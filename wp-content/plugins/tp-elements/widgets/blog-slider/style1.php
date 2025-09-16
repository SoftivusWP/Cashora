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
	$cats_show      = get_the_term_list( $best_wp->ID, 'category', ' ', '<span class="separator">,</span> ');	

    $category = get_the_category(); 

	$full_date      = get_the_date();
    $blog_date      = get_the_date('d');	
    $blog_month      = get_the_date('M');    
    $post_admin     = get_the_author();	
    $comment_ccount = wp_count_comments()->total_comments;					
	?>
	<div class="align-items-center no-gutter blog-item pixelaxis-blog-grid1 swiper-slide">
        <div class="col-top">
            <div class="image-part">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                </a> 
                <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                    <?php if(!empty($blog_date || $blog_month)){ ?>
                    <div class="blog-badge">
                        <span class="b-date"><?php echo esc_html($blog_date);?></span> 
                        <span class="b-month"><?php echo esc_html($blog_month);?></span>
                    </div>
                    <?php } ?>
                <?php } ?>           
            </div>
        </div>
        <div class="col-bottom">
            <div class="blog-content">        
            <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
                <ul class="blog-meta">
                    <?php if(($settings['blog_cat_show_hide'] == 'yes') && !empty($category ) ){ ?>
                            <li><span class="meta_category"><i class="tp tp-tags"></i> <?php echo esc_html($category[0]->cat_name);?></span></li>
                        <?php } ?>
                    <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
                        <?php if(!empty($post_admin)){ ?>
                        <li><i class="tp tp-user-2"></i><span> By </span><span class="author"><?php echo esc_html($post_admin);?></span></li>
                        <?php } ?>
                    <?php } ?>
                    <?php if(($settings['blog_comments_show_hide'] == 'yes') && !empty($comment_ccount ) ){ ?>
                        <li><i class="tp tp-message"></i><span class="meta_comments"><?php echo esc_html( $comment_ccount )  . esc_html__( ' Comments', 'tp-elements' );?></span></li>
                    <?php } ?>
                </ul>
                <?php } ?>            
                <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <?php if($settings['blog_readmore_text']) : ?>
                    <a class="tps-read-more" href="<?php the_permalink();?>"><?php echo $settings['blog_readmore_text'];?> <i class="tp tp-arrow-right"></i></a>
                <?php endif; ?>
            
            </div>
        </div>
        
    </div>
	<?php	
	endwhile;
	wp_reset_query();  
 ?>  
