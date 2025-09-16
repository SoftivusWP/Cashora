<?php
get_header(); ?>

	<?php
	  //checking page layout 
		$page_layout = get_post_meta( get_the_ID(), 'layout', true );
		$col_side ='';
		$col_letf ='';
		if($page_layout == '2left'){
			$col_side = '8';
			$col_letf = 'left-sidebar';}
		else if($page_layout == '2right'){
			$col_side = '8';}
		else{
			$col_side = '12';}
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
            <div class="row padding-<?php echo esc_attr( $col_letf) ?>">
                <div class="col-lg-<?php echo esc_attr( $col_side). ' ' .esc_attr( $col_letf) ?>">
                    <?php	
                        while ( have_posts() ) : the_post(); 
                        get_template_part( 'template-parts/content', 'page' );
                        endwhile; // End of the loop.					
                    ?>
                </div>
                <?php get_sidebar('page');?>
            </div>
        </div>

<?php
get_footer();

