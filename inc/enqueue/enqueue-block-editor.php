<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_editor_assets', 'ss_enqueue_block_editor_assets', 20 );

function ss_enqueue_block_editor_assets(): void {
	ss_register_inline_style( 'ss-admin-block-editor', 'css/admin-block-editor.css' );
	wp_enqueue_style( 'ss-admin-block-editor' );

	ss_register_inline_script( 'ss-admin-draggable-pane', 'js/admin-draggable-block-pane.js', [ 'jquery' ] );
	wp_enqueue_script( 'ss-admin-draggable-pane' );
}
