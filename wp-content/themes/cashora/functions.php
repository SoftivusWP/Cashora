<?php

if ( ! function_exists( 'cashora_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */ 

function cashora_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on cashora, use a find and replace
	 * to change 'cashora' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'cashora', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	if ( class_exists( 'WooCommerce' ) ) {  

		add_theme_support( 'woocommerce' );	
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	}

	function my_theme_register_block_patterns() {
		register_block_pattern( 'my-theme/my-pattern', array(
			'title'       => __( 'My Pattern', 'cashora' ),
			'description' => _x( 'A custom pattern for my theme.', 'Block pattern description', 'cashora' ),
			'content'     => "<!-- wp:paragraph --><p>" . __( 'Hello world!', 'cashora' ) . "</p><!-- /wp:paragraph -->",
		));
	}
	add_action( 'init', 'my_theme_register_block_patterns' );
	function my_theme_register_block_styles() {
		register_block_style( 'core/quote', array(
			'name'  => 'fancy-quote',
			'label' => __( 'Fancy Quote', 'cashora' ),
		));
	}
	add_action( 'init', 'my_theme_register_block_styles' );

	
	function cashora_change_excerpt( $text )
	{
		$pos = strrpos( $text, '[');
		if ($pos === false)
		{
			return $text;
		}
		
		return rtrim (substr($text, 0, $pos) ) . '...';
	}
	add_filter('get_the_excerpt', 'cashora_change_excerpt');


	// Limit Excerpt Length by number of Words
	function cashora_custom_excerpt( $limit ) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
		} else {
		$excerpt = implode(" ",$excerpt);
		}
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
		return $excerpt;
		}
		function content($limit) {
		$content = explode(' ', get_the_content(), $limit);
		if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
		} else {
		$content = implode(" ",$content);
		}
		$content = preg_replace('/[.+]/','', $content);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary Menu', 'cashora' ),		
		'menu-2' => esc_html__( 'Single Menu', 'cashora' ),
		
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cashora_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	//add support posts format
	add_theme_support( 'post-formats', array( 
		'aside', 
		'gallery',
		'audio',
		'video',
		'image',
		'quote',
		'link',
	) );

add_theme_support( 'align-wide' );	
}
endif;
add_action( 'after_setup_theme', 'cashora_setup' );

/**
*Custom Image Size
*/
add_image_size( 'cashora-blog-slider', 420, 365, true );
add_image_size( 'cashora-blog-sideabr', 87, 87, true );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cashora_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cashora_content_width', 640 );
}
add_action( 'after_setup_theme', 'cashora_content_width', 0 );


/**
 * Implement the Custom Header feature.
 */
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 *  Enqueue scripts and styles.
 */
require_once get_template_directory() . '/inc/theme-scripts.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/theme-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/theme-sidebar.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Custom Style
 */
require_once get_template_directory() . '/inc/dyanamic-css.php';
require_once get_template_directory() . '/libs/theme-option/config.php';
require_once get_template_directory() . '/inc/tgm/tgm-config.php';


//----------------------------------------------------------------------
// Remove Redux Framework NewsFlash
//----------------------------------------------------------------------
if ( ! class_exists( 'reduxNewsflash' ) ):
    class reduxNewsflash {
        public function __construct( $parent, $params ) {}
    }
endif;

function cashora_remove_demo_mode_link() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'cashora_remove_demo_mode_link');

/**
 * Registers an editor stylesheet for the theme.
 */
function cashora_theme_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'cashora_theme_add_editor_styles' );


//------------------------------------------------------------------------
//Organize Comments form field
//-----------------------------------------------------------------------
function cashora_wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}

add_filter( 'comment_form_fields', 'cashora_wpb_move_comment_field_to_bottom' );	


//adding placeholder text for comment form

function cashora_comment_textarea_placeholder( $args ) {
	$args['comment_field']        = str_replace( '<textarea', '<textarea placeholder="Comment"', $args['comment_field'] );
	return $args;
}
add_filter( 'comment_form_defaults', 'cashora_comment_textarea_placeholder' );

/**
 * Comment Form Fields Placeholder
 *
 */
