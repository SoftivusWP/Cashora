<div class="swiper-slide ">
    <div class="tp-product-cat-single" style="background-image: url( <?php echo esc_url( $image_url ); ?> );" >
        <div class="tp-product-cat-content">
            <h4 class="tp-product-cat-title"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo wp_kses_post( $category->name ); ?></a></h4> 
            <a href="<?php echo esc_url( $category_link ); ?>" class="tp-product-cat-btn"><?php echo esc_html__('Shop Now', 'tp-elements'); ?> <i class="tp tp-arrow-up-right"></i></a>
        </div>
    </div>
</div>

