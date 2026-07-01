<?php
$styles = '';

// Content
$m3_intro_head = get_field('m3_intro_head');
$m3_intro_use_h1 = get_field('m3_intro_use_h1');
$m3_intro_txt = get_field('m3_intro_txt');

// Style
$m3_look = get_field('m3_look');
$m3_look = $m3_look ? ' data-look="'.$m3_look.'"' : '';
$m3_fx = get_field('m3_fx');
$m3_fx_type = $m3_fx ? ' data-fx="' . $m3_fx . '"' : '';
$m3_bgimg = get_field('m3_bgimg');
$m3_imgtach = get_field('m3_imgtach');
$m3_intro_txt_lt = get_field('m3_intro_txt_lt');
$m3_class_container = get_field('m3_class_container');
$m3_bgclr = get_field('m3_bgclr');
$m3_hrt = get_field('m3_hrt');
$m3_hrb = get_field('m3_hrb');
$m3_class = get_field('m3_class');

// Formatting
$m3_spacing = get_field('m3_spacing');
$m3_intro_head_sz = get_field('m3_intro_head_sz');
$m3_intro_txt_sz = get_field('m3_intro_txt_sz');
$m3_intro_spacing = get_field('m3_intro_spacing');
$m3_intro_max_w = get_field('m3_intro_max_w');
$m3_intro_max_w = $m3_intro_max_w ? 'style="max-width:'.$m3_intro_max_w.'"':'';
$m3_intro_pos = get_field('m3_intro_pos');
$m3_intro_txt_algnmnt = get_field('m3_intro_txt_algnmnt');
$m3_row_p_sz = get_field('m3_row_p_sz');
$m3_align_content = get_field('m3_align_content'); // For Grid Items
$m3_fillw = get_field('m3_fillw');
$m3_clmns_fixedw = get_field('m3_clmns_fixedw') ? ' dp-contain ' : '';
$m3_clmns_fixedw_sm = get_field('m3_clmns_fixedw_sm') ? ' mod-contain-sm ' : '';
$m3_clmn_size = get_field('m3_clmn_size');
$m3_clmn_gutter = get_field('m3_clmn_gutter');
$m3_clmn_gutter_tab = get_field('m3_clmn_gutter_tab');
$m3_clmn_gutter_mob = get_field('m3_clmn_gutter_mob');
$m3_row_head_sz = get_field('m3_row_head_sz');
$m3_row_algnmnt = get_field('m3_row_algnmnt');
$m3_imgl = get_field('m3_imgl');
$m3_altrows = get_field('m3_altrows');
$m3_imgtop_mob = get_field('m3_imgtop_mob');
$m3_row_leadin_sz = get_field('m3_row_leadin_sz');

$m3_mod_class = $m3_class;


if($m3_imgtop_mob){

    $m3_mod_class .= ' m3-imgtop-mob ';
}


if ($m3_altrows) {
    $m3_mod_class .= ' m3-altrows ';
}

if ($m3_imgl) {
    $m3_mod_class .= ' m3-imgl ';
}

$parallax = '';
if ($m3_imgtach == 'parallax') {
    $parallax = ' data-parallax="1" data-diff="100" ';
}

if ($m3_bgclr != '') {
    $styles .= 'background-color:' . $m3_bgclr . '; ';
}

if ($m3_intro_txt_lt != '') {
    $m3_intro_txt_lt = 'mod-txt-lght';
}

$m3_mod_class = 'mod mod-m3 ' . $m3_mod_class . ' ' . $m3_imgtach;
$mod = '';

if ($m3_hrt) {
    $mod .= '<hr class="section-rule">';
}


if ($m3_clmn_gutter != '') {
    $m3_clmn_gutter = ' dp-gutter:' . $m3_clmn_gutter;
}

if ($m3_clmn_gutter_tab != '') {
    $m3_clmn_gutter_tab = ' dp-gutter:' . $m3_clmn_gutter_tab . ':m';
}

