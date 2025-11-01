<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "cashora_option";

// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters('cashora/opt_name', $opt_name);

/*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    'page_priority'        => 8,
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Cashora Options', 'cashora'),
    'page_title'           => esc_html__('Cashora Options', 'cashora'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 20,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    'forced_dev_mode_off' => true,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    'compiler' => true,

    // OPTIONAL -> Give you extra features
    'page_priority'        => 20,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    'force_output' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);

// Panel Intro text -> before the form
if (!isset($args['global_variable']) || $args['global_variable'] !== false) {
    if (!empty($args['global_variable'])) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace('-', '_', $args['opt_name']);
    }
    $args['intro_text'] = sprintf(esc_html__('Cashora Theme', 'cashora'), $v);
} else {
    $args['intro_text'] = esc_html__('Cashora Theme', 'cashora');
}

Redux::setArgs($opt_name, $args);

/*
     * ---> END ARGUMENTScashora
      
     */
// -> START General Settings
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('General Settings', 'cashora'),
        'id'               => 'basic-checkbox',
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id'       => 'enable_global',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Global Settings', 'cashora'),
                'subtitle' => esc_html__('If you enable global settings all option will be work only theme option', 'cashora'),
                'default'  => true,
            ),

            array(
                'id'       => 'container_size',
                'title'    => esc_html__('Container Size', 'cashora'),
                'subtitle' => esc_html__('Container Size example(1350px)', 'cashora'),
                'type'     => 'text',
                'default'  => '1320px'
            ),

            array(
                'id'       => 'tp_favicon',
                'type'     => 'media',
                'title'    => esc_html__('Upload Favicon', 'cashora'),
                'subtitle' => esc_html__('Upload your faviocn here', 'cashora'),
                'url' => true
            ),

            array(
                'id'       => 'off_sticky',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Sticky Menu', 'cashora'),
                'subtitle' => esc_html__('You can show or hide sticky menu here', 'cashora'),
                'default'  => false,
            ),  
            array(
                'id'       => 'show_top_bottom',
                'type'     => 'switch', 
                'title'    => esc_html__('Scroll to Top', 'cashora'),
                'subtitle' => esc_html__('You can show or hide here', 'cashora'),
                'default'  => false,
            ),         
        )
    )
);


//Preloader settings
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Preloader Style', 'cashora'),
        'desc'   => esc_html__('Preloader Style Here', 'cashora'),
        'fields' => array(
            array(
                'id'       => 'show_preloader',
                'type'     => 'switch',
                'title'    => esc_html__('Show Preloader', 'cashora'),
                'subtitle' => esc_html__('You can show or hide preloader', 'cashora'),
                'default'  => false,
            ),

            array(
                'id'        => 'preloader_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Preloader Background Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#212121',
                'validate'  => 'color',
            ),
           

            array(
                'id'        => 'preloader_animate_color2',
                'type'      => 'color',
                'title'     => esc_html__('Preloader Circle Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#A58EFF',
                'validate'  => 'color',
                'output'    => array('background' => '.lds-ellipsis div')
            ),

          
            array(
                'id'    => 'preloader_img',
                'url'   => true,
                'title' => esc_html__('Preloader Image', 'cashora'),
                'type'  => 'media',
            ),
        )
    )
);
//End Preloader settings 

// -> START Style Section
Redux::setSection($opt_name, array(
    'title'            => esc_html__('Style', 'cashora'),
    'id'               => 'stle',
    'customizer_width' => '450px',
    'icon' => 'el el-brush',
));

Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Global Style', 'cashora'),
        'desc'   => esc_html__('Style your theme', 'cashora'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'        => 'body_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Body Backgroud Color', 'cashora'),
                'subtitle'  => esc_html__('Pick body background color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'body_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Text Color', 'cashora'),
                'subtitle'  => esc_html__('Pick text color', 'cashora'),
                'default'   => '#666666',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'primary_color',
                'type'      => 'color',
                'title'     => esc_html__('Primary Color', 'cashora'),
                'subtitle'  => esc_html__('Select Primary Color.', 'cashora'),
                'default'   => '#107658',
                'validate'  => 'color',
                'output'      => array('.pixelaxis-heading .title-inner .sub-text,  .menu-area .navbar ul li:hover a'),
            ),

            array(
                'id'        => 'secondary_color',
                'type'      => 'color',
                'title'     => esc_html__('Secondary Color', 'cashora'),
                'subtitle'  => esc_html__('Select Secondary Color.', 'cashora'),
                'default'   => '#00100B',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'link_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Link Color', 'cashora'),
                'subtitle'  => esc_html__('Pick Link color', 'cashora'),
                'default'   => '#666666',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'link_hover_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Link Hover Color', 'cashora'),
                'subtitle'  => esc_html__('Pick link hover color', 'cashora'),
                'default'   => '#00100B',
                'validate'  => 'color',
            ),

        )
    )
);


