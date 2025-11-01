<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'rt_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function tp_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function tp_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function tp_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function tp_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array      $field_args Array of field parameters.
 * @param  CMB2_Field $field      Field object.
 */
function tp_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'tp_register_gallery_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function tp_register_gallery_metabox() {
	$prefix = 'tp_'; 
	$cmb_project = new_cmb2_box( array(
		'id'            => $prefix . 'metabox-gallery',
		'title'         => esc_html__( 'Gallery Images', 'tp-framework' ),
		'object_types'  => array( 'gallery' ), // Post type
		// 'show_on_cb' => 'tp_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'rt_add_some_classes', // Add classes through a callback.
	) );

	$cmb_project->add_field( array(
	'name' => 'Upload Gallery Images',
	'desc' => '',
	'id'   => 'Screenshot',
	'type' => 'file_list',
	// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	// 'query_args' => array( 'type' => 'image' ), // Only images attachment
	// Optional, override default text strings
	'text' => array(
		'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
		'remove_image_text' => 'Replacement', // default: "Remove Image"
		'file_text' => 'Replacement', // default: "File:"
		'file_download_text' => 'Replacement', // default: "Download"
		'remove_text' => 'Replacement', // default: "Remove"
	),
) );
	
}

add_action( 'cmb2_admin_init', 'tp_register_header_metabox' );

