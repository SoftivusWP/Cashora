<div class="swiper-slide tp-slide-item"> 
    <div class="slider-content-area">
    <?php if(!empty($description)):?>
                <div class="slider-description"><?php echo wp_kses_post($description); ?></div>
            <?php endif;?>

        <div class="bottom--area">
            <?php $img_gap = !empty($img_gap ) ? 'style="margin-right:'. $img_gap .'"' : '';?>
            <div class="content--box">
                <?php if(!empty($title)):?>
                    <h5 class="slider-title"><?php echo wp_kses_post($title); ?></h5>
                <?php endif;?>
                <?php if(!empty($sub_title)):?>
                    <p class="slider-subtitle"><?php echo wp_kses_post($sub_title); ?></p>
                <?php endif;?>

            </div>
                       
        </div>
    </div>
</div> 
