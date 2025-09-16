<?php 
// Add meta boxes for pages, posts, and custom post types
add_action('add_meta_boxes', 'add_sidebar_metabox');
add_action('save_post', 'save_sidebar_postdata');

/* Adds a box to the side column on the Post and Page edit screens */
function add_sidebar_metabox() {
    add_meta_box(
        'custom_sidebar',
        esc_html__('Post Sidebar Setting', 'tp-framework'),
        'custom_sidebar_callback',
        'post',
        'side'
    );
    
    add_meta_box(
        'custom_sidebar',
        esc_html__('Page Sidebar Setting', 'tp-framework'),
        'custom_sidebar_callback',
        'page',
        'side'
    );

    add_meta_box(
        'custom_sidebar',
        esc_html__('Portfolio Sidebar Setting', 'tp-framework'),
        'custom_sidebar_callback',
        'tp-portfolios',
        'side'
    );
}

function custom_sidebar_callback($post) {
  global $wp_registered_sidebars;

  // Use nonce for verification
  wp_nonce_field(plugin_basename(__FILE__), 'custom_sidebar_nonce');

  $custom = get_post_custom($post->ID);
  $val = isset($custom['custom_sidebar']) ? $custom['custom_sidebar'][0] : 'default';
  $page_layout = get_post_meta($post->ID, 'layout', true);

  // Layout options
  $left_check = $page_layout === '2left' ? 'checked="checked"' : '';
  $right_check = $page_layout === '2right' ? 'checked="checked"' : '';
  $full_check = !$left_check && !$right_check ? 'checked="checked"' : '';

  $left_class = $left_check ? 'active' : '';
  $right_class = $right_check ? 'active' : '';
  $full_class = $full_check ? 'active' : '';

  $directory = get_template_directory_uri();
  $output1 = '<div class="radio-select"><p><label for="myplugin_layout">' . esc_html__("Choose Sidebar Layout", 'tp-framework') . '</label></p>';
  $output1 .= '<input id="2left" type="radio" name="layout" value="2left" ' . esc_attr($left_check) . '><label for="2left" class="' . esc_attr($left_class) . '"><img src="' . esc_url($directory) . '/assets/images/2cl.png" /></label>';
  $output1 .= '<input id="2right" type="radio" name="layout" value="2right" ' . esc_attr($right_check) . '><label for="2right" class="' . esc_attr($right_class) . '"><img src="' . esc_url($directory) . '/assets/images/2cr.png" /></label>';
  $output1 .= '<input id="full" type="radio" name="layout" value="full" ' . esc_attr($full_check) . '><label for="full" class="full ' . esc_attr($full_class) . '"><img src="' . esc_url($directory) . '/assets/images/1c.png" /></label></div>';
  echo $output1;

  // Sidebar options
  $output = '<p><label for="myplugin_new_field">' . esc_html__("Choose Portfolio Details layout", 'tp-framework') . '</label></p>';
  $output .= "<select name='custom_sidebar'>";

  if ($post->post_type === 'tp-portfolios') {
      // Custom options for tp-portfolios
      $tp_portfolio_options = array(
          'portfolio_default' => esc_html__('Portfolio Default', 'tp-framework'),
          'top_image_carousel' => esc_html__('Top Image Carousel', 'tp-framework'),
          'top_carousel_center' => esc_html__('Top Carousel Center', 'tp-framework'),
          'left_gallery_image' => esc_html__('Left Gallery Image', 'tp-framework'),
          'left_gallery_grid' => esc_html__('Left Gallery Grid', 'tp-framework'),
          'bottom_gallery_grid' => esc_html__('Bottom Gallery Grid', 'tp-framework'),
          'top_gallery_carousel' => esc_html__('Top Gallery Carousel', 'tp-framework'),
      );

      foreach ($tp_portfolio_options as $option_value => $option_label) {
          $output .= "<option value='" . esc_attr($option_value) . "'" . selected($option_value, $val, false) . ">" . esc_html($option_label) . "</option>";
      }
  } elseif($post->post_type === 'post') {
      // Custom options for tp-portfolios
      $tp_post_options = array(
        'post_default' => esc_html__('Post Default', 'tp-framework'),
    );

    foreach ($tp_post_options as $option_value => $option_label) {
        $output .= "<option value='" . esc_attr($option_value) . "'" . selected($option_value, $val, false) . ">" . esc_html($option_label) . "</option>";
    }
  } else {
      // Original code for other post types
      //$output .= "<option value='default'" . selected($val, 'default', false) . ">" . esc_html__('Select Sidebar', 'tp-framework') . "</option>";

      foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
          $output .= "<option value='" . esc_attr($sidebar_id) . "'" . selected($sidebar_id, $val, false) . ">" . esc_html($sidebar['name']) . "</option>";
      }
  }

  $output .= "</select>";
  echo $output;
}

/* When the post is saved, saves our custom data */
function save_sidebar_postdata($post_id) {
    // Verify nonce
    if (!isset($_POST['custom_sidebar_nonce']) || !wp_verify_nonce($_POST['custom_sidebar_nonce'], plugin_basename(__FILE__))) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save custom sidebar data
    if (isset($_POST['custom_sidebar'])) {
        update_post_meta($post_id, 'custom_sidebar', sanitize_text_field($_POST['custom_sidebar']));
    }

    // Save layout data
    if (isset($_POST['layout'])) {
        update_post_meta($post_id, 'layout', sanitize_text_field($_POST['layout']));
    }
}
