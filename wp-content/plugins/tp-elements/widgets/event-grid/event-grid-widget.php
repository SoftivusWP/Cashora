<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Elementor\Core\Schemes\Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Events_Grid_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve rsgallery widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tp-event-gird';
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
		return esc_html__( 'TP Events Grid', 'tp-elements' );
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
		return 'glyph-icon flaticon-slider-1';
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
				'label' => esc_html__( 'Content Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'event_grid_style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',				
				'options' => [
					'style1' => 'Default',
					'style2' => 'Transparent',
					'style3' => 'Style 3',
					'style4' => 'Style 4',
				],											
			]
		);

		$this->add_control(
			'cat',
			[
				'label'   => esc_html__( 'Category', 'afaddon' ),
				'type'    => Controls_Manager::SELECT2,	
				'options'   => $this->getCategories(),
				'multiple' => true,	
				'separator' => 'before',					
			]
		);		

		$this->add_control(
			'course_per',
			[
				'label' => esc_html__( 'Event Per Page', 'afaddon' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'afaddon' ),
				'separator' => 'before',				
			]
		);

		$this->add_control(
			'event_col',
			[
				'label'   => esc_html__( 'Columns', 'afaddon' ),
				'type'    => Controls_Manager::SELECT,	
				'default' => 4,			
				'options' => [
					'6' => esc_html__( '2 Column', 'afaddon' ),
					'4' => esc_html__( '3 Column', 'afaddon' ),
					'3' => esc_html__( '4 Column', 'afaddon' ),
					'2' => esc_html__( '6 Column', 'afaddon' ),
					'12' => esc_html__( '1 Column', 'afaddon' ),					
				],
				'separator' => 'before',				
							
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Course offset', 'afaddon' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'You can write how many course offset. ex(2)', 'afaddon' ),
				'separator' => 'before',				
			]
		); 

		$this->add_control(
		    'event_content_show_hide',
		    [
		        'label' => esc_html__( 'Description Show / Hide', 'tp-elements' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'yes',
		        'options' => [
		            'yes' => esc_html__( 'Yes', 'tp-elements' ),
		            'no' => esc_html__( 'No', 'tp-elements' ),
		        ],                
		        'separator' => 'before',
		    ]
		);

		$this->add_control(
		    'event_des',
		    [
		        'label' => esc_html__( 'Show Excerpt Limit', 'tp-elements' ),
		        'type' => Controls_Manager::TEXT,
		        'placeholder' => esc_html__( '16', 'tp-elements' ),
		        'separator' => 'before',
		        'condition' => [
		            'event_content_show_hide' => 'yes',
		        ]
		    ]
		);

		$this->add_responsive_control(
		    'area_spacing',
		    [
		        'label' => esc_html__( 'Events Item Bottom Gap', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .events-short' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);	

		$this->end_controls_section();


		$this->start_controls_section(
			'images_section',
			[
				'label' => esc_html__( 'Image Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'show_thum',
		    [
		        'label'        => esc_html__( 'Show Image', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ],
                'condition' => [
                    'show_thum' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
		    'img_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .events-short .featured-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'show_thum' => 'yes',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->add_responsive_control(
		    'img_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .events-short .featured-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .events-short .featured-img:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'show_thum' => 'yes',
		        ],
		    ]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'cate_section',
			[
				'label' => esc_html__( 'Category Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'show_cates',
		    [
		        'label'        => esc_html__( 'Show Category', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
		    'cate_position',
		    [
		        'label' => esc_html__( 'Category Position', 'tp-elements' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'tops',
		        'options' => [
		            'tops' => esc_html__( 'Top', 'tp-elements' ),
		            'bottoms' => esc_html__( 'Bottom', 'tp-elements' ),
		        ],  
		        'condition' => [
		            'show_cates' => 'yes',
		        ],              
		        'separator' => 'before',
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lock_section',
			[
				'label' => esc_html__( 'Address Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'add_event',
		    [
		        'label'        => esc_html__( 'Show Address', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'time_section',
			[
				'label' => esc_html__( 'Time Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'event_grid_style' => 'style2',
				],
			]
		);

		$this->add_control(
		    'tim_event',
		    [
		        'label'        => esc_html__( 'Time Show / Hide', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		        'condition' => [
		            'event_grid_style' => ['style2', 'style1'],
		        ],
		    ]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'times_section',
			[
				'label' => esc_html__( 'Time Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'event_grid_style' =>['style3', 'style4'],
				],
			]
		);

		$this->add_control(
		    'tims_event',
		    [
		        'label'        => esc_html__( 'Time Show / Hide', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		        'condition' => [
		            'event_grid_style' =>['style3', 'style4'],
		        ],
		    ]
		);

		$this->end_controls_section();




		$this->start_controls_section(
			'metas_section',
			[
				'label' => esc_html__( 'Meta Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'show_meta',
		    [
		        'label'        => esc_html__( 'Show Meta', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
			'event_multi_color',
			[
				'label'   => esc_html__( 'Select Color', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Custom Color',
					'2' => 'Multi Color',			
				],											
			]
		);

		$this->add_control(
		    'meta_position',
		    [
		        'label' => esc_html__( 'Date Position', 'tp-elements' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'tops',
		        'options' => [
		            'tops' => esc_html__( 'Top', 'tp-elements' ),
		            'bottoms' => esc_html__( 'Bottom', 'tp-elements' ),
		        ],  
		        'condition' => [
		            'show_meta' => 'yes',
		        ], 
		        'condition' => [
		            'event_grid_style' => 'style3',
		        ],             
		        'separator' => 'before',
		    ]
		);
     	
		$this->end_controls_section();


        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__( 'Button Settings', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
		    'show_btn',
		    [
		        'label'        => esc_html__( 'Show Event Button', 'tp-elements' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'tp-elements' ),
		        'label_off'    => esc_html__( 'Hide', 'tp-elements' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
			'event_btn_text',
			[
                'label'       => esc_html__( 'Button Text', 'tp-elements' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Join Event',
                'placeholder' => esc_html__( 'Event Button Text', 'tp-elements' ),
                'separator'   => 'before',
                'condition'   => [
                    'show_btn' => 'yes',
                ]
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'section_items_style',
			[
				'label' => esc_html__( 'Events Item Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
		    'align',
		    [
		        'label' => esc_html__( 'Text Alignment', 'tp-elements' ),
		        'type' => Controls_Manager::CHOOSE,
		        'options' => [
		            'start' => [
		                'title' => esc_html__( 'Left', 'tp-elements' ),
		                'icon' => 'fa fa-align-left',
		            ],
		            'center' => [
		                'title' => esc_html__( 'Center', 'tp-elements' ),
		                'icon' => 'fa fa-align-center',
		            ],
		            'end' => [
		                'title' => esc_html__( 'Right', 'tp-elements' ),
		                'icon' => 'fa fa-align-right',
		            ],
		            'justify' => [
		                'title' => esc_html__( 'Justify', 'tp-elements' ),
		                'icon' => 'fa fa-align-justify',
		            ],
		        ],
		        'toggle' => true,
		        'selectors' => [
		            '{{WRAPPER}} .events-short' => 'text-align: {{VALUE}}',
		        ],
		        'default'   => 'left',
		        'separator' => 'before',
		    ]
		);

        $this->add_control(
            'date_color_bg',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short' => 'background: {{VALUE}};',                   
                ], 
                'condition' => [
                    'event_grid_style' => 'style1',
                ],               
            ]  
        ); 

        $this->add_control(
            'date_color_bgs',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short' => 'background: {{VALUE}};',                   
                ], 
                'condition' => [
                    'event_grid_style' => 'style3',
                ],               
            ]  
        );

        $this->add_control(
            'border_color_bg',
            [
                'label' => esc_html__( 'Border Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-btm' => 'border-color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short' => 'border-color: {{VALUE}};',                   
                ],
                'condition' => [
                    'event_grid_style' => ['style1', 'style4'],
                ],                
            ]    
        ); 

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadows',
                'label' => esc_html__( 'Box Shadow', 'tp-elements' ),
                'selector' => '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short',
                'condition' => [
                    'event_grid_style' => 'style1',
                ],
            ]            
        );


        $this->add_responsive_control(
		    'padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .pixelaxis-event-slider.event-slider-style2 .event-item .events-short .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'],
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'padding_areas',
		    [
		        'label' => esc_html__( 'Content Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style4'],
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'padding_items_areas',
		    [
		        'label' => esc_html__( 'Item Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style4'],
		        ],
		    ]
		);
		
		$this->end_controls_section();


        $this->start_controls_section(
			'section_event_cate_style',
			[
				'label' => esc_html__( 'Category Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'category_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a' => 'background-color: {{VALUE}};',                   
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a' => 'background-color: {{VALUE}};',                   
		        ],                
		    ]
		);

		$this->add_control(
		    'category_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a' => 'color: {{VALUE}};',                   
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);


		$this->add_control(
		    'category_color_hover',
		    [
		        'label' => esc_html__( 'Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a:hover' => 'color: {{VALUE}};',                    
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a:hover' => 'color: {{VALUE}};',                    
		        ],                
		    ]		    
		);  

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cates_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a, {{WRAPPER}} .events-short .categorie a',
			]
		);

        $this->add_responsive_control(
		    'cate_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .categorie' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_responsive_control(
            'catebg_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .categorie a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'cate_position' => 'tops',
                ]
            ]
        );

		$this->end_controls_section(); 



        $this->start_controls_section(
			'add_event_style',
			[
				'label' => esc_html__( 'Address Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'add_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .address' => 'color: {{VALUE}};',                  
                ],                
            ]
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'add_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .events-short .address',                                    
			]
		);
		$this->end_controls_section();  

        $this->start_controls_section(
			'time_event_style',
			[
				'label' => esc_html__( 'Time Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'time_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .time' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .time i:before' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-slider.event-slider-style3 .event-item .time-sec .timesec i:before' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-slider.event-slider-style3 .event-item .time-sec .timesec' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .timesec' => 'color: {{VALUE}};',                   
                ],                
            ]
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'time_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .time, {{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .timesec, {{WRAPPER}} .pixelaxis-event-slider.event-slider-style3 .event-item .time-sec .timesec',                                    
			]
		);
		$this->end_controls_section(); 


        $this->start_controls_section(
			'section_event_style',
			[
				'label' => esc_html__( 'Title Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .content-part .title a' => 'color: {{VALUE}};',
                ],             
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short:hover .content-part .title a' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .events-short .content-part .title, {{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .content-part .title a',                   
			]
		);

        $this->add_responsive_control(
		    'title_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->end_controls_section();  


        $this->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'bg_date_colors',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .dates' => 'background-color: {{VALUE}};',                                     
                    '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .date-sec' => 'background-color: {{VALUE}};',                                     
                ],                 
                'condition' => [
                    'event_grid_style' => ['style3', 'style4'],
                ],           
            ]  
        ); 

        $this->add_control(
            'meta_icons_color',
            [
                'label' => esc_html__( 'Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pixelaxis-event-grid .event-item .time-secs .time i::before' => 'color: {{VALUE}} !important;',
                ],             
            ]
        );

        $this->add_control(
            'meta_icons_date_color',
            [
                'label' => esc_html__( 'Date Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-event-grid .event-item .date-part span' => 'color: {{VALUE}};',                    
                ], 
                'condition' => [
                    'event_grid_style' => ['style1'],
                ],             
            ]
        );

		$this->add_control(
            'custom_date_color_1',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part .date' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .dates' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .date-sec' => 'color: {{VALUE}};',                   
                ],                 
                'condition' => [
                    'show_meta' => 'yes',
                ],           
            ]  
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'month_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .date-part, {{WRAPPER}} .date-part .date, {{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .date-sec, {{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .featured-img .dates',				
			]
		);  

        $this->add_responsive_control(
		    'date_space_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => 'style2',
		        ],
		    ]
		);

        $this->end_controls_section();  


        $this->start_controls_section(
			'section_event_content_style',
			[
				'label' => esc_html__( 'Excerpt Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'excerpt_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .content-part .txt' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exc_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .events-short .content-part .txt, {{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .content-part .txt',               
			]
		);

        $this->add_responsive_control(
		    'excerpt_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .content-part .txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();  


        $this->start_controls_section(
			'event_btn_style',
			[
				'label' => esc_html__( 'Button Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'btn_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn' => 'background-color: {{VALUE}};',                   

		        ], 
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'], 
		        ],	              
		    ]
		);

		$this->add_control(
		    'btn_hover_bg_color',
		    [
		        'label' => esc_html__( 'Hover Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn:hover' => 'background-color: {{VALUE}};',                              
		                             

		        ], 
		                     
		    ]
		);

		$this->add_control(
		    'btn_hover_border_color',
		    [
		        'label' => esc_html__( 'Hover Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn:hover' => 'border-color: {{VALUE}};',                              
		                             

		        ], 
		                     
		    ]
		);


		$this->add_control(
		    'btn_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);

		

		$this->add_control(
		    'd_btn_color_hovers',
		    [
		        'label' => esc_html__( 'Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-grid .event-item .events-short .btn-part a.join-btn:hover' => 'color: {{VALUE}};',                   
		        ],   
		                  
		    ]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn',                                     
			]
		);

        $this->add_responsive_control(
		    'btn_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-slider .event-item .events-short .event-btm .join-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'], 
		        ],		        
		    ]
		);

		$this->add_responsive_control(
		    'd_btn_area_spacing',
		    [
		        'label' => esc_html__( 'Button Top Gap', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-event-grid.event-slider-style4 .event-item .events-short .event-btm' => 'margin-top: {{SIZE}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => 'style4',
		        ],
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
	?>	 


		<div class="pixelaxis-unique-sliders pixelaxis-event-slider pixelaxis-event-grid event-slider-<?php echo esc_attr($settings['event_grid_style']); ?>">
			<div id="pixelaxis-grid" class="pixelaxis-addon-sliders row">
				<?php 
					if('style1' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style1.php");
					}
					if('style2' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style2.php");
					}
					if('style3' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style3.php");
					}
					if('style4' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style4.php");
					}
				?>
			</div>
		</div>
	<?php 
	}
	public function getCategories(){
         $cat_list = [];
         if ( post_type_exists( 'tp-events' ) ) { 
          $terms = get_terms( array(
             'taxonomy'    => 'tp-event-category',
             'hide_empty'  => true            
         ) );           
    
         foreach($terms as $post) {
          $cat_list[$post->slug]  = [$post->name];
         }
      }  
        return $cat_list;
     }  
}?>