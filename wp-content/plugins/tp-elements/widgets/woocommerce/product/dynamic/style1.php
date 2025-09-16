<div class="col-xxl-<?php echo esc_attr( $settings['product_col_xxl'] ); ?> col-xl-<?php echo esc_attr( $settings['product_col_xl'] ); ?> col-lg-<?php echo esc_attr( $settings['product_col_lg'] ); ?> col-md-<?php echo esc_attr( $settings['product_col_md'] ); ?> col-sm-<?php echo esc_attr( $settings['product_col_sm'] ); ?> col-<?php echo esc_attr( $settings['product_col_xs'] ); ?>">
    <div class="tp-single-product">
        <?php if(has_post_thumbnail()) : ?>
        <div class="tp-single-product-img">
            <?php the_post_thumbnail(); ?>

            <?php if( function_exists( 'woosw_init' )) : ?>
            <div class="tp-product-abs-wishlist">
                <?php echo do_shortcode('[woosw]'); ?>
            </div>
            <?php endif; ?>

            <div class="tp-product-abs-cart box-style box-second">
            <?php tp_woo_add_to_cart(); ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="tp-single-product-text">
            <h4 class="tp-single-product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4> 
            <span class="tp-single-price"><?php echo woocommerce_template_loop_price();?></span>
        </div>
    </div>
</div>