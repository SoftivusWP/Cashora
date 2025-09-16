<?php
    get_header();
    global $cashora_option;
    $post_id      = get_the_id();
    $author_id    = get_post_field ('post_author', $post_id);
    $display_name = get_the_author_meta( 'display_name' , $author_id );

    //checking page layout 
    $page_layout = get_post_meta( $post->ID, 'layout', true );
    $page_sidebar = get_post_meta( $post->ID, 'custom_sidebar', true );
    $col_side = '';
    $col_letf = '';
    if($page_layout == '2left'){
        $col_side = '8';
        $col_letf = 'left-sidebar';}
    else if($page_layout == '2right'){
        $col_side = '8';
        $col_letf = 'right-sidebar';
    }
    else{
        $col_side = '12';
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
        <!-- Blog Detail Start -->
        <div class="pixelaxis-blog-details pt-70 pb-70">
            <div class="row padding-<?php echo esc_attr( $col_letf) ?>">
                <div class="col-lg-<?php echo esc_attr( $col_side); ?> <?php echo esc_attr( $col_letf); ?> ">
                    <div class="news-details-inner">
                        <?php
                            while ( have_posts() ) : the_post();
                        ?>             
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>             
                            <?php if(has_post_thumbnail()){ ?>
                            <div class="bs-img">
                            <?php the_post_thumbnail()?>
                            </div>
                            <?php } ?>
                        
                            <?php
                            get_template_part( 'template-parts/post/content', get_post_format() );         
                            ?>
                            <div class="clear-fix"></div>      
                        </article> 
                    
                        <?php                    
                            $author_meta = get_the_author_meta('description'); 
                            if( !empty($author_meta) ){
                            ?>
                                <div class="author-block">
                                    <div class="author-img"> <?php echo get_avatar(get_the_author_meta( 'ID' ), 200);?> </div>
                                    <div class="author-desc">
                                        <h3 class="author-title">
                                            <?php the_author();?>
                                        </h3>
                                        <p>
                                            <?php   
                                                echo wpautop( get_the_author_meta( 'description' ) );
                                            ?>
                                        </p>
                                        
                                    </div>
                                </div>
                                <!-- .author-block -->
                        <?php }     
                        if(!empty($cashora_option['blog-comments']) && $cashora_option['blog-comments'] =='show') :         
                            $blog_author = '';
                            if($blog_author == ""){
                                if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif;
                            }
                            else
                                {
                                $blog_author = $cashora_option['blog-comments'];
                                if($blog_author == 'show'){     
                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) :
                                comments_template();
                                endif;
                                }
                            }
                        endif;
                    endwhile; // End of the loop.
                    ?>
                    </div>
                </div>
            <?php
                if( ( $page_layout == '2left' || $page_layout == '2right') ):
                    get_sidebar('single');
                endif;
            ?>    
            </div>
        </div>
        <!-- Blog Detail End --> 
    </div>
<?php
get_footer();