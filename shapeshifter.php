<?php
/**
 * Plugin Name: ShapeShifter Modules
 * Description: Consolidated ShapeShifter module library, DarkPhysiCSS framework settings, and Deluxe Block Editor enhancements.
 * Version:     1.0.0
 * Author:      The Elixir Haus
 * Text Domain: shapeshifter
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SS_PLUGIN_VERSION', '1.0.0' );

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

require_once SS_INC . 'class-shapeshifter.php';

add_action( 'plugins_loaded', [ 'ShapeShifter', 'boot' ] );