/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function tp_register_header_metabox() {
	$prefix = 'tp_'; 

  /**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Page Options', 'tp-framework' ),
		'object_types'  => array( 'page','post','teams','tp-portfolios','services','product','archive' ), // Post type
		'vertical_tabs' => true, // Set vertical tabs, default false
		'tabs' => array(
            array(
                'id'    => 'tab-1',
                'icon' => 'dashicons-admin-page',
                'title' => 'Page Settings',
                'fields' => array(
                    'primary-colors',
                    'page_bg',
                    'content_top',
                    'content_bottom'
                ),
            ),
                     
            array(
                'id'    => 'tab-9',
                'icon' => 'dashicons-format-image',
                'title' => 'Banner Settings',
                'fields' => array(
                    'banner_image',
                    'banner_hide',
                    'select-title',
                    'select-bread',                   
                    'content_banner',                   
                    'intro_content_banner'             
                ),
            ),         
                           

        )
		
	) );

function get_myposttype_options($argument) {
	$args = array(
		'post_type' => $argument, 
		'posts_per_page' => -1,
		'orderby' => 'title',
    	'order'   => 'ASC');
	$loop = new WP_Query($args);
	if($loop->have_posts()) {  
	    while($loop->have_posts()) : $loop->the_post();
	        //
	        $varID = get_the_id();
	        $varName = get_the_title();
	        $pageArray[$varID]=$varName;
	    endwhile; 
	    return  $pageArray;  
	}
	
}

	//Page Settings meta field
	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Primary Color', 'tp-framework' ),
		'desc'    => esc_html__( 'chosse your background', 'tp-framework' ),
		'id'      => 'primary-colors',		
		'type'    => 'colorpicker',
		'default' => '#f4f4f4',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Select Page Background Image', 'tp-framework' ),
		'desc' => esc_html__( 'Upload an image or enter a URL for page banner.', 'tp-framework' ),
		'id'   => 'page_bg',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Content Top Padding', 'tp-framework' ),
		'desc'    => esc_html__( 'example(120px)', 'tp-framework' ),
		'default' => esc_attr__( '120px', 'tp-framework' ),
		'id'      => 'content_top',
		'type'    => 'text_medium',
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Content Bottom Padding', 'tp-framework' ),
		'desc'    => esc_html__( 'example(80px)', 'tp-framework' ),
		'default' => esc_attr__( '80px', 'tp-framework' ),
		'id'      => 'content_bottom',
		'type'    => 'text_medium',
	) );


	
	//Banner Custom field here

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Select Banner Image', 'tp-framework' ),
		'desc' => esc_html__( 'Upload an image or enter a URL for page banner.', 'tp-framework' ),
		'id'   => 'banner_image',
		'type' => 'file',
	) );
    
    $cmb_demo->add_field( array(
		'name'             => esc_html__( 'Banner Hide', 'tp-framework' ),
		'desc'             => esc_html__( 'You Can Show or Hide Banner', 'tp-framework' ),
		'id'               => 'banner_hide',
		'type'             => 'select',
		'show_option_none' => 'Default',
		'options'          => array(
			'show' => esc_html__( 'Show', 'tp-framework' ),
			'hide' => esc_html__( 'Hide', 'tp-framework' ),			
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Show Page Title', 'tp-framework' ),
		'desc'             => esc_html__( 'You can show/hide page title', 'tp-framework' ),
		'id'               => 'select-title',
		'type'             => 'select',
		'show_option_none' => 'Default',
		'options'          => array(
			'show' => esc_html__( 'Show', 'tp-framework' ),
			'hide' => esc_html__( 'Hide', 'tp-framework' ),			
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Show Breadcurmbs', 'tp-framework' ),
		'desc'             => esc_html__( 'You can show/hide  breadcurmbs here', 'tp-framework' ),
		'id'               => 'select-bread',
		'type'             => 'select',
		'show_option_none' => 'Default',
		'options'          => array(
			'show' => esc_html__( 'Show', 'tp-framework' ),
			'hide' => esc_html__( 'Hide', 'tp-framework' ),			
		),
	));


	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Page Banner Text', 'tp-framework' ),
		'desc'    => esc_html__( 'Enter some text in banner', 'tp-framework' ),
		'id'      => 'content_banner',
		'type'    => 'textarea_small',
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Page Banner Intro Text', 'tp-framework' ),
		'desc'    => esc_html__( 'Enter some intro text in banner', 'tp-framework' ),
		'id'      => 'intro_content_banner',
		'type'    => 'textarea_small',
	) );

}


/**** Skill Meta ***/

add_action( 'cmb2_admin_init', 'pixelaxis_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function pixelaxis_register_repeatable_group_field_metabox() {
	$prefix = 'tp_group_';  

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Team Member Skill', 'tp-framework' ),
		'object_types' => array( 'teams' ),
		'priority'     => 'low',  //  'high', 'core', 'default' or 'low'
	) );
    
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => 'member_skill',
		'type'        => 'group',
		'description' => esc_html__( 'Team Member Personal Skills', 'tp-framework' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Skill {#}', 'tp-framework' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add More Skill', 'tp-framework' ),
			'remove_button' => esc_html__( 'Remove Skill', 'tp-framework' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Skill Title', 'tp-framework' ),
		'id'         => 'skill_title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Skill Level', 'tp-framework' ),
		'id'         => 'skill_level',
		'type'       => 'text',
		'desc' => esc_html__( 'add skill level as like (35%) out 100%', 'tp-framework' ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );		

}


/**** Product Ingredient ***/

add_action( 'cmb2_admin_init', 'product_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function product_register_repeatable_group_field_metabox() {
	$prefix = 'tp_group_in_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Product Ingredient', 'tp-framework' ),
		'object_types' => array( 'product' ),
		'priority'     => 'low',  //  'high', 'core', 'default' or 'low'
	) );


	$cmb_group->add_field( array(
		'name'    => esc_html__( 'Ingredient Label', 'tp-framework' ),
		'id'      => 'product_ingredient_label',
		'type'    => 'text',
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => 'product-ingredient',
		'type'        => 'group',
		'description' => esc_html__( 'Product Ingredient Information', 'tp-framework' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Ingredient {#}', 'tp-framework' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add More Ingredient', 'tp-framework' ),
			'remove_button' => esc_html__( 'Remove Ingredient', 'tp-framework' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );
	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Product Ingredient', 'tp-framework' ),
		'id'         => 'ingredient_feature',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );	

}




add_action( 'cmb2_admin_init', 'header_style_register_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function header_style_register_field_metabox() {
	$prefix = 'tp_group_header_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_meta_page = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Header Layout', 'tp-framework' ),
		'object_types' => array( 'elementor-hf' ),
		'priority'     => 'low',  //  'high', 'core', 'default' or 'low'
	) );

	$cmb_meta_page->add_field( array(
		'name'    => esc_html__( 'Fixed Header Layout', 'tp-framework' ),
		'desc'    => esc_html__( 'If you active it your header layout will be fixed/absolutue positon', 'tp-framework' ),		
		'id'      => 'header-position',
		'type'    => 'checkbox',
	) );

	
}



