<?php 
    $post_id      = get_the_id();
    $cats_show = get_the_term_list( $post_id, 'tp-portfolio-category', ' ', '<span class="separator">,</span> ');
    $post_date = get_the_date('F j, Y', $post_id);
    $author_name = get_the_author_meta('display_name'); 
    $group_field_values = get_post_meta( $post_id, 'pf_details', true );

    $gallery_images = get_post_meta(get_the_ID(), 'tp_gallery_images', true);

?>
<div class="tp-portfolio-inner-content">
    <div class="tp-portfolio-inner-content-text">
        <div class="row">
                                            
            <?php if (!empty($gallery_images) && is_array($gallery_images)) : ?>
            <div class="col-lg-12">
                <div class="tp-portfolio-inner-content-slider tp-top-image-carousel swiper mb-50">
                    <div class="swiper-wrapper">
                        <?php foreach ($gallery_images as $image_id => $image_url) : ?>
                        <div class="tp-portfolio-inner-content-slide swiper-slide">
                            <img src="<?php echo esc_url($image_url); ?>" alt="portfolio-image">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tp-portfolio-inner-content-navigation">
                        <span class="portfolio-inner-prev"><i class="tp tp-arrow-left"></i></span>
                        <span class="portfolio-inner-next"><i class="tp tp-arrow-right"></i></span>
                    </div>
                </div>
            </div>
            <?php else : ?>
                <?php if ( has_post_thumbnail() ) :  ?>
                <div class="col-lg-12">
                    <div class="tp-portfolio-inner-details-img mb-50">
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'post-thumbnail' ) ); ?>
                    </div>
                </div>
            <?php endif; endif; ?>

            <div class="col-lg-9">
                <div class="tp-portfolio-inner-content-text-wrapper mb-50 pr-lg-4">
                    <h2 class="tp-portfolio-inner-content-text-title"><?php echo the_title(); ?></h2>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="tp-portfolio-inner-content-side mb-50">
                    <?php if( $cats_show ) : ?>
                    <div class="tp-portfolio-inner-side-single mb-20">
                        <h6 class="tp-portfolio-inner-side-title"><?php echo esc_html__('Category:', 'cashora'); ?></h6>
                        <?php echo wp_kses_post($cats_show); ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($author_name) : ?>
                    <div class="tp-portfolio-inner-side-single mb-20">
                        <h6 class="tp-portfolio-inner-side-title"><?php echo esc_html__('Author:', 'cashora'); ?></h6>
                        <span><?php echo esc_html($author_name); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if( $post_date ) : ?>
                    <div class="tp-portfolio-inner-side-single mb-20">
                        <h6 class="tp-portfolio-inner-side-title"><?php echo esc_html__('Date:', 'cashora'); ?></h6>
                        <span><?php echo esc_html($post_date); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if( !empty( $group_field_values ) ) : 
                    foreach ( $group_field_values as $key => $group_item ) : 
                        $info_title = $group_item['pf_info_title'];
                        $info_value = $group_item['pf_info_value'];
                    ?>
                    <div class="tp-portfolio-inner-side-single mb-20">
                        <h6 class="tp-portfolio-inner-side-title"><?php echo esc_html( $info_title ); ?></h6>
                        <span><?php echo esc_html( $info_value ); ?></span>
                    </div>
                    
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


