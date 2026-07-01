<?php
$styles = '';

// Content
$m5_intro_head = get_field('m5_intro_head');
$m5_intro_use_h1 = get_field('m5_intro_use_h1');
$m5_schema = get_field('m5_schema');
$m5_intro_txt = get_field('m5_intro_txt');
$m5_txt_bot = get_field('m5_txt_bot');
$m5_quote = get_field('m5_quote');
$m5_auth = get_field('m5_auth');
$m5_txt_top = get_field('m5_txt_top');

// Style
$m5_look = get_field('m5_look');
$m5_look = $m5_look ? ' data-look="'.$m5_look.'"' : '';
$m5_fx = get_field('m5_fx');
$m5_fx_type = $m5_fx ? ' data-fx="' . $m5_fx . '"' : '';
$m5_bgclr = get_field('m5_bgclr');
$m5_txt_lt = get_field('m5_txt_lt');
$m5_hrt = get_field('m5_hrt');
$m5_hrb = get_field('m5_hrb');
$m5_class = get_field('m5_class');
$m5_bgimg = get_field('m5_bgimg');
$m5_imgtach = get_field('m5_imgtach');

// Formatting
$m5_intro_head_sz = get_field('m5_intro_head_sz');
$m5_intro_txt_sz = get_field('m5_intro_txt_sz');
$m5_intro_algnmnt = get_field('m5_intro_algnmnt');
$m5_intro_spacing = get_field('m5_intro_spacing');
$m5_intro_pos = get_field('m5_intro_pos');
$m5_intro_max_w = get_field('m5_intro_max_w');
$m5_intro_max_w = $m5_intro_max_w ? 'style="max-width:'.$m5_intro_max_w.'"':'';
$m5_closing_txt_sz = get_field('m5_closing_txt_sz');
$m5_closing_algnmnt = get_field('m5_closing_algnmnt');
$m5_head_sz = get_field('m5_head_sz');
$m5_exp_p_sz = get_field('m5_exp_p_sz');
$m5_fillw = get_field('m5_fillw');
$m5_clmns_fixedw = get_field('m5_clmns_fixedw') ? ' dp-contain ' : '';
$m5_clmns_fixedw_sm = get_field('m5_clmns_fixedw_sm') ? ' mod-contain-sm ' : '';
$m5_align_mod = get_field('m5_align_mod');
$m5_align_content = get_field('m5_align_content');
$m5_nopad = get_field('m5_nopad');
$m5_p_sz = get_field('m5_p_sz');


if($m5_schema){
    $m5_schema = [];
}
global $ss_faqarray;

$spacing_class = ' mod-default-spacing:' . get_field('m5_spacing') . ' ';

$parallax = '';
if ($m5_imgtach == 'parallax') {
    $parallax = ' data-parallax="1" data-diff="100" ';
}

if ($m5_bgimg != '') {
    $styles .= 'background-image:url(\'' . $m5_bgimg . '\'); ';
}

if ($m5_bgclr != '') {
    $styles .= 'background-color:' . $m5_bgclr . '; ';
}


if ($m5_txt_lt != '') {
    $m5_txt_lt = 'mod-txt-lght';
}

$mod_class = 'mod mod-m5 ' . $m5_class . ' ' . $m5_imgtach . ' ' . ($m5_fillw ? '' : 'dp-contain dp-pos:'.$m5_align_mod) . ' dp-pad:75pc:bot ' . $m5_align_mod . ' ' . ($m5_nopad ? '' : 'default-padding');
$mod = '';

if ($m5_hrt) {
    $mod .= '<hr class="section-rule">';
}

$mod .= '<!-- Start Accordion Section -->
<div ' . ($styles != '' ? 'style="' . $styles . '"' : '') . $parallax . ' class="' . $mod_class . ' '.$spacing_class.'" ' . $m5_fx_type . ' '.$m5_look.'>
    <div class=" dp-pos:' .$m5_align_content.' '.$m5_clmns_fixedw.' '.$m5_clmns_fixedw_sm.'">';



if ($m5_intro_head . $m5_intro_txt != '') {
    $mod .= '<div class="mod-intro-header' . ($m5_txt_lt ? ' mod-txt-lght ' : '') . ' '.$m5_intro_pos.'">
                <div class="mod-default-spacing:' . $m5_intro_spacing . ' ' . $m5_intro_algnmnt . '">
                    <div class="mod-head-pos '.$m5_intro_pos.'" '.$m5_intro_max_w.'>';
                        $introPadTop = '';
                        if ($m5_intro_head != '') {
                            if ($m5_intro_use_h1) {
                                $m5_intro_head = '<h1 class="' . $m5_intro_head_sz . ' ">' . $m5_intro_head . '</h1>';
                            } else {
                                $m5_intro_head = '<h2 class="' . $m5_intro_head_sz . '">' . $m5_intro_head . '</h2>';
                            }
                            $mod .= '<div class="mod-intro-title">' . $m5_intro_head . '</div>';
                            $introPadTop = ' dp-pad:10px:top ';
                        }
                        if ($m5_intro_txt != '' && strlen(strip_tags($m5_intro_txt)) > 1) {
                            $mod .= '<div class="mod-intro-txt ' . $m5_intro_txt_sz . ' ' . $introPadTop . '">' . apply_filters('the_content', $m5_intro_txt) . '</div>';
                        }
                        $mod .= '</div>
                                </div>
                                </div>';
}




$mod .= '<div class="accordion '.($m5_txt_lt ? ' mod-txt-lght ' : '').'">';

if (have_rows('m5_section')) {
    while (have_rows('m5_section')) : the_row();
        $m5_section_title = get_sub_field('m5_section_title');
        $mod .= '<div class="m5-section">
                    <div class="m5-section-hit">
                        <div class="m5-section-header dp-pad:15px ' . $m5_head_sz . '">' .
                            $m5_section_title . '</div>
                    </div>
                    <div class="m5-expander">
                        <div class="m5-sizer">';

        if (have_rows('m5_section_item')) {
            $faqarray_item='';
           
            while (have_rows('m5_section_item')) : the_row();
                 $m5_section_text = get_sub_field('m5_section_text');
                $faqarray_item.= $m5_section_text;
                $mod .= '<div class="m5-item dp-pad:25pc' . $m5_exp_p_sz . '">' . $m5_section_text . '</div>';
            endwhile;
        }

        $mod .= '</div>
                </div>
            </div>';
    $faqarray_item = array(strip_tags($m5_section_title),strip_tags($faqarray_item));
      if(is_array($m5_schema)){
          array_push($m5_schema,$faqarray_item);
    }
    endwhile;
    array_push($ss_faqarray,$m5_schema);
}

$mod .= '</div>';

if ($m5_txt_bot != '') {
    $mod .= '<div class="bottom-txt dp-pad:50pc:top dp-pad:50pc:bot '.($m5_txt_lt ? ' mod-txt-lght ' : '').'">' .
        ss_add_pclass(apply_filters('the_content', $m5_txt_bot), $m5_closing_algnmnt.' '.$m5_closing_txt_sz) . '</div>';
}

$mod .= '</div>
</div>';

if ($m5_hrb) {
    $mod .= '<hr class="section-rule">';
}

if (!get_field('m5_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>