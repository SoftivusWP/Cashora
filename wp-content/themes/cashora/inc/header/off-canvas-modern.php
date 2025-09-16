<?php 
global $cashora_option;
$rs_offcanvas = get_post_meta(get_the_ID(), 'show-off-canvas', true);
$logo_height = !empty($cashora_option['logo-height']) ? 'style = "max-height: '.$cashora_option['logo-height'].'"' : '';
//off convas here

?>

<!-- sidebar section start-->
<div class="sidebar-wrapper ">
    <div class="sidebar-menu header-section cus-border border-bottom border-2">
        <div class="logo-area position-absolute top-0 p-5 w-100 d-center justify-content-between">
            <a href="index.html" class="nav-brand d-center gap-2">
                <img src="assets/images/logo.png" class="logo" alt="logo">
            </a>
            <button class="menu-close-btn close-btn">
                <i class="ti ti-x fs-two n1-color"></i>
            </button>
        </div>
        <div class="container main-navbar">
            <div class="row gy-12 gy-xl-0 py-15 align-items-center justify-content-between navbar-custom">
                <div class="col-lg-6">

                    <?php
                    if(is_page_template('page-single.php')){
                        if ( has_nav_menu( 'menu-2' ) ):
                            ?>                                
                                <div class="mobile-menu">      
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
                                <div class="mobile-menu">      
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
                <div class="col-lg-5">
                    <div class="contact-inner">
                        <h2 class="mb-3">Get In Touch</h2>
                        <div class="contact-information">
                            <ul class="copyright d-flex align-items-center gap-8">
                                <li class="d-grid gap-2">
                                    <span class="n2-color">Copyright by</span>
                                    <span class="fs-six"><span class="currentYear"></span> Edition</span>
                                </li>
                                <li class="d-grid gap-2">
                                    <span class="n2-color">LOCAL TIME</span>
                                    <span class="fs-six">11.37 AM GMT+2</span>
                                </li>
                            </ul>
                            <ul class="d-flex gap-4 mt-4 mt-md-7 social-area">
                                <li>
                                    <a href="https://www.facebook.com" aria-label="Facebook" class="d-center">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com" aria-label="Instagram" class="d-center">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com" aria-label="Linkedin" class="d-center">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com" aria-label="Twitter" class="d-center">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sidebar section end -->
