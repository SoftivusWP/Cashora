<div class="swiper-slide tp-slide-item">
    <div  class="single--item">

        <div class="single-item-inner-wrapper">
            <div class="single-item-inner-image">
                <img src="<?php echo esc_url($image); ?>" class="w-100" alt="Image">
            </div>
            <div class="single-item-inner-content">
                <?php if(!empty($sub_img_link)): ?>
                <div class="abs-area d-none d-md-block position-absolute">
                    <img src="<?php echo $sub_img_link;?>" class="max-un" alt="Image">
                </div>
                <?php endif; ?>
                <div class="main-content">
                    <?php if(!empty($top_title)):?>
                        <h3 class="slider-title title"><?php echo wp_kses_post($top_title); ?></h3>
                    <?php endif;?>
                    <?php echo wp_kses_post($description); ?>
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