//Button settings
Redux::setSection(
    $opt_name,
    array(
        'title'      => esc_html__('Button Style', 'cashora'),
        'desc'       => esc_html__('Button Style Here', 'cashora'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'        => 'btn_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Background Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#107658',
                'validate'  => 'color',
                'output'    => array('background-color' => '.pixelaxis-button a')
            ),

            array(
                'id'        => 'btn_bg_hover',
                'type'      => 'color',
                'title'     => esc_html__('Hover Background', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#00100B',
                'validate'  => 'color',
                'output'    => array('background' => '.pixelaxis-button a:hover::before')

            ),          

            array(
                'id'        => 'btn_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Text Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.pixelaxis-button a')
            ),

            array(
                'id'        => 'btn_txt_hover_color',
                'type'      => 'color',
                'title'     => esc_html__('Hover Text Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.pixelaxis-button a:hover')
            ),

            array(
                'id'     => 'notice_critical',
                'type'   => 'info',
                'notice' => true,
                'style'  => 'success',
                'title'  => esc_html__('Seconday Button Style', 'cashora')            
            ),
            array(
                'id'        => 'btn2_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Background Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#00100B',
                'validate'  => 'color',
                'output'    => array('background-color' => '.pixelaxis-button.secondary_btn a')
            ),

            array(
                'id'        => 'btn2_bg_hover',
                'type'      => 'color',
                'title'     => esc_html__('Hover Background', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#107658',
                'validate'  => 'color',
                'output'    => array('background' => '.pixelaxis-button.secondary_btn a:after')

            ),
            
            array(
                'id'        => 'btn2_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Text Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.pixelaxis-button.secondary_btn a')
            ),

            array(
                'id'        => 'btn2_txt_hover_color',
                'type'      => 'color',
                'title'     => esc_html__('Hover Text Color', 'cashora'),
                'subtitle'  => esc_html__('Pick color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.pixelaxis-button.secondary_btn a:after')
            ),
        )
    )
);

