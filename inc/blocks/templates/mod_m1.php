<?php
$styles = '';
$m1_bgimg = '';
$m1_rowcnt = 0;
$m1_fx_type = '';

// Content
$m1_intro_head = get_field('m1_intro_head');
$m1_intro_use_h1 = get_field('m1_intro_use_h1');
$m1_intro_txt = get_field('m1_intro_txt');

// Style
$m1_look = get_field('m1_look');
$m1_look = $m1_look ? ' data-look="'.$m1_look.'"' : '';
$m1_fx = get_field('m1_fx');
$m1_fx_type = $m1_fx ? ' data-fx="' . $m1_fx . '"' : '';
$m1_usevid = get_field('m1_usevid');
$m1_clmn_bgimg_tint = get_field('m1_bgimg_tint');
$m1_bgimg = get_field('m1_bgimg');
$m1_bgimg_mob = get_field('m1_bgimg_mob');
$m1_txt_lt = get_sub_field('m1_txt_lt');
$m1_clmn_lazy = get_field('m1_lazy');
$m1_clmn_fetchpriority = get_field('m1_fetchpriority');
$m1_intro_txt_lt = get_field('m1_intro_txt_lt');
$m1_bgimg_alignmnt = get_field('m1_bgimg_alignmnt');
$m1_imgtach = get_field('m1_imgtach');
$m1_bgclr = get_field('m1_bgclr');
$m1_hrt = get_field('m1_hrt');
$m1_hrb = get_field('m1_hrb');
$m1_id = get_field('m1_clmns_id');
$m1_clmns_class = get_field('m1_clmns_class');

// Formatting
$m1_intro_head_sz = get_field('m1_intro_head_sz');
$m1_intro_txt_sz = get_field('m1_intro_txt_sz');
$m1_intro_max_w = get_field('m1_intro_max_w');
$m1_intro_max_w = $m1_intro_max_w ? 'style="max-width:'.$m1_intro_max_w.'"':'';
$m1_intro_algnmnt = get_field('m1_intro_algnmnt');
$m1_intro_spacing = get_field('m1_intro_spacing');
$m1_intro_pos = get_field('m1_intro_pos');
$m1_align_mod = get_field('m1_align_mod');
$m1_align_content = get_field('m1_align_content');
$m1_no_valign = get_field('m1_no_valign');
$m1_fillw = get_field('m1_fillw');
$m1_clmns_fixedw = get_field('m1_clmns_fixedw') ? ' dp-contain ' : ' ';
$m1_clmns_fixedw_sm = get_field('m1_clmns_fixedw_sm') ? ' mod-contain-sm ' : ' ';
$m1_clmn_max_w = get_field('m1_clmn_max_w');
$m1_clmn_num = get_field('m1_clmn_num') ?: '1';
$m1_clmn_num_tab = get_field('m1_clmn_num_tab') ?: $m1_clmn_num;
$m1_clmn_num_mob = get_field('m1_clmn_num_mob') ?: '1';
$m1_clmn_gutter = get_field('m1_clmn_gutter');
$m1_clmn_gutter_tab = get_field('m1_clmn_gutter_tab');
$m1_clmn_gutter_mob = get_field('m1_clmn_gutter_mob');
$m1_clmn_rev_tab = get_field('m1_clmn_rev_tab');
$m1_clmn_rev_mob = get_field('m1_clmn_rev_mob');
$m1_clmn_size = get_field('m1_clmn_size');



if($m1_clmn_max_w !=""){
        $styles.=' max-width:'.$m1_clmn_max_w.'; ';
}

if (is_array(get_field('m1_clmns')) && get_field('m1_clmns') != '') {
    count(get_field('m1_clmns'));
}

if ($m1_clmn_lazy) {
    $m1_clmn_lazy = ' loading="lazy" ';
}

   if ($m1_clmn_fetchpriority) {
        $m1_clmn_fetchpriority = ' fetchpriority="high" ';
    }

if ($m1_clmn_gutter != '') {
    $m1_clmn_gutter = ' dp-gutter:' . $m1_clmn_gutter;
}

if ($m1_clmn_gutter_tab != '') {
    $m1_clmn_gutter_tab = ' dp-gutter:' . $m1_clmn_gutter_tab . ':m';
}

