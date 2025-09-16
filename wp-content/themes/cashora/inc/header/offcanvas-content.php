<?php 

global $cashora_option;
if(!empty($cashora_option['facebook']) || !empty($cashora_option['twitter']) || !empty($cashora_option['rss']) || !empty($cashora_option['pinterest']) || !empty($cashora_option['google']) || !empty($cashora_option['instagram']) || !empty($cashora_option['vimeo']) || !empty($cashora_option['tumblr']) ||  !empty($cashora_option['youtube'])){
?>

    <ul class="offcanvas_social">  
        <?php
        if(!empty($cashora_option['facebook'])) { ?>
        <li> 
        <a href="<?php echo esc_url($cashora_option['facebook'])?>" target="_blank"><span><i class="fa fa-facebook"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($cashora_option['twitter'])) { ?>
        <li> 
        <a href="<?php echo esc_url($cashora_option['twitter']);?> " target="_blank"><span><i class="fa fa-twitter"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($cashora_option['rss'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['rss']);?> " target="_blank"><span><i class="fa fa-rss"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['pinterest'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['pinterest']);?> " target="_blank"><span><i class="fa fa-pinterest-p"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['linkedin'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['linkedin']);?> " target="_blank"><span><i class="fa fa-linkedin"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['google'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['google']);?> " target="_blank"><span><i class="fa fa-google-plus-square"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['instagram'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['instagram']);?> " target="_blank"><span><i class="fa fa-instagram"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($cashora_option['vimeo'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['vimeo'])?> " target="_blank"><span><i class="fa fa-vimeo"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['tumblr'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['tumblr'])?> " target="_blank"><span><i class="fa fa-tumblr"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($cashora_option['youtube'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($cashora_option['youtube'])?> " target="_blank"><span><i class="fa fa-youtube"></i></span></a> 
        </li>
        <?php } ?>     
    </ul>
<?php }