//Breadcrumb settings
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Breadcrumb Style', 'deala'),
        'desc'       => esc_html__('Breadcrumb Style Your Theme', 'deala'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'       => 'breadcrumb_style_notice',
                'type'     => 'info',
                'style'    => 'warning',
                'title'    => esc_html__('Notice', 'deala'),
                'desc'     => sprintf(
                    esc_html__('Please enable %s switch to use these options', 'deala'),
                    '<strong> <i>' . esc_html__('General Settings > Enable Global Style Settings', 'deala') . '</i></strong>'
                ),
                'hidden'   => function ($value) {
                    global $cashora_option;
                    return ($cashora_option['enable_global'] == true);
                }
            ),

            array(
                'id'       => 'off_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Show off Breadcrumb', 'deala'),
                'subtitle' => esc_html__('You can show or hide off breadcrumb here', 'deala'),
                'default'  => true,
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'      => 'align_breadcrumb',
                'type'    => 'select',
                'title'    => esc_html__('Breadcrumb Alignment', 'deala'),
                'default'  => 'start',
                'options' => array(
                    'start' => __('Left', 'deala'),
                    'center'   => __('Center', 'deala'),
                    'end'     => __('Right', 'deala'),
                ),
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'breadcrumb_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Background Bg Color', 'deala'),
                'subtitle'  => esc_html__('Pick color', 'deala'),
                'default'   => '#F5F6F7',
                'validate'  => 'color',
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'       => 'page_banner_main',
                'type'     => 'media',
                'title'    => esc_html__('Background Banner', 'deala'),
                'subtitle' => esc_html__('Upload your banner', 'deala'),
                // 'default' => [
                //     'url' => get_template_directory_uri() . '/assets/images/breadcrum_bg.png',
                // ],
                'url'      => true, // Allow URL upload
                'preview'  => true, // Enable preview of the image
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'breadcrumb_top_padding',
                'type'      => 'text',
                'title'     => esc_html__('Padding Top', 'deala'),
                'desc'    => esc_html__('Type ex: 20px', 'deala'),
                'placeholder'      => esc_html__('20px', 'deala'),
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'breadcrumb_bottom_padding',
                'type'      => 'text',
                'title'     => esc_html__('Padding Bottom', 'deala'),
                'desc'    => esc_html__('Type ex: 20px', 'deala'),
                'placeholder'      => esc_html__('20px', 'deala'),
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'breadcrumb_position',
                'type'      => 'text',
                'title'     => esc_html__('Top Postion', 'deala'),
                'placeholder'      => esc_html__('Type ex: 0px', 'deala'),
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'       => 'enable_breadcrumb_title',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Breadcrumb Title ?', 'deala'),
                'subtitle' => esc_html__('You can show or hide off breadcrumb title', 'deala'),
                'default'  => false,
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'page_title_color',
                'type'      => 'color',
                'title'     => esc_html__('Banner Title Color', 'deala'),
                'subtitle'  => esc_html__('Pick color', 'deala'),
                'default'   => '#222E48',
                'validate'  => 'color',
                'required'         => array(
                    array('enable_global', '=', '1'),
                    array('enable_breadcrumb_title', '=', '1'),
                ),
            ),

            array(
                'id'          => 'page_title_typography',
                'type'        => 'typography',
                'title'       => __('Banner Title Typography', 'deala'),
                'units'       => 'px',
                'subtitle'    => __('Typography option with each property can be called individually.', 'deala'),
                'required'         => array(
                    array('enable_global', '=', '1'),
                    array('enable_breadcrumb_title', '=', '1'),
                ),
            ),

            array(
                'id'          => 'page_breadcrumbs_color',
                'type'        => 'typography',
                'title'       => __('Banner Breadcrumbs Typography', 'deala'),
                'units'       => 'px',
                'subtitle'    => __('Typography option with each property can be called individually.', 'deala'),
                'required'         => array('enable_global', '=', '1'),
            ),

            array(
                'id'        => 'page_breadcrumbs_current_color',
                'type'      => 'color',
                'title'       => __('Banner Breadcrumbs Current Color', 'deala'),
                'subtitle'  => esc_html__('Pick color', 'deala'),
                'default'   => '#0B453C',
                'required'         => array('enable_global', '=', '1'),
            ),


        )
    )
);


//-> START Typography
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Typography', 'cashora'),
        'id'     => 'typography',
        'desc'   => esc_html__('You can specify your body and heading font here', 'cashora'),
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'opt-typography-body',
                'type'     => 'typography',
                'title'    => esc_html__('Body Font', 'cashora'),
                'subtitle' => esc_html__('Specify the body font properties.', 'cashora'),
                'google'   => true,
                'font-style' => false,
                'default'  => array(
                    'font-size'   => '16px',
                    'font-weight' => '400',
                ),
            ),
            array(
                'id'       => 'opt-typography-menu',
                'type'     => 'typography',
                'title'    => esc_html__('Navigation Font', 'cashora'),
                'subtitle' => esc_html__('Specify the menu font properties.', 'cashora'),
                'google'   => true,
                'font-backup' => true,
                'all_styles'  => true,
                'default'  => array(
                    'color'       => '',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '15px',
                    'font-weight' => '500',
                ),
            ),
            array(
                'id'          => 'opt-typography-h1',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H1', 'cashora'),
                'font-backup' => true,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '48px',
                    'line-height' => ''

                ),
            ),
            array(
                'id'          => 'opt-typography-h2',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H2', 'cashora'),
                'font-backup' => true,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '38px',
                    'line-height' => ''

                ),
            ),
            array(
                'id'          => 'opt-typography-h3',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H3', 'cashora'),
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '28px',
                    'line-height' => ''

                ),
            ),
            array(
                'id'          => 'opt-typography-h4',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H4', 'cashora'),
                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '22px',
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'opt-typography-h5',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H5', 'cashora'),
                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'opt-typography-6',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H6', 'cashora'),

                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'cashora'),
                'default'     => array(
                    'color'       => '#090908',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '16px',
                    'line-height' => ''
                ),
            ),

        )
    )

);

