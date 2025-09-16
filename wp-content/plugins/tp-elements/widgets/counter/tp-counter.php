<?php
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Global_Colors;


defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Counter_Widget extends \Elementor\Widget_Base {
	
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
		return 'tp-counter';
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
		return esc_html__( 'TP Counter', 'tp-elements' );
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
		return 'glyph-icon flaticon-count';
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
		return [ 'counter' ];
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
			'section_counter',
			[
				'label' => esc_html__( 'Counter', 'tp-elements' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Select Counter Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'tp-elements'),
					'style2' => esc_html__( 'Style 2', 'tp-elements'),
					'style3' => esc_html__( 'Style 3', 'tp-elements'),

				],
			]
		);
		
		$this->add_control(
			'enable_hover_effect',
			[
				'label' => esc_html__( 'Enable Hover Effect?', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
		    'wrapper_width',
		    [
		        'label' => esc_html__( 'Counter Width', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 500,
		            ],
		            '%' => [
		                'min' => 1,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-top-area' => 'width: {{SIZE}}{{UNIT}};',
		        ],
				'condition' => [
					'enable_hover_effect' => ['yes']
				],
		    ]
		);
		$this->add_responsive_control(
		    'wrapper_height',
		    [
		        'label' => esc_html__( 'Counter Height', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 500,
		            ],
		            '%' => [
		                'min' => 1,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-top-area' => 'height: {{SIZE}}{{UNIT}};',
		        ],
				'condition' => [
					'enable_hover_effect' => ['yes']
				],
		    ]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Counter Number', 'tp-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Number Prefix', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Prefix', 'tp-elements' ),
				'separator' => 'before',
			]
			
		);

		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Number Suffix', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 'Suffix',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Counter Title', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Happy Clients', 'tp-elements' ),
				'placeholder' => esc_html__( 'Clients', 'tp-elements' ),
				'separator' => 'before',
			]
			
		);

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Counter Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__( 'On the other hand we denounce', 'tp-elements' ),
				'separator' => 'before',
				'condition' => ['style' => ['style1', 'style2', 'style3']],
			]
			
		);

		$this->add_control(
			'icon_type',
			[
				'label'   => esc_html__( 'Select Icon Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',			
				'options' => [					
					'icon' => esc_html__( 'Icon', 'tp-elements'),
					'image' => esc_html__( 'Image', 'tp-elements'),
								
				],
				'condition' => [
					'style' => ['style1', 'style2', 'style3']
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Select Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,			
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
				
				'condition' => [
					'icon_type' => 'icon',
				],
				
			]
		);

		$this->add_control(
			'selected_image',
			[
				'label' => esc_html__( 'Choose Image', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				
				'condition' => [
					'icon_type' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'custom_css_filters',
				'selector' => '{{WRAPPER}} .counter-top-area:hover .counter-icon img',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_responsive_control(
            'align',
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
                    '{{WRAPPER}} .counter-top-area' => 'text-align: {{VALUE}}'
                ],                
				'separator' => 'before',
				'condition' => [
					'style' => ['style1', 'style3','style5'],
				],
            ]
        );

        $this->add_responsive_control(
            'align2',
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
                    '{{WRAPPER}} .rs-counter-list' => 'justify-content: {{VALUE}}'
                ],                
				'separator' => 'before',
				'condition' => [
					'style' => 'style2',
				],
            ]
        );

		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_item',
			[
				'label' => esc_html__( 'Item', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .counter-top-area.box-style' => 'background: {{VALUE}};',
					'{{WRAPPER}} .counter-top-area' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_bg_hover_color',
			[
				'label' => esc_html__( 'Background Hover Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .counter-top-area.box-style:hover::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .counter-top-area:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'item_padding',
		    [
		    	'label' => esc_html__( 'Padding', 'tp-elements' ),
		    	'type' => Controls_Manager::DIMENSIONS,
		    	'size_units' => [ 'px', 'em', '%' ],
		    	'selectors' => [
		    	    '{{WRAPPER}} .counter-top-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		    	],
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => esc_html__( 'Number', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .count-number span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .counter-top-area:hover .count-number span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
            'show_background',
            [
				'label'        => esc_html__( 'Show Text Background', 'tp-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tp-elements' ),
				'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',				
            ]
        );

         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_bg_color',
                'label' => esc_html__( 'Text Background Color', 'tp-elements' ),
                'types' => [ 'gradient' ],
                'exclude' => [ 'classic','image' ],             
				'selector' => '{{WRAPPER}} .counter-top-area.yes .rs-counter-list .count-text .rs-counter',
				'condition' => [
					'show_background' => 'yes',
				],
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                ],
                
            ]
        ); 

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => esc_html__( 'Typography', 'tp-elements' ),
				'name' => 'typography_number',
				'selector' => '{{WRAPPER}} .count-number span',
			]
		);

		$this->add_control(
		    'number_top_spacing',
		    [
		    	'label' => esc_html__( 'Padding', 'tp-elements' ),
		    	'type' => Controls_Manager::DIMENSIONS,
		    	'size_units' => [ 'px', 'em', '%' ],
		    	'selectors' => [
		    	    '{{WRAPPER}} .count-number span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		    	],
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => esc_html__( 'Sufix Typography', 'tp-elements' ),
				'name' => 'typography_suffix',
				'selector' => '{{WRAPPER}} .count-number span.suffix',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => esc_html__( 'Prefix Typography', 'tp-elements' ),
				'name' => 'typography_prefix',
				'selector' => '{{WRAPPER}} .count-number span.prefix',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'number_stroke',
				'selector' => '{{WRAPPER}} .count-text .rs-counter, .count-number span.prefix, .count-number span.suffix',
			]
		);
		$this->add_control(
			'number_hover_stroke_color',
			[
				'label' => esc_html__( 'Hover Stroke Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [					
					'{{WRAPPER}} .counter-top-area:hover .rs-counter' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .counter-top-area:hover .rs-counter, .counter-top-area:hover span.prefix, .counter-top-area:hover span.suffix' => '-webkit-text-stroke-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
				[
					'label' => esc_html__( 'Title', 'tp-elements' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'tp-elements' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .count-text .title' => 'color: {{VALUE}};',
						'{{WRAPPER}} .counter-top-area.style3 .tps-counter-list .text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'tp-elements' ),
					'type' => Controls_Manager::COLOR,				
					'selectors' => [
						'{{WRAPPER}} .counter-top-area:hover .count-text .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_title',				
					'selector' => '{{WRAPPER}} .count-text .title',
				]
			);

			$this->add_control(
			    'counter_title',
			    [
			    	'label' => esc_html__( 'Padding', 'tp-elements' ),
			    	'type' => Controls_Manager::DIMENSIONS,
			    	'size_units' => [ 'px', 'em', '%' ],
			    	'selectors' => [
			    	    '{{WRAPPER}} .counter-top-area .tps-counter-list .count-text .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    	  
			    	],
			    ]
			);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_content',
				[
					'label' => esc_html__( 'Content', 'tp-elements' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			

			$this->add_responsive_control(
			    'counter_title_content',
			    [
			    	'label' => esc_html__( 'Padding', 'tp-elements' ),
			    	'type' => Controls_Manager::DIMENSIONS,
			    	'size_units' => [ 'px', 'em', '%' ],
			    	'selectors' => [
			    	    '{{WRAPPER}} .counter-top-area.style2 .tps-counter-list .count-text .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

			    	],
			    ]
			);

			$this->add_responsive_control(
			    'counter_title_content_margin',
			    [
			    	'label' => esc_html__( 'Margin', 'tp-elements' ),
			    	'type' => Controls_Manager::DIMENSIONS,
			    	'size_units' => [ 'px', 'em', '%' ],
			    	'selectors' => [
			    	    '{{WRAPPER}} .counter-top-area.style2 .tps-counter-list .count-text .text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    	],
			    ]
			);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_text',
				[
					'label' => esc_html__( 'Text', 'tp-elements' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'text_color',
				[
					'label' => esc_html__( 'Color', 'tp-elements' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .count-text .text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'text_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'tp-elements' ),
					'type' => Controls_Manager::COLOR,				
					'selectors' => [
						'{{WRAPPER}} .counter-top-area:hover .count-text .text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_text',				
					'selector' => '{{WRAPPER}} .count-text .text',
					'condition' => ['style' => ['style1', 'style2']],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_text_style3',				
					'selector' => '{{WRAPPER}} .counter-top-area.style3 .tps-counter-list .text',
					'condition' => ['style' => ['style3']],
				]
			);

			$this->add_control(
			    'counter_text',
			    [
			    	'label' => esc_html__( 'Padding', 'tp-elements' ),
			    	'type' => Controls_Manager::DIMENSIONS,
			    	'size_units' => [ 'px', 'em', '%' ],
			    	'selectors' => [
			    	    '{{WRAPPER}} .counter-top-area .rs-counter-list .count-text .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    	],
			    ]
			);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon/Image', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

				$this->add_responsive_control(
		            'icon_align',
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
		                    '{{WRAPPER}} .counter-icon' => 'text-align: {{VALUE}}'
		                ],                
						'separator' => 'before',
		            ]
		        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => esc_html__( 'Typography', 'tp-elements' ),
				'name' => 'typography_icon',				
				'selector' => '{{WRAPPER}} .counter-icon i',
		        'condition' => [
		            'icon_type' => 'icon'
		        ]
			]
		);

		$this->add_responsive_control(
		    'icon_width',
		    [
		        'label' => esc_html__( 'Icon/Image Part Width', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 400,
		            ],
		            '%' => [
		                'min' => 1,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon svg' => 'width: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .counter-icon i' => 'width: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .counter-icon img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'icon_height',
		    [
		        'label' => esc_html__( 'Icon/Image Part Height', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 400,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon svg' => 'height: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .counter-icon i' => 'height: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .counter-icon img' => 'height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'icon_line_height',
		    [
		        'label' => esc_html__( 'Icon/Image Part Line Height', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 400,
		            ],
		            '%' => [
		                'min' => 1,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon, {{WRAPPER}} .counter-icon i, {{WRAPPER}} .counter-icon svg' => 'line-height: {{SIZE}}{{UNIT}};',
		        ],              
		    ]
		);		


		$this->add_responsive_control(
		    'image_width',
		    [
		        'label' => esc_html__( 'Image Width', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 400,
		            ],
		            '%' => [
		                'min' => 1,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
                'condition' => [
                  'icon_type' => 'image'
                ],
		    ]
		);

		$this->add_responsive_control(
		    'image_height',
		    [
		        'label' => esc_html__( 'Image Height', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 400,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon img' => 'height: {{SIZE}}{{UNIT}};',
		        ],
                'condition' => [
                  'icon_type' => 'image'
                ],
		    ]
		);

		$this->add_responsive_control(
		    'icon_padding',
		    [
		        'label' => esc_html__( 'Icon Part Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'icon_margin',
		    [
		        'label' => esc_html__( 'Icon Part Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->start_controls_tabs( 'back_part_btn_tabs' );

		    $this->start_controls_tab(
		        'icon_tabs_normal',
		        [
		            'label' => esc_html__( 'Normal', 'tp-elements' ),
		        ]
		    );
		    	$this->add_group_control(
		    	    Group_Control_Border::get_type(),
		    	    [
		    	        'name' => 'icon_part_border',
		    	        'selector' => '{{WRAPPER}} .counter-icon',
		    	    ]
		    	);

				$this->add_control(
				    'icon_part_border_radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

		    	$this->add_group_control(
		    	    Group_Control_Box_Shadow::get_type(),
		    	    [
		    	        'name' => 'icon_part_box_shadow',
		    	        'selector' => '{{WRAPPER}} .counter-icon',
		    	    ]
		    	);

				$this->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'tp-elements' ),
						'type' => Controls_Manager::COLOR,				
						'selectors' => [
							'{{WRAPPER}} .counter-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .counter-icon svg path' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'icon_part_bg',
				        'label' => esc_html__( 'Background', 'tp-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .counter-icon',
				    ]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
			    'icon_tabs_hover',
			    [
			        'label' => esc_html__( 'Hover', 'tp-elements' ),
			    ]
			);
				$this->add_group_control(
				    Group_Control_Border::get_type(),
				    [
				        'name' => 'icon_part_hover_border',
				        'selector' => '{{WRAPPER}} .counter-top-area:hover .counter-icon',
				    ]
				);

				$this->add_control(
				    'icon_part_hover_border_radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .counter-top-area:hover .counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'icon_part_hover_box_shadow',
				        'selector' => '{{WRAPPER}} .counter-top-area:hover .counter-icon',
				    ]
				);

				$this->add_control(
					'icon_hover_color',
					[
						'label' => esc_html__( 'Icon Hover Color', 'tp-elements' ),
						'type' => Controls_Manager::COLOR,				
						'selectors' => [
							'{{WRAPPER}} .counter-top-area:hover .counter-icon i' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'icon_part_hover_bg',
				        'label' => esc_html__( 'Background', 'tp-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .counter-icon',
				    ]
				);

		    $this->end_controls_tab();
		$this->end_controls_tab();
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
		$this->add_inline_editing_attributes( 'suffix', 'basic' );
	    $this->add_render_attribute( 'suffix', 'class', 'suffix' );	

	    $this->add_inline_editing_attributes( 'number', 'basic' );
	    $this->add_render_attribute( 'number', 'class', 'rs-counter' );

	    $this->add_inline_editing_attributes( 'prefix', 'basic' );
	    $this->add_render_attribute( 'prefix', 'class', 'prefix' );	

	    $this->add_inline_editing_attributes( 'title', 'basic' );
	    $this->add_render_attribute( 'title', 'class', 'title' );    	

		?>
		<div class="counter-top-area <?php if( $settings['enable_hover_effect'] == 'yes' ) : ?> box-style position-relative <?php endif; ?> <?php echo esc_attr($settings['show_background']);?> <?php echo esc_attr( $settings['style']);?>">
		    <div class="tps-counter-list ">
				<?php if($settings['style'] == 'style3') : ?>
				<div class="tps-counter-list-inner"> 
				<?php endif; ?>		
					<?php if( !empty($settings['selected_icon']) || !empty($settings['selected_image']['url'])){?>
					<div class="counter-icon">
						<?php if(!empty($settings['selected_icon'])) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif; ?>

						<?php if(!empty($settings['selected_image'])) :?>
							<img src="<?php echo esc_url($settings['selected_image']['url']);?>" alt="image"/>
						<?php endif;?>
					</div>	
					<?php }?>
							
					<div class="count-text">
						<div class="count-number">
							<?php if($settings['suffix']) :?><span class="suffix"><?php echo esc_html($settings['suffix']);?></span><?php endif; ?>
								<span data-letters="500" class="rs-counter"> <?php echo esc_html($settings['number']);?></span>
							<?php if($settings['prefix']) :?><span class="prefix"><?php echo esc_html($settings['prefix']);?></span><?php endif; ?>
						</div>

						<?php if(!empty($settings['title'])) : ?>
							<span class="title">  <?php echo esc_html($settings['title']);?></span>	
						<?php endif; ?>	

						<?php if(!empty($settings['text']) && $settings['style'] == 'style2' || $settings['style'] == 'style1' ) : ?>
							<div class="text">  <?php echo esc_html($settings['text']);?></div>	
						<?php endif; ?>	

					</div>
				<?php if($settings['style'] == 'style3') : ?> 
				</div>
				<?php endif; ?>

				<?php if(!empty($settings['text']) && $settings['style'] == 'style3' ) : ?>
				<div class="text">  <?php echo esc_html($settings['text']);?></div>	
				<?php endif; ?>	
			</div>
		</div>	
		
	<?php
	}
}
