<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'ss_register_settings_options_page' );

function ss_register_settings_options_page(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		[
			'page_title'  => __( 'ShapeShifter Modules', 'shapeshifter' ),
			'menu_title'  => __( 'ShapeShifter Modules', 'shapeshifter' ),
			'menu_slug'   => 'shapeshifter-modules',
			'parent_slug' => 'options-general.php',
			'capability'  => 'manage_options',
			'redirect'    => false,
		]
	);
}
