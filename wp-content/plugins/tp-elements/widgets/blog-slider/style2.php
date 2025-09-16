<?php 
	$cat   = $settings['portfolio_category'];

	if(empty($cat)){
    	$best_wp = new wp_Query(array(
				'post_type'      => 'post',
				'posts_per_page' => $settings['per_page'],								
		));	  
    }   
    else{
    	$best_wp = new wp_Query(array(
			'post_type'      => 'post',
			'posts_per_page' => $settings['per_page'],				
			'tax_query'      => array(
		        array(
					'taxonomy' => 'category',
					'field'    => 'slug', //can be set to ID
					'terms'    => $cat //if field is ID you can reference by cat/term number
		        ),
		    )
		));	  
    }
	while($best_wp->have_posts()): $best_wp->the_post();			
	$cats_show = get_the_term_list( $best_wp->ID, 'category', ' ', '<span class="separator">,</span> ');	
	$full_date      = get_the_date();
					$blog_date      = get_the_date('M d y');	
					$post_admin     = get_the_author();						
	?>
	<div class="align-items-center no-gutter blog-item pixelaxis-blog-grid1 swiper-slide">
		<div class="tps-blog-h-2-wrapper">
			<div class="col-top">
				<div class="image-part">
					<a href="<?php the_permalink();?>">
						<?php the_post_thumbnail($settings['thumbnail_size']); ?>
					</a> 
					<?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>							
						<div class="blog-badge"> 
							<div class="date-2">
								<span class="date"><?php echo get_the_date('d'); ?></span>
								<span class="month"><?php echo get_the_date('M'); ?></span>
							</div>
							<div class="year">								
								<?php echo get_the_date('Y'); ?>
							</div>
						</div>							
					<?php } ?>
				
				</div>
			</div>
			<div class="col-bottom">
				<div class="blog-content">        
				<?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
					<ul class="blog-meta">
						<?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
							<li class="cat_list">
								<?php the_category( ); ?>
						</li>
						<?php } ?>
						<?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
							<?php if(!empty($post_admin)){ ?>
							<li>/ <span> By </span><span class="author"><?php echo esc_html($post_admin);?></span></li>
							<?php } ?>
						<?php } ?>
					</ul>
					<?php } ?>
				
					<h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
					<?php if($settings['blog_readmore_text']) : ?>						
						<div class="blog-btn pixelaxis-button">
							<a class="tps-read-more btn-primary" href="<?php the_permalink(); ?>">
							<?php echo $settings['blog_readmore_text'];?> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none"><path d="M11.0039 3.414L2.39691 12.021L0.98291 10.607L9.58891 2H2.00391V-3.8147e-06H13.0039V11H11.0039V3.414Z" fill="white"></path></svg></a>								
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
