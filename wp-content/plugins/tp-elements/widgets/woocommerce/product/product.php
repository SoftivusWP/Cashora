<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Product_Widget extends \Elementor\Widget_Base {

	 
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
		return 'tp-product';
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
		return esc_html__( 'TP Product', 'tp-elements' );
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
			'section_product',
			[
				'label' => esc_html__( 'Product Global', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'product_style',
			[
				'label'   => esc_html__( 'Select Product Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'tp-elements'),
					'style2' => esc_html__( 'Style 2', 'tp-elements'),		
				],
			]
		);
		
		$this->add_control(
			'product_grid_source',
			[
				'label'   => esc_html__( 'Select Service Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',				
				'options' => [
					'slider' => esc_html__('Slider', 'tp-elements'),
					'dynamic' => esc_html__('Dynamic', 'tp-elements')					
				],											
			]
		);

		$this->add_control(
			'product_category',
			[
				'label'   => esc_html__( 'Category', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getProductCategories(),
				'multiple' => true,	
				'separator' => 'before',	
				'condition' => [
					'product_grid_source' => ['dynamic', 'slider'],
				],	
			]
		);

		$this->add_control(
            'product_sorting',
            [
                'label'   => esc_html__( 'Product Order By', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'date',
                'options' => [
                    'date' => esc_html__( 'Date', 'tp-elements' ), 
                    'title' => esc_html__( 'Title', 'tp-elements' ),
                    'rand' => esc_html__( 'Random', 'tp-elements' ),
                    'ID' => esc_html__( 'ID', 'tp-elements' ),
                    'menu_order' => esc_html__( 'Menu Order', 'tp-elements' ),
                    'modified' => esc_html__( 'Modified', 'tp-elements' ),
                    'comment_count' => esc_html__( 'Comments', 'tp-elements' ),              
                    'meta_value_num_price' => esc_html__( 'Price', 'tp-elements' ),                
                    'meta_value_num_rating' => esc_html__( 'Rating/Review', 'tp-elements' ),              
                    'meta_value_num_sales' => esc_html__( 'Sales', 'tp-elements' ),                
                ],
                'separator' => 'before',
				'condition' => [
					'product_grid_source' => ['dynamic', 'slider'],
				],	        
            ]
            
        );

		$this->add_control(
            'product_order',
            [
                'label'   => esc_html__( 'Product Order', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'tp-elements' ), 
                    'DESC' => esc_html__( 'Descending', 'tp-elements' ),              
                ],
                'separator' => 'before',
				'condition' => [
					'product_grid_source' => ['dynamic', 'slider'],
				],	        
            ]
            
        );

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Product Show Per Page', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
					'product_grid_source' => ['dynamic', 'slider'],
				],
			]
		);

		$this->add_control(
            'product_col_xxl',
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
					'product_grid_source' => 'dynamic',
				],	        
            ]
            
        );

		$this->add_control(
            'product_col_xl',
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
					'product_grid_source' => 'dynamic',
				],	        
            ]
            
        );

		$this->add_control(
            'product_col_lg',
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
					'product_grid_source' => 'dynamic',
				],	        
            ]
            
        );

        $this->add_control(
            'product_col_md',
            [
                'label'   => esc_html__( 'Desktops > 767px', 'tp-elements' ),
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
					'product_grid_source' => 'dynamic',
				],           
            ]
            
        );

        $this->add_control(
            'product_col_sm',
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
					'product_grid_source' => 'dynamic',
				],           
            ] 
        );

        $this->add_control(
            'product_col_xs',
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
					'product_grid_source' => 'dynamic',
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
                    '{{WRAPPER}} .tp-single-product .services-part' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
            ]
        );

		$this->add_control(
            'product_pagination_show_hide',
            [
                'label' => esc_html__( 'Pagination Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'product_grid_source' => 'dynamic',
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
            'title_word_count',
            [
                'label' => esc_html__( 'Title Word Count', 'tp-elements' ),
                'type' => Controls_Manager::NUMBER, 
				'condition' => [
					'product_grid_source' => 'dynamic',
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
		        'default' => 'h2',
		        'toggle' => false,
		    ]
		);
		$this->add_control(
            'product_text_show_hide',
            [
                'label' => esc_html__( 'Services Text Show / Hide', 'tp-elements' ),
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
            'product_text_word_limit',
            [
                'label' => esc_html__( 'Show Content Limit', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '20', 'tp-elements' ),
                'separator' => 'before',
                'condition' => [
                    'product_text_show_hide' => 'yes',
					'product_grid_source' => 'dynamic',
                ]
            ]
        );

		$this->end_controls_section();	

		$this->start_controls_section(
			'section_meta',
			[
				'label' => esc_html__( 'Product Meta', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'product_meta_show_hide',
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
		$this->add_control(
            'product_cat_show_hide',
            [
                'label' => esc_html__( 'Category Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'product_meta_show_hide' => ['yes'],
					'product_grid_source' => 'dynamic',
				],
            ]
        );
		$this->add_control(
            'product_trainer_show_hide',
            [
                'label' => esc_html__( 'Trainer Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'product_meta_show_hide' => ['yes'],
					'product_grid_source' => 'dynamic',
				],
            ]
        );
		$this->add_control(
            'product_schedule_show_hide',
            [
                'label' => esc_html__( 'Schedule Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'product_meta_show_hide' => ['yes'],
					'product_grid_source' => 'dynamic',
				],
            ]
        );
		$this->add_control(
            'product_fee_show_hide',
            [
                'label' => esc_html__( 'Fee Show / Hide', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'tp-elements' ),
                    'no' => esc_html__( 'No', 'tp-elements' ),
                ],                
                'separator' => 'before',
				'condition' => [
					'product_meta_show_hide' => ['yes'],
					'product_grid_source' => 'dynamic',
				],
            ]
        );

		$this->end_controls_section();	

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'product_btn_show_hide',
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
			'product_btn_text',
			[
				'label' => esc_html__( 'Services Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'View Service',
				'placeholder' => esc_html__( 'Services Button Text', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
					'product_btn_show_hide' => ['yes'],
				],
			]
		);

		$this->add_control(
			'product_btn_link_open',
			[
				'label'   => esc_html__( 'Link Open New Window', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [					
					'no' => esc_html__( 'No', 'tp-elements'),
					'yes' => esc_html__( 'Yes', 'tp-elements'),
				],
				'condition' => [
					'product_btn_show_hide' => ['yes'],
				],
			]
		);

		$this->add_control(
			'product_btn_icon',
			[
				'label' => esc_html__( 'Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'solid',
				],			
				'separator' => 'before',	
				'condition' => [
					'product_btn_show_hide' => ['yes'],
				],		
			]
		);

		$this->add_control(
		    'product_btn_icon_position',
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
		            'product_btn_icon!' => '',
					'product_btn_show_hide' => ['yes'],
		        ],
		    ]
		); 

		$this->add_control(
		    'product_btn_icon_spacing',
		    [
		        'label' => esc_html__( 'Icon Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		       
		        'condition' => [
		            'product_btn_icon!' => '',
					'product_btn_show_hide' => ['yes'],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product .services-part .tp-single-product-text .services-btn-part .services-btn.icon-before i' => 'margin-right: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .tp-single-product .services-part .tp-single-product-text .services-btn-part .services-btn.icon-after i' => 'margin-left: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

				
        $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT, 
				'condition' => [
					'product_grid_source' => 'slider',
				],              
            ]
        );

        $this->add_control(
            'col_xl',
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
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'tp-elements' ),
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
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 767px', 'tp-elements' ),
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
                'label'   => esc_html__( 'Tablets < 768px', 'tp-elements' ),
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
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Item', 'tp-elements' ),
                    '2' => esc_html__( '2 Item', 'tp-elements' ),
                    '3' => esc_html__( '3 Item', 'tp-elements' ),
                    '4' => esc_html__( '4 Item', 'tp-elements' ),                   
                ],
                'separator' => 'before',
                            
            ]
            
        );      
        $this->add_control(
            'rt_pslider_effect',
            [
                'label' => esc_html__('Slider Effect', 'tp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
					'default' => esc_html__('Default', 'tp-elements'),					
					'fade' => esc_html__('Fade', 'tp-elements'),
					'flip' => esc_html__('Flip', 'tp-elements'),
					'cube' => esc_html__('Cube', 'tp-elements'),
					'coverflow' => esc_html__('Coverflow', 'tp-elements'),
					'creative' => esc_html__('Creative', 'tp-elements'),
					'cards' => esc_html__('Cards', 'tp-elements'),
                ],
            ]
        );

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
        $this->add_control(
            'slider_dots_color',
            [
                'label' => esc_html__( 'Navigation Dots Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
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
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_dots' => 'true', ],
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

        $this->add_control(
            'pcat_nav_text_bg',
            [
                'label' => esc_html__( 'Nav BG Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-slider-navigation i' => 'background-color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .tp-slider-navigation i:hover' => 'background-color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .tp-slider-navigation i:before' => 'color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .tp-slider-navigation i:hover::before' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
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

        $this->add_control(
            'item_gap_custom',
            [
                'label' => esc_html__( 'Item Gap', 'tp-elements' ),
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
            ]
        ); 
                
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
		            '{{WRAPPER}} .tp-single-product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-single-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'item_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-single-product',
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
		            '{{WRAPPER}} .tp-single-product' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'item_border',
		        'selector' => '{{WRAPPER}} .tp-single-product',
		    ]
		);

		$this->add_control(
		    'item_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'tp_item_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product' => 'border-color: {{VALUE}};',
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
		            '{{WRAPPER}} .tp-single-product:hover' => 'background: {{VALUE}};',
		        ],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'item_hover_border',
		        'selector' => '{{WRAPPER}} .tp-single-product:hover',
		    ]
		);

		$this->add_control(
		    'item_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_control(
		    'tp_item_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product:hover' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_media_style',
		    [
		        'label' => esc_html__( 'Image', 'tp-elements' ),
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
		            '(desktop){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) !important;',
		            '(tablet){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}) !important;',
		            '(mobile){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}) !important;',
		            // Body text styles
		            '{{WRAPPER}} .tp-single-product-text' => 'margin-top: {{SIZE}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-single-product-img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
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
		            '{{WRAPPER}} .tp-single-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-single-product-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'media_border',
		        'selector' => '{{WRAPPER}} .tp-single-product-img',
		    ]
		);

		$this->add_responsive_control(
		    'media_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [		            
		            '{{WRAPPER}} .tp-single-product-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
		        'selector' => '{{WRAPPER}} .tp-single-product-img > img, {{WRAPPER}} .tp-single-product-img'
		    ]
		);

		$this->add_control(
		    'icon_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product-img' => 'background-color: {{VALUE}} !important',
		        ],
		    ]
		);

		$this->add_control(
		    'icon_hover_bg_color',
		    [
		        'label' => esc_html__( 'Hover Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-single-product-img' => 'background-color: {{VALUE}} !important',
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
		            '(desktop){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
		            '(tablet){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
		            '(mobile){{WRAPPER}} .tp-single-product-img' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg) !important;',
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
		            '{{WRAPPER}} .tp-single-product-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'content_border',
		        'selector' => '{{WRAPPER}} .tp-single-product-text',
		    ]
		);

		$this->add_responsive_control(
		    'content_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		        'selector' => '{{WRAPPER}} .tp-single-product-text'
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
		        'selector' => '{{WRAPPER}}  .tp-single-product-title',
		    ]
		);

		$this->add_responsive_control(
		    'title_spacing',
		    [
		        'label' => esc_html__( 'Bottom Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_control(
		    'title_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		             '{{WRAPPER}} .tp-single-product-title,
					  {{WRAPPER}}  .tp-single-product-title a' => 'color: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_control(
		    'title_hover_color',
		    [
		        'label' => esc_html__( 'Hover Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [

		        	'{{WRAPPER}} .tp-single-product-title:hover,
		            {{WRAPPER}}   .tp-single-product-title a:hover' => 'color: {{VALUE}}',
					
		        ],
		    ]
		);			

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_style_meta',
		    [
		        'label' => esc_html__( 'Meta', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'meta_typography',
		        'selector' => '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'meta_border',
		        'selector' => '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a',
		    ]
		);

		$this->add_control(
		    'meta_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'meta_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a',
		    ]
		);

		$this->add_control(
		    'hr_two',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_meta' );

		$this->start_controls_tab(
		    '_tab_meta_normal',
		    [
		        'label' => esc_html__( 'Normal', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-single-product .service-meta span, {{WRAPPER}} .tp-single-product .service-meta a' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    '_tab_meta_hover',
		    [
		        'label' => esc_html__( 'Hover', 'tp-elements' ),
		    ]
		);

		$this->add_control(
		    'meta_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta span, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta span, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta a' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'meta_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta span, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta span:focus, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta a, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .service-meta a:focus' => 'border-color: {{VALUE}};',
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

		$this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn,
		        {{WRAPPER}} .tp-add-to-cart-btn',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .services-btn',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn, .services-btn-part .services-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn',
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

		$this->add_control(
		    'link_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn' => 'background-color: {{VALUE}};',
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
		            '{{WRAPPER}} .tp-add-to-cart-btn.icon-before i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .tp-add-to-cart-btn.icon-after i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
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
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product .services-part .services-btn-part:focus .services-btn' => 'color: {{VALUE}};',
		            '{{WRAPPER}}  .tp-add-to-cart-btn:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product:focus .tp-add-to-cart-btn' => 'background-color: {{VALUE}};',
		            '{{WRAPPER}} .tp-add-to-cart-btn:hover' => 'background: {{VALUE}};',
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
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn, {{WRAPPER}} .elementor-widget-container .tp-add-to-cart-btn:focus' => 'border-color: {{VALUE}};',
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
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn.icon-before i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .elementor-widget-container .tp-add-to-cart-btn.icon-after i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
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
		            '{{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_text_typography',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text,
		        {{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'btn_text_border',
		        'selector' => '{{WRAPPER}} .services-btn .tp-simple-text',
		    ]
		);

		$this->add_control(
		    'btn_text_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn, .tp-add-to-cart-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'btn_text_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text',
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
		            '{{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn .tp-simple-text' => 'background-color: {{VALUE}};',
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
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn .tp-simple-text' => 'color: {{VALUE}};',
		            '{{WRAPPER}}  .tp-add-to-cart-btn:hover .tp-simple-text' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn .tp-simple-text, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product:focus .tp-add-to-cart-btn .tp-simple-text' => 'background-color: {{VALUE}};',
		            '{{WRAPPER}} .tp-add-to-cart-btn:hover .tp-simple-text' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn .tp-simple-text, {{WRAPPER}} .elementor-widget-container .tp-add-to-cart-btn:focus .tp-simple-text' => 'border-color: {{VALUE}};',
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
		            '{{WRAPPER}} .tp-add-to-cart-btn i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'button_icon_typography',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn i,
		        {{WRAPPER}} .tp-add-to-cart-btn i',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_icon_border',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn i',
		    ]
		);

		$this->add_control(
		    'button_icon_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn, .tp-add-to-cart-btn i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_icon_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-add-to-cart-btn i',
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
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-add-to-cart-btn i' => 'background-color: {{VALUE}};',
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
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn i, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product:focus .tp-add-to-cart-btn i' => 'color: {{VALUE}};',
		            '{{WRAPPER}}  .tp-add-to-cart-btn:hover i' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn i, {{WRAPPER}} .elementor-widget-container:hover .tp-single-product:focus .tp-add-to-cart-btn i' => 'background-color: {{VALUE}};',
		            '{{WRAPPER}} .tp-add-to-cart-btn:hover i' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'button_icon_hover_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .elementor-widget-container:hover .tp-add-to-cart-btn i, {{WRAPPER}} .elementor-widget-container .tp-add-to-cart-btn:focus i' => 'border-color: {{VALUE}};',
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
		            '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'pagination_typography',
		        'selector' => '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span',
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
                    '{{WRAPPER}} .tp-services-wrapper ul.page-numbers' => 'text-align: {{VALUE}}'
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

		$this->add_control(
		    'pagination_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'pagination_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'pagination_button_border',
		        'selector' => '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span',
		    ]
		);

		$this->add_control(
		    'pagination_button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'pagination_button_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-services-wrapper ul li a, {{WRAPPER}} .tp-services-wrapper ul li span',
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
		            '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'pagination_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current' => 'background: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'pagination_hover_border',
		        'selector' => '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current',
		    ]
		);

		$this->add_control(
		    'pagination_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'pagination_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-services-wrapper ul li a:hover, {{WRAPPER}} .tp-services-wrapper ul li span:hover, {{WRAPPER}} .tp-services-wrapper ul li span.current',
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
		
		if ( class_exists( 'WooCommerce' ) ) {
				
			$sstyle = $settings['product_style'];

			if( $settings['product_grid_source'] == 'slider' ) {

				$col_xl          = $settings['col_xl'];
				$col_xl          = !empty($col_xl) ? $col_xl : 3;
				$slidesToShow    = $col_xl;
				$autoplaySpeed   = $settings['slider_autoplay_speed'];
				$autoplaySpeed   = !empty($autoplaySpeed) ? $autoplaySpeed : '1000';
				$interval        = $settings['slider_interval'];
				$interval        = !empty($interval) ? $interval : '3000';
				$slidesToScroll  = $settings['slides_ToScroll'];
				$slider_autoplay = $settings['slider_autoplay'] === 'true' ? 'true' : 'false';
				$pauseOnHover    = $settings['slider_stop_on_hover'] === 'true' ? 'true' : 'false';
				$pauseOnInter    = $settings['slider_stop_on_interaction'] === 'true' ? 'true' : 'false';
				$sliderDots      = $settings['slider_dots'] == 'true' ? 'true' : 'false';
				$sliderNav       = $settings['slider_nav'] == 'true' ? 'true' : 'false';        
				$infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
				$centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
				$col_lg          = $settings['col_lg'];
				$col_md          = $settings['col_md'];
				$col_sm          = $settings['col_sm'];
				$col_xs          = $settings['col_xs'];
				$unique          = rand(20192,35120);
				$item_gap        = $settings['item_gap_custom']['size'];
				$item_gap        = !empty($item_gap) ? $item_gap : '30';        
				$prev_text       = !empty($prev_text) ? $prev_text : '';       
				$next_text       = !empty($next_text) ? $next_text : '';
				$all_pcat = tpelemetns_woocommerce_product_categories();
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
	
				$effect = $settings['rt_pslider_effect'];
	
				if($effect== 'fade'){
					$seffect = "effect: 'fade', fadeEffect: { crossFade: true, },";
				}elseif($effect== 'cube'){
					$seffect = "effect: 'cube',";
				}elseif($effect== 'flip'){
					$seffect = "effect: 'flip',";
				}elseif($effect== 'coverflow'){
					$seffect = "effect: 'coverflow',";
				}elseif($effect== 'creative'){
					$seffect = "effect: 'creative', creativeEffect: { prev: { translate: [0, 0, -400], }, next: { translate: ['100%', 0, 0], }, },";
				}elseif($effect== 'cards'){
					$seffect = "effect: 'cards',";
				}else{
					$seffect = '';
				}	

			}

			// Assign default values
			$orderby_value = '';
			$meta_key_value = '';
			$meta_value_value = '';

			// Define sorting logic based on selected settings
			switch ($settings['product_sorting']) {
				case 'date':
					$orderby_value = 'date';
					break;
				case 'title':
					$orderby_value = 'title';
					break;
				case 'rand':
					$orderby_value = 'rand';
					break;
				case 'ID':
					$orderby_value = 'ID';
					break;
				case 'menu_order':
					$orderby_value = 'menu_order';
					break;
				case 'modified':
					$orderby_value = 'modified';
					break;
				case 'comment_count':
					$orderby_value = 'comment_count';
					break;
				case 'meta_value_num_price':
					$orderby_value = 'meta_value_num';
					$meta_key_value = '_price';
					break;
				case 'meta_value_num_rating':
					$orderby_value = 'meta_value_num';
					$meta_key_value = '_wc_average_rating';
					break;
				case 'meta_value_num_sales':
					$orderby_value = 'meta_value_num';
					$meta_key_value = 'total_sales';
					break;
				default:
					// Default sorting option
					$orderby_value = 'date'; // Fallback to sorting by date
					break;
			}

			$cat = $settings['product_category'];
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if(empty($cat)){
				$best_wp = new wp_Query(array(
						'post_type'      => 'product',
						'posts_per_page' => $settings['per_page'],
						'paged'          => $paged,
						'meta_key'       => $meta_key_value,  
						'orderby'        => $orderby_value,     
						'meta_value'	 => $meta_value_value,
						'order'          => $settings['product_order'],
							
				));	  
			}   
			else{
				$best_wp = new wp_Query(array(
					'post_type'      => 'product',
					'posts_per_page' => $settings['per_page'],
					'paged'          => $paged,
					'meta_key'       => $meta_key_value,     
					'orderby'        => $orderby_value,    
					'meta_value'	 => $meta_value_value,
					'order'          => $settings['product_order'],
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug', //can be set to ID
							'terms'    => $cat //if field is ID you can reference by cat/term number
						),
					)
				));	  
			} 


			?>
			<div class="tp-product-wrapper tp-product-<?php echo esc_attr( $settings['product_style'] ); ?>">
				<?php if( $settings['product_grid_source'] == 'dynamic' ) : ?>
				<div class="tp-product-dynamic ">
					<div class="row " >
					<?php elseif( $settings['product_grid_source'] == 'slider' ) : ?>
					<div class="swiper tp-product-slider-<?php echo esc_attr($unique); ?> ">
						<div class="swiper-wrapper ">
				<?php else : ?>
				<?php endif; ?>

						<?php
						//$post_counter = 01;
						$x=1;
						while($best_wp->have_posts()): $best_wp->the_post();

						global $woocommerce;
						global $product;

						$post_id = $product->get_id();

						$rating = wc_get_rating_html($product->get_average_rating());
						$ratingcount = $product->get_review_count();
						$attachment_ids = $product->get_gallery_image_ids();

						foreach( $attachment_ids as $key => $attachment_id ) {
							$image_link =  wp_get_attachment_url( $attachment_id );
							$arr[] = $image_link;
						}

						$categories = get_the_terms($post_id, 'product_cat');
				
						if ($categories && !is_wp_error($categories)) {
							$first_category_name = $categories[0]->name;
						}	

						if(!empty($settings['title_word_count'])){
							$title_limit = $settings['title_word_count']; 
						}
						else{
							$title_limit = 20;
						}

						if(!empty($settings['product_text_word_limit'])){
							$text_limit = $settings['product_text_word_limit']; 
						}
						else{
							$text_limit = 20;
						}

						if( $settings['product_grid_source'] == 'dynamic' ) {

							if($sstyle){
								require plugin_dir_path(__FILE__)."/dynamic/$sstyle.php";
							}else{
								require plugin_dir_path(__FILE__)."/dynamic/style1.php";
							}

						}

						if( $settings['product_grid_source'] == 'slider' ) {

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
					</div>

					<?php if ( $settings['product_grid_source'] == 'dynamic' ) {

						if( $settings['product_pagination_show_hide'] == 'yes' ) {
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

					}

					?>
				<?php if( $settings['product_grid_source'] == 'dynamic' || $settings['product_grid_source'] == 'slider' ) : ?>
				</div>
			</div>
			<?php endif; ?>

			<?php 
		} 
			
		if( $settings['product_grid_source'] == 'slider' ) : ?> 

		<script type="text/javascript"> 

		jQuery(document).ready(function(){
			var swiper<?php echo esc_attr($unique); ?> = new Swiper(".tp-product-slider-<?php echo esc_attr($unique); ?>", {				
				slidesPerView: 1,
				<?php echo $seffect; ?>
				speed: <?php echo esc_attr($autoplaySpeed); ?>,
				slidesPerGroup: 1,
				loop: <?php echo esc_attr($infinite ); ?>,
			<?php echo esc_attr($slider_autoplay); ?>,
			spaceBetween:  <?php echo esc_attr($item_gap); ?>,
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
				},
				centeredSlides: <?php echo esc_attr($centerMode); ?>,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				breakpoints: {
					<?php
					echo (!empty($col_xs)) ?  '575: { slidesPerView: '. $col_xs .' },' : '';
					echo (!empty($col_sm)) ?  '767: { slidesPerView: '. $col_sm .' },' : '';
					echo (!empty($col_md)) ?  '991: { slidesPerView: '. $col_md .' },' : '';
					echo (!empty($col_lg)) ?  '1199: { slidesPerView: '. $col_lg .' },' : '';
					?>
					1399: {
						slidesPerView: <?php echo esc_attr($col_xl); ?>,
						spaceBetween:  <?php echo esc_attr($item_gap); ?>
					}
				}
			});
		});

		</script>

		<?php 
		endif;
	}
	public function getProductCategories(){
		$cat_list = [];
			if ( post_type_exists( 'product' ) ) { 
			$terms = get_terms( array(
				'taxonomy'    => 'product_cat',
				'hide_empty'  => true            
			) ); 
			foreach($terms as $post) {
				$cat_list[$post->slug]  = [$post->name];
			}
		}  
		return $cat_list;
	}	
}