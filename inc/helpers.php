<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $form_scripts, $ss_faqarray, $ss_globalscripts;
$form_scripts     = [];
$ss_faqarray      = [];
$ss_globalscripts = '';

function ss_grab_vimeo_thumbnail( $vimeo_id, $size = null ) {
	$url = "https://vimeo.com/api/oembed.json?url=https://vimeo.com/" . urlencode($vimeo_id);
    
    // Use file_get_contents (simple) or cURL for better control
    $response = @file_get_contents($url);
    
    if ($response === false) {
        return false; // Network error or video not found
    }
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['thumbnail_url'])) {
        return false;
    }
    
    return $data['thumbnail_url'];
}

function ss_grab_youtube_thumbnail( $id ) {
	return 'https://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';
}

function ss_get_thumb( $vid, $size = null ) {
	if ( is_numeric( $vid ) ) {
		return ss_grab_vimeo_thumbnail( $vid, $size );
	}
	return ss_grab_youtube_thumbnail( $vid );
}

function ss_get_content( $pid ) {
	$the_post = get_post( $pid );
	if ( isset( $the_post->post_content ) ) {
		return do_blocks( $the_post->post_content );
	}
	return '';
}

/* ========================================================================
							Get post Excerpt
==========================================================================*/

function ss_excerpt_by_id( $post_id = 0 ) {

	return apply_filters('the_excerpt', get_post_field('post_excerpt', $post_id));
}



function ss_trimexcerpt($e,$c=null,$charL=null){

	if(!$charL){
		$charL = 110;
	}

	//echo '$charL ='.$charL;

	$excerpt = strip_tags($e); 

	if($excerpt==''){
		$excerpt = strip_tags($c);
		
	}

	if(strlen($excerpt)>$charL){
								  
			$excerptsrc = substr($excerpt,0,$charL);
				
			$lastSpace = strrpos($excerpt,'.');

			if($lastSpace<20){
				$lastSpace='';
			}
			if($lastSpace=='' || $lastSpace<1){
				$lastSpace =$charL;
			}
			$excerpt = substr($excerpt,0,$lastSpace).'.';
			
			if($excerpt=='' || strlen($excerpt)>$lastSpace){
				$excerptsrc = substr($excerpt,0,$charL);
				$lastSpace = strrpos($excerptsrc,' ');
				

			$excerpt = substr($excerptsrc,0,$lastSpace).'...';
			
		}
		
	}

	return $excerpt;

}





/* ========================== Get Block Data ============================ */

function ss_block_data($post, $block_name = 'core/heading', $field_name = "" ){
    $content = "";

    if ( has_blocks( $post->post_content ) && !empty($field_name )) {
    
        $blocks = parse_blocks( $post->post_content );
        foreach($blocks as $block){

            if ( $block['blockName'] === $block_name ) {
                if(isset($block["attrs"]["data"][$field_name ])){
                   $content .= $block["attrs"]["data"][$field_name ];
                }
            }           
        }  
    }

    return $content;


}

function ss_add_pclass( $txt, $classes ) {
	return str_replace( '<p', '<p class="' . $classes . '"', $txt );
}

function ss_rsrcPic( $imgObject, $defaultSize = null, $customClass = null, $alt = null ) {
	if ( is_numeric( $imgObject ) && intval( $imgObject ) > 0 ) {
		$id     = intval( $imgObject );
		$full   = wp_get_attachment_image_src( $id, 'full' );
		$large  = wp_get_attachment_image_src( $id, 'large' );
		$medium = wp_get_attachment_image_src( $id, 'medium' );
		$thumb  = wp_get_attachment_image_src( $id, 'thumbnail' );

		if ( ! $full ) {
			return '';
		}

		$imgObject = [
			'url'    => $full[0],
			'width'  => $full[1],
			'height' => $full[2],
			'title'  => get_the_title( $id ),
			'alt'    => get_post_meta( $id, '_wp_attachment_image_alt', true ),
			'sizes'  => [
				'large'            => $large[0]  ?? $full[0],
				'large-width'      => $large[1]  ?? $full[1],
				'large-height'     => $large[2]  ?? $full[2],
				'medium'           => $medium[0] ?? $full[0],
				'medium-width'     => $medium[1] ?? $full[1],
				'medium-height'    => $medium[2] ?? $full[2],
				'thumbnail'        => $thumb[0]  ?? $full[0],
				'thumbnail-width'  => $thumb[1]  ?? $full[1],
				'thumbnail-height' => $thumb[2]  ?? $full[2],
			],
		];
	}

	if ( ! is_array( $imgObject ) || empty( $imgObject['url'] ) ) {
		return '';
	}

	$size      = $defaultSize ?: 'full';
	$src       = $size === 'full' ? $imgObject['url'] : ( $imgObject['sizes'][ $size ] ?? $imgObject['url'] );
	$width     = $size === 'full' ? $imgObject['width']  : ( $imgObject['sizes'][ $size . '-width' ]  ?? $imgObject['width'] );
	$height    = $size === 'full' ? $imgObject['height'] : ( $imgObject['sizes'][ $size . '-height' ] ?? $imgObject['height'] );
	$alt_text  = $alt ?: ( $imgObject['alt'] ?: $imgObject['title'] );
	$class_str = $customClass ? ' class="' . esc_attr( $customClass ) . '"' : '';

	return sprintf(
		'<img src="%s" width="%s" height="%s" alt="%s"%s>',
		esc_url( $src ),
		esc_attr( $width ),
		esc_attr( $height ),
		esc_attr( $alt_text ),
		$class_str
	);
}

