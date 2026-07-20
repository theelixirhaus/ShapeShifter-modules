<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ss_register_module_cpt' );

function ss_register_module_cpt(): void {
	register_post_type(
		'ss_module',
		[
			'labels'             => [
				'name'               => __( 'Modules', 'shapeshifter' ),
				'singular_name'      => __( 'Module', 'shapeshifter' ),
				'menu_name'          => __( 'Modules', 'shapeshifter' ),
				'add_new'            => __( 'Add New', 'shapeshifter' ),
				'add_new_item'       => __( 'Add New Module', 'shapeshifter' ),
				'edit_item'          => __( 'Edit Module', 'shapeshifter' ),
				'new_item'           => __( 'New Module', 'shapeshifter' ),
				'view_item'          => __( 'View Module', 'shapeshifter' ),
				'search_items'       => __( 'Search Modules', 'shapeshifter' ),
				'not_found'          => __( 'No modules found', 'shapeshifter' ),
				'not_found_in_trash' => __( 'No modules in trash', 'shapeshifter' ),
			],
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-schedule',
			'menu_position'      => 25,
			'supports'           => [ 'title', 'editor', 'revisions', 'custom-fields' ],
			'has_archive'        => false,
			'rewrite'            => [ 'slug' => 'ss_module', 'with_front' => false ],
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'publicly_queryable' => false,
		]
	);
}
