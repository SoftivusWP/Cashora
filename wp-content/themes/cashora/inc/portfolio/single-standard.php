<?php

    global $cashora_option;
    $post_id      = get_the_id();
    //checking page layout 
    $page_layout = get_post_meta( $post->ID, 'layout', true );
    $col_side = '';
    $col_letf = '';

    if($page_layout == '2left' && is_active_sidebar( 'sidebar-portfolio' )){
        $col_side = '8';
        $col_letf = 'left-sidebar';}
    else if($page_layout == '2right' && is_active_sidebar( 'sidebar-portfolio' )){
        $col_side = '8';
        $col_letf = 'right-sidebar';
    }
    else{
        $col_side = '12';
        $col_letf = 'full-width';
    }

    $selected_layout = get_post_meta(get_the_ID(), 'custom_sidebar', true);

    if ($selected_layout == 'top_carousel_center' && !is_active_sidebar('sidebar-portfolio')) {
        $container_class = 'container-fluid';
    } elseif ($selected_layout == 'top_carousel_center' && is_active_sidebar('sidebar-portfolio') && ($page_layout !== '2left' && $page_layout !== '2right')) {
        $container_class = 'container-fluid';
    } else {
        $container_class = 'container';
    }

    ?>

    <div class="<?php echo esc_attr($container_class); ?>">
        <div class="pixelaxis-portfolio-details">
            <div class="row padding-<?php echo esc_attr( $col_letf) ?>">
                <div class="col-lg-<?php echo esc_attr( $col_side); ?> <?php echo esc_attr( $col_letf); ?> ">
                    <div class="pixelaxis-portfolio-details-inner-left <?php echo esc_attr( $selected_layout ); ?> ">
                        <?php while ( have_posts() ) : the_post(); 

                            if (empty($selected_layout)) {
                                $selected_layout = 'portfolio_default';
                            }

                            $tp_portfolio_options = array(
                                'portfolio_default' => esc_html__('Portfolio Default', 'cashora'),
                                'top_image_carousel' => esc_html__('Top Image Carousel', 'cashora'),
                                'top_carousel_center' => esc_html__('Top Carousel Center', 'cashora'),
                                'left_gallery_image' => esc_html__('Left Gallery Image', 'cashora'),
                                'left_gallery_grid' => esc_html__('Left Gallery Grid', 'cashora'),
                                'bottom_gallery_grid' => esc_html__('Bottom Gallery Grid', 'cashora'),
                                'top_gallery_carousel' => esc_html__('Top Gallery Carousel', 'cashora'),
                            );

                            // Include the appropriate template part based on the selected layout
                            switch ($selected_layout) {
                                case 'top_image_carousel':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'top_image_carousel');
                                    break;

                                case 'top_carousel_center':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'top_carousel_center');
                                    break;

                                case 'left_gallery_image':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'left_gallery_image');
                                    break;

                                case 'left_gallery_grid':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'left_gallery_grid');
                                    break;

                                case 'bottom_gallery_grid':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'bottom_gallery_grid');
                                    break;

                                case 'top_gallery_carousel':
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'top_gallery_carousel');
                                    break;

                                case 'portfolio_default':
                                default:
                                    get_template_part('inc/portfolio/portfolio-parts/portfolio', 'portfolio_default');
                                    break;
                            }

                        ?>  

                        <?php endwhile; wp_reset_query();?>

                        <?php if( $selected_layout == 'top_carousel_center' ) : ?> <div class="container"> <?php endif; ?>
                        
                        <?php 
                        $next_post = get_next_post();
                        $previous_post = get_previous_post();
                        if( !empty($next_post) || !empty($previous_post)):?>
                        <div class="service-navigation">
                            <?php			 
                            $url_next = is_object( $next_post ) ? get_permalink( $next_post->ID ) : ''; 
                            $title    = is_object( $next_post ) ? get_the_title( $next_post->ID ) : ''; 
                            ?>
                            <div class="row align-items-center justify-content-between tps-left-write-blog-wrapper-main">
                                <div class="col-lg-6 col-sm-6">
                                    <?php if($next_post):?>	
                                    <div class="left-icon-area single">
                                        <div class="icon-1">
                                            <a href="<?php echo esc_url( $url_next ) ?>">
                                                <i class="tp-arrow-left"></i>
                                            </a>
                                        </div>
                                        <div class="writing-content">
                                            <a href="<?php echo esc_url( $url_next ) ?>"><span><?php echo esc_html__('Previous', 'cashora'); ?></span>
                                                <h6 class="title"><?php echo esc_html( $title ); ?></h6>
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <?php $url_previous = is_object( $previous_post ) ? get_permalink( $previous_post->ID ) : '';
                                    $title = is_object( $previous_post ) ? get_the_title( $previous_post->ID ) : ''; ?>
                                    <?php if($previous_post):?>	
                                    <div class="right-icon-area single justify-content-end">
                                        <div class="writing-content">
                                            <a href="<?php echo esc_url( $url_previous ) ?>"><span><?php echo esc_html__('Next', 'cashora'); ?></span>
                                                <h6 class="title">
                                                <?php echo esc_html( $title ); ?>
                                                </h6>
                                            </a>
                                        </div>
                                        <div class="icon-1">
                                            <a href="<?php echo esc_url( $url_previous ) ?>"> <i class="tp-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if( $selected_layout == 'top_carousel_center' ) : ?> </div> <?php endif; ?>

                    </div>
                </div>

                <?php 
                if( ( $page_layout=='2left' || $page_layout=='2right' ) && is_active_sidebar( 'sidebar-portfolio' ) ){	
                ?>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <aside id="secondary" class="widget-area">
                        <div class="pixelaxis-sideabr dynamic-sidebar">
                        <?php
                            dynamic_sidebar('sidebar-portfolio');
                        ?>
                        </div>
                    </aside>
                </div>
                <?php
                } ?>

            </div>
        </div>
    </div>
    