// Timeline Year
add_action( 'cmb2_admin_init', 'tp_register_timeline_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function tp_register_timeline_metabox() {
	$prefix = 'tp_demo_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_meta_page = new_cmb2_box( array(
		'id'            => $prefix . 'timeline',
		'title'         => esc_html__( 'Timeline Settings', 'tp-framework' ),
		'object_types'  => array( 'timelines' ), // Post type
		// 'show_on_cb' => 'tp_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'rt_add_some_classes', // Add classes through a callback.
	) );	

	$cmb_meta_page->add_field( array(
		'name'    => esc_html__( 'Enter Period of Time', 'tp-framework' ),
		'desc'    => esc_html__( 'Enter Period of Time i.e year of experience or year', 'tp-framework' ),		
		'id'      => 'year',
		'type'    => 'text_medium',
	) );
}


add_action( 'cmb2_admin_init', 'tp_service_project_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function tp_service_project_metabox() {
	$prefix = 'tp_'; 
	$cmb_project = new_cmb2_box( array(
		'id'            => $prefix . 'metabox-service',
		'title'         => esc_html__( 'Service Informations', 'tp-framework' ),
		'object_types'  => array( 'services' ), // Post type
		
	) );

	$cmb_project->add_field( array(
		'name' => 'Upload Icon Image',
		'desc' => '',
		'id'   => 'service-thumb',
		'type' => 'file',
	) );

	$cmb_project->add_field(array(
        'name' => 'Select Icon',
        'desc' => '',
        'id'   => 'service-icon',
        'type' => 'icon_select',
        'options' => array(
            'fas fa-home' => 'Home',
            'fas fa-user' => 'User',
            'fas fa-cog' => 'Cog',
            // Add more icons as needed
        ),
    ));

	$cmb_project->add_field( array(
		'name'    => esc_html__( 'Trainer Name', 'tp-framework' ),
		'desc'    => esc_html__( 'Ex Masum Billah', 'tp-framework' ),
		'id'      => 'service_trainer_name',
		'type'    => 'text',
	) ); 
	$cmb_project->add_field( array(
		'name'    => esc_html__( 'Traning Schedule', 'tp-framework' ),
		'desc'    => esc_html__( 'Ex 10.00am - 11.00pm', 'tp-framework' ),
		'id'      => 'service_schedule_time',
		'type'    => 'text',
	) ); 
	$cmb_project->add_field( array(
		'name'    => esc_html__( 'Training Fee', 'tp-framework' ),
		'desc'    => esc_html__( 'Ex $250.00', 'tp-framework' ),
		'id'      => 'service_training_fee',
		'type'    => 'text',
	) ); 

}


// Register custom field type
add_action('cmb2_render_icon_select', 'cmb2_render_icon_select_field', 10, 5);
function cmb2_render_icon_select_field($field, $escaped_value, $object_id, $object_type, $field_type_object) {
    $select_attrs = $field_type_object->select_attrs();

    echo $field_type_object->select(array(
        'class' => 'cmb2-icon-select',
        'options' => '<option value="">' . esc_html__('Select an icon', 'tp-framework') . '</option>' . $field_type_object->concat_items($field->options()),
        'desc' => $field_type_object->_desc(true),
    ));
}

//department post type metabox
add_action( 'cmb2_admin_init', 'tp_department_project_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function tp_department_project_metabox() {
	$prefix = 'tp_'; 
	$cmb_project = new_cmb2_box( array(
		'id'            => $prefix . 'icon-department',
		'title'         => esc_html__( 'Department Section', 'tp-framework' ),
		'object_types'  => array( 'mp-event' ), // Post type
		
	) );

	$cmb_project->add_field( array(
		'name' => 'Upload department icon',
		'desc' => '',
		'id'   => 'icon-thumb',
		'type' => 'file',
		
	) );

	$cmb_project->add_field( array(
		'name'    => esc_html__( 'Department Except', 'tp-framework' ),
		'desc'    => esc_html__( 'Enter some text', 'tp-framework' ),
		'id'      => 'content_dept',
		'type'    => 'textarea_small',
	) );
}