if (class_exists('WooCommerce')) {
    Redux::setSection(
        $opt_name,
        array(
            'title'  => esc_html__('Woocommerce', 'cashora'),
            'icon'   => 'el el-shopping-cart',
        )
    );

    Redux::setSection(
        $opt_name,
        array(
            'title'            => esc_html__('Shop', 'cashora'),
            'id'               => 'shop_layout',
            'customizer_width' => '450px',
            'subsection' => true,
            'fields'           => array(
                array(
                    'id'       => 'shop_banner',
                    'url'      => true,
                    'title'    => esc_html__('Shop page banner', 'cashora'),
                    'type'     => 'media',
                ),
                array(
                    'id'       => 'shop-long-title',
                    'url'      => true,
                    'title'    => esc_html__('Shop Long Title', 'cashora'),
                    'type'     => 'text',
                ),
                array(
                    'id'       => 'shop-layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Select Shop Layout', 'cashora'),
                    'subtitle' => esc_html__('Select your shop layout', 'cashora'),
                    'options'  => array(
                        'full'      => array(
                            'alt'   => esc_html__('Shop Style 1', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/1c.png'
                        ),
                        'right-col' => array(
                            'alt'   => esc_html__('Shop Style 2', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/2cr.png'
                        ),
                        'left-col'  => array(
                            'alt'   => esc_html__('Shop Style 3', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/2cl.png'
                        ),
                    ),
                    'default' => 'full'
                ),

                array(
                    'id'       => 'wc_num_product',
                    'type'     => 'text',
                    'title'    => esc_html__('Number of Products Per Page', 'cashora'),
                    'default'  => '9',
                ),

                array(
                    'id'       => 'wc_num_product_per_row',
                    'type'     => 'text',
                    'title'    => esc_html__('Number of Products Per Row', 'cashora'),
                    'default'  => '3',
                ),

                array(
                    'id'       => 'wc_cart_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__('Cart Icon Show At Menu Area', 'cashora'),
                    'on'       => esc_html__('Enabled', 'cashora'),
                    'off'      => esc_html__('Disabled', 'cashora'),
                    'default'  => false,
                ),

                array(
                    'id'       => 'disable-sidebar',
                    'type'     => 'switch',
                    'title'    => esc_html__('Sidebar Disable For Single Product Page', 'cashora'),
                    'default'  => true,
                ),

                array(
                    'id'       => 'wc_wishlist_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__('Show Wishlist Icon', 'cashora'),
                    'on'       => esc_html__('Enabled', 'cashora'),
                    'off'      => esc_html__('Disabled', 'cashora'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'wc_quickview_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__('Product Quickview Icon', 'cashora'),
                    'on'       => esc_html__('Enabled', 'cashora'),
                    'off'      => esc_html__('Disabled', 'cashora'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'wc_show_new',
                    'type'     => 'switch',
                    'title'    => esc_html__('Show Product New Badge', 'cashora'),
                    'on'       => esc_html__('Enabled', 'cashora'),
                    'off'      => esc_html__('Disabled', 'cashora'),
                    'default'  => true,
                ),

                array(
                    'id'       => 'wc_new_product_days',
                    'type'     => 'select',
                    'title'    => esc_html__('New Days', 'cashora'),
                    'desc'     => esc_html__('Select last day, when uploaded products will show a new badge.', 'cashora'),
                    'options'  => array(
                        '7'     => esc_html__('7 Days', 'cashora'),
                        '10' => esc_html__('10 Days', 'cashora'),
                        '15' => esc_html__('15 Days', 'cashora'),
                        '30' => esc_html__('30 Days', 'cashora'),
                    ),
                    'default'  => '15',

                ),



            )
        )
    );
    Redux::setSection(
        $opt_name,
        array(
            'title'            => esc_html__('Shop Single', 'cashora'),
            'id'               => 'shop_single',
            'customizer_width' => '450px',
            'subsection' => true,
            'fields'           => array(

                array(
                    'id'       => 'single-gallery-layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Single Product Gallery Layout', 'cashora'),
                    'subtitle' => esc_html__('Select single page gallery layout', 'cashora'),
                    'options'  => array(
                        'default-thumb'      => array(
                            'alt'   => esc_html__('Style 1', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/1c.png'
                        ),
                        'right-thumb' => array(
                            'alt'   => esc_html__('Style 2', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/2cr.png'
                        ),
                        'left-thumb'  => array(
                            'alt'   => esc_html__('Style 3', 'cashora'),
                            'img'   => get_template_directory_uri() . '/libs/img/2cl.png'
                        ),
                    ),
                    'default' => 'default-thumb'
                ),

                array(
                    'id'       => 'single_releted_products',
                    'type'     => 'text',
                    'title'    => esc_html__('Number of Releted Products in Product detail Page', 'cashora'),
                    'default'  => '4',
                ),
                array(
                    'id'       => 'single_releted_products_col',
                    'type'     => 'text',
                    'title'    => esc_html__('Coloumn Number of Releted Products in Product detail Page', 'cashora'),
                    'default'  => '4',
                ),

            )
        )
    );
}

/*Blog Sections*/
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Blog', 'cashora'),
        'id'               => 'blog',
        'customizer_width' => '450px',
        'icon' => 'el el-comment',
    )
);

Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Blog Settings', 'cashora'),
        'id'               => 'blog-settings',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'    => 'blog_banner_main',
                'url'   => true,
                'title' => esc_html__('Blog Page Banner', 'cashora'),
                'type'  => 'media',
            ),

            array(
                'id'        => 'blog_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Body Backgroud Color', 'cashora'),
                'subtitle'  => esc_html__('Pick body background color', 'cashora'),
                'default'   => '#ffffff',
                'validate'  => 'color',
            ),

            array(
                'id'       => 'blog_title',
                'title'    => esc_html__('Blog  Title', 'cashora'),
                'subtitle' => esc_html__('Enter Blog  Title Here', 'cashora'),
                'type'     => 'text',
            ),

            array(
                'id'       => 'blog_long_title',
                'title'    => esc_html__('Blog  Long Title', 'cashora'),
                'subtitle' => esc_html__('Enter Blog  Long Title Here', 'cashora'),
                'type'     => 'text',
            ),

            array(
                'id'               => 'blog-layout',
                'type'             => 'image_select',
                'title'            => esc_html__('Select Blog Layout', 'cashora'),
                'subtitle'         => esc_html__('Select your blog layout', 'cashora'),
                'options'          => array(
                    'full'             => array(
                        'alt'              => esc_html__('Blog Style 1', 'cashora'),
                        'img'              => get_template_directory_uri() . '/libs/img/1c.png'
                    ),
                    '2right'           => array(
                        'alt'              => esc_html__('Blog Style 2', 'cashora'),
                        'img'              => get_template_directory_uri() . '/libs/img/2cr.png'
                    ),
                    '2left'            => array(
                        'alt'              => esc_html__('Blog Style 3', 'cashora'),
                        'img'              => get_template_directory_uri() . '/libs/img/2cl.png'
                    ),
                ),
                'default'          => '2right'
            ),

            array(
                'id'               => 'blog-grid',
                'type'             => 'select',
                'title'            => esc_html__('Select Blog Gird', 'cashora'),
                'desc'             => esc_html__('Select your blog gird layout', 'cashora'),
                'options'          => array(
                    '12'               => esc_html__('1 Column', 'cashora'),
                    '6'                => esc_html__('2 Column', 'cashora'),
                    '4'                => esc_html__('3 Column', 'cashora'),
                    '3'                => esc_html__('4 Column', 'cashora'),
                ),
                'default'          => '12',
            ),

            array(
                'id'               => 'blog-author-post',
                'type'             => 'select',
                'title'            => esc_html__('Show Author Info ', 'cashora'),
                'desc'             => esc_html__('Select author info show or hide', 'cashora'),
                'options'          => array(
                    'show'             => esc_html__('Show', 'cashora'),
                    'hide'             => esc_html__('Hide', 'cashora'),
                ),
                'default'          => 'show',

            ),

            array(
                'id'               => 'blog-category',
                'type'             => 'select',
                'title'            => esc_html__('Show Category', 'cashora'),
                'options'          => array(
                    'show'             => esc_html__('Show', 'cashora'),
                    'hide'             => esc_html__('Hide', 'cashora'),
                ),
                'default'          => 'show',

            ),

            array(
                'id'               => 'blog-date',
                'type'             => 'switch',
                'title'            => esc_html__('Show Date', 'cashora'),
                'desc'             => esc_html__('You can show/hide date at blog page', 'cashora'),
                'default'          => true,
            ),
            array(
                'id'               => 'blog_readmore',
                'title'            => esc_html__('Blog Read More Text', 'cashora'),
                'subtitle'         => esc_html__('Enter Blog Read More Here', 'cashora'),
                'type'             => 'text',
                'default'          => esc_html__('Read More', 'cashora'),
            ),

        )
    )

);

