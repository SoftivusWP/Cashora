
<?php 
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
		<div class="team-item swiper-slide">
			<div class="tps-team-one-start">
				<div class="wrapper">
					<?php if(has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>" class="thumbnail">
							<?php the_post_thumbnail('elevate-team-slider'); ?>
						</a>
					<?php endif; ?>
					<div class="inner">
						<?php if(get_the_title()):?>
							<a href="<?php the_permalink(); ?>" class="name">
								<h5 class="title"><?php the_title(); ?></h5>
							</a>
						<?php endif; ?>
						<?php if($designation): ?>
							<span class="desig"><?php echo esc_html($designation);?></span>
						<?php endif; ?>

						<?php if( $fb || $gp || $tw || $ins || $ldin ): ?> 
							<div class="info-wrapper">
								<div class="single">									
									<i class="tp-envelope"></i>
									<a href="<?php the_permalink(); ?>"><?php echo esc_html($show_phone); ?></a>									
								</div>
								<!-- single info -->
								<div class="single">									
									<i class="tp-phone-volume"></i>
									<a href="<?php the_permalink(); ?>"><?php echo esc_html($show_email); ?></a>									
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php	
	endwhile;
	wp_reset_query();  
?>  