function ss_footer_code() {
	global $ss_faqarray;
	?>
	<?php
	if(count($ss_faqarray)>0){
		for($ar_item=0; $ar_item<=count($ss_faqarray); $ar_item++){

			if(isset($ss_faqarray[$ar_item]) && is_array($ss_faqarray[$ar_item])){
				$faqtotal = count($ss_faqarray[$ar_item]); 
				if($faqtotal>0){
				echo '
				<!-- Dynamic ShapeShifter FAQ Schema -->
				<script type="application/ld+json">
				{
				  "@context": "https://schema.org",
				  "@type": "FAQPage",
				  "mainEntity": [';

				  for($ar = 0; $ar < $faqtotal; $ar++){ 

				  echo '  {
				      "@type": "Question",
				      "name": "'.$ss_faqarray[$ar_item][$ar][0].'",
				      "acceptedAnswer": {
				        "@type": "Answer",
				        "text": "'.$ss_faqarray[$ar_item][$ar][1].'"
				      }
				    }'.(($ar < $faqtotal - 1) ? ',' : '');
				 } 
				echo '  ]
				}
				</script>';
				}
			}
		}
	}


	echo "
	<!-- ShapeShifter Lightboxes -->
	<script>
		(function( $ ){
			$('[href*=\"#lightbox-\"]').click(function(e){
		        e.preventDefault();
		        var lghbx= $(this).attr('href').split('#lightbox-');
		        lghbx= lghbx[1];
		        console.log('lghbx[1] ='+lghbx[1]);
		        
		        e.preventDefault();
		        $('.ss-lightbox[data-type=\"'+lghbx+'\"').removeClass('dp-hide');


		        $('.ss-lightbox[data-type=\"'+lghbx+'\"] .btn-close').click(function(){
		          $('.ss-lightbox[data-type=\"'+lghbx+'\"]').addClass('dp-hide');
		          reset_fforms();
		          
		        });


		    });
		  

		  $('.ss-lightbox[data-type=\"lightbox\"] .btn-close').click(function(){
		      $('.ss-lightbox[data-type=\"lightbox\"]').addClass('dp-hide');
		      $('.ss-lightbox[data-type=\"lightbox\"] .ss-lightbox-modal').html('');
		      $('.ss-lightbox[data-type=\"lightbox\"] .ss-lightbox-modal').attr('data-type','');
		  });


		  $('.ss-lightbox-trigger').click( function(e){
		    e.preventDefault();
		 

		    $('.ss-lightbox[data-type=\"lightbox\"] .ss-lightbox-modal').html('');
		    $('.ss-lightbox[data-type=\"lightbox\"] .ss-lightbox-modal').append($(this).parent().find('.ss-lightbox-content').html());
		  

		    if($(this).parent().find('.ss-lightbox-content iframe').length>0){
		     if($(this).parent().find('.ss-lightbox-content iframe').attr('src').indexOf('vimeo') !== -1){
		          $('.ss-lightbox[data-type=\"lightbox\"]').attr('data-type','video');
		     }
		   }
	    	
	    	$('.ss-lightbox[data-type=\"lightbox\"]').removeClass('dp-hide');
	    
	    });

	   })(jQuery);

</script>";




}
add_action( 'wp_footer', 'ss_footer_code' );

