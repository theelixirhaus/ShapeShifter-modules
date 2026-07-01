<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_footer', 'ss_render_module_lightboxes', 5 );

function ss_render_module_lightboxes(): void {
	$query = new WP_Query(
		[
			'numberposts' => -1,
			'posts_per_page' => -1,
			'post_type'   => 'ss_module',
			'post_status' => 'publish',
			'meta_query'  => [
				[
					'key'     => 'mod_lghtbx',
					'value'   => '1',
					'compare' => '=',
				],
			],
			'no_found_rows' => true,
		]
	);

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return;
	}

	foreach ( $query->posts as $mod ) {
		$lightbox_name = function_exists( 'get_field' ) ? get_field( 'mod_lghtbx_name', $mod->ID ) : '';
		?>
		<div class="ss-lightbox dp-hide module-box" data-type="<?php echo esc_attr( $lightbox_name ); ?>">
			<div class="ss-lightbox-container">
				<div class="ss-lightbox-modal">
					<?php echo do_shortcode( ss_get_content( $mod->ID ) ); ?>
				</div>
				<div class="btn-close" data-type="lightbox"><span>&#x2715;</span></div>
			</div>
			<div class="hit"></div>
		</div>
		<?php
	}

	wp_reset_postdata();
}