if ($m1_clmn_gutter_mob != '') {
    $m1_clmn_gutter_mob = ' dp-gutter:' . $m1_clmn_gutter_mob . ':xs dp-gutter:' . $m1_clmn_gutter_mob . ':s';
}


$spacing_class = ' mod-default-spacing:' . get_field('m1_clmn_spacing') . ' ';
$m1_align_content = !$m1_align_content || $m1_align_content == '' ? 'cntr' : $m1_align_content;


if ($m1_usevid && $m1_usevid == true) {
    $vid = get_field('m1_vid_id');
    $type = is_numeric($vid);
    if ($type == 1) {
        $hash = file_get_contents("http://vimeo.com/api/v2/video/" . $vid . ".xml");
        $hash = simplexml_load_string($hash);
        $m1_bgimg = $hash[0]->video->thumbnail_large;
        $m1_bgimg = 'https://img.youtube.com/vi/' . $vid . '/maxresdefault.jpg';
    }
}

$bg_imgW = '768';
$bg_imgH = '1365';

if (isset($m1_bgimg['url']) && function_exists('getimagesize') && file_exists($m1_bgimg['url'])) {
    if ($m1_bgimg['url']) {
        list($bg_imgW, $bg_imgH) = getimagesize($m1_bgimg['url']);
    }
}

if ($m1_bgclr != '') {
    $styles .= 'background-color:' . $m1_bgclr . '; ';
}


if ($m1_txt_lt != '') {
    $m1_txt_lt = 'mod-txt-lght';
}

if ($m1_usevid && $m1_usevid == true) {
    $m1_clmns_class .= ' has-video ';
}

if ($m1_clmn_size != '') {
    $m1_clmn_size = 'colmn_sz_' . $m1_clmn_size;
}


$mod = '';

if ($m1_hrt) {
    $mod .= '<div class="dp-contain dp-pos:cntr dp-pad:15px:rt dp-pad:15px:lt"><hr class="section-rule"></div>';
}

$mod .= '
<!-- Start Columned Text Module -->
<div ' . ($m1_id != '' ? ' id="' . $m1_id . '"' : '') . ' class="' . ($m1_usevid && $m1_usevid == true ? ' video-mantle ' : '') . 'mod mod-m1 ' . $m1_clmns_class . ' ' . $spacing_class . ' ' . ($m1_fillw ? '' : ' dp-contain dp-pos:'.$m1_align_mod) . ' ' . ($m1_clmn_rev_mob ? ' clmn-rev-mob ' : '') . ' ' . ($m1_clmn_rev_tab ? ' clmn-rev-tab ' : '') . '" ' . ($styles != '' ? 'style="' . $styles . '"' : '') . ' '.$m1_look.'>';


$mod.='<div class="dp-pos:' . $m1_align_content . ' ' . $m1_clmns_fixedw_sm . $m1_clmns_fixedw . '" ' . $m1_fx_type . '>';


if (isset($m1_bgimg['url'])) {
    $m1_img_alt = $m1_bgimg['alt'];
    if ($m1_img_alt == '') {
        $m1_img_alt = $m1_bgimg['title'];
    }




    if ($m1_imgtach != 'fixed') {
        if ($m1_bgimg_mob != '') {
            $mod .= '<img src="' . $m1_bgimg['url'] . '" class="m1_img dp-display:above:m ' . $m1_imgtach . ' " style="object-size:cover; object-position:' . $m1_bgimg_alignmnt . '" ' . $m1_clmn_lazy . ' '.$m1_clmn_fetchpriority.' alt="' . $m1_img_alt . '" srcset="' . wp_get_attachment_image_srcset($m1_bgimg['id'], 'full') . '" width="350" height="300">';
            $mod .= '<img src="' . $m1_bgimg_mob['url'] . '" class="m1_img dp-display:below:m ' . $m1_imgtach . ' " style="object-size:cover; object-position:' . $m1_bgimg_alignmnt . '" ' . $m1_clmn_lazy . ' alt="' . $m1_img_alt . '" srcset="' . wp_get_attachment_image_srcset($m1_bgimg_mob['id'], 'full') . '" width="350" height="300" ' . ($m1_imgtach == 'parallax' ? 'data-parallax="1" data-bgimage="1"  data-img-width="' . $bg_imgW . '" data-img-height="' . $bg_imgH . '"' : '') . '>';
        } else {
            $mod .= '<img src="' . $m1_bgimg['url'] . '" class="m1_img ' . $m1_imgtach . ' " style="object-size:cover; object-position:' . $m1_bgimg_alignmnt . '" ' . $m1_clmn_lazy . ' alt="' . $m1_img_alt . '" srcset="' . wp_get_attachment_image_srcset($m1_bgimg['id'], 'full') .'" '.($m1_imgtach == 'parallax' ?  ' data-parallax="img" data-bgimage="1"  data-img-width="' . $bg_imgW . '" data-img-height="' . $bg_imgH. '"' : '') . '>';
        }
    } else {
        $mod .= '<div class="m1_img ' . $m1_imgtach . ' " style="background-attachment: fixed; background-image:url(' . $m1_bgimg['url'] . ');" alt="' . $m1_img_alt . '" ></div>';
    }
}

