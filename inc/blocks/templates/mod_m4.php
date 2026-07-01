<?php
$styles = '';
$m4_fx_type = '';

// Content
$m4_intro_head = get_field('m4_intro_head');
$m4_id = get_field('m4_id');
$m4_intro_use_h1 = get_field('m4_intro_use_h1');
$m4_intro_txt = get_field('m4_intro_txt');
$m4_head = get_field('m4_head');
$m4_txt = get_field('m4_txt');

// Style
$m4_look = get_field('m4_look');
$m4_look = $m4_look ? ' data-look="'.$m4_look.'"' : '';
$m4_fx = get_field('m4_fx');
$m4_fx_type = $m4_fx ? ' data-fx="' . $m4_fx . '"' : '';
$m4_bgimg = get_field('m4_bgimg');
$m4_imgtach = get_field('m4_imgtach');
$m4_bgclr = get_field('m4_bgclr');
$m4_txt_lt = get_field('m4_txt_lt');
$m4_hrt = get_field('m4_hrt');
$m4_hrb = get_field('m4_hrb');
$m4_class = get_field('m4_class');

// Formatting
$m4_spacing = get_field('m4_spacing');
$m4_intro_head_sz = get_field('m4_intro_head_sz');
$m4_head_sz = get_field('m4_head_sz');
$m4_intro_txt_sz = get_field('m4_intro_txt_sz');
$m4_intro_max_w = get_field('m4_intro_max_w');
$m4_intro_max_w = $m4_intro_max_w ? 'style="max-width:'.$m4_intro_max_w.'"':'';
$m4_intro_algnmnt = get_field('m4_intro_algnmnt');
$m4_intro_spacing = get_field('m4_intro_spacing');
$m4_intro_pos = get_field('m4_intro_pos');
$m4_txt_sz = get_field('m4_txt_sz');
$m4_txt_almnt = get_field('m4_txt_almnt');
$m4_fillw = get_field('m4_fillw');
$m4_clmns_fixedw = get_field('m4_clmns_fixedw');
$m4_align_mod = get_field('m4_align_mod');
$m4_align_content = get_field('m4_align_content');
$m4_almnt = get_field('m4_almnt');
$m4_nopad = get_field('m4_nopad');
$m4_scrolltoggle = get_field('m4_scrolltoggle');

$m4_id = 'quotes-'.get_field('m4_id');

global $globalscripts;
global $globalscriptcnt;


$parallax = '';
if ($m4_imgtach == 'parallax') {
    $parallax = ' data-parallax="1" data-diff="100" ';
}

if ($m4_bgimg != '') {
    $styles .= 'background-image:url(\'' . $m4_bgimg . '\'); ';
}
if ($m4_bgclr != '') {
    $styles .= 'background-color:' . $m4_bgclr . '; ';
}

if ($m4_txt_lt!= '') {
    $m4_txt_lt = 'mod-txt-lght';
}

$mod_class = 'mod mod-m4 ' . $m4_class . ' ' . $m4_txt_lt . ' ' . $m4_imgtach;
$mod = '';

if ($m4_hrt) {
    $mod .= '<hr class="section-rule">';
}

$m4_clmns_fixedw_sm = '';
if (get_field('m4_clmns_fixedw_sm')) {
    $m4_clmns_fixedw_sm = ' mod-contain-sm ';
}

$mod .= '<!-- Start Quotes-->

<div ' . ($styles != '' ? 'style="' . $styles . ' " ' : '') . $parallax . ' class=" mod-default-spacing:' . $m4_spacing . ' ' . $mod_class . ($m4_fillw? '' : ' dp-contain dp-pos:' . $m4_align_mod) . ' " ' . $m4_fx_type . ' '.$m4_look.'>
<div class="dp-pos:'.$m4_align_content.':l dp-pos:'.$m4_align_content.':m'.$m4_clmns_fixedw_sm .($m4_clmns_fixedw ? ' dp-contain ' : '').'">';

