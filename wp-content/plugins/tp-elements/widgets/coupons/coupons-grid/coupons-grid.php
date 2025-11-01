<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;

defined( 'ABSPATH' ) || die();

class Themephi_Elementor_Coupons_Grid_Widget extends \Elementor\Widget_Base {

	 
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
		return 'tp-coupons-grid';
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
		return esc_html__( 'TP Coupons Grid', 'tp-elements' );
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
		return 'glyph-icon flaticon-support';
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
	 * Register services widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
		protected function register_controls() {

		$this->start_controls_section(
			'section_coupon',
			[
				'label' => esc_html__( 'Coupons Global', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->add_control(
			'coupon_style',
			[
				'label'   => esc_html__( 'Select Coupon Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'tp-elements'),	
					'style2' => esc_html__( 'Style 2', 'tp-elements'),	
					// 'style3' => esc_html__( 'Style 3', 'tp-elements'),	
					// 'store1' => esc_html__( 'Store 1', 'tp-elements'),	
				],
			]
		);

				
		$this->add_control(
			'coupon_grid_source',
			[
				'label'   => esc_html__( 'Select Coupon Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',				
				'options' => [
                    'dynamic' => esc_html__('Dynamic', 'tp-elements'),
					'slider' => esc_html__('Slider', 'tp-elements'),					
				],											
			]
		);

        $this->add_control(
			'enable_item_massonry',  
			[
				'label' => esc_html__( 'Enable Massonry ?', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],
			]
		);

        $this->add_control(
			'enable_item_gutter',
			[
				'label' => esc_html__( 'Enable Gutter Space ?', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label'   => esc_html__( 'Show Filter', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'filter_hide',	
				'separator' => 'before',		
				'options' => [
					'filter_show' => 'Show',
					'filter_hide' => 'Hide',				
				],
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],											
			]
		);
		
		$this->add_control(
			'enable_filter_icon',
			[
				'label' => esc_html__( 'Enable Filter Icon ?', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'show_filter' => 'filter_show',
					'coupon_grid_source' => 'dynamic',
				],
			]
		);

		$this->add_control(
			'filter_title',
			[
				'label' => esc_html__( 'Filter Default Title', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => __('All', 'tp-elements'),
				'condition' => [
					'show_filter' => 'filter_show',
					'coupon_grid_source' => 'dynamic',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'coupon_exapansion',
			[
				'label'   => esc_html__( 'Slider Expansion', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'expansion-right',
				'options' => [					
					'expansion-right' => esc_html__( 'Right Expansion', 'tp-elements'),
					'expansion-left' => esc_html__( 'Left Expansion', 'tp-elements'),	
				],
				'condition' => [
					'coupon_grid_source' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'store_box_position',
			[
				'label'   => esc_html__( 'Store Box Position', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',				
				'options' => [
                    'top' => esc_html__('Top', 'tp-elements'),
					'bottom' => esc_html__('Bottom', 'tp-elements'),					
				],
				'condition' => [
					'coupon_style' => 'style2',
				],											
			]
		);

		$this->add_control(
			'coupon_category',
			[
				'label'   => esc_html__( 'Category', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getCategories(),
				'multiple' => true,	
				'separator' => 'before',		
			]
		);

		$this->add_control(
			'coupon_store',
			[
				'label'   => esc_html__( 'Store', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getStores(),
				'multiple' => true,	
				'separator' => 'before',		
			]
		);

		$this->add_control(
            'coupon_orderby',
            [
                'label'   => esc_html__( 'Order By', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'title',
                'options' => [
					'date' => esc_html__( 'Latest', 'tp-elements' ),
					'popular' => esc_html__( 'Popular', 'tp-elements' ),
					'ending'  => esc_html__( 'Ending Soon', 'tp-elements' ),
                    'title' => esc_html__( 'Title', 'tp-elements' ), 
                    'rend' => esc_html__( 'Random', 'tp-elements' ),               
                ],
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'coupon_order',
            [
                'label'   => esc_html__( 'Order', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'tp-elements' ), 
                    'DESC' => esc_html__( 'Descending', 'tp-elements' ),              
                ],
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'coupon_type',
            [
                'label'   => esc_html__( 'Coupon Type', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => '',
                'options' => [
					'' => esc_html__( 'All', 'tp-elements' ),
					'1' => esc_html__( 'Online Code', 'tp-elements' ),
					'2' => esc_html__( 'In Store Code', 'tp-elements' ),
					'3' => esc_html__( 'Online Sale', 'tp-elements' ),             
                ],
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Coupons Show Per Page', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'tp-elements' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
            'even_col_xxl',
            [
                'label'   => esc_html__( 'Desktops > 1399px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],	        
            ]
            
        );

		$this->add_control(
            'even_col_xl',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],	        
            ]
            
        );

		$this->add_control(
            'even_col_lg',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 4,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],	        
            ]
            
        );

        $this->add_control(
            'even_col_md',
            [
                'label'   => esc_html__( 'Desktops > 768px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 6,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                   
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],           
            ]
            
        );

        $this->add_control(
            'even_col_sm',
            [
                'label'   => esc_html__( 'Tablets > 576px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 6,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                  
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],           
            ] 
        );

        $this->add_control(
            'even_col_xs',
            [
                'label'   => esc_html__( 'Tablets < 575px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 12,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],           
            ]
        );

		$this->add_control(
			'image_show_hide',
			[
				'label'   => esc_html__( 'Image Show Hide', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yes',				
				'options' => [
                    'yes' => esc_html__('Yes', 'tp-elements'),
					'no' => esc_html__('No', 'tp-elements'),					
				],
				'condition' => [
					'coupon_style' => ['style1', 'style3'],
				],											
			]
		);

		$this->add_responsive_control(
            'image_or_icon_position',
            [
                'label' => esc_html__( 'Image / Icon Position', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'elementor-postion-left' => [
                        'title' => esc_html__( 'Left', 'tp-elements' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'elementor-postion-top' => [
                        'title' => esc_html__( 'Top', 'tp-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'elementor-postion-bottom' => [
                        'title' => esc_html__( 'Bottom', 'tp-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'elementor-postion-right' => [
                        'title' => esc_html__( 'Right', 'tp-elements' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
				'default' => 'elementor-postion-top',
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'image_or_icon_vertical_align',
            [
                'label' => esc_html__( 'Vertical Alignment', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'elementor-vertical-align-top' => [
                        'title' => esc_html__( 'Top', 'tp-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'elementor-vertical-align-middle' => [
                        'title' => esc_html__( 'Middle', 'tp-elements' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'elementor-vertical-align-bottom' => [
                        'title' => esc_html__( 'Bottom', 'tp-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => true,
				'separator' => 'before',
				'default' => 'elementor-vertical-align-top',
				'condition' => [
					'image_or_icon_position' => ['elementor-postion-left', 'elementor-postion-right'],
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
                    '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-item' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-title-meta.d-flex ' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta.d-flex ' => 'justify-content: {{VALUE}}',
                    // '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta.d-flex' => 'justify-content: {{VALUE}}',
                ], 
				'separator' => 'before',
            ]
        );

		$this->add_control(
            'coupon_pagination_show_hide',
            [
                'label' => esc_html__( 'Pagination Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'coupon_grid_source' => 'dynamic',
				],
            ]
        );
		
		$this->end_controls_section();	
		
		$this->start_controls_section(
			'section_store_image',
			[
				'label' => esc_html__( 'Store Image', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'coupon_style' => ['style1', 'style2', 'style3'],
				],	
			]
		);
		$this->add_control(
			'store_image_show_hide',
			[
				'label'   => esc_html__( 'Store Image Show Hide', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yes',				
				'options' => [
                    'yes' => esc_html__('Yes', 'tp-elements'),
					'no' => esc_html__('No', 'tp-elements'),					
				],										
			]
		);

		$this->add_control(
            'store_image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupon-store-image-wrapp a img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

		$this->add_responsive_control(
            'store_image_position',
            [
                'label' => esc_html__( 'Store Image Position', 'tp-elements' ),
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
				'default' => 'end',
				'selectors' => [
                    '{{WRAPPER}} .tp-coupon-store-image-wrapp' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

		$this->add_responsive_control(
		    'store_img_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-store-image-wrapp .tp-coupon-store-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
			'store_name_heading',
			[
				'label' => esc_html__( 'Store Name', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'store_title_typography',
		        'label' => esc_html__( 'Title Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .tp-coupon-store-name',
		    ]
		);

		$this->add_responsive_control(
		    'store_title_spacing',
		    [
		        'label' => esc_html__( 'Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-store-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'store_title_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		             '{{WRAPPER}} .tp-coupon-store-name' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
			'store_location_heading',
			[
				'label' => esc_html__( 'Store Location', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'store_location_typography',
		        'label' => esc_html__( 'Location Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .tp-coupon-store-address',
		    ]
		);

		$this->add_control(
		    'store_location_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		             '{{WRAPPER}} .tp-coupon-store-address' => 'color: {{VALUE}}',
		        ],
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title & Description', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
	
		$this->add_control(
            'coupon_title_show_hide',
            [
                'label' => esc_html__( 'Title Show / Hide', 'tp-elements' ),
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
            'title_word_count',
            [
                'label' => esc_html__( 'Title Word Count', 'tp-elements' ),
                'type' => Controls_Manager::NUMBER,  
				'condition' => [
					'coupon_title_show_hide' => 'yes',
				],         
            ]
        );

		$this->add_control(
			'link_open',
			[
				'label'   => esc_html__( 'Link Open New Window', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [					
					'no' => esc_html__( 'No', 'tp-elements'),
					'yes' => esc_html__( 'Yes', 'tp-elements'),					

				],
			]
		);

		$this->add_control(
		    'title_tag',
		    [
		        'label' => esc_html__( 'Title HTML Tag', 'tp-elements' ),
		        'type' => Controls_Manager::CHOOSE,
		        'options' => [
		            'h1'  => [
		                'title' => esc_html__( 'H1', 'tp-elements' ),
		                'icon' => 'eicon-editor-h1'
		            ],
		            'h2'  => [
		                'title' => esc_html__( 'H2', 'tp-elements' ),
		                'icon' => 'eicon-editor-h2'
		            ],
		            'h3'  => [
		                'title' => esc_html__( 'H3', 'tp-elements' ),
		                'icon' => 'eicon-editor-h3'
		            ],
		            'h4'  => [
		                'title' => esc_html__( 'H4', 'tp-elements' ),
		                'icon' => 'eicon-editor-h4'
		            ],
		            'h5'  => [
		                'title' => esc_html__( 'H5', 'tp-elements' ),
		                'icon' => 'eicon-editor-h5'
		            ],
		            'h6'  => [
		                'title' => esc_html__( 'H6', 'tp-elements' ),
		                'icon' => 'eicon-editor-h6'
		            ]
		        ],
		        'default' => 'h5',
		        'toggle' => false,
				'condition' => [
					'coupon_title_show_hide' => 'yes',
				], 
		    ]
		);

		$this->add_control(
            'coupon_text_show_hide',
            [
                'label' => esc_html__( 'Content Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'coupon_text_word_limit',
            [
                'label' => esc_html__( 'Show Content Limit', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '20', 'tp-elements' ),
                'separator' => 'before',
                'condition' => [
                    'coupon_text_show_hide' => 'yes',
                ]
            ]
        );

		$this->add_control(
            'coupon_rich_text_show_hide',
            [
                'label' => esc_html__( 'Rich Text Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
            ]
        );

		$this->end_controls_section();	
	
		$this->start_controls_section(
			'section_meta',
			[
				'label' => esc_html__( 'Coupons Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'coupon_meta_show_hide',
            [
                'label' => esc_html__( 'Meta Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
            ]
        );

		/* Top Meta Start */
		$this->add_control(
			'show_top_meta',
			[
				'label' => esc_html__( 'Enable Top Meta', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
            'show_top_meta_position',
            [
                'label' => esc_html__( 'Top Meta Position?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Outside Image', 'tp-elements' ),
                    'no' => esc_html__( 'Inside Image', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_top_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'coupon_exclusive_show_hide',
            [
                'label' => esc_html__( 'Show Exclusive?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_top_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'coupon_available_show_hide',
            [
                'label' => esc_html__( 'Show Availability?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_top_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'coupon_favourite_show_hide',
            [
                'label' => esc_html__( 'Show Favorite?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_top_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		// $this->add_control(
        //     'coupon_expired_show_hide',
        //     [
        //         'label' => esc_html__( 'Show Expirity?', 'tp-elements' ),
        //         'type' => Controls_Manager::SELECT,
        //         'default' => 'yes',
        //         'options' => [
        //             'yes' => esc_html__( 'Yes', 'tp-elements' ),
        //             'no' => esc_html__( 'No', 'tp-elements' ),
        //         ],                
        //         'separator' => 'before',
		// 		'condition' => [
		// 			'show_top_meta' => ['yes'],
		// 			'coupon_meta_show_hide' => ['yes'],
		// 		],
        //     ]
        // );

		/* Top Meta End */

		/* After Title Meta Start */
		$this->add_control(
			'show_after_title_meta',
			[
				'label' => esc_html__( 'Enable Title Meta', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
            'show_after_title_meta_position',
            [
                'label' => esc_html__( 'Title Meta Position?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Before Title', 'tp-elements' ),
                    'no' => esc_html__( 'After Title', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_after_title_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'regular_price_show_hide',
            [
                'label' => esc_html__( 'Show Regular Price?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_after_title_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'sale_parcentage_show_hide',
            [
                'label' => esc_html__( 'Show Sale Parcentage?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_after_title_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );
		$this->add_control(
            'cashback_show_hide',
            [
                'label' => esc_html__( 'Show Cashback?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'show_after_title_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );
		/* After Title Meta End */

		
		/* Before Button Meta Start */
		$this->add_control(
			'before_button_meta',
			[
				'label' => esc_html__( 'Enable Before Button Meta', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
            'coupon_verified_show_hide',
            [
                'label' => esc_html__( 'Show Verified?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'before_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );
		$this->add_control(
            'affiliate_site_show_hide',
            [
                'label' => esc_html__( 'Show Affiliate Site?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'before_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );
        $this->add_control(
            'coupon_usage_show_hide',
            [
                'label' => esc_html__( 'Show Usage Amount?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'before_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'date_show_hide',
            [
                'label' => esc_html__( 'Show Expire Date?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'before_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		/* Before Button Meta End */
		
		/* After Button Meta Start */
		$this->add_control(
			'after_button_meta',
			[
				'label' => esc_html__( 'Enable After Button Meta', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
            'coupon_feedback_show_hide',
            [
                'label' => esc_html__( 'Show Feedback?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'after_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		$this->add_control(
            'coupon_comments_show_hide',
            [
                'label' => esc_html__( 'Show Comments?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'after_button_meta' => ['yes'],
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );
		
		$this->add_control(
            'coupon_share_show_hide',
            [
                'label' => esc_html__( 'Share Position?', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'After Button', 'tp-elements' ),
                    'no' => esc_html__( 'Align Button', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'coupon_meta_show_hide' => ['yes'],
				],
            ]
        );

		/* After Button Meta End */


		$this->end_controls_section();	

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'coupon_btn_show_hide',
            [
                'label' => esc_html__( 'Button Show / Hide', 'tp-elements' ),
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
            'coupon_btn_width_size',
            [
                'label' => esc_html__( 'Button Width Size', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'tp-elements' ),
                    'flex-grow-1' => esc_html__( 'Full Width', 'tp-elements' ),
                ],                
				'condition' => [
					'coupon_btn_show_hide' => ['yes'],
					'coupon_style' => ['style1', 'style2'],
				],
            ]
        );

		$this->add_control(
			'coupon_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('View All', 'tp-elements'),
				'condition' => [
					'coupon_btn_show_hide' => ['yes'],
					'coupon_style' => ['store1', 'style2', 'style3'],
				],
			]
		);

		$this->add_control(
			'coupon_btn_link_open',
			[
				'label'   => esc_html__( 'Link Open New Window', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [					
					'no' => esc_html__( 'No', 'tp-elements'),
					'yes' => esc_html__( 'Yes', 'tp-elements'),
				],
				'condition' => [
					'coupon_type!' => '1',
					'coupon_btn_show_hide' => ['yes'],
				],
			]
		);

		$this->add_control(
			'coupon_btn_icon',
			[
				'label' => esc_html__( 'Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'solid',
				],			
				'separator' => 'before',	
				'condition' => [
					'coupon_btn_show_hide' => ['yes'],
				],		
			]
		);

		$this->add_control(
		    'coupon_btn_icon_position',
		    [
		        'label' => esc_html__( 'Icon Position', 'tp-elements' ),
		        'type' => Controls_Manager::CHOOSE,
		        'label_block' => false,
		        'options' => [
		            'before' => [
		                'title' => esc_html__( 'Before', 'tp-elements' ),
		                'icon' => 'eicon-h-align-left',
		            ],
		            'after' => [
		                'title' => esc_html__( 'After', 'tp-elements' ),
		                'icon' => 'eicon-h-align-right',
		            ],
		        ],
		        'default' => 'after',
		        'toggle' => false,
		        'condition' => [
		            'coupon_btn_icon!' => '',
					'coupon_btn_show_hide' => ['yes'],
		        ],
		    ]
		); 

		$this->add_control(
		    'coupon_btn_icon_spacing',
		    [
		        'label' => esc_html__( 'Icon Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		       
		        'condition' => [
		            'coupon_btn_icon!' => '',
					'coupon_btn_show_hide' => ['yes'],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button.icon-before i' => 'margin-right: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button.icon-after i' => 'margin-left: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		
		$this->add_responsive_control(
            'button_position',
            [
                'label' => esc_html__( 'Button Position', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'elementor-btn-postion-top' => [
                        'title' => esc_html__( 'Top', 'tp-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'elementor-btn-postion-bottom' => [
                        'title' => esc_html__( 'Bottom', 'tp-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'elementor-btn-postion-right' => [
                        'title' => esc_html__( 'Right', 'tp-elements' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
				'default' => 'elementor-btn-postion-bottom',
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'button_vertical_align',
            [
                'label' => esc_html__( 'Vertical Alignment', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'elementor-btn-vertical-align-top' => [
                        'title' => esc_html__( 'Top', 'tp-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'elementor-btn-vertical-align-middle' => [
                        'title' => esc_html__( 'Middle', 'tp-elements' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'elementor-btn-vertical-align-bottom' => [
                        'title' => esc_html__( 'Bottom', 'tp-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => true,
				'separator' => 'before',
				'default' => 'elementor-btn-vertical-align-top',
				'condition' => [
					'button_position' => ['elementor-btn-postion-right'],
				],
            ]
        );

		$this->end_controls_section();

		        
		$this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'tp-elements' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'coupon_grid_source' => 'slider',
				],                
            ]
        );

        $this->add_control(
            'col_xxl',
            [
                'label'   => esc_html__( 'Wide Screen > 1399px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_xl',
            [
                'label'   => esc_html__( 'Wide Screen > 1199px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );
    
        $this->add_control(
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',                            
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Laptop > 767px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 575px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__( 'Tablets < 575px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 1,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '5' => esc_html__( '5 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slides_ToScroll',
            [
                'label'   => esc_html__( 'Slide To Scroll', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 1,         
                'options' => [
                    '1' => esc_html__( '1 Item', 'tp-elements' ),
                    '2' => esc_html__( '2 Item', 'tp-elements' ),
                    '3' => esc_html__( '3 Item', 'tp-elements' ),
                    '4' => esc_html__( '4 Item', 'tp-elements' ),                   
                ],
                'separator' => 'before',
                            
            ]
            
        );      

        $this->add_responsive_control(
            'slider_nav',
            [
                'label'   => esc_html__( 'Navigation Nav', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),              
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'slider_nav_position',
            [
                'label'   => esc_html__( 'Navigation Position', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Middle Position', 'tp-elements' ),
                    'false' => esc_html__( 'Default Position', 'tp-elements' ),              
                ],
                'separator' => 'before',
                'condition' => [ 
                    'slider_nav' => 'true', 
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_nav_left_space',
            [
                'label' => esc_html__( 'Navigation Previous Space', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation .tp-coupons-slide-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'slider_nav' => 'true', 
                    'slider_nav_position' => 'true', 
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_nav_right_space',
            [
                'label' => esc_html__( 'Navigation Next Space', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation .tp-coupons-slide-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'slider_nav' => 'true',
                    'slider_nav_position' => 'true',  
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_nav_align',
            [
                'label' => esc_html__( 'Slider Navigation Alignment', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'center',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation ' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [ 
                    'slider_nav' => 'true',
                    'slider_nav_position' => 'false', 
                ],
            ]
        );

        $this->add_control(
            'slider_nav_gap_custom',
            [
                'label' => esc_html__( 'Nav Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'slider_nav' => 'true', 
                    'slider_nav_position' => 'false', 
                ],
            ]
        );
        $this->add_control(
            'slider_nav_gap_between',
            [
                'label' => esc_html__( 'Navigation Gap Between', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],          
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation ' => 'gap: {{SIZE}}{{UNIT}};',                    
                ],
                'condition' => [ 
                    'slider_nav' => 'true', 
                    'slider_nav_position' => 'false', 
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_nav_padding',
            [
                'label' => esc_html__( 'Nav Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

        $this->add_control(
            'slider_nav_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'navigation_border',
		        'selector' => '{{WRAPPER}} .tp-coupons-navigation > span',
                'condition' => [ 'slider_nav' => 'true', ],
		    ]
		);

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'navigation_hover_border',
		        'selector' => '{{WRAPPER}} .tp-coupons-navigation > span:hover',
                'condition' => [ 'slider_nav' => 'true', ],
		    ]
		);

        $this->add_control(
            'pcat_nav_text_bg',
            [
                'label' => esc_html__( 'Nav BG Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_hover',
            [
                'label' => esc_html__( 'Nav BG Hover Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span:hover' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_icon',
            [
                'label' => esc_html__( 'Nav BG Icon Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_hover_icon',
            [
                'label' => esc_html__( 'Nav BG Icon Hover Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-coupons-navigation > span:hover' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

		/* Slider Dots Start */
        $this->add_control(
            'slider_dots',
            [
                'label'   => esc_html__( 'Navigation Dots', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_responsive_control(
            'slider_dot_width',
            [
                'label' => esc_html__( 'Width', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 80,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );
        $this->add_responsive_control(
            'slider_dot_active_width',
            [
                'label' => esc_html__( 'Active Dot Width', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 80,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );
        $this->add_responsive_control(
            'slider_dot_height',
            [
                'label' => esc_html__( 'Height', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 80,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );
        $this->add_control(
            'slider_dot_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );
        $this->add_control(
            'slider_dots_color',
            [
                'label' => esc_html__( 'Navigation Dots Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );
        $this->add_control(
            'slider_dots_color_active',
            [
                'label' => esc_html__( 'Active Navigation Dots Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );

        $this->add_control(
            'slider_dot_gap_custom',
            [
                'label' => esc_html__( 'Pagination Bottom Gap', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],          
                'selectors' => [                   
                    '{{WRAPPER}} .themephi-addon-slider.swiper.swiper-horizontal' => 'padding-bottom: {{SIZE}}{{UNIT}};',                    
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );

        $this->add_responsive_control(
            'slider_dot_align',
            [
                'label' => esc_html__( 'Slider Dot Alignment', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'center',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .themephi-addon-slider .swiper-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );

        $this->add_responsive_control(
            'slider_dot_padding',
            [
                'label' => esc_html__( 'Pagination Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .themephi-addon-slider .swiper-pagination' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label'   => esc_html__( 'Autoplay', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'   => esc_html__( 'Autoplay Slide Speed', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '1000' => esc_html__( '1 Seconds', 'tp-elements' ),
                    '2000' => esc_html__( '2 Seconds', 'tp-elements' ), 
                    '3000' => esc_html__( '3 Seconds', 'tp-elements' ), 
                    '4000' => esc_html__( '4 Seconds', 'tp-elements' ), 
                    '5000' => esc_html__( '5 Seconds', 'tp-elements' ), 
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                          
            ]
            
        );

        $this->add_control(
            'slider_interval',
            [
                'label'   => esc_html__( 'Autoplay Interval', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '5000' => esc_html__( '5 Seconds', 'tp-elements' ), 
                    '4000' => esc_html__( '4 Seconds', 'tp-elements' ), 
                    '3000' => esc_html__( '3 Seconds', 'tp-elements' ), 
                    '2000' => esc_html__( '2 Seconds', 'tp-elements' ), 
                    '1000' => esc_html__( '1 Seconds', 'tp-elements' ),     
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_stop_on_interaction',
            [
                'label'   => esc_html__( 'Stop On Interaction', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),              
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_stop_on_hover',
            [
                'label'   => esc_html__( 'Stop on Hover', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),              
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_loop',
            [
                'label'   => esc_html__( 'Loop', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_centerMode',
            [
                'label'   => esc_html__( 'Center Mode', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'tp-elements' ),
                    'false' => esc_html__( 'Disable', 'tp-elements' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_responsive_control(
            'item_gap_custom',
            [
                'label' => esc_html__( 'Item Middle Gap', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],          
            ]
        ); 
      
        $this->end_controls_section();

		// STyle Start From Here

        $this->start_controls_section(
			'section_portfolio_style',
			[
				'label' => esc_html__( 'Filter Button', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter' => 'filter_show',
				],
			]
		);

		$this->add_responsive_control(
		    'filter_btn_wrap_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_responsive_control(
            'filter_btn_align',
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
                    '{{WRAPPER}} .coupon-filter' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
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
		            '{{WRAPPER}} .coupon-filter button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .coupon-filter button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
            ]
        );

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'filter_btn_typography',
		        'selector' => '{{WRAPPER}} .coupon-filter button',
		    ]
		);


		$this->add_control(
		    'filter_btn_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter button' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_btn_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter button' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_btn_button_border',
		        'selector' => '{{WRAPPER}} .coupon-filter button',
		    ]
		);

		$this->add_control(
		    'filter_btn_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'filter_btn_button_box_shadow',
		        'selector' => '{{WRAPPER}} .coupon-filter button',
		    ]
		);

		$this->add_control(
		    'filter_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Filter Icon/Image', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_responsive_control(
		    'filter_image_width',
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
		            '{{WRAPPER}} .coupon-filter img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'filter_image_filters',
				'selector' => '{{WRAPPER}} .coupon-filter img',
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
		            '{{WRAPPER}} .coupon-filter button:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .coupon-filter button.active' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'filter_btn_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter button:hover' => 'background: {{VALUE}};',
		            '{{WRAPPER}} .coupon-filter button.active' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'filter_btn_hover_border',
		        'selector' => '{{WRAPPER}} .coupon-filter button:hover, {{WRAPPER}} .coupon-filter button.active',
		    ]
		);

		$this->add_control(
		    'filter_btn_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .coupon-filter button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .coupon-filter button.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'filter_btn_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .coupon-filter button:hover, {{WRAPPER}} .coupon-filter button.active',
		    ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'filter_image_active_filters',
				'selector' => '{{WRAPPER}} .coupon-filter button:hover img, {{WRAPPER}} .coupon-filter button.active img',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->end_controls_section();

		$this->start_controls_section(
		    '_section_wrapper_style',
		    [
		        'label' => esc_html__( 'Item', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'item_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'item_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'item_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons',
		    ]
		);

		$this->add_control(
		    'hr_one',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_item' );

		$this->start_controls_tab(
		    '_tab_item_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'item_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'item_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons',
		    ]
		);

		$this->add_control(
		    'item_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_item_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'item_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'item_hover_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons:hover',
		    ]
		);

		$this->add_control(
		    'item_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_media_style',
		    [
		        'label' => esc_html__( 'Icon / Image', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
			'show_graycale',
			[
				'label' => esc_html__( 'Enable Image Grayscale', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
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
		            '{{WRAPPER}} .tp-coupon-item-img img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->add_responsive_control(
		    'image_height',
		    [
				'label'      => esc_html__( 'Image Height', 'tp-elements' ),
				'type'       => Controls_Manager::SLIDER,
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
		            '{{WRAPPER}} .tp-coupon-item-img img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
		        ],
		        'separator' => 'before',
		    ]
		);		
		
		$this->add_responsive_control(
		    'image_width_box',
		    [
		        'label' => esc_html__( 'Image Box Width', 'tp-elements' ),
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
		            '{{WRAPPER}} .tp-coupon-item-img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->add_responsive_control(
		    'image_height_box',
		    [
		        'label' => esc_html__( 'Image Box Height', 'tp-elements' ),
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
		            '{{WRAPPER}} .tp-coupon-item-img' => 'height: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->start_popover();

		$this->add_responsive_control(
		    'media_offset_x',
		    [
		        'label' => esc_html__( 'Offset Left', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'condition' => [
		            'offset_toggle' => 'yes'
		        ],
		        'range' => [
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'render_type' => 'ui',

		    ]
		);

		$this->add_responsive_control(
		    'media_offset_y',
		    [
		        'label' => esc_html__( 'Offset Top', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'condition' => [
		            'offset_toggle' => 'yes'
		        ],
		        'range' => [
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'selectors' => [
		            // Media translate styles
		            '(desktop){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) !important;',
		            '(tablet){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}) !important;',
		            '(mobile){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}) !important;',
		            // Body text styles
		            '{{WRAPPER}} .tp-coupon-item-content-wrapper ' => 'margin-top: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);
		$this->end_popover();

		$this->add_responsive_control(
		    'media_spacing',
		    [
		        'label' => esc_html__( 'Bottom Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'media_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		
		$this->add_responsive_control(
		    'media_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'media_border',
		        'selector' => '{{WRAPPER}} .tp-coupon-item-img',
		    ]
		);

		$this->add_responsive_control(
		    'media_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [		            
		            '{{WRAPPER}} .tp-coupon-item-img, {{WRAPPER}} .tp-coupon-item-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'media_box_shadow',
		        'exclude' => [
		            'box_shadow_position',
		        ],
		        'selector' => '{{WRAPPER}} .tp-coupon-item-img > img, {{WRAPPER}} .tp-coupon-item-img'
		    ]
		);

		$this->add_control(
		    'icon_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-img' => 'background-color: {{VALUE}} !important',
		        ],
		    ]
		);

		$this->add_control(
		    'icon_hover_bg_color',
		    [
		        'label' => esc_html__( 'Hover Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-coupon-item-img' => 'background-color: {{VALUE}} !important',
		        ],
		    ]
		);

		$this->add_control(
		    'icon_bg_rotate',
		    [
		        'label' => esc_html__( 'Background Rotate', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'deg' ],
		        'default' => [
		            'unit' => 'deg',
		        ],
		        'range' => [
		            'deg' => [
		                'min' => 0,
		                'max' => 360,
		            ],
		        ],
		        'selectors' => [
		            // Icon box transform styles
		            '(desktop){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
		            '(tablet){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
		            '(mobile){{WRAPPER}} .tp-coupon-item-img' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
		        ],
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_content_style',
		    [
		        'label' => esc_html__( 'Content', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'content_padding',
		    [
		        'label' => esc_html__( 'Content Box Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-content-wrapper ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'content_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-content-wrapper ' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'content_border',
		        'selector' => '{{WRAPPER}} .tp-coupon-item-content-wrapper ',
		    ]
		);

		$this->add_responsive_control(
		    'content_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-item-content-wrapper ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);		

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'content_box_shadow',
		        'exclude' => [
		            'box_shadow_position',
		        ],
		        'selector' => '{{WRAPPER}} .tp-coupon-item-content-wrapper '
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_title_style',
		    [
		        'label' => esc_html__( 'Title', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'title_typography',
		        'label' => esc_html__( 'Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}}  .themephi-addon-coupons .tp-coupon-title',
		    ]
		);

		$this->add_responsive_control(
		    'title_spacing',
		    [
		        'label' => esc_html__( 'Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}}  .themephi-addon-coupons .tp-coupon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'title_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		             '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-title,
					  {{WRAPPER}}  .themephi-addon-coupons .tp-coupon-title a' => 'color: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_control(
		    'title_hover_color',
		    [
		        'label' => esc_html__( 'Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [

		        	'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-title:hover,
		            {{WRAPPER}}   .themephi-addon-coupons .tp-coupon-title a:hover' => 'color: {{VALUE}}',
					
		        ],
		    ]
		);			

		$this->end_controls_section();


		
		$this->start_controls_section(
			'_section_style_desc',
		    [
			'label' => esc_html__( 'Description', 'tp-elements' ),
			'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'description_typography',
		        'label' => esc_html__( 'Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-desc',
		    ]
		);

		$this->add_responsive_control(
		    'description_spacing',
		    [
		        'label' => esc_html__( 'Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'description_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-desc p, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-desc' => 'color: {{VALUE}}',
		            
		        ],
		    ]
		);

		$this->add_control(
		    'description_hover_color',
		    [
		        'label' => esc_html__( 'Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .themephi-addon-coupons .tp-coupon-desc' => 'color: {{VALUE}}',
		        ],
		    ]
		);

		$this->end_controls_section();

		
		// Start Upper Meta
		$this->start_controls_section(
		    '_section_style_meta_upper',
		    [
		        'label' => esc_html__( 'Upper Meta', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
            'meta_upper_align',
            [
                'label' => esc_html__( 'Display Meta', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'start' => [
                        'title' => esc_html__( 'Start', 'tp-elements' ),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tp-elements' ),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'tp-elements' ),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'toggle' => true,
				'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .tp-coupon-meta.d-flex' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

		$this->add_responsive_control(
		    'meta_upper_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_upper_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_upper_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta',
		    ]
		);

		$this->add_control(
		    'meta_upper_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'hr_cat_two',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_cat_meta' );

		$this->start_controls_tab(
		    '_tab_cat_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_cat_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper ',
		    ]
		);

		$this->add_responsive_control(
		    'meta_cat_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_cat_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_cat_gap',
		    [
		        'label' => esc_html__( 'Gap', 'tp-elements' ),
		        'type' => \Elementor\Controls_Manager::SLIDER,
		        'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta .d-inline-flex' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_cat_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper',
		    ]
		);

		$this->add_control(
		    'meta_cat_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cat_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_cat_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper',
		    ]
		);

		$this->add_control(
		    'meta_cat_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'upper_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Meta Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_cat_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper i ',
		    ]
		);

		$this->add_responsive_control(
		    'meta_cat_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_cat_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_cat_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cat_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single-upper:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cat_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// End Upper Meta

		
		// Start Exclusive / Available Meta
		$this->start_controls_section(
			'_section_style_meta_exclusive',
			[
				'label' => esc_html__( 'Exclusive/Available Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_tabs_exclusive_meta' );

		$this->start_controls_tab(
		    '_tab_exclusive_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_exclusive_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive',
		    ]
		);

		$this->add_responsive_control(
		    'meta_exclusive_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_exclusive_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_exclusive_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive',
		    ]
		);

		$this->add_control(
		    'meta_exclusive_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_exclusive_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_exclusive_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive',
		    ]
		);

		$this->add_control(
		    'meta_exclusive_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'exclusive_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Exclusive/Available Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_exclusive_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i',
		    ]
		);

		$this->add_control(
		    'meta_exclusive_icon_svg_size',
		    [
		        'label' => esc_html__( 'SVG Font Size', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_exclusive_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'meta_exclusive_icon_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_exclusive_icon_color',
		    [
		        'label' => esc_html__( 'Icon Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_exclusive_icon_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_exclusive_icon_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg',
		    ]
		);

		$this->add_control(
		    'meta_exclusive_icon_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_exclusive_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_only_exclusive_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_exclusive_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_exclusive_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.tp-coupon-meta-exclusive:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

				
		// Start Favorite Meta
		$this->start_controls_section(
			'_section_style_meta_favorite',
			[
				'label' => esc_html__( 'Favorite Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_tabs_favorite_meta' );

		$this->start_controls_tab(
		    '_tab_favorite_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_favorite_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark',
		    ]
		);

		$this->add_responsive_control(
		    'meta_favorite_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_favorite_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_favorite_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark',
		    ]
		);

		$this->add_control(
		    'meta_favorite_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_favorite_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_favorite_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark',
		    ]
		);

		$this->add_control(
		    'meta_favorite_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'favoriite_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Favorite Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_favorite_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark i',
		    ]
		);

		$this->add_control(
		    'meta_favorite_icon_svg_size',
		    [
		        'label' => esc_html__( 'SVG Font Size', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_favorite_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_favorite_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_only_favorite_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_favorite_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single-upper.favorite-bookmark:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_favorite_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single-upper.favorite-bookmark:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		/* Rich Description */
		$this->start_controls_section(
			'_section_style_rich_desc',
		    [
			'label' => esc_html__( 'Rich Description', 'tp-elements' ),
			'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'rich_description_typography',
		        'label' => esc_html__( 'Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher',
		    ]
		);
		
		$this->add_responsive_control(
		    'rich_description_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_responsive_control(
		    'rich_description_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_control(
		    'rich_description_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher' => 'color: {{VALUE}}',
		            
		        ],
		    ]
		);

		$this->add_control(
		    'rich_description_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'rich_description_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher',
		    ]
		);

		$this->add_control(
		    'rich_description_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'rich_description_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-store-voucher',
		    ]
		);

		$this->end_controls_section();

					
		// Start Price Meta
		$this->start_controls_section(
			'_section_style_meta_price',
			[
				'label' => esc_html__( 'Price', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_tabs_price_meta' );

		$this->start_controls_tab(
		    '_tab_price_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_price_typography',
				'label' => esc_html__( 'Price Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_del_price_typography',
				'label' => esc_html__( 'Del Price Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price.tp-coupon-price-del',
		    ]
		);

		$this->add_responsive_control(
		    'meta_price_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_price_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_price_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price',
		    ]
		);

		$this->add_control(
		    'meta_price_color',
		    [
		        'label' => esc_html__( 'Price Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_del_price_color',
		    [
		        'label' => esc_html__( 'Del Price Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price.tp-coupon-price-del' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_price_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_price_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price',
		    ]
		);

		$this->add_control(
		    'meta_price_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_price_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_only_price_hover_color',
		    [
		        'label' => esc_html__( 'Price Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_del_price_hover_color',
		    [
		        'label' => esc_html__( 'Del Price Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price.tp-coupon-price-del:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_price_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single.tp-coupon-meta-price:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_price_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-price:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

						
		// Start Discount Meta
		$this->start_controls_section(
			'_section_style_meta_discount',
			[
				'label' => esc_html__( 'Discount Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_tabs_discount_meta' );

		$this->start_controls_tab(
		    '_tab_discount_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_discount_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount',
		    ]
		);

		$this->add_responsive_control(
		    'meta_discount_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_discount_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_discount_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount',
		    ]
		);

		$this->add_control(
		    'meta_discount_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_discount_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_discount_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount',
		    ]
		);

		$this->add_control(
		    'meta_discount_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_discount_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_only_discount_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_discount_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single.tp-coupon-meta-discount:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_discount_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-discount:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		
		// Start Cashback Meta
		$this->start_controls_section(
			'_section_style_meta_cashback',
			[
				'label' => esc_html__( 'Cashback Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_tabs_cashback_meta' );

		$this->start_controls_tab(
		    '_tab_cashback_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_cashback_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback',
		    ]
		);

		$this->add_responsive_control(
		    'meta_cashback_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_cashback_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_cashback_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback',
		    ]
		);

		$this->add_control(
		    'meta_cashback_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cashback_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_cashback_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback',
		    ]
		);

		$this->add_control(
		    'meta_cashback_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'cashback_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Date Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_cashback_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback i',
		    ]
		);

		$this->add_control(
		    'meta_cashback_icon_svg_size',
		    [
		        'label' => esc_html__( 'SVG Font Size', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_cashback_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_cashback_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_only_cashback_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cashback_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-single.tp-coupon-meta-cashback:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_cashback_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-single.tp-coupon-meta-cashback:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		// Start Bottom Meta
		$this->start_controls_section(
			'_section_style_meta_bottom',
			[
				'label' => esc_html__( 'Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'meta_margin',
			[
				'label' => esc_html__( 'Margin', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'meta_border',
				'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta',
			]
		);

		$this->add_control(
			'meta_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hr_meta_two',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_tabs_bottom_meta' );

		$this->start_controls_tab(
			'_tab_meta_normal',
			[
				'label' => esc_html__( 'Normal', 'tp-elements' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item ',
			]
		);

		$this->add_responsive_control(
		    'meta_bottom_gap',
		    [
		        'label' => esc_html__( 'Gap', 'tp-elements' ),
		        'type' => \Elementor\Controls_Manager::SLIDER,
		        'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-before-button-meta' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
		    ]
		);

		$this->add_responsive_control(
			'meta_bottom_margin',
			[
				'label' => esc_html__( 'Margin', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_bottom_padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'meta_bottom_box_shadow',
				'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item',
			]
		);

		$this->add_control(
			'meta_bottom_color',
			[
				'label' => esc_html__( 'Text Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_bottom_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'meta_bottom_border',
				'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item',
			]
		);

		$this->add_control(
			'meta_bottom_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	
		$this->add_control(
			'meta_icon_only',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Meta Icon', 'tp-elements' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_icon_typography',
				'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item i ',
			]
		);

		$this->add_control(
		    'meta_icon_svg_size',
		    [
		        'label' => esc_html__( 'SVG Font Size', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
			'meta_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_bottom_meta_hover',
			[
				'label' => esc_html__( 'Hover', 'tp-elements' ),
			]
		);

		$this->add_control(
			'meta_bottom_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_bottom_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_bottom_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-info-list-item:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// Start earn and share Meta
		$this->start_controls_section(
			'_section_style_meta_share',
			[
				'label' => esc_html__( 'Share Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'coupon_style' => ['style3'],
				],
			]
		);

		$this->start_controls_tabs( '_tabs_share_meta' );

		$this->start_controls_tab(
		    '_tab_share_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_share_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share',
		    ]
		);

		$this->add_responsive_control(
		    'meta_share_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_share_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_share_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share',
		    ]
		);

		$this->add_control(
		    'meta_share_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_share_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_share_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share',
		    ]
		);

		$this->add_control(
		    'meta_share_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'share_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Share Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_share_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share i ',
		    ]
		);

		$this->add_responsive_control(
		    'meta_share_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_share_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_share_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_share_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .toggle-coupon-share:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_share_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share:hover, {{WRAPPER}} .themephi-addon-coupons .toggle-coupon-share:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// End Share Meta
				
		// Start After Button Meta
		$this->start_controls_section(
		    '_section_style_meta_under',
		    [
		        'label' => esc_html__( 'Under Meta', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
            'meta_after_under_align',
            [
                'label' => esc_html__( 'Display Meta', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'tp-elements' ),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'start' => [
                        'title' => esc_html__( 'Start', 'tp-elements' ),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tp-elements' ),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'tp-elements' ),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'toggle' => true,
				'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .tp-coupon-after-button-meta.d-flex' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

		$this->add_responsive_control(
		    'meta_after_under_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_after_under_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_after_under_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta ',
		    ]
		);

		$this->add_control(
		    'meta_after_under_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'hr_after_under_two',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_under_meta' );

		$this->start_controls_tab(
		    '_tab_after_under__meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_after_under_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item ',
		    ]
		);

		$this->add_responsive_control(
		    'meta_under_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_under_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'meta_under_icon_gap',
		    [
		        'label' => esc_html__( 'Gap', 'tp-elements' ),
		        'type' => \Elementor\Controls_Manager::SLIDER,
		        'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta .d-inline-flex, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-after-button-meta .d-inline-flex .feedback-record-action' => 'gap: {{SIZE}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_under_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item',
		    ]
		);

		$this->add_control(
		    'meta_under_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item a, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item svg' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_under_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_under_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item',
		    ]
		);

		$this->add_control(
		    'meta_under_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
	
		$this->add_control(
		    'met_under_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Meta Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_under_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item i ',
		    ]
		);

		$this->add_responsive_control(
		    'meta_under_icon_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item i, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_under_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_under_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item:hover a, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item:hover svg' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_under_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons  .tp-coupon-meta-after-button-item:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_under_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-meta-after-button-item:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// End Under Meta


		$this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Button', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
            'normal_btn_align',
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
                    '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button' => 'justify-content: {{VALUE}}',
                ],
				'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
		    'link_wrapper_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_responsive_control(
		    'link_wrapper_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_wrapper_border',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button',
		    ]
		);

		$this->add_control(
		    'hr_three',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
		    '_tab_button_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .coupon-action-button',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button',
		    ]
		);

		$this->add_control(
		    'link_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_translate',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button.icon-before i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button.icon-after i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_button_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'button_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:hover, {{WRAPPER}} .elementor-widget-container .themephi-addon-coupons:focus .coupon-action-button' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:hover, {{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .tp-coupon-button:focus .coupon-action-button' => 'background-color: {{VALUE}};',
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover, {{WRAPPER}} .themephi-addon-coupons .tp-coupon-button:focus .coupon-action-button' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'condition' => [
		            'button_border_border!' => '',
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons:hover .coupon-action-button, {{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:focus' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_hover_icon_translate',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons:hover .coupon-action-button.icon-before i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button.icon-after i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		
		$this->add_control(
		    'btn_text_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Button Text', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);
		
		$this->add_responsive_control(
		    'btn_text_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button .code-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_text_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button .code-text,
		        {{WRAPPER}} .themephi-addon-coupons .coupon-action-button .code-text',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'btn_text_border',
		        'selector' => '{{WRAPPER}} .coupon-action-button .code-text',
		    ]
		);

		$this->add_control(
		    'btn_text_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button .code-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'btn_text_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button .code-text',
		    ]
		);

		$this->add_control(
		    'hr_four',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_btn_text' );

		$this->start_controls_tab(
		    '_tab_btn_text_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'btn_text_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button .code-text' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button .code-text' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_btn_text_hover',
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
		            '{{WRAPPER}}  .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover .code-text' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover .code-text' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:hover .code-text, {{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:focus .code-text' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
		    'button_icon_only',
		    [
		        'type' => Controls_Manager::HEADING,
		        'label' => esc_html__( 'Button Icon', 'tp-elements' ),
		        'separator' => 'before'
		    ]
		);

		$this->add_responsive_control(
		    'button_icon_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'button_icon_typography',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button i,
		        {{WRAPPER}} .themephi-addon-coupons .coupon-action-button i',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_icon_border',
		        'selector' => '{{WRAPPER}} .coupon-action-button i',
		    ]
		);

		$this->add_control(
		    'button_icon_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_icon_box_shadow',
		        'selector' => '{{WRAPPER}} .themephi-addon-coupons .coupon-action-button i',
		    ]
		);

		$this->add_control(
		    'hr_five',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_button_icon' );

		$this->start_controls_tab(
		    '_tab_button_icon_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'button_icon_color',
		    [
		        'label' => esc_html__( 'Icon Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button i' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_button_icon_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'button_icon_hover_color',
		    [
		        'label' => esc_html__( 'Icon Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:focus i' => 'color: {{VALUE}};',
		            '{{WRAPPER}}  .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .tp-coupon-button:focus .coupon-action-button:hover i' => 'background-color: {{VALUE}};',
		            '{{WRAPPER}} .themephi-addon-coupons .tp-coupon-button .coupon-action-button:hover i' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:hover i, {{WRAPPER}} .elementor-widget-container .themephi-addon-coupons .coupon-action-button:focus i' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
 
		$this->start_controls_section(
		    '_section_style_pagination',
		    [
		        'label' => esc_html__( 'Pagination', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'margin_pagination',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'pagination_typography',
		        'selector' => '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span',
		    ]
		);

		$this->add_responsive_control(
            'pagination_align',
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
                    '{{WRAPPER}} .tp-coupons-wrapper ul.page-numbers' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
            ]
        );

		$this->add_control(
		    'hr_six',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_pagination' );

		$this->start_controls_tab(
		    '_tab_pagination_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);
		
		$this->add_responsive_control(
		    'padding_pagination',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_control(
		    'pagination_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'pagination_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'pagination_button_border',
		        'selector' => '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span',
		    ]
		);

		$this->add_control(
		    'pagination_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'pagination_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'condition' => [
		            'button_border_border!' => '',
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'pagination_button_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupons-wrapper ul li a, {{WRAPPER}} .tp-coupons-wrapper ul li span',
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_pagination_hover',
		    [
		        'label' => esc_html__( 'Hover/Active', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'pagination_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'pagination_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'pagination_hover_border',
		        'selector' => '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current',
		    ]
		);

		$this->add_control(
		    'pagination_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'tp_pagination_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'condition' => [
		            'button_border_border!' => '',
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'pagination_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupons-wrapper ul li a:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span:hover, {{WRAPPER}} .tp-coupons-wrapper ul li span.current',
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

		$sstyle = $settings['coupon_style'];
		$unique = rand(2012,35120);

			if( $settings['coupon_grid_source'] == 'slider' ) {
						
				$col_xxl          = $settings['col_xxl'];
				$col_xxl          = !empty($col_xxl) ? $col_xxl : 5;
				$slidesToShow    = $col_xxl;
				$autoplaySpeed   = $settings['slider_autoplay_speed'];
				$autoplaySpeed = !empty($autoplaySpeed) ? $autoplaySpeed : '1000';
				$interval        = $settings['slider_interval'];
				$interval = !empty($interval) ? $interval : '3000';
				$slidesToScroll  = $settings['slides_ToScroll'];
				$slider_autoplay = $settings['slider_autoplay'] === 'true' ? 'true' : 'false';
				$pauseOnHover    = $settings['slider_stop_on_hover'] === 'true' ? 'true' : 'false';
				$pauseOnInter    = $settings['slider_stop_on_interaction'] === 'true' ? 'true' : 'false';
				$sliderDots      = $settings['slider_dots'] == 'true' ? 'true' : 'false';       
				$infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
				$centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
				$col_xl          = $settings['col_xl'];
				$col_lg          = $settings['col_lg'];
				$col_md          = $settings['col_md'];
				$col_sm          = $settings['col_sm'];
				$col_xs          = $settings['col_xs'];
				$item_gap = $settings['item_gap_custom']['size'];
				$item_gap = !empty($item_gap) ? $item_gap : '0';

				if( $slider_autoplay =='true' ){
					$slider_autoplay = 'autoplay: { ' ;
					$slider_autoplay .= 'delay: '.$interval;
					if(  $pauseOnHover =='true'  ){
						$slider_autoplay .= ', pauseOnMouseEnter: true';
					}else{
						$slider_autoplay .= ', pauseOnMouseEnter: false';
					}
					if(  $pauseOnInter =='true'  ){
						$slider_autoplay .= ', disableOnInteraction: true';
					}else{
						$slider_autoplay .= ', disableOnInteraction: false';
					}
					$slider_autoplay .= ' }';
				}else{
					$slider_autoplay = 'autoplay: false' ;
				}

			}	

			$orderby = $settings['coupon_orderby'];
			$order   = $settings['coupon_order'];
			$paged   = (get_query_var('paged')) ? get_query_var('paged') : 1;

			$meta_query = [];

			// Add coupon_type filter
			if (!empty($coupon_type)) {
				$meta_query[] = array(
					'key'     => 'ctype',
					'value'   => $coupon_type,
					'compare' => '=',
				);
			}

			// Setup base args
			$args = [
				'post_type'      => 'coupon',
				'posts_per_page' => $settings['per_page'],
				'paged'          => $paged,
				'order'          => $order,
				'meta_query'     => $meta_query,
			];

			// Custom order logic
			switch ( $orderby ) {
				case 'popular':
					$args['meta_key'] = 'used';
					$args['orderby']  = 'meta_value_num';
					break;

				case 'ending':
					$args['meta_key']  = 'expire';
					$args['orderby']  = 'meta_value_num';
					break;

				case 'rand':
					$args['orderby'] = 'rand';
					break;

				case 'title':
					$args['orderby'] = 'title';
					break;

				default: 
					$args['orderby'] = 'date';
					break;
			}

			// Taxonomy filters
			if (!empty($cat) || !empty($store)) {
				$args['tax_query'] = array(
					'relation' => 'OR',
				);

				if (!empty($cat)) {
					$args['tax_query'][] = array(
						'taxonomy' => 'coupon-category',
						'field'    => 'slug',
						'terms'    => $cat,
					);
				}

				if (!empty($store)) {
					$args['tax_query'][] = array(
						'taxonomy' => 'coupon-store',
						'field'    => 'slug',
						'terms'    => $store,
					);
				}
			}

			$best_wp = new WP_Query($args);

			?>

			<style>
			.share-coupon {
				display: none;
			}
			.share-coupon.open-share {
				display: block;
			}
			.favorite-bookmark {
				cursor: pointer;
				color: gray; 
				transition: color 0.3s ease;
			}
			.favorite-bookmark.favorite {
				color: #B3682B; 
			}
			.favorite-bookmark:hover {
				color: #B3682B; 
			}
			.tp-coupons-navigation {
				display: flex;
			}
			.tp-coupons-wrapper.true .tp-coupons-navigation > span  {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                left: 0px;
                z-index: 2;
            }
            .tp-coupons-wrapper.true .tp-coupons-navigation > span.tp-coupons-slide-next {
                left: auto;
                right: 0px;
            }

			.expansion-right {
				margin-right: -290px;
			}

			@media screen and (max-width: 767px) {
				.expansion-right {
					margin-right: 0px;
				}
			}

			</style>

			<?php

			$terms = get_terms( array(
				'taxonomy'    => 'coupon-category',
				'hide_empty'  => true            
				) 
			);
			
			if( !empty($terms) && !is_wp_error($terms) ) { ?>
			<?php if($settings['show_filter'] == 'filter_show') : ?>	
			<div class="coupon-filter coupon-filter-<?php echo esc_attr( $unique ); ?>">
				<button class="active" data-filter="*">
					<?php if( $settings['enable_filter_icon'] == 'yes' ) : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cat.png' ); ?>" >
					<?php endif; ?>
					<?php echo esc_html($settings['filter_title']);?>
				</button>
				<?php $taxonomy = "coupon-category";
					$select_cat = $settings['coupon_category'];
					if( !empty($select_cat) && !is_wp_error($select_cat) ) {
					foreach ($select_cat as $catid) {
					$term = get_term_by('slug', $catid, $taxonomy);
					$term_name  =  $term->name;
					$term_slug  =  $term->slug;

					$cat_id = get_term_meta($term->term_id, 'category_icon', true);
					if ($cat_id) {
						$cat_img = wp_get_attachment_url($cat_id);
					} else {
						$cat_img = ''; // Default image or empty if no image is set
					}

				?>
				<button data-filter=".filter_<?php echo esc_html($term_slug);?>">
					<?php if( $settings['enable_filter_icon'] == 'yes' ) : ?>
					<img src="<?php echo esc_url($cat_img); ?>" >
					<?php endif; ?>
					<?php echo esc_html($term_name);?>
				</button>
				<?php  } }
				
				?>

			</div>
			<?php endif; ?>

			<div class="tp-coupons-wrapper <?php echo esc_attr( $settings['slider_nav_position'] ); ?> coupons-wrapper-<?php echo esc_attr( $settings['coupon_style'] ); ?> position-relative ">
                <?php if( $settings['coupon_grid_source'] == 'dynamic' ) : ?>
                    <div class="tp-coupons-dynamic-wrapp <?php if($settings['show_filter'] == 'filter_show') : ?> grid-<?php echo esc_attr( $unique ); ?> <?php endif; ?> ">
                    <div class="row <?php if ( $settings['enable_item_gutter'] == 'yes' ) : ?>  g-0 <?php endif; ?>" <?php if ( $settings['enable_item_massonry'] == 'yes' ) : ?>  data-masonry='{ "percentPosition": false }' <?php endif; ?> >
                <?php elseif( $settings['coupon_grid_source'] == 'slider' ) : ?>
                    <div class="tp-coupons-slider-<?php echo esc_attr($unique); ?> swiper <?php echo esc_attr( $settings['coupon_exapansion'] ); ?> ">
                        <div class="swiper-wrapper ">
                <?php else : ?>
                <?php endif; ?>

					<?php
					//$post_counter = 01;
					$x=1;
					while($best_wp->have_posts()): $best_wp->the_post();

					$post_id = get_the_ID();

					$termsArray  = get_the_terms( $post_id, "coupon-category" );  //Get the terms for this particular item
					$termsString = ""; //initialize the string that will contain the terms
					$termsSlug   = "";
			
					foreach ( $termsArray as $term ) { 
						$termsString .= 'filter_'.$term->slug.' '; 
						$termsSlug .= $term->name;
					}	

					$coupon_regular_price = get_post_meta( $post_id, 'coupon_regular_price', true );
					$coupon_sale_price = get_post_meta( $post_id, 'coupon_sale_price', true );
					
					if ( $coupon_regular_price && $coupon_sale_price && $coupon_regular_price > 0 ) {
						$discount_percentage = ( ( $coupon_regular_price - $coupon_sale_price ) / $coupon_regular_price ) * 100;
						$discount_percentage = round( $discount_percentage ); // round to nearest whole number
					} else {
						$discount_percentage = 0;
					}

					$coupon_cashback = get_post_meta( $post_id, 'coupon_cashback', true );
					$coupon_affiliate = get_post_meta( $post_id, 'coupon_affiliate', true );
					$coupon_spec_link = get_post_meta( $post_id, 'coupon_spec_link', true );

					if( !empty( $coupon_spec_link ) ) {
						$coupon_affiliate = $coupon_spec_link;
					} else {
						$coupon_affiliate = $coupon_affiliate;
					}

					$coupon_url = get_post_meta( $post_id, 'coupon_url', true );

					$verified = get_post_meta( $post_id, 'verified', true );
					$exclusive = get_post_meta( $post_id, 'exclusive', true );

					$expire_timestamp = get_post_meta( get_the_ID(), 'expire', true );
					$used = get_post_meta( $post_id, 'used', true );
					$current_used = tp_register_coupon_used( $post_id, $used );

					$att = get_post_thumbnail_id();
					$image_src = wp_get_attachment_image_src($att, 'full');
					if (!empty($image_src)) {
						$image_src = $image_src[0];
					}

					// Category
					$categories = get_the_terms($post_id, 'coupon-category');

					if ($categories && !is_wp_error($categories)) {
						foreach ($categories as $category) {
							$category_name = $category->name;

							$cat_image_id = get_term_meta($category->term_id, 'category_icon', true);

							if ($cat_image_id) {
								$cat_image_url = wp_get_attachment_image_url($cat_image_id, 'full'); 
								
							}
						}
					}

					// Store
					$stores = get_the_terms($post_id, 'coupon-store'); 

					if ($stores && !is_wp_error($stores)) {
						foreach ($stores as $store) {
							$store_name = $store->name;
							$store_description = $store->description;
							$store_rich_description = get_term_meta( $store->term_id, 'store_rich_description', true );
							$store_address = get_term_meta( $store->term_id, 'store_address', true );
							$store_link = get_term_link($store);
							$store_image_id = get_term_meta($store->term_id, 'store_image', true);
							if ($store_image_id) {
								$store_image_url = wp_get_attachment_image_url($store_image_id, 'full'); 
							}

						}
					}

 
					if(!empty($settings['title_word_count'])){
						$title_limit = $settings['title_word_count']; 
					}
					else{
						$title_limit = 20;
					}
					if(!empty($settings['coupon_text_word_limit'])){
						$text_limit = $settings['coupon_text_word_limit']; 
					}
					else{
						$text_limit = 20;
					}

                    if( $settings['coupon_grid_source'] == 'dynamic' ) {

                        if($sstyle){
                            require plugin_dir_path(__FILE__)."/dynamic/$sstyle.php";
                        }else{
                            require plugin_dir_path(__FILE__)."/dynamic/style1.php";
                        }

                    }


                    if( $settings['coupon_grid_source'] == 'slider' ) {

                        if($sstyle){
                            require plugin_dir_path(__FILE__)."/slider/$sstyle.php";
                        }else{
                            require plugin_dir_path(__FILE__)."/slider/style1.php";
                        }

                    }

					//$post_counter++;
					$x++;
					endwhile;
					wp_reset_query();  
					?>  
                
                <?php if( $settings['coupon_grid_source'] == 'dynamic' || $settings['coupon_grid_source'] == 'slider' ) : ?>
				    </div>
				</div>
                <?php endif; ?>

				<?php 
					if( $settings['coupon_pagination_show_hide'] == 'yes' ) {
						echo paginate_links(
							array(
								'total'      => $best_wp->max_num_pages,
								'type'       => 'list',
								'current'    => max( 1, $paged ),
								'prev_text'  => '<i class="fa fa-angle-left"></i>',
								'next_text'  => '<i class="fa fa-angle-right"></i>'
							)
						);
					}
				?>
				<!-- slider navigation and pagination start -->
				<?php if( $settings['coupon_grid_source'] == 'slider' ) : 
				if( $settings['slider_dots'] == 'true' ) : ?>
				<div class="tp-coupons-pagination swiper-pagination"></div>
				<?php endif; ?>
				<?php if( $settings['slider_nav'] == 'true' ) : ?>
				<div class="tp-coupons-navigation">
					<span class="tp-coupons-slide-prev box-style"><i class="tp tp-arrow-left"></i></span>
					<span class="tp-coupons-slide-next box-style"><i class="tp tp-arrow-right"></i></span>
				</div>
				<?php endif; endif; ?>
				<!-- slider navigation and pagination end -->

			</div>
			<script>
				jQuery(document).ready(function($) {

					$('.toggle-coupon-share-<?php echo esc_attr( $unique ); ?>').on('click', function() {
						var target = $(this).data('target'); 
						var shareDiv = $('.share-coupon.' + target); 
						shareDiv.toggleClass('open-share');
						$('.share-coupon').not(shareDiv).removeClass('open-share');
					});
					
				});

				// JS for Filter
				jQuery(window).load(function($) {

					// image loaded portfolio init
					jQuery('.grid-<?php echo esc_attr( $unique ); ?>').imagesLoaded(function() {
						jQuery('.coupon-filter-<?php echo esc_attr( $unique ); ?>').on('click', 'button', function() {
							var filterValue = jQuery(this).attr('data-filter');
							$grid.isotope({
								filter: filterValue
							});
						});
						var $grid = jQuery('.grid-<?php echo esc_attr( $unique ); ?>').isotope({
							animationOptions: {
							duration: 750,
							easing: 'linear',
							queue: false
						},

							itemSelector: '.grid-item',
							percentPosition: true,
							masonry: {
								columnWidth: '.grid-item',
							}
						});
					});
					jQuery('.coupon-filter-<?php echo esc_attr( $unique ); ?> button').on('click', function(event) {
						jQuery(this).siblings('.active').removeClass('active');
						jQuery(this).addClass('active');
						event.preventDefault();
					});

				});  

			</script>

			<?php if( $settings['coupon_grid_source'] == 'slider' ) : ?>

			<script type="text/javascript"> 
            jQuery(document).ready(function(){
                    
                var swiper = new Swiper(".tp-coupons-slider-<?php echo esc_attr($unique); ?>", {				
                    slidesPerView: <?php echo $slidesToShow;?>,
                    speed: <?php echo esc_attr($autoplaySpeed); ?>,
                  
                    loop: <?php echo esc_attr($infinite ); ?>,
                   <?php echo esc_attr($slider_autoplay); ?>,
                   spaceBetween:  <?php echo esc_attr($item_gap); ?>,
                   pagination: {
                       el: ".tp-coupons-pagination",
                       clickable: true,
                    },
                    centeredSlides: <?php echo esc_attr($centerMode); ?>,
                    navigation: {
                        nextEl: ".tp-coupons-slide-next",
                        prevEl: ".tp-coupons-slide-prev",
                    },
                    breakpoints: {
                        0: { slidesPerView: <?php echo $col_xs;?>},
                        <?php
                        echo (!empty($col_xs)) ?  '0: { slidesPerView: '. $col_xs .' },' : '';
                        echo (!empty($col_sm)) ?  '575: { slidesPerView: '. $col_sm .' },' : '';
                        echo (!empty($col_md)) ?  '767: { slidesPerView: '. $col_md .' },' : '';
                        echo (!empty($col_lg)) ?  '991: { slidesPerView: '. $col_lg .' },' : '';
                        echo (!empty($col_xl)) ?  '1199: { slidesPerView: '. $col_xl .' },' : '';
                        ?>
                        1399: {
                            slidesPerView: <?php echo esc_attr($col_xxl); ?>,
                            spaceBetween:  <?php echo esc_attr($item_gap); ?>
                        }
                    }
                });
			
			});
			</script>
			<?php endif; ?>

		<?php 
		} else {
			$admin_tp_url = admin_url('term.php?taxonomy=coupon-category&post_type=coupon');
			echo '<div class="text-center"><a href=" '. $admin_tp_url .' " class="btn btn-danger">Create Coupon Category & Add to Coupon Post</a></div>';
		}
	}
	public function getCategories(){
        $cat_list = [];
             if ( post_type_exists( 'coupon' ) ) { 
              $terms = get_terms( array(
                 'taxonomy'    => 'coupon-category',
                 'hide_empty'  => true            
             ) ); 
            foreach($terms as $post) {
                $cat_list[$post->slug]  = [$post->name];
            }
        }  
        return $cat_list;
    }

	public function getStores(){
        $store_list = [];
             if ( post_type_exists( 'coupon' ) ) { 
              $terms = get_terms( array(
                 'taxonomy'    => 'coupon-store',
                 'hide_empty'  => true            
             ) ); 
            foreach($terms as $post) {
                $store_list[$post->slug]  = [$post->name];
            }
        }  
        return $store_list;
    }
	
}