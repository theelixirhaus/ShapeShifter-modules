<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_head',   'ss_admin_head_styles' );
add_action( 'admin_footer', 'ss_admin_footer_scripts' );

function ss_admin_head_styles(): void {
	$color = function_exists( 'get_field' ) ? (string) get_field( 'ss_editor_bg_color',  'option' ) : '';
	$extra = function_exists( 'get_field' ) ? (string) get_field( 'ss_editor_extra_css', 'option' ) : '';

	$bg_block = '';
	if ( $color !== '' ) {
		$bg_block = 'html body.post-type-page .is-root-container.is-desktop-preview{ background: ' . esc_attr( $color ) . '; }';
	}

	?>
	<style id="ss-admin-head-styles">
		html .wp-admin #post-body [class*="dp-grid"] { clear: none !important; }
		@media (min-width: 1023px) { .dp-grid\:50pc\:l { display: block; float: left; width: 50%; } }
		@media (min-width: 767px)  { .dp-grid\:50pc\:m { display: block; float: left; width: 50%; } }
		<?php echo $bg_block; ?>
		<?php echo $extra; ?>
	</style>
	<?php
}

function ss_admin_footer_scripts(): void {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
	if ( ! get_field( 'ss_editor_draggable_panel', 'option' ) ) {
		return;
	}
	?>
	<script>jQuery && jQuery('html').addClass('draggable-sidebar');</script>
	<?php
}