if ($m3_clmn_gutter_mob != '') {
    $m3_clmn_gutter_mob = ' dp-gutter:' . $m3_clmn_gutter_mob . ':xs dp-gutter:' . $m3_clmn_gutter_mob . ':s';
}




$htag = get_field('m3_use_h1') ? 'h1' : 'h2';

$mod .= '<div ' . ($styles != '' ? 'style="' . $styles . '"' : '') . $parallax . ' class="' . $m3_mod_class . ' '.$m3_class_container . ' '.($m3_fillw ? '' : 'dp-contain dp-pos:' . $m3_align_content).'" '.$m3_look.' '.$m3_fx_type.'>';
$mod .= '<div class="'. $m3_class_container .'" >';

if ($m3_intro_head . $m3_intro_txt != '') {
    $mod .= '<div class="' . ($m3_fillw ? '' : 'dp-contain').' dp-pos:' . $m3_align_content . $m3_intro_txt_lt . '  mod-default-spacing:' . $m3_spacing .' ">';
    $mod .= '<div class="mod-intro-header '.$m3_intro_txt_lt.' '.$m3_intro_txt_algnmnt . ($m3_clmns_fixedw ? ' dp-contain dp-pos:cntr ' : '') . '">
        <div class="mod-head-pos '.$m3_intro_pos.'" '.$m3_intro_max_w.'>
                <div class="mod-intro-title mod-default-spacing:' . $m3_intro_spacing . ' ' . $m3_intro_txt_algnmnt . '">';
    
    $introPadTop = '';
    if($m3_intro_head!=''){
        if ($m3_intro_use_h1) {
            $m3_intro_head = '<h1 class="' . $m3_intro_head_sz . '">' . $m3_intro_head . '</h1>';
        } else {
            $m3_intro_head = '<h2 class="' . $m3_intro_head_sz . '">' . $m3_intro_head . '</h2>';
        }
        
        $mod .= '<div class="mod-intro-title">' . $m3_intro_head . '</div>';
        $introPadTop = ' dp-pad:10px:top ';
    }
    
    if ($m3_intro_txt != '') {
        $mod .= '<div class="mod-intro-txt'.$introPadTop. $m3_intro_txt_sz . '">' . $m3_intro_txt . '</div>';
    }
    
    $mod .= '</div>
            </div>
            </div>
            </div>';
}

$m3_clmn_size = $m3_clmn_size != '' ? 'colmn_sz_' . $m3_clmn_size : 'colmn_sz_50-50';
$rowsttl = is_array(get_field('m3_rows'))? count(get_field('m3_rows')) : 1;

$mod .= '<div class="m3-rows">';

