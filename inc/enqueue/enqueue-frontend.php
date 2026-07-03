<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'ss_enqueue_frontend_assets', 10 );

function ss_enqueue_frontend_assets(): void {
	// ss-dpcss and ss-modules are registered earlier (priority 9) by enqueue-rewritten-css.php
	// so their URLs reflect the breakpoint-rewritten cache files.
	ss_register_inline_style( 'ss-owl-carousel',   'css/vendor/owl-carousel.css' );
	ss_register_inline_style( 'ss-mod-lightboxes', 'css/mod-lightboxes.css',     [ 'ss-modules' ] );

	wp_enqueue_style( 'ss-owl-carousel' );
	wp_enqueue_style( 'ss-mod-lightboxes' );

	ss_register_inline_script( 'ss-owl-carousel', 'js/vendor/owl.carousel.js', [ 'jquery' ] );
	ss_register_inline_script( 'ss-masonry',      'js/vendor/masonry.js' );
	ss_register_inline_script( 'ss-parallax',     'js/vendor/parallax.js' );
	ss_register_inline_script( 'ss-vimeoplayer',  'js/vendor/vimeoplayer.js' );

	ss_register_inline_script( 'ss-mod-video',     'js/mod-video.js' );
	ss_register_inline_script( 'ss-mod-m1',        'js/mod-m1.js',        [ 'jquery' ] );
	ss_register_inline_script( 'ss-mod-m2',        'js/mod-m2.js',        [ 'jquery', 'ss-owl-carousel', 'ss-masonry' ] );
	ss_register_inline_script( 'ss-mod-m3',        'js/mod-m3.js',        [ 'jquery' ] );
	ss_register_inline_script( 'ss-mod-m5',        'js/mod-m5.js',        [ 'jquery' ] );
	ss_register_inline_script( 'ss-mod-m6',        'js/mod-m6.js',        [ 'jquery' ] );

	wp_enqueue_script( 'ss-parallax' );
	wp_enqueue_script( 'ss-mod-video' );
	wp_enqueue_script( 'ss-mod-m1' );
	wp_enqueue_script( 'ss-mod-m1-bgvid' );
	wp_enqueue_script( 'ss-mod-m2' );
	wp_enqueue_script( 'ss-mod-m3' );
	wp_enqueue_script( 'ss-mod-m5' );
	wp_enqueue_script( 'ss-mod-m6' );
}
