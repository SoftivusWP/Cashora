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
class Pixelaxis_Search_Button extends Widget_Base {
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
        return 'hfe-search-button';
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
        return __( 'TP HFE Search', 'tp-elements');
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
        return 'eicon-search';
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
        return [ 'header_footer_category' ];
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
                'label' => __( 'Search Box', 'tp-elements'),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'        => __( 'Layout', 'tp-elements'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'text',
                'options'      => [
                    'text'      => __( 'Input Box', 'tp-elements'),
                    'icon'      => __( 'Icon', 'tp-elements'),
                    'icon_text' => __( 'Input Box With Button', 'tp-elements'),
                    'icon_flip' => __( 'Flip Icon', 'tp-elements'),
                ],
                'prefix_class' => 'hfe-search-layout-',
                'render_type'  => 'template',
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label'     => __( 'Placeholder', 'tp-elements'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Type & Hit Enter', 'tp-elements') . '...',
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_responsive_control(
            'size',
            [
                'label'              => __( 'Size', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => [
                    'size' => 50,
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-search-form__container' => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .hfe-search-submit'      => 'min-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .hfe-search-form__input' => 'padding-left: calc({{SIZE}}{{UNIT}} / 5); padding-right: calc({{SIZE}}{{UNIT}} / 5)',
                ],
                'condition'          => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
                'render_type'        => 'template',
                'frontend_available' => true,
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
            'section_input_style',
            [
                'label' => __( 'Input', 'tp-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,                

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} input[type="search"].hfe-search-form__input,{{WRAPPER}} .hfe-search-icon-toggle',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'input_icon_size',
            [
                'label'              => __( 'Width', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => [
                    'size' => 250,
                ],
                'range'              => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle input[type=search]' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'          => [
                    'layout' => ['icon', 'icon_flip'],
                ],
                'frontend_available' => true,
            ]
        );

        $this->start_controls_tabs( 'tabs_input_colors' );

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label'     => __( 'Normal', 'tp-elements'),
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => __( 'Text Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__input' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => __( 'Placeholder Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__input::placeholder' => 'color: {{VALUE}}',
                ],
                'default'   => '#7A7A7A6B',
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label'     => __( 'Background Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ededed',
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__input, {{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .hfe-search-icon-toggle .hfe-search-form__input' => 'background-color: transparent;',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'input_box_shadow',
                'selector'  => '{{WRAPPER}} .hfe-search-form__container,{{WRAPPER}} input.hfe-search-form__input',
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );
        $this->add_control(
            'border_style',
            [
                'label'       => __( 'Border Style', 'tp-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'none',
                'label_block' => false,
                'options'     => [
                    'none'   => __( 'None', 'tp-elements'),
                    'solid'  => __( 'Solid', 'tp-elements'),
                    'double' => __( 'Double', 'tp-elements'),
                    'dotted' => __( 'Dotted', 'tp-elements'),
                    'dashed' => __( 'Dashed', 'tp-elements'),
                ],
                'selectors'   => [
                    '{{WRAPPER}} .hfe-search-form__container ,{{WRAPPER}} .hfe-search-icon-toggle .hfe-search-form__input,{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-style: {{VALUE}};',
                ],
                'condition'   => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => __( 'Border Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'condition' => [
                    'border_style!' => 'none',
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .hfe-search-icon-toggle .hfe-search-form__input,{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label'      => __( 'Border Width', 'tp-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [
                    'top'    => '1',
                    'bottom' => '1',
                    'left'   => '1',
                    'right'  => '1',
                    'unit'   => 'px',
                ],
                'condition'  => [
                    'border_style!' => 'none',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .hfe-search-icon-toggle .hfe-search-form__input,{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'     => __( 'Border Radius', 'tp-elements'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'   => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .hfe-search-icon-toggle .hfe-search-form__input,{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label'     => __( 'Focus', 'tp-elements'),
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_text_color_focus',
            [
                'label'     => __( 'Text Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__input:focus,
                    {{WRAPPER}} .tps-search-button-wrapper input[type=search]:focus' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_hover_color',
            [
                'label'     => __( 'Placeholder Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__input:focus::placeholder' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_background_color_focus',
            [
                'label'     => __( 'Background Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__input:focus,
                    {{WRAPPER}}.hfe-search-layout-icon .hfe-search-icon-toggle .hfe-search-form__input' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'input_box_shadow_focus',
                'selector'       =>
                '{{WRAPPER}} .tps-search-button-wrapper.hfe-input-focus .hfe-search-form__container,
                 {{WRAPPER}} .tps-search-button-wrapper.hfe-input-focus input.hfe-search-form__input',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'input_border_color_focus',
            [
                'label'     => __( 'Border Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__container,
                     {{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'icon_text_color_focus',
            [
                'label'     => __( 'Text Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__input:focus' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout' => ['icon', 'icon_flip'],
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_text_background_color_focus',
            [
                'label'     => __( 'Background Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ededed',
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__input:focus' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'layout' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'icon_box_shadow_focus',
                'selector'       =>
                '{{WRAPPER}} .tps-search-button-wrapper.hfe-input-focus .hfe-search-form__container,
                 {{WRAPPER}} .tps-search-button-wrapper.hfe-input-focus input.hfe-search-form__input',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'layout' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'icon_border_style',
            [
                'label'       => __( 'Border Style', 'tp-elements'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'none',
                'label_block' => false,
                'options'     => [
                    'none'   => __( 'None', 'tp-elements'),
                    'solid'  => __( 'Solid', 'tp-elements'),
                    'double' => __( 'Double', 'tp-elements'),
                    'dotted' => __( 'Dotted', 'tp-elements'),
                    'dashed' => __( 'Dashed', 'tp-elements'),
                ],
                'selectors'   => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-style: {{VALUE}};',
                ],
                'condition'   => [
                    'layout' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_focus',
            [
                'label'     => __( 'Border Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-form__container,
                     {{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'layout'             => ['icon', 'icon_flip'],
                    'icon_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label'      => __( 'Border Width', 'tp-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [
                    'top'    => '1',
                    'bottom' => '1',
                    'left'   => '1',
                    'right'  => '1',
                    'unit'   => 'px',
                ],
                'condition'  => [
                    'icon_border_style!' => 'none',
                    'layout'             => ['icon', 'icon_flip'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_focus_border_radius',
            [
                'label'     => __( 'Border Radius', 'tp-elements'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'   => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .hfe-input-focus .hfe-search-icon-toggle .hfe-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'layout' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label'     => __( 'Button', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'icon_text',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_colors' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'tp-elements'),
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label'     => __( 'Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} button.hfe-search-submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'button_background',
                'label'          => __( 'Background', 'tp-elements'),
                'types'          => [ 'classic', 'gradient' ],
                'exclude'        => [ 'image' ],
                'selector'       => '{{WRAPPER}} .hfe-search-submit',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color'      => [
                        'default' => '#818a91',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'tp-elements'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'     => __( 'Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label'     => __( 'Background Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-submit:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'button_background_color_hover!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_background_hover',
                'label'     => __( 'Background', 'tp-elements'),
                'types'     => [ 'classic', 'gradient' ],
                'exclude'   => [ 'image' ],
                'selector'  => '{{WRAPPER}} .hfe-search-submit:hover',
                'condition' => [
                    'button_background_color_hover' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label'              => __( 'Icon Size', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => '16',
                    'unit' => 'px',
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-search-submit' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition'          => [
                    'layout!' => ['icon', 'icon_flip'],
                ],
                'separator'          => 'before',
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'              => __( 'Width', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max'  => 500,
                        'step' => 5,
                    ],
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-search-form__container .hfe-search-submit' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .hfe-close-icon-yes button#clear_with_button' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition'          => [
                    'layout' => 'icon_text',
                ],
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style',
            [
                'label'     => __( 'Icon', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['icon', 'icon_flip'],
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_toggle_color' );

        $this->start_controls_tab(
            'tab_toggle_normal',
            [
                'label' => __( 'Normal', 'tp-elements'),
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-icon-toggle i' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'icon_box_border',
		        'selector' => '{{WRAPPER}} .tps-search-button-wrapper .sticky_search',
		    ]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_toggle_hover',
            [
                'label' => __( 'Hover', 'tp-elements'),
            ]
        );

        $this->add_control(
            'toggle_color_hover',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-icon-toggle i:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search i:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'icon_box_hover_border',
		        'selector' => '{{WRAPPER}} .tps-search-button-wrapper .sticky_search:hover',
		    ]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

       
        $this->add_responsive_control(
            'toggle_icon_size',
            [
                'label'              => __( 'Icon Size', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => [
                    'size' => 15,
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-search-icon-toggle input[type=search]' => 'padding: 0 calc( {{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .hfe-search-icon-toggle i.fa-search:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .hfe-search-icon-toggle i.fa-search, {{WRAPPER}} .hfe-search-icon-toggle' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search i' => 'font-size: {{SIZE}}{{UNIT}};',

                ],
                'condition'          => [
                    'layout' => ['icon', 'icon_flip'],
                ],
                'separator'          => 'before',
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );

     
         $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Icon Box width', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search' => 'width: {{SIZE}}{{UNIT}};',
                    
                ],
            ]
        );
          $this->add_control(
            'height',
            [
                'label' => esc_html__( 'Icon Box Height', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [                    
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search' => 'height: {{SIZE}}{{UNIT}};',
                   
                ],
            ]
        );
           $this->add_control(
            'line-height',
            [
                'label' => esc_html__( 'Icon Box Line Height', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .tps-search-button-wrapper .sticky_search' => 'line-height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg',
                'label' => esc_html__( 'Icon Box Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.tps-search-button-wrapper .sticky_search',
            ]
        );  
        
        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__( 'Icon Box Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '.tps-search-button-wrapper .sticky_search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();
        

        $this->start_controls_section(
            'sticky_style_icon_input',
            [
                'label'     => __( 'Sticky Style ', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );


        $this->start_controls_tabs( 'tabs_toggle_sticky_color' );

        $this->start_controls_tab(
            'sticky_tab_toggle_normal',
            [
                'label' => __( 'Normal', 'tp-elements'),
            ]
        );

        $this->add_control(
            'sticky_toggle_color',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}}  .hfe-search-icon-toggle i' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
                    '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'sticky_icon_box_border',
		        'selector' => '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search',
		    ]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sticky_tab_toggle_hover',
            [
                'label' => __( 'Hover', 'tp-elements'),
            ]
        );

        $this->add_control(
            'sticky_toggle_color_hover',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}}  .hfe-search-icon-toggle i:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search i:hover' => 'color: {{VALUE}};',
                    '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'sticky_icon_box_hover_border',
		        'selector' => '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search:hover',
		    ]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'sticy_input_text_color',
            [
                'label'     => __( 'Input Text Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '.tp-sticky {{WRAPPER}}  .hfe-search-form__input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sticky_icon_box_bg',
                'label' => esc_html__( 'Icon Box Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.tp-sticky {{WRAPPER}}  .tps-search-button-wrapper .sticky_search',
            ]
        );  

        $this->end_controls_section();


        $this->start_controls_section(
            'section_wrap_icon',
            [
                'label'     => __( 'Search Popup ', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );

         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'search_background_hover',
                'label'     => __( 'Search Popup Background', 'tp-elements'),
                'types'     => [ 'classic', 'gradient' ],
                'separator'          => 'before',
                'selector'  => '.sticky_form.tps-search-popup',
                
            ]
        );
        $this->end_controls_section();
        

        $this->start_controls_section(
            'section_close_icon',
            [
                'label'     => __( 'Close Icon', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_responsive_control(
            'close_icon_size',
            [
                'label'              => __( 'Size', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'            => [
                    'size' => '20',
                    'unit' => 'px',
                ],
                'selectors'          => [
                    '{{WRAPPER}} .hfe-search-form__container button#clear i:before,
                    
                    {{WRAPPER}} .hfe-search-icon-toggle button#clear i:before,
                   
                {{WRAPPER}} .hfe-search-form__container button#clear-with-button i:before' => 'font-size: {{SIZE}}{{UNIT}};',
                 '.close-search:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'frontend_available' => true,

            ]
        );

        $this->add_responsive_control(
            'close_icon_lineheight',
            [
                'label'              => __( 'Line Height', 'tp-elements'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'            => [
                    'size' => '20',
                    'unit' => 'px',
                ],
                'selectors'          => [
                  
                    '.close-search:before' => 'line-height: {{SIZE}}{{UNIT}};',

                ],
                'frontend_available' => true,

            ]
        );

        $this->start_controls_tabs( 'close_icon_normal' );

        $this->start_controls_tab(
            'normal_close_button',
            [
                'label' => __( 'Normal', 'tp-elements'),
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'default'   => '#7a7a7a',
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__container button#clear-with-button,
                    {{WRAPPER}} .hfe-search-form__container button#clear,
                    {{WRAPPER}} .close-search,
                    {{WRAPPER}} .hfe-search-icon-toggle button#clear' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover_close_icon',
            [
                'label' => __( 'Hover', 'tp-elements'),
            ]
        );

        $this->add_control(
            'hover_close_icon_text',
            [
                'label'     => __( 'Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hfe-search-form__container button#clear-with-button:hover,
                    {{WRAPPER}} .hfe-search-form__container button#clear:hover,
                    {{WRAPPER}} .hfe-search-icon-toggle button#clear:hover' => 'color: {{VALUE}}',
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

        $this->add_render_attribute(
            'input',
            [
                'placeholder' => $settings['placeholder'],
                'class'       => 'hfe-search-form__input',
                'type'        => 'search',
                'name'        => 's',
                'title'       => __( 'Search', 'tp-elements'),
                'value'       => get_search_query(),

            ]
        );

        $this->add_render_attribute(
            'container',
            [
                'class' => [ 'hfe-search-form__container' ],
                'role'  => 'tablist',
            ]
        );
        ?>

        <style>
            .box-style.sticky_search {
                width: 60px;
                overflow: hidden;
                height: 60px;
                position: relative;
                border-radius: 50%;
                text-align: center;
                line-height: 60px;
            }
            .box-style::before {
                content: "";
                position: absolute;
                top: var(--y);
                left: var(--x);
                transform: translate(-50%, -50%);
                width: 0;
                height: 0;
                border-radius: 100%;
                background-color: #592DA8;
                transition: all .7s ease;
                z-index: 1;
            }
            .box-style i {
                transition: all 0.5s ease-in-out;
                display: inline-block;
                position: relative;
                z-index: 1;
            }
            .box-style:hover::before {
                width: 400%;
                height: 400%;
            }
            .box-style:hover i {
                transform: rotateY(180deg);
            }

        </style>

        <form class="tps-search-button-wrapper" action="<?php echo home_url(); ?>" method="get">
            <?php if ( 'icon' === $settings['layout'] ) { ?>
                <?php $text_center = !empty($settings['width']) ? 'text-center' : '';?>
                <div class="sticky_search <?php echo esc_attr( $text_center );?>"> 
                  <i class="tp tp-search"></i> 
                </div>
            <?php } elseif( 'icon_flip' === $settings['layout'] ) { ?>

                <?php $text_center = !empty($settings['width']) ? 'text-center' : '';?>
                <div class="box-style sticky_search <?php echo esc_attr( $text_center );?>"> 
                    <i class="tp tp-search"></i> 
                </div>

            <?php } else { ?>
            <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
                <?php if ( 'text' === $settings['layout'] ) { ?>
                    <input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
                        <button id="clear" type="reset">
                            <i class="fas fa-times clearable__clear" aria-hidden="true"></i>
                        </button>
                <?php } else { ?>
                    <input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
                    <!-- <button id="clear-with-button" type="reset">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button> -->
                    <button class="hfe-search-submit" type="submit">
                        <i class="tp tp-search"></i>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>
        </form>

        <?php
    }
}
