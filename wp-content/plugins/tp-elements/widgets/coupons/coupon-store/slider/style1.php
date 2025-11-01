<div class="swiper-slide grid-item " >

    <div class="themephi-addon-coupons position-relative <?php echo esc_attr( $settings['image_or_icon_vertical_align'] ); ?> <?php echo esc_attr( $settings['image_or_icon_position'] ); ?> coupons-<?php echo esc_attr( $settings['coupon_style'] ); ?> coupons-<?php echo esc_attr( $settings['coupon_grid_source'] ); ?>">

        <div class="tp-coupon-item" >

            <?php if( !empty( $store_image_url ) ){ ?>
            <div class="tp-coupon-item-img">
                <img src="<?php echo esc_url( $store_image_url ); ?>" alt="store image">
            </div>
            <?php }?>

            <div class="tp-coupon-item-content-wrapper <?php echo esc_attr( $settings['button_position'] ); ?>">

                <div class="tp-coupon-content-wrapp">

                    <?php if( $settings['title_show_hide'] == 'yes' ) : ?>
                    <<?php echo esc_attr( $settings['title_tag'] ); ?> class="tp-coupon-title"><a href="<?php echo esc_url( $store_link ); ?>"><?php echo wp_trim_words( $store_name, $title_limit, '...' ); ?></a></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                    <?php endif; ?>
                    
                    <?php if( $settings['coupon_text_show_hide'] == 'yes' ) : ?>
                    <div class="tp-coupon-desc">
                    <?php echo wp_kses_post( wp_trim_words( $store_description, $text_limit, '...' ) ); ?>
                    </div>
                    <?php endif; ?>

                    <?php if( $settings['coupon_rich_text_show_hide'] == 'yes' ) : ?>
                    <div class="tp-coupon-store-voucher">
                        <?php echo wp_kses_post( $store_rich_description ); ?>
                    </div>
                    <?php endif; ?>
 
                </div>

                <div class="tp-coupon-button-wrapp <?php echo esc_attr( $settings['button_vertical_align'] ); ?>">

                    <?php if( $settings['coupon_btn_show_hide'] == 'yes' ) : ?>
                    <div class="tp-coupon-button">
                        <?php 
                        $link_open = $settings['coupon_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 
                        $icon_position = $settings['coupon_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                        ?>
                        <a class="tp-store-button <?php echo esc_attr( $icon_position ); ?>" href="<?php echo esc_url( $store_link ); ?>" rel="nofollow" <?php echo wp_kses_post($link_open); ?> >
                            <?php if( $settings['coupon_btn_icon_position'] == 'before' ) : ?>
                                <?php if($settings['coupon_btn_icon']): ?>
                                <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if( !empty( $settings['coupon_btn_text'] ) ) : ?>
                            <span class="tp-store-btn-text"><?php echo esc_html( $settings['coupon_btn_text'] ); ?></span>
                            <?php endif; ?>
                            <?php if( $settings['coupon_btn_icon_position'] == 'after' ) : ?>
                                <?php if($settings['coupon_btn_icon']): ?>
                                <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a> 


                    </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>


    </div>
    
</div>