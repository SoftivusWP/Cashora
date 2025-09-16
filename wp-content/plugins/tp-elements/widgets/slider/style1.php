<div class="swiper-slide tp-slide-item">
    <div  class="single--item">
        
        <?php if(!empty($sub_img_link)):?>
        <div class="review-end">
            <img class="quote" src="<?php echo esc_attr($sub_img_link); ?>" alt="Icon">
        </div>
        <?php endif;?>
        
        <div class="content--box">
            <div class="description">
                <?php if(!empty($title)):?>
                <h2 class="slider-title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif;?>
                <?php if(!empty($sub_title)):?>
                <p class="slider-subtitle"><?php echo wp_kses_post($sub_title); ?></p>
                <?php endif;?>
            </div> 
            <div class="banner-image">
                <img class="banner-img" src="<?php echo esc_url($image); ?>" alt="image">
            </div>           
        </div>
        <div class="review-body">
            <div class="desc">
                <?php echo wp_kses_post($description); ?>
            </div>
        </div>
    </div>
</div> 