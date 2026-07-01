<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_editor_assets', 'ss_inject_repathed_editor_css', 50 );

function ss_inject_repathed_editor_css(): void {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$raw = trim( (string) get_field( 'ss_editor_css_url', 'option' ) );
	if ( $raw === '' ) {
		return;
	}

	$source_url = ( str_starts_with( $raw, '/' ) && ! str_starts_with( $raw, '//' ) )
		? home_url( $raw )
		: $raw;

	$repathed = SS_CSS_Repather::get_repathed_css( $source_url );
	if ( $repathed === '' ) {
		return;
	}

	$cache_file = SS_CSS_Repather::get_cache_file_path( $source_url );
	if ( ! is_file( $cache_file ) ) {
		return;
	}

	wp_enqueue_style(
		'ss-block-editor-repathed',
		SS_CSS_Repather::get_cache_file_url( $source_url ),
		[],
		(string) filemtime( $cache_file )
	);
}
