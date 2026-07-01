<?php
$styles = '';
$m6_txt_lt = '';

// Content
$m6_intro_head = get_field('m6_intro_head');
$m6_intro_use_h1 = get_field('m6_intro_use_h1');
$m6_intro_txt = get_field('m6_intro_txt');
$m6_height = get_field('m6_height');
$m6_auth = get_field('m6_item');

// Style
$m6_look = get_field('m6_look');

$m6_fx = get_field('m6_fx');
$m6_look = $m6_look ? ' data-look="'.$m6_look.'"' : '';
$m6_fx_type = $m6_fx ? ' data-fx="' . $m6_fx . '"' : '';
$m6_bgimg = get_field('m6_bgimg');
$m6_imgtach = get_field('m6_imgtach');
$m6_bgclr = get_field('m6_bgclr');
$m6_txt_lt = get_field('m6_txt_lt');
$m6_items_side = get_field('m6_items_side');
$m6_intro_txt_lt = get_field('m6_intro_txt_lt');
$m6_stickied_txt_lt = get_field('m6_stickied_txt_lt');
$m6_hrt = get_field('m6_hrt');
$m6_hrb = get_field('m6_hrb');
$m6_class = get_field('m6_class');

// Formatting
$m6_spacing = get_field('m6_spacing');
$m6_intro_head_sz =get_field('m6_intro_head_sz');
$m6_intro_txt_sz =get_field('m6_intro_txt_sz');
$m6_intro_pos = get_field('m6_intro_pos');
$m6_intro_max_w = get_field('m6_intro_max_w');
$m6_intro_max_w = $m6_intro_max_w ? 'style="max-width:'.$m6_intro_max_w.'"':'';
$m6_item_title_sz = get_field('m6_item_title_sz');
$m6_item_descr_sz = get_field('m6_item_descr_sz');
$m6_intro_algnmnt = get_field('m6_intro_algnmnt');
$m6_align_mod = get_field('m6_align_mod');
$m6_align_content = get_field('m6_align_content');
$m6_txt_alnmnt = get_field('m6_txt_alnmnt');
$m6_txtstickied_alnmnt = get_field('m6_txtstickied_alnmnt');
$m6_fillw = get_field('m6_fillw');
$m6_clmns_fixedw = get_field('m6_clmns_fixedw');
$m6_stickied_disable = get_field('m6_stickied_disable');
$m6_clmns_fixedw_sm = get_field('m6_clmns_fixedw_sm') ? ' mod-contain-sm ' : '';
$m6_clmn_size = get_field('m6_clmn_size');
$m6_nopad = get_field('m6_nopad');



$parallax = '';
if ($m6_imgtach == 'parallax') {
    $parallax = ' data-parallax="1" data-diff="100" ';
}

if ($m6_bgimg != '') {
    $styles .= 'background-image:url(\'' . $m6_bgimg . '\'); ';
}

if ($m6_bgclr != '') {
    $styles .= 'background-color:' . $m6_bgclr . '; ';
}

if ($m6_txt_lt != '') {
    $m6_txt_lt = 'mod-txt-lght';
}

if ($m6_items_side == 'l') {
    $m6_items_side = 'm6-stick-l';
}


$mod_class = 'mod mod-m6 ' . $m6_class . '  ' . $m6_imgtach.($m6_stickied_disable? ' mod-disabled-sticky ':'');
$mod = '';

if ($m6_hrt) {
    $mod .= '<hr class="section-rule">';
}

$mod .= '<!-- Start Sticky Section -->
<section ' . ($styles != '' ? 'style="' . $styles . '"' : '') . $parallax . ' class="' . $mod_class .' mod-default-spacing:'.$m6_spacing.' '.(!$m6_fillw?' dp-contain dp-pos:'.$m6_align_mod: '').'"  '.$m6_fx_type .' '.$m6_look.'>
    <div class="' .($m6_clmns_fixedw? 'dp-contain':'').($m6_clmns_fixedw_sm? ' mod-contain-sm':'').' dp-pos:'.$m6_align_content.'">';


    
   if ($m6_intro_txt != '' || $m6_intro_head != '') {
        
        $mod .= '<div class="mod-intro-header dp-pad:33pc:top dp-pad:33pc:bot '.$m6_intro_algnmnt.($m6_intro_txt_lt? ' mod-txt-lght ':'').'">
            <div class="mod-head-pos '.$m6_intro_pos.'" '.$m6_intro_max_w.'>';
            
                    $introPadTop = '';
                    if ($m6_intro_head != '') {
                        if ($m6_intro_use_h1) {
                            $m6_intro_head = '<h1 class="' . $m6_intro_head_sz . ' ">' . $m6_intro_head . '</h1>';
                        } else {
                            $m6_intro_head = '<h2 class="' . $m6_intro_head_sz . '">' . $m6_intro_head . '</h2>';
                        }
                        $mod .= '<div class="mod-intro-title">' . $m6_intro_head . '</div>';
                        $introPadTop = ' dp-pad:10px:top ';
                      
                    }

                  $mod.=' <div class="mod-intro-text '.$introPadTop.get_field('m6_intro_txt_sz').'">'.apply_filters('the_content',$m6_intro_txt).'</div>
                </div>
            </div>';
    }


$mod .= '<div class="m6-columns dp-pad:50pc:top:l dp-pad:50pc:top:m  dp-pad:50pc:bot '.$m6_clmn_size. ' '. $m6_clmns_fixedw_sm . '">
            <div class="m6_sticky dp-pad:25pc:bot:xs dp-pad:25pc:bot:s dp-pad:25pc:bot:m '.$m6_txtstickied_alnmnt.($m6_stickied_txt_lt? ' mod-txt-lght ':'').'">
                <div class="m6_stickied">
                    <h3 class="dp-pad:33pc:bot dp-txt:u '.$m6_item_title_sz .'"> '.get_field('m6_title') . '</h3><p class="'.$m6_item_descr_sz.'">'.get_field('m6_descr') . '</p>
                </div>
            </div>
            <div class="m6-items">';

if (have_rows('m6_items')) {
    while (have_rows('m6_items')) : the_row();
        $mod .= '<div class="m6-item dp-pad:25pc:top dp-pad:50pc:rt dp-pad:50pc:lt dp-pad:5px:rt:s dp-pad:5px:lt:s dp-pad:10px:rt:xs dp-pad:10px:lt:xs dp-pad:25pc:rt:m dp-pad:25pc:lt:m dp-pad:25pc:bot dp-txt:sm '.$m6_txt_alnmnt.(get_sub_field('m6_txt_lt')? ' mod-txt-lght ':'').'">' . get_sub_field('m6_section_text') . '</div>';
    endwhile;
}

$mod .= '</div>
        </div>
    </div>
</section>';

if ($m6_hrb) {
    $mod .= '<hr class="section-rule">';
}

if (!get_field('m6_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>