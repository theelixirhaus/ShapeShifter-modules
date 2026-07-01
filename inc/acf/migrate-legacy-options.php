<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'ss_migrate_legacy_block_editor_options', 20 );

function ss_migrate_legacy_block_editor_options(): void {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}
	if ( get_option( 'ss_settings_migrated_to_acf' ) ) {
		return;
	}

	$ss_legacy = get_option( 'ss_settings' );
	$dbe_legacy = get_option( 'deluxe_block_editor_options' );

	$source = [];
	if ( is_array( $ss_legacy ) ) {
		$source = [
			'css_url'   => $ss_legacy['editor_css_url']   ?? '',
			'bg_color'  => $ss_legacy['editor_bg_color']  ?? '',
			'extra_css' => $ss_legacy['editor_extra_css'] ?? '',
			'draggable' => ! empty( $ss_legacy['draggable_panel'] ) ? 1 : 0,
		];
	} elseif ( is_array( $dbe_legacy ) ) {
		$source = [
			'css_url'   => $dbe_legacy['url']   ?? '',
			'bg_color'  => $dbe_legacy['color'] ?? '',
			'extra_css' => $dbe_legacy['css']   ?? '',
			'draggable' => ( $dbe_legacy['draggable'] ?? '' ) === 'on' ? 1 : 0,
		];
	}

	if ( $source ) {
		update_field( 'ss_editor_css_url',         $source['css_url'],   'option' );
		update_field( 'ss_editor_bg_color',        $source['bg_color'],  'option' );
		update_field( 'ss_editor_extra_css',       $source['extra_css'], 'option' );
		update_field( 'ss_editor_draggable_panel', $source['draggable'], 'option' );
	}

	update_option( 'ss_settings_migrated_to_acf', 1, false );
}