/*Single Post Sections*/
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Single Post', 'cashora'),
        'id'               => 'spost',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id'       => 'single_blog_title',
                'title'    => esc_html__('Single Blog  Title', 'cashora'),
                'subtitle' => esc_html__('Enter Title Here', 'cashora'),
                'type'     => 'text',
            ),
            array(
                'id'       => 'blog_banner',
                'url'      => true,
                'title'    => esc_html__('Blog Single page banner', 'cashora'),
                'type'     => 'media',

            ),

            array(
                'id'       => 'blog-comments',
                'type'     => 'select',
                'title'    => esc_html__('Show Comment Form', 'cashora'),
                'desc'     => esc_html__('Select comments show or hide', 'cashora'),
                'options'  => array(
                    'show' => esc_html__('Show', 'cashora'),
                    'hide' => esc_html__('Hide', 'cashora'),
                ),
                'default'  => 'show',

            ),

            array(
                'id'       => 'blog-author-meta',
                'type'     => 'select',
                'title'    => esc_html__('Show Meta Info', 'cashora'),
                'desc'     => esc_html__('Select meta info show or hide', 'cashora'),
                'options'  => array(
                    'show' => esc_html__('Show', 'cashora'),
                    'hide' => esc_html__('Hide', 'cashora'),
                ),
                'default'  => 'show',

            ),

        )
    )


);


Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('404 Error Page', 'cashora'),
        'desc'   => esc_html__('404 details  here', 'cashora'),
        'icon'   => 'el el-error-alt',
        'fields' => array(

            array(
                'id'       => 'title_404',
                'type'     => 'text',
                'title'    => esc_html__('Title', 'cashora'),
                'subtitle' => esc_html__('Enter title for 404 page', 'cashora'),
                'default'  => esc_html__('404', 'cashora')
            ),
            array(
                'id'       => 'text_404',
                'type'     => 'text',
                'title'    => esc_html__('Text', 'cashora'),
                'subtitle' => esc_html__('Enter text for 404 page', 'cashora'),
                'default'  => esc_html__('Page Not Found', 'cashora')
            ),
            array(
                'id'       => 'back_home',
                'type'     => 'text',
                'title'    => esc_html__('Back to Home Button Label', 'cashora'),
                'subtitle' => esc_html__('Enter label for "Back to Home" button', 'cashora'),
                'default'  => esc_html__('Back to Home', 'cashora')

            ),
            array(
                'id'       => '404_bg',
                'type'     => 'media',
                'title'    => esc_html__('404 page Image', 'cashora'),
                'subtitle' => esc_html__('Upload your image', 'cashora'),
                'url' => true
            ),


        )
    )
);

