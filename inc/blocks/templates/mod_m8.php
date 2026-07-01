<?php

$m8_look = get_field('m8_look');
$m8_look = $m8_look ? ' data-look="'.$m8_look.'"' : '';
$m8_almnt = get_field('m8_almnt');
$m8_nopad = get_field('m8_nopad');
$m8_scrolltoggle = get_field('m8_scrolltoggle');
$m8_spacing = get_field('m8_spacing');
$m8_class = get_field('m8_class');
$m8_fillw = get_field('m8_fillw');
$m8_clmns_fixedw_sm = get_field('m8_clmns_fixedw_sm') ? ' mod-contain-sm ' : '';

if ($m8_scrolltoggle) {
    $m8_class .= ' scrolltoggle';
}

$mod_class = 'mod mod-m8 ' . $m8_class;
$mod = '';

$mod .= '<!-- Start Horizontal Rule -->
<section class="dp-pos:'.$m8_almnt.' ' . $m8_class . ' ' . $mod_class . ' ' . ($m8_fillw == '' ? 'dp-contain' : 'full-width') . ' ' . $m8_clmns_fixedw_sm . '">
    <div class="mod-default-spacing:' . $m8_spacing . '" '.$m8_look.'>
        <hr />
    </div>
</section>
<!-- End Horizontal Rule -->';

if (!get_field('m8_deactivate')) {
    echo $mod;
} else {
    echo '';
}
?>