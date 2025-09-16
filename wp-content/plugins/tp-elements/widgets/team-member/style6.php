<div class="rs-team-grid rs-team team-grid-<?php echo esc_html($settings['team_grid_style']);?> ">
<?php if($settings['show_filter'] == 'filter_show'){
		$grid = 'grid';

	}else{
		$grid = "";
	}?>
	<div class="row <?php echo $grid; ?>">
		 	<?php //******************//
		 		$x = 1;
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
				    $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';			
				    									   
					//retrive social icon values	
					$content = get_the_content();		
					$facebook    = get_post_meta( get_the_ID(), 'facebook', true );
					$twitter     = get_post_meta( get_the_ID(), 'twitter', true );
					$google_plus = get_post_meta( get_the_ID(), 'google_plus', true );
					$instagram    = get_post_meta( get_the_ID(), 'instagram', true );
					$linkedin    = get_post_meta( get_the_ID(), 'linkedin', true );
					$show_phone  = get_post_meta( get_the_ID(), 'phone', true );
					$show_email  = get_post_meta( get_the_ID(), 'email', true );
					
					$fb   ='';
					$tw   ='';
					$gp   ='';
					$ins  ='';
					$ldin ='';
				
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

					
				<div class="col-lg-<?php echo esc_html($settings['team_columns']);?> col-md-6 col-xs-1 <?php echo $termsString;?> grid-item">
				<div class="single-team-three">
                <?php if(has_post_thumbnail()) : ?>
                    <div class="thumbnail">
                            <a href="<?php the_permalink(); ?>" class="thumbnail">
                                <?php the_post_thumbnail('elevate-team-slider'); ?>
                            </a>
                        <?php if( $fb || $gp || $tw || $ins || $ldin ): ?> 
                            <div class="social-team-wrapper">
                                <ul>
                                    <li><?php echo wp_kses_post($fb);?></li>
                                    <li><?php echo wp_kses_post($tw);?></li>
                                    <li><?php echo wp_kses_post($ins);?></li>
                                    <li><?php echo wp_kses_post($ldin);?></li> 
                                </ul>
                            </div>
                        <?php endif; ?>
						<span class="tp-team-speaker"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/speaker.png"><?php echo esc_html__('Speaker', 'tp-elements'); ?></span>
                    </div>
                <?php endif; ?> 
                <?php if(get_the_title()) : ?>
                    <div class="content-area">
                        <?php if(get_the_title()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <h6 class="name"><a href="<?php the_permalink(); ?>"><?php echo esc_html(the_title()); ?></a></h6>
                            </a>
                        <?php endif; ?>
						<?php if($designation): ?>
                            <span class="designation">
                                <?php echo esc_html($designation);?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
					if($linkedin!=''){
						$ldin_popup='<a href="'.$linkedin.'" class="social-icon" '.$icon_style.'><i class="fab fa-linkedin-in"></i></a>';
					}
				?>

				<div id="rs_popupBox6_<?php echo esc_attr($x);?>" class="rspopup_style1 mfp-with-anim mfp-hide" <?php echo wp_kses_post($popup_background);?>>
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

									<?php if( $fb || $gp || $tw || $ldin ): ?>
								  	<div class="rs-social-icons">
										<div class="social-icons1">
											<?php echo wp_kses_post($fb_popup);
											echo wp_kses_post($gp_popup);
											echo wp_kses_post($tw_popup);
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