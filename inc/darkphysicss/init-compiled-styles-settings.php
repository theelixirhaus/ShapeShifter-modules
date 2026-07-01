<?php 
$dp_site_clr=get_field('dp-site-clr','options');
$dp_site_fnt_clr_dk = get_field('dp-site-fnt-clr-dk','options');
$dp_site_fnt_clr_lt = get_field('dp-site-fnt-clr-lt','options');
$dp_site_width = get_field('dp-site-width','options');

$dp_site_width  = ($dp_site_width!=''? $dp_site_width :"1250px");
$dp_site_width_sm = get_field('dp-site-width-sm','options');
$dp_site_width_sm  = ($dp_site_width_sm!=''? $dp_site_width_sm :"950px");
$dp_mobile_portrait = get_field('dp_mobile_portrait','options');
$dp_mobile_portrait =($dp_mobile_portrait!=''? $dp_mobile_portrait :"500px"); 
$dp_tablet_portrait = get_field('dp-tablet-portrait','options'); 
$dp_tablet_portrait = ($dp_tablet_portrait!=''? $dp_tablet_portrait :"768px"); 
$dp_desktop= get_field('dp-desktop','options'); 
$dp_desktop  = ($dp_desktop!=''? $dp_desktop :"1024px"); 
$dp_desktopxl= get_field('dp-desktopxl','options'); 
$dp_desktopxl  = ($dp_desktopxl!=''? $dp_desktopxl :"2000px"); 

$dp_site_padding = get_field('dp-site-padding', 'options');

$dp_p_lh= get_field('dp-p-lh','options');
$dp_h_lh= get_field('dp-h-lh','options');
$dp_p_marg= get_field('dp-p-marg','options'); 

$dp_rnd= get_field('dp-rnd','options');

$dp_font_primary= get_field('dp-font-primary','options'); 
$dp_font_secondary= get_field('dp-font-secondary','options'); 
$dp_font_tertiary= get_field('dp-font-tertiary','options'); 

$dp_color_primary= get_field('dp-color-primary','options'); 
$dp_color_secondary= get_field('dp-color-secondary','options'); 
$dp_color_tertiary= get_field('dp-color-tertiary','options'); 
$dp_color_quaternary= get_field('dp-color-quaternary','options'); 
$dp_color_quinary= get_field('dp-color-quinary','options'); 
$dp_color_senary= get_field('dp-color-senary','options'); 
$dp_color_severnary= get_field('dp-color-severnary','options'); 
$dp_color_octarnary= get_field('dp-color-octarnary','options'); 
$dp_color_nonary= get_field('dp-color-nonary','options'); 
$dp_color_denary= get_field('dp-color-denary','options'); 

$dp_grey_light= get_field('dp-grey-light','options'); 
$dp_grey_norm= get_field('dp-grey-norm','options'); 
$dp_grey_med= get_field('dp-grey-med','options'); 
$dp_grey_dark= get_field('dp-grey-dark','options');

$dp_txt_headline_xtrabig_xl= get_field('dp-txt-headline-xtrabig-xl','options'); 
$dp_txt_headline_big_xl= get_field('dp-txt-headline-big-xl','options'); 
$dp_txt_headline_med_xl= get_field('dp-txt-headline-med-xl','options'); 
$dp_txt_headline_norm_xl= get_field('dp-txt-headline-norm-xl','options'); 
$dp_txt_headline_small_xl= get_field('dp-txt-headline-small-xl','options');
$dp_txt_big_xl= get_field('dp-txt-big-xl','options');
$dp_txt_med_xl= get_field('dp-txt-med-xl','options');
$dp_txt_norm_xl= get_field('dp-txt-norm-xl','options');
$dp_txt_small_xl= get_field('dp-txt-small-xl','options');
$dp_txt_xsmall_xl= get_field('dp-txt-xsmall-xl','options');


$dp_txt_headline_xtrabig= get_field('dp-txt-headline-xtrabig','options'); 
$dp_txt_headline_big= get_field('dp-txt-headline-big','options'); 
$dp_txt_headline_med= get_field('dp-txt-headline-med','options'); 
$dp_txt_headline_norm= get_field('dp-txt-headline-norm','options'); 
$dp_txt_headline_small= get_field('dp-txt-headline-small','options');
$dp_txt_big= get_field('dp-txt-big','options');
$dp_txt_med= get_field('dp-txt-med','options');
$dp_txt_norm= get_field('dp-txt-norm','options');
$dp_txt_small= get_field('dp-txt-small','options');
$dp_txt_xsmall= get_field('dp-txt-xsmall','options');


