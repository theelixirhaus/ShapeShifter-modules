<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'ss_enqueue_darkphysicss_compiled_styles', 20 );

function ss_enqueue_darkphysicss_compiled_styles(): void {
	if ( is_admin() ) {
		return;
	}
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$styleoutput = '';
	include SS_INC . 'darkphysicss/init-compiled-styles-settings.php';

	if ( empty( $styleoutput ) ) {
		return;
	}

	if ( ! wp_style_is( 'ss-dpcss', 'registered' ) ) {
		wp_register_style( 'ss-dpcss-vars', false, [], SS_VERSION );
		wp_enqueue_style( 'ss-dpcss-vars' );
	}

	wp_add_inline_style( wp_style_is( 'ss-dpcss', 'registered' ) ? 'ss-dpcss' : 'ss-dpcss-vars', $styleoutput );
}