if ($m4_intro_head . $m4_intro_txt != '') {
    $mod .= '<div class="' . $m4_intro_algnmnt . ' mod-default-spacing:' . $m4_intro_spacing .($m4_txt_lt? ' mod-txt-lght ':'').' mod-intro-header">
     <div class="mod-head-pos '.$m4_intro_pos.' " '.$m4_intro_max_w.'>';
    
    $introPadTop = '';

    if($m4_intro_head !=''){
        if ($m4_intro_use_h1) {
            $m4_intro_head = '<h1 class="' . $m4_intro_head_sz . ' ">' . $m4_intro_head . '</h1>';
        } else {
            $m4_intro_head = '<h2 class="' . $m4_intro_head_sz . '">' . $m4_intro_head . '</h2>';
        }
        
        $mod .= '<div class="mod-intro-title">' . $m4_intro_head . '</div>';
        $introPadTop = ' dp-pad:10px:top ';
    }
    if ($m4_intro_txt != '') {
        $mod .= '<div class="mod-intro-txt dp-pad:10px:top"><p class="' . $m4_intro_txt_sz . '">' . $m4_intro_txt . '</p></div>';
    }
    
    $mod .= '</div></div>';
}

$mod .= '<div class="' . ($m4_clmns_fixedw ? '' : 'dp-contain dp-pos:' . $m4_almnt) .($m4_txt_lt? ' mod-txt-lght ':'').' owl-carousel owl-theme " data-slider-name="'.$m4_id.'">';

while (have_rows('m4_quotes')) : the_row();
    $m4_quote = get_sub_field('m4_quote');
    $m4_auth = get_sub_field('m4_auth');
    $m4_auth_title = get_sub_field('m4_auth_title');
    $m4_quote_img = get_sub_field('m4_quote_img');
    
    $mod .= '<div class="quote-item item '.$m4_txt_almnt.'">';
    
    if ($m4_quote_img != '') {
        $mod .= '<div class="mod-quote-img">' . ss_rsrcPic($m4_quote_img) . '</div>';
    }
    
    $mod .= '<div class="mod-txt">';
    
    if ($m4_quote != '') {
        $mod .= '<blockquote class="mod-quote dp-txt:h3">' . $m4_quote . '</blockquote>';
    }
    
    if ($m4_auth || $m4_auth_title) {
       $mod .= '<div class="quote-cred">';
    }
    if ($m4_auth) {
        $mod .= '<div class="mod-auth dp-marg:10px:top dp-txt:h3 b">' . $m4_auth . '</div>';
    }
    
    if ($m4_auth_title) {
        $mod .= '<div class="mod-title dp-marg:10px:top dp-txt:h3">' . $m4_auth_title . '</div>';
    }

    if ($m4_auth || $m4_auth_title) {
       $mod .= '</div>';
    }


    
    $mod .= '</div>';
    $mod .= '</div>';
endwhile;

$mod .= '</div><!-- 1 --></div><!-- 2 --></div><!-- 3 -->';




$m4_slide_speed = get_field('m4_slide_speed') ?: 12000;
$m4_autoslide = get_field('m4_autoslide') == 1 ? 'true' : 'false';
$m4_quotes_arrows = get_field('m4_quotes_arrows') == 1 ? 'true' : 'false';
$m4_quotes_dots = get_field('m4_quotes_dots') == 1 ? 'true' : 'false';

$globalscripts.= "

            $('[data-slider-name=\"{$m4_id}\"]').owlCarousel({
                loop: true,
                margin: 0,
                autoplay: {$m4_autoslide},
                autoplayTimeout: {$m4_slide_speed},
                autoplayHoverPause: true,
                nav: {$m4_quotes_arrows},
                dots: {$m4_quotes_dots},
                responsive: {
                    0: { items: 1 },
                    600: { items: 1 },
                    1000: { items: 1 }
                }
            });";



if ($m4_hrb) {
    $mod .= '<hr class="section-rule">';
}

if (!get_field('m4_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>