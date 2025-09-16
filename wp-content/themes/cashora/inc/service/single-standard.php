<?php 
if( is_active_sidebar( 'sidebar-service' ) ) {
    $col= 'col-xxl-8 col-xl-8 col-lg-8';
} else {
    $col= 'col-xxl-12 col-xl-12 col-lg-12';
}
?>
<!--container-->
<div class="container">
    <div class="row">
        <div class="<?php echo esc_attr( $col ); ?>">
            <div class="service__details__left mb-40">
                <div class="machine__learning__box">
                    <?php while ( have_posts() ) : the_post(); ?>          

                    <?php the_content(); ?>

                    <?php endwhile; wp_reset_query();?>

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

                </div>
            </div>

        </div>
        <?php if( is_active_sidebar( 'sidebar-service' ) ) : ?>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
            <aside id="secondary" class="widget-area">
                <div class="pixelaxis-sideabr dynamic-sidebar">
                    <?php dynamic_sidebar('sidebar-service'); ?>
                </div>
            </aside>
        </div>
        <?php endif; ?>
    </div>
</div>
<!--container-->



