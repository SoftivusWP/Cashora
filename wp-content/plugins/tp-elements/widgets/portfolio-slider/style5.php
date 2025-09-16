<?php 
	$cat   = $settings['portfolio_category'];

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
    $details_btn_text = !empty($settings['details_btn_text']) ? $settings['details_btn_text'] : 'Case Details';
	while($best_wp->have_posts()): $best_wp->the_post();			
	$cats_show = get_the_term_list( $best_wp->ID, 'tp-portfolio-category', ' ', '<span class="separator">,</span> ');							
	?>
	<div class="grid-item swiper-slide">
		
		<div class="tps-business-case-s-2">

			<a class="center-image" href="<?php the_permalink();?>" class="thumbnail">
				<?php the_post_thumbnail($settings['thumbnail_size']);?>
				<?php if(!empty($settings['card_image_shape']['url'])) : ?>
					<div class="icon">
						<img  src="<?php echo $settings['card_image_shape']['url'];?>" alt="icon">
					</div>
				<?php endif; ?>
			</a>		
					
		</div>        
	</div>
	<?php	
	endwhile;
	wp_reset_query();  
 ?>  
