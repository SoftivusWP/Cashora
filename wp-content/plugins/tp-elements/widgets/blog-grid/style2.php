<div class="grid-item col-xxl-<?php echo esc_attr($col_xxl); ?> col-xl-<?php echo esc_attr($col_xl); ?> col-lg-<?php echo esc_attr($col_lg); ?> col-md-<?php echo esc_attr($col_md); ?> col-sm-<?php echo esc_attr($col_sm); ?> col-<?php echo esc_attr($col_xs); ?> <?php echo esc_attr($termsString);?>">
   <div class="align-items-center no-gutter blog-item pixelaxis-blog-grid1">     
         <div class="blog-inner">   
                <?php if($settings['blog_image'] == 'yes') :?>                         
                <div class="image-part <?php echo $settings['image_gray'];?>">
                    <a href="<?php the_permalink();?>">
                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                    </a> 
                </div> 
                <?php endif; ?>             
                <div class="blog-content-wrapper">
                    <?php if(($settings['blog_date_show_hide'] == 'yes') ){ ?>	
                    <div class="blog-content-date">		
                        <span class="blog-date-wrapp">
                            <span class="date"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?></span>
                        </span>				
                    </div>
                    <?php } ?>
                    <div class="blog-content">                                    
                        <?php if( !empty($settings['blog_meta_show_hide']) ){?>
                        <ul class="blog-meta">
                        <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
                            <?php if(!empty($post_admin)){ ?>
                            <li><span>- <?php echo esc_html($post_admin);?></span></li>
                            <?php } ?>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                        <div class="bottom-part">
                            <div class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
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
                    </div> 
                </div>
            </div>                      
                                                                
    </div>
</div>