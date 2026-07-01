<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', 'ss_output_dp_font_code', 5 );

function ss_output_dp_font_code(): void {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$font_code = get_field( 'dp-font-code', 'options' );
	if ( ! is_string( $font_code ) || trim( $font_code ) === '' ) {
		return;
	}

	echo "\n<!-- ShapeShifter font code -->\n";
	echo $font_code;
	echo "\n<!-- /ShapeShifter font code -->\n";
}
