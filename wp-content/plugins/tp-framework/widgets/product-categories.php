<?php

// Adds Weiboo Product Categories widget.
class tp_pcats extends WP_Widget {

	// Register widget with WordPress.
	function __construct() {
		parent::__construct(
			'tp_pcats', // Base ID
			__( 'TP Product Categories', 'tp-framework' ), // Name
			array( 'description' => __( 'Show Product Categories and Subcategories', 'tp-framework' ), ) // Args
		);
	}

	// Front-end display of widget.
	public function widget( $args, $instance ) {
		// echo $args['before_widget'];
		?>
			<div class="widget pixelaxis-pcat col-lg-12 mx-auto mb25">
				<div id="categories" class="widget-bg p20">
					<h2 class="widget-title"><?php esc_html_e( 'Product Category', 'tp-framework' ); ?></h2>

					<nav class='animated bounceInDown'>
						<ul>
							<?php
							$taxonomies = get_terms( array(
								'taxonomy' => 'product_cat', //Custom taxonomy name
								'hide_empty' => true
							) );

							if ( !empty($taxonomies) ) :
								foreach( $taxonomies as $category ) {
									if( $category->parent == 0 ) {
										
										//remove uncategorized from loop
										if( $category->slug == 'uncategorized' ){
											continue;
										}
										$name_count = $category->name.' ('.$category->count.')';
										$clink = get_term_link( $category );
										//Parent category information
										// echo esc_html__($category->name, 'tp-framework');
										// echo esc_html__($category->description, 'tp-framework');
										// echo esc_html__($category->slug, 'tp-framework');
										// echo esc_html__($category->count, 'tp-framework');
										$cat_child = get_term_children($category->term_id, 'product_cat');
										if($cat_child){
											//Sub category information
											?>
											<li class='sub-menu'>
												<a href='<?php echo esc_url($clink); ?>'><?php echo esc_html__( $name_count, 'tp-framework' ) ?>
													<!-- <div class='fa fa-caret-down right'></div> -->
												</a>
												<div class='toggler'><i class="tp-angle-down"></i> </div>
											<ul>

												<?php
													foreach($cat_child as $ch_id){
														$catc = get_term_by('id', $ch_id, 'product_cat');
														$chid_name = $catc->name.' ('.$catc->count.')';
														$child_link = get_term_link( $catc );
														?>
														<li><a href="<?php echo esc_url($child_link); ?>"><?php echo esc_html__($chid_name, 'tp-framework') ?></a></li>
														<?php
													}
												?>
											</ul>
										</li>
										<?php
										}else{
											echo "<li><a href='".esc_url($clink)."'>". esc_html__( $name_count, 'tp-framework') ."</a></li>";
										}
									}
								}
							endif;
							?>
						</ul>
					</nav>

					
	
			    </div>
			</div> 
		<?php //echo $args['after_widget'];
	}

} // class weiboo categories

// register weiboo categories
function pixelaxis_register_custom_widgets() {
    register_widget( 'tp_pcats' );
}
add_action( 'widgets_init', 'pixelaxis_register_custom_widgets' );