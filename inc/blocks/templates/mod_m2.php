<?php
/*
Module Overview:
This module checks to see if slides are set "Explicitly", by "Selected Pages", or set as a grid.
It loops through the entries getting the field data and then sets variables.
The actual "slide" is defined in the function "ss_setslide()", located in /includes/functions/func-modules.php file.
The module needs javascript assets/js/modules/mod-m2.js to create the slider logic, and assets/js/modules/mod-m2-video.js to set the video player logic.
Basic styles for element positioning are set under the child theme, in assets/css/scss/modules/mod-m2.scss.
*/

$styles = '';

// Module Options
$m2_usepages = get_field('m2_usepages');
$m2_grid = get_field('m2_grid');
$m2_grid_slider = get_field('m2_grid_slider');

// Content
$m2_intro_head = get_field('m2_intro_head');
$m2_intro_use_h1 = get_field('m2_intro_use_h1');
$m2_intro_txt = get_field('m2_intro_txt');
$m2_pageslides_auto = get_field('m2_pageslides_auto');
$m2_pageslides_posttype = get_field('m2_pageslides_posttype');
$m2_pageslides_cnt = get_field('m2_pageslides_cnt');
$m2_pageslides_post_lmt = get_field('m2_pageslides_post_lmt');
$m2_pageslides = get_field('m2_pageslides');
$m2_slide_algnmnt_default = get_field('m2_slide_algnmnt_default'); // For slides
$m2_txt_post = get_field('m2_txt_post');

// Style
$m2_look = get_field('m2_look');
$m2_look = $m2_look ? ' data-look="'.$m2_look.'"' : '';
$m2_fx = get_field('m2_fx');
$m2_fx_type = $m2_fx ? ' data-fx="' . $m2_fx . '"' : '';
$m2_fx_grid = get_field('m2_fx_grid');
$m2_fx_grid_type = $m2_fx_grid ? ' data-fx="' . $m2_fx_grid . '"' : '';
$m2_hrt = get_field('m2_hrt');
$m2_hrb = get_field('m2_hrb');
$m2_bgclr = get_field('m2_bgclr');
$m2_bgimg = get_field('m2_bgimg');
$m2_bgimg_algnmnt = get_field('m2_bgimg_algnmnt');
$m2_intro_txt_lt = get_field('m2_intro_txt_lt');
$m2_id = get_field('m2_id');
$m2_class = get_field('m2_class');

// Formatting
$m2_spacing = get_field('m2_spacing');
$m2_intro_head_sz = get_field('m2_intro_head_sz');
$m2_intro_txt_sz = get_field('m2_intro_txt_sz');
$m2_intro_max_w = get_field('m2_intro_max_w');
$m2_intro_max_w = $m2_intro_max_w ? 'style="max-width:'.$m2_intro_max_w.'"':'';
$m2_intro_algnmnt = get_field('m2_intro_algnmnt');
$m2_intro_spacing = get_field('m2_intro_spacing');
$m2_intro_pos = get_field('m2_intro_pos');
$m2_item_head_sz = get_field('m2_item_head_sz');
$m2_item_subhead_sz = get_field('m2_item_subhead_sz');
$m2_item_p_sz = get_field('m2_item_p_sz');
$m2_item_p_limit = get_field('m2_item_p_limit');
$m2_fillw = get_field('m2_fillw');
$m2_clmns_fixedw = get_field('m2_clmns_fixedw') ? ' dp-contain ' : ' ';
$m2_clmns_fixedw_sm = get_field('m2_clmns_fixedw_sm') ? ' mod-contain-sm ' : ' ';
$m2_fillh = get_field('m2_fillh') ? 'm2-fillh' : '';
$m2_align_mod = get_field('m2_align_mod'); // For Container
$m2_align_content = get_field('m2_align_content'); // For Grid Items


// Slider Settings
$m2_infinitslide = get_field('m2_infinitslide');
$m2_autoslide = get_field('m2_autoslide');
$m2_slider_size = get_field('m2_slider_size')?: ' 16 / 9';
$m2_slider_pause_on_hov = get_field('m2_slider_pause_on_hov');
$m2_autoplay = get_field('m2_autoplay') ? '1' : '';
$m2_slidev = get_field('m2_slidev') ? 'vert' : '';
$m2_scrolltoggle = get_field('m2_scrolltoggle');


global $masonary_grid;
$m2_grid_clmns_masonary = get_field('m2_grid_clmns_masonary');
if($m2_grid_clmns_masonary){
 $masonary_grid = 1;
}


