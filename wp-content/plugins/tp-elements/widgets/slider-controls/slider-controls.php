<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Slider_Controls_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve counter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tp-slider-controls';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve counter widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'TP Slider Controls', 'tp-elements' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-error';
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_categories() {
        return [ 'pielements_category' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'slider-controls' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_slider_controls',
			[
				'label' => esc_html__( 'Slider Navigation', 'tp-elements' ),
			]
		);				

		$this->add_control(
            'slider_previous_navigation',
            [
                'label' => esc_html__( 'Slider Previous Navigation', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

		$this->add_control(
			'nav_prev_icon_type',
			[
				'label'   => esc_html__( 'Selec Previous Icon Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'prev_icon',			
				'options' => [					
					'prev_icon' => esc_html__( 'Icon', 'tp-elements'),
					'prev_image' => esc_html__( 'Image', 'tp-elements'),
								
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nav_prev_icon',
			[
				'label'     => esc_html__( 'Previous Icon', 'tp-elements' ),
				'type'      => Controls_Manager::ICONS,				
				'default' => [
					'value' => 'fa fa-arrow-left',
					'library' => 'solid',
				],
				'separator' => 'before',
				'condition' => [
					'nav_prev_icon_type' => 'prev_icon',
				],				
			]
		);

		$this->add_control(
			'nav_prev_image',
			[
				'label' => esc_html__( 'Choose Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				
				'condition' => [
					'nav_prev_icon_type' => 'prev_image',
				],
				'separator' => 'before',
			]
		);
		
		
		$this->add_control(
            'slider_next_navigation',
            [
                'label' => esc_html__( 'Slider Next Navigation', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

		$this->add_control(
			'nav_next_icon_type',
			[
				'label'   => esc_html__( 'Selec Next Icon Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'next_icon',			
				'options' => [					
					'next_icon' => esc_html__( 'Icon', 'tp-elements'),
					'next_image' => esc_html__( 'Image', 'tp-elements'),
								
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nav_next_icon',
			[
				'label'     => esc_html__( 'Next Icon', 'tp-elements' ),
				'type'      => Controls_Manager::ICONS,				
				'default' => [
					'value' => 'fa fa-arrow-right',
					'library' => 'solid',
				],
				'separator' => 'before',
				'condition' => [
					'nav_next_icon_type' => 'next_icon',
				],				
			]
		);

		$this->add_control(
			'nav_next_image',
			[
				'label' => esc_html__( 'Next Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				
				'condition' => [
					'nav_next_icon_type' => 'next_image',
				],
				'separator' => 'before',
			]
		);
		

		$this->end_controls_section();


		$this->start_controls_section(
		    '_section_style_slider_controls',
		    [
		        'label' => esc_html__( 'Sldier Controls', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nav_icon_typography',
                'label' => esc_html__( 'Icon Typography', 'tp-elements' ),
                'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div span i',
                'separator'   => 'before',
            ]
        );

		
        $this->add_responsive_control(
            'navigation_alignment',
            [
                'label' => esc_html__( 'Navigation Alignment', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Left', 'tp-elements' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tp-elements' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Right', 'tp-elements' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

	
        $this->start_controls_tabs( '_tabs_nav_prev' );

		$this->start_controls_tab(
            'nav_prev_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
            ]
        ); 

		$this->add_responsive_control(
            'nav_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nav_border',
                'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_box_shadow',
                'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div',
            ]
        ); 

        $this->add_responsive_control(
            'nav_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
                ],               
            ]
        );

        $this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'nav_bg_color',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div',
			]
		);
		$this->add_control(
		    'nav_icon_color',
		    [
		        'label' => esc_html__( 'Icon Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .tp-slider-controls-navigation > div .tp-nav-icon i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'nav_hover_tab',
            [
                'label' => esc_html__( 'Nav Hover', 'tp-elements' ),
            ]
        ); 

        $this->add_responsive_control(
            'nav_hover_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_hover_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nav_hover_border',
                'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_hover_box_shadow',
                'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div:hover',
            ]
        ); 

        $this->add_responsive_control(
            'nav_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-controls-navigation > div:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
                ],               
            ]
        );

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'nav_hover_bg_color',
				'label' => esc_html__( 'Hover Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-slider-controls-navigation > div:hover',
			]
		);
		$this->add_control(
		    'nav_icon_hover_color',
		    [
		        'label' => esc_html__( 'Icon Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .tp-slider-controls-navigation > div:hover .tp-nav-icon i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Button', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
            'btn_style',
            [
                'label' => esc_html__( 'Button Style', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
		    'btn_width',
		    [
		        'label' => esc_html__( 'Width', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cta .rs-button' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
            'btn_position',
            [
                'label' => esc_html__( 'Position', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
				'default' => '14',
                'options' => [
                    '-2' => esc_html__( 'Left', 'tp-elements'),
					'14' => esc_html__( 'Right', 'tp-elements'),
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rs-cta .rs-button' => 'order: {{VALUE}};'
                ],
				'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn_align',
            [
                'label' => esc_html__( 'Alignment', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Left', 'tp-elements' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tp-elements' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Right', 'tp-elements' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'tp-elements' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rs-cta .rs-button' => 'text-align: {{VALUE}}'
                ]
            ]
        );

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
            ]
        ); 

		$this->add_control(
		    'btn_text_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background_normal',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rs-button a',
			]
		);

		$this->add_control(
            'btn_opacity',
            [
                'label' => esc_html__( 'Opacity', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-button a' => 'opacity: {{SIZE}};',
                ],
            ]
        );

		$this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'link_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .rs-button a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .rs-button a',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .rs-button a',
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'tp-elements' ),
            ]
        ); 

		$this->add_control(
		    'btn_text_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .rs-cta:hover .rs-button a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rs-cta:hover .rs-button a',
			]
		);

		$this->add_control(
            'btn_hover_opacity',
            [
                'label' => esc_html__( 'Opacity', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-button:hover a' => 'opacity: {{SIZE}};',
                ],
            ]
        );

		$this->add_responsive_control(
		    'link_hover_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cta:hover .rs-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'link_hover_margin',
		    [
                'label'      => esc_html__( 'Margin', 'tp-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cta:hover .rs-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
                'name'     => 'btn_hover_typography',
                'selector' => '{{WRAPPER}} .rs-cta:hover .rs-button a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
                'name'     => 'button_hover_border',
                'selector' => '{{WRAPPER}} .rs-cta:hover .rs-button a',
		    ]
		);

		$this->add_control(
		    'button_hover_border_radius',
		    [
                'label'      => esc_html__( 'Border Radius', 'tp-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cta:hover .rs-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .rs-cta:hover .rs-button a',
		    ]
		);

		$this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'tp-elements' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->add_control(
            'btn_icon_style',
            [
                'label'     => esc_html__( 'Button Icon', 'tp-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_icon' => 'yes'
                ],
            ]
        );

		$this->start_controls_tabs( '_tabs_button_icon' );

		$this->start_controls_tab(
            'btn_icon_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
                'condition' => [
                    'show_icon' => 'yes'
                ],
            ]
        ); 

		$this->add_control(
		    'btn_icon_spacing',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 10
		        ],
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		        'condition' => [
					'show_icon' => 'yes',
				],	
		    ]
		);


		$this->add_control(
		    'icon_text_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a i' => 'color: {{VALUE}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->add_control(
		    'icon_background',
		    [
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .rs-button a i' => 'background: {{VALUE}};',],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
			]
		);

		$this->add_responsive_control(
		    'icon_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->add_control(
		    'icon_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button a i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'btn_icon_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'tp-elements' ),
                'condition' => [
                    'show_icon' => 'yes'
                ],
            ]
        ); 

		$this->add_control(
		    'btn_icon_hover_spacing',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 10
		        ],
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		        'condition' => [
					'show_icon' => 'yes',
				],	
		    ]
		);

		$this->add_control(
		    'icon_hover_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .rs-button:hover a i' => 'color: {{VALUE}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->add_control(
		    'icon_hover_background',
		    [				
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .rs-button:hover a i'=> 'background: {{VALUE}};',],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
			]
		);

		$this->add_responsive_control(
		    'icon_hover_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button:hover a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->add_control(
		    'icon_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-button:hover a i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
	            'condition' => [
	                'show_icon' => 'yes'
	            ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		

		$this->end_controls_section();

	}

	/**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {	
	
	$settings = $this->get_settings_for_display();

	?>
	
		<style>
		.tp-slider-controls-navigation{
			display: flex;
		}
		.tp-banner-slide-prev {
			display: inline-block;
			position: relative;
			z-index: 1;
		}
		.tp-banner-slide-next {
			display: inline-block;
			position: relative;
			z-index: 1;
		}

		</style>
		<div class="tp-slider-controls-navigation">

			<?php if( !empty($settings['nav_prev_icon']) || !empty($settings['nav_prev_image']['url']) ){?>
			<div class="tp-banner-slide-prev">
				<?php if(!empty($settings['nav_prev_image'])) :?>
				<img src="<?php echo esc_url($settings['nav_prev_image']['url']);?>" class="tp-nav-img">
				<?php else : ?>
				<span class="tp-nav-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
			</div>
			<?php }?>

			<?php if( !empty($settings['nav_next_icon']) || !empty($settings['nav_next_image']['url']) ){?>
			<div class="tp-banner-slide-next">
				<?php if(!empty($settings['nav_next_image'])) :?>
				<img src="<?php echo esc_url($settings['nav_next_image']['url']);?>" class="tp-nav-img">
				<?php else : ?>
				<span class="tp-nav-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['nav_next_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
			</div>
			<?php }?> 
 
		</div>
	<?php 
	}
}