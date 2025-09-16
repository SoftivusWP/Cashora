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
					$google_plus = get_post_meta( get_the_ID(), 'google_plus', true );
					$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
					$linkedin    = get_post_meta( get_the_ID(), 'linkedin', true );
					$show_phone  = get_post_meta( get_the_ID(), 'phone', true );
					$show_email  = get_post_meta( get_the_ID(), 'email', true );
					$short_bio   = get_post_meta( get_the_ID(), 'shortbio', true );
					
					$fb   =	'';
					$tw   =	'';
					$gp   =	'';
					$ins  =	'';
					$ldin =	'';
				
					if($facebook!=''){
						$fb='<a href="'.$facebook.'" class="social-icon"><i class="fab fa-facebook-f"></i></a> ';
					}
					if($twitter!=''){
						$tw='<a href="'.$twitter.'" class="social-icon"><i class="fab fa-twitter"></i></a>';
					}
					if($google_plus!=''){
						$gp='<a href="'.$google_plus.'" class="social-icon"><i class="fab fa-google-plus-g"></i></a> ';
					}
					if($instagram!=''){
						$ins='<a href="'.$instagram.'" class="social-icon"><i class="fab fa-instagram"></i></a>';
					}
					if($linkedin!=''){
						$ldin='<a href="'.$linkedin.'" class="social-icon"><i class="fab fa-linkedin-in"></i></a>';
					}
				?>					
					<div class="col-lg-<?php echo esc_html($settings['team_columns']);?> col-md-6 col-xs-1 team-style5 <?php echo $termsString;?> grid-item">
						<div class="team-item">
							<div class="team-inner-wrap">
								<div class="image-wrap">
									<?php if(has_post_thumbnail()) : ?>
								    	<a class="pointer-events" href="#rs_popupBox4_<?php echo esc_attr($x);?>" data-effect="mfp-zoom-in">
											<?php the_post_thumbnail($settings['thumbnail_size']); ?>
										</a>
									<?php endif; ?>
								</div>
								<div class="team-content">

									<?php if(get_the_title()):?>
							       		<h3 class="team-name"><a class="pointer-events" href="#rs_popupBox4_<?php echo esc_attr($x);?>" data-effect="mfp-zoom-in"><?php the_title();?></a></h3>
							       <?php endif;

							        if($designation): ?>
										<span class="team-title"><?php echo esc_html($designation);?></span>
									<?php endif ;
									if( $short_bio ) : ?>
										<p class="team-desc"><?php echo esc_html( $short_bio );?></p>
									<?php endif; 
																		
				                  	 if( $fb || $tw || $ins|| $ldin ): ?>
										<div class="social-icons">
											<?php echo wp_kses_post($fb);
												echo wp_kses_post($tw);
												echo wp_kses_post($ins);
												echo wp_kses_post($ldin);
											?>
							        	</div>
								    <?php endif; ?>						    							    
									
								</div>
							</div>
					  	</div>
					</div>

				<!-- Hidden PupupBox Text -->
				<?php
					if($facebook!=''){
						$fb_popup='<a href="'.$facebook.'" class="social-icon" '.$icon_style.'><i class="fab fa-facebook-f"></i></a> ';
					}
					if($twitter!=''){
						$tw_popup='<a href="'.$twitter.'" class="social-icon" '.$icon_style.'><i class="fab fa-twitter"></i></a>';
					}
					if($google_plus!=''){
						$gp_popup='<a href="'.$google_plus.'" class="social-icon" '.$icon_style.'><i class="fab fa-google-plus-g"></i></a> ';
					}
					if($instagram!=''){
						$instagram_popup='<a href="'.$instagram.'" class="social-icon" '.$icon_style.'><i class="fab fa-instagram"></i></a>';
					}
					if($linkedin!=''){
						$ldin_popup='<a href="'.$linkedin.'" class="social-icon" '.$icon_style.'><i class="fab fa-linkedin-in"></i></a>';
					}
				?>

				<div id="rs_popupBox4_<?php echo esc_attr($x);?>" class="rspopup_style1  mfp-with-anim mfp-hide" <?php echo wp_kses_post($popup_background);?>>
					<div class="row">
						<div class="col-md-5">
							<div class="rsteam_img">
								<?php the_post_thumbnail($settings['thumbnail_size']); ?>	
					  		</div>
						</div>
						<div class="col-md-7">
							<div class="rsteam_content">
								<div class="team-content">
									<div class="team-heading">

									  	<h3 class="team-name" <?php echo wp_kses_post($popup_title_color);?>><?php the_title();?></h3>
									  	<span class="team-title" <?php echo wp_kses_post($popup_designation_color);?>><?php echo esc_html( $designation );?></span>
									</div> 
									<?php if( $content): ?>
									<div class="team-des" <?php echo wp_kses_post($popup_content_color);?>>
									  	<?php echo esc_html($content);?>
									</div>
									<?php endif; ?>


									<?php if( $show_phone || $show_email ): ?>
									<div class="contact-info">
										<ul>
											<?php if( $show_phone ): ?>
												<li <?php echo wp_kses_post($popup_phn_email_color);?>><span><?php echo esc_html('Phone:', 'tp-elements');?> </span><?php echo esc_html($show_phone); ?></li>
											<?php endif; ?>

											<?php if( $show_email ): ?>
												<li <?php echo wp_kses_post($popup_phn_email_color);?>><span><?php echo esc_html('Email:', 'tp-elements');?> </span><a href="<?php echo esc_html($show_email); ?>"<?php echo wp_kses_post($popup_phn_email_color);?>><?php echo esc_html($show_email); ?></a></li>
											<?php endif; ?>
										</ul>
									</div>
									<?php endif; ?>

									<?php if( $fb || $tw || $ins || $ldin ): ?>
								  	<div class="rs-social-icons">
										<div class="social-icons1">
											<?php echo wp_kses_post($fb_popup);
											echo wp_kses_post($gp_popup);
											echo wp_kses_post($tw_popup);
											echo wp_kses_post($instagram_popup);
											echo wp_kses_post($ldin_popup);
											?>
								        </div>
								  	</div>
								  	<?php endif; ?> 
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