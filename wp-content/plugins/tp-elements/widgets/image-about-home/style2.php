<div class="thumbnail-about-eight">
    <?php $imgId = $settings['main_image']['id'];
        if( !empty($imgId) ){
            $img_link = wp_get_attachment_image_src($imgId, 'large')[0];
        }else{
            $img_link = $placeholder;
    } ?>
    <?php if(!empty($img_link )) : ?>
            <img src="<?php echo esc_url($img_link);?>" alt="about">
        <?php endif; ?>
    <div class="experience-area">
        <div class="image-area">
        <?php 
            $imgId = $settings['animate_image']['id'];
            if( !empty($imgId) ){
                $img_link = wp_get_attachment_image_src($imgId, 'large')[0];
            }else{
                $img_link = $placeholder;
            }
        ?>
        <?php if(!empty($img_link )) : ?>
            <img src="<?php echo esc_url($img_link);?>" alt="about">
        <?php endif; ?>
        <span><?php echo $settings['content'];?></span>
        </div>
        <?php if( !empty($settings['year_text'])) : ?>
            <p><?php echo $settings['year_text']; ?></p>
        <?php endif; ?>
    </div>
</div>