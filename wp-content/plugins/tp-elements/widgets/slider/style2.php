<div class="swiper-slide tp-slide-item">
    <div  class="single--item">
        <div class="content--box">
            <div class="banner-image">
                <img class="banner-img" src="<?php echo esc_url($image); ?>" alt="image">
                <?php if(!empty($sub_img_link)): ?>
                    <img class="quote" src="<?php echo $sub_img_link;?>" alt="quote">
                <?php endif; ?>
                
            </div>
            <div class="description">
                <div class="desc">
                    <?php echo wp_kses_post($description); ?>
                </div>
                
                <?php if(!empty($title)):?>
                    <h2 class="slider-title"><?php echo wp_kses_post($title); ?>
                    <?php if(!empty($sub_title)):?>
                        <span class="slider-subtitle"><?php echo wp_kses_post($sub_title); ?></span>
                    <?php endif;?>
                </h2>   
                <?php endif;?>            
            </div>            
        </div>
    </div>
</div> 