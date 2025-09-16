<div class="swiper-slide tp-slide-item ">
    <div class="single-item position-relative s1-bg-color py-6 py-md-11 px-4 px-md-8 rounded-4  tp-el-content">
        <?php if(!empty($sub_img_link)): ?>
        <div class="quote-area position-absolute end-0">
            <img src="<?php echo $sub_img_link;?>" class="max-un quote" alt="quote">
        </div>
        <?php endif; ?>
        <div class="d-center justify-content-start gap-2">
            <div class="slider-pagination">
                <div class="customPagination p1-bg-color">
                    <span class="curString fs-six"><?php echo esc_html( $index ); ?></span>
                    <span><?php echo esc_html__( 'of', 'tp-elements' ); ?></span>
                    <span class="totalString fs-six"><?php echo esc_html( $total_number ); ?></span>
                </div>
            </div>
        </div>
        <?php if( $settings['show_rating'] == 'yes' ) : ?>
        <ul class="single mt-6 mt-md-10 mb-2 mb-md-4 d-center justify-content-start gap-2 tp-el-star">
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
        <?php if( !empty( $description ) ) : ?>
        <p class="text-body fs-five fw-mid tp-el-desc mb-0"><?php echo wp_kses_post($description); ?></p>
        <?php endif; ?>
        <div class="info-area cus-border border-top b-third pt-6 pt-md-10 mt-8 mt-md-15 d-center justify-content-start gap-4">
            <div class="img-area">
                <img src="<?php echo esc_url($image); ?>" class="max-un rounded-circle" alt="image">
            </div>
            <div class="text-area alt-color">
                <?php if(!empty($title)):?>
                    <h6 class="mb-1 slider-title tp-el-title"><?php echo wp_kses_post($title); ?></h6>
                <?php endif;?>
                <?php if(!empty($sub_title)):?>
                    <p class="slider-subtitle tp-el-subtitle"><?php echo wp_kses_post($sub_title); ?></p>
                <?php endif;?>
            </div>
        </div>
    </div>

</div> 
