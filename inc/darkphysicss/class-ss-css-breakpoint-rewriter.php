<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SS_CSS_Breakpoint_Rewriter {

	const SOURCE_MOBILE  = 500;
	const SOURCE_TABLET  = 768;
	const SOURCE_DESKTOP = 1024;
	const SOURCE_XL      = 1250;

	public static function get_cache_dir(): string {
		$uploads = wp_upload_dir();
		return trailingslashit( $uploads['basedir'] ) . 'shapeshifter/breakpoint-cache/';
	}

	public static function get_cache_base_url(): string {
		$uploads = wp_upload_dir();
		return trailingslashit( $uploads['baseurl'] ) . 'shapeshifter/breakpoint-cache/';
	}

	public static function get_rewritten_url( string $source_path ): string {
		if ( ! is_file( $source_path ) ) {
			return '';
		}

		$breakpoints = self::get_breakpoints();
		$hash        = self::compute_hash( $source_path, $breakpoints );
		$slug        = pathinfo( $source_path, PATHINFO_FILENAME );
		$cache_dir   = self::get_cache_dir();
		$cache_file  = $cache_dir . $slug . '.' . $hash . '.css';

		if ( ! is_file( $cache_file ) ) {
			if ( ! is_dir( $cache_dir ) ) {
				wp_mkdir_p( $cache_dir );
			}

			$source = (string) file_get_contents( $source_path );
			if ( $source === '' ) {
				return '';
			}

			$rewritten = self::rewrite( $source, $breakpoints );
			if ( file_put_contents( $cache_file, $rewritten ) === false ) {
				return '';
			}

			self::prune_stale( $cache_dir, $slug, $hash );
		}

		$url = self::get_cache_base_url() . $slug . '.' . $hash . '.css';
		return set_url_scheme( $url );
	}

	public static function get_rewritten_path( string $source_path ): string {
		if ( self::get_rewritten_url( $source_path ) === '' ) {
			return '';
		}
		$breakpoints = self::get_breakpoints();
		$hash        = self::compute_hash( $source_path, $breakpoints );
		$slug        = pathinfo( $source_path, PATHINFO_FILENAME );
		return self::get_cache_dir() . $slug . '.' . $hash . '.css';
	}

	public static function clear_cache(): int {
		$dir = self::get_cache_dir();
		if ( ! is_dir( $dir ) ) {
			return 0;
		}
		$count = 0;
		foreach ( glob( $dir . '*.css' ) ?: [] as $file ) {
			if ( @unlink( $file ) ) {
				$count++;
			}
		}
		return $count;
	}

	public static function rewrite( string $css, array $breakpoints ): string {
		return (string) preg_replace_callback(
			'/@media[^{]*\{/i',
			static function ( $matches ) use ( $breakpoints ) {
				return self::rewrite_media_clause( $matches[0], $breakpoints );
			},
			$css
		);
	}

	private static function rewrite_media_clause( string $clause, array $breakpoints ): string {
		$sources = [
			self::SOURCE_MOBILE  => $breakpoints['mobile'],
			self::SOURCE_TABLET  => $breakpoints['tablet'],
			self::SOURCE_DESKTOP => $breakpoints['desktop'],
			self::SOURCE_XL      => $breakpoints['xl'],
		];

		return (string) preg_replace_callback(
			'/((?:min|max)-width\s*:\s*)(\d+)(px)/i',
			static function ( $m ) use ( $sources ) {
				$value  = (int) $m[2];
				$is_min = stripos( $m[1], 'min' ) !== false;

				if ( $value === 0 ) {
					return $m[0];
				}

				$new = null;
				if ( isset( $sources[ $value ] ) ) {
					$new = $sources[ $value ];
				} elseif ( $is_min && isset( $sources[ $value - 1 ] ) ) {
					$new = $sources[ $value - 1 ] + 1;
				}

				if ( $new === null ) {
					return $m[0];
				}

				return $m[1] . $new . $m[3];
			},
			$clause
		);
	}

	private static function get_breakpoints(): array {
		$mobile  = self::extract_pixels( get_field( 'dp_mobile_portrait', 'options' ),  self::SOURCE_MOBILE );
		$tablet  = self::extract_pixels( get_field( 'dp-tablet-portrait', 'options' ),  self::SOURCE_TABLET );
		$desktop = self::extract_pixels( get_field( 'dp-desktop',         'options' ),  self::SOURCE_DESKTOP );
		$xl      = self::extract_pixels( get_field( 'dp-desktopxl',       'options' ),  self::SOURCE_XL );

		return [
			'mobile'  => $mobile,
			'tablet'  => $tablet,
			'desktop' => $desktop,
			'xl'      => $xl,
		];
	}

	private static function extract_pixels( $value, int $fallback ): int {
		if ( ! is_string( $value ) ) {
			return $fallback;
		}
		if ( ! preg_match( '/(\d+)/', $value, $m ) ) {
			return $fallback;
		}
		$n = (int) $m[1];
		return $n > 0 ? $n : $fallback;
	}

	private static function compute_hash( string $source_path, array $breakpoints ): string {
		$material = [
			'mtime'       => (int) filemtime( $source_path ),
			'size'        => (int) filesize( $source_path ),
			'breakpoints' => $breakpoints,
			'version'     => SS_VERSION,
		];
		return substr( md5( wp_json_encode( $material ) ), 0, 12 );
	}

	private static function prune_stale( string $dir, string $slug, string $current_hash ): void {
		foreach ( glob( $dir . $slug . '.*.css' ) ?: [] as $file ) {
			if ( basename( $file ) !== $slug . '.' . $current_hash . '.css' ) {
				@unlink( $file );
			}
		}
	}
}
