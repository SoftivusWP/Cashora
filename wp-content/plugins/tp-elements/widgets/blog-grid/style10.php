<div class="grid-item col-xxl-<?php echo esc_attr($col_xxl); ?> col-xl-<?php echo esc_attr($col_xl); ?> col-lg-<?php echo esc_attr($col_lg); ?> col-md-<?php echo esc_attr($col_md); ?> col-sm-<?php echo esc_attr($col_sm); ?> col-<?php echo esc_attr($col_xs); ?> <?php echo esc_attr($termsString);?>">
    <div class="align-items-center g-0 row blog-item pixelaxis-blog-grid1">
        <div class="col-md-12">
            <div class="blog-content-wrapper">
                <?php if($settings['blog_image'] == 'yes') :?>
                <div class="image-part <?php echo $settings['image_gray'];?>">
                    <a href="<?php the_permalink();?>">
                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                    </a> 
                </div>   
                <?php endif; ?>     
                <div class="blog-content">   
                
                    <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>

                    <div class="blog-meta-wrapper">
                    <?php if(($settings['blog_cat_show_hide'] == 'yes') && !empty($category ) ){ ?>
                    <?php the_category( ); ?>
                    <?php } ?>

                    <ul class="blog-meta">
                        <?php if(($settings['blog_avatar_show_hide'] == 'yes') && !empty($post_admin) ){ ?>
                        <li><span class="meta_author"><?php echo esc_html__( 'By', 'tp-elements' ); ?> <?php echo esc_html($post_admin);?></span></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    </div>

                    <h5 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                    <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                    <p class="txt mb-0"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                    <?php } ?>

                    <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
                    <div class="btn-part mt-15">
                        <a class="readon-arrow" href="<?php the_permalink(); ?>">
                            <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <div class="blog_footer d-flex flex-wrap justify-content-between align-items-center">
                    <?php if(($settings['blog_date_show_hide'] == 'yes') ){ ?>						
                    <span class="meta_date"><i class="tp tp-calendar-days"></i> <?php echo esc_html( $full_date ); ?></span>					
                    <?php } ?>
                    <?php if(($settings['blog_comments_show_hide'] == 'yes') && !empty($comment_ccount ) ){ ?>
                    <span class="meta_comments"><i class="tp tp-message"></i> <?php echo esc_html( $comment_ccount );?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>