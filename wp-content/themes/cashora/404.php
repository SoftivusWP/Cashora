<?php
wp_head();
global $cashora_option;?>
<div class="page-error">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <section class="error-404 not-found">
                    <div class="page-content">
                        <?php if (!empty($cashora_option['404_bg']['url'])) {?>
                            <img class="error-image"  src="<?php echo esc_url($cashora_option['404_bg']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php }
                        else{ ?>
                            <h2>
                            <span>
                                <?php
                                    if (!empty($cashora_option['title_404'])) {
                                        echo esc_html($cashora_option['title_404']);
                                    } else {  
                                        echo esc_html__('404', 'cashora');
                                    }
                                ?>
                            </span>                           
                        </h2>                 
                       <?php } 
                        ?>

                        <h2 class="opps-nothing">
                            
                            <?php
                                if (!empty($cashora_option['text_404'])) {
                                    echo esc_html($cashora_option['text_404']);
                                } else {
                                    echo esc_html__('Oops! Nothing Was Found', 'cashora');
                                }
                            ?>
                        </h2>            
                        <p class="error-msg">
                            <?php echo esc_html__("Sorry, we couldn't find the page you where looking for. We suggest that you return to homepage.", 'cashora'); ?>
                        </p>
                        <a class="tp-error-button cmn--btn" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php
                                if (!empty($cashora_option['back_home'])) {
                                    // echo esc_html($cashora_option['back_home']);
                                    echo '<span> '. esc_html($cashora_option['back_home']) .' </span>';
                                } else {
                                    esc_html_e('Or back to homepage', 'cashora');
                                }
                            ?>
                        </a>
                    </div><!-- .page-content -->
                </section><!-- .error-404 -->
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
</div> <!-- .page-error -->
<?php
wp_footer();
