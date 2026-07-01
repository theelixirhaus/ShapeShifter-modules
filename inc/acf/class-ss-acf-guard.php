<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SS_ACF_Guard {

	const NOTICE_DISMISS_OPTION = 'ss_acf_notice_dismissed';

	public static function init(): void {
		add_action( 'admin_notices',          [ __CLASS__, 'maybe_render_notice' ] );
		add_action( 'wp_ajax_ss_dismiss_acf', [ __CLASS__, 'ajax_dismiss_notice' ] );
	}

	public static function is_active(): bool {
		return function_exists( 'acf_add_local_field_group' );
	}

	public static function maybe_render_notice(): void {
		if ( self::is_active() ) {
			return;
		}
		if ( get_option( self::NOTICE_DISMISS_OPTION ) ) {
			return;
		}
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$nonce = wp_create_nonce( 'ss_dismiss_acf' );
		echo '<div class="notice notice-warning is-dismissible" data-ss-acf-notice="1" data-nonce="' . esc_attr( $nonce ) . '">';
		echo '<p>' . esc_html__( 'ShapeShifter requires Advanced Custom Fields to manage module fields.', 'shapeshifter' ) . '</p>';
		echo '</div>';
		?>
		<script>
			(function(){
				var n = document.querySelector('[data-ss-acf-notice="1"]');
				if (!n) return;
				n.addEventListener('click', function(e){
					if (!e.target.classList.contains('notice-dismiss')) return;
					var f = new FormData();
					f.append('action', 'ss_dismiss_acf');
					f.append('_wpnonce', n.dataset.nonce);
					fetch(ajaxurl, { method: 'POST', credentials: 'same-origin', body: f });
				});
			})();
		</script>
		<?php
	}

	public static function ajax_dismiss_notice(): void {
		check_ajax_referer( 'ss_dismiss_acf' );
		if ( current_user_can( 'activate_plugins' ) ) {
			update_option( self::NOTICE_DISMISS_OPTION, 1, false );
		}
		wp_send_json_success();
	}
}
