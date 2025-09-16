<?php

class TP_Elements_Addon_Control {

    private $tpelements_options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'tpelements_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'tpelements_page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'tpelements_admin_scripts' ) );
        register_activation_hook( TPELEMENTS_FILE, [$this,'tpelements_plugin_activate'] );      
        
    }

    public function tpelements_admin_scripts(){
        wp_register_style('tpelements-admin-styles', TPELEMENTS_DIR_URL_PRO . 'widget-option/assets/css/tpelements-admin.css', array(), null );
        wp_enqueue_style('tpelements-admin-styles');
    }


    public function tpelements_add_plugin_page() {
        add_menu_page(
            'TP Elements Setting',
            'TP Elements',
            'manage_options',
            'tpelements-addon-settings',
            array( $this, 'tpelements_create_admin_page' ),
            'dashicons-superhero',
            6
        );
    }

    /**
     *
     */
    public function tpelements_create_admin_page() {
        $this->tpelements_options = get_option( 'tpelements_addon_option' );
        ?>
        <div class="wrap">
            <form class="tpelements-form" method="post" action="options.php">
                <?php
                settings_fields( 'tpelements_addon_group' );
                do_settings_sections( 'tpelements-addon-field' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function tpelements_page_init(){

        /**
         * Sanitize callback
         */
        register_setting(
            'tpelements_addon_group',
            'tpelements_addon_option',
            array( $this, 'tpelements_sanitize' )
        );

        

        add_settings_section(
            'tpelements_section_field_id',
            esc_html__( 'Disable Elements for better performance', 'tp-elements' ),
            array( $this, 'tpelements_section_info' ),
            'tpelements-addon-field'
        );

       
        /**
         * Heading addon control
         */
        add_settings_field(
            'tp_heading',
            esc_html__( 'TP Heading', 'tp-elements' ),
            array( $this, 'tp_elements_heading_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Animated heading control
         */
        add_settings_field(
            'tp_animated_heading',
            esc_html__( 'TP Animated Heading', 'tp-elements' ),
            array( $this, 'tpelements_animated_heading_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
        * Blockquote Control
        */
        add_settings_field(
            'tp_blockquote',
            esc_html__( 'TP Blockquote', 'tp-elements' ),
            array( $this, 'tpelements_blockquote_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * About Image Control
         */
        add_settings_field(
            'tp_about_iamge',
            esc_html__( 'TP About Image', 'tp-elements' ),
            array( $this, 'tpelements_about_image' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Image Showcase
         */
        add_settings_field(
            'tp_image_showcase',
            esc_html__( 'TP Image Showcase', 'tp-elements' ),
            array( $this, 'tpelements_image_showcase_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Team Grid control
         */
        add_settings_field(
            'tp_team_gread',
            esc_html__( 'TP Team Grid', 'tp-elements' ),
            array( $this, 'tpelements_team_gread_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Full Width Slider control
         */
        add_settings_field(
            'tp_team_slider',
            esc_html__( 'TP Team Slider', 'tp-elements' ),
            array( $this, 'tpelements_team_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );


        /**
         * Full Width Slider ( Masum did not find )
         */
        add_settings_field(
            'tp_full_width_slider',
            esc_html__( 'TP Full Width Slider Masum', 'tp-elements' ),
            array( $this, 'tpelements_full_width_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        
        /**
         * Portfolio Grid
         */
        add_settings_field(
            'tp_portfolio_grid',
            esc_html__( 'TP Portfolio Grid', 'tp-elements' ),
            array( $this, 'tpelements_portfolio_grid_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
       
        /**
         * Portfolio Slider
         */
        add_settings_field(
            'tp_portfolio_slider',
            esc_html__( 'TP Portfolio Slider', 'tp-elements' ),
            array( $this, 'tpelements_portfolio_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Counter
         */
        add_settings_field(
            'tp_counter',
            esc_html__( 'TP Counter', 'tp-elements' ),
            array( $this, 'tpelements_counter_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Services Grid
         */
        add_settings_field(
            'tp_service_grid',
            esc_html__( 'TP Services Grid', 'tp-elements' ),
            array( $this, 'tpelements_service_grid_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Services Slider
         */
        add_settings_field(
            'tp_service_slider',
            esc_html__( 'TP Services Slider', 'tp-elements' ),
            array( $this, 'tpelements_service_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Video
         */
        add_settings_field(
            'tp_video',
            esc_html__( 'TP Video', 'tp-elements' ),
            array( $this, 'tpelements_video_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Pricing Table
         */
        add_settings_field(
            'tp_pricing_table',
            esc_html__( 'TP Pricing Table', 'tp-elements' ),
            array( $this, 'tpelements_pricing_table_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
       
        /**
         * Button
         */
        add_settings_field(
            'tp_button',
            esc_html__( 'TP Button', 'tp-elements' ),
            array( $this, 'tpelements_button_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Logo Showcase
         */
        add_settings_field(
            'tp_logo_showcase',
            esc_html__( 'TP Logo Showcase', 'tp-elements' ),
            array( $this, 'tpelements_logo_showcase_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * CTA
         */
        add_settings_field(
            'tp_cta',
            esc_html__( 'TP CTA', 'tp-elements' ),
            array( $this, 'tpelements_cta_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        
        /**
         * Testimonial Slider
         */
        add_settings_field(
            'tp_testimonial_slider',
            esc_html__( 'TP Testimonial Slider', 'tp-elements' ),
            array( $this, 'tpelements_testimonial_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
       
        /**
         * Flip Box ( Masum did not find )
         */
        add_settings_field(
            'tp_flip_box',
            esc_html__( 'TP Flip Box Masum', 'tp-elements' ),
            array( $this, 'tpelements_flip_box_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Tab
         */
        add_settings_field(
            'tp_tab',
            esc_html__( 'TP Tab', 'tp-elements' ),
            array( $this, 'tpelements_tab_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Advance Tab
         */
        add_settings_field(
            'tp_advance_tab',
            esc_html__( 'TP Advance Tab', 'tp-elements' ),
            array( $this, 'tpelements_advance_tab_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Icon Box
         */
        add_settings_field(
            'tp_icon_box',
            esc_html__( 'TP Icon Box', 'tp-elements' ),
            array( $this, 'tpelements_icon_box_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Blog Grid
         */
        add_settings_field(
            'tp_blog_grid',
            esc_html__( 'TP Blog Grid', 'tp-elements' ),
            array( $this, 'tpelements_blog_grid_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Blog Slider
         */
        add_settings_field(
            'tp_blog_slider',
            esc_html__( 'TP Blog Slider', 'tp-elements' ),
            array( $this, 'tpelements_blog_slider_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Number Grid
         */
        add_settings_field(
            'tp_number_grid',
            esc_html__( 'TP Number Grid', 'tp-elements' ),
            array( $this, 'tpelements_number_grid_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Contact Form 7
         */
        add_settings_field(
            'tp_contact_form_7',
            esc_html__( 'TP Contact Form 7', 'tp-elements' ),
            array( $this, 'tpelements_contact_form_7_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Progress Bar
         */
        add_settings_field(
            'tp_progress_bar',
            esc_html__( 'TP Progress Bar', 'tp-elements' ),
            array( $this, 'tpelements_progress_bar_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Iconbox Top
         */
        add_settings_field(
            'tp_iconbox_bar',
            esc_html__( 'TP Iconbox Top', 'tp-elements' ),
            array( $this, 'tpelements_icon_bar_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Iconbox List
         */
        add_settings_field(
            'tp_contactbox_icon',
            esc_html__( 'TP Iconbox List', 'tp-elements' ),
            array( $this, 'tpelements_contactbox_icon_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Iconbox List
         */
        add_settings_field(
            'tp_real_contactbox',
            esc_html__( 'TP Contact Box Masum', 'tp-elements' ),
            array( $this, 'tpelements_real_contactbox_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        
        /**
         * Progress Pie
         */
        add_settings_field(
            'tp_progress_pie',
            esc_html__( 'TP Progress Pie', 'tp-elements' ),
            array( $this, 'tpelements_progress_pie_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );


        /**
         * Countdown
         */
        add_settings_field(
            'tp_countdown_box',
            esc_html__( 'TP Countdown', 'tp-elements' ),
            array( $this, 'tpelements_countdown_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

         /**
         * Business Hour 
         */
        add_settings_field(
            'tp_business_hour_box',
            esc_html__( 'TP Business Hour', 'tp-elements' ),
            array( $this, 'tpelements_business_hour_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Tooltip
         */
        add_settings_field(
            'tp_tooltip',
            esc_html__( 'TP Tooltip', 'tp-elements' ),
            array( $this, 'tpelements_tooltip_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
       
        /**
         * FAQ ( Masum did not find )
         */
        add_settings_field(
            'tp_faq',
            esc_html__( 'TP FAQ Masum', 'tp-elements' ),
            array( $this, 'tpelements_faq_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
       
        /**
         * Image Hover Effect
         */
        add_settings_field(
            'tp_image_hover_effect',
            esc_html__( 'TP Image Hover Effect', 'tp-elements' ),
            array( $this, 'tpelements_image_hover_effect_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Features List
         */
        add_settings_field(
            'tp_features_list',
            esc_html__( 'TP Features List', 'tp-elements' ),
            array( $this, 'tpelements_features_list_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
      
       
        /**
         * Accordion
         */
        add_settings_field(
            'tp_accordion',
            esc_html__( 'TP Accordion', 'tp-elements' ),
            array( $this, 'tpelements_accordion_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Newsletter
         */
        add_settings_field(
            'tp_newsletter',
            esc_html__( 'TP MC4WP', 'tp-elements' ),
            array( $this, 'tpelements_newsletter_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        
        /**
         * Image Card
         */
        add_settings_field(
            'tp_image_card',
            esc_html__( 'TP Image Card', 'tp-elements' ),
            array( $this, 'tpelements_image_card_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Marquee
         */
        add_settings_field(
            'tp_marquee',
            esc_html__( 'TP Marquee', 'tp-elements' ),
            array( $this, 'tpelements_marquee_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Line Draw
         */
        add_settings_field(
            'tp_linedraw',
            esc_html__( 'TP Line Draw', 'tp-elements' ),
            array( $this, 'tpelements_linedraw_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Client Thumb
         */
        add_settings_field(
            'tp_client_thumb',
            esc_html__( 'TP Client Thumb Masum', 'tp-elements' ),
            array( $this, 'tpelements_client_thumb_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Timeline
         */
        add_settings_field(
            'tp_timeline',
            esc_html__( 'TP Timeline', 'tp-elements' ),
            array( $this, 'tpelements_timeline_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * History
         */
        add_settings_field(
            'tp_history',
            esc_html__( 'TP History Masum', 'tp-elements' ),
            array( $this, 'tpelements_history_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Portfolio Featurelist
         */
        add_settings_field(
            'tp_portfolio_featurelist',
            esc_html__( 'TP Portfolio Features', 'tp-elements' ),
            array( $this, 'tpelements_portfolio_featurelist_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Featured Image
         */
        add_settings_field(
            'tp_featured_image',
            esc_html__( 'TP Single Featured Image', 'tp-elements' ),
            array( $this, 'tpelements_featured_image_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Site Logo
         */
        add_settings_field(
            'tp_site_logo',
            esc_html__( 'TP Site Logo', 'tp-elements' ),
            array( $this, 'tpelements_site_logo_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Site Search
         */
        add_settings_field(
            'tp_site_search',
            esc_html__( 'TP Search', 'tp-elements' ),
            array( $this, 'tpelements_site_search_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Site Canvas
         */
        add_settings_field(
            'tp_site_canvas',
            esc_html__( 'OffCanvas Hamburger', 'tp-elements' ),
            array( $this, 'tpelements_site_canvas_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Site Navigation
         */
        add_settings_field(
            'tp_site_navigation',
            esc_html__( 'Navigation Menu', 'tp-elements' ),
            array( $this, 'tpelements_site_navigation_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );
        /**
         * Scroll To Top
         */
        add_settings_field(
            'tp_scroll_to_top',
            esc_html__( 'TP Scroll To Top', 'tp-elements' ),
            array( $this, 'tpelements_scroll_to_top_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Single Navigation
         */
        add_settings_field(
            'tp_single_navigation',
            esc_html__( 'Single Page Navigation', 'tp-elements' ),
            array( $this, 'tpelements_single_navigation_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Copyright
         */
        add_settings_field(
            'tp_copyright',
            esc_html__( 'TP Copyright', 'tp-elements' ),
            array( $this, 'tpelements_copyright_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );

        /**
         * Cart
         */
        add_settings_field(
            'tp_cart',
            esc_html__( 'TP Woo Cart', 'tp-elements' ),
            array( $this, 'tpelements_cart_setting' ),
            'tpelements-addon-field',
            'tpelements_section_field_id',
            array( 'class' => 'tpselements_addon_field' )
        );





    }

    /**
     * Sanitize all form
     */
    public function tpelements_sanitize( $input_addon ) {
        $rt_addon_arg = array();

        //Heading
        if( isset( $input_addon['tp_heading_setting'] ) ){
            $rt_addon_arg['tp_heading_setting'] = sanitize_text_field( $input_addon['tp_heading_setting'] );
        }

        //Heading
        if( isset( $input_addon['tp_animated_heading_setting'] ) ){
            $rt_addon_arg['tp_animated_heading_setting'] = sanitize_text_field( $input_addon['tp_animated_heading_setting'] );
        }
        //Blockquote
        if( isset( $input_addon['tp_blockquote_setting'] ) ){
            $rt_addon_arg['tp_blockquote_setting'] = sanitize_text_field( $input_addon['tp_blockquote_setting'] );
        }
        //About Image
        if( isset( $input_addon['tp_about_image_setting'] ) ){
            $rt_addon_arg['tp_about_image_setting'] = sanitize_text_field( $input_addon['tp_about_image_setting'] );
        }
        //Team Grid
        if( isset( $input_addon['tp_team_grid_setting'] ) ){
            $rt_addon_arg['tp_team_grid_setting'] = sanitize_text_field( $input_addon['tp_team_grid_setting'] );
        }
        //Full Width Slider
        if( isset( $input_addon['tp_full_width_slider_setting'] ) ){
            $rt_addon_arg['tp_full_width_slider_setting'] = sanitize_text_field( $input_addon['tp_full_width_slider_setting'] );
        }
        //Team Slider
        if( isset( $input_addon['tp_team_slider_setting'] ) ){
            $rt_addon_arg['tp_team_slider_setting'] = sanitize_text_field( $input_addon['tp_team_slider_setting'] );
        }
        //Portfolio Grid 
        if( isset( $input_addon['tp_portfolio_grid_setting'] ) ){
            $rt_addon_arg['tp_portfolio_grid_setting'] = sanitize_text_field( $input_addon['tp_portfolio_grid_setting'] );
        }

        //Portfolio Slider 
        if( isset( $input_addon['tp_portfolio_slider_setting'] ) ){
            $rt_addon_arg['tp_portfolio_slider_setting'] = sanitize_text_field( $input_addon['tp_portfolio_slider_setting'] );
        }
        //Counter 
        if( isset( $input_addon['tp_counter_setting'] ) ){
            $rt_addon_arg['tp_counter_setting'] = sanitize_text_field( $input_addon['tp_counter_setting'] );
        }

         //Counter 
         if( isset( $input_addon['tp_countdown_setting'] ) ){
            $rt_addon_arg['tp_countdown_setting'] = sanitize_text_field( $input_addon['tp_countdown_setting'] );
        } 
        
        //Business Hour 
         if( isset( $input_addon['tp_business_hour_setting'] ) ){
            $rt_addon_arg['tp_business_hour_setting'] = sanitize_text_field( $input_addon['tp_business_hour_setting'] );
        }

        //Services Grid 
        if( isset( $input_addon['tp_service_grid_setting'] ) ){
            $rt_addon_arg['tp_service_grid_setting'] = sanitize_text_field( $input_addon['tp_service_grid_setting'] );
        }
        //Services Slider 
        if( isset( $input_addon['tp_service_slider_setting'] ) ){
            $rt_addon_arg['tp_service_slider_setting'] = sanitize_text_field( $input_addon['tp_service_slider_setting'] );
        }
        //Video 
        if( isset( $input_addon['tp_video_setting'] ) ){
            $rt_addon_arg['tp_video_setting'] = sanitize_text_field( $input_addon['tp_video_setting'] );
        }
        //Pricing Table 
        if( isset( $input_addon['tp_pricing_table_setting'] ) ){
            $rt_addon_arg['tp_pricing_table_setting'] = sanitize_text_field( $input_addon['tp_pricing_table_setting'] );
        }

        //Button
        if( isset( $input_addon['tp_button_setting'] ) ){
            $rt_addon_arg['tp_button_setting'] = sanitize_text_field( $input_addon['tp_button_setting'] );
        }
        //Logo Showcase
        if( isset( $input_addon['tp_logo_showcase_setting'] ) ){
            $rt_addon_arg['tp_logo_showcase_setting'] = sanitize_text_field( $input_addon['tp_logo_showcase_setting'] );
        }
        //CTA
        if( isset( $input_addon['tp_cta_setting'] ) ){
            $rt_addon_arg['tp_cta_setting'] = sanitize_text_field( $input_addon['tp_cta_setting'] );
        }

        //Testimonial Slider
        if( isset( $input_addon['tp_testimonial_slider_setting'] ) ){
            $rt_addon_arg['tp_testimonial_slider_setting'] = sanitize_text_field( $input_addon['tp_testimonial_slider_setting'] );
        }

        //Flip Box
        if( isset( $input_addon['tp_flip_box_setting'] ) ){
            $rt_addon_arg['tp_flip_box_setting'] = sanitize_text_field( $input_addon['tp_flip_box_setting'] );
        }
        //Tab
        if( isset( $input_addon['tp_tab_setting'] ) ){
            $rt_addon_arg['tp_tab_setting'] = sanitize_text_field( $input_addon['tp_tab_setting'] );
        }
        //Advance Tab
        if( isset( $input_addon['tp_advance_tab_setting'] ) ){
            $rt_addon_arg['tp_advance_tab_setting'] = sanitize_text_field( $input_addon['tp_advance_tab_setting'] );
        }
        //Icon Box
        if( isset( $input_addon['tp_icon_box_setting'] ) ){
            $rt_addon_arg['tp_icon_box_setting'] = sanitize_text_field( $input_addon['tp_icon_box_setting'] );
        }
        //Blog Grid
        if( isset( $input_addon['tp_blog_grid_setting'] ) ){
            $rt_addon_arg['tp_blog_grid_setting'] = sanitize_text_field( $input_addon['tp_blog_grid_setting'] );
        }
        //Blog Slider
        if( isset( $input_addon['tp_blog_slider_setting'] ) ){
            $rt_addon_arg['tp_blog_slider_setting'] = sanitize_text_field( $input_addon['tp_blog_slider_setting'] );
        }
        //Number Grid
        if( isset( $input_addon['tp_number_grid_setting'] ) ){
            $rt_addon_arg['tp_number_grid_setting'] = sanitize_text_field( $input_addon['tp_number_grid_setting'] );
        }
        //Contact Form 7
        if( isset( $input_addon['tp_contact_form_7_setting'] ) ){
            $rt_addon_arg['tp_contact_form_7_setting'] = sanitize_text_field( $input_addon['tp_contact_form_7_setting'] );
        }
        //Progress Bar
        if( isset( $input_addon['tp_progress_bar_setting'] ) ){
            $rt_addon_arg['tp_progress_bar_setting'] = sanitize_text_field( $input_addon['tp_progress_bar_setting'] );
        }
        //Progress Pie
        if( isset( $input_addon['tp_progress_pie_setting'] ) ){
            $rt_addon_arg['tp_progress_pie_setting'] = sanitize_text_field( $input_addon['tp_progress_pie_setting'] );
        }
        //Iconbox Top
        if( isset( $input_addon['tp_icon_bar_setting'] ) ){
            $rt_addon_arg['tp_icon_bar_setting'] = sanitize_text_field( $input_addon['tp_icon_bar_setting'] );
        }
        //Iconbox List
        if( isset( $input_addon['tp_contactbox_icon_setting'] ) ){
            $rt_addon_arg['tp_contactbox_icon_setting'] = sanitize_text_field( $input_addon['tp_contactbox_icon_setting'] );
        }
        //Contact Box
        if( isset( $input_addon['tp_real_contactbox_setting'] ) ){
            $rt_addon_arg['tp_real_contactbox_setting'] = sanitize_text_field( $input_addon['tp_real_contactbox_setting'] );
        }
        //Tooltip
        if( isset( $input_addon['tp_tooltip_setting'] ) ){
            $rt_addon_arg['tp_tooltip_setting'] = sanitize_text_field( $input_addon['tp_tooltip_setting'] );
        }

        //FAQ
        if( isset( $input_addon['tp_faq_setting'] ) ){
            $rt_addon_arg['tp_faq_setting'] = sanitize_text_field( $input_addon['tp_faq_setting'] );
        }
        //Image Showcase
        if( isset( $input_addon['tp_image_showcase_setting'] ) ){
            $rt_addon_arg['tp_image_showcase_setting'] = sanitize_text_field( $input_addon['tp_image_showcase_setting'] );
        }
        //Image Hover Effect
        if( isset( $input_addon['tp_image_hover_effect_setting'] ) ){
            $rt_addon_arg['tp_image_hover_effect_setting'] = sanitize_text_field( $input_addon['tp_image_hover_effect_setting'] );
        }
        //Features List
        if( isset( $input_addon['tp_features_list_setting'] ) ){
            $rt_addon_arg['tp_features_list_setting'] = sanitize_text_field( $input_addon['tp_features_list_setting'] );
        }

        //Accordion
        if( isset( $input_addon['tp_accordion_setting'] ) ){
            $rt_addon_arg['tp_accordion_setting'] = sanitize_text_field( $input_addon['tp_accordion_setting'] );
        }
        //Newsletter
        if( isset( $input_addon['tp_newsletter_setting'] ) ){
            $rt_addon_arg['tp_newsletter_setting'] = sanitize_text_field( $input_addon['tp_newsletter_setting'] );
        }
        //Image Card
        if( isset( $input_addon['tp_image_card_setting'] ) ){
            $rt_addon_arg['tp_image_card_setting'] = sanitize_text_field( $input_addon['tp_image_card_setting'] );
        }
        //Marquee
        if( isset( $input_addon['tp_marquee_setting'] ) ){
            $rt_addon_arg['tp_marquee_setting'] = sanitize_text_field( $input_addon['tp_marquee_setting'] );
        }
        //Line Draw
        if( isset( $input_addon['tp_linedraw_setting'] ) ){
            $rt_addon_arg['tp_linedraw_setting'] = sanitize_text_field( $input_addon['tp_linedraw_setting'] );
        }
        //Client Thumb
        if( isset( $input_addon['tp_client_thumb_setting'] ) ){
            $rt_addon_arg['tp_client_thumb_setting'] = sanitize_text_field( $input_addon['tp_client_thumb_setting'] );
        }
        //Timeline
        if( isset( $input_addon['tp_timeline_setting'] ) ){
            $rt_addon_arg['tp_timeline_setting'] = sanitize_text_field( $input_addon['tp_timeline_setting'] );
        }
        //History
        if( isset( $input_addon['tp_history_setting'] ) ){
            $rt_addon_arg['tp_history_setting'] = sanitize_text_field( $input_addon['tp_history_setting'] );
        }
        //Portfolio Feature
        if( isset( $input_addon['tp_portfolio_featurelist_setting'] ) ){
            $rt_addon_arg['tp_portfolio_featurelist_setting'] = sanitize_text_field( $input_addon['tp_portfolio_featurelist_setting'] );
        }
        //Featured Image
        if( isset( $input_addon['tp_featured_image_setting'] ) ){
            $rt_addon_arg['tp_featured_image_setting'] = sanitize_text_field( $input_addon['tp_featured_image_setting'] );
        }
        //Site Logo
        if( isset( $input_addon['tp_site_logo_setting'] ) ){
            $rt_addon_arg['tp_site_logo_setting'] = sanitize_text_field( $input_addon['tp_site_logo_setting'] );
        }

        //Site Search
        if( isset( $input_addon['tp_site_search_setting'] ) ){
            $rt_addon_arg['tp_site_search_setting'] = sanitize_text_field( $input_addon['tp_site_search_setting'] );
        }

        //Site Canvas
        if( isset( $input_addon['tp_site_canvas_setting'] ) ){
            $rt_addon_arg['tp_site_canvas_setting'] = sanitize_text_field( $input_addon['tp_site_canvas_setting'] );
        }

        //Site Navigation
        if( isset( $input_addon['tp_site_navigation_setting'] ) ){
            $rt_addon_arg['tp_site_navigation_setting'] = sanitize_text_field( $input_addon['tp_site_navigation_setting'] );
        }

        //Sroll To Top
        if( isset( $input_addon['tp_scroll_to_top_setting'] ) ){
            $rt_addon_arg['tp_scroll_to_top_setting'] = sanitize_text_field( $input_addon['tp_scroll_to_top_setting'] );
        }

        //Single Navigation
        if( isset( $input_addon['tp_single_navigation_setting'] ) ){
            $rt_addon_arg['tp_single_navigation_setting'] = sanitize_text_field( $input_addon['tp_single_navigation_setting'] );
        }

        //Copyright
        if( isset( $input_addon['tp_copyright_setting'] ) ){
            $rt_addon_arg['tp_copyright_setting'] = sanitize_text_field( $input_addon['tp_copyright_setting'] );
        }

        //Cart
        if( isset( $input_addon['tp_cart_setting'] ) ){
            $rt_addon_arg['tp_cart_setting'] = sanitize_text_field( $input_addon['tp_cart_setting'] );
        }


        return $rt_addon_arg;
    }

    /**
     * Print the Section text
     */
    public function tpelements_section_info() {
        //print 'Enter your settings below:';
    }
    /**
     * Heading field
     */
    public function tp_elements_heading_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_heading_setting]" id="tp_heading_setting" value="tpelement_heading" %s/>',
                (isset( $this->tpelements_options['tp_heading_setting']) && $this->tpelements_options['tp_heading_setting'] ) == 'tpelement_heading' ? 'checked' : ''
            );
            ?>
            <label for="tp_heading_setting"></label>
        </div>
        <?php
    }

    /**
     * Animated Heading
     */
    public function tpelements_animated_heading_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_animated_heading_setting]" id="tp_animated_heading_setting" value="tpelement_animated_heading" %s/>',
                (isset( $this->tpelements_options['tp_animated_heading_setting']) && $this->tpelements_options['tp_animated_heading_setting'] ) == 'tpelement_animated_heading' ? 'checked' : ''
            );
            ?>
            <label for="tp_animated_heading_setting"></label>
        </div>
        <?php
    }

    /**
     * Blockquote
     */
    public function tpelements_blockquote_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_blockquote_setting]" id="tp_blockquote_setting" value="tpelement_blockquote" %s/>',
                (isset( $this->tpelements_options['tp_blockquote_setting']) && $this->tpelements_options['tp_blockquote_setting'] ) == 'tpelement_blockquote' ? 'checked' : ''
            );
            ?>
            <label for="tp_blockquote_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Animated Heading
     */
    public function tpelements_about_image() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_about_image_setting]" id="tp_about_image_setting" value="tpelement_about_image" %s/>',
                (isset( $this->tpelements_options['tp_about_image_setting']) && $this->tpelements_options['tp_about_image_setting'] ) == 'tpelement_about_image' ? 'checked' : ''
            );
            ?>
            <label for="tp_about_image_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Blockquote
     */
    public function tpelements_blockquote() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_about_image_setting]" id="tp_about_image_setting" value="tpelement_about_image" %s/>',
                (isset( $this->tpelements_options['tp_about_image_setting']) && $this->tpelements_options['tp_about_image_setting'] ) == 'tpelement_about_image' ? 'checked' : ''
            );
            ?>
            <label for="tp_about_image_setting"></label>
        </div>
        <?php
    }

    /**
     * Team Grid
     */
    public function tpelements_team_gread_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_team_grid_setting]" id="tp_team_grid_setting" value="tpelement_team_grid" %s/>',
                (isset( $this->tpelements_options['tp_team_grid_setting']) && $this->tpelements_options['tp_team_grid_setting'] ) == 'tpelement_team_grid' ? 'checked' : ''
            );
            ?>
            <label for="tp_team_grid_setting"></label>
        </div>
        <?php
    }

    /**
     * Full Width Slider
     */
    public function tpelements_full_width_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_full_width_slider_setting]" id="tp_full_width_slider_setting" value="tpelement_full_width_slider" %s/>',
                (isset( $this->tpelements_options['tp_full_width_slider_setting']) && $this->tpelements_options['tp_full_width_slider_setting'] ) == 'tpelement_full_width_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_full_width_slider_setting"></label>
        </div>
        <?php
    }

    /**
     * Team Slide
     */
    public function tpelements_team_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_team_slider_setting]" id="tp_team_slider_setting" value="tpelement_team_slider" %s/>',
                (isset( $this->tpelements_options['tp_team_slider_setting']) && $this->tpelements_options['tp_team_slider_setting'] ) == 'tpelement_team_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_team_slider_setting"></label>
        </div>
        <?php
    }

    /**
     * Portfolio Grid
     */
    public function tpelements_portfolio_grid_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_portfolio_grid_setting]" id="tp_portfolio_grid_setting" value="tpelement_portfolio_grid" %s/>',
                (isset( $this->tpelements_options['tp_portfolio_grid_setting']) && $this->tpelements_options['tp_portfolio_grid_setting'] ) == 'tpelement_portfolio_grid' ? 'checked' : ''
            );
            ?>
            <label for="tp_portfolio_grid_setting"></label>
        </div>
        <?php
    }
    /**
     * Portfolio Slider
     */
    public function tpelements_portfolio_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_portfolio_slider_setting]" id="tp_portfolio_slider_setting" value="tpelement_portfolio_slider" %s/>',
                (isset( $this->tpelements_options['tp_portfolio_slider_setting']) && $this->tpelements_options['tp_portfolio_slider_setting'] ) == 'tpelement_portfolio_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_portfolio_slider_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Counter
     */
    public function tpelements_counter_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_counter_setting]" id="tp_counter_setting" value="tpelement_counter" %s/>',
                (isset( $this->tpelements_options['tp_counter_setting']) && $this->tpelements_options['tp_counter_setting'] ) == 'tpelement_counter' ? 'checked' : ''
            );
            ?>
            <label for="tp_counter_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Services Grid
     */
    public function tpelements_service_grid_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_service_grid_setting]" id="tp_service_grid_setting" value="tpelement_service_grid" %s/>',
                (isset( $this->tpelements_options['tp_service_grid_setting']) && $this->tpelements_options['tp_service_grid_setting'] ) == 'tpelement_service_grid' ? 'checked' : ''
            );
            ?>
            <label for="tp_service_grid_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Services Slider
     */
    public function tpelements_service_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_service_slider_setting]" id="tp_service_slider_setting" value="tpelement_service_slider" %s/>',
                (isset( $this->tpelements_options['tp_service_slider_setting']) && $this->tpelements_options['tp_service_slider_setting'] ) == 'tpelement_service_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_service_slider_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Video
     */
    public function tpelements_video_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_video_setting]" id="tp_video_setting" value="tpelement_video" %s/>',
                (isset( $this->tpelements_options['tp_video_setting']) && $this->tpelements_options['tp_video_setting'] ) == 'tpelement_video' ? 'checked' : ''
            );
            ?>
            <label for="tp_video_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Pricing Table
     */
    public function tpelements_pricing_table_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_pricing_table_setting]" id="tp_pricing_table_setting" value="tpelement_pricing_table" %s/>',
                (isset( $this->tpelements_options['tp_pricing_table_setting']) && $this->tpelements_options['tp_pricing_table_setting'] ) == 'tpelement_pricing_table' ? 'checked' : ''
            );
            ?>
            <label for="tp_pricing_table_setting"></label>
        </div>
        <?php
    }
    /**
     * Button
     */
    public function tpelements_button_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_button_setting]" id="tp_button_setting" value="tpelement_button" %s/>',
                (isset( $this->tpelements_options['tp_button_setting']) && $this->tpelements_options['tp_button_setting'] ) == 'tpelement_button' ? 'checked' : ''
            );
            ?>
            <label for="tp_button_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Logo Showcase
     */
    public function tpelements_logo_showcase_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_logo_showcase_setting]" id="tp_logo_showcase_setting" value="tpelement_logo_showcase" %s/>',
                (isset( $this->tpelements_options['tp_logo_showcase_setting']) && $this->tpelements_options['tp_logo_showcase_setting'] ) == 'tpelement_logo_showcase' ? 'checked' : ''
            );
            ?>
            <label for="tp_logo_showcase_setting"></label>
        </div>
        <?php
    }
    
    /**
     * CTA
     */
    public function tpelements_cta_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_cta_setting]" id="tp_cta_setting" value="tpelement_cta" %s/>',
                (isset( $this->tpelements_options['tp_cta_setting']) && $this->tpelements_options['tp_cta_setting'] ) == 'tpelement_cta' ? 'checked' : ''
            );
            ?>
            <label for="tp_cta_setting"></label>
        </div>
        <?php
    }
    /**
     * Testimonial Slider
     */
    public function tpelements_testimonial_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_testimonial_slider_setting]" id="tp_testimonial_slider_setting" value="tpelement_testimonial_slider" %s/>',
                (isset( $this->tpelements_options['tp_testimonial_slider_setting']) && $this->tpelements_options['tp_testimonial_slider_setting'] ) == 'tpelement_testimonial_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_testimonial_slider_setting"></label>
        </div>
        <?php
    }
    /**
     * Flip Box
     */
    public function tpelements_flip_box_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_flip_box_setting]" id="tp_flip_box_setting" value="tpelement_flip_box" %s/>',
                (isset( $this->tpelements_options['tp_flip_box_setting']) && $this->tpelements_options['tp_flip_box_setting'] ) == 'tpelement_flip_box' ? 'checked' : ''
            );
            ?>
            <label for="tp_flip_box_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Tab
     */
    public function tpelements_tab_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_tab_setting]" id="tp_tab_setting" value="tpelement_tab" %s/>',
                (isset( $this->tpelements_options['tp_tab_setting']) && $this->tpelements_options['tp_tab_setting'] ) == 'tpelement_tab' ? 'checked' : ''
            );
            ?>
            <label for="tp_tab_setting"></label>
        </div>
        <?php
    }

    /**
     * Advance Tab
     */
    public function tpelements_advance_tab_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_advance_tab_setting]" id="tp_advance_tab_setting" value="tpelement_advance_tab" %s/>',
                (isset( $this->tpelements_options['tp_advance_tab_setting']) && $this->tpelements_options['tp_advance_tab_setting'] ) == 'tpelement_advance_tab' ? 'checked' : ''
            );
            ?>
            <label for="tp_advance_tab_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Icon Box
     */
    public function tpelements_icon_box_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_icon_box_setting]" id="tp_icon_box_setting" value="tpelement_icon_box" %s/>',
                (isset( $this->tpelements_options['tp_icon_box_setting']) && $this->tpelements_options['tp_icon_box_setting'] ) == 'tpelement_icon_box' ? 'checked' : ''
            );
            ?>
            <label for="tp_icon_box_setting"></label>
        </div>
        <?php
    }

    /**
     * Blog Grid
     */
    public function tpelements_blog_grid_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_blog_grid_setting]" id="tp_blog_grid_setting" value="tpelement_blog_grid" %s/>',
                (isset( $this->tpelements_options['tp_blog_grid_setting']) && $this->tpelements_options['tp_blog_grid_setting'] ) == 'tpelement_blog_grid' ? 'checked' : ''
            );
            ?>
            <label for="tp_blog_grid_setting"></label>
        </div>
        <?php
    }

    /**
     * Blog Slider
     */
    public function tpelements_blog_slider_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_blog_slider_setting]" id="tp_blog_slider_setting" value="tpelement_blog_slider" %s/>',
                (isset( $this->tpelements_options['tp_blog_slider_setting']) && $this->tpelements_options['tp_blog_slider_setting'] ) == 'tpelement_blog_slider' ? 'checked' : ''
            );
            ?>
            <label for="tp_blog_slider_setting"></label>
        </div>
        <?php
    }

    /**
     * Number Grid
     */
    public function tpelements_number_grid_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_number_grid_setting]" id="tp_number_grid_setting" value="tpelement_number_grid" %s/>',
                (isset( $this->tpelements_options['tp_number_grid_setting']) && $this->tpelements_options['tp_number_grid_setting'] ) == 'tpelement_number_grid' ? 'checked' : ''
            );
            ?>
            <label for="tp_number_grid_setting"></label>
        </div>
        <?php
    }

    /**
     * Contact Form 7
     */
    public function tpelements_contact_form_7_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_contact_form_7_setting]" id="tp_contact_form_7_setting" value="tpelement_contact_form_7" %s/>',
                (isset( $this->tpelements_options['tp_contact_form_7_setting']) && $this->tpelements_options['tp_contact_form_7_setting'] ) == 'tpelement_contact_form_7' ? 'checked' : ''
            );
            ?>
            <label for="tp_contact_form_7_setting"></label>
        </div>
        <?php
    }

    /**
     * Progress Bar
     */
    public function tpelements_progress_bar_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_progress_bar_setting]" id="tp_progress_bar_setting" value="tpelement_progress_bar" %s/>',
                (isset( $this->tpelements_options['tp_progress_bar_setting']) && $this->tpelements_options['tp_progress_bar_setting'] ) == 'tpelement_progress_bar' ? 'checked' : ''
            );
            ?>
            <label for="tp_progress_bar_setting"></label>
        </div>
        <?php
    }

    /**
     * Iconbox Top
     */
    public function tpelements_icon_bar_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_icon_bar_setting]" id="tp_icon_bar_setting" value="tpelement_icon_bar" %s/>',
                (isset( $this->tpelements_options['tp_icon_bar_setting']) && $this->tpelements_options['tp_icon_bar_setting'] ) == 'tpelement_icon_bar' ? 'checked' : ''
            );
            ?>
            <label for="tp_icon_bar_setting"></label>
        </div>
        <?php
    }

    /**
     * Iconbox List
     */
    public function tpelements_contactbox_icon_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_contactbox_icon_setting]" id="tp_contactbox_icon_setting" value="tpelement_contactbox_icon" %s/>',
                (isset( $this->tpelements_options['tp_contactbox_icon_setting']) && $this->tpelements_options['tp_contactbox_icon_setting'] ) == 'tpelement_contactbox_icon' ? 'checked' : ''
            );
            ?>
            <label for="tp_contactbox_icon_setting"></label>
        </div>
        <?php
    }

    /**
     * Contact Box
     */
    public function tpelements_real_contactbox_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_real_contactbox_setting]" id="tp_real_contactbox_setting" value="tpelement_real_contactbox" %s/>',
                (isset( $this->tpelements_options['tp_real_contactbox_setting']) && $this->tpelements_options['tp_real_contactbox_setting'] ) == 'tpelement_real_contactbox' ? 'checked' : ''
            );
            ?>
            <label for="tp_real_contactbox_setting"></label>
        </div>
        <?php
    }


    /**
     * Progress Pie
     */
    public function tpelements_progress_pie_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_progress_pie_setting]" id="tp_progress_pie_setting" value="tpelement_progress_pie" %s/>',
                (isset( $this->tpelements_options['tp_progress_pie_setting']) && $this->tpelements_options['tp_progress_pie_setting'] ) == 'tpelement_progress_pie' ? 'checked' : ''
            );
            ?>
            <label for="tp_progress_pie_setting"></label>
        </div>
        <?php
    }

    
    /**
     * Countdown Box
     */
    public function tpelements_countdown_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_countdown_setting]" id="tp_countdown_setting" value="tpelement_countdown_box" %s/>',
                (isset( $this->tpelements_options['tp_countdown_setting']) && $this->tpelements_options['tp_countdown_setting'] ) == 'tpelement_countdown_box' ? 'checked' : ''
            );
            ?>
            <label for="tp_countdown_setting"></label>
        </div>
        <?php
    }
    
    /**
     * Business Hour 
     */
    public function tpelements_business_hour_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_business_hour_setting]" id="tp_business_hour_setting" value="tpelement_business_hour_box" %s/>',
                (isset( $this->tpelements_options['tp_business_hour_setting']) && $this->tpelements_options['tp_business_hour_setting'] ) == 'tpelement_business_hour_box' ? 'checked' : ''
            );
            ?>
            <label for="tp_business_hour_setting"></label>
        </div>
        <?php
    }

    /**
     * Tooltip
     */
    public function tpelements_tooltip_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_tooltip_setting]" id="tp_tooltip_setting" value="tpelement_tooltip" %s/>',
                (isset( $this->tpelements_options['tp_tooltip_setting']) && $this->tpelements_options['tp_tooltip_setting'] ) == 'tpelement_tooltip' ? 'checked' : ''
            );
            ?>
            <label for="tp_tooltip_setting"></label>
        </div>
        <?php
    }
    /**
     * FAQ ( masum did not find )
     */
    public function tpelements_faq_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_faq_setting]" id="tp_faq_setting" value="tpelement_faq" %s/>',
                (isset( $this->tpelements_options['tp_faq_setting']) && $this->tpelements_options['tp_faq_setting'] ) == 'tpelement_faq' ? 'checked' : ''
            );
            ?>
            <label for="tp_faq_setting"></label>
        </div>
        <?php
    }

    /**
     * Image Showcase
     */
    public function tpelements_image_showcase_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_image_showcase_setting]" id="tp_image_showcase_setting" value="tpelement_image_showcase" %s/>',
                (isset( $this->tpelements_options['tp_image_showcase_setting']) && $this->tpelements_options['tp_image_showcase_setting'] ) == 'tpelement_image_showcase' ? 'checked' : ''
            );
            ?>
            <label for="tp_image_showcase_setting"></label>
        </div>
        <?php
    }

    /**
     * Image Hover Effect
     */
    public function tpelements_image_hover_effect_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_image_hover_effect_setting]" id="tp_image_hover_effect_setting" value="tpelement_image_hover_effect" %s/>',
                (isset( $this->tpelements_options['tp_image_hover_effect_setting']) && $this->tpelements_options['tp_image_hover_effect_setting'] ) == 'tpelement_image_hover_effect' ? 'checked' : ''
            );
            ?>
            <label for="tp_image_hover_effect_setting"></label>
        </div>
        <?php
    }

    /**
     * Features List
     */
    public function tpelements_features_list_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_features_list_setting]" id="tp_features_list_setting" value="tpelement_features_list" %s/>',
                (isset( $this->tpelements_options['tp_features_list_setting']) && $this->tpelements_options['tp_features_list_setting'] ) == 'tpelement_features_list' ? 'checked' : ''
            );
            ?>
            <label for="tp_features_list_setting"></label>
        </div>
        <?php
    }
    /**
     * Accordion
     */
    public function tpelements_accordion_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_accordion_setting]" id="tp_accordion_setting" value="tpelement_accordion" %s/>',
                (isset( $this->tpelements_options['tp_accordion_setting']) && $this->tpelements_options['tp_accordion_setting'] ) == 'tpelement_accordion' ? 'checked' : ''
            );
            ?>
            <label for="tp_accordion_setting"></label>
        </div>
        <?php
    }

    /**
     * Newsletter
     */
    public function tpelements_newsletter_setting() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tpelements_addon_option[tp_newsletter_setting]" id="tp_newsletter_setting" value="tpelement_newsletter" %s/>',
                (isset( $this->tpelements_options['tp_newsletter_setting']) && $this->tpelements_options['tp_newsletter_setting'] ) == 'tpelement_newsletter' ? 'checked' : ''
            );
            ?>
            <label for="tp_newsletter_setting"></label>
        </div>
        <?php
    }

    /**
     * Image Card
     */
    public function tpelements_image_card_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_image_card_setting]" id="tp_image_card_setting" value="tpelement_image_card" %s/>',
                (isset( $this->tpelements_options['tp_image_card_setting']) && $this->tpelements_options['tp_image_card_setting'] ) == 'tpelement_image_card' ? 'checked' : ''
            );
            ?>
            <label for="tp_image_card_setting"></label>
        </div>
        <?php
    }


    /**
     * Marquee
     */
    public function tpelements_marquee_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_marquee_setting]" id="tp_marquee_setting" value="tpelement_marquee" %s/>',
                (isset( $this->tpelements_options['tp_marquee_setting']) && $this->tpelements_options['tp_marquee_setting'] ) == 'tpelement_marquee' ? 'checked' : ''
            );
            ?>
            <label for="tp_marquee_setting"></label>
        </div>
        <?php
    }

    /**
     * Line Draw
     */
    public function tpelements_linedraw_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_linedraw_setting]" id="tp_linedraw_setting" value="tpelement_linedraw" %s/>',
                (isset( $this->tpelements_options['tp_linedraw_setting']) && $this->tpelements_options['tp_linedraw_setting'] ) == 'tpelement_linedraw' ? 'checked' : ''
            );
            ?>
            <label for="tp_linedraw_setting"></label>
        </div>
        <?php
    }
    /**
     * Client Thumb
     */
    public function tpelements_client_thumb_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_client_thumb_setting]" id="tp_client_thumb_setting" value="tpelement_client_thumb" %s/>',
                (isset( $this->tpelements_options['tp_client_thumb_setting']) && $this->tpelements_options['tp_client_thumb_setting'] ) == 'tpelement_client_thumb' ? 'checked' : ''
            );
            ?>
            <label for="tp_client_thumb_setting"></label>
        </div>
        <?php
    }

    /**
     * Timeline
     */
    public function tpelements_timeline_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_timeline_setting]" id="tp_timeline_setting" value="tpelement_timeline" %s/>',
                (isset( $this->tpelements_options['tp_timeline_setting']) && $this->tpelements_options['tp_timeline_setting'] ) == 'tpelement_timeline' ? 'checked' : ''
            );
            ?>
            <label for="tp_timeline_setting"></label>
        </div>
        <?php
    }

    /**
     * History
     */
    public function tpelements_history_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_history_setting]" id="tp_history_setting" value="tpelement_history" %s/>',
                (isset( $this->tpelements_options['tp_history_setting']) && $this->tpelements_options['tp_history_setting'] ) == 'tpelement_history' ? 'checked' : ''
            );
            ?>
            <label for="tp_history_setting"></label>
        </div>
        <?php
    }
    /**
     * Portfolio Feature
     */
    public function tpelements_portfolio_featurelist_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_portfolio_featurelist_setting]" id="tp_portfolio_featurelist_setting" value="tpelement_portfolio_featurelist" %s/>',
                (isset( $this->tpelements_options['tp_portfolio_featurelist_setting']) && $this->tpelements_options['tp_portfolio_featurelist_setting'] ) == 'tpelement_portfolio_featurelist' ? 'checked' : ''
            );
            ?>
            <label for="tp_portfolio_featurelist_setting"></label>
        </div>
        <?php
    }
    /**
     * Featured Image
     */
    public function tpelements_featured_image_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_featured_image_setting]" id="tp_featured_image_setting" value="tpelement_featured_image" %s/>',
                (isset( $this->tpelements_options['tp_featured_image_setting']) && $this->tpelements_options['tp_featured_image_setting'] ) == 'tpelement_featured_image' ? 'checked' : ''
            );
            ?>
            <label for="tp_featured_image_setting"></label>
        </div>
        <?php
    }
    /**
     * Site Logo
     */
    public function tpelements_site_logo_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_site_logo_setting]" id="tp_site_logo_setting" value="tpelement_site_logo" %s/>',
                (isset( $this->tpelements_options['tp_site_logo_setting']) && $this->tpelements_options['tp_site_logo_setting'] ) == 'tpelement_site_logo' ? 'checked' : ''
            );
            ?>
            <label for="tp_site_logo_setting"></label>
        </div>
        <?php
    }
    /**
     * Site Search
     */
    public function tpelements_site_search_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_site_search_setting]" id="tp_site_search_setting" value="tpelement_site_search" %s/>',
                (isset( $this->tpelements_options['tp_site_search_setting']) && $this->tpelements_options['tp_site_search_setting'] ) == 'tpelement_site_search' ? 'checked' : ''
            );
            ?>
            <label for="tp_site_search_setting"></label>
        </div>
        <?php
    }

    /**
     * Site Canvas
     */
    public function tpelements_site_canvas_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_site_canvas_setting]" id="tp_site_canvas_setting" value="tpelement_site_canvas" %s/>',
                (isset( $this->tpelements_options['tp_site_canvas_setting']) && $this->tpelements_options['tp_site_canvas_setting'] ) == 'tpelement_site_canvas' ? 'checked' : ''
            );
            ?>
            <label for="tp_site_canvas_setting"></label>
        </div>
        <?php
    }

    /**
     * Site Navigation
     */
    public function tpelements_site_navigation_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_site_navigation_setting]" id="tp_site_navigation_setting" value="tpelement_site_navigation" %s/>',
                (isset( $this->tpelements_options['tp_site_navigation_setting']) && $this->tpelements_options['tp_site_navigation_setting'] ) == 'tpelement_site_navigation' ? 'checked' : ''
            );
            ?>
            <label for="tp_site_navigation_setting"></label>
        </div>
        <?php
    }

    /**
     * Scroll To Top
     */
    public function tpelements_scroll_to_top_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_scroll_to_top_setting]" id="tp_scroll_to_top_setting" value="tpelement_scroll_to_top" %s/>',
                (isset( $this->tpelements_options['tp_scroll_to_top_setting']) && $this->tpelements_options['tp_scroll_to_top_setting'] ) == 'tpelement_scroll_to_top' ? 'checked' : ''
            );
            ?>
            <label for="tp_scroll_to_top_setting"></label>
        </div>
        <?php
    }


    /**
     * Single Navigation
     */
    public function tpelements_single_navigation_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_single_navigation_setting]" id="tp_single_navigation_setting" value="tpelement_single_navigation" %s/>',
                (isset( $this->tpelements_options['tp_single_navigation_setting']) && $this->tpelements_options['tp_single_navigation_setting'] ) == 'tpelement_single_navigation' ? 'checked' : ''
            );
            ?>
            <label for="tp_single_navigation_setting"></label>
        </div>
        <?php
    }

    /**
     * Copyright
     */
    public function tpelements_copyright_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_copyright_setting]" id="tp_copyright_setting" value="tpelement_copyright" %s/>',
                (isset( $this->tpelements_options['tp_copyright_setting']) && $this->tpelements_options['tp_copyright_setting'] ) == 'tpelement_copyright' ? 'checked' : ''
            );
            ?>
            <label for="tp_copyright_setting"></label>
        </div>
        <?php
    }

    /**
     * Cart
     */
    public function tpelements_cart_setting() {
        ?>
        <div class="checkbox">
            <?php

            printf('<input type="checkbox" name="tpelements_addon_option[tp_cart_setting]" id="tp_cart_setting" value="tpelement_cart" %s/>',
                (isset( $this->tpelements_options['tp_cart_setting']) && $this->tpelements_options['tp_cart_setting'] ) == 'tpelement_cart' ? 'checked' : ''
            );
            ?>
            <label for="tp_cart_setting"></label>
        </div>
        <?php
    }



    public function tpelements_plugin_activate() {
        $all_elements_list = $this->tpelements_widget_list();

        update_option('tpelements_addon_option',$all_elements_list);
    }

    public function tpelements_widget_list() {
        $tpall_elements = [
            'tp_cart_setting' => 'tpelement_cart',
            'tp_copyright_setting' => 'tpelement_copyright',
            'tp_single_navigation_setting' => 'tpelement_single_navigation',
            'tp_scroll_to_top_setting' => 'tpelement_scroll_to_top',
            'tp_site_navigation_setting' => 'tpelement_site_navigation',
            'tp_site_canvas_setting' => 'tpelement_site_canvas',
            'tp_site_search_setting' => 'tpelement_site_search',
            'tp_site_logo_setting' => 'tpelement_site_logo',
            'tp_featured_image_setting' => 'tpelement_featured_image',
            'tp_portfolio_featurelist_setting' => 'tpelement_portfolio_featurelist',
            'tp_history_setting' => 'tpelement_history',
            'tp_timeline_setting' => 'tpelement_timeline',
            'tp_client_thumb_setting' => 'tpelement_client_thumb',
            'tp_linedraw_setting' => 'tpelement_linedraw',
            'tp_image_card_setting' => 'tpelement_image_card',
            'tp_marquee_setting' => 'tpelement_marquee',
            'tp_heading_setting' => 'tp_element_heading',
            'tp_animated_heading_setting' => 'tpelement_animated_heading',
            'tp_blockquote_setting' => 'tpelement_blockquote',
            'tp_about_image_setting' => 'tpelement_about_image',
            'tp_team_grid_setting' => 'tpelement_team_grid',
            'tp_full_width_slider_setting' => 'tpelement_full_width_slider',
            'tp_team_slider_setting' => 'tpelement_team_slider',
            'tp_portfolio_grid_setting' => 'tpelement_portfolio_grid',
            'tp_portfolio_slider_setting' => 'tpelement_portfolio_slider',
            'tp_counter_setting' => 'tpelement_counter',
            'tp_service_grid_setting' => 'tpelement_service_grid',
            'tp_service_slider_setting' => 'tpelement_service_slider',
            'tp_video_setting' => 'tpelement_video',
            'tp_pricing_table_setting' => 'tpelement_pricing_table',
            'tp_button_setting' => 'tpelement_button',
            'tp_logo_showcase_setting' => 'tpelement_logo_showcase',
            'tp_cta_setting' => 'tpelement_cta',
            'tp_flip_box_setting' => 'tpelement_flip_box',
            'tp_tab_setting' => 'tpelement_tab',
            'tp_advance_tab_setting' => 'tpelement_advance_tab',
            'tp_icon_box_setting' => 'tpelement_icon_box',
            'tp_blog_grid_setting' => 'tpelement_blog_grid',
            'tp_blog_slider_setting' => 'tpelement_blog_slider',
            'tp_number_grid_setting' => 'tpelement_number_grid',
            'tp_contact_form_7_setting' => 'tpelement_contact_form_7',
            'tp_progress_bar_setting' => 'tpelement_progress_bar',
            'tp_icon_bar_setting' => 'tpelement_icon_bar',
            'tp_contactbox_icon_setting' => 'tpelement_contactbox_icon',
            'tp_real_contactbox_setting' => 'tpelement_real_contactbox',
            'tp_progress_pie_setting' => 'tpelement_progress_pie',
            'tp_countdown_setting' => 'tpelement_countdown_box',
            'tp_business_hour_setting' => 'tpelement_business_hour_box',
            'tp_tooltip_setting' => 'tpelement_tooltip',
            'tp_faq_setting' => 'tpelement_faq',
            'tp_image_showcase_setting' => 'tpelement_image_showcase',
            'tp_image_hover_effect_setting' => 'tpelement_image_hover_effect',
            'tp_features_list_setting' => 'tpelement_features_list',            
            'tp_accordion_setting' => 'tpelement_accordion',
            'tp_newsletter_setting' => 'tpelement_newsletter',
            'tp_testimonial_slider_setting' => 'tpelement_testimonial_slider',
           
        ];

        return $tpall_elements;
    }
    
}

if( is_admin() )
    new TP_Elements_Addon_Control();