function ss_setslide( $params ) {
	$vidtype   = is_numeric( $params['m2_vidid'] ?? '' );
	$slidetype = '';

	if ( ! empty( $params['m2_usevid'] ) && $vidtype ) {
		$slidetype = 'vimeo';
	} elseif ( ! empty( $params['m2_usevid'] ) ) {
		$slidetype = 'youtube';
	}

	$m2_class     = $params['m2_slide_class'] ?? '';
	$bgpos        = $params['m2_slide_algnmnt'] ?? '';
	$m2_item_p_sz = $params['m2_item_p_sz'] ?? '';
	$m2_spacing   = $params['m2_spacing'] ?? '';
	$m2_fitimg    = ! empty( $params['m2_fitimg'] ) ? ' fitimg ' : '';
	$m2_lazy      = ! empty( $params['m2_lazy'] ) ? ' loading="lazy" ' : '';

	if ( get_sub_field( 'm2_slide_tint' ) ) {
		$m2_class .= ' tint ';
	}

	if ( ! empty( $params['m2_slide_txt_lt'] ) ) {
		$m2_class .= ' mod-txt-lght ';
	}

	if ( ! empty( $params['m2_usevid'] ) && ! empty( $params['m2_vidid'] ) ) {
		$params['m2_bgimg'] = ss_get_thumb( $params['m2_vidid'] );
	}

	$params['m2_btn_txt'] = $params['m2_btn_txt'] ? $params['m2_btn_txt'] : 'Click Here';
	$m2_bgimg             = $params['m2_bgimg'] ?? '';
	$m2_bgimg_alt         = $m2_bgimg['alt'] ?? $m2_bgimg['title'] ?? '';

	if ( ! empty( $params['m2_usevid'] ) ) {
		$vid     = $params['m2_vidid'];
		$resp    = wp_remote_get( "https://vimeo.com/api/v2/video/{$vid}.php" );
		$hash    = is_wp_error( $resp ) ? [] : @unserialize( wp_remote_retrieve_body( $resp ) );
		$m2_bgimg     = [ 'url' => $hash[0]['thumbnail_medium'] ?? '' ];
		$m2_bgimg_alt = ( $params['m2_head'] ?? '' ) . ' video';
	}

	$slide_imgW = 1024;
	$slide_imgH = 768;

	if ( $m2_bgimg && function_exists( 'getimagesize' ) && empty( $params['m2_usevid'] ) ) {
		$getimgSize = @getimagesize( is_array( $m2_bgimg ) ? $m2_bgimg['url'] : $m2_bgimg );
		if ( $getimgSize ) {
			[ $slide_imgW, $slide_imgH ] = $getimgSize;
		}
	}

	$m2_bgimg_sz = $params['m2_bgimg_sz'] ?: 'full';
	$imgpath     = '';
	$img_w       = 350;
	$img_h       = 300;

	if ( isset( $m2_bgimg['url'] ) && empty( $params['m2_usevid'])) {

		if ( $m2_bgimg_sz === 'full' ) {
			$imgpath = $m2_bgimg['url'];

		} else {
			if(isset($m2_bgimg['sizes']) && isset($m2_bgimg['sizes'][ $m2_bgimg_sz ])){
				$imgpath = $m2_bgimg['sizes'][ $m2_bgimg_sz ] ?? '';
				$img_w   = $m2_bgimg['sizes'][ $m2_bgimg_sz . '-width' ] ?? 350;
				$img_h   = $m2_bgimg['sizes'][ $m2_bgimg_sz . '-height' ] ?? 300;
			}
		}
	}
	


	$moditem = '<div class="ss-slide s-' . ( $params['slidecount'] ?? '' ) . ' ' . $m2_class . ' ' . ( $m2_bgimg ? 'has-image' : '' ) . ' ' . $bgpos . ' ' . ( isset( $params['m2_btn'] ) ? 'no-button' : '' ) . '" '
		. ( ! empty( $params['m2_bgclr'] ) ? 'style="background-color:' . $params['m2_bgclr'] . ';"' : '' ) . ' '
		. ( ! empty( $params['m2_usevid'] ) ? 'data-vidthumb="' . esc_attr( is_array( $params['m2_bgimg'] ) ? '' : $params['m2_bgimg'] ) . ';"' : '' )
		. ' data-img-width="' . $slide_imgW . '" data-img-height="' . $slide_imgH . '" data-tint_pos="' . ( $params['m2_align_content'] ?? '' ) . '">';

	if ( $imgpath ) {
		$moditem .= '<img class="m2-img ' . $bgpos . '" style="object-fit:'.($params['m2_fitimg']? 'contain' : 'cover').'; object-position:' . ( $params['m2_slide_algnmnt'] ?? '' ) . '" src="' . esc_url( $imgpath ) . '" ' . $m2_lazy . ' alt="' . esc_attr( $m2_bgimg_alt ) . '" width="'.$img_w.'" height="'.$img_h.'">';
	}

	if ( $slidetype !== '' ) {
		if ( $slidetype === 'vimeo' ) {
			global $loadvimeo;
			$loadvimeo = true;
			$moditem  .= '<div class="vid-tint" style="background-color:rgba(' . get_field( 'm1_vid_tint_rgba' ) . ')"></div>';
			$moditem  .= '<div class="bg-video" data-diff="100" data-tpspeed="fixed" data-zoom="1" data-img-height="' . $img_h . '" data-img-width="' . $img_w . '">'.(!is_admin()?'
				<iframe src="https://player.vimeo.com/video/' . $params['m2_vidid'] . '?api=1&autoplay=1&background=1&playsinline=1&muted=1&player_id=vimeo-vid-' . $params['m2_vidid'] . '" width="100%" height="100%" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen id="vimeo-vid-' . $params['m2_vidid'] . '" class="vimeo-frame autoplay project-video"></iframe>':'<div id="video-placeholder-' . $params['m2_vidid'] . '" class="vid-thumb" data-vidid="' . $vid . '"><img src="'.ss_grab_vimeo_thumbnail($params['m2_vidid']).'" alt="Video '.$vid.' placeholder image"></div>').'
			</div>';
		} elseif ( $slidetype === 'youtube' ) {
			$moditem .= '<div class="bg-video"><div id="player_' . $params['m2_vidid'] . '" class="youtube"></div></div>';
		}
	}

	if ($params['m2_slide_tint'] != '') {
    	$moditem .= '<div class="mod-bg-tint" style="background-color:' .$params['m2_slide_tint'] . '"></div>';
	}

	$moditem .= '<div class="dp-valigner ' . ( $params['m2_txt_algnmnt'] ?? '' ) . ' ' . ( $params['m2_align_content'] ?? '' ) . ' txt-overlay">
			<div class="dp-valign">
				<div class="dp-contain dp-pos:cntr dp-txt:cntr:xs dp-txt:cntr:s slide-content default-spacing:' . $m2_spacing . '">';

	if ( ! empty( $params['m2_cat_lnk'] ) ) {
		$moditem .= $params['m2_cat_lnk'];
	}

	if ( ! empty( $params['m2_postdate'] ) ) {
		$moditem .= '<h5>' . $params['m2_postdate'] . '</h5>';
	}

	if ( isset( $params['m2_head_stylized'] ) ) {
		$moditem .= '<h2>' . $params['m2_head_stylized'] . '</h2><div class="stylized-pad">';
	}

	if ( isset( $params['m2_usepages'] ) && ! empty( $params['m2_grid_options']['head'] ) ) {
		$moditem .= '<h3 class="title ' . $m2_item_p_sz . '">' . $params['m2_head'] . '</h3>';
	} elseif ( ! empty( $params['m2_head'] ) ) {
		$moditem .= '<h3 class="title ' . $m2_item_p_sz . '">' . $params['m2_head'] . '</h3>';
	}

	if ( ! empty( $params['m2_subtitle'] ) ) {
		$moditem .= '<p class="sub-title dp-txt:cntr:s dp-txt:cntr:xs dp-marg:15px:bot ' . ( $params['m2_item_subhead_sz'] ?? '' ) . '">' . $params['m2_subtitle'] . '</p>';
	}

	if ( isset( $params['m2_usepages'] ) && ! empty( $params['m2_grid_options']['txt'] ) ) {
		$moditem .= '<div class="dp-marg:25pc:top ' . $m2_item_p_sz . '">' . $params['m2_txt'] . '</div>';
	} elseif ( ! empty( $params['m2_txt'] ) ) {
		$moditem .= '<div class="dp-pad:10px:bot ' . $m2_item_p_sz . '">' . $params['m2_txt'] . '</div>';
	}

	if ( ! empty( $params['m2_btn'] ) && ! empty( $params['m2_btn_lead'] ) ) {
		$moditem .= '<div class="lead-txt dp-pad:10px:top ' . ( $params['m2_item_leadin_sz'] ?? '' ) . '">' . $params['m2_btn_lead'] . '</div>';
	}

	if ( isset( $params['m2_usepages'] ) && ! empty( $params['m2_grid_options']['btn'] ) ) {
		$btnlnk = ! empty( $params['m2_use_url'] ) ? $params['m2_url'] : $params['m2_lnk'];
		$target = ! empty( $params['m2_new_win'] ) ? ' target="_blank" ' : '';
		$moditem .= '<div class="button-pos dp-txt:cntr:xs dp-txt:cntr:s dp-marg:15px:top">
			<a href="' . esc_url( $btnlnk ) . '" ' . $target . ' class="button ' . ( ! empty( $params['m2_btn_rev'] ) ? ' btn-rev ' : '' ) . '">' . $params['m2_btn_txt'] . '</a>
		</div>';
	} elseif ( ! empty( $params['m2_btn'] ) ) {
		$btnlnk = ! empty( $params['m2_use_url'] ) ? $params['m2_url'] : $params['m2_lnk'];
		$target = ! empty( $params['m2_new_win'] ) ? ' target="_blank" ' : '';
		$moditem .= '<div class="button-pos dp-marg:5px:top">
			<a href="' . esc_url( $btnlnk ) . '" class="button ' . ( ! empty( $params['m2_btn_rev'] ) ? ' btn-rev ' : '' ) . ' dp-txt-med ' . ( ! empty( $params['m2_txt_lt'] ) ? ' rev ' : '' ) . '" ' . $target . '>' . $params['m2_btn_txt'] . '</a>
		</div>';
	}

	if ( ! empty( $params['feat_credit'] ) ) {
		$moditem .= '<div class="caption dp-txt-xsm">' . $params['feat_credit'] . '</div>';
	}

	if ( empty( $params['m2_btn'] ) && ( ! empty( $params['m2_use_url'] ) || ! empty( $params['m2_lnk'] ) ) ) {
		$btnlnk  = ! empty( $params['m2_use_url'] ) ? $params['m2_use_url'] : $params['m2_lnk'];
		$target  = ! empty( $params['m2_use_url'] ) ? ' target="_blank" ' : '';
		$moditem .= '<a href="' . esc_url( $btnlnk ) . '" class="invisbutton" ' . $target . '></a>';
	}

	if ( isset( $params['m2_head_stylized'] ) ) {
		$moditem .= '</div>';
	}

	$moditem .= '</div></div></div></div>';

	return $moditem;
}

function ss_setitem( $params ) {
	$m2_lazy            = ! empty( $params['m2_lazy'] ) ? ' loading="lazy" ' : '';
	$styles             = ! empty( $params['m2_bgclr'] ) ? ' background-color:' . $params['m2_bgclr'] . ';' : '';
	$txt_lt             = $params['m2_slide_txt_lt'] ?? '';
	$m2_fitimg          = ! empty( $params['m2_fitimg'] ) ? 'fitimg' : '';
	$m2_class           = $params['m2_slide_class'] ?? '';
	$m2_item_p_sz       = $params['m2_item_p_sz'] ?? '';
	$m2_item_head_sz    = $params['m2_item_head_sz'] ?? '';
	$m2_item_subhead_sz = $params['m2_item_subhead_sz'] ?? '';

	if ( ! empty( $params['m2_usevid'] ) && ! empty( $params['m2_vidid'] ) ) {
		$params['m2_bgimg'] = ss_get_thumb( $params['m2_vidid'] );
	}

	$params['m2_btn_txt'] = isset($params['m2_btn_txt']) && $params['m2_btn_txt']!='' ? $params['m2_btn_txt'] : 'Click Here';
	$btnlnk               = ! empty( $params['m2_use_url'] ) ? $params['m2_url'] : ( $params['m2_lnk'] ?? '' );
	$target               = ! empty( $params['m2_new_win'] ) ? ' target="_blank" ' : '';
	$m2_bgimg             = $params['m2_bgimg'] ?? '';
	$m2_bgimg_alt         = $m2_bgimg['alt'] ?? $m2_bgimg['title'] ?? '';
	$m2_id                = isset( $params['m2_id'] ) ? 'data-id="' . $params['m2_id'] . '"' : '';

	$moditem  = '<!-- Start Grid Item -->';

	$moditem .= '<div class="mod-grid-item ' . $txt_lt . ' ' . $m2_class . ' ' . ( ( $params['slidetype'] ?? '' ) === 'post' ? 'article-link' : '' ) . '" data-type="' . ( $params['slidetype'] ?? '' ) . '" data-button="' . esc_attr( $btnlnk ) . '" ' . $m2_id . ' data-linktype="' . ( ! empty( $params['m2_blocklink'] ) ? 'blocklink' : 'buttonlink' ) . '">
		<div class="mod-grid-item-pad">
			<div class="article ' . ( $params['m2_txt_algnmnt'] ?? '' ) . '">';

		

	if ( isset( $params['m2_usepages'] ) && ( !empty( $params['m2_grid_options']['img'] )) ) {
		$moditem .= '<div style="' . $styles . ' height:calc(600px / ' . ( $params['m2_grid_clmns'] ?? 1 ) . ')" class="thumb ' . $m2_fitimg . '" ' . $m2_lazy . '>';

		if ( ! empty( $params['m2_head'] ) && ! empty( $params['m2_txtovrImg'] ) && ! empty( $params['m2_grid_options']['head'] ) ) {
			$moditem .= '<h3 class="' . $m2_item_head_sz . '">' . $params['m2_head'] . '</h3>';
		}

		$m2_bgimg_sz = isset($params['m2_bgimg_sz']) && $params['m2_bgimg_sz']!='' ?: 'full';
		$imgpath     = $m2_bgimg_sz === 'full' ? ( $m2_bgimg['0'] ?? '' ) : ( $m2_bgimg[0] ?? '' );
		$img_w       = $m2_bgimg_sz === 'full' ? 350 : ( $m2_bgimg[1] ?? 350 );
		$img_h       = $m2_bgimg_sz === 'full' ? 300 : ( $m2_bgimg[2] ?? 300 );


		if ( ( $params['slidetype'] ?? '' ) === 'post' ) {
			$feat_img_thumb = get_field( 'featured_image_mob', $params['m2_id'] );
			if ( $feat_img_thumb !== '' ) {
				$imgpath = $feat_img_thumb;
			}
		}

		if($imgpath==''){
			$imgpath = $m2_bgimg[0];
			$img_w =$m2_bgimg[1];
			$img_h = $m2_bgimg[2];
		}
		if ( $imgpath ) {
			$moditem .= '<img src="' . esc_url( $imgpath ) . '" alt="' . esc_attr( $m2_bgimg_alt ) . '" ' . $m2_lazy . ' width="' . $img_w . '" height="' . $img_h . '">';
		}

		$moditem .= '</div>';
	} elseif ( !isset( $params['m2_usepages'] ) && (! empty( $params['m2_bgimg'])  || ! empty( $params['m2_bgclr'] ))) {
		$moditem .= '<div style="' . $styles . ' height:calc(600px / ' . ( $params['m2_grid_clmns'] ?? 1 ) . ');" class="thumb ' . $m2_fitimg . '">';

		$m2_bgimg_sz = $params['m2_bgimg_sz'] ?: 'full';
		$imgpath     = $m2_bgimg_sz === 'full' ? ( $m2_bgimg['url'] ?? '' ) : ( $m2_bgimg['sizes'][ $m2_bgimg_sz ] ?? '' );
		$img_w       = $m2_bgimg_sz === 'full' ? 350 : ( $m2_bgimg['sizes'][ $m2_bgimg_sz . '-width' ]  ?? 350 );
		$img_h       = $m2_bgimg_sz === 'full' ? 300 : ( $m2_bgimg['sizes'][ $m2_bgimg_sz . '-height' ] ?? 300 );

		if($imgpath==''){
			$imgpath = $m2_bgimg[0][0];
			$img_w =$m2_bgimg[0][1];
			$img_h = $m2_bgimg[0][2];
		}


		if ( $imgpath ) {
			$moditem .= '<img src="' . esc_url( $imgpath ) . '" alt="' . esc_attr( $m2_bgimg_alt ) . '" ' . $m2_lazy . ' width="' . $img_w . '" height="' . $img_h . '">';
		}

		if ( ! empty( $params['m2_head'] ) && ! empty( $params['m2_txtovrImg'] ) ) {
			$moditem .= '<span class="tint"></span><h3 class="' . $m2_item_head_sz . '">' . $params['m2_head'] . '</h3>';
		}

		$moditem .= '</div>';
	}

	$moditem .= '<div class="info dp-pad:25pc:bot:xs dp-pad:25pc:bot:s">';

	if ( isset( $params['m2_grid_options'] ) && ! empty( $params['m2_grid_options']['cat'] ) && ! empty( $params['m2_cat'] ) && $params['m2_cat'] !== 'Uncategorized' ) {
		$moditem .= '<div class="props dp-marg:5px:bot"><span class="cat">' . $params['m2_cat'] . '</span></div>';
	}

	if ( isset( $params['m2_usepages'] ) && ( $params['slidetype'] ?? '' ) !== 'review' && ( $params['slidetype'] ?? '' ) !== 'post' && ! empty( $params['m2_grid_options']['date'] ) ) {
		$moditem .= '<h4 class="dp-txt:sm">' . $params['m2_postdate'] . '</h4>';
	}

	if ( isset( $params['m2_usepages'] ) ) {
		if ( ! empty( $params['m2_grid_options']['head'] ) ) {
			$moditem .= '<h3 class="' . $m2_item_head_sz . '">' . $params['m2_head'] . '</h3>';
		}
	} elseif ( ! empty( $params['m2_head'] ) && empty( $params['m2_txtovrImg'] ) ) {
		$moditem .= '<h3 class="dp-marg:20px:top ' . $m2_item_head_sz . '">' . $params['m2_head'] . '</h3>';
	}

	if ( ! empty( $params['m2_subtitle'] ) ) {
		$moditem .= '<p class="sub-title ' . $m2_item_subhead_sz . '">' . $params['m2_subtitle'] . '</p>';
	}

	if ( isset( $params['m2_usepages'] ) && ! empty( $params['m2_grid_options']['date'] ) && ( $params['slidetype'] ?? '' ) === 'review' ) {
		$moditem .= '<h4 class="dp-txt:sm">' . $params['m2_postdate'] . '</h4>';
		$moditem .= '<div class="starratting" data-starnum="' . ( $params['starnum'] ?? '' ) . '"><div class="stars"></div></div>';
	}

	if ( isset( $params['m2_usepages'] ) ) {
		if ( ! empty( $params['m2_grid_options']['txt'] ) ) {
			$moditem .= '<div class="mod-txt dp-pad:15px:top ' . $m2_item_p_sz . ' ' . ( ! empty( $params['m2_head'] ) && empty( $params['m2_txtovrImg'] ) ? 'dp-marg-10px-top' : '' ) . '">' . $params['m2_txt'] . '</div>';
		}
	} elseif ( ! empty( $params['m2_txt'] ) ) {
		$moditem .= '<div class="mod-txt dp-pad:15px:top dp-pad:10px:bot dp-pad:25pc:bot:xs dp-pad:25pc:bot:s ' . $m2_item_p_sz . ' ' . ( ! empty( $params['m2_head'] ) && empty( $params['m2_txtovrImg'] ) ? 'dp-marg-10px-top' : '' ) . '">' . $params['m2_txt'] . '</div>';
	}

	if ( isset( $params['m2_usepages'] ) && ( $params['slidetype'] ?? '' ) === 'post' && ! empty( $params['m2_grid_options']['date'] ) ) {
		$moditem .= '<div class="dp-txt:xsm dp-txt:clr6 dp-fnt:2 dp-txt:uppercase post-meta dp-pad:5px:top postdate" style="font-size:13px">' . $params['m2_postdate'] . '</div>';
	}

	if ( ! empty( $params['m2_btn'] ) && ! empty( $params['m2_btn_lead'] ) ) {
		$moditem .= '<div class="lead-txt dp-pad:20px:top:xs dp-pad:20px:top:s ' . ( $params['m2_txt_algnmnt'] ?? '' ) . '">' . $params['m2_btn_lead'] . '</div>';
	}

	if ( empty( $params['m2_blocklink'] ) ) {
		if ( ! empty( $params['m2_btn'] ) ) {
			if ( isset( $params['m2_grid_options'] ) ) {
				if ( ! empty( $params['m2_grid_options']['btn'] ) ) {
					$moditem .= '<div class="button-pos dp-txt:cntr:xs dp-txt:cntr:s dp-marg:15px:top">
						<a href="' . esc_url( $btnlnk ) . '" ' . $target . ' class="button ' . ( ! empty( $params['m2_btn_rev'] ) ? ' btn-rev ' : '' ) . '">' . $params['m2_btn_txt'] . '</a>
					</div>';
				}
			} else {
				$moditem .= '<div class="button-pos dp-txt:cntr:xs dp-txt:cntr:s dp-marg:15px:top">
					<a href="' . esc_url( $btnlnk ) . '" ' . $target . ' class="button ' . ( ! empty( $params['m2_btn_rev'] ) ? ' btn-rev ' : '' ) . '">' . $params['m2_btn_txt'] . '</a>
				</div>';
			}
		} elseif ( $btnlnk ) {
			$moditem .= '<a href="' . esc_url( $btnlnk ) . '" ' . $target . ' class="link-hit"> </a>';
		}
	}

	if ( ! empty( $params['m2_blocklink'] ) ) {
		if ( ! empty( $params['m2_btn'] ) ) {
			$moditem .= '<div class="button-pos dp-txt:cntr:xs dp-txt:cntr:s dp-marg:15px:top">
				<button class="' . ( ! empty( $params['m2_btn_rev'] ) ? ' btn-rev ' : '' ) . '">' . $params['m2_btn_txt'] . '</button>
			</div>';
		}
		$moditem .= '<a href="' . esc_url( $btnlnk ) . '" ' . $target . ' class="link-hit"> </a>';
	}

	$moditem .= '</div>';

	if ( isset( $params['m2_grid_options'] ) && empty( $params['m2_grid_options']['btn'] ) && isset( $params['m2_usepages'] ) && ( $params['slidetype'] ?? '' ) !== 'review' ) {
		$moditem .= '<a href="' . esc_url( $btnlnk ) . '" class="link-hit"> </a>';
	}

	$moditem .= '</div></div></div><!-- End Grid Item -->';

	return $moditem;
}

function ss_use_external_assets(): bool {
	return is_user_logged_in() && isset( $_GET['dev'] );
}

function ss_pro_active(): bool {
	return class_exists( 'SS_License' ) && SS_License::is_active();
}

function ss_minify_css( string $css ): string {
	$css = preg_replace( '!/\*.*?\*/!s', '', $css );
	$css = preg_replace( '/\s+/', ' ', $css );
	$css = preg_replace( '/\s*([{}:;,>+~])\s*/', '$1', $css );
	$css = preg_replace( '/;}/', '}', $css );
	return trim( (string) $css );
}

function ss_minify_js( string $js ): string {
	$js = preg_replace( '!/\*.*?\*/!s', '', (string) $js );
	$lines = preg_split( "/\r\n|\r|\n/", (string) $js );
	$out = [];
	foreach ( $lines as $line ) {
		$trimmed = ltrim( $line );
		if ( $trimmed === '' || str_starts_with( $trimmed, '//' ) ) {
			continue;
		}
		$out[] = rtrim( $line );
	}
	return implode( "\n", $out );
}

function ss_read_asset_contents( string $abs_path ): string {
	if ( ! is_file( $abs_path ) ) {
		return '';
	}
	return (string) file_get_contents( $abs_path );
}

function ss_register_inline_style( string $handle, string $rel_path, array $deps = [] ): void {
	$url      = SS_ASSETS_URL . $rel_path;
	$abs_path = SS_DIR . 'assets/' . $rel_path;

	if ( ss_use_external_assets() ) {
		wp_register_style( $handle, $url, $deps, SS_VERSION );
		return;
	}

	$css = ss_read_asset_contents( $abs_path );
	if ( $css !== '' && defined( 'SS_MINIFY' ) && SS_MINIFY ) {
		$css = ss_minify_css( $css );
	}

	wp_register_style( $handle, false, $deps, SS_VERSION );
	if ( $css !== '' ) {
		wp_add_inline_style( $handle, $css );
	}
}

function ss_register_inline_script( string $handle, string $rel_path, array $deps = [], bool $in_footer = true ): void {
	$url      = SS_ASSETS_URL . $rel_path;
	$abs_path = SS_DIR . 'assets/' . $rel_path;

	if ( ss_use_external_assets() ) {
		wp_register_script( $handle, $url, $deps, SS_VERSION, $in_footer );
		return;
	}

	$js = ss_read_asset_contents( $abs_path );
	if ( $js !== '' && defined( 'SS_MINIFY' ) && SS_MINIFY ) {
		$js = ss_minify_js( $js );
	}

	wp_register_script( $handle, false, $deps, SS_VERSION, $in_footer );
	if ( $js !== '' ) {
		wp_add_inline_script( $handle, $js );
	}
}
