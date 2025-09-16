<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Utils;


defined( 'ABSPATH' ) || die();

class Pixelaxis_Portfolio_Slider_Widget extends \Elementor\Widget_Base {
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
		return 'tp-portfolio-slider';
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
		return __( 'TP Portfolio Slider', 'tp-elements' );
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
		return 'glyph-icon flaticon-slider-3';
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
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'portfolio_slider_style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Style 1',
					'2' => 'Style 2',
					'3' => 'Style 3',				
					'4' => 'Style 4',
					'5' => 'Style 5',
                    '6' => 'Style 6',
                    '7' => 'Style 7',
                    '8' => 'Style 8',
                    '9' => 'Style 9',
				],											
			]
		);


		$this->add_control(
			'portfolio_category',
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
			'per_page',
			[
				'label' => esc_html__( 'Portfolio Show Per Page', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'tp-elements' ),
				'separator' => 'before',
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
                'separator' => 'before',
            ]
        ); 

        $this->add_control(
			'details_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,				
				'separator' => 'before',				  
		        'condition' => ['portfolio_slider_style' => ['1', '3', '6']],
			]
		);	

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__( 'Button Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .tp-portfolio-style3 .portfolio-item a.pf-btn2',         
				'condition' => [
				    'portfolio_slider_style' => '3',
				],           
			]
		);

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Button Area Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-style3 .portfolio-item a.pf-btn2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
				    'portfolio_slider_style' => '3',
				],
            ]
        );

        
		
        $this->add_control(
            'contet_area_bg_color',
            [
                'label' => esc_html__( 'Content Area Bg Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                  
                    '{{WRAPPER}} .portfolio-item .p-title a' => 'color: {{VALUE}};',                   

                ],      
                'condition' => [
				    'portfolio_slider_style' => '6',
				],          
            ]
        );

        $this->add_control(
			'card_image',
			[
				'label' => esc_html__( 'Content Icon Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				'separator' => 'before',
                'condition' => ['portfolio_slider_style' => ['7', '6', '8']],

			]
		);

        $this->add_control(
			'card_image_shape',
			[
				'label' => esc_html__( 'Details Icon', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				'separator' => 'before',
				'condition' => ['portfolio_slider_style' => ['5']],              

			]
		);

         

        $this->end_controls_section();


	$this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'tp-elements' ),
                'tab'   => Controls_Manager::TAB_CONTENT,               
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
                    '2.4' => esc_html__( '2.4 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '4.5' => esc_html__( '4.5 Column', 'tp-elements' ),
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
                    '2.4' => esc_html__( '2.4 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
                    '6' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',                            
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Laptop > 991px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
                    '3' => esc_html__( '3 Column', 'tp-elements' ),
                    '4' => esc_html__( '4 Column', 'tp-elements' ),
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
            'pcat_prev_text',
            [
                'label' => esc_html__( 'Previous Text', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Previous', 'tp-elements' ),
                'placeholder' => esc_html__( 'Type your title here', 'tp-elements' ),
                'condition' => [
                    'slider_nav' => 'true',
                ],
            ]
        );

        $this->add_control(
            'pcat_next_text',
            [
                'label' => esc_html__( 'Next Text', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Next', 'tp-elements' ),
                'placeholder' => esc_html__( 'Type your title here', 'tp-elements' ),
                'condition' => [
                    'slider_nav' => 'true',
                ],

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
                    'size' => 15,
                ],          
            ]
        ); 

         $this->add_control(
            'item_gap_custom_bottom',
            [
                'label' => esc_html__( 'Item Bottom Gap', 'tp-elements' ),
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
                    '{{WRAPPER}} .pixelaxis-addon-slider .testimonial-item' => 'margin-bottom:{{SIZE}}{{UNIT}};',                    
                ],
            ]
        ); 
                
        $this->end_controls_section();

		$this->start_controls_section(
			'section_slider_style',
			[
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                  
                    '{{WRAPPER}} .portfolio-item .p-title a' => 'color: {{VALUE}};',  
                    '{{WRAPPER}} .tp-portfolio-style7 .tps-business-case-s-2 .inner .title' => 'color: {{VALUE}};',  
                                    

                ],                
            ]
        );



        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item .p-title  a:hover' => 'color: {{VALUE}};', 
                    '{{WRAPPER}} .tp-portfolio-style7 .tps-business-case-s-2 .inner .title:hover' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .tp-portfolio-slider.slider-style-6 .portfolio-item .portfolio-content .p-title > a, {{WRAPPER}} .p-title a',                    
			]
		);


        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-slider.slider-style-6 .portfolio-item .portfolio-content .p-title .p-category a, {{WRAPPER}} .p-category a' => 'color: {{VALUE}};',                   

                ],                
            ]
        );

        $this->add_control(
            'category_color_hover',
            [
                'label' => esc_html__( 'Category Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-slider.slider-style-6 .portfolio-item .portfolio-content .p-title .p-category a:hover, {{WRAPPER}} .p-category a:hover' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );  

        $this->add_control(
            'icon_color6',
            [
                'label' => esc_html__( 'Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-style8 .tps-business-case-s-2 .thumbnail i' => 'color: {{VALUE}};',                   

                ], 
                           
            ]
        ); 

        $this->add_control(
            'icon_bg_color6',
            [
                'label' => esc_html__( 'Icon Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-style8 .tps-business-case-s-2 .thumbnail i' => 'background: {{VALUE}};',                   

                ], 
                        
            ]
        ); 

        $this->add_control(
            'item_border_color',
            [
                'label' => esc_html__( 'Border Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-slider.slider-style-6 .portfolio-item:before' => 'background: {{VALUE}};',                   

                ], 
                'condition' => [
		            'portfolio_slider_style' => '6',
		        ],               
            ]
        ); 

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_bg_color',
                'label' => esc_html__( 'Text Background Color', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'condition' => [
		            'portfolio_slider_style' => '5',
		        ],
                'selector' => '{{WRAPPER}} .slider-style-5 .tp-portfolio4 .portfolio-item .portfolio-inner'
            ]
        );


        $this->add_control(
            'image_overlay',
            [
                'label' => esc_html__( 'Image Overlay', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .portfolio-content:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .slider-style-5 .tp-portfolio4 .portfolio-item' => 'background: {{VALUE}};',
                    '{{WRAPPER}}  .tp-portfolio-style3 .portfolio-item .portfolio-img:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}}  .tp-portfolio-style4 .portfolio-item .portfolio-img:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tp-portfolio-style2 .portfolio-item:before' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'style_overly_bg',
                'label' => esc_html__( 'Overlay Background Color', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tp-portfolio-slider.slider-style-6 .portfolio-item:after',
                'condition' => [
		            'portfolio_slider_style' => '6'
		        ]
            ]
        );
      
        $this->add_control(
			'arrow_options',
			[
				'label' => esc_html__( 'Arrow Style', 'tp-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
		    'arrow_left_position',
		    [
				'label'      => esc_html__( 'Left Position', 'tp-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'condition' => [
				    'slider_centerMode' => 'true',
				],
		        'selectors' => [
		            '{{WRAPPER}} .tp-portfolio-slider.slider-style-5 .rt_widget_sliders .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .rt_widget_sliders .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);	

		$this->add_responsive_control(
		    'arrow_right_position',
		    [
				'label'      => esc_html__( 'Right Position', 'tp-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'condition' => [
				    'slider_centerMode' => 'true',
				],
		        'selectors' => [
		            '{{WRAPPER}} .tp-portfolio-slider.slider-style-5 .rt_widget_sliders .slick-next' => 'right: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .rt_widget_sliders .slick-next' => 'right: {{SIZE}}{{UNIT}};',
		        ],
		        'separator' => 'before',
		    ]
		);


        $this->add_control(
            'navigation_arrow_background',
            [
                'label' => esc_html__( 'Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-next,{{WRAPPER}}  .rt_widget_sliders .slick-prev' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rt_widget_sliders .slick-next,{{WRAPPER}}  .rt_widget_sliders .slick-next' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_background_hover',
            [
                'label' => esc_html__( 'Hover Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                    
                    '.tp-portfolio-style6 .swiper-button-prev:hover' => 'background: {{VALUE}}; !important',
                    '.tp-portfolio-style6 .swiper-button-next:hover' => 'background: {{VALUE}}; !important',
                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-next::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt_widget_sliders .slick-prev::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-prev:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next:before' => 'color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_icon_color_hvoer',
            [
                'label' => esc_html__( 'Icon Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-next::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt_widget_sliders .slick-prev::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-prev:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-next:hover:before' => 'color: {{VALUE}};',

                ],                
            ]
        );

         $this->add_control(
			'bullet_options',
			[
				'label' => esc_html__( 'Bullet Style', 'tp-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Style', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-dots li button' => 'border-color: {{VALUE}};',

                ],                
            ]
        );


        $this->add_control(
            'navigation_dot_border_color_active',
            [
                'label' => esc_html__( 'Active Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-dots li button.active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tp-portfolio-style6.swiper .swiper-pagination-frac .swiper-pagination-current' => 'color: {{VALUE}};',

                ],                
            ]
        );




        $this->add_control(
            'navigation_dot_icon_background',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-dots li button:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rt_widget_sliders .slick-dots li.slick-active button' => 'background: {{VALUE}};',

                ],                
            ]
        );


        $this->add_control(
			'button_options',
			[
				'label' => esc_html__( 'Button Style', 'tp-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'button_color_normal',
            [
                'label' => esc_html__( 'Button Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-btn' => 'color: {{VALUE}};',

                ],                
            ]
        );      



        $this->add_control(
            'button_background',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    ' {{WRAPPER}} .tps-btn' => 'background: {{VALUE}};',                    

                ],                
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__( 'Button Hover Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-btn:hover' => 'color: {{VALUE}};',

                ],                
            ]
        );      



        $this->add_control(
            'Hover_button_background',
            [
                'label' => esc_html__( 'Hover Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    ' {{WRAPPER}} .tps-btn:hover' => 'background: {{VALUE}};',                    

                ],                
            ]
        );

          $this->add_control(
			'bullet_spacing_custom',
			[
				'label' => esc_html__( 'Top Gap', 'tp-elements' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => true,				
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 25,
				],			

				'selectors' => [
                    '{{WRAPPER}} .rt_widget_sliders .slick-dots' => 'margin-bottom:-{{SIZE}}{{UNIT}};',                    
                ],
			]
		); 

        

		$this->end_controls_section();

		$this->start_controls_section(
				    '_section_style_button',
				    [
				        'label' => esc_html__( 'Button', 'tp-elements' ),
				        'tab' => Controls_Manager::TAB_STYLE,
				        'condition' => ['portfolio_slider_style' => ['1']],
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
				            '{{WRAPPER}} .tp-portfolio-style1 .read-btn' => 'color: {{VALUE}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
					[
						'name' => 'background_normal',
						'label' => esc_html__( 'Background', 'tp-elements' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .portfolio-item .link-button',
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
				            '{{WRAPPER}}  .tp-portfolio-style1 .grid-item:hover .read-btn' => 'color: {{VALUE}};',
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
					[
						'name' => 'background',
						'label' => esc_html__( 'Background', 'tp-elements' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tp-portfolio-style1 .grid-item:hover .read-btn:before',
					]
				);

				$this->end_controls_tab();
				$this->end_controls_tabs();    
				
				

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

		$settings    = $this->get_settings_for_display();
        $placeholder = Utils::get_placeholder_image_src();
        $imgId       = !empty($settings['card_image']) ? $settings['card_image']['id'] : '';
        if( !empty($imgId) ){
            $img_link = wp_get_attachment_image_src($imgId, 'large')[0];
        }else{
            $img_link = $placeholder;
        }
        $imgId2 = !empty($settings['card_image_shape']) ? $settings['card_image_shape']['id'] : '';
        if( !empty($imgId2) ){
            $img_link2 = wp_get_attachment_image_src($imgId2, 'large')[0];
        }else{
            $img_link2 = $placeholder;
        }

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
        $item_gap   = $settings['item_gap_custom']['size'];
        $item_gap   = !empty($item_gap) ? $item_gap : '30';
        $prev_text  = $settings['pcat_prev_text'];
        $prev_text  = !empty($prev_text) ? $prev_text : '';
        $next_text  = $settings['pcat_next_text'];
        $next_text  = !empty($next_text) ? $next_text : '';
        $unique = rand(2012,35120);
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
		?>	
        <?php if( $sliderNav =='true' ) : ?> 
            <div class="portfolio-slider-nav">
                <div class="swiper-button-prev">
                    <i class="tp tp-arrow-left"></i>
                </div>
                <div class="swiper-button-next">
                    <i class="tp tp-arrow-right"></i>
                </div>
            </div>
        <?php endif; ?>
		<div class="swiper tpaddon-portfolio-slider-<?php echo esc_attr($unique); ?>  tpaddon-unique-slider pixelaxis-addon-slider tp-portfolio-slider tp-portfolio tp-portfolio-style<?php echo esc_attr($settings['portfolio_slider_style']); ?> slider-style-<?php echo esc_attr($settings['portfolio_slider_style']); ?> center-mode-<?php echo $centerMode;?>">
			<div class="swiper-wrapper">
                <?php 	if('1' == $settings['portfolio_slider_style']){ 
                        include plugin_dir_path(__FILE__)."/style1.php";
                    }
                    if('2' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style2.php";
                    }
                    if('3' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style3.php";
                    }
                    if('4' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style4.php";
                    }
                    if('5' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style5.php";
                    }
                    if('6' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style6.php";
                    }
                    if('7' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style7.php";
                    }
                    if('8' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style8.php";
                    }  
                    if('9' == $settings['portfolio_slider_style']){
                        include plugin_dir_path(__FILE__)."/style9.php";
                    }                    
                ?>
		    </div>
            <?php if( $sliderDots == 'true' ) : ?>
            <div class="swipper-bulet-pagination">
                    <div class="swiper-pagination-new"></div>
            </div>
        <?php endif; ?>
	    </div>
      
       
	<script type="text/javascript"> 
        jQuery(document).ready(function(){                
            var swiper = new Swiper(".tpaddon-portfolio-slider-<?php echo esc_attr($unique); ?>", {				
                slidesPerView: <?php echo $slidesToShow;?>,
                <?php if('6' == $settings['portfolio_slider_style']){ ?>
                      loop: true,
                      loopedSlides: 50,
                      autoHeight: true,
                      shortSwipes: false,
                      longSwipes: false,
                      effect: 'fade',
                      speed: 500,
                      autoplay: {
                          delay: 1500,
                      },
                <?php } else{                
                 echo $seffect; ?>
                speed: <?php echo esc_attr($autoplaySpeed); ?>,                
                loop: <?php echo esc_attr($infinite ); ?>,
                <?php echo esc_attr($slider_autoplay); ?>, 
                <?php } ?>
               
                spaceBetween:  <?php echo esc_attr($item_gap); ?>,
                
                centeredSlides: <?php echo esc_attr($centerMode); ?>,
                <?php if( $sliderNav =='true' ) : ?>
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                <?php endif;?>
                <?php if( $sliderDots == 'true' ) : ?>
                pagination: {
                    el: ".swiper-pagination-new",
                    clickable: true
                },
                <?php endif;?>
                breakpoints: {
                    
                    
                    0: {
                       slidesPerView: <?php echo esc_attr($col_xs); ?>,
                      
                   },
                   <?php echo (!empty($col_xs)) ?  '575: { slidesPerView: '. $col_xs .' },' : '';
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
	}
	public function getCategories(){
        $cat_list = [];
         	if ( post_type_exists( 'tp-portfolios' ) ) { 
          	$terms = get_terms( array(
             	'taxonomy'    => 'tp-portfolio-category',
             	'hide_empty'  => true            
         	) );
            
	        foreach($terms as $post) {
	        	$cat_list[$post->slug]  = [$post->name];
	        }
    	}  
        return $cat_list;
    }
}?>