<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SS_Pro_Notice {

	const DISMISSED_VERSION_OPTION = 'ss_pro_notice_dismissed_version';
	const NONCE_ACTION             = 'ss_dismiss_pro_notice';

	public static function init(): void {
		add_action( 'admin_notices',                [ __CLASS__, 'maybe_render_notice' ] );
		add_action( 'wp_ajax_ss_dismiss_pro_notice',[ __CLASS__, 'ajax_dismiss_notice' ] );
	}

	public static function maybe_render_notice(): void {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		if ( self::is_dismissed_for_current_version() ) {
			return;
		}
		if ( class_exists( 'SS_License' ) && SS_License::is_active() ) {
			return;
		}
		if ( ! self::is_relevant_screen() ) {
			return;
		}

		$settings_url = admin_url( 'options-general.php?page=shapeshifter-modules' );
		$nonce        = wp_create_nonce( self::NONCE_ACTION );

		?>
		<div class="notice notice-info is-dismissible" data-ss-pro-notice="1" data-nonce="<?php echo esc_attr( $nonce ); ?>">
			<p>
				<strong><?php esc_html_e( 'ShapeShifter Lite is active.', 'shapeshifter' ); ?></strong>
				<?php esc_html_e( 'Three of ten modules are available (M1, M4, M5). Activate a Pro license to unlock the full suite of content modules.', 'shapeshifter' ); ?>
				&nbsp;
				<a href="<?php echo esc_url( $settings_url ); ?>" class="button button-primary" style="vertical-align: baseline;">
					<?php esc_html_e( 'Activate License', 'shapeshifter' ); ?>
				</a>
			</p>
		</div>
		<script>
			(function(){
				var n = document.querySelector('[data-ss-pro-notice="1"]');
				if (!n) return;
				n.addEventListener('click', function(e){
					if (!e.target.classList.contains('notice-dismiss')) return;
					var f = new FormData();
					f.append('action', 'ss_dismiss_pro_notice');
					f.append('_wpnonce', n.dataset.nonce);
					fetch(ajaxurl, { method: 'POST', credentials: 'same-origin', body: f });
				});
			})();
		</script>
		<?php
	}

	public static function ajax_dismiss_notice(): void {
		check_ajax_referer( self::NONCE_ACTION );
		if ( current_user_can( 'edit_posts' ) ) {
			update_option( self::DISMISSED_VERSION_OPTION, self::current_version(), false );
		}
		wp_send_json_success();
	}

	private static function is_dismissed_for_current_version(): bool {
		$dismissed_at = (string) get_option( self::DISMISSED_VERSION_OPTION, '' );
		return $dismissed_at !== '' && $dismissed_at === self::current_version();
	}

	private static function current_version(): string {
		return defined( 'SS_PLUGIN_VERSION' ) ? (string) SS_PLUGIN_VERSION : '0.0.0';
	}

	private static function is_relevant_screen(): bool {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}
		$screen = get_current_screen();
		if ( ! $screen ) {
			return false;
		}

		$relevant_ids = [
			'settings_page_shapeshifter-modules',
			'post',
			'page',
		];

		if ( in_array( $screen->id, $relevant_ids, true ) ) {
			return true;
		}

		if ( in_array( $screen->base, [ 'post' ], true ) ) {
			return true;
		}

		return false;
	}
}