if (have_rows('m3_rows')) {
    $rowcnt = 0;
    
    while (have_rows('m3_rows')) : the_row();
        $m3_head = get_sub_field('m3_head');
        $m3_txt = get_sub_field('m3_txt');
        $m3_txt_lt = get_sub_field('m3_txt_lt');
        $m3_img_txt = get_sub_field('m3_img_content');
        $m3_img_txt_algnmt = get_sub_field('m3_img_txt_algnmt');
        $m3_txtovrImg = get_sub_field('m3_txtovrImg');
        $m3_bleed = get_sub_field('m3_bleed');
        $m3_btn = get_sub_field('m3_btn');
        $m3_txt_algnmnt = get_sub_field('m3_txt_algnmnt');
        $m3_fitimg = get_sub_field('m3_fitimg') ? 'fitimg' : '';
        $m3_lazy = get_sub_field('m3_lazy') ? ' loading="lazy" ' : '';
        $m3_class = get_sub_field('m3_class');
        $m3_spacing = get_sub_field('m3_spacing');
        $m3_expand = get_sub_field('m3_expand');
        $m3_expand_cta = get_sub_field('m3_expand_cta');
        $m3_fx = get_field('m3_fx');
        $m3_fx_type = $m3_fx ? ' data-fx="' . $m3_fx . '"' : '';

        $m3_img = get_sub_field('m3_img');
        $m3_img_alt = '';
        if(isset($m3_img['url']) && $m3_img['url']!=''){
            $m3_img_alt = $m3_img['alt'] ?: $m3_img['title'];
        }
        $rowside = 'clmnl';

      
 $mod.='<div class="mod-contain  mod-default-spacing:' . $m3_spacing .' '.$m3_clmn_gutter.' '.$m3_clmn_gutter_tab.'  '.$m3_clmn_gutter_mob.'">';
        $mod .= '<section class="m3-row dp-flex:valign:mid dp-grid:fit:2:m  ' . $m3_clmn_size . ' '.($m3_bleed!=''?' bleed ':'').$m3_bleed.' '. $m3_class . ' ' . ' ' . ($m3_row_algnmnt ? 'dp-flex:valign:mid' : '') . ' ' . ($rowcnt < ($rowsttl - 1) ? '' : '') . ' ' . $m3_clmns_fixedw_sm . '   '.$m3_clmns_fixedw_sm .($m3_fillw ? $m3_clmns_fixedw.'dp-pos:' .$m3_align_content: '') .'" '.$m3_fx_type.'>';
        $rowside = 'clmnr';


        $mod .= '<div class="m3-txt">
                
                <div class="m3-content '.($m3_txt_lt? ' mod-txt-lght ' : '').$m3_txt_algnmnt . '"> <div class="mod">';
        
        if ($m3_head != '' && !$m3_txtovrImg) {
            $mod .= '<h3 class="mod-header dp-pad:10px:bot ' . $m3_row_head_sz . ' ' . $rowside . '">' . $m3_head . '</h3>';
        }
        
        if ($m3_txt) {
            $mod .= '<div class="mod-txt">' . ss_add_pclass(apply_filters('the_content', $m3_txt), $m3_row_p_sz) . '</div>';
        }
        
        if ($m3_expand != '') {
            $mod .= '<div class="expand-more' . ($m3_expand_cta != '' ? ' hascta ' : '') . '">' .
                ($m3_expand_cta != '' ? ' <span class="cta"> ' . $m3_expand_cta . '</span> ' : '') . '
                    <div class="expander" style="height:1px">
                        <div class="sizer">
                            <p>' . $m3_expand . '</p>
                        </div>
                    </div>
                </div>';
        }
        
        if ($m3_btn) {
            if (get_sub_field('m3_use_url')) {
                $btnlnk = get_sub_field('m3_url');
                $target = 'target="_blank"';
            } else {
                $btnlnk = get_sub_field('m3_lnk');
                $target = '';
            }

            $btntxt = get_sub_field('m3_btn_txt');
            if($btntxt==""){
                $btntxt = 'View More';
            }
            
            $mod .= '<div class="dp-marg:25pc:top button-pos"><a href="' . $btnlnk . '" class="button" ' . $target . '>' . $btntxt . '</a></div>';
        }
        
        $mod .= '</div>
                </div>
                </div>
            <div class="m3-img dp-flex:m dp-valign-center dp-txt:cntr ' . $m3_fitimg . ' dp-parallax-box "><div class="mod">';
       
        if(isset($m3_img['url']) && $m3_img['url']!=''){
            $mod .= '<img src="' . $m3_img['url'] . '" alt="' . $m3_img_alt . '" width="230" height="120" ' . $m3_lazy . ' srcset="' . wp_get_attachment_image_srcset($m3_img['id'], 'full') . '">';
        
                if ($m3_head != '' && $m3_txtovrImg) {
                    $mod .= '<div class="tint" style="background-color:'.get_sub_field('m3_bgimg_tint').'"></div><h3 class="mod-header ' . $m3_row_head_sz . ' dp-parallax">' . $m3_head . '</h3>';
                }
         }
        if ($m3_img_txt != '') {
            $mod .= '<div class="img-content '.$m3_img_txt_algnmt.'">' . apply_filters('the_content', $m3_img_txt) . '</div>';
        }
        
        
        $mod .= '</div></div>
                </section></div>';
        
        $rowcnt++;
    endwhile;
}

$mod .= '</div>
        </div>
       
        </div>';

if ($m3_hrb) {
    $mod .= '<hr class="section-rule">';
}

if (!get_field('m3_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>