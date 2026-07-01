<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SS_License {

	const OPTION_KEY      = 'options_ss_license_key';
	const STATUS_OPTION   = 'ss_license_status';
	const ERROR_TRANSIENT = 'ss_license_status_err';
	const TRANSIENT_TTL_ERR = 5 * MINUTE_IN_SECONDS;

	public static function init(): void {
		add_action( 'acf/save_post', [ __CLASS__, 'maybe_revalidate' ], 20 );
	}

	public static function is_active(): bool {
		return ( self::status()['valid'] ?? false ) === true;
	}

	public static function status(): array {
		// Valid state persists indefinitely — never re-check unless the key changes.
		$saved = get_option( self::STATUS_OPTION, false );
		if ( is_array( $saved ) && ( $saved['valid'] ?? false ) === true ) {
			return $saved;
		}

		// Short-lived error cache prevents hammering the proxy on bad keys.
		$err = get_transient( self::ERROR_TRANSIENT );
		if ( is_array( $err ) ) {
			return $err;
		}

		// No cached state — auto-validate, but only on admin page loads.
		// Skipped on frontend / AJAX / cron to avoid HTTP calls on every visitor request.
		if ( is_admin() && ! wp_doing_ajax() && ! wp_doing_cron() ) {
			return self::validate();
		}

		return [ 'valid' => false, 'reason' => 'unchecked' ];
	}

	public static function get_license_key(): string {
		return (string) get_option( self::OPTION_KEY, '' );
	}

	public static function maybe_revalidate( $post_id ): void {
		if ( $post_id !== 'options' ) {
			return;
		}
		// Clear all cached state so validate() runs fresh against the (possibly changed) key.
		delete_option( self::STATUS_OPTION );
		delete_transient( self::ERROR_TRANSIENT );
		self::validate();
	}

	public static function validate(): array {
		$key = self::get_license_key();

		if ( $key === '' ) {
			return [ 'valid' => false, 'reason' => 'no_key' ];
		}

		if ( ! defined( 'SS_LICENSE_API_URL' ) ) {
			return self::cache_error( [ 'valid' => false, 'reason' => 'config_missing' ] );
		}

		$base = rtrim( (string) SS_LICENSE_API_URL, '/' );
		$url  = $base . '/wp-json/shapeshifter-licensing/v1/validate';

		$response = wp_remote_post( $url, [
			'headers'   => [ 'Content-Type' => 'application/json' ],
			'body'      => wp_json_encode( [ 'license_key' => $key, 'site_url' => home_url() ] ),
			'sslverify' => ! self::is_local_host( $base ),
			'timeout'   => 15,
		] );

		if ( is_wp_error( $response ) ) {
			return self::cache_error( [
				'valid'   => false,
				'reason'  => 'transport_error',
				'message' => $response->get_error_message(),
			] );
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! empty( $body['valid'] ) ) {
			return self::cache_valid( [
				'valid'      => true,
				'checked_at' => time(),
				'data'       => $body,
			] );
		}

		return self::cache_error( [
			'valid'   => false,
			'reason'  => 'rejected',
			'message' => $body['message'] ?? __( 'License rejected.', 'shapeshifter' ),
		] );
	}

	private static function cache_valid( array $status ): array {
		update_option( self::STATUS_OPTION, $status, false );
		delete_transient( self::ERROR_TRANSIENT );
		return $status;
	}

	private static function cache_error( array $status ): array {
		set_transient( self::ERROR_TRANSIENT, $status, self::TRANSIENT_TTL_ERR );
		return $status;
	}

	private static function is_local_host( string $url ): bool {
		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! $host ) {
			return false;
		}
		return $host === 'localhost'
			|| str_ends_with( $host, '.local' )
			|| str_ends_with( $host, '.test' );
	}
}
