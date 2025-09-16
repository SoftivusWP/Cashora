<?php
class Bookinfo_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'bookinfo_widget', // Widget ID
            __('Book Info Widget', 'text_domain'), // Widget Name
            array('description' => __('A widget that displays book information.', 'text_domain')) // Widget Description
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (!empty($instance['description'])) {
            echo '<p>' . esc_html($instance['description']) . '</p>';
        }

        if (!empty($instance['repeater'])) {
            echo '<ul class="tp-bookinfo-list">';
            foreach ($instance['repeater'] as $item) {
                if (!empty($item['key']) && !empty($item['value'])) {
                    echo '<li><strong>' . wp_kses_post($item['key']) . ':</strong> ' . wp_kses_post($item['value']) . '</li>';
                }
            }
            echo '</ul>';
        }

        echo '<div class="book-author-wrapp">';
            echo '<div class="book-author-image">';
            if (!empty($instance['avatar_image'])) {
                echo '<img src="' . esc_url($instance['avatar_image']) . '" alt="Author Avatar" class="author-avatar">';
            }
            echo '</div>';
            echo '<div class="book-author-content">';
            if (!empty($instance['avatar_name'])) {
                echo '<h3 class="avatar-name">' . esc_html($instance['avatar_name']) . '</h3>';
            }

            if (!empty($instance['avatar_designation'])) {
                echo '<p class="avatar-designation">' . esc_html($instance['avatar_designation']) . '</p>';
            }
            echo '</div>';
        echo '</div>';

        if (!empty($instance['button_text']) && !empty($instance['button_url'])) {
            echo '<a href="' . esc_url($instance['button_url']) . '" class="box-style w-100 rounded-0 box-second third-alt d-center gap-2 py-1 py-xl-3 px-3 px-xl-6">' . esc_html($instance['button_text']) . '</a>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $repeater = !empty($instance['repeater']) ? $instance['repeater'] : array();
        $avatar_image = !empty($instance['avatar_image']) ? $instance['avatar_image'] : '';
        $avatar_name = !empty($instance['avatar_name']) ? $instance['avatar_name'] : '';
        $avatar_designation = !empty($instance['avatar_designation']) ? $instance['avatar_designation'] : '';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : '';
        $button_url = !empty($instance['button_url']) ? $instance['button_url'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <div class="repeater-container">
            <?php
            if (!empty($repeater)) {
                foreach ($repeater as $index => $item) {
                    $this->repeater_item($index, $item);
                }
            }
            ?>
        </div>
        <button type="button" class="button add-repeater-item"><?php esc_html_e('Add Item', 'text_domain'); ?></button>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('avatar_image')); ?>"><?php esc_html_e('Avatar Image URL:', 'text_domain'); ?></label>
            <input class="widefat image-upload-url" id="<?php echo esc_attr($this->get_field_id('avatar_image')); ?>" name="<?php echo esc_attr($this->get_field_name('avatar_image')); ?>" type="text" value="<?php echo esc_attr($avatar_image); ?>">
            <button type="button" class="button tp-image-upload-button"><?php esc_html_e('Upload Image', 'text_domain'); ?></button>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('avatar_name')); ?>"><?php esc_html_e('Avatar Name:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('avatar_name')); ?>" name="<?php echo esc_attr($this->get_field_name('avatar_name')); ?>" type="text" value="<?php echo esc_attr($avatar_name); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('avatar_designation')); ?>"><?php esc_html_e('Avatar Designation:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('avatar_designation')); ?>" name="<?php echo esc_attr($this->get_field_name('avatar_designation')); ?>" type="text" value="<?php echo esc_attr($avatar_designation); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button Text:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($button_text); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_url')); ?>"><?php esc_html_e('Button URL:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_url')); ?>" name="<?php echo esc_attr($this->get_field_name('button_url')); ?>" type="text" value="<?php echo esc_attr($button_url); ?>">
        </p>
        <script>
            jQuery(document).ready(function($) {
                var container = $('.repeater-container');
                var count = container.children().length;

                $('.add-repeater-item').on('click', function() {
                    var template = `
                        <div class="repeater-item">
                            <p>
                                <label><?php esc_html_e('Key:', 'text_domain'); ?></label>
                                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('repeater')); ?>[${count}][key]" type="text">
                            </p>
                            <p>
                                <label><?php esc_html_e('Value:', 'text_domain'); ?></label>
                                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('repeater')); ?>[${count}][value]" type="text">
                            </p>
                            <button type="button" class="button remove-repeater-item"><?php esc_html_e('Remove', 'text_domain'); ?></button>
                        </div>
                    `;
                    container.append(template);
                    count++;
                });

                $(document).on('click', '.remove-repeater-item', function() {
                    $(this).closest('.repeater-item').remove();
                });

                $(document).on('click', '.tp-image-upload-button', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var customUploader = wp.media({
                        title: '<?php esc_html_e('Choose Image', 'text_domain'); ?>',
                        library: {
                            type: 'image'
                        },
                        button: {
                            text: '<?php esc_html_e('Use this image', 'text_domain'); ?>'
                        },
                        multiple: false
                    }).on('select', function() {
                        var attachment = customUploader.state().get('selection').first().toJSON();
                        button.siblings('.image-upload-url').val(attachment.url);
                    }).open();
                });

            });
        </script>
        <?php
    }

    private function repeater_item($index, $item) {
        ?>
        <div class="repeater-item">
            <p>
                <label><?php esc_html_e('Key:', 'text_domain'); ?></label>
                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('repeater')); ?>[<?php echo esc_attr($index); ?>][key]" type="text" value="<?php echo wp_kses_post($item['key']); ?>">
            </p>
            <p>
                <label><?php esc_html_e('Value:', 'text_domain'); ?></label>
                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('repeater')); ?>[<?php echo esc_attr($index); ?>][value]" type="text" value="<?php echo wp_kses_post($item['value']); ?>">
            </p>
            <button type="button" class="button remove-repeater-item"><?php esc_html_e('Remove', 'text_domain'); ?></button>
        </div>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['repeater'] = (!empty($new_instance['repeater'])) ? $this->sanitize_repeater($new_instance['repeater']) : array();
        $instance['avatar_image'] = (!empty($new_instance['avatar_image'])) ? esc_url_raw($new_instance['avatar_image']) : '';
        $instance['avatar_name'] = (!empty($new_instance['avatar_name'])) ? sanitize_text_field($new_instance['avatar_name']) : '';
        $instance['avatar_designation'] = (!empty($new_instance['avatar_designation'])) ? sanitize_text_field($new_instance['avatar_designation']) : '';
        $instance['button_text'] = (!empty($new_instance['button_text'])) ? sanitize_text_field($new_instance['button_text']) : '';
        $instance['button_url'] = (!empty($new_instance['button_url'])) ? esc_url_raw($new_instance['button_url']) : '';
        return $instance;
    }

    private function sanitize_repeater($repeater) {
        $sanitized_repeater = array();
        if (is_array($repeater)) {
            foreach ($repeater as $item) {
                if (!empty($item['key']) || !empty($item['value'])) {
                    $sanitized_repeater[] = array(
                        'key' => wp_kses_post($item['key']),
                        'value' => wp_kses_post($item['value']),
                    );
                }
            }
        }
        return $sanitized_repeater;
    }
}

function register_bookinfo_widget() {
    register_widget('Bookinfo_Widget');
}
add_action('widgets_init', 'register_bookinfo_widget');
