<!-- start here  -->
<div class="realworld__items swiper-slide tp-slide-item">
    <div class="thumb">
        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
        <a href="<?php echo esc_url( $video_link ); ?>" class="play__btn video-btn popup-videos tp-el-video-play-btn">
            <i class="material-symbols-outlined">
            play_arrow
            </i>
        </a>
    </div>
    <div class="content">
        <a href="<?php echo esc_url( $cat_link ); ?>" class="tp-el-cat-btn">
            <span><?php echo esc_html( $cat_text ); ?></span>
        </a>
        <?php if(!empty($title)):?>
        <h4 class="tp-el-title">
            <a href="<?php echo esc_url($link); ?>"><?php echo wp_kses_post($title); ?></a>
        </h4>
        <?php endif;?>
        <p class="tp-el-desc"><?php echo wp_kses_post($description); ?></p>
        <?php if(!empty($btn_text)):?>
            <a class="real__btn tp-el-btn" <?php echo esc_attr($target); ?> href="<?php echo esc_url($link); ?>"><span><?php echo wp_kses_post($btn_text); ?></span> <span class="icon"><i class="material-symbols-outlined">arrow_right_alt</i></span></a>
        <?php endif;?>
    </div>
</div>
<script type="text/javascript"> 
    jQuery('.video-btn').magnificPopup({
        type: 'iframe',
        callbacks: {
            
        }
    });
</script>