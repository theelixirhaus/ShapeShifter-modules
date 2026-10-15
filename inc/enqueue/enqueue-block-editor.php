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





add_action( 'enqueue_block_assets', 'my_custom_iframe_inline_styles' );

function my_custom_iframe_inline_styles() {
    // Target your inline styles specifically to the block editor
    if ( is_admin() ) {
        $custom_css = "
            .is-root-container :where(.wp-block){
			  max-width: none;
			}

			:root :where(.editor-styles-wrapper)::after {
			    height: 100px !important;
			}
        ";

        // 'wp-block-library' is a core handle loaded both in frontend and inside the iframe
        wp_add_inline_style( 'wp-block-library', $custom_css );
    }
}