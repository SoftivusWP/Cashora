<?php

// Adds All Post Types Categories widget.
class TP_All_Post_Types_Categories extends WP_Widget {

    // Register widget with WordPress.
    public function __construct() {
        parent::__construct(
            'tp_all_post_types_categories', // Base ID
            __('TP Post Categories', 'tp-framework'), // Name
            array('description' => __('Show categories for selected post types', 'tp-framework'),) // Args
        );
    }

    // Front-end display of widget.
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('All Categories', 'tp-framework');
        $selected_post_types = !empty($instance['post_types']) ? $instance['post_types'] : array('post');

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        echo '<div class="pixelaxis-all-categories-wrapper">';

        foreach ($selected_post_types as $post_type) {
            $taxonomy = $this->get_post_type_taxonomy($post_type);

            if (!$taxonomy) {
                continue;
            }

            $categories = get_terms(array(
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
            ));

            if (!empty($categories) && !is_wp_error($categories)) {
                echo '<ul>';
                foreach ($categories as $category) {

                    //remove uncategorized from loop
                    if( $category->slug == 'uncategorized' ){
                        continue;
                    }
                    
                    $category_link = get_term_link($category);
                    if (!is_wp_error($category_link)) {
                        echo '<li><a href="' . esc_url($category_link) . '">' . esc_html($category->name) . ' <span>(' . esc_html($category->count) . ')</span></a></li>';
                    }
                }
                echo '</ul>';
            }
        }

        echo '</div>';
        echo $args['after_widget'];
    }

    // Back-end widget form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('All Categories', 'tp-framework');
        $selected_post_types = !empty($instance['post_types']) ? $instance['post_types'] : array('post');
        
        $post_types = $this->get_post_types_with_taxonomies();
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'tp-framework'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label><?php esc_html_e('Select Post Types to Display Categories:', 'tp-framework'); ?></label><br>
            <?php foreach ($post_types as $post_type => $taxonomy) : 
                $post_type_obj = get_post_type_object($post_type);
            ?>
                <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('post_types_' . $post_type)); ?>" 
                       name="<?php echo esc_attr($this->get_field_name('post_types')); ?>[]" 
                       value="<?php echo esc_attr($post_type); ?>" 
                       <?php checked(in_array($post_type, $selected_post_types)); ?>>
                <label for="<?php echo esc_attr($this->get_field_id('post_types_' . $post_type)); ?>">
                    <?php echo esc_html($post_type_obj->label); ?>
                    (<?php echo esc_html($taxonomy); ?>)
                </label><br>
            <?php endforeach; ?>
        </p>
        <?php
    }

    // Updating widget
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['post_types'] = !empty($new_instance['post_types']) ? array_map('sanitize_text_field', $new_instance['post_types']) : array('post');
        return $instance;
    }

    // Helper function to get post types with taxonomies
    private function get_post_types_with_taxonomies() {
        $post_types = get_post_types(array('public' => true), 'objects');
        $result = array();

        foreach ($post_types as $post_type => $post_type_obj) {
            $taxonomy = $this->get_post_type_taxonomy($post_type);
            if ($taxonomy) {
                $result[$post_type] = $taxonomy;
            }
        }

        return $result;
    }

    // Helper function to get the category taxonomy for a post type
    private function get_post_type_taxonomy($post_type) {
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        foreach ($taxonomies as $tax_slug => $tax) {
            if ($tax->hierarchical) {
                return $tax_slug;
            }
        }
        return false;
    }
}

// Register all post types categories widget
function pixelaxis_register_all_post_types_categories_widget() {
    register_widget('TP_All_Post_Types_Categories');
}
add_action('widgets_init', 'pixelaxis_register_all_post_types_categories_widget');
?>