<div class="swiper-slide tp-slide-item">

    <div class="single-item cus-border border transition n1-bg-color position-relative">
        <div class="icon-area d-center cus-border border">
            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr('icon-img', 'tp-elements'); ?>">
        </div>
        <div class="text-area cus-border border-top mt-6 mt-lg-10 pt-6 pt-lg-10">
            <?php if(!empty($title)):?>
            <h5 class="mb-4 tp-el-title"><?php echo wp_kses_post($title); ?></h5>
            <?php endif;?>
            <p class="tp-el-desc mb-0"><?php echo wp_kses_post($description); ?></p>
        </div>
    </div>

</div>
