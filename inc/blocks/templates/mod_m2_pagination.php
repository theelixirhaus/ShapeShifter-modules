<?php 

				
				$results_total_pages = ceil($results_total/$results_per);

				$slug='';
				$results_groups=0;

			
				if($results_total_pages>5){
					$results_groups = ceil($results_total_pages/5);
				}

				$results_group = ceil(($results_page)/$page_incr);


				if($results_total_pages>1) :

					if(isset($wp_query) && $wp_query->query_vars['s']!=''){
						$slug = $slug.$wp_query->query_vars['s'].'/';
					}

					$searchparms='';

					if(isset($_GET['type'])){
						$searchparms.='&type='.$_GET['type'];
					}

					if(isset($_GET['datefrom']) && isset($_GET['dateto']) ){
						if($_GET['datefrom']){
							$searchparms.='&datefrom='.$_GET['datefrom'];
						}
						if($_GET['dateto']){
							$searchparms.='&dateto='.$_GET['dateto'];
						}
					}


					echo '<div class="dp-contain pagination dp-pos:cntr dp-txt:cntr dp-pad:bot dp-pad:bot"><div class="index-nav">';

					if($pagenum>1){
						echo '<span class="pag-action prev dp-show:below:m"><a href="'.$slug.'?pg='.($pagenum-1).$searchparms.'">Prev Page</a></span>';
					}

					if($results_group>1){
						echo '<span class="pag-action prev dp-hide:below:m"><a href="'.$slug.'?pg='.((($results_group-1)*$page_incr)-($page_incr-1)).$searchparms.'">Prev</a></span>';
					}
					echo '<span class="pgnums">';

					/* See if on the last page */
					if($results_group && $results_group != $results_groups){
						$maxcount = min($results_total_pages, $page_incr);

					}
					else{
						$maxcount = (($results_groups*$page_incr)-$results_total_pages)-1;
					}

					/* Count out pages */

					for($i=1; $i<= $maxcount; $i++){
						echo '<span class="pgnum"><a href="'.$slug.'?pg='.($i+(($results_group-1)*$page_incr)).$searchparms.'" class="'.($pagenum == ($i+(($results_group-1)*$page_incr))?'active' :'').'">'.($i+(($results_group-1)*$page_incr)).'</a></span>';
					}
					echo '</span>';

					if($results_groups && ((int)$results_groups>(int)$results_group)){
						echo '<span class="pag-action nex dp-hide:below:m"><a href="'.$slug.'?pg='.((($results_group+1)*$page_incr)-($page_incr-1)).$searchparms.'">Next</a></span>';
					}

					if((int)$results_total_pages>(int)$pagenum){
						echo '<span class="pag-action nex  dp-show:below:m"><a href="'.$slug.'?pg='.($pagenum+1).$searchparms.'">Next Page</a></span>';
					}
					echo '</div></div>';
		//print_r($postArray);

				endif;
				?>