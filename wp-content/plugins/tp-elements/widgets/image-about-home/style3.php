<div class="thumbnail-about-eight industrial">
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
            <div class="about_ani_top">
            <?php if( !empty($settings['year_text'])) : ?>
                <h3><?php echo $settings['year_text']; ?></h3>  
            <?php endif; ?>              
                <p><?php echo $settings['content'];?></p>
            </div>       
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
        </div>  
    </div>
</div>