if(get_field('m2_grid_slider_dots_over')){
    $m2_class .= ' dot-nav-over '; 
};


if ($m2_intro_txt_lt) {
    $m2_intro_txt_lt = 'mod-txt-lght';
}
$m2_post_txt_lt = '';
if(get_field('m2_post_txt_lt') && $m2_usepages ){
    $m2_post_txt_lt = 'mod-txt-lght';
}

if ($m2_pageslides_auto) {
    $m2_pageslides_posttype = $m2_pageslides_posttype ?: 'post';
    $m2_pageslides_cnt = $m2_pageslides_cnt ?: 6;

    if($m2_pageslides_post_lmt!=''){
        $m2_pageslides_cnt = $m2_pageslides_post_lmt;
    }

    $m2_args = [
        'post_type' => $m2_pageslides_posttype,
        'post_status' => 'publish',
        'posts_per_page' => $m2_pageslides_cnt,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    if ($m2_pageslides_posttype == 'event') {
        $m2_args['order'] = 'asc';
        $m2_args['post_status'] = 'all';
        $m2_args['date_query'] = [
            [
                'after' => [
                    'year' => date("Y"),
                    'month' => date("n"),
                    'day' => date("j")
                ]
            ],
        ];
    }

    $m2_pageslides_posts = new WP_Query($m2_args);
    $m2_pageslides = $m2_pageslides_posts->posts;
}

global $globalscripts, $globalscriptcnt;

// Initialize values for Grid options based on checkboxes
$m2_grid_options = [
    'img' => false,
    'head' => false,
    'txt' => false,
    'date' => false,
    'btn' => false,
    'cat' => false
];

$m2_grid_options_init = get_field('m2_grid_options');

if (is_array($m2_grid_options_init)) {
    foreach ($m2_grid_options_init as $option) {
        if (array_key_exists($option, $m2_grid_options)) {
            $m2_grid_options[$option] = true;
        }
    }
}

if ($m2_bgclr != '') {
    $styles .= 'background-color:' . $m2_bgclr . '; ';
}

$mod_class = 'mod mod-m2 ' . $m2_class . ' ' . $m2_fillh;
$params = $params ?? [];
$params['mod_instance'] = rand(0, 1000000);
$mod = '';

if ($m2_hrt) {
    $mod .= '<div class="dp-contain dp-pos:cntr dp-pad:15px:rt dp-pad:15px:lt"><hr class="section-rule"></div>';
}

$mod .= '<!-- Start Slideshow Grid Module -->
<div ' . ($m2_id != '' ? ' id="' . $m2_id . '"' : '') . ' class="'.$mod_class . ' ' . ($m2_fillw  ? '' : ' dp-contain dp-pos:' . $m2_align_mod) . $m2_clmns_fixedw_sm.' mod-default-spacing:' . $m2_spacing . ' " style="' . $styles . '" ' .($m2_fillw ? '' : $m2_fx_type) . ' '.$m2_look.'>';

    $mod.='<div class="'.$m2_clmns_fixedw.$m2_clmns_fixedw_sm.' dp-pos:' . $m2_align_content.'" ' . $m2_fx_type .'">';


if (isset($m2_bgimg['url'])) {
    $m2_img_alt = $m2_bgimg['alt'] ?: $m2_bgimg['title'];
    $mod .= '<img src="' . $m2_bgimg['url'] . '" class="m1_img" style="object-size:cover; object-position:' . $m2_bgimg_algnmnt . '" loading="lazy" alt="' . $m2_img_alt . '" srcset="' . wp_get_attachment_image_srcset($m2_bgimg['id'], 'full') . '">';
}

if ($m2_intro_head . $m2_intro_txt != '') {
    $mod .= '<div class="mod-intro-header ' . $m2_intro_txt_lt . ' '.$m2_intro_algnmnt.' ' . ($m2_intro_pos != '' ? $m2_intro_pos . ':l ' . $m2_intro_pos. ':m' : '') . ' dp-contain dp-pos:' . $m2_align_content . ' ' . $m2_clmns_fixedw_sm . ' mod-default-spacing:' . $m2_intro_spacing .(get_field('m2_intro_txt_lt')? ' mod-txt-lght ' : '').'">
    <div class="mod-head-pos '.$m2_intro_pos.'" '.$m2_intro_max_w.'>';


    $introPadTop = '';
    if($m2_intro_head!=''){
        if ($m2_intro_use_h1) {
            $m2_intro_head = '<h1 class="' . $m2_intro_head_sz . '">' . $m2_intro_head . '</h1>';
        } else {
            $m2_intro_head = '<h2 class="' . $m2_intro_head_sz . '">' . $m2_intro_head . '</h2>';
        }
        
        $mod .= '<div class="mod-intro-title" '.($m2_intro_head_max_w? 'style="max-width:'.$m2_intro_head_max_w.'"':'').'>' . $m2_intro_head . '</div>';
        $introPadTop = ' dp-pad:10px:top ';
    }

    
    if ($m2_intro_txt != '') {
        $mod .= '<div class="mod-txt mod-intro-txt'.$introPadTop. $m2_intro_txt_sz . ' ' . $m2_clmns_fixedw_sm . '"  '.($m2_intro_txt_max_w? 'style="max-width:'.$m2_intro_txt_max_w.'"':'').'>' . ss_add_pclass(apply_filters('the_content', $m2_intro_txt), $m2_intro_txt_sz) . '</div>';
    }
    
    $mod .= '</div></div>';
}

// Check if Slideshow
if (!$m2_grid) {
    $mod_gridslidername = get_field('m2_grid_slider_name');
    $m2_grid_slider_show_dots = get_field('m2_grid_slider_show_dots') == 1 ? 'true' : 'false';
    $m2_grid_slider_show_arrows = get_field('m2_grid_slider_show_arrows') == 1 ? 'true' : 'false';
    $m2_grid_slider_speed = get_field('m2_grid_slider_speed') ?: 9000;
    $m2_autoslide = $m2_autoslide ? 'true' : 'false';
    $dots = 'true';
    $m2_slidecnt = "0";

    if (is_array(get_field('m2_slides')) && count(get_field('m2_slides')) < 2) {
        $dots = 'false';
        $m2_slidecnt = count(get_field('m2_slides'));
    }

    if (is_array(get_field('m2_slides')) && count(get_field('m2_slides')) > 1) {
        $globalscripts .= "
            $('[data-slider-name=\"{$mod_gridslidername}\"]').owlCarousel({
                loop: true,
                margin: 0,
                autoplay: {$m2_autoslide},
                autoplayTimeout: {$m2_grid_slider_speed},
                autoplayHoverPause: ".($m2_slider_pause_on_hov? 'true' : 'false').",
                nav: {$m2_grid_slider_show_arrows},
                dots: {$dots},
                ".($m2_slidev == 'vert'? 
                    "animateOut: 'slideOutUp',
                    animateIn: 'slideInUp'," : "" ) ."
                responsive: {
                    0: { items: 1 },
                    600: { items: 1 },
                    1000: { items: 1 }
                },
                 onInitialized: function(event) {
             
                    $('[data-slider-name=\"{$mod_gridslidername}\"]').find('.owl-prev').attr('aria-label','Previous Slide');
                    $('[data-slider-name=\"{$mod_gridslidername}\"]').find('.owl-next').attr('aria-label','Next Slide');

                    $('[data-slider-name=\"{$mod_gridslidername}\"] .owl-prev').click(function() {
                        $('[data-slider-name=\"{$mod_gridslidername}\"]').attr('data-slide-dir','prev');
                    });

                    $('[data-slider-name=\"{$mod_gridslidername}\"] .owl-next').click(function() {
                        $('[data-slider-name=\"{$mod_gridslidername}\"]').attr('data-slide-dir','next');
                    });

                }
            });";
    }

   


    $m2_size_check_apsect = explode('/',$m2_slider_size);
    $m2_aspect = 'aspect-ratio: auto';
    if(isset($m2_size_check_apsect[1])){
        if($m2_slider_size == ''){
          $m2_slider_size = '16 / 9';
        }
        $m2_aspect = 'aspect-ratio:'.$m2_slider_size.';';
        $m2_init_h =  'height:auto;';
    }
    if($m2_slider_size!='' && !isset($m2_size_check_apsect[1])){
            $m2_init_h =  'min-height:'.$m2_slider_size.';';
    }



    $mod .= '<div class="ss-slideshow ' . $m2_clmns_fixedw_sm.($m2_fillw? "" :" dp-contain ") . '" data-autoslide="' . $m2_autoslide . '"  style="'.$m2_init_h.' '.$m2_aspect.'" data-slidescount="' . $m2_slidecnt . '">
                <div class="bgimgs slide-view">
                    <div class="ss-slides nobull owl-carousel owl-theme ' . ($m2_grid_slider_show_dots == 'true' ? '' : ' hide-dots ') . ' '. $m2_post_txt_lt.'" data-slider-name="' . $mod_gridslidername .'">';

    // Explicitly Slides
    if (have_rows('m2_slides') && !get_field('m2_usepages')) {
        $slidecount = 0;

        while (have_rows('m2_slides')) : the_row();
            $params['txt_lt'] = '';
            $params['styles'] = '';
            $params['slidecount'] = $slidecount;
            $params['slidetype'] = 'img';
            $params['m2_autoplay'] = get_sub_field('m2_autoplay');
            $params['m2_head'] = get_sub_field('m2_head');
            $params['m2_use_h1'] = get_sub_field('m2_use_h1');
            $m2_noformat = get_sub_field('m2_noformat');

            add_filter('acf_the_content', 'wpautop');
            if ($m2_noformat) {
                $m2_txt = get_sub_field('m2_txt');
                $m2_txt = do_blocks($m2_txt);
                $m2_txt = str_replace(['<br/>', '<p>', '</p>', '<p> </p>'], '', $m2_txt);
                $params['m2_txt'] = $m2_txt;
            } else {
                $params['m2_txt'] = get_sub_field('m2_txt');
            }

            $params['m2_subtitle'] = get_sub_field('m2_subtitle');
            $params['m2_bgimg'] = get_sub_field('m2_img');
            $params['m2_bgimg_sz'] = get_sub_field('m2_bgimg_sz');
            $params['m2_bgclr'] = get_sub_field('m2_bgclr');
            $params['m2_fitimg'] = get_sub_field('m2_fitimg');
            $params['m2_slide_tint'] = get_sub_field('m2_slide_tint');
            $params['m2_slide_txt_lt'] = get_sub_field('m2_slide_txt_lt') ? 'mod-txt-lght' : '';
            $params['m2_item_head_sz'] = $m2_item_head_sz;
            $params['m2_item_subhead_sz'] = $m2_item_subhead_sz;
            $params['m2_item_p_sz'] = $m2_item_p_sz;
            $params['m2_align_content'] = get_sub_field('m2_align_content'); // content
            $params['m2_slide_algnmnt'] = get_sub_field('m2_slide_algnmnt'); // image
            $params['m2_txt_algnmnt'] = get_sub_field('m2_txt_algnmnt'); // text
            $params['m2_usevid'] = get_sub_field('m2_usevid');
            $params['m2_vidid'] = get_sub_field('m2_vidid');
            $params['m2_btn_lead'] = get_sub_field('m2_btn_lead');
            $params['m2_btn'] = get_sub_field('m2_btn');
            $params['m2_use_url'] = get_sub_field('m2_use_url');
            $params['m2_url'] = get_sub_field('m2_url');
            $params['m2_new_win'] = get_sub_field('m2_new_win');
            $params['m2_lnk'] = get_sub_field('m2_lnk');
            $params['m2_blocklink'] = get_sub_field('m2_blocklink');
            $params['m2_btn_rev'] = get_sub_field('m2_btn_rev');
            $params['m2_btn_txt'] = get_sub_field('m2_btn_txt');
            $params['m2_txt_lt'] = get_sub_field('m2_txt_lt');
            $params['m2_slide_class'] = get_sub_field('m2_slide_class');
            $params['m2_img_tag'] = get_sub_field('m2_img_tag');
            $params['m2_slide_pos'] = get_sub_field('m2_slide_pos');
            $params['m2_spacing'] = get_sub_field('m2_spacing');
            $params['m2_lazy'] = get_sub_field('m2_lazy');

            if (get_sub_field('event_link') && get_sub_field('event_link') != '') {
                $params['m2_rsvp'] = get_sub_field('event_link');
            }

            $mod .= ss_setslide($params);
            $slidecount++;
        endwhile;
    }

    // Selected Pages
    if ($m2_usepages && $m2_pageslides > 0) {
        $slidecount = 0;

        foreach ($m2_pageslides as $slideid):
            $params['txt_lt'] = '';
            $params['styles'] = '';
            $params['m2_id'] =$slideid;
            $params['slidecount'] = $slidecount;
            $params['slidetype'] = 'img';
            $m2_leadin = get_field('m2_leadin', $slideid);
            $slide_head = get_field('slide_head', $slideid);
            $slide_txt = get_field('slide_txt', $slideid);
            $slide_img = get_field('slide_img', $slideid);
            $slide_alignment = get_field('slide_alignment', $slideid);
            $slide_txt_alignmnt = get_field('slide_txt_alignmnt', $slideid);
            $params['m2_slide_tint'] = get_sub_field('m2_slide_tint');
            $params['m2_slide_txt_lt'] = get_sub_field('m2_slide_txt_lt') ? 'mod-txt-lght' : '';
            $params['m2_item_leadin_sz'] = $m2_item_leadin_sz;
            $params['m2_item_shead_sz'] = $m2_item_head_sz;
            $params['m2_item_p_sz'] = $m2_item_p_sz;
            $params['m2_use_h1'] = get_sub_field('m2_use_h1');
            $params['m2_subtitle'] = get_sub_field('m2_subtitle');
            $params['m2_align_content'] = get_sub_field('m2_align_content'); // content
            $params['m2_slide_algnmnt'] = get_sub_field('m2_slide_algnmnt'); // image
            $params['m2_txt_algnmnt'] = get_sub_field('m2_txt_algnmnt'); // text
            $params['m2_slide_pos'] = get_sub_field('m2_slide_pos');
            $params['m2_lazy'] = get_sub_field('m2_lazy');
            $params['m2_btn_rev'] = get_sub_field('m2_btn_rev');

            if ($slide_head != '') {
                $params['m2_head'] = $slide_head;
            } elseif (get_field('m2_head', $slideid) != '') {
                $params['m2_head'] = get_field('m2_head', $slideid);
            } else {
                $params['m2_head'] = ss_displayTitle($slideid);
            }

            if ($slide_txt != '') {
                $params['m2_txt'] = $slide_txt;
            } elseif (get_field('m2_txt', $slideid) != '') {
                $params['m2_txt'] = get_field('m2_txt', $slideid);
            } else {
                $params['m2_txt'] = ss_trimexcerpt(ss_get_excerpt_by_id($slideid), '', 100);
            }

            if ($slide_img != '') {
                $params['m2_bgimg'] = $slide_img;
            } elseif (get_field('m2_img', $slideid) != '') {
                $params['m2_bgimg'] = get_field('m2_img', $slideid);
            } else {
                $thumsize = 'large';
                $slidefeatimg = wp_get_attachment_image_src(get_post_thumbnail_id($slideid), $thumsize);
                $params['m2_bgimg'] = $slidefeatimg[0];
            }

            $params['m2_postdate'] = get_the_date('m.j.y', $slideid);
            $params['m2_fitimg'] = get_sub_field('m2_fitimg');
            $params['m2_img_tag'] = get_sub_field('m2_img_tag');
            $params['m2_align_content'] = $slide_txt_alignmnt != '' ? $slide_txt_alignmnt : $m2_slide_algnmnt_default;
            $params['m2_slide_algnmnt'] = get_field('m2_slide_algnmnts', $slideid) != '' ? get_field('m2_slide_algnmnt', $slideid) : $m2_slide_algnmnt_default;
            $params['m2_txt_lt'] = get_field('m2_txt_lt', $slideid);
            $params['m2_usepages'] = $m2_usepages;
            $params['m2_grid_options'] = $m2_grid_options;

            if ($m2_grid_options['btn']) {
                $params['m2_btn_txt'] = get_field('m2_grid_options_btntxt');
            }

            $params['m2_usevid'] = get_sub_field('m2_usevid', $slideid);
            $params['m2_vidid'] = get_sub_field('m2_vidid', $slideid);

            if (get_sub_field('event_link') && get_sub_field('event_link') != '') {
                $params['m2_rsvp'] = get_sub_field('event_link');
            }

            $mod .= ss_setslide($params);
            $slidecount++;
        endforeach;
    }

   

    $mod .= '</div>
            </div>
           </div>';
}

// Start Grid Check
if ($m2_grid) {
    $mod .= '<div class="' . (!$m2_fillw ? ' ' . $m2_fillw . ' ' : ' ') . ' dp-contain dp-pos:' . $m2_align_content . ' ' . $m2_clmns_fixedw_sm . '">';

    $params['m2_grid_clmns'] = get_field('m2_grid_clmns') ?: '1';
    $params['m2_grid_clmns_tab'] = get_field('m2_grid_clmns_tab') ?: '1';
    $params['m2_grid_clmns_mob'] = get_field('m2_grid_clmns_mob') ?: $params['m2_grid_clmns_tab'];
    $params['m2_txt'] = get_sub_field('m2_txt');
    $m2_clmn_gutter = get_field('m2_clmn_gutter');
    $m2_clmn_gutter_slider = $m2_clmn_gutter;
    $m2_clmn_gutter_tab = get_field('m2_clmn_gutter_tab');
    $m2_clmn_gutter_mob = get_field('m2_clmn_gutter_mob');

    if ($m2_clmn_gutter != '') {
        $m2_clmn_gutter = ' dp-gutter:' . $m2_clmn_gutter;
    }

    if ($m2_clmn_gutter_tab != '') {
        $m2_clmn_gutter_tab = ' dp-gutter:' . $m2_clmn_gutter_tab . ':m';
    }

    if ($m2_clmn_gutter_mob != '') {
        $m2_clmn_gutter_mob = ' dp-gutter:' . $m2_clmn_gutter_mob . ':s dp-gutter:' . $m2_clmn_gutter_mob . ':xs ';
    }

    $numlist = get_field('m2_numblst') ? 'numblist' : '';

    if ($m2_grid_slider) {
        $mod_gridslidername = get_field('m2_grid_slider_name');
        $m2_grid_slider_show_dots = get_field('m2_grid_slider_show_dots') == 1 ? 'true' : 'false';
        $m2_grid_slider_show_arrows = get_field('m2_grid_slider_show_arrows') == 1 ? 'true' : 'false';
        $m2_grid_slider_speed = get_field('m2_grid_slider_speed') ?: 9000;
        $m2_autoslide = $m2_autoslide ? 'true' : 'false';
        $owlmargin = (int)$m2_clmn_gutter_slider;

        if ($owlmargin > 20) {
            if ($owlmargin == 50) {
                $owlmargin = ($owlmargin / 100) * ((int)get_field('dp-site-padding', 'options'));
            }
        }

        $globalscripts = "
            $('[data-slider-name=\"{$mod_gridslidername}\"]').owlCarousel({
                loop: true,
                margin: {$owlmargin},
                autoplay: {$m2_autoslide},
                autoplayTimeout: {$m2_grid_slider_speed},
                autoplayHoverPause: ".($m2_slider_pause_on_hov ? 'true' : 'false').",
                nav: {$m2_grid_slider_show_arrows},
                dots: 'true',
                responsive: {
                    0: { items: {$params['m2_grid_clmns_mob']} },
                    600: { items: {$params['m2_grid_clmns_tab']} },
                    1000: { items: {$params['m2_grid_clmns']} }
                },
                onInitialized: function(event) {
                    console.log('initialize');
                    $('[data-slider-name=\"{$mod_gridslidername}\"]').find('.owl-prev').attr('aria-label','Previous Slide');
                    $('[data-slider-name=\"{$mod_gridslidername}\"]').find('.owl-next').attr('aria-label','Next Slide');

                }
            });

           
            ";

    }

    $sitemcnt = 0;
    if (get_field('m2_slides') && is_array(get_field('m2_slides'))) {
        $sitemcnt = count(get_field('m2_slides'));
    }
    if ($m2_usepages && is_array($m2_usepages)) {
        $sitemcnt = count($m2_usepages);
    }
    if ($m2_pageslides && is_array($m2_pageslides)) {
        $sitemcnt = count($m2_pageslides);
    }

    $mod .= '<div ' . ($m2_grid_slider ? ' data-slider-name="' . $mod_gridslidername . '" data-grid-sz="' . $params['m2_grid_clmns'] . '" data-gutter="' . $m2_clmn_gutter . ':l ' . $m2_clmn_gutter_tab . ':m ' . $m2_clmn_gutter_mob . '" data-slcnt="' . $sitemcnt . '" class=" owl-carousel owl-theme ' . $mod_gridslidername . ' ' . ($m2_grid_slider_show_dots == 'true' ? '' : ' hide-dots ') . '"' : ' data-slidecnt="' . $sitemcnt . '" class="' . $m2_clmn_gutter . ' ' . $m2_clmn_gutter_tab . ' ' . $m2_clmn_gutter_mob . ' dp-grid:fit:' . $params['m2_grid_clmns'] . ':l ' . ($params['m2_grid_clmns_tab'] != '' ? ' dp-grid:fit:' . $params['m2_grid_clmns_tab'] . ':m ' : ' dp-grid:fit:' . ceil($params['m2_grid_clmns'] / 2) . ':m ') . ($params['m2_grid_clmns_tab'] != '' ? ' dp-grid:fit:' . $params['m2_grid_clmns_tab'] . ':s ' : ' dp-grid:fit:' . ceil($params['m2_grid_clmns'] / 2) . ':s ') . ($params['m2_grid_clmns_mob'] != '' ? ' dp-grid:fit:' . $params['m2_grid_clmns_mob'] . ':xs ' : 'dp-grid:xs:fit:1:xs ') . $numlist . ' mod-grid '.($m2_grid_clmns_masonary && !$m2_grid_slider ? 'masonary-grid':'').' dp-flex:align:' . $m2_align_content . ' ' .$m2_post_txt_lt. ($m2_clmns_fixedw ? ' dp-contain dp-pos:cntr' : '') . '').'" '.$m2_fx_grid_type.'>';

    if($m2_grid_clmns_masonary && !$m2_grid_slider){
        $mod .= '<div class="grid-sizer"></div>';
    }

    // Explicitly Slides
    if (have_rows('m2_slides') && (!$m2_usepages)) {
        while (have_rows('m2_slides')) : the_row();
            $params['txt_lt'] = '';
            $params['styles'] = '';
            $params['slidecount'] = '';
            $params['slidetype'] = 'img';
            $params['m2_leadin'] = get_sub_field('m2_leadin');
            $params['m2_head'] = get_sub_field('m2_head');
            $params['m2_subtitle'] = get_sub_field('m2_subtitle');
            $params['m2_use_h1'] = get_sub_field('m1_use_h1');
            $params['m2_txt'] = get_sub_field('m2_txt');
            $params['m2_noformat'] = get_sub_field('m2_noformat');
            $params['m2_txt_algnmnt'] = get_sub_field('m2_txt_algnmnt');
            $params['m2_txtovrImg'] = get_sub_field('m2_txtovrImg');
            $params['m2_bgimg'] = get_sub_field('m2_img');
            $params['m2_bgimg_sz'] = get_sub_field('m2_bgimg_sz');
            $params['m2_bgclr'] = get_sub_field('m2_bgclr');
            $params['m2_fitimg'] = get_sub_field('m2_fitimg');
            $params['m2_align_content'] = get_sub_field('m2_align_content');
            $params['m2_txt_lt'] = get_sub_field('m2_txt_lt');
            $params['m2_img_tag'] = get_sub_field('m2_img_tag');
            $params['m2_slide_pos'] = get_sub_field('m2_slide_pos');
            $params['m2_slide_txt_lt'] = get_sub_field('m2_slide_txt_lt') ? 'mod-txt-lght' : '';
            $params['m2_item_head_sz'] = $m2_item_head_sz;
            $params['m2_item_subhead_sz'] = $m2_item_subhead_sz;
            $params['m2_item_p_sz'] = $m2_item_p_sz;
            $params['m2_usevid'] = get_sub_field('m2_usevid');
            $params['m2_vidid'] = get_sub_field('m2_vidid');
            $params['m2_btn_lead'] = get_sub_field('m2_btn_lead');
            $params['m2_btn'] = get_sub_field('m2_btn');
            $params['m2_use_url'] = get_sub_field('m2_use_url');
            $params['m2_url'] = get_sub_field('m2_url');
            $params['m2_blocklink'] = get_sub_field('m2_blocklink');
            $params['m2_new_win'] = get_sub_field('m2_new_win');
            $params['m2_lnk'] = get_sub_field('m2_lnk');
            $params['m2_btn_rev'] = get_sub_field('m2_btn_rev');
            $params['m2_btn_txt'] = get_sub_field('m2_btn_txt');
            $params['m2_slide_class'] = get_sub_field('m2_slide_class');
            $params['m2_spacing'] = get_sub_field('m2_spacing');
            $params['m2_lazy'] = get_sub_field('m2_lazy');

            if (get_sub_field('event_link') && get_sub_field('event_link') != '') {
                $params['m2_rsvp'] = get_sub_field('event_link');
            }

             $mod .= ss_setitem($params);
        endwhile;
    }

    // Selected Pages
    if ($m2_usepages && $m2_pageslides!='' && count($m2_pageslides) > 0) {

        foreach ($m2_pageslides as $m2_slide) {
            
            $slideid = $m2_slide->ID;
            $params['txt_lt'] = '';
            $params['styles'] = '';
            $postype = get_post($slideid);
            $params['slidetype'] = $m2_slide->post_type;
            $params['m2_leadin'] = get_field('m2_leadind', $slideid) ?: '';
            $params['m2_id'] = $slideid;
            $params['m2_head'] = htmlspecialchars_decode(get_the_title($slideid));

            if (get_field('m2_txt', $slideid) != '') {
                $params['m2_txt'] = get_field('m2_txt', $slideid);
            } else {
                $params['m2_txt'] = ss_trimexcerpt(ss_excerpt_by_id($slideid), '', 100);
                if ($params['m2_txt'] == '') {
                    $params['m2_txt'] = ss_trimexcerpt(ss_get_content($slideid), '', $m2_item_p_limit ?: 200);
                }
            }

            $params['m2_bgimg'] = wp_get_attachment_image_src(get_post_thumbnail_id($slideid), 'medium');
            $params['m2_subtitle'] = get_sub_field('m2_subtitle');
            $params['m2_postdate'] = get_the_date($m2_pageslides_posttype == 'event' ? 'n.j' : 'F jS, Y', $slideid);
            $params['m2_txtovrImg'] = get_sub_field('m2_txtovrImg');
            $params['m2_usepages'] = $m2_usepages;
            $params['m2_grid_options'] = $m2_grid_options;
            $params['m2_txt_algnmnt'] = get_sub_field('m2_txt_algnmnt');
            $params['m2_fitimg'] = get_sub_field('m2_fitimg');
            $params['m2_align_content'] = get_sub_field('m2_align_content');
            $params['m2_txt_lt'] = get_field('slide_txt_lt', $slideid);
            $params['m2_img_tag'] = get_sub_field('m2_img_tag');
            $params['m2_slide_txt_lt'] = get_sub_field('m2_slide_txt_lt') ? 'mod-txt-lght' : '';
            $params['m2_item_head_sz'] = $m2_item_head_sz;
            $params['m2_item_subhead_sz'] = $m2_item_subhead_sz;
            $params['m2_item_p_sz'] = $m2_item_p_sz;
            $params['m2_usevid'] = get_sub_field('m2_usevid', $slideid);
            $params['m2_vidid'] = get_sub_field('m2_vidid', $slideid);
            $params['m2_spacing'] = get_sub_field('m2_spacing',$slideid);
            $params['m2_slide_class'] = get_field('portfolio_cnr_thmb', $slideid) ? ' cntrthumb ' : '';
            $params['m2_btn'] = true;
            $params['m2_use_url'] = false;
            $params['m2_lnk'] = get_permalink($slideid);
            $params['m2_btn_rev'] = get_sub_field('m2_btn_rev');
            $params['m2_new_win'] = get_sub_field('m2_new_win');

            if ($params['slidetype'] == 'review') {
                $params['starnum'] = get_field('stars', $slideid);
                $params['m2_postdate'] = get_field('date', $slideid);
                $params['m2_url'] = get_field('link', $slideid);
                $params['m2_new_win'] = true;
                $params['m2_use_url'] = true;
            }

            if ($m2_grid_options['btn']) {
                $m2_gridbtntxt = get_field('m2_grid_options_btntxt');
                if($m2_gridbtntxt==''){
                    $m2_gridbtntxt = 'View More';
                }
                $params['m2_btn_txt'] = $m2_gridbtntxt;
            }

            $params['m2_use_h1'] = get_sub_field('m2_use_h1');
            $params['m2_lazy'] = get_sub_field('m2_lazy');

            if (get_field('event_link', $slideid) && get_field('event_link', $slideid) != '') {
                $params['m2_rsvp'] = get_field('event_link', $slideid);
            }

            $categories = get_the_terms($slideid, 'category', 'orderby=count&hide_empty=0');
            if(isset($categories[0])){
                $category_name = isset($categories[0]->name) && $categories[0]->name != 'uncategorized' ? $categories[0]->name : 'General';
                $params['m2_cat'] = $category_name;
            }

             $mod .= ss_setitem($params); 
        }
    }

    $mod .= '</div><!-- End Grid blocks-->
            </div><!-- End Container-->';
}


       $mod .= '</div>';/* End Content container */
    

if ($m2_txt_post != '') {
    $mod .= '<div class="dp-pad:25pc:bot:xs dp-pad:100px:top:xs dp-pad:50pc:bot dp-pad:50pc:top post-text ' . $m2_align_content . ' ' . $txt_lt . ' mod-default-spacing:' . $m2_spacing . '">
                <div class="mod-txt">' . ss_add_pclass(apply_filters('the_content', $m2_txt_post), null) . '</div>
            </div>';
}

$mod .= '</div>



<!-- End Module-->';
 $mod .= '<!--custom pagination '.getcwd().'-->';




if($m2_hrb){
        $mod .='<div class="dp-contain dp-pos:cntr dp-pad:15px:rt dp-pad:15px:lt"><hr class="section-rule"></div>';
    }


if(!get_field('m2_deactivate')){
   echo $mod;
    
    if($m2_pageslides_post_lmt!='' ){
        echo  '<!--custom pagination file-->';

        $page_incr =5;

        $results_per = $m2_pageslides_post_lmt;
        if(isset($_GET['pg'])){
            $pagenum = $_GET['pg'];
        }
        else{
            $pagenum = 1;
        }

        $results_page=$pagenum;
        $results_total = $m2_pageslides_posts->found_posts;

        include __DIR__ . '/mod_m2_pagination.php';
    }
}
else{
    echo '';
}
?>