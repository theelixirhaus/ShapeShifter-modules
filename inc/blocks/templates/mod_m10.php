<?php

	$m10_id=get_field('m10_module');

	$params=[];
	$m10_look = get_field('m10_look');
	$m10_class = get_field('m10_class');
	$m10_fx = get_field('m10_fx');

    $m10_fx_type='';

    if($m10_fx){
        $m10_fx_type = ' data-fx="'.$m10_fx.'"';
    }


	echo'<div class="mod mod-m10 '.$m10_class.' '.$m10_look.'" data-mod="'.$modid.'" '.$m10_fx_type.'>';
	if($m10_id !=''){

    	echo ss_get_content($m10_id);
	}
	else{
		echo '<div class="dp-txt:cntr dp-pos:cntr dp-pad:50pc" style="sans-serif"><h3> Select a Module</h3></div>';
	}
    echo '</div>';