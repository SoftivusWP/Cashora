<div class="rs-team-grid rs-team team-grid-<?php echo esc_html($settings['team_grid_style']); ?>  ">
<?php if($settings['show_filter'] == 'filter_show'){
		$grid = 'grid';

	}else{
		$grid = "";
	}?>
	<div class="row <?php echo $grid; ?>">
		 	<?php //******************//
		 		$x=1;
		        $cat = $settings['team_category'];
		      
		        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				if(empty($cat)){
		        	$best_wp = new wp_Query(array(
							'post_type'      => 'teams',
							'posts_per_page' => $settings['per_page'],
							'paged'          => $paged					
					));	  
		        }   
		        else{
		        	$best_wp = new wp_Query(array(
							'post_type'      => 'teams',
							'posts_per_page' => $settings['per_page'],
							'paged'          => $paged,
							'tax_query'      => array(
						        array(
									'taxonomy' => 'team-category',
									'field'    => 'slug', //can be set to ID
									'terms'    => $cat //if field is ID you can reference by cat/term number
						        ),
						    )
					));	  
		        }

				while($best_wp->have_posts()): $best_wp->the_post();					
					$termsArray  = get_the_terms( $best_wp->ID, "team-category" );  //Get the terms for this particular item
					$termsString = ""; //initialize the string that will contain the terms
					$termsSlug   = "";
					if(!empty($termsArray)): 
						foreach ( $termsArray as $term ) { 
							$termsString .= 'filter_'.$term->slug.' '; 
							$termsSlug .= $term->name;
						}		
					endif;		
					$content = get_the_content();	
				    $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';			
				   						   
					//retrive social icon values			
					$facebook    = get_post_meta( get_the_ID(), 'facebook', true );
					$twitter     = get_post_meta( get_the_ID(), 'twitter', true );
					$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
					$linkedin    = get_post_meta( get_the_ID(), 'linkedin', true );
					$show_phone  = get_post_meta( get_the_ID(), 'phone', true );
					$show_email  = get_post_meta( get_the_ID(), 'email', true );
					
					$fb   ='';
					$tw   ='';
					$ins  ='';
					$ldin ='';
					
					if($facebook!=''){
						$fb ='<a href="'.$facebook.'"><i class="tp tp-facebook-f"></i></a>';
					}
					if($twitter!=''){
						$tw='<a href="'.$twitter.'"><i class="tp tp-twitter"></i></a>';
					}
					if($instagram!=''){
						$ins='<a href="'.$instagram.'"><i class="tp tp-instagram"></i></a>';
					}
					if($linkedin!=''){
						$ldin ='<a href="'.$linkedin.'"><i class="tp tp-linkedin-in"></i></a>';
					}
				?>

				
				<div class="col-lg-<?php echo esc_html($settings['team_columns']);?> col-md-6 col-xs-1 <?php echo $termsString;?> grid-item">
					<div class="team-item">
						<div class="team-inner-wrap">
							<div class="image-wrap">
								<a  href="<?php the_permalink();?>">
									<?php the_post_thumbnail($settings['thumbnail_size']); ?>
								</a>   
								<div class="team-social">
                                    <div class="main">
                                        <i class="tp tp-plus"></i>
                                    </div>
                                    <div class="team-social-one">
                                         <?php echo $fb ;?>
										 <?php echo $tw ;?>
										 <?php echo $ins ;?>
										 <?php echo $ldin; ?>
                                    </div>
                                </div>
							</div>	
							<div class="team-content">
								<div class="member-desc">
									<h3 class="team-name"><a href="<?php the_permalink();?>" data-effect="mfp-zoom-in"><?php the_title();?></a></h3>
									<span class="team-title"><?php echo esc_html( $designation );?></span>
								</div>								  	
							  	
							</div>					
				  		</div>
			  		</div>
				</div>		
				<?php
				$x++;	
				endwhile;
				wp_reset_query();  
	         ?>  
	</div>
</div>