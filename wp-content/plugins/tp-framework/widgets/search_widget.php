<?php
/**
 * Plugin Name: TP Search Widget
 * Description: Custom search widget with post type selection.
 */

// Register and load the widget
function wpb_load_search_widget() {
    register_widget( 'tptheme_search_widget' );
}
add_action( 'widgets_init', 'wpb_load_search_widget' );

// Creating the widget 
class tptheme_search_widget extends WP_Widget {
   
    public function __construct() {
        parent::__construct(
            'tptheme_search_widget',
            __( 'TP Search Widget', 'tp-framework' ),
            array( 'description' => __( 'Search widget with post type selection', 'tp-framework' ) )
        );
    }

    // Widget Backend 
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post'; // Default to 'post'

        // Get all registered post types
        $post_types = get_post_types( array( 'public' => true ), 'objects' );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_html_e( 'Title:', 'tp-framework' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>">
                <?php esc_html_e( 'Select Post Type:', 'tp-framework' ); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
                <?php foreach ( $post_types as $post_type_slug => $post_type_obj ) : ?>
                    <option value="<?php echo esc_attr( $post_type_slug ); ?>" <?php selected( $post_type, $post_type_slug ); ?>>
                        <?php echo esc_html( $post_type_obj->labels->singular_name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']     = sanitize_text_field( $new_instance['title'] );
        $instance['post_type'] = sanitize_text_field( $new_instance['post_type'] );

        return $instance;
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title     = isset( $instance['title'] ) ? $instance['title'] : '';
        $post_type = isset( $instance['post_type'] ) ? $instance['post_type'] : 'post'; // Default to 'post'

        $search_text = get_search_query(); // Get the search query from the current search

        // Display search form
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        ?>
        <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search...', 'tp-framework' ); ?>" value="<?php echo esc_attr( $search_text ); ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'tp-framework' ); ?>" />
            <input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>" />
            <button type="submit" class="search-submit"><i class="tp tp-search"></i></button>
        </form>
        <?php
        echo $args['after_widget'];
    }
}

