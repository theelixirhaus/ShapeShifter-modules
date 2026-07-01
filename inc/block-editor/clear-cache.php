<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_ss_clear_repath_cache', 'ss_handle_clear_repath_cache' );
add_action( 'admin_notices',                    'ss_show_repath_cache_notice' );

function ss_handle_clear_repath_cache(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'shapeshifter' ) );
	}
	check_admin_referer( 'ss_clear_repath_cache' );

	$count    = SS_CSS_Repather::clear_cache();
	$redirect = wp_get_referer() ?: admin_url();

	wp_safe_redirect( add_query_arg( 'ss_cache_cleared', (string) $count, $redirect ) );
	exit;
}

function ss_show_repath_cache_notice(): void {
	if ( ! isset( $_GET['ss_cache_cleared'] ) ) {
		return;
	}
	$count = (int) $_GET['ss_cache_cleared'];
	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		esc_html( sprintf(
			/* translators: %d: number of cache files removed */
			_n( 'ShapeShifter stylesheet cache cleared (%d file).', 'ShapeShifter stylesheet cache cleared (%d files).', $count, 'shapeshifter' ),
			$count
		) )
	);
}
