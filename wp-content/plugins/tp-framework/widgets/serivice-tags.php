<?php

// Adds Post Tags widget.
class tp_post_tags extends WP_Widget {

	// Register widget with WordPress.
	function __construct() {
		parent::__construct(
			'tp_post_tags', // Base ID
			__( 'TP Post Tags', 'tp-framework' ), // Name
			array( 'description' => __( 'Show Post Tags for selected post type', 'tp-framework' ), ) // Args
		);
	}

	// Front-end display of widget.
	public function widget( $args, $instance ) {
		$post_type = !empty($instance['post_type']) ? $instance['post_type'] : 'post';
		$title = !empty($instance['title']) ? $instance['title'] : __( 'Post Tags', 'tp-framework' );

		?>
			<div class="widget pixelaxis-tags col-lg-12 mx-auto mb25">
				<div id="tags" class="widget-bg p20">
					<h2 class="widget-title"><?php echo esc_html($title); ?></h2>

					<div class='pixelaxis-tag-wrapper'>
						<?php
						$tags = get_terms( array(
							'taxonomy' => 'post_tag', // Using post tags
							'hide_empty' => true
						) );

						if ( !empty($tags) ) :
							foreach( $tags as $tag ) {
								$name_count = $tag->name.' ('.$tag->count.')';
								$tag_link = get_term_link( $tag );
								?>
								<a href='<?php echo esc_url($tag_link); ?>'><?php echo esc_html($name_count); ?></a>
								<?php
							}
						endif;
						?>
					</div>
				</div>
			</div> 
		<?php 
	}

	// Back-end widget form
	public function form( $instance ) {
		$post_type = !empty($instance['post_type']) ? $instance['post_type'] : 'post';
		$title = !empty($instance['title']) ? $instance['title'] : __( 'Post Tags', 'tp-framework' );
		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php esc_html_e( 'Title:', 'tp-framework' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>">
				<?php esc_html_e( 'Select Post Type:', 'tp-framework' ); ?>
			</label>
			<select id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>">
				<?php foreach ( $post_types as $type ) : ?>
					<option value="<?php echo esc_attr($type->name); ?>" <?php selected($post_type, $type->name); ?>>
						<?php echo esc_html($type->label); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	// Updating widget
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : __( 'Post Tags', 'tp-framework' );
		$instance['post_type'] = !empty($new_instance['post_type']) ? sanitize_text_field($new_instance['post_type']) : 'post';
		return $instance;
	}
}

// Register post tags widget
function pixelaxis_register_post_tags_widget() {
    register_widget( 'tp_post_tags' );
}
add_action( 'widgets_init', 'pixelaxis_register_post_tags_widget' );