/**
 * Callback to define the optionss-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function tp_options_page_message_callback( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'tp-framework' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}

/**
 * Only show this box in the CMB2 REST API if the user is logged in.
 *
 * @param  bool                 $is_allowed     Whether this box and its fields are allowed to be viewed.
 * @param  CMB2_REST_Controller $cmb_controller The controller object.
 *                                              CMB2 object available via `$cmb_controller->rest_box->cmb`.
 *
 * @return bool                 Whether this box and its fields are allowed to be viewed.
 */
function tp_limit_rest_view_to_logged_in_users( $is_allowed, $cmb_controller ) {
	if ( ! is_user_logged_in() ) {
		$is_allowed = false;
	}

	return $is_allowed;
}

add_action('cmb2_admin_init', 'tp_portfolio_gallery_images_metas');

function tp_portfolio_gallery_images_metas() {
    $cmb = new_cmb2_box(array(
        'id'            => 'tp_portfolio_gallery_images_metas',
        'title'         => __('Portfolio Gallery', 'tp-framework'),
        'object_types'  => array('tp-portfolios'), // Custom post type
        'context'       => 'side',
        'priority'      => 'default',
    ));

	$cmb->add_field(array(
        //'name'       => 'Gallery Images',
        'desc'       => 'Upload and manage gallery images',
        'id'         => 'tp_gallery_images',
        'type'       => 'file_list',
        'options'    => array(
            'add_upload_file_text' => 'Add Images', // Change the text of the upload button
        ),
        'query_args' => array(
            'type' => 'image', // Specify to only show images
        ),
        'text' => array(
            'add_upload_file_text' => 'Add Images',
            'remove_image' => 'Remove Image',
            'file' => 'File',
            'file_remove' => 'Remove File',
        ),
    ));

}
 
add_action( 'cmb2_admin_init', 'tp_portfoloio_metas' );
/**
 * Define the metabox and field configurations.
 */
