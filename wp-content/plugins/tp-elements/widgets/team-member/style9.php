
<div class="rs-team-grid rs-team team-grid-<?php echo esc_attr($settings['team_grid_style']); ?> ">
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
				$content     = get_the_content();		
				$facebook    = get_post_meta( get_the_ID(), 'facebook', true );
				$twitter     = get_post_meta( get_the_ID(), 'twitter', true );
				$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
				$google_plus = get_post_meta( get_the_ID(), 'google_plus', true );
				$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
				$linkedin    = get_post_meta( get_the_ID(), 'linkedin', true );
				$show_phone  = get_post_meta( get_the_ID(), 'phone', true );
				$show_email  = get_post_meta( get_the_ID(), 'email', true );
				
				$fb   ='';
				$tw   ='';
				$gp   ='';
				$ig   ='';
				$ins  ='';
				$ldin ='';
			
				if($facebook!=''){
					$fb = '<a href="'.$facebook.'" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a> ';
				}
				if($twitter!=''){
					$tw = '<a href="'.$twitter.'" class="social-icon" target="_blank"><i class="fab fa-twitter"></i></a>';
				}
				if($instagram!=''){
					$ins = '<a href="'.$instagram.'" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>';
				} 
				if($google_plus!=''){
					$gp = '<a href="'.$google_plus.'" class="social-icon" target="_blank"><i class="fab fa-google-plus-g"></i></a> ';
				}
				if($linkedin!=''){
					$ldin = '<a href="'.$linkedin.'" class="social-icon" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
				}
				$plus = '<a href="'.$linkedin.'" class="social-icon" target="_blank"><i class="tp-plus"></i></a>';
			?>
					
			<div class="col-lg-<?php echo esc_html($settings['team_columns']);?> col-md-6 col-xs-1 <?php echo $termsString;?> grid-item">

				<div class="team-item mb-30">
					<div class="single-item position-relative overflow-hidden">
						<?php the_post_thumbnail($settings['thumbnail_size']); ?>
						<div class="hover-item position-absolute">
							<div class="text-item">
								<h4 class="mb-1"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title();?></a></h4>
							</div>
						</div>
					</div>
				</div>

			</div>		

		<?php
			
		endwhile;
		wp_reset_query();  
     ?>  
	</div>
</div>