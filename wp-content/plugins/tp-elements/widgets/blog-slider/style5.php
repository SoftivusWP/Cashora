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
					
				</div>
			</div>
			<div class="col-bottom">
				<div class="blog-content">        
				<?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
					<ul class="blog-meta">
						
						<?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
						<li class="cat_list">
						<i class="fas fa-tags"></i> <?php the_category( ); ?>
						</li>
						<?php } ?>
						
						<?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
						<li>
							<?php if(!empty($full_date)){ ?>
							<div class="blog-badge"> <i class="tp-clock-regular"></i> <?php echo esc_html($full_date);?></div>
							<?php } ?>
						</li>
						<?php } ?>
						
					</ul>
					<?php } ?>
				
					<h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
					<div class="footer-area">
					<?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
						<div class="left-area">
							<?php echo get_avatar(get_the_author_meta( 'ID' ), 40);?>
							<div class="info">
								
									<?php if(!empty($post_admin)){ ?>
									<h6 class="title"><?php echo esc_html($post_admin);?></h6>
									<?php } ?>
									<span><?php echo esc_html__('Author','tp-elements');?></span>					
								
								
							</div>
						</div>
						<?php } ?>
						<?php if($settings['blog_readmore_text']) : ?>
						<div class="blog-btn pixelaxis-button">
							<a class="tps-read-more btn-primary" href="<?php the_permalink(); ?>">
							<?php echo $settings['blog_readmore_text'];?> </a>								
						</div>
					<?php endif; ?>
					</div>
					
				</div>
			</div>
		</div>
        
    </div>
	<?php	
	endwhile;
	wp_reset_query();  
 ?>  
