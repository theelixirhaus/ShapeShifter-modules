<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'ss_register_module_field_groups' );

function ss_register_module_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$schemas = [
		SS_INC . 'acf/schemas/shapeshifter-module-field-schema.json',
		SS_INC . 'acf/schemas/module-lightbox-field-schema.json',
	];

	$pro_active = ss_pro_active();

	foreach ( $schemas as $path ) {
		if ( ! file_exists( $path ) ) {
			continue;
		}

		$json   = file_get_contents( $path );
		$groups = json_decode( $json, true );

		if ( ! is_array( $groups ) ) {
			continue;
		}

		if ( isset( $groups['key'] ) ) {
			$groups = [ $groups ];
		}

		foreach ( $groups as $group ) {
			if ( ! is_array( $group ) || ! isset( $group['key'] ) ) {
				continue;
			}
			if ( ! $pro_active && ss_is_pro_module_group_title( (string) ( $group['title'] ?? '' ) ) ) {
				continue;
			}
			acf_add_local_field_group( $group );
		}
	}
}

function ss_is_pro_module_group_title( string $title ): bool {
	if ( ! preg_match( '/\bM(\d{1,2})\b/', $title, $matches ) ) {
		return false;
	}
	$num = (int) $matches[1];
	return in_array( $num, [ 2, 3, 6, 7, 8, 9, 10 ], true );
}
