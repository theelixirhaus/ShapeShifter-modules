<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SS_CSS_Repather {

	const PREFIX        = ' .is-root-container.wp-block-post-content ';
	const CACHE_TTL     = DAY_IN_SECONDS;
	const FETCH_TIMEOUT = 10;

	public static function get_cache_dir(): string {
		$uploads = wp_upload_dir();
		return trailingslashit( $uploads['basedir'] ) . 'shapeshifter/css-cache/';
	}

	public static function get_cache_file_path( string $source_url ): string {
		$dir = self::get_cache_dir();
		if ( ! is_dir( $dir ) ) {
			wp_mkdir_p( $dir );
		}
		return $dir . md5( $source_url ) . '.css';
	}

	public static function get_cache_file_url( string $source_url ): string {
		$uploads = wp_upload_dir();
		$url     = trailingslashit( $uploads['baseurl'] ) . 'shapeshifter/css-cache/' . md5( $source_url ) . '.css';
		return set_url_scheme( $url, 'https' );
	}

	public static function get_repathed_css( string $source_url ): string {
		$source_url = trim( $source_url );
		if ( $source_url === '' ) {
			return '';
		}

		$bypass     = defined( 'SS_BYPASS_REPATH_CACHE' ) && SS_BYPASS_REPATH_CACHE;
		$cache_file = self::get_cache_file_path( $source_url );

		if ( ! $bypass && is_file( $cache_file ) && ( time() - (int) filemtime( $cache_file ) ) < self::CACHE_TTL ) {
			return (string) file_get_contents( $cache_file );
		}

		$fetch_url = $source_url;
		if ( $bypass ) {
			$fetch_url .= ( str_contains( $source_url, '?' ) ? '&' : '?' ) . '_ss_cb=' . microtime( true );
		}

		$css = self::fetch( $fetch_url );
		if ( $css === '' ) {
			return '';
		}

		$prepend = '';
		foreach ( [ 'dpcss.min.css', 'modules.css', 'mod-lightboxes.css' ] as $local ) {
			$path = SS_DIR . 'assets/css/' . $local;
			if ( is_file( $path ) ) {
				$prepend .= file_get_contents( $path ) . "\n";
			}
		}
		if ( $prepend !== '' ) {
			$css = $prepend . $css;
		}

		if ( function_exists( 'get_field' ) ) {
			$styleoutput = '';
			include SS_INC . 'darkphysicss/init-compiled-styles-settings.php';
			if ( $styleoutput !== '' ) {
				$css = $styleoutput . "\n" . $css;
			}
		}

		$repathed = self::repath( $css );
		file_put_contents( $cache_file, $repathed );

		return $repathed;
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

	private static function fetch( string $url ): string {
		$args = [ 'timeout' => self::FETCH_TIMEOUT ];
		if ( ! self::should_verify_ssl( $url ) ) {
			$args['sslverify'] = false;
		}

		$resp = wp_remote_get( $url, $args );
		if ( is_wp_error( $resp ) ) {
			return '';
		}
		if ( (int) wp_remote_retrieve_response_code( $resp ) !== 200 ) {
			return '';
		}
		return (string) wp_remote_retrieve_body( $resp );
	}

	private static function should_verify_ssl( string $url ): bool {
		$host = parse_url( $url, PHP_URL_HOST );
		if ( ! is_string( $host ) || $host === '' ) {
			return true;
		}
		$host = strtolower( $host );

		$home_host = parse_url( home_url(), PHP_URL_HOST );
		if ( is_string( $home_host ) && strcasecmp( $host, $home_host ) === 0 ) {
			return false;
		}

		if ( $host === 'localhost' || str_ends_with( $host, '.local' ) || str_ends_with( $host, '.test' ) || str_ends_with( $host, '.localhost' ) ) {
			return false;
		}

		return true;
	}

	public static function repath( string $css ): string {
		$css = self::strip_comments( $css );

		$preserved = [];
		$css       = self::extract_preserved_blocks( $css, $preserved );

		$out    = '';
		$len    = strlen( $css );
		$i      = 0;
		$buffer = '';

		while ( $i < $len ) {
			$ch = $css[ $i ];

			if ( $ch === '{' ) {
				$selector_chunk = trim( $buffer );
				$buffer         = '';
				$depth          = 1;
				$body           = '';
				$i++;

				while ( $i < $len && $depth > 0 ) {
					$c = $css[ $i ];
					if ( $c === '{' ) {
						$depth++;
					} elseif ( $c === '}' ) {
						$depth--;
						if ( $depth === 0 ) {
							$i++;
							break;
						}
					}
					$body .= $c;
					$i++;
				}

				if ( $selector_chunk !== '' ) {
					if ( str_starts_with( $selector_chunk, '@media' ) || str_starts_with( $selector_chunk, '@supports' ) ) {
						$out .= $selector_chunk . '{' . self::repath( $body ) . '}';
					} else {
						$out .= self::prefix_selector_list( $selector_chunk ) . '{' . $body . '}';
					}
				}
				continue;
			}

			$buffer .= $ch;
			$i++;
		}

		foreach ( $preserved as $token => $block ) {
			$out = str_replace( $token, $block, $out );
		}

		return $out;
	}

	private static function strip_comments( string $css ): string {
		return preg_replace( '#/\*.*?\*/#s', '', $css ) ?? $css;
	}

	private static function extract_preserved_blocks( string $css, array &$preserved ): string {
		$css = preg_replace_callback(
			'/@import\s+[^;]+;/i',
			static function ( $m ) use ( &$preserved ) {
				$token              = '/*SS_PRESERVED_' . count( $preserved ) . '*/';
				$preserved[ $token ] = $m[0];
				return $token;
			},
			$css
		);

		$patterns = [
			'/@(-webkit-)?keyframes\s+[^\{]+\{(?:[^{}]+|\{[^{}]*\})*\}/i',
			'/@font-face\s*\{[^}]*\}/i',
			'/:root\s*\{[^}]*\}/i',
		];

		foreach ( $patterns as $pattern ) {
			$css = preg_replace_callback(
				$pattern,
				static function ( $m ) use ( &$preserved ) {
					$token              = '/*SS_PRESERVED_' . count( $preserved ) . '*/';
					$preserved[ $token ] = $m[0];
					return $token;
				},
				$css
			);
		}

		return $css;
	}

	private static function prefix_selector_list( string $selector_chunk ): string {
		$parts  = explode( ',', $selector_chunk );
		$out    = [];
		$prefix = self::PREFIX;

		foreach ( $parts as $sel ) {
			$sel = trim( $sel );
			if ( $sel === '' ) {
				continue;
			}
			if ( str_starts_with( $sel, '@' ) || str_starts_with( $sel, '/*SS_PRESERVED_' ) ) {
				$out[] = $sel;
				continue;
			}

			if ( str_contains( $sel, rtrim( $prefix ) ) ) {
				$out[] = $sel;
				continue;
			}

			$compound   = '(?:\.[\w-]+|#[\w-]+|\[[^\]]+\]|:[\w-]+(?:\([^)]*\))?)*';
			$combinator = '(?:\s*>\s*|\s+)';
			$intro_pat  = "/^(html{$compound}(?:{$combinator}body{$compound})?|body{$compound})(?=[\\s,>+~]|$)/i";

			if ( preg_match( $intro_pat, $sel, $m ) ) {
				$intro = $m[1];
				$rest  = substr( $sel, strlen( $intro ) );
				$out[] = $intro . ' ' . rtrim( $prefix ) . $rest;
				continue;
			}

			$out[] = $prefix . $sel;
		}

		return implode( ',', $out );
	}
}
