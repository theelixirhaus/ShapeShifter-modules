<?php
/**
 * Plugin Name: ShapeShifter Modules
 * Description: Consolidated ShapeShifter module library, DarkPhysiCSS framework settings, and Deluxe Block Editor enhancements.
 * Version:     1.0.21
 * Author:      The Elixir Haus
 * Text Domain: shapeshifter
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SS_PLUGIN_VERSION', '1.0.21' );
define( 'SS_BASENAME',       plugin_basename( __FILE__ ) );

$ss_ver = SS_PLUGIN_VERSION;
if(isset($_GET['dev'])){
	$ss_ver = rand(0,10000000);
}
define( 'SS_VERSION',     $ss_ver );
define( 'SS_FILE',        __FILE__ );
define( 'SS_DIR',         plugin_dir_path( __FILE__ ) );
define( 'SS_URL',         plugin_dir_url( __FILE__ ) );
define( 'SS_INC',         SS_DIR . 'inc/' );
define( 'SS_ASSETS_URL',  SS_URL . 'assets/' );

// Toggle: minify inlined CSS/JS. Has no effect on externally-linked assets.
define( 'SS_MINIFY',      true );

defined( 'SS_LICENSE_API_URL' ) || define( 'SS_LICENSE_API_URL', 'https://www.shapeshifter-modules.com' );

require_once SS_INC . 'class-shapeshifter.php';

add_action( 'plugins_loaded', [ 'ShapeShifter', 'boot' ] );



add_filter( 'pre_set_site_transient_update_plugins', 'ssm_check_for_update' );

function ssm_check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) return $transient;

    $response = wp_remote_get( 'https://www.shapeshifter-modules.com/shapeshifter-plugin-version.json' );
    if ( is_wp_error( $response ) ) return $transient;

    $data = json_decode( wp_remote_retrieve_body( $response ) );

    if ( ! $data || ! isset( $data->version ) ) return $transient;

    if ( version_compare( SS_PLUGIN_VERSION, $data->version, '<' ) ) {
        $transient->response[ SS_BASENAME ] = (object) [
            'slug'        => 'shapeshifter-modules',
            'new_version' => $data->version,
            'url'         => 'https://www.shapeshifter-modules.com/',
            'package'     => $data->download_url,
        ];
    }

    return $transient;
}

add_action( 'admin_init', function() {
    delete_site_transient( 'update_plugins' );
});


//Prevent Meta Boxes panel in page editor from being collapsed
add_action( 'enqueue_block_editor_assets', function () {
 
    // Optional: only do this on the Page editor, not Posts too.
    // Remove this block if you want it applied everywhere.
    $screen = get_current_screen();
    if ( $screen && 'page' !== $screen->post_type ) {
        return;
    }
 
    $script = <<<JS
    wp.domReady( function () {
        if ( wp.data && wp.data.dispatch( 'core/preferences' ) ) {
            wp.data.dispatch( 'core/preferences' ).set(
                'core/edit-post',
                'metaBoxesMainIsOpen',
                true
            );
        }
    } );
    JS;
 
    wp_add_inline_script( 'wp-edit-post', $script );
}, 20 );