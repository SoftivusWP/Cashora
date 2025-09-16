<?php 
    $cat = $settings['portfolio_category'];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $details_btn_text = !empty($settings['details_btn_text']) ? $settings['details_btn_text'] : 'Case Studies';
	if($settings['show_releted_post'] == 'yes' ){

		$all_term_pf = get_the_terms( $post->ID, 'tp-portfolio-category' );
		$releted_cat = [];
		if( is_array($all_term_pf) ){
			foreach ($all_term_pf as $terms_pf ) {
				$releted_cat[] = $terms_pf->slug;
			}
		}
			$best_wp = new wp_Query(array(
				'post_type'      => 'tp-portfolios',
				'posts_per_page' => $settings['per_page'],
				'offset'		 => $settings['post_offset'],
				'orderby' => $settings['order_by'],
                'order' => $settings['order'],
				'post__not_in' => array( get_the_ID() ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'tp-portfolio-category',
						'field'    => 'slug', //can be set to ID
						'terms'    => $releted_cat //if field is ID you can reference by cat/term number
					),
				)
			));
	}else {
		if(empty($cat)){
			$best_wp = new wp_Query(array(
					'post_type'      => 'tp-portfolios',
					'posts_per_page' => $settings['per_page'],	
					'orderby' => $settings['order_by'],
                	'order' => $settings['order'],							
			));	  
		}   
		else{
			$best_wp = new wp_Query(array(
					'post_type'      => 'tp-portfolios',
					'posts_per_page' => $settings['per_page'],	
					'offset'		 => $settings['post_offset'],
					'orderby' => $settings['order_by'],
                	'order' => $settings['order'],			
					'tax_query'      => array(
						array(
							'taxonomy' => 'tp-portfolio-category',
							'field'    => 'slug', //can be set to ID
							'terms'    => $cat //if field is ID you can reference by cat/term number
						),
					)
			));	  
		}
	}

    $x = 1;

    $xx = 1;

	while($best_wp->have_posts()): $best_wp->the_post();
	$cats_show = get_the_term_list( $best_wp->ID, 'tp-portfolio-category', ' ', '<span class="separator">,</span> ');	
	$termsArray  = get_the_terms( $best_wp->ID, "tp-portfolio-category" );  //Get the terms for this particular item
	$termsString = ""; //initialize the string that will contain the terms
	$termsSlug   = "";
	foreach ( $termsArray as $term ) { 
		$termsString .= 'filter_'.$term->slug.' '; 
		$termsSlug .= $term->name;
	}
	$content       = get_the_content();
	$client        = get_post_meta( get_the_ID(), 'client', true );
	$location      = get_post_meta( get_the_ID(), 'location', true );
	$surface_area  = get_post_meta( get_the_ID(), 'surface_area', true );
	$created       = get_post_meta( get_the_ID(), 'created', true );
	$date          = get_post_meta( get_the_ID(), 'date', true );
	$project_value = get_post_meta( get_the_ID(), 'project_value', true );
	?>	
	<div class="col-lg-<?php echo esc_html($settings['portfolio_columns']);?> grid-item <?php echo $termsString;?>">
		<div class="portfolio-item content-overlay">
	       <ul class="banner-inner">
	       	
	       		<?php $imgval = get_the_post_thumbnail_url(); ?>	   		

		        <li class="item p-title">

		            <div class="pos pstyle">0<?php echo $xx++; ?></div>	
		            <?php if(get_the_title()): ?>
		           		<a href="<?php the_permalink(); ?>"  data-img="<?php echo esc_url($imgval); ?>" data-fx="1" class="tps-img-reveal-item image-title" data-letters="<?php the_title(); ?>"><?php the_title(); ?></a>
		           	<?php endif; ?>

		            <a href="<?php the_permalink(); ?>" class="portfolio-button style_eight"><i class="fas fa-arrow-right"></i></a>
		        </li>

		    </ul>
		 </div>
	 </div>
	<?php
	$x++;	
	endwhile;
	wp_reset_query();