if ($m1_usevid && $m1_usevid == true) {
    $mod .= '<div class="bg-video" data-diff="100" data-tpspeed="fixed" data-zoom="1" data-img-height="' . $bg_imgH . '" data-img-width="' . $bg_imgW . '">';
    $type = is_numeric($vid);
    if ($type == 1) {
        $mod .= '  <iframe id="vimeo-vid-' . $vid . '" class="vimeo-frame autoplay project-video" src="https://player.vimeo.com/video/' . $vid . '?api=1&autoplay=1&background=1&playsinline=0&muted=1&player_id=vimeo-vid-' . $vid . '" width="100%" height="100%" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    } else {
        $mod .= '<div id="video-placeholder-' . $vid . ' class="youtube-vid" data-vidid="' . $vid . '"></div> ';
    }
    $mod .= ' </div>';
}

if ($m1_clmn_bgimg_tint != '') {
    $mod .= '<div class="mod-bg-tint" style="background-color:' . $m1_clmn_bgimg_tint . '"></div>';
}

if ($m1_intro_head . $m1_intro_txt != '') {
    $mod .= '<div class="' . ($m1_intro_txt_lt ? ' mod-txt-lght ' : '') .'">
                <div class="mod-intro-header mod-default-spacing:' . $m1_intro_spacing . ' ' . $m1_intro_algnmnt . '">
                <div class="mod-head-pos '.$m1_intro_pos.'" '.$m1_intro_max_w.'>';

    $introPadTop = '';
    if ($m1_intro_head != '') {
        if ($m1_intro_use_h1) {
            $m1_intro_head = '<h1 class="' . $m1_intro_head_sz . ' ">' . $m1_intro_head . '</h1>';
        } else {
            $m1_intro_head = '<h2 class="' . $m1_intro_head_sz . '">' . $m1_intro_head . '</h2>';
        }
        $mod .= '<div class="mod-intro-title">' . $m1_intro_head . '</div>';
        $introPadTop = ' dp-pad:10px:top ';
      
    }
    if ($m1_intro_txt != '' && strlen(strip_tags($m1_intro_txt)) > 1) {
        $mod .= '<div class="mod-intro-txt '.$m1_intro_txt_sz . ' ' . $introPadTop . '">' . apply_filters('the_content', $m1_intro_txt) . '</div>';
    }
    $mod .= '</div>
            </div>
            </div>';
}

