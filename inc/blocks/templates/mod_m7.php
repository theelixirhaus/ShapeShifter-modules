<?php
$styles = '';

// Content
$m7_intro_head = get_field('m7_intro_head');
$m7_intro_txt = get_field('m7_intro_txt');
$m7_align_img = get_field('m7_align_img');
$m7_alternate = get_field('m7_alternate') ? ' clmn-alt ' : '';


// Style
$m7_look = get_field('m7_look');
$m7_look = $m7_look ? ' data-look="'.$m7_look.'"' : '';
$m7_fx = get_field('m7_fx');
$m7_fx_type = $m7_fx ? ' data-fx="' . $m7_fx . '"' : '';
$m7_bgimg = get_field('m7_bgimg');
$m7_bgclr = get_field('m7_bgclr');
$m7_txt_lt = get_field('m7_txt_lt');
$m7_hrt = get_field('m7_hrt');
$m7_hrb = get_field('m7_hrb');
$m7_class = get_field('m7_class');
$m7_imgtach = get_field('m7_imgtach');
$m7_scrolltoggle = get_field('m7_scrolltoggle');

// Formatting
$m7_spacing = get_field('m7_spacing');
$m7_intro_head_sz = get_field('m7_intro_head_sz');
$m7_intro_txt_sz = get_field('m7_intro_txt_sz');
$m7_intro_algnmnt = get_field('m7_intro_algnmnt');
$m7_intro_pos = get_field('m7_intro_pos');
$m7_header_sz = get_field('m7_header_sz');
$m7_intro_max_w = get_field('m7_intro_max_w');
$m7_intro_max_w = $m7_intro_max_w ? 'style="max-width:'.$m7_intro_max_w.'"':'';
$m7_price_sz = get_field('m7_price_sz');
$m7_menu_txt_align = get_field('m7_menu_txt_align');
$m7_txt_sz = get_field('m7_txt_sz');
$m7_align_content = get_field('m7_align_content'); // For Grid Items
$m7_align_mod = get_field('m7_align_mod'); // For Grid Items
$m7_clmn_gutter = get_field('m7_clmn_gutter');
$m7_clmn_gutter_tab = get_field('m7_clmn_gutter_tab');
$m7_clmn_gutter_mob = get_field('m7_clmn_gutter_mob');
$m7_stack = get_field('m7_stack');
$m7_fillw = get_field('m7_fillw');
$m7_clmns_fixedw = get_field('m7_clmns_fixedw') ? ' dp-contain ' : ' ';
$m7_clmns_fixedw_sm = get_field('m7_clmns_fixedw_sm') ? ' mod-contain-sm ' : '';


$parallax = '';
if ($m7_imgtach == 'parallax') {
    $parallax = ' data-parallax="1" data-diff="100" ';
}

if ($m7_bgimg != '') {
    $styles .= 'background-image:url(\'' . $m7_bgimg . '\'); ';
}

if ($m7_bgclr != '') {
    $styles .= 'background-color:' . $m7_bgclr . '; ';
}


if ($m7_txt_lt != '') {
    $m7_txt_lt = 'mod-txt-lght';
}

if ($m7_scrolltoggle) {
    $m7_class .= ' scrolltoggle';
}



if ($m7_clmn_gutter != '') {
    $m7_clmn_gutter = ' dp-gutter:' . $m7_clmn_gutter;
}

if ($m7_clmn_gutter_tab != '') {
    $m7_clmn_gutter_tab = ' dp-gutter:' . $m7_clmn_gutter_tab . ':m';
}

if ($m7_clmn_gutter_mob != '') {
    $m7_clmn_gutter_mob = ' dp-gutter:' . $m7_clmn_gutter_mob . ':xs dp-gutter:' . $m7_clmn_gutter_mob . ':s';
}


$gutters = $m7_clmn_gutter.$m7_clmn_gutter_tab.$m7_clmn_gutter_mob;


$mod_class = 'mod mod-m7 ' . $m7_class . ' ' . $m7_imgtach;
$mod = '';

if ($m7_hrt) {
    $mod .= '<hr class="section-rule">';
}

$mod .= '<!-- Start Menu Section -->
<div ' . ($styles != '' ? 'style="' . $styles . '"' : '') . $parallax . ' class="' . $mod_class . ($m7_fillw? ' ' : ' dp-contain dp-pos:'.$m7_align_mod).$m7_clmns_fixedw_sm.'">
    <div class="' . ($m7_fillw? $m7_clmns_fixedw.' dp-pos:'.$m7_align_mod  : '').' dp-pos:'.$m7_align_content.' '. $m7_clmns_fixedw_sm.'   mod-default-spacing:'.$m7_spacing .'" '.$m7_fx_type.' '.$m7_look.'>';

