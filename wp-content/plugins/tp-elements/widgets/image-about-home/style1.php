<div class="about-four-img">
    <div class="thumbnail-1">
        <?php $imgId = $settings['main_image']['id'];
        if( !empty($imgId) ){
            $img_link = wp_get_attachment_image_src($imgId, 'large')[0];
        }else{
            $img_link = $placeholder;
        } ?>
        <?php if(!empty($img_link )) : ?>
            <img src="<?php echo esc_url($img_link);?>" alt="about">
        <?php endif; ?>
        <div class="experience">
            <h3 class="animated fadeIn"><?php echo $settings['year'];?></h3>
            <div class="small-st">
                <span class="plus">+</span>
                <span><?php echo $settings['year_text'];?></span>
            </div>
        </div>
    </div>
    <div class="thumbnail-2">
        <?php 
        $imgId = $settings['animate_image']['id'];
        if( !empty($imgId) ){
            $img_link = wp_get_attachment_image_src($imgId, 'large')[0];
        }else{
            $img_link = $placeholder;
        } ?>
        <?php if(!empty($img_link )) : ?>
            <img src="<?php echo esc_url($img_link);?>" alt="about">
        <?php endif; ?>
        <span><?php echo $settings['content'];?></span>
    </div>
</div>
