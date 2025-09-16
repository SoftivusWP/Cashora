<div class="swiper-slide tp-slide-item">
    <div  class="single--item">

        <div class="single-item-inner-wrapper">
            <div class="single-item-inner-image">
                <img src="<?php echo esc_url($image); ?>" class="w-100" alt="Image">
                <?php if(!empty($sub_img_link)): ?>
                <div class="abs-quote-img position-absolute">
                    <img src="<?php echo $sub_img_link;?>" class="max-un" alt="Image">
                </div>
                <?php endif; ?>
            </div>
            <div class="single-item-inner-content">
                <div class="main-content">
                    <div class="single-item-inner-top-wrapp">
                        <?php if(!empty($top_title)):?>
                        <span class="single-item-join"><?php echo wp_kses_post($top_title); ?></span>
                        <?php endif;?>
                        <?php 
                        if( $tp_rating == '1' ) {
                            $rating_value = '1';
                        } elseif($tp_rating == '1.5') {
                            $rating_value = '1.5';
                        } elseif($tp_rating == '2') {
                            $rating_value = '2';
                        } elseif($tp_rating == '2.5') {
                            $rating_value = '2.5';
                        } elseif($tp_rating == '3') {
                            $rating_value = '3';
                        } elseif($tp_rating == '3.5') {
                            $rating_value = '3.5';
                        } elseif($tp_rating == '4') {
                            $rating_value = '4';
                        } elseif($tp_rating == '4.5') {
                            $rating_value = '4.5';
                        } elseif($tp_rating == '5') {
                            $rating_value = '5';
                        } else {
                            $rating_value = '5';
                        }
                        ?>
                        <span class="single-item-rating"><i class="tp tp-star p1-color fs-eight"></i><?php echo esc_html( $rating_value ) . '.0'; ?></span>
                    </div>
                    <p><?php echo wp_kses_post($description); ?></p>
                    <div class="bottom-area ">
                        <div class="text-area ">
                            <?php if(!empty($title)):?>
                            <h6 class="fw-bolder transition"><?php echo wp_kses_post($title); ?></h6>
                            <?php endif;?>
                            <?php if(!empty($sub_title)):?>
                            <span class="fs-seven transition"><?php echo wp_kses_post($sub_title); ?></span>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> 