if ($m7_intro_head != '' || $m7_intro_txt != '') {
    $mod .= '<div class="mod-intro-header dp-pad:75pc:bot ' . $m7_txt_lt . ' ' . $m7_intro_algnmnt. '">
                <div class="mod-head-pos '.$m7_intro_pos.'" '.$m7_intro_max_w.'>';
    
                    $introPadTop = '';
                    if ($m7_intro_head != '') {
                        if ($m7_intro_use_h1) {
                            $m7_intro_head = '<h1 class="' . $m7_intro_head_sz . ' ">' . $m7_intro_head . '</h1>';
                        } else {
                            $m7_intro_head = '<h2 class="' . $m7_intro_head_sz . '">' . $m7_intro_head . '</h2>';
                        }
                        $mod .= '<div class="mod-intro-title">' . $m7_intro_head . '</div>';
                        $introPadTop = ' dp-pad:10px:top ';
                      
                    }

                     if ($m7_intro_txt != '' && strlen(strip_tags($m7_intro_txt) > 1)) {
                        $mod .= '<div class="mod-intro-txt '.$m7_intro_txt_sz . ' ' . $introPadTop . '">' . apply_filters('the_content', $m7_intro_txt) . '</div>';
                    }

                  $mod.='
                </div>
             </div>';
}

$mod .= '<div class=" dp-pos:'.$m7_align_content.' ' . $m7_txt_lt. '">';

$rowsttl = get_field('m7_items') != '' ? is_array(get_field('m7_items')) && count(get_field('m7_items')) : 1;
$m7_clmns = get_field('m7_clmns');
if ($m7_clmns == '' ) {
    $m7_clmns = '1';
    //$gutters = '';
}

$mod .= '<div class="m7-items dp-grid:fit:' . $m7_clmns . ':l dp-grid:fit:' . $m7_clmns.' '. $m7_alternate . ' '.$gutters.' '.$m7_align_img.'">';

if (have_rows('m7_items')) {
    $rowcnt = 0;
    
    while (have_rows('m7_items')) : the_row();
        $m7_item_name = get_sub_field('m7_item_name');
        $m7_descr = get_sub_field('m7_descr');
        $m7_item_img = get_sub_field('m7_item_img');
        $m7_fitimg = get_sub_field('m7_fitimg');
        $m7_item_price = get_sub_field('m7_price');
        $m7_has_link = get_sub_field('m7_has_lnk');
        $m7_link = get_sub_field('m7_link');
        $m7_link_txt = get_sub_field('m7_link_txt');
        $m7_prod_img = get_sub_field('m7_prod_img');
        $rowside = ''; // Assuming $rowside is meant to be dynamic; left empty as in original
        $target = ''; // Assuming $target is defined elsewhere or meant to be empty

        $mod .= '<div class="m7-row dp-flex '.($m7_stack ? 'dp-flex-col' : $gutters).' ' . (intval($m7_clmns) == 1 ? 'dp-grid:fit:2:m dp-gridfit:1:sm dp-flex-align dp-flex-center' : '') . ' ' . (($rowcnt < ($rowsttl - 1)) ? '' : '') . ' dp-txt:'.$m7_menu_txt_align.'">
                    <div class="img '.($m7_fitimg ? 'fitimg' : '').'">
                        <img src="' . $m7_item_img . '" alt="' . $m7_item_name . '" class="t-show-under-m">
                    </div>
                    <div class="descr">
                        <div>';
        
        if ($m7_item_name != '') {
            $mod .= '<h3 class="t-pad:25pc:bot '.$m7_header_sz .' '. $rowside . '">' . $m7_item_name . '</h3>';
        }
        
        if ($m7_descr) {
            $mod .= '<div class="mod-txt ' . $rowside . ($m7_fillw != '' ? ' dp-pad:25pc:rt dp-pad:25pc:lt' : '') . '">' . ss_add_pclass(apply_filters('the_content', $m7_descr), $m7_txt_sz) . '</div>';
        }
        
        if ($m7_item_price) {
            $mod .= '<div class="price '.$m7_price_sz.' dp-marg:25pc:top dp-marg:25pc:bot">' . $m7_item_price . '</div>';
        }
        
        if ($m7_has_link) {
            $mod .= '<div class="t-marg:25pc:top button-pos"><a href="' . $m7_link . '" class="button" ' . $target . '>' . $m7_link_txt . '</a></div>';
        }
        
        $mod .= '</div>
                </div>
            </div>';
        
        $rowcnt++;
    endwhile;
}

$mod .= '</div>
        </div>
    </div>
</div>';

if ($m7_hrb) {
    $mod .= '<hr class="section-rule">';
}

if (!get_field('m7_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>