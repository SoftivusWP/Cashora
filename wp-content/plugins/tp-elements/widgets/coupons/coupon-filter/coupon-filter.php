<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
    exit;   // Exit if accessed directly.
}

/**
 * HFE Search Button.
 *
 * HFE widget for Search Button.
 *
 * @since 1.5.0
 */
class Themephi_Coupon_Filter extends Widget_Base {
    /**
     * Retrieve the widget name.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'coupon-filter';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'TP Coupon Filter', 'tp-elements');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'hfe-icon-search';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'tpaddon_category' ];
    }

    /**
     * Retrieve the list of scripts the navigation menu depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.5.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
 

    /**
     * Register Search Button controls.
     *
     * @since 1.5.7
     * @access protected
     */
    protected function register_controls() {
        $this->register_general_content_controls();
        $this->register_search_style_controls();
    }
    /**
     * Register Search General Controls.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function register_general_content_controls() {
        $this->start_controls_section(
            'section_general_fields',
            [
                'label' => __( 'Coupon Filter', 'tp-elements'),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'        => __( 'Select Layout', 'tp-elements'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'style1',
                'options'      => [
                    'style1'      => __( 'Style 1', 'tp-elements'),
                ],
            ]
        );


        $this->end_controls_section();
    }
    /**
     * Register Search Style Controls.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function register_search_style_controls() {

        $this->start_controls_section(
			'section_portfolio_style',
			[
				'label' => esc_html__( 'Filter Button', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
		    'filter_wrap_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon_types_item_wrapper ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);
		$this->add_responsive_control(
		    'filter_wrap_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon_types_item_wrapper ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

        $this->add_control(
		    'filter_wrap_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .coupon_types_item_wrapper' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_wrap_button_border',
		        'selector' => '{{WRAPPER}} .coupon_types_item_wrapper',
		    ]
		);

		$this->add_control(
		    'filter_wrap_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon_types_item_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'hr_fitler_btn',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_filter_btn' );

		$this->start_controls_tab(
		    '_tab_filter_btn_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_responsive_control(
		    'filter_btn_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .form-group label.search-type' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

        $this->add_responsive_control(
            'filter_btn__padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],  
                'selectors' => [
                    '{{WRAPPER}} .search-filter .form-group label.search-type' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
            ]
        );

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'filter_btn_typography',
		        'selector' => '{{WRAPPER}} .search-filter .form-group label.search-type',
		    ]
		);

		$this->add_control(
		    'filter_btn_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} label.search-type' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_button_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
                'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .label.search-type' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_btn_button_border',
		        'selector' => '{{WRAPPER}} label.search-type',
		    ]
		);

		$this->add_control(
		    'filter_btn_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} label.search-type' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'filter_btn_button_box_shadow',
		        'selector' => '{{WRAPPER}} label.search-type',
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_filter_btn_hover',
		    [
		        'label' => esc_html__( 'Hover/Active', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'filter_btn_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .search-type:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} input[id*="check-type"]:checked + .search-type' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_btn_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .search-type:hover' => 'background: {{VALUE}};',
		            '{{WRAPPER}} input[id*="check-type"]:checked + .search-type' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_btn_hover_border',
		        'selector' => '{{WRAPPER}} .search-type:hover, {{WRAPPER}} input[id*="check-type"]:checked + .search-type',
		    ]
		);

		$this->add_control(
		    'filter_btn_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .search-type:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} input[id*="check-type"]:checked + .search-type' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'filter_btn_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .search-type:hover, {{WRAPPER}} input[id*="check-type"]:checked + .search-type',
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->end_controls_section();

        
        $this->start_controls_section(
            'section_coupon_input_style',
            [
                'label' => __( 'Filter Input', 'tp-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,

            ]
        );

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'coupon_filter_input__typography',
                'label' => esc_html__( 'Label Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .coupon-input-style label',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'coupon_filter_input_placeholder__typography',
                'label' => esc_html__( 'Placeholder Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .coupon-input-style .coupon-input-style-input::placeholder',
		    ]
		);

        $this->add_responsive_control(
		    'coupon_filter_input_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-input-style .coupon-input-style-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'coupon_filter_input_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-input-style .coupon-input-style-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'coupon_filter_input_label_color',
		    [
		        'label' => esc_html__( 'Label Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .coupon-input-style label' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'coupon_filter_input_placeholder_color',
		    [
		        'label' => esc_html__( 'Placeholder Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .coupon-input-style .coupon-input-style-input::placeholder' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'coupon_filter_input_background_normal',
				'label' => esc_html__( 'Input Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .coupon-input-style .coupon-input-style-input',
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'coupon_filter_input__border',
		        'selector' => '{{WRAPPER}} .coupon-input-style .coupon-input-style-input',
		    ]
		);

		$this->add_control(
		    'coupon_filter_input__border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-input-style .coupon-input-style-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'coupon_filter_input__box_shadow',
		        'selector' => '{{WRAPPER}} .coupon-input-style .coupon-input-style-input',
		    ]
		);

        
		$this->add_control(
		    'hr_fitler_submit_btn',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_filter_submit_btn' );

		$this->start_controls_tab(
		    '_tab_filter_submit_btn_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_responsive_control(
		    'filter_submit_btn_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

        $this->add_responsive_control(
            'filter_submit_btn__padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],  
                'selectors' => [
                    '{{WRAPPER}} .search-filter .btn.submit-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
            ]
        );

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'filter_submit_btn_typography',
		        'selector' => '{{WRAPPER}} .search-filter .btn.submit-form',
		    ]
		);

		$this->add_control( 
		    'filter_submit_btn_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_submit_btn_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_submit_btn_button_border',
		        'selector' => '{{WRAPPER}} .search-filter .btn.submit-form',
		    ]
		);

		$this->add_control(
		    'filter_submit_btn_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'filter_submit_btn_button_box_shadow',
		        'selector' => '{{WRAPPER}} .search-filter .btn.submit-form',
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'submit_tab_filter_btn_hover',
		    [
		        'label' => esc_html__( 'Hover/Active', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'filter_submit_btn_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_submit_btn_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .search-filter .btn.submit-form:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->end_controls_section();

    }
    /**
     * Render Search button output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        global $tptheme_option; 

        $cur_page = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

        // Get filter values from the URL
        $category = !empty($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $store = !empty($_GET['store']) ? sanitize_text_field($_GET['store']) : '';
        $keyword = !empty($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';
        $type = !empty($_GET['type']) && is_array($_GET['type']) ? array_map('sanitize_text_field', $_GET['type']) : array();

        $selected_orderby = couponis_get_search_orderby_cookie();

        // Base query arguments
        $search_args = array(
            'post_type'     => 'coupon',
            'post_status'   => 'publish',
            'orderby'       => 'date',
            'order'         => 'DESC',
            'paged'         => $cur_page,
            'tax_query'     => array(), 
            'posts_per_page' => 6,
        );

        // Apply orderby if selected
        if (!empty($selected_orderby)) {
            $search_args['orderby'] = $selected_orderby;
            $search_args['order'] = ($selected_orderby == 'expire' || $selected_orderby == 'name') ? 'ASC' : 'DESC';
        }

        // Handle category filter
        if (!empty($category)) {
            $search_args['tax_query'][] = array(
                'taxonomy' => 'coupon-category',
                //'field'    => 'slug', // Use 'slug' to match the category slug
                'terms'    => $category,
            );
        }

        // Handle store filter
        if (!empty($store)) {
            $search_args['tax_query'][] = array(
                'taxonomy' => 'coupon-store',
                //'field'    => 'slug', // Use 'slug' to match the store slug
                'terms'    => $store,
            );
        }

        // Handle coupon type filter (Online Codes, Store Codes, Online Sales)
        if (!empty($type)) {
            $search_args['meta_query'] = array(
                'relation' => 'OR',
            );
            if (in_array('1', $type)) {
                $search_args['meta_query'][] = array(
                    'key'     => 'ctype',
                    'value'   => '1',  // Online Codes
                    'compare' => 'LIKE',
                );
            }
            if (in_array('2', $type)) {
                $search_args['meta_query'][] = array(
                    'key'     => 'ctype',
                    'value'   => '2',  // Store Codes
                    'compare' => 'LIKE',
                );
            }
            if (in_array('3', $type)) {
                $search_args['meta_query'][] = array(
                    'key'     => 'ctype',
                    'value'   => '3',  // Online Sales
                    'compare' => 'LIKE',
                );
            }
        }

        // Handle keyword search
        if (!empty($keyword)) {
            $search_args['s'] = $keyword;
        }

        // Handle multiple taxonomies
        if (count($search_args['tax_query']) > 1) {
            $search_args['tax_query']['relation'] = 'AND'; // Use 'AND' to match both category AND store
        }

        // Run the query
        $coupons = new WP_Query($search_args);

        ?>
        <div class="search-filter">
            <div class="white-block-content">

                <?php
                // Get selected values from URL parameters
                $selected_types = isset($_GET['type']) ? $_GET['type'] : [];
                $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                $selected_store = isset($_GET['store']) ? sanitize_text_field($_GET['store']) : '';

                $coupon_types = isset( $tptheme_option['coupon_types'] ) ? $tptheme_option['coupon_types'] : [];
                $ajax_taxonomy = isset( $tptheme_option['ajax_taxonomy'] ) ? $tptheme_option['ajax_taxonomy'] : [];
                ?>

                <form method="GET" action="<?php echo esc_url(couponis_get_permalink_by_tpl('page-tpl_browse_coupon')); ?>" class="widget-search-coupons">

                    <?php if (empty($coupon_types) || sizeof($coupon_types) > 1): ?>
                        <div class="coupon_types_item_wrapper">

                            <!-- <div class="coupon_types_item">
                                <input type="checkbox" name="type[]" value="" id="check-type-" checked>
                                <label for="check-type-" class="search-type">
                                    <?php // esc_html_e('ALL Coupons', 'couponis') ?>
                                </label>
                            </div> -->

                            <div class=" form-group types-wrap clearfix">
                                <?php if (empty($coupon_types) || in_array('1', $coupon_types)): ?>
                                    <div class="coupon_types_item">
                                        <input type="checkbox" name="type[]" value="1" id="check-type-1" <?php checked(in_array('1', $selected_types)) ?>>
                                        <label for="check-type-1" class="search-type">
                                            <?php esc_html_e('ONLINE CODES', 'couponis') ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <?php if (empty($coupon_types) || in_array('2', $coupon_types)): ?>
                                    <div class="coupon_types_item">
                                        <input type="checkbox" name="type[]" value="2" id="check-type-2" <?php checked(in_array('2', $selected_types)) ?>>
                                        <label for="check-type-2" class="search-type">
                                            <?php esc_html_e('STORE CODES', 'couponis') ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <?php if (empty($coupon_types) || in_array('3', $coupon_types)): ?>
                                    <div class="coupon_types_item">
                                        <input type="checkbox" name="type[]" value="3" id="check-type-3" <?php checked(in_array('3', $selected_types)) ?>>
                                        <label for="check-type-3" class="search-type">
                                            <?php esc_html_e('ONLINE SALES', 'couponis') ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endif; ?>

                    <div class="form-group coupon-input-style">
                        <label for="keyword"><?php esc_html_e('Keyword', 'couponis') ?></label>
                        <input type="text" id="keyword" name="keyword" placeholder="Type Keywords" class="form-control coupon-input-style-input" value="<?php echo esc_attr($keyword ?? '') ?>" />
                    </div>

                    <div class="form-group coupon-input-style">
                        <label for="category"><?php esc_html_e('Category', 'couponis') ?></label>
                        <div class="styled-select select2-styled ">
                            <select name="category" id="category" class="coupon-input-style-input <?php echo isset( $ajax_taxonomy ) && $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-category">
                                <option value=""><?php esc_html_e( 'Select Category', 'couponis' ) ?></option>
                                <?php
                                if( isset( $ajax_taxonomy ) && $ajax_taxonomy == 'yes' ){
                                    if( !empty( $category ) ){
                                        $term = get_term_by( 'id', $category, 'coupon-category' );
                                        if ( $term ) {
                                            ?>
                                            <option value="<?php echo esc_attr( $term->term_id ); ?>" selected="selected"><?php echo esc_html( $term->name ); ?></option>
                                            <?php
                                        }
                                    }
                                } else {
                                    $categories = get_terms( array(
                                        'taxonomy' => 'coupon-category',
                                        'orderby'  => 'name',
                                        'hide_empty' => false, // Show even empty terms
                                    ));

                                    if( !is_wp_error( $categories ) && !empty( $categories ) ){
                                        foreach( $categories as $category_term ){
                                            ?>
                                            <option value="<?php echo esc_attr( $category_term->term_id ); ?>" <?php selected( $category, $category_term->term_id ); ?>>
                                                <?php echo esc_html( $category_term->name ); ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group coupon-input-style">
                        <label for="store"><?php esc_html_e('Store', 'couponis') ?></label>
                        <div class="styled-select select2-styled">
                            <select name="store" id="store" class="coupon-input-style-input <?php echo isset( $ajax_taxonomy ) && $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-store">
                                <option value=""><?php esc_html_e( 'Select Store', 'couponis' ) ?></option>
                                <?php
                                if( isset( $ajax_taxonomy ) && $ajax_taxonomy == 'yes' ){
                                    if( !empty( $store ) ){
                                        $term = get_term_by( 'id', $store, 'coupon-store' );
                                        if ( $term ) {
                                            ?>
                                            <option value="<?php echo esc_attr( $term->term_id ); ?>" selected="selected"><?php echo esc_html( $term->name ); ?></option>
                                            <?php
                                        }
                                    }
                                } else {
                                    $stores = get_terms( array(
                                        'taxonomy' => 'coupon-store',
                                        'orderby'  => 'name',
                                        'hide_empty' => false, // Show even empty terms
                                    ));

                                    if( !is_wp_error( $stores ) && !empty( $stores ) ){
                                        foreach( $stores as $store_term ){
                                            ?>
                                            <option value="<?php echo esc_attr( $store_term->term_id ); ?>" <?php selected( $store, $store_term->term_id ); ?>>
                                                <?php echo esc_html( $store_term->name ); ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn submit-form"><?php esc_html_e('FILTER COUPON', 'couponis') ?></button>
                </form>
            </div>
        </div>
        <?php

    }
}