if (!function_exists('compiler_action')) {
    function compiler_action($options, $css, $changed_values)
    {
        echo '<h1>The compiler hook has run!</h1>';
        echo "<pre>";
        print_r($changed_values); // Values that have changed since the last save
        echo "</pre>";
    }
}

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')) {
    function redux_validate_callback_function($field, $value, $existing_value)
    {
        $error   = false;
        $warning = false;

        //do your validation
        if ($value == 1) {
            $error = true;
            $value = $existing_value;
        } elseif ($value == 2) {
            $warning = true;
            $value   = $existing_value;
        }

        $return['value'] = $value;

        if ($error == true) {
            $field['msg']    = 'your custom error message';
            $return['error'] = $field;
        }

        if ($warning == true) {
            $field['msg']      = 'your custom warning message';
            $return['warning'] = $field;
        }

        return $return;
    }
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')) {
    function redux_my_custom_field($field, $value)
    {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
}

/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.     
 * */
if (!function_exists('dynamic_section')) {
    function dynamic_section($sections)
    {
        $sections[] = array(
            'title'  => esc_html__('Section via hook', 'cashora'),
            'desc'   => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'cashora'),
            'icon'   => 'el el-paper-clip',
            'fields' => array()
        );
        return $sections;
    }
}

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if (!function_exists('change_arguments')) {
    function change_arguments($args)
    {
        return $args;
    }
}

/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
if (!function_exists('change_defaults')) {
    function change_defaults($defaults)
    {
        $defaults['str_replace'] = 'Testing filter hook!';
        return $defaults;
    }
}

/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if (!function_exists('remove_demo')) {
    function remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_action('plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2);
            remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
        }
    }
}