function tp_portfoloio_metas() {

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'tp_portfolio_metas',
		'title'         => __( 'Portfolio Details', 'tp-framework' ),
		'object_types'  => array( 'tp-portfolios', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$group_field_id = $cmb->add_field( array(
		'id'          => 'pf_details',
		'type'        => 'group',

		'options'     => array(
			'group_title'       => __( 'Info {#}', 'tp-framework' ), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __( 'Add Another Info', 'tp-framework' ),
			'remove_button'     => __( 'Remove Info', 'tp-framework' ),
			'sortable'          => true,
			// 'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'tp-framework' ), // Performs confirmation before removing group.
		),
	) );


	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	// $cmb->add_group_field( $group_field_id, array(
	// 	'name' => 'Information Icon',
	// 	'id'   => 'pf_info_title_icon',
	// 	'type' => 'text',
	// 	'description' => __( 'Portfolio Information Icon (You can write here font-awesome icon name. Ex: fas fa-calendar-alt)', 'tp-framework' ),
	// 	// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	// ) );

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Information Title',
		'id'   => 'pf_info_title',
		'type' => 'text',
		'description' => __( 'Portfolio Information name. Ex: Budget', 'tp-framework' ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	
	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Information Value',
		'id'   => 'pf_info_value',
		'type' => 'text',
		'description' => __( 'Portfolio Information value. Ex: $30K', 'tp-framework' ),

		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

}

 
add_action( 'cmb2_admin_init', 'tp_cashback_tracker_metas' );
/**
 * Define the metabox and field configurations.
 */
function tp_cashback_tracker_metas() {

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'tp_cashback_tracker_metas',
		'title'         => __( 'Cashback Metas', 'tp-framework' ),
		'object_types'  => array( 'cbtrkr_shop', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$group_field_id = $cmb->add_field( array(
		'id'          => 'cbtrkr_metas_info',
		'type'        => 'group',
		'options'     => array(
			'group_title'       => __( 'Meta Info {#}', 'tp-framework' ), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __( 'Add Another Meta Info', 'tp-framework' ),
			'remove_button'     => __( 'Remove Meta Info', 'tp-framework' ),
			'sortable'          => true,
			// 'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'tp-framework' ), // Performs confirmation before removing group.
		),
	) );


	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	// $cmb->add_group_field( $group_field_id, array(
	// 	'name' => 'Information Icon',
	// 	'id'   => 'pf_info_title_icon',
	// 	'type' => 'text',
	// 	'description' => __( 'Portfolio Information Icon (You can write here font-awesome icon name. Ex: fas fa-calendar-alt)', 'tp-framework' ),
	// 	// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	// ) );

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Information Title',
		'id'   => 'cbtrkr_metas_title',
		'type' => 'text',
		'description' => __( 'Information name. Ex: Budget', 'tp-framework' ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	
	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Information Value',
		'id'   => 'cbtrkr_metas_value',
		'type' => 'text',
		'description' => __( 'Information value. Ex: $30K', 'tp-framework' ),

		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

}

add_action( 'cmb2_admin_init', 'tp_product_metabox' );
/**
 * Define the metabox and field configurations.
 */
function tp_product_metabox() {

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'tp_product__meta',
		'title'         => __( 'TP Metabox', 'tp-framework' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'side',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name'    => 'Product 2nd Image',
		'desc'    => 'This Image will show on the product hover on the home page if no gallery image is uploaded.',
		'id'      => 'tp_product_2nd_img',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );
	$cmb->add_field( array(
		'name' => 'Disable New Badge',
		'desc' => 'Check for only disable the new badge for this post',
		'id'   => 'disable_new_badge',
		'type' => 'checkbox',
	) );

}



add_action( 'cmb2_admin_init', 'tp_testimonial_metabox' );
/**
 * Define the metabox and field configurations.
 */
function tp_testimonial_metabox() {

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'testimonial_info_meta',
		'title'         => __( 'Testimonial Info', 'tp-framework' ),
		'object_types'  => array( 'tp-testimonials', ), // Post type
		'context'       => 'top',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name'    => 'Review Title',
		'desc'    => 'Give Your Review A Title.',
		'id'      => 'tp_review__title',
		'type'    => 'text',
		
	) );

	$cmb->add_field( array(
		'name'    => 'Author Designation',
		'desc'    => 'Your Designation.',
		'id'      => 'designation',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'             => 'Select Ratings',
		'desc'             => 'Select ratings',
		'id'               => 'ratings',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'1'   => __( '1', 'tp-framework' ),
			'1.5' => __( '1.5', 'tp-framework' ),
			'2'   => __( '2', 'tp-framework' ),
			'2.5' => __( '2.5', 'tp-framework' ),
			'3'   => __( '3', 'tp-framework' ),
			'3.5' => __( '3.5', 'tp-framework' ),
			'4'   => __( '4', 'tp-framework' ),
			'4.5' => __( '4.5', 'tp-framework' ),
			'5'   => __( '5', 'tp-framework' ),
		),
	) );


}

// services_addition_here

add_action( 'cmb2_admin_init', 'tp_register_services_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function tp_register_services_taxonomy_metabox() {

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => 'tp_service_cat_info',
		'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'service-category' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Icon', 'cmb2' ),
		'desc' => esc_html__( 'Add Service Category Icon Image', 'cmb2' ),
		'id'   => 'tp_service_cat_icon',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Icon'
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Category Image', 'cmb2' ),
		'desc' => esc_html__( 'Add Category Image', 'cmb2' ),
		'id'   => 'tp_service_cat_image',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Image'
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );		

}

// products_addition_here
add_action( 'cmb2_admin_init', 'tp_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function tp_register_taxonomy_metabox() {

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => 'tp_pcat_info',
		'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'product_cat' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Icon', 'cmb2' ),
		'desc' => esc_html__( 'Add Product Category Icon Image', 'cmb2' ),
		'id'   => 'tp_pcat_icon',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Icon'
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Category Image', 'cmb2' ),
		'desc' => esc_html__( 'Add Category Image', 'cmb2' ),
		'id'   => 'tp_pcat_image',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Image'
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );

	$cmb_term->add_field( array(
		'name'    => 'Category Grid Item Background',
		'id'      => 'pcat_grid_bg',
		'type'    => 'colorpicker',
		'options' => array(
			'alpha' => true, 
		),
		) );
		
	$cmb_term->add_field( array(
		'name'    => 'Category Grid Item Button Color',
		'id'      => 'pcat_grid_btn_color',
		'type'    => 'colorpicker',
		'desc' 	  => esc_html__( 'Try to pick a similar color like icon ', 'cmb2' ),
		'options' => array(
			'alpha' => true, 
		),
	) );		

}