$dp_txt_headline_xtrabig_mob= get_field('dp-txt-headline-xtrabig-mob','options'); 
$dp_txt_headline_big_mob= get_field('dp-txt-headline-big-mob','options'); 
$dp_txt_headline_med_mob= get_field('dp-txt-headline-med-mob','options'); 
$dp_txt_headline_norm_mob= get_field('dp-txt-headline-norm-mob','options'); 
$dp_txt_headline_small_mob= get_field('dp-txt-headline-small-mob','options');
$dp_txt_big_mob= get_field('dp-txt-big-mob','options');
$dp_txt_med_mob= get_field('dp-txt-med-mob','options');
$dp_txt_norm_mob= get_field('dp-txt-norm-mob','options');
$dp_txt_small_mob= get_field('dp-txt-small-mob','options');
$dp_txt_xsmall_mob= get_field('dp-txt-xsmall-mob','options');



$dp_defaul_overflow= get_field('dp-default-overflow', 'options');


$styleoutput.= ':root{

	 --dp-site-padding:'.($dp_site_padding!=''? $dp_site_padding :"100px").';

	/* Responsive sizes*/
	 --dp-site-width:'.($dp_site_width!=''? $dp_site_width :"1100px").';
	 --dp-mobile-portrait:'.(isset($dp_mobile_portrait) && $dp_mobile_portrait!=''? $dp_mobile_portrait :"500px").'; 
	 --dp-tablet-portrait: '.(isset($dp_mobile_portrait) && $dp_mobile_portrait !=''? $dp_tablet_portrait :"768px").'; 
	 --dp-desktop: '.(isset($dp_desktop) && $dp_desktop!=''? $dp_desktop :" 1024px").'; 
	 --dp-desktopxl: '.(isset($dp_desktopxl) && $dp_desktopxl!=''? $dp_desktopxl :"1250px").';



	/* Paragraph Line Height and Margin */
	 --dp-p-lh: '.($dp_p_lh!=''? $dp_p_lh :"1.2em").';
	 --dp-h-lh:'.($dp_p_lh!=''? $dp_p_lh :"1.3em").';
	 --dp-p-marg:'.($dp_p_lh!=''? $dp_p_lh :"26px").';


	/* Round Corner Default Bezier */
	--dp-rnd: '.($dp_rnd!=''? $dp_rnd :" 20px").';


	/* Font  Faces */

	 --dp-font-primary: '.($dp_font_primary!=''? $dp_font_primary : '"Barlow Semi Condensed", sans-serif').';
	 --dp-font-secondary:  '.($dp_font_secondary!=''? $dp_font_secondary : '"Martel", serif').';
	 --dp-font-tertiary:  '.($dp_font_tertiary!=''? $dp_font_tertiary :'"Carlito", Arial, Helvetica, Geneva, sans-serif').';


	/*Colors */

	 --dp-color-primary:'.($dp_color_primary!=''? $dp_color_primary :"blue").';
	 --dp-color-secondary:'.($dp_color_secondary!=''? $dp_color_secondary :"red").';
	 --dp-color-tertiary:'.($dp_color_tertiary!=''? $dp_color_tertiary :"green").';
	 --dp-color-quaternary:'.($dp_color_quaternary!=''? $dp_color_quaternary:"orange").';
	 --dp-color-quinary:'.($dp_color_quinary!=''? $dp_color_quinary:"purple").';
	 --dp-color-senary:'.($dp_color_senary!=''? $dp_color_senary:"yellow").';
	 --dp-color-severnary:'.($dp_color_severnary!=''? $dp_color_severnary:"gold").';
	 --dp-color-octarnary:'.($dp_color_octarnary!=''? $dp_color_octarnary:"silver").';
	 --dp-color-nonary:'.($dp_color_nonary!=''? $dp_color_nonary:"pink").';
	 --dp-color-denary:'.($dp_color_denary!=''? $dp_color_denary:"tan").';

	 --dp-grey-light:'.($dp_grey_light!=''? $dp_grey_light:"#979797").';
	 --dp-grey-norm:'.($dp_grey_light!=''? $dp_grey_norm:"#393939").';
	 --dp-grey-med:'.($dp_grey_light!=''? $dp_grey_med:"#656464").';
	 --dp-grey-dark:'.($dp_grey_light!=''? $dp_grey_dark:"#333333").';
	

	/*Text Sizes Big Screen */
	--dp-txt-headline-xtrabig-xl:'.($dp_txt_headline_xtrabig_xl!=''? $dp_txt_headline_xtrabig_xl:($dp_txt_headline_xtrabig!=''? $dp_txt_headline_xtrabig:"45px")).';
	 --dp-txt-headline-big-xl:'.($dp_txt_headline_big_xl!=''? $dp_txt_headline_big_xl:($dp_txt_headline_big!=''? $dp_txt_headline_big:"40px")).';
	 --dp-txt-headline-med-xl:'.($dp_txt_headline_med_xl!=''? $dp_txt_headline_med_xl:($dp_txt_headline_med!=''? $dp_txt_headline_med:"32px")).';
	 --dp-txt-headline-norm-xl:'.($dp_txt_headline_norm_xl!=''? $dp_txt_headline_norm_xl:($dp_txt_headline_norm!=''? $dp_txt_headline_norm:"26px")).';
	 --dp-txt-headline-small-xl:'.($dp_txt_headline_small_xl!=''? $dp_txt_headline_small_xl:($dp_txt_headline_small!=''? $dp_txt_headline_small:"24px")).';

	 --dp-txt-big-xl:'.($dp_txt_big_xl!=''? $dp_txt_big_xl:($dp_txt_big!=''? $dp_txt_big:"22px")).';
	 --dp-txt-med-xl:'.($dp_txt_med_xl!=''? $dp_txt_med_xl:($dp_txt_med!=''? $dp_txt_med:"20px")).';
	 --dp-txt-norm-xl:'.($dp_txt_norm_xl!=''? $dp_txt_norm_xl:($dp_txt_norm!=''? $dp_txt_norm:"18px")).';
	 --dp-txt-small-xl:'.($dp_txt_small_xl!=''? $dp_txt_small_xl:($dp_txt_small!=''? $dp_txt_small:"16px")).';
	 --dp-txt-xsmall-xl:'.($dp_txt_xsmall_xl!=''? $dp_txt_xsmall_xl:($dp_txt_xsmall!=''? $dp_txt_xsmall:"14px")).';

	/* Text Sizes Standard Screen*/
	 --dp-txt-headline-xtrabig:'.($dp_txt_headline_xtrabig!=''? $dp_txt_headline_xtrabig:"45px").';

	 --dp-txt-headline-big:'.($dp_txt_headline_big!=''? $dp_txt_headline_big:"40px").';
	 --dp-txt-headline-med:'.($dp_txt_headline_med!=''? $dp_txt_headline_med:"32px").';
	 --dp-txt-headline-norm:'.($dp_txt_headline_norm!=''? $dp_txt_headline_norm:"26px").';
	 --dp-txt-headline-small:'.($dp_txt_headline_small!=''? $dp_txt_headline_small:"24px").';

	 --dp-txt-big:'.($dp_txt_big!=''? $dp_txt_big:"22px").';
	 --dp-txt-med:'.($dp_txt_med!=''? $dp_txt_med:"20px").';
	 --dp-txt-norm:'.($dp_txt_norm!=''? $dp_txt_norm:"18px").';
	 --dp-txt-small:'.($dp_txt_small!=''? $dp_txt_small:"16px").';
	 --dp-txt-xsmall:'.($dp_txt_xsmall!=''? $dp_txt_xsmall:"14px").';

	/* Text Sizes Mobile */
	 --dp-txt-headline-xtrabig-mob:'.($dp_txt_headline_xtrabig_mob!=''? $dp_txt_headline_xtrabig_mob:"30px").';

	 --dp-txt-headline-big-mob:'.($dp_txt_headline_big_mob!=''? $dp_txt_headline_big_mob:"30px").';
	 --dp-txt-headline-med-mob:'.($dp_txt_headline_med_mob!=''? $dp_txt_headline_med_mob:"26px").';
	 --dp-txt-headline-norm-mob:'.($dp_txt_headline_norm_mob!=''? $dp_txt_headline_norm_mob:"24px").';
	 --dp-txt-headline-small-mob:'.($dp_txt_headline_small_mob!=''? $dp_txt_headline_small_mob:"22px").';

	 --dp-txt-big-mob:'.($dp_txt_big_mob!=''? $dp_txt_big_mob:"20px").';
	 --dp-txt-med-mob:'.($dp_txt_med_mob!=''? $dp_txt_med_mob:"18px").';
	 --dp-txt-norm-mob:'.($dp_txt_norm_mob!=''? $dp_txt_norm_mob:"16px").';
	 --dp-txt-small-mob:'.($dp_txt_small_mob!=''? $dp_txt_small_mob:"14px").';
	 --dp-txt-xsmall-mob:'.($dp_txt_xsmall_mob!=''? $dp_txt_xsmall_mob:"12px").';

	 


	/* Misc */
	 --dp-default-overflow: '.($dp_defaul_overflow!=''? $dp_defaul_overflow:"visible").' /* Default overflow state for containers */
}

