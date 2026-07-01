<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'ss_enqueue_rewritten_dpcss_modules', 9 );

function ss_enqueue_rewritten_dpcss_modules(): void {
	$css_dir = SS_DIR . 'assets/css/';
	$css_url = SS_ASSETS_URL . 'css/';
	$v       = SS_VERSION;

	$sources = [
		'ss-dpcss'   => [
			'file'    => $css_dir . 'dpcss.min.css',
			'fallback'=> $css_url . 'dpcss.min.css',
			'deps'    => [],
		],
		'ss-modules' => [
			'file'    => $css_dir . 'modules.css',
			'fallback'=> $css_url . 'modules.css',
			'deps'    => [ 'ss-dpcss' ],
		],
	];

	$use_external = ss_use_external_assets();

	foreach ( $sources as $handle => $cfg ) {
		$rewritten_url  = '';
		$rewritten_path = '';

		if ( function_exists( 'get_field' ) ) {
			$rewritten_url  = SS_CSS_Breakpoint_Rewriter::get_rewritten_url( $cfg['file'] );
			$rewritten_path = SS_CSS_Breakpoint_Rewriter::get_rewritten_path( $cfg['file'] );
		}

		if ( $use_external ) {
			$url = $rewritten_url !== '' ? $rewritten_url : $cfg['fallback'];
			wp_register_style( $handle, $url, $cfg['deps'], $v );
			wp_enqueue_style( $handle );
			continue;
		}

		$source_path = $rewritten_path !== '' && is_file( $rewritten_path )
			? $rewritten_path
			: $cfg['file'];

		$css = ss_read_asset_contents( $source_path );
		if ( $css !== '' && defined( 'SS_MINIFY' ) && SS_MINIFY ) {
			$css = ss_minify_css( $css );
		}

		wp_register_style( $handle, false, $cfg['deps'], $v );
		wp_enqueue_style( $handle );
		if ( $css !== '' ) {
			wp_add_inline_style( $handle, $css );
		}
	}
}
