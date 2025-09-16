<?php global $cashora_option; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
    <header class="entry-header">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
    </header>
    <!-- .entry-header -->
    
    <div class="entry-summary mb-0">
        <p><?php echo cashora_custom_excerpt(30);?></p>   
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
    <!-- .entry-summary -->

</article>
