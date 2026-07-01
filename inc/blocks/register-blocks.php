<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init',                'ss_register_block_types' );
add_filter( 'allowed_block_types_all', 'ss_filter_pro_blocks_from_inserter', 10, 2 );

function ss_pro_block_slugs(): array {
	return [ 'm2', 'm3', 'm6', 'm7', 'm8', 'm9', 'm10' ];
}

function ss_pro_block_names(): array {
	return array_map( fn( $slug ) => 'acf/module-' . $slug, ss_pro_block_slugs() );
}

function ss_register_block_types(): void {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$templates = SS_INC . 'blocks/templates/';
	$stub      = $templates . 'mod_pro_required.php';

	$blocks = [
		[ 'm1',  'M1: Headline, General Columned Content', 'For Headline, Copy, Form, and Button', [ 'm1', 'paragraph' ] ],
		[ 'm2',  'M2: Slideshow or Grid',                  'For Slideshow or Grid',                [ 'm2', 'M1: slideshow', 'grid' ] ],
		[ 'm3',  'M3: Alternating Columns',                'For Alternating Columns',              [ 'm3', 'alternating columns' ] ],
		[ 'm4',  'M4: Quote',                              'For Quote',                            [ 'm4', 'quote' ] ],
		[ 'm5',  'M5: Accordion',                          'For Accordion',                        [ 'm5', 'accordion' ] ],
		[ 'm6',  'M6: Sticky Column',                      'For Sticky Column',                    [ 'm6', 'sticky' ] ],
		[ 'm7',  'M7: Menu List',                          'For Menu List',                        [ 'm7', 'menu' ] ],
		[ 'm8',  'M8: Horizontal Rule',                    'For Horizontal Rule',                  [ 'm8', 'rule' ] ],
		[ 'm9',  'M9: Code Block',                         'For Code Block',                       [ 'm9', 'code' ] ],
		[ 'm10', 'M10: Custom Module',                     'For Custom Module Block',              [ 'm10', 'custom', 'block' ] ],
	];

	$pro_slugs  = ss_pro_block_slugs();
	$pro_active = ss_pro_active();

	foreach ( $blocks as [ $slug, $title, $desc, $keywords ] ) {
		$is_pro = in_array( $slug, $pro_slugs, true );
		$render = ( $is_pro && ! $pro_active )
			? $stub
			: $templates . 'mod_' . $slug . '.php';

		acf_register_block_type(
			[
				'name'            => 'module-' . $slug,
				'title'           => __( $title, 'shapeshifter' ),
				'description'     => __( $desc, 'shapeshifter' ),
				'render_template' => $render,
				'category'        => 'formatting',
				'icon'            => 'layout',
				'keywords'        => $keywords,
			]
		);
	}
}

function ss_filter_pro_blocks_from_inserter( $allowed, $editor_context ) {
	if ( ss_pro_active() ) {
		return $allowed;
	}

	$pro_blocks = ss_pro_block_names();

	if ( is_array( $allowed ) ) {
		return array_values( array_diff( $allowed, $pro_blocks ) );
	}

	if ( $allowed === true ) {
		$registry = WP_Block_Type_Registry::get_instance();
		$all      = array_keys( $registry->get_all_registered() );
		return array_values( array_diff( $all, $pro_blocks ) );
	}

	return $allowed;
}
