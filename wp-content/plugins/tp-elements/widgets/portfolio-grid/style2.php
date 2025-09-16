<?php 
    $cat = $settings['portfolio_category'];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if(empty($cat)){
    	$best_wp = new wp_Query(array(
				'post_type'      => 'tp-portfolios',
				'posts_per_page' => $settings['per_page'],								
		));	  
    }   
    else{
    	$best_wp = new wp_Query(array(
				'post_type'      => 'tp-portfolios',
				'posts_per_page' => $settings['per_page'],				
				'tax_query'      => array(
			        array(
						'taxonomy' => 'tp-portfolio-category',
						'field'    => 'slug', //can be set to ID
						'terms'    => $cat //if field is ID you can reference by cat/term number
			        ),
			    )
		));	  
    }

    $x=1;
 	$details_btn_text = !empty($settings['details_btn_text']) ? $settings['details_btn_text'] : 'Case Details';
	while($best_wp->have_posts()): $best_wp->the_post();	
		
		$content       = get_the_content();

		$cats_show = get_the_term_list( $best_wp->ID, 'tp-portfolio-category', ' ', '<span class="separator"> </span> ');
		$termsArray  = get_the_terms( $best_wp->ID, "tp-portfolio-category" );  //Get the terms for this particular item
		$termsString = ""; //initialize the string that will contain the terms
		$termsSlug   = "";

		foreach ( $termsArray as $term ) { 
			$termsString .= 'filter_'.$term->slug.' '; 
			$termsSlug .= $term->name;
		}		
								
	?>

	<div class="col grid-item <?php echo $termsString;?>">

		<div class="portfolio-item <?php echo esc_attr( $row_gap ); ?> ">
			<div class="portfolio-item-image portfolio-image-overlay-gradient">
				<!-- icon with popup image -->
				<?php if( ( $settings[ 'portfolio_popup_type' ] == 'icon_with_popup' ) ) : ?>
				<a class="popup-images" href="<?php echo esc_url( get_the_post_thumbnail_url(get_the_ID(), 'full') ); ?>"><?php the_post_thumbnail($settings['thumbnail_size']);?>
				<?php if(!empty($settings['portfolio_icon'])) : ?>
				<span class="popup-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['portfolio_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
				</a>
				<?php endif; ?>
				<?php if( ( $settings[ 'portfolio_popup_type' ] !== 'icon_with_popup' ) ) : ?>
				<a class="popup-images" href="<?php the_permalink();?>"><?php  the_post_thumbnail($settings['thumbnail_size']);?>
				<!-- icon with details link -->
				<?php if(!empty($settings['portfolio_icon']) && ( $settings[ 'portfolio_popup_type' ] == 'icon_with_link' ) ) : ?>
					<span class="popup-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['portfolio_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
				</a>
				<?php endif; ?>
			</div>
			<?php if( ( $settings[ 'portfolio_content_type' ] == 'with_content' ) || ( $settings[ 'portfolio_content_type' ] == 'both_content' ) ) : ?>
			<div class="portfolio-item-content portfolio-item-content-absolute">
				<div class="portfolio-item-content-inner">

					<div class="portfolio-item-content-inner-text">
						<?php if( !empty( $cats_show ) ) : ?>
						<span class="portfolio-cat"><?php echo $cats_show; ?></span>
						<?php endif; ?>
						<?php if(get_the_title()):?>
						<h4 class="portfolio-title mb-0"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
						<?php endif; ?>
						
					</div> 

					<?php if( $settings['portfolio_btn_show_hide'] == 'yes' ){ ?>
					<div class="portfolios-btn-part ">
						<?php 
							$link_open = $settings['portfolio_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 		    		 
							$icon_position = $settings['portfolio_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
						?>		    		
						<a class="portfolios-btn <?php echo esc_html($icon_position); ?>" href="<?php the_permalink(); ?>" <?php echo wp_kses_post($link_open); ?>>
							<?php if( $settings['portfolio_btn_icon_position'] == 'before' ) : ?>
								<?php if($settings['portfolio_btn_icon']): ?>
								<?php \Elementor\Icons_Manager::render_icon( $settings['portfolio_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if( !empty( $settings['portfolio_btn_text'] ) ) : ?>
							<span class="btn_text">
								<?php echo esc_html($settings['portfolio_btn_text']);?>    						
							</span>	
							<?php endif; ?>
							<?php if( $settings['portfolio_btn_icon_position'] == 'after' ) : ?> 				
								<?php if($settings['portfolio_btn_icon']): ?>
								<?php \Elementor\Icons_Manager::render_icon( $settings['portfolio_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php endif; ?>
							<?php endif; ?>
						</a>	 
					</div>
					<?php } ?>

				</div>
			</div>
			<?php endif; ?>

		</div>


    </div>
	        
	<?php
	$x++;	
	endwhile;
	wp_reset_query();  
 ?>  