@media(min-width:'.$dp_desktopxl.'){
	:root{
	

		 --dp-txt-headline-big:var(--dp-txt-headline-big-xl);
		 --dp-txt-headline-med:var(--dp-txt-headline-med-xl);
		 --dp-txt-headline-norm:var(--dp-txt-headline-norm-xl);
		 --dp-txt-headline-small:var(--dp-txt-headline-small-xl);

		 --dp-txt-big:var(--dp-txt-big-xl);
		 --dp-txt-med:var(--dp-txt-med-xl);
		 --dp-txt-norm:var(--dp-txt-norm-xl);
		 --dp-txt-small:var(--dp-txt-small-xl);
		 --dp-txt-xsmall:var(--dp-txt-xsmall-xl);

	 }
}


@media(max-width:'.$dp_tablet_portrait.'){
	:root{
		 --dp-txt-headline-xtrabig-xl:var(--dp-txt-headline-xtrabig);
		 --dp-txt-headline-big-xl:var(--dp-txt-headline-big);
		 --dp-txt-headline-med-xl:var(--dp-txt-headline-med);
		 --dp-txt-headline-norm-xl:var(--dp-txt-headline-norm);
		 --dp-txt-headline-small-xl:var(--dp-txt-headline-small);

		 --dp-txt-big-xl:var(--dp-txt-big);
		 --dp-txt-med-xl:var(--dp-txt-med);
		 --dp-txt-norm-xl:var(--dp-txt-norm);
		 --dp-txt-small-xl:var(--dp-txt-small);
		 --dp-txt-xsmall-xl:var(--dp-txt-xsmall);




		 --dp-txt-headline-big:var(--dp-txt-headline-big-mob);
		 --dp-txt-headline-med:var(--dp-txt-headline-med-mob);
		 --dp-txt-headline-norm:var(--dp-txt-headline-norm-mob);
		 --dp-txt-headline-small:var(--dp-txt-headline-small-mob);

		 --dp-txt-big:var(--dp-txt-big-mob);
		 --dp-txt-med:var(--dp-txt-med-mob);
		 --dp-txt-norm:var(--dp-txt-norm-mob);
		 --dp-txt-small:var(--dp-txt-small-mob);
		 --dp-txt-xsmall:var(--dp-txt-xsmall-mob);

	 }
}

body.post-type-page{
	font-family:var(--dp-font-primary);
	color:'.$dp_site_fnt_clr_dk.';
	background-color:'.$dp_site_clr.';

}
html .mod .mod-contain-sm{
	max-width:'.$dp_site_width_sm.'
}

html .mod .mod-txt-lght{
	color:'.$dp_site_fnt_clr_lt.';
}

@media(min-width:'.$dp_desktopxl.'){

	.dp-txt\:xl{
		font-size:var(--dp-txt-headline-xtrabig-xl);
	}

}


@media(min-width:'.$dp_mobile_portrait.')and (max-width:'.$dp_desktopxl.'){

	.dp-txt\:xl{
		font-size:var(--dp-txt-headline-xtrabig);
	}

}

@media(max-width:'.$dp_mobile_portrait.'){

	.dp-txt\:xl{
		font-size:var(--dp-txt-headline-xtrabig-mob);
	}

}



';
?>