function cashora_comment_form_fields( $fields ) {
	foreach( $fields as &$field ) {
		$field = str_replace( 'id="author"', 'id="author" placeholder="Name*"', $field );
		$field = str_replace( 'id="email"', 'id="email" placeholder="Email*"', $field );
		$field = str_replace( 'id="url"', 'id="url" placeholder="Website"', $field );
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'cashora_comment_form_fields' );


//customize archive tilte
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;
        }
    return $title;
});

add_filter( 'get_the_archive_title', 'cashora_archive_title_remove_prefix' );
function cashora_archive_title_remove_prefix( $title ) {
	if ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
}

function cashora_menu_add_description_to_menu($item_output, $item, $depth, $args) {

   if (strlen($item->description) > 0 ) {
      // append description after link
      $item_output .= sprintf('<span class="description">%s</span>', esc_html($item->description));   
     
   }   
   return $item_output;
}
add_filter('walker_nav_menu_start_el', 'cashora_menu_add_description_to_menu', 10, 4);

add_filter('wp_list_categories', 'cashora_cat_count_span');
function cashora_cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span>(', $links);
  $links = str_replace(')', ')</span>', $links);
  return $links;
}

function cashora_style_the_archive_count($links) {
    $links = str_replace('</a>&nbsp;(', '</a> <span class="archiveCount">(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

add_filter('get_archives_link', 'cashora_style_the_archive_count');

/**
 * Post title array
 */
function cashora_get_postTitleArray($postType = 'post' ){
    $post_type_query  = new WP_Query(
        array (
            'post_type'      => $postType,
            'posts_per_page' => -1,
            'orderby' => 'title',
    		'order'   => 'ASC',
        )
    );
    // we need the array of posts
    $posts_array      = $post_type_query->posts;
    // the key equals the ID, the value is the post_title
    if ( is_array($posts_array) ) {
        $post_title_array = wp_list_pluck($posts_array, 'post_title', 'ID' );
    } else {
        $post_title_array['default'] = esc_html__( 'Default', 'cashora' );
    }
    return $post_title_array;
}


if ( class_exists( 'WooCommerce' ) ) { 

	/**
	 * Display 3 products per row on Shop Page
	 */
	add_filter('loop_shop_columns', 'fitton_default_shop_loop_columns');
	function fitton_default_shop_loop_columns() {
		return 3;
	}

	/**
	 * Remove WooCommerce Actions 
	 */
	add_action( 'init', 'woo_remove_actions' );
	function woo_remove_actions() {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

}


/** #######################################################################################################################################################
 * Cashback tracker start here 
 * #####################################################################################################################################################***/

// Register Category taxonomy for cbtrkr_shop
function cbtrkr_shop_register_category_taxonomy() {
    register_taxonomy(
        'cbtrkr_shop_category', // taxonomy slug
        'cbtrkr_shop',          // post type
        array(
            'labels' => array(
                'name'              => __( 'Shop Categories', 'textdomain' ),
                'singular_name'     => __( 'Shop Category', 'textdomain' ),
                'search_items'      => __( 'Search Shop Categories', 'textdomain' ),
                'all_items'         => __( 'All Shop Categories', 'textdomain' ),
                'parent_item'       => __( 'Parent Shop Category', 'textdomain' ),
                'parent_item_colon' => __( 'Parent Shop Category:', 'textdomain' ),
                'edit_item'         => __( 'Edit Shop Category', 'textdomain' ),
                'update_item'       => __( 'Update Shop Category', 'textdomain' ),
                'add_new_item'      => __( 'Add New Shop Category', 'textdomain' ),
                'new_item_name'     => __( 'New Shop Category Name', 'textdomain' ),
                'menu_name'         => __( 'Shop Categories', 'textdomain' ),
            ),
            'hierarchical' => true, // true = like categories, false = like tags
            'show_admin_column' => true,
            'show_ui' => true,
            'show_in_rest' => true, // enable for Gutenberg/REST API
        )
    );
}
add_action( 'init', 'cbtrkr_shop_register_category_taxonomy' );



/*******
 * ########################################################################################################################################################
 * Add Image column to cbtrkr_shop_category taxonomy list
 * #######################################################################################################################################################
 * ********/
// Add new column
function cbtrkr_shop_category_columns($columns) {
    $new = [];
    $new['cbtrkr_shop_category_image'] = __('Image', 'eblog'); // Add before name column
    return array_slice($columns, 0, 1, true) + $new + array_slice($columns, 1, null, true);
}
add_filter('manage_edit-cbtrkr_shop_category_columns', 'cbtrkr_shop_category_columns');

// Populate column
function cbtrkr_shop_category_column_content($content, $column_name, $term_id) {
    if ($column_name === 'cbtrkr_shop_category_image') {
        $image_id = get_term_meta($term_id, 'cbtrkr_shop_category_image', true);
        if ($image_id) {
            $image = wp_get_attachment_image($image_id, 'thumbnail', false, ['style' => 'width:40px;height:auto;border-radius:4px;']);
            return $image;
        } else {
            return '<span style="color:#999;">—</span>';
        }
    }
    return $content;
}
add_filter('manage_cbtrkr_shop_category_custom_column', 'cbtrkr_shop_category_column_content', 10, 3);

// Make column not sortable (optional, just keeps UI clean)
function cbtrkr_shop_category_column_width() {
    echo '<style>
        .column-cbtrkr_shop_category_image { width:60px; text-align: start; }
    </style>';
}
add_action('admin_head', 'cbtrkr_shop_category_column_width');



/*******
 * ########################################################################################################################################################
 * Cashback Shop Category Image start Here 
 * #######################################################################################################################################################
 * ********/

// Add image upload field to add form
function cbtrkr_shop_category_add_image_field($taxonomy) {
    ?>
    <div class="form-field term-group">
        <label for="cbtrkr_shop_category_image"><?php _e('Category Image', 'eblog'); ?></label>
        <input type="hidden" id="cbtrkr_shop_category_image" name="cbtrkr_shop_category_image" value="">
        <div id="cbtrkr_shop_category_image_wrapper"></div>
        <button type="button" class="button cbtrkr_shop_category_image_upload"><?php _e('Add Image', 'eblog'); ?></button>
        <button type="button" class="button cbtrkr_shop_category_image_remove"><?php _e('Remove Image', 'eblog'); ?></button>
    </div>
    <?php
}
add_action('cbtrkr_shop_category_add_form_fields', 'cbtrkr_shop_category_add_image_field', 10, 2);

// Save category image
function cbtrkr_shop_category_save_image($term_id, $tt_id) {
    if (isset($_POST['cbtrkr_shop_category_image']) && '' !== $_POST['cbtrkr_shop_category_image']) {
        add_term_meta($term_id, 'cbtrkr_shop_category_image', absint($_POST['cbtrkr_shop_category_image']), true);
    }
}
add_action('created_cbtrkr_shop_category', 'cbtrkr_shop_category_save_image', 10, 2);

// Edit form field
function cbtrkr_shop_category_edit_image_field($term, $taxonomy) {
    $image_id = get_term_meta($term->term_id, 'cbtrkr_shop_category_image', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="cbtrkr_shop_category_image"><?php _e('Category Image', 'eblog'); ?></label>
        </th>
        <td>
            <input type="hidden" id="cbtrkr_shop_category_image" name="cbtrkr_shop_category_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="cbtrkr_shop_category_image_wrapper">
                <?php if ($image_id) {
                    echo wp_get_attachment_image($image_id, 'thumbnail');
                } ?>
            </div>
            <button type="button" class="button cbtrkr_shop_category_image_upload"><?php _e('Add Image', 'eblog'); ?></button>
            <button type="button" class="button cbtrkr_shop_category_image_remove"><?php _e('Remove Image', 'eblog'); ?></button>
        </td>
    </tr>
    <?php
}
add_action('cbtrkr_shop_category_edit_form_fields', 'cbtrkr_shop_category_edit_image_field', 10, 2);

// Update image
function cbtrkr_shop_category_update_image($term_id, $tt_id) {
    if (isset($_POST['cbtrkr_shop_category_image']) && '' !== $_POST['cbtrkr_shop_category_image']) {
        update_term_meta($term_id, 'cbtrkr_shop_category_image', absint($_POST['cbtrkr_shop_category_image']));
    } else {
        delete_term_meta($term_id, 'cbtrkr_shop_category_image');
    }
}
add_action('edited_cbtrkr_shop_category', 'cbtrkr_shop_category_update_image', 10, 2);
