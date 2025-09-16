<div class="swiper-slide tp-slide-item">
    <div  class="single--item">
        <div class="content--box d-flex">
            <div class="banner-image">
                <img class="banner-img" src="<?php echo esc_url($image); ?>" alt="image">
            </div>
            <div class="description">
                <?php if(!empty($title)):?>
                    <h2 class="slider-title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif;?>
                <?php if(!empty($sub_title)):?>
                    <p class="slider-subtitle"><?php echo wp_kses_post($sub_title); ?></p>
                <?php endif;?>
            </div>            
        </div>
        <div class="review-body">
            <div class="desc">
                <?php echo wp_kses_post($description); ?>
            </div> 
        </div>
        <?php if( $settings['show_rating'] == 'yes' ) : ?>
        <ul class="rating-portion d-center justify-content-end gap-2 tp-el-star">
            <?php if( $tp_rating == '1' ) : ?>
            <li><i class="tp tp-star p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '1.5' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-half p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '2' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '2.5' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-half p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '3' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '3.5' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-half p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '4' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-regular p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '4.5' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star-half p1-color fs-eight"></i></li>
            <?php endif; ?>
            <?php if( $tp_rating == '5' ) : ?>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <li><i class="tp tp-star  p1-color fs-eight"></i></li>
            <?php endif; ?>

        </ul>
        <?php endif; ?>
    </div>
</div> 