if (have_rows('m1_clmns')) {
    $mod .= '<div class="m1-rows">
                <div class=" mod-grid mod-rowcnt-' . $m1_rowcnt . ' ' . $m1_clmn_gutter . ' ' . $m1_clmn_gutter_tab . ' ' . $m1_clmn_gutter_mob . ' ' . ($m1_clmn_num != '' && $m1_clmn_num != 'auto' ? 'dp-grid:fit:' . $m1_clmn_num . ':l ' : '') . ' ' . ($m1_clmn_num_tab != '' && $m1_clmn_num_tab != 'auto' ? 'dp-grid:fit:' . $m1_clmn_num_tab . ':m ' : '') . ' ' . ($m1_clmn_num_mob != '' && $m1_clmn_num_mob != 'auto' ? 'dp-grid:fit:' . $m1_clmn_num_mob . ':s dp-grid:fit:' . $m1_clmn_num_mob . ':xs ' : '') .' ' . ($m1_no_valign ? ' dp-flex:valign:top ' : '') . ' ' . $m1_clmn_size . ' ">';

    while (have_rows('m1_clmns')) : the_row();
        $m1_noformat = get_sub_field('m1_noformat');
        $m1_form = get_sub_field('m1_form');
        $m1_bgimg = get_sub_field('m1_bgimg');
        $m1_bgimg_mob = get_sub_field('m1_bgimg_mob');
        $m1_bgimg_sz = get_sub_field('m1_bgimg_sz');
        $m1_bgimg_alignmnt = get_sub_field('m1_bgimg_alignmnt');
        $m1_bgclr = get_sub_field('m1_bgclr');
        $m1_imgtach = get_sub_field('m1_imgtach');
        $m1_class = " " . get_sub_field('m1_class') . " ";
        $m1_usevid = get_sub_field('m1_usevid');
        $m1_bgimg_tint = get_sub_field('m1_bgimg_tint');
        $m1_btn = get_sub_field('m1_btn');
        $m1_nomarg = get_sub_field('m1_nomarg');
        $m1_nopad = get_sub_field('m1_nopad');
        $m1_pos = get_sub_field('m1_pos');
        $m1_head = get_sub_field('m1_head');
        $m1_head_sz = get_sub_field('m1_head_sz');
        $m1_p_sz = get_sub_field('m1_p_sz');
        $m1_txt_algnmnt = get_sub_field('m1_txt_algnmnt');
        $m1_use_h1 = get_sub_field('m1_use_h1');
        $m1_valign = get_sub_field('m1_valign');
        $m1_bleed = get_sub_field('m1_bleed');
        $m1_img_algnmnt = get_sub_field('m1_img_algnmnt');
        $m1_spacing = get_sub_field('m1_spacing');
        $m1_clmn_max_w = get_sub_field('m1_clmn_max_w');
        $m1_clmn_w_dsktp = get_sub_field('m1_clmn_w_dsktp');
        $m1_clmn_w_tab = get_sub_field('m1_clmn_w_tab');
        $m1_clmn_w_mob = get_sub_field('m1_clmn_w_mob');
        $m1_id = get_sub_field('m1_id');
        $m1_btn_rev = get_sub_field('m1_btn_rev');
        $m1_btn_alt = get_sub_field('m1_btn_alt');
        $m1_btn_class = get_sub_field('m1_btn_class');
        $m1_use_popup = get_sub_field('m1_use_popup');
        $m1_popup_code = get_sub_field('m1_popup_code');
        $m1_fx = get_sub_field('m1_fx');
        $m1_fx_type = $m1_fx ? ' data-fx="' . $m1_fx . '"' : '';
        $m1_expand = get_sub_field('m1_expand');
        $m1_expand_cta = get_sub_field('m1_expand_cta');
        $m1_bgimg_tint = get_sub_field('m1_bgimg_tint');
        $m1_mod_rule = get_sub_field('m1_mod_rule');
        $m1_gutter_class = '';
        $m1_lazy = get_sub_field('m1_lazy');
        $m1_fetchpriority =get_field('m1_fetchpriority');

        $m1_texthaslink = false;

        if ($m1_lazy) {
            $m1_lazy = ' loading="lazy" ';
        }

        if ($m1_fetchpriority) {
            $m1_fetchpriority = ' fetchpriority="high" ';
        }

        if ($m1_valign != '') {
            $m1_valign = 'dp-flex:valign:' . $m1_valign;
        }

        if ($m1_clmn_w_dsktp) {
            $m1_gutter_class .= ' dp-grid:' . $m1_clmn_w_dsktp . ':l ';
        }
        if ($m1_clmn_w_tab) {
            $m1_gutter_class .= ' dp-grid:' . $m1_clmn_w_tab . ':m ';
        }
        if ($m1_clmn_w_mob) {
            $m1_gutter_class .= ' dp-grid:' . $m1_clmn_w_mob . ':s ';
        }

        add_filter('acf_the_content', 'wpautop');
        if ($m1_noformat) {
            remove_filter('acf_the_content', 'wpautop');
            $m1_txt = do_shortcode(get_sub_field('m1_txt'));
            $m1_txt = do_blocks($m1_txt);
            $m1_txt = str_replace(['<br/>', '<p>', '</p>', '<p> </p>'], '', $m1_txt);
            $m1_class .= ' noformat ';
        } else {
            $m1_txt = ss_add_pclass(apply_filters('the_content', get_sub_field('m1_txt')), '');
        }

        $m1_txt .= get_sub_field('m1_shortcode');

        if (strpos($m1_txt, 'href=') !== false) {
            $m1_texthaslink = true;
        }

        $mod_class = 'mod m1-row ' . $m1_class . ' ' . $m1_txt_algnmnt . ' ' . $m1_txt_lt . ' ' . $m1_pos . ' ' . $m1_imgtach.' ';

        if (get_sub_field('m1_use_url')) {
            $btnlnk = get_sub_field('m1_url');
            $m1_url = get_sub_field('m1_url');
            $target = (strpos($m1_url, 'http://') !== false && !strpos($m1_url, 'mailto:') || get_sub_field('m1_new_win')) ? 'target="_blank"' : '';
        } else {
            $btnlnk = get_sub_field('m1_link');
            $m1_texthaslink = true;
            $target = '';
        }

        if ($m1_usevid && $m1_usevid == true) {
            $vid = get_sub_field('m1_vid_id');
            $type = is_numeric($vid);
            if ($type == 1) {
                $hash = file_get_contents("http://vimeo.com/api/v2/video/" . $vid . ".xml");
                $hash = simplexml_load_string($hash);
                if(isset($hash[0])){
                     $m1_bgimg = $hash[0]->video->thumbnail_large;
                }
               
            } else {
                $m1_bgimg = 'https://img.youtube.com/vi/' . $vid . '/maxresdefault.jpg';
            }
        }

        $bg_imgW = '768';
        $bg_imgH = '1365';
        $m1_img = '';


      

        if (isset($m1_bgimg['url']) && $m1_bgimg['url'] != '') {
            if (function_exists('getimagesize') && file_exists($m1_bgimg['url'])) {
                list($bg_imgW, $bg_imgH) = getimagesize($m1_bgimg['url']);
            }

            $m1_bgimg_sz = $m1_bgimg_sz == '' ? 'full' : $m1_bgimg_sz;

            if ($m1_imgtach == 'normal') {
                if ($m1_bgimg_sz == 'full') {
                    $imgpath = $m1_bgimg['url'];
                    $img_w = 350;
                    $img_h = 300;
                } else {
                    $imgpath = $m1_bgimg['sizes'][$m1_bgimg_sz];
                    $img_w = $m1_bgimg['sizes'][$m1_bgimg_sz . '-width'];
                    $img_h = $m1_bgimg['sizes'][$m1_bgimg_sz . '-height'];
                }
            } else {
                $imgpath = $m1_bgimg['url'];
                $img_w = $m1_bgimg['width'];
                $img_h = $m1_bgimg['height'];
            }

            $m1_img_alt = $m1_bgimg['alt'] ?: $m1_bgimg['title'];

            if ($m1_imgtach != 'fixed') {
                $m1_img .= '<img data-imgtype="1" src="' . $imgpath . '" class="m1_img ' . $m1_imgtach . '" style="object-size:cover; object-position:' . $m1_img_algnmnt . '" ' . $m1_lazy . ' '.$m1_fetchpriority.' alt="' . $m1_img_alt . '" width="' . $img_w . '" height="' . $img_h . '" '.($m1_imgtach == 'parallax' ?  ' data-parallax="img" data-bgimage="1"  data-img-width="' . $img_w . '" data-img-height="' . $img_h . '"' : '') .'>';
                if ($m1_bgimg_mob != '') {
                    $mod .= '<img src="' . $imgpath . '" class="m1_img dp-display:above:m ' . $m1_imgtach . '" style="object-size:cover; object-position:' . $m1_img_algnmnt . '" ' . $m1_lazy . ' alt="' . $m1_img_alt . '" width="' . $img_w . '" height="' . $img_h . '">';
                    $mod .= '<img src="' . $m1_bgimg_mob['url'] . '" class="m1_img dp-display:below:m ' . $m1_imgtach . '" style="object-size:cover; object-position:' . $m1_img_algnmnt . '" ' . $m1_lazy . ' alt="' . $m1_img_alt . '" width="' . $img_w . '" height="' . $img_h . '">';
                }
            } else {
                $m1_img .= '<div class="m1_img_bg ' . $m1_imgtach . '" style=" background-image:url(' . $imgpath . '); ' . $m1_bgimg_alignmnt . '" ' . $m1_lazy . ' width="' . $img_w . '" height="' . $img_h . '" ' . ($m1_imgtach == 'parallax' ? 'data-parallax="1" data-bgimage="1" data-rev="1" data-diff="1" data-container="parallax-img" data-multiplyer="1" data-img-width="' . $img_w . '" data-img-height="' . $img_h . '"' : '') . ' ></div>';
            }
            $m1_img .='bg tint ='.$m1_bgimg_tint;

            if($m1_bgimg_tint!=''){
               $m1_img .='<div class="mod-bg-tint" style="background-color:' . $m1_bgimg_tint . '"></div>';
            }
        }

        $bgstyles = '';
        $bleedclass = '';

        if ($m1_bgclr != '') {
            if (str_contains($m1_bgclr, '#')) {
                $bgstyles .= 'background-color:' . $m1_bgclr . '; ';
            } else {
                $bleedclass .= $m1_bgclr;
            }
        }

        if (get_sub_field('m1_txt_lt') != '') {
            $mod_class .= ' mod-txt-lght';
        }

        $m1_hasvid = $m1_usevid ? ' has-video' : '';

        $mod .= '<div class="mod-grid-item ' . $m1_valign . ' ' . $m1_hasvid . ' ' . ($m1_bleed ? ' bleed ' : ' ') . ' ' . ($m1_imgtach == 'fixed' ? 'fixed' : '') . ' ' . $m1_gutter_class . '" '.($m1_clmn_max_w!="" ? ' style="max-width:'.$m1_clmn_max_w.'"': '').' ' . $m1_fx_type . ' >';

        $styles = $bgstyles;
        $mod_class .= $bleedclass;

        $mod .= '<div ' . ($m1_id != '' ? ' id="' . $m1_id . '"' : '') . ' ' . ($styles != '' ? 'style="' . $styles . '"' : '') . ' data-img-height="' . $bg_imgH . '" data-img-width="' . $bg_imgW . '" class=" ' . $m1_usevid . ' ' . $mod_class . ' ' . $m1_valign . ' ' .($m1_bleed ? ' ' :  ' mod-default-spacing:' . $m1_spacing).' '.(strip_tags($m1_txt) == '' && $m1_form == '' && $m1_head == '' ? ' no-content' : ' has-content') . '">' . $m1_img;

        if ($m1_usevid && $m1_usevid == true) {
            
            $mod .= '<div class="bg-video" data-diff="100" data-tpspeed="fixed" data-zoom="1" data-img-height="' . $bg_imgH . '" data-img-width="' . $bg_imgW . '">';
            $type = is_numeric($vid);
            if ($type == 1) {
                $mod .= '  <iframe id="vimeo-vid-' . $vid . '" class="vimeo-frame autoplay project-video" src="https://player.vimeo.com/video/' . $vid . '?api=1&autoplay=1&background=1&playsinline=0&muted=1&player_id=vimeo-vid-' . $vid . '" width="100%" height="100%" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            } else {
                $mod .= '<div id="video-placeholder-' . $vid . ' class="youtube-vid" data-vidid="' . $vid . '"></div> ';
            }
     
            $mod .= ' </div>';
        }

         if($m1_bgimg_tint!=''){
               $mod .='<div class="mod-bg-tint" style="background-color:' . $m1_bgimg_tint . '"></div>';
            }

        if ($btnlnk != '' && !isset($m1_texthaslink)) {
            $mod .= '<a href="' . $btnlnk . '" class=" ' . $m1_hrb . $m1_hrt . ' modlink ' . ($m1_fillw ? '' : 'dp-contain ') . $m1_pos . ' mod-default-spacing:' . $m1_spacing . ' " ' . $target . ' roll="button">';
        } else {
            $mod .= '<div class="' . $m1_hrb . $m1_hrt . ' ' . ($m1_fillw ? '' : 'mod-contain ') . ' ' .($m1_bleed ? ' mod-default-spacing:' . $m1_spacing: '').' ' . $m1_pos . ' mod-position">';
        }

        if ($m1_head != '') {
            $htag = $m1_use_h1 ? 'h1' : 'h2';
            $mod .= '<' . $htag . ' class="dp-pad:15px:bot mod-header ' . ($m1_head_sz != '' ? $m1_head_sz : '') . '">' . $m1_head . '</' . $htag . '>';
        }

        if ($m1_txt != '') {
            $mod .= '<div class="mod-txt ' . $m1_p_sz . '">' . $m1_txt;
            if ($m1_expand != '') {
                $mod .= '<div class="expand-more' . ($m1_expand_cta != '' ? ' hascta ' : '') . '">' .
                    ($m1_expand_cta != '' ? ' <span class="cta"> ' . $m1_expand_cta . '</span> ' : '') . '
                            <div class="expander" style="height:1px">
                                <div class="sizer">
                                    <p>' . $m1_expand . '</p>
                                </div>
                            </div>
                        </div>';
            }
            $mod .= '</div>';
        }

        if ($m1_form != '' && $m1_form) {
            if ($m1_form != 'sharebutton') {
                global $form_scripts;
                $form_scripts[$m1_form] = 'set';
                $mod .= '<div class="form">' . do_shortcode('[fform_html id="' . $m1_form . '"]') . '</div>';
            } else {
                $mod .= '<div class="sharelinks dp-contain dp-pos:cntr dp-pad:25pc:top:xs dp-pad:25pc:top:s dp-pad:75pc:top"><!-- Load Facebook SDK for JavaScript --><div id="fb-root"></div>
<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0"; fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));</script><!-- Your share button code --><div class="fb-share-button" data-href="https://www.your-domain.com/your-page.html" data-layout="button_count" data-size="large"></div></div>';
            }
        }

        if (get_sub_field('m1_btn') && isset($m1_texthaslink)) {
            $btnclass = '' . $m1_btn_class . ' ';
            $btntxt = get_sub_field('m1_btn_txt');
            if($btntxt==''){
                    $btntxt =" Read More";
            }

             $content_txt = $m1_txt . $m1_head;

            if ($m1_use_popup && $m1_popup_code != '') {
                $btnlnk = "#";
                $btnclass = ' lightbox-trigger ';
                $m1_popup_code = '<span class="lightbox-content dp-hide" data-title="">' . $m1_popup_code . '</span>';

                $mod .= '<div class="button-pos ' . ($content_txt != '' ? 'dp-marg:33pc:top' : '') . '"><button class="button ' . (strlen($btntxt) > 15 ? ' btn-wide ' : '') . ' ' . $btnclass . ' ' . ($m1_btn_rev ? ' btn-rev ' : '') . ' ' . ($m1_btn_alt ? ' btn-alt ' : '') . '" >' . $btntxt . ' </button>' . $m1_popup_code . '</div>';
            }

            else{
                $mod .= '<div class="button-pos ' . ($content_txt != '' ? 'dp-marg:33pc:top' : '') . '"><a href="' . $btnlnk . '" class="button ' . (strlen($btntxt) > 15 ? ' btn-wide ' : '') . ' ' . $btnclass . ' ' . ($m1_btn_rev ? ' btn-rev ' : '') . ' ' . ($m1_btn_alt ? ' btn-alt ' : '') . '" ' . $target . '>' . $btntxt . ' </a>' . $m1_popup_code . '</div>';

            }
           

        } elseif (get_sub_field('m1_btn')) {
            $mod .= '<div class="button-pos dp-marg:33pc:top"><span class="button">' . $btntxt . '</span></div>';
        }

        if ($btnlnk != '' && !isset($m1_texthaslink)) {
            $mod .= '</a>';
        } else {
            $mod .= '</div>';
        }

        if ($m1_mod_rule) {
            $mod .= '<hr class="section-rule">';
        }

        $mod .= '</div></div><!-- this 0-->';
    endwhile;

    $mod .= '</div></div>';
}

$mod .= '</div></div><!-- this 3-->';

if ($m1_hrb) {
    $mod .= '<div class="dp-contain dp-pos:cntr dp-pad:15px:rt dp-pad:15px:lt"><hr class="section-rule"></div>';
}

$mod .= '
<!-- End Columned Text Module -->';

if (!get_field('m1_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>