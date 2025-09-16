<?php //******************//
$cat = $settings['service_category'];

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if(empty($cat)){
	$best_wp = new wp_Query(array(
			'post_type'      => 'services',
			'posts_per_page' => $settings['per_page'],
			'paged'          => $paged					
	));	  
}   
else{
	$best_wp = new wp_Query(array(
		'post_type'      => 'services',
		'posts_per_page' => $settings['per_page'],
		'paged'          => $paged,
		'tax_query'      => array(
			array(
				'taxonomy' => 'service-category',
				'field'    => 'slug', //can be set to ID
				'terms'    => $cat //if field is ID you can reference by cat/term number
			),
		)
	));	  
} 
$col_xl = $settings['col_xl'] ? $settings['col_xl'] : '3';
$col_lg = $settings['col_lg'] ? $settings['col_lg'] : '4';
$col_md = $settings['col_md'] ? $settings['col_md'] : '6';
$col_sm = $settings['col_sm'] ? $settings['col_sm'] : '6';
$col_xs = $settings['col_xs'] ? $settings['col_xs'] : '12';

?>
<div class="tp-icon-box-<?php echo esc_attr( $settings['service_grid_source'] ); ?>">
	<div class="row mb-10">
		<?php
		while($best_wp->have_posts()): $best_wp->the_post();
		$post_id = get_the_ID();
		$image_url = get_post_meta( $post_id, 'service-thumb', true );		

		?>
		<div class="col-xl-<?php echo esc_attr( $col_xl ); ?> col-lg-<?php echo esc_attr( $col_lg ); ?> col-md-<?php echo esc_attr( $col_md ); ?> col-sm-<?php echo esc_attr( $col_sm ); ?> col-<?php echo esc_attr( $col_xs ); ?>">
			<div class="tp-iconbox-area">
				<div class="box-inner">
				
					<div class="tp-box-inner-wrapper ">
						<?php if( $settings['enable_icon_position_bottom'] !== 'yes' ) : ?>
						<?php if( !empty( $image_url ) ){?>
						<div class="icon-area">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr__( 'Icon Image', 'tp-elements' ); ?>">
						</div>
						<?php }?> 
						<?php endif;?>
						<div class="text-area">
							<div class="iconbox-title">								
								<<?php echo esc_html($settings['title_tag']);?> class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_html($settings['title_tag']);?>>
							</div>
							<?php the_excerpt(); ?>
							<?php if(!empty($settings['services_btn_text'])){ ?>
							<div class="services-btn-part">
								<?php if(!empty($settings['services_btn_text'])) : 
									$link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : '';
								?>

								<?php  
									$icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
								?>
									<a class="services-btn <?php echo esc_attr($icon_position) ?>" href="<?php the_permalink();?>" <?php echo wp_kses_post( $link_open ); ?>>
										<span class="btn-txt"><?php echo wp_kses_post( $settings['services_btn_text'] );?></span>
										<?php if(!empty($settings['services_btn_icon'])) : ?>
											<i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
										<?php endif; ?>
									</a>
								<?php else: ?>
								<?php endif;
								?>
								
							</div>
							<?php } ?>

						</div>
						<?php if( $settings['enable_icon_position_bottom'] == 'yes' ) : ?>

						<?php if( !empty( $image_url ) ){?>
						<div class="icon-area">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr__( 'Icon Image', 'tp-elements' ); ?>">
						</div>
						<?php }?> 
						
						<?php endif;?>
					</div>

				</div>
			</div>	
		</div>
		<?php
		endwhile;
		wp_reset_query();  
		?>  
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
