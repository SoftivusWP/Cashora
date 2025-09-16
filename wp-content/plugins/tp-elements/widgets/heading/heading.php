<?php
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Heading_Widget extends \Elementor\Widget_Base {

/*
	 *
	 * @since 1.0.0 
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tp-heading';
	}		

	/**
	 * Get widget title.
	 *
	 * Retrieve rsgallery widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'TP Heading', 'tp-elements' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve rsgallery widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-letter';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the rsgallery widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return [ 'pielements_category' ];
    }
	 
	/**
	 * Register rsgallery widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Heading Info', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		
		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Select Heading Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'tp-elements'),
					'style1'  => esc_html__( 'Border Right', 'tp-elements'),
					'style2'  => esc_html__( 'Border Bottom', 'tp-elements'),
					'style3'  => esc_html__( 'Border Left', 'tp-elements' ),
					'style4'  => esc_html__( 'Border Top', 'tp-elements' ),					
					'style6'  => esc_html__( 'Border Top Left', 'tp-elements' ),
					'style7'  => esc_html__( 'Border Top Right', 'tp-elements' ),
					'style8'  => esc_html__( 'Boder Left Vertical Style', 'tp-elements' ),
					'style9'  => esc_html__( 'Heading Image Style', 'tp-elements' ),
					'style5'  => esc_html__( 'Heading Bracket Style', 'tp-elements' ),
					'style10' => esc_html__( 'Heading Left Rotate Style', 'tp-elements' ),
					'style11' => esc_html__( 'Heading Right Rotate Style', 'tp-elements' ),
					'style12'  => esc_html__( 'Border Top Left Right', 'tp-elements' ),
					'style13'  => esc_html__( 'Sub Heading Left Right Image', 'tp-elements' ),
					'style14'  => esc_html__( 'Heading with Button', 'tp-elements' ),
					
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Heading Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Heading Style', 'tp-elements' ),				
				'separator' => 'before',
			]
		);

		$this->add_control(
			'enable_stroke',
			[
				'label' => esc_html__( 'Enable Title Stroke', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tp-elements' ),
				'label_off' => esc_html__( 'No', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		);

		$this->add_control(
			'enable_border',
			[
				'label' => esc_html__( 'Enable Title Bottom Border', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tp-elements' ),
				'label_off' => esc_html__( 'No', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Select Heading Tag', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [						
					'h1' => esc_html__( 'H1', 'tp-elements'),
					'h2' => esc_html__( 'H2', 'tp-elements'),
					'h3' => esc_html__( 'H3', 'tp-elements' ),
					'h4' => esc_html__( 'H4', 'tp-elements' ),
					'h5' => esc_html__( 'H5', 'tp-elements' ),
					'h6' => esc_html__( 'H6', 'tp-elements' ),				
					
				],
			]
		);

		$this->add_control(
			'image-left-sub',
			[
				'label' => esc_html__( 'Choose Sub Heading Left Image', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'style' => 'style13',
				],

				'separator' => 'before',
			]
		);

		$this->add_control(
			'image-right-sub',
			[
				'label' => esc_html__( 'Choose Sub Heading Rihgt Image', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'style' => 'style13',
				],

				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'     => esc_html__( 'Sub Heading Text', 'tp-elements' ),
				'type'      => Controls_Manager::TEXT,				
				'default'   => esc_html__( 'Sub Heading', 'tp-elements' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Heading Image', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'style' => 'style9',
				],

				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_postition',
			[
				'label'   => esc_html__( 'Select Image Position', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [						
					'top' => esc_html__( 'Top', 'tp-elements'),
					'bottom' => esc_html__( 'Bottom', 'tp-elements'),						
					
				],
				'condition' => [
					'style' => 'style9',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_postition_width',
			[
				'label' => esc_html__( 'Image With', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size'=> '150',
				],
				'condition' => [
					'style' => 'style9',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .title-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_postition_left_right',
			[
				'label' => esc_html__( 'Image Left/right Position', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					
				],
				'condition' => [
					'style' => 'style9',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .title-img img' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'watermark',
			[
				'label' => esc_html__( 'Watermark Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Watermark', 'tp-elements' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'mark_postition_zindex',
			[
				'label' => esc_html__( 'Watermark Z-Index', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1,
						'max' => 99,
						'step' => 1,
					],
					
				],
				'default' => [
					'unit' => 'px',
					
				],
				
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixelaxis-heading  span.watermark' => 'z-index: {{SIZE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'mark_postition_left_right',
			[
				'label' => esc_html__( 'Watermark Left/right Position', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					
				],
				
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixelaxis-heading  span.watermark' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mark_postition_top_bottom',
			[
				'label' => esc_html__( 'Watermark Top/Bottom Position', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					
				],
				
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixelaxis-heading  span.watermark' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mark_width',
			[
				'label' => esc_html__( 'Watermark Text Custom Width', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					
				],
				
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixelaxis-heading span.watermark' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label'   => esc_html__( 'Description', 'tp-elements' ),
				'type'    => Controls_Manager::WYSIWYG,
				'rows'    => 10,			
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
                    '{{WRAPPER}} .pixelaxis-heading' => 'text-align: {{VALUE}}'
                ]
            ]
        );


		
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_button',
			[
				'label' => esc_html__( 'Button Info', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				
			]
		);
		$this->add_control(
            'button',
            [
                'label' => esc_html__( 'Button', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

		
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('', 'tp-elements'),				
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label' => esc_html__( ' Button Link', 'tp-elements' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,						
			]
		);

		$this->add_control(
            'show_icon',
            [
                'label' => esc_html__( 'Show Icon', 'tp-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
		

		 $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
                'condition' => [
					'show_icon' => 'yes',
				],	                
            ]
        );

		$this->end_controls_section();

			

		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
	    $this->add_control(
            'title_style',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Title', 'tp-elements' ),
                'separator' => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-heading .title',
			]
		);

		$this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .title' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Title Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
            'sub_title_watermark',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Watermark', 'tp-elements' ),
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'watermark_typography',
				'label' => esc_html__( 'Watermark Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-heading span.watermark',
			]
		);

		$this->add_control(
            'watermark_color',
            [
                'label' => esc_html__( 'Watermark Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading span.watermark' => 'color: {{VALUE}};',
                ],                
            ]
        );

		$this->add_control(
            'watermark_border_color',
            [
                'label' => esc_html__( 'Watermark Text Border Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading span.watermark' => 'background-color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control(
            'sub_title_style',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Sub Title', 'tp-elements' ),
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-heading .sub-text',
			]
		);

		$this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__( 'Subtitle Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .sub-text' => 'color: {{VALUE}};',
                ],                
            ]
        );

		$this->add_control(
            'subtitle_highlight_color',
            [
                'label' => esc_html__( 'Subtitle Highlight Background', 'tp-elements' ),
                // 'desc' => esc_html__( 'Add span tag to apply background style', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .sub-text span' => 'background: {{VALUE}};',
                ],                
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__( 'Subtitle Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .sub-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'des_style',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Description', 'tp-elements' ),
                'separator' => 'before',
            ]
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-heading .description p',
			]
		);

		$this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .description' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pixelaxis-heading .description p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pixelaxis-heading .description p a' => 'color: {{VALUE}};',
                ],                
            ]
        ); 

        $this->add_control(
            'desc_color_strong',
            [
                'label' => esc_html__( 'Description Strong Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .description strong' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pixelaxis-heading .description p strong' => 'color: {{VALUE}};',
                    
                ],                
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_sec_typography',
				'label' => esc_html__( 'Description Strong Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-heading .description strong',
			]
		);

        $this->add_responsive_control(
            'desc_margin',
            [
                'label' => esc_html__( 'Description Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'border_color',
                'label' => esc_html__( 'Border Color', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
             
				'selector' => '{{WRAPPER}} .pixelaxis-heading.style2:after',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                
            ]
        );   
		
				
        $this->add_responsive_control(
            'btn_styles',
            [
                'label' => esc_html__( 'Button Styles', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );

		$this->add_responsive_control(
            'btn_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'color: {{VALUE}};',
                ],
            ]
        ); 

		$this->add_responsive_control(
            'btn_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a:hover' => 'color: {{VALUE}};',
                ],
            ]
        ); 

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_text_typography',
				'selector' => '{{WRAPPER}} .pixelaxis-heading .tp-button a',
			]
		);
		
        $this->add_responsive_control(
            'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

		$this->add_responsive_control(
            'btn_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

		$this->add_responsive_control(
            'btn_icon_styles',
            [
                'label' => esc_html__( 'Button Icon Styles', 'tp-elements' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );

		$this->add_responsive_control(
            'btn_icon_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a i' => 'color: {{VALUE}};',
                ],
            ]
        ); 

		$this->add_responsive_control(
            'btn_icon_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a:hover i' => 'color: {{VALUE}};',
                ],
            ]
        ); 

		
		$this->add_responsive_control(
            'btn_icon_bg_color',
            [
                'label' => esc_html__( 'Backgorund Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a i' => 'background: {{VALUE}};',
                ],
            ]
        );
				
		$this->add_responsive_control(
            'btn_icon_hover_bg_color',
            [
                'label' => esc_html__( 'Hover Backgorund Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a:hover i' => 'background: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_iocn_typography',
				'selector' => '{{WRAPPER}} .pixelaxis-heading .tp-button a i',
			]
		);
		
        $this->add_responsive_control(
            'btn_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

		$this->add_responsive_control(
            'btn_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-heading .tp-button a i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


		$this->end_controls_section();

			$this->start_controls_section(
				    '_section_style_button',
				    [
				        'label' => esc_html__( 'Button', 'tp-elements' ),
				        'tab' => Controls_Manager::TAB_STYLE,
				        'condition' => [
							'style' => 'style14',
						],
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
				            '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'width: {{SIZE}}{{UNIT}};',
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
		                    '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'order: {{VALUE}};'
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
		                    'left' => [
		                        'title' => esc_html__( 'Left', 'tp-elements' ),
		                        'icon' => 'eicon-text-align-left',
		                    ],
		                    'center' => [
		                        'title' => esc_html__( 'Center', 'tp-elements' ),
		                        'icon' => 'eicon-text-align-center',
		                    ],
		                    'right' => [
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
		                    '{{WRAPPER}} .pixelaxis-heading .tp-button a' => 'text-align: {{VALUE}}'
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
				            '{{WRAPPER}} .tp-button a' => 'color: {{VALUE}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
					[
						'name' => 'background_normal',
						'label' => esc_html__( 'Background', 'tp-elements' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tp-button a',
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
		                    '{{WRAPPER}} .tp-button a' => 'opacity: {{SIZE}};',
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
				            '{{WRAPPER}} .tp-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				            '{{WRAPPER}} .tp-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Typography::get_type(),
				    [
				        'name' => 'btn_typography',
				        'selector' => '{{WRAPPER}} .tp-button a',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Border::get_type(),
				    [
				        'name' => 'button_border',
				        'selector' => '{{WRAPPER}} .tp-button a',
				    ]
				);

				$this->add_control(
				    'button_border_radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .tp-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'button_box_shadow',
				        'selector' => '{{WRAPPER}} .tp-button a',
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
				            '{{WRAPPER}} .tp-button a:hover' => 'color: {{VALUE}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
					[
						'name' => 'background',
						'label' => esc_html__( 'Background', 'tp-elements' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tp-button a:hover',
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
		                    '{{WRAPPER}} .tp-button:hover a' => 'opacity: {{SIZE}};',
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
				            '{{WRAPPER}}  .tp-button a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				            '{{WRAPPER}} .tp-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Typography::get_type(),
				    [
		                'name'     => 'btn_hover_typography',
		                'selector' => '{{WRAPPER}}  .tp-button a',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Border::get_type(),
				    [
		                'name'     => 'button_hover_border',
		                'selector' => '{{WRAPPER}} .tp-button a',
				    ]
				);

				$this->add_control(
				    'button_hover_border_radius',
				    [
		                'label'      => esc_html__( 'Border Radius', 'tp-elements' ),
		                'type'       => Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .tp-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
		                'name'     => 'button_hover_box_shadow',
		                'selector' => '{{WRAPPER}} .rs-cta:hover .tp-button a',
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
				            '{{WRAPPER}} .tp-button i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
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
				            '{{WRAPPER}} .tp-button a i' => 'color: {{VALUE}};',
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
						'selectors' => ['{{WRAPPER}} .tp-button a i' => 'background: {{VALUE}};',],
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
				            '{{WRAPPER}} .tp-button a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				            '{{WRAPPER}} .tp-button a i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				            '{{WRAPPER}} .tp-button:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
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
				            '{{WRAPPER}} .tp-button:hover a i' => 'color: {{VALUE}};',
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
						'selectors' => ['{{WRAPPER}} .tp-button:hover a i'=> 'background: {{VALUE}};',],
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
				            '{{WRAPPER}} .tp-button:hover a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				            '{{WRAPPER}} .tp-button:hover a i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
			            'condition' => [
			                'show_icon' => 'yes'
			            ],
				    ]
				);

				$this->end_controls_tab();
				$this->end_controls_tabs();
				

				$this->end_controls_section();

				$this->start_controls_section(
					'_section_style_animation',
					[
						'label' => esc_html__( 'AOS Animation', 'tp-elements' ),
						'tab'   => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_control(
					'enable_animation',
					[
						'label' => esc_html__( 'Enable Animation', 'tp-elements' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'tp-elements' ),
						'label_off' => esc_html__( 'No', 'tp-elements' ),
						'return_value' => 'yes',
						'default' => 'yes',
						
					]
				);
		
				$this->add_control(
					'animation_style',
					[
						'label' => esc_html__( 'Animation Type', 'tp-elements' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'slide-up',
						'options' => [
							'fade'  => esc_html__( 'Fade', 'tp-elements' ),
							'slide-up'  => esc_html__( 'Slide Up', 'tp-elements' ),
							'slide-down'  => esc_html__( 'Slide Down', 'tp-elements' ),
							'slide-left' => esc_html__( 'Slide Left', 'tp-elements' ),
							'slide-right' => esc_html__( 'Slide Right', 'tp-elements' ),
							
						],
						'condition' =>[
							'enable_animation' =>  'yes'
						]
						
					]
				);
		
				$this->add_control(
					'data_delay',
					[
						'label' => esc_html__( 'Data Delay', 'tp-elements' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( '150', 'tp-elements' ),
						'condition' =>[
							'enable_animation' =>  'yes'
						]
						
					]
				);
		
		
				$this->add_control(
					'data_duration',
					[
						'label' => esc_html__( 'Data Duration', 'tp-elements' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( '800', 'tp-elements' ),
						'condition' =>[
							'enable_animation' =>  'yes'
						]
					]
				);
				$this->end_controls_section();

	}

	/**
	 * Render rsgallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display(); 
		if($settings['enable_animation'] == 'yes'){
			$animate_img = 'data-aos-delay="100" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true"';
            $animate = 'data-aos-delay="100" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true"';
			$animate_sub = 'data-aos-delay="150" data-aos="fade-up" data-aos-duration="700" data-aos-once="true"';
			$animate_des = 'data-aos-delay="200" data-aos="fade-up" data-aos-duration="1200" data-aos-once="true"';
			$animate_btn = 'data-aos-delay="250" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true"';
			
        }else{
            $animate = '';
			$animate_sub = '';
			$animate_des = '';
			$animate_img= '';
			$animate_btn = '';
        }
		$watermark_text = ($settings['watermark']) ? '<span class="watermark">'.($settings['watermark']).'</span>' : '';
		$main_title     = ($settings['title']) ? '<'.$settings['title_tag'].' class="title" '.$animate.'>'.wp_kses_post($settings['title']).'</'.$settings['title_tag'].'>' : '';
		if( "style4"    ==	$settings['style'] || "style4 Lite"== $settings['style'] || "style6"== $settings['style'] || "style6 Lite"==$settings['style'] || "style7" == $settings['style'] || "style7 Lite"== $settings['style'] ){
			$sub_text = ($settings['subtitle']) ? '<span class="sub-text" '.$animate_sub.'>'.($settings['subtitle']).'</span>' : '';
		}
		elseif ( "style5" == $settings['style'] ){
			$sub_text = ($settings['subtitle']) ? '<span class="sub-text title-upper" '.$animate_sub.'>[ <span class="sub-text title-upper">'.($settings['subtitle']).'</span> ] </span>' : '';
		}
		else{
			$sub_text  = ($settings['subtitle'])  ? '<span class="sub-text" '.$animate_sub.'>'.($settings['subtitle']) .'</span>' : '';
		}
		$titleimg    = $settings['image'] ? '<img src="' . $settings['image']['url'] . '" alt="title-image" />' : '';
		$topimage    = $settings['image_postition'] == 'top' ? '<div class="title-img top" '.$animate_img.'> '.$titleimg .'</div>' : "";
		$bottomimage = $settings['image_postition'] == 'bottom' ? '<div class="title-img bottom-img">'.$titleimg .'</div>' : "";

		if( "style9" == $settings['style'] ){
			$main_title     = ($settings['title']) ? '<'.$settings['title_tag'].' class="title" '.$animate.'>'.$watermark_text.''.($settings['title']).'</'.$settings['title_tag'].'>' : '';
		}

		
		if( "style13" == $settings['style'] ){
			$sub_left_image = $settings['image-left-sub']['url'] ? '<img  class = "line-1-img" src="' . $settings['image-left-sub']['url'] . '" alt="title-image" />' : '';
			$sub_right_image = $settings['image-right-sub']['url'] ? '<img class = "line-2-img" src="' . $settings['image-right-sub']['url'] . '" alt="title-image" />' : '';
			$sub_text  =   '<div class="sub-content">'.$sub_left_image .$sub_text. $sub_right_image.'</div>';
		}
		    
        // Fill $html var with data
      ?>
	  
        <div class="pixelaxis-heading <?php echo esc_attr($settings['style']);?> title-border-<?php echo $settings['enable_border'];?>">
             		      		
	            <?php 
					echo wp_kses_post($topimage);					
					echo wp_kses_post($sub_text);
					echo wp_kses_post($main_title);					
					echo wp_kses_post($bottomimage) ;
				?>
	     
			<?php echo $watermark_text; ?>
	        <?php if ($settings['content']) { 
				$this->add_inline_editing_attributes( 'content', 'advanced' );
				$this->add_render_attribute( 'content', 'class', 'description' );?>
            	<div  <?php echo wp_kses_post($this->print_render_attribute_string('content'));?> <?php echo $animate_des; ?>>
            		<?php echo wp_kses_post($settings['content']);?>            		
            	</div>
        	<?php } ?>

	        <?php if(!empty($settings['btn_text'])): ?>
	
				<div class="tp-button" <?php echo $animate_btn; ?>>

					<?php $target = $settings['btn_link']['is_external'] ? 'target=_blank' : '';?>
					<a class="readon pixelaxis_button elementor-animation-<?php echo esc_html($settings['hover_animation']);?>" href="<?php echo esc_url($settings['btn_link']['url']);?>" <?php echo esc_attr($target);?>>				
						<span <?php echo wp_kses_post($this->print_render_attribute_string('btn_text'));?>><?php echo esc_html($settings['btn_text']);?></span>

						<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</a>

				</div>
	        <?php endif; ?>    
        </div>
        <?php 		
	}
}?>