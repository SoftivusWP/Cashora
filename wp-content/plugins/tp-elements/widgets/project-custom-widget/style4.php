<!-- start here  
*********************************************************************************************************************************************************************************************************************************************************************************************** 
-->

<?php 
$cat = $settings['project_category'];

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if(empty($cat)){
	$best_wp = new wp_Query(array(
			'post_type'      => 'tp-portfolios',
			'posts_per_page' => $settings['per_page'],
			'paged'          => $paged					
	));	  
}   
else{
	$best_wp = new wp_Query(array(
		'post_type'      => 'tp-portfolios',
		'posts_per_page' => $settings['per_page'],
		'paged'          => $paged,
		'tax_query'      => array(
			array(
				'taxonomy' => 'tp-portfolio-category',
				'field'    => 'slug', //can be set to ID
				'terms'    => $cat //if field is ID you can reference by cat/term number
			),
		)
	));	  
} 
$col_xxl = $settings['col_xxl'] ? $settings['col_xxl'] : '3';
$col_xl = $settings['col_xl'] ? $settings['col_xl'] : '3';
$col_lg = $settings['col_lg'] ? $settings['col_lg'] : '4';
$col_md = $settings['col_md'] ? $settings['col_md'] : '6';
$col_sm = $settings['col_sm'] ? $settings['col_sm'] : '6';
$col_xs = $settings['col_xs'] ? $settings['col_xs'] : '12';

?>

<div class="studies__section case__trough project_style_<?php echo esc_attr( $settings['project_grid_source'] ); ?>">
    <div class="row g-4 justify-content-center align-items-center">
        <!--col grid-->
        <?php
			while($best_wp->have_posts()): $best_wp->the_post();
			$post_id = get_the_ID();
			$terms = get_the_terms($post_id, 'tp-portfolio-category' );
			if ($terms && ! is_wp_error($terms)) :
				$tslugs_arr = array();
				foreach ($terms as $term) {
					$tslugs_arr[] = $term->slug;
					$cat_link = get_category_link( $term->term_id );
					break;
				}
			endif;
			?>
        <div class="col-xxl-<?php echo esc_attr( $col_xxl ); ?> col-xl-<?php echo esc_attr( $col_xl ); ?> col-lg-<?php echo esc_attr( $col_lg ); ?> col-md-<?php echo esc_attr( $col_md ); ?> col-sm-<?php echo esc_attr( $col_sm ); ?> col-<?php echo esc_attr( $col_xs ); ?>">

            <div class="capa__case__box tp-el-project-item">
                <div class="capabilities__items">
                    <a href="<?php the_permalink(); ?>" class="thumb">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <div class="content">
                    <?php if( !empty( $tslugs_arr ) ) : ?>
						<a href="<?php echo esc_url( $cat_link ); ?>" class="cmn--btn capabilites__btn tp-el-cat-btn">
							<span><?php echo esc_html( $tslugs_arr[0] ); ?></span>
						</a>
					<?php endif; ?>
                    <h4 class="tp-el-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                </div>
            </div>

        </div>
        <?php
			endwhile;
			wp_reset_query();  
			?> 
        <!--col grid-->
    </div>
    <?php 
        echo paginate_links(
            array(
                'total'      => $best_wp->max_num_pages,
                'type'       => 'list',
                'current'    => max( 1, $paged ),
                'prev_text'  => '<i class="fa fa-angle-left"></i>',
                'next_text'  => '<i class="fa fa-angle-right"></i>'
            )
        );
    ?>
</div>
