<?php // check if the flexible content field has rows of data
    
if(!get_field('m9_deactivate')){

	$modoutput = do_shortcode(get_field('m9_txt'));
    echo $modoutput;

}
else{
    echo'';
}
?>

