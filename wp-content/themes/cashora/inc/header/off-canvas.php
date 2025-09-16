<?php 
global $cashora_option;
$rs_offcanvas = get_post_meta(get_the_ID(), 'show-off-canvas', true);
$logo_height = !empty($cashora_option['logo-height']) ? 'style = "max-height: '.$cashora_option['logo-height'].'"' : '';
//off convas here
?>
    
<nav class="menu-wrap-off nav-container nav menu-ofcn">       
    <div class="inner-offcan">
        <div class="nav-link-container">  
            <a href='#' class="nav-menu-link close-button" id="close-button2">              
                <i class="tp-xmark"></i>
            </a> 
        </div> 
        <div class="sidenav offcanvas-icon">      

            <div id="mobile_menu" class="pixelaxis-offcanvas-inner-left">
                <?php
                    if(is_page_template('page-single.php')){
                        if ( has_nav_menu( 'menu-2' ) ):
                            ?>                                
                                <div class="widget widget_nav_menu mobile-menus">      
                                    <?php
                                        wp_nav_menu( array(
                                            'theme_location' => 'menu-2',
                                            'menu_id'        => 'single-menu',
                                        ) );
                                    ?>
                                </div>                                
                            <?php
                        endif;
                    } else {

                        if ( has_nav_menu( 'menu-1' ) ):
                            ?>                                
                                <div class="widget widget_nav_menu mobile-menus">      
                                    <?php
                                        wp_nav_menu( array(
                                            'theme_location' => 'menu-1',
                                            'menu_id'        => 'primary-menu-single1',
                                        ) );
                                    ?>
                                </div>                                
                            <?php
                        endif;
                    }
                ?>
            </div> 
                
            <div class="pixelaxis-innner-offcanvas-contents"> 

                <?php 
                    $canvas_style = new WP_Query(array(
                    'post_type' => 'tp-canvans',
                    'posts_per_page' => 1,
                    
                    )); 
                if ( $canvas_style->have_posts() ) {
                    while ( $canvas_style->have_posts() ) : $canvas_style->the_post();
                        the_content();
                    endwhile;
                    wp_reset_postdata();
                }?>
            </div>            
            
        </div>
    </div>
</nav>
