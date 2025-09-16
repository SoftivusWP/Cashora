<?php if($settings['blog_image'] == 'yes') :?>
    <?php if ( has_post_thumbnail() ) { ?>
<div class="grid-item col-xxl-<?php echo esc_attr($col_xxl); ?> col-xl-<?php echo esc_attr($col_xl); ?> col-lg-<?php echo esc_attr($col_lg); ?> col-md-<?php echo esc_attr($col_md); ?> col-sm-<?php echo esc_attr($col_sm); ?> col-<?php echo esc_attr($col_xs); ?> <?php echo esc_attr($termsString);?>">
    <div class="align-items-center no-gutter blog-item pixelaxis-blog-grid1">
        <div class="col-md-12 ">
            <div class="grid-image-part-wrapper">
                <div class="image-part">
                    <a href="<?php the_permalink();?>">
                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                    </a>
                </div>
                <div class="blog-content blog-content-absolute">        
                    <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                    <ul class="blog-meta">
                        <?php if(($settings['blog_avatar_show_hide'] == 'yes') && !empty($post_admin) ){ ?>
                            <li><span class="meta_author"><?php echo esc_html__( 'By', 'tp-elements' ); ?> <?php echo esc_html($post_admin);?></span></li>
                        <?php } ?>
                        <?php if(($settings['blog_cat_show_hide'] == 'yes') && !empty($category ) ){ ?>
                            <li><span class="meta_category"><?php echo esc_html($category[0]->cat_name);?></span></li>
                        <?php } ?>
                        <?php if(($settings['blog_date_show_hide'] == 'yes') ){ ?>						
                            <li><span class="meta_date"><?php echo esc_html( $full_date ); ?></span></li>						
                        <?php } ?>
                        <?php if(($settings['blog_comments_show_hide'] == 'yes') && !empty($comment_ccount ) ){ ?>
                            <li><span class="meta_comments"><?php echo esc_html( $comment_ccount )  . esc_html__( ' Comments', 'tp-elements' );?></span></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                    <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                    <p class="txt mt-15 mb-0"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                    <?php } ?>
                    <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
                    <div class="btn-part mt-15">
                        <a class="readon-arrow" href="<?php the_permalink(); ?>">
                            <?php echo esc_html($settings['blog_btn_text']);?><i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php endif; ?>