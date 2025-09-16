<div class="grid-item  swiper-slide">
    <div class="tp-banner-slide-item">
        <div class="tp-banner-slide-item-img">
            <a href="<?php echo esc_url($link);?>" <?php echo wp_kses_post($target);?>class="front<?php echo esc_attr( $backExists ); ?>"><img class="rs-grid-img <?php echo esc_attr( $animation ); ?>" <?php echo esc_attr( $show_tooltip );?> src="<?php echo esc_url( $image ); ?>"  ></a>  
            <div class="tp-banner-slide-abs-content">
                <div class="tp-banner-slide-content">
                    <?php if( !empty( $subtitle ) ) : ?>
                    <span class="tp-banner-subtitle"><?php echo esc_html( $subtitle ); ?></span>
                    <?php endif; ?>
                    <?php if( !empty( $title ) ) : ?>
                    <h4 class="tp-banner-title"><?php echo wp_kses_post( $title ); ?></h4>
                    <?php endif; ?>
                    <?php if( !empty( $description ) ) : ?>
                    <div class="tp-banner-desc"><?php echo wp_kses_post( $description ); ?></div>
                    <?php endif; ?>
                    <?php if( !empty( $button_text ) ) : ?>
                    <div class="tp-banner-btn">
                        <a href="<?php echo esc_url($link);?>"><?php echo esc_html( $button_text ); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>                        
</div>  