<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'ss-module', 'ss_module_shortcode' );

function ss_module_shortcode( $atts, $content = '' ) {
	if ( ! isset( $atts['id'] ) ) {
		return '';
	}

	$id = $atts['id'];

	if ( is_numeric( $id ) ) {
		$tid = (int) $id;
	} else {
		$post  = get_page_by_path( $id, OBJECT, 'ss_module' );
		$mpath = $id;
		$tid   = $post ? $post->ID : 0;
	}

	if ( $tid && is_numeric( $tid ) ) {
		return do_shortcode( ss_get_content( $tid ) );
	}

	return esc_html( $mpath ?? '' ) . ' not module';
}
