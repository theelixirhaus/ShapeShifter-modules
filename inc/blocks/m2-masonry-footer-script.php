<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_footer', 'ss_output_m2_masonry_init', 100 );

function ss_output_m2_masonry_init(): void {
	global $masonary_grid;

	if ( empty( $masonary_grid ) ) {
		return;
	}
	?>
<script>
(function( $ ){
	$('.mod-grid.masonary-grid').each(function(){
		var $grid = $(this).masonry({
			itemSelector:   '.mod-grid-item',
			columnWidth:    '.grid-sizer',
			percentPosition: true,
			initLayout:      true
		});

		setTimeout(function(){
			$grid.masonry('layout');
		}, 10000);
	});
})(jQuery);
</script>
	<?php
}
