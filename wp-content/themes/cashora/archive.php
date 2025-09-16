<?php
get_header(); 

//checking blog layout form option  
$col         ='';
$blog_layout =''; 
$column      =''; 
$blog_grid   ='';

if(!empty($cashora_option['blog-layout']) || !is_active_sidebar( 'sidebar-1' )){

    $blog_layout = !empty($cashora_option['blog-layout']) ? $cashora_option['blog-layout'] : '';
    $blog_grid   =  !empty($cashora_option['blog-grid']) ? $cashora_option['blog-grid'] : '';
    $blog_grid   = !empty($blog_grid) ? $blog_grid : '12';
    if($blog_layout == 'full' || !is_active_sidebar( 'sidebar-1' ))
    {
        $layout ='full-layout';
        $col    = '-full';
        $column = 'sidebar-none';  
    } 
    
    elseif($blog_layout == '2left'){
        $layout = 'full-layout-left';  
    }
    elseif($blog_layout == '2right'){
        $layout = 'full-layout-right'; 
    } 
    else{
        $col = '';
        $blog_layout = ''; 
    }
}
else{
    $col         ='';
    $blog_layout =''; 
    $layout      ='';
    $blog_grid   ='12';
}

?>

<?php
if (class_exists('\Elementor\Plugin') && 
    is_a(\Elementor\Plugin::$instance, '\Elementor\Plugin') && 
    \Elementor\Plugin::$instance->documents->get($post->ID)->is_built_with_elementor()) {

    $document = \Elementor\Plugin::$instance->documents->get($post->ID);
    $settings = $document->get_settings('general');

    if (!empty($settings['layout']) && $settings['layout'] === 'elementor_full_width') {
        echo '<div class="container-fluid custom-container">';
    } else {
        echo '<div class="container">';
    }
} else {
    echo '<div class="container">';
}
?>

    <div id="pixelaxis-blog" class="pixelaxis-blog blog-page">
        <div class="row padding-<?php echo esc_attr( $layout) ?>">       
            <div class="contents-sticky col-md-12 col-lg-8<?php echo esc_attr($col); ?> <?php echo esc_attr($layout); ?>">                   
                <div class="row">            
                    <?php
                        if ( have_posts() ) :           
                            /* Start the Loop */
                            while ( have_posts() ) : the_post();

                            $post_id   = get_the_id();
                            $author_id = $post->post_author;
                            $no_thumb  = "";

                            if ( !has_post_thumbnail() ) {
                            $no_thumb = "no-thumbs";
                            }?>

                        <div class="col-sm-<?php echo esc_attr($blog_grid);?> col-xs-12">
                            <article <?php post_class();?>>
                                <div class="blog-item <?php echo esc_attr($no_thumb); ?>">
                                    <?php if ( has_post_thumbnail() ) {?>
                                        <div class="blog-img">
                                        <a href="<?php the_permalink();?>">
                                                <?php
                                                    the_post_thumbnail();
                                                ?>
                                            </a>                                
                                        
                                        </div><!-- .blog-img -->
                                    <?php }       
                                    ?>
                                    <div class="full-blog-content">
                                        <div class="user-info">
                                            <!-- single info -->
                                            <?php if (!empty($cashora_option['blog-author-post'])) {
                                            if ($cashora_option['blog-author-post'] == 'show') : ?>
                                                <div class="single-info">
                                                    <span>
                                                        <i class="tp tp-circle-user-regular"></i>
                                                        <?php
                                                        echo esc_html__('by', 'cashora');
                                                        $last_name = get_user_meta($author_id, 'last_name', true);
                                                        $first_name = get_user_meta($author_id, 'first_name', true);
                                                        if (!empty($first_name) && !empty($last_name)) {
                                                            echo esc_html($first_name) . ' ' . esc_html($last_name);
                                                        } else {
                                                            echo get_the_author();
                                                        } ?>  </span>
                                                        </div>
                                                    <?php endif; ?>
                                                
                                            <?php } else { ?>
                                                <div class="single-info">
                                                    <span>
                                                        <i class="tp tp-circle-user-regular"></i>
                                                        <?php
                                                        echo esc_html__('by', 'cashora');
                                                        $last_name = get_user_meta($author_id, 'last_name', true);
                                                        $first_name = get_user_meta($author_id, 'first_name', true);
                                                        if (!empty($first_name) && !empty($last_name)) {
                                                            echo esc_html($first_name) . ' ' . esc_html($last_name);
                                                        } else {
                                                            echo get_the_author();
                                                        } ?>
                                                    </span>
                                                </div>
                                            <?php }; ?>
                                                
                                            
                                            <!-- single infoe end -->
                                            <!-- single info -->
                                            <?php if(!empty($cashora_option['blog-date'])) :?>
                                                <div class="single-info">
                                                    <i class="tp tp-clock-regular"></i>
                                                    <span><?php echo get_the_date();?></span>
                                                </div>
                                            <?php endif; ?>
                                            <!-- single infoe end -->
                                            <!-- single info -->
                                            <div class="single-info cat">
                                                
                                                <span> <?php if(!empty($cashora_option['blog-category'])){
                                                    if($cashora_option['blog-category'] == 'show'){ ?>
                                                    <i class="tp tp-tags"></i> <?php
                                                        if(get_the_category()):
                                                            the_category(', ');                                                 
                                                    endif;
                                                        }
                                                }else{ ?>
                                                    <i class="tp tp-tags"></i> <?php
                                                    if(get_the_category()): ?>
                                                                                                    
                                                        <?php
                                                            //tag add
                                                            $seperator = ', '; // blank instead of comma
                                                            $after = '';
                                                            $before = '';
                                                        
                                                            ?>
                                                            
                                                            <?php
                                                            the_category(',  '); 
                                                        
                                                        ?> 
                                                    
                                                    <?php
                                                endif;
                                                } ?>
                                                </span>
                                            </div>
                                            <!-- single info end -->
                                        </div>
                                        <div class="title-wrap">                                                                                                              
                                            <h3 class="blog-title">
                                                <a href="<?php the_permalink();?>">
                                                    <?php the_title();?>
                                                </a>
                                            </h3>                                        
                                    </div>

                                    <div class="blog-desc">   
                                        <?php echo cashora_custom_excerpt(30);?>                                     
                                    </div>                                     

                                    <?php 
                                    if(!empty($cashora_option['blog_readmore'])):?>
                                    <div class="btn-area mt-20">
                                        <a href="<?php the_permalink();?>" class="blog-btn">
                                            <span class="blog-btn-text"><?php echo esc_html($cashora_option['blog_readmore']); ?></span>
                                            <span class="icon ">
                                                <i class="tp tp-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            </article>
                        </div>
                    
                    <?php  
                    endwhile;                        
                    ?>
                </div>
                <?php if ( $wp_query->max_num_pages > 1 ) { ?>
                <div class="pagination-area">
                    <?php
                        the_posts_pagination();
                    ?>
                </div>
                <?php } ?>
                <?php
                else :
                get_template_part( 'template-parts/content', 'none' );
                endif; ?> 
            </div>
            <?php if( $layout != 'full-layout' ):     
                get_sidebar();    
            endif;
            ?>
        </div>      
    </div>
</div>


<?php
get_footer();