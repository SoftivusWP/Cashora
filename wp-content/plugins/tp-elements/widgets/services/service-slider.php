<?php
/**
 * Logo widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\register_controls;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Services_Slider_Widget  extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *   
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'tp-service-slider';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */

    public function get_title() {
        return esc_html__( 'TP Services Slider', 'tp-elements' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'service' ];
    }


    protected function register_controls() {       

        $this->start_controls_section(
            '_section_service',
            [
                'label' => esc_html__( 'Slider Item', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
			'service_slider_style',
			[
				'label'   => esc_html__( 'Select Services Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'tp-elements'),
					'style2' => esc_html__( 'Style 2', 'tp-elements'),	
					'style3' => esc_html__( 'Style 3', 'tp-elements'),	
					'style4' => esc_html__( 'Style 4', 'tp-elements'),	
				],
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'tp-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );  
		$repeater->add_control(
            'services_meta_show_hide',
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

		$repeater->add_control(
            'topic_fee',
            [
                'label' => esc_html__('Fee', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('$250.00', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Type Price', 'tp-elements' ),
                'separator'   => 'before',
                'condition' => [
                    'services_meta_show_hide' => 'yes',
                ],
            ]
        ); 
        
		$repeater->add_control(
            'trainer_name',
            [
                'label' => esc_html__('Trainer Name', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Masum Billah', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Type Trainer Name', 'tp-elements' ),
                'separator'   => 'before',
                'condition' => [
                    'services_meta_show_hide' => 'yes',
                ],
            ]
        ); 

		$repeater->add_control(
            'topic_name',
            [
                'label' => esc_html__('Topic', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Swimming Course', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Type Topice name', 'tp-elements' ),
                'separator'   => 'before',
                'condition' => [
                    'services_meta_show_hide' => 'yes',
                ],
            ]
        );      

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Title', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Name', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'tp-elements'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Description', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );        
        
		$repeater->add_control(
            'services_btn_show_hide',
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
        
		$repeater->add_control(
			'services_btn_text',
			[
				'label' => esc_html__( 'Services Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'View Service',
				'placeholder' => esc_html__( 'Services Button Text', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
					'services_btn_show_hide' => ['yes'],
				],
			]
		);

		$repeater->add_control(
			'services_btn_link',
			[
				'label' => esc_html__( 'Services Button Link', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
				'placeholder' => esc_html__( '#', 'tp-elements' ),		
				'condition' => [
					'services_btn_show_hide' => ['yes'],
				],	
			]
		);

		$repeater->add_control(
			'services_btn_link_open',
			[
				'label'   => esc_html__( 'Link Open New Window', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [					
					'no' => esc_html__( 'No', 'tp-elements'),
					'yes' => esc_html__( 'Yes', 'tp-elements'),
				],
				'condition' => [
					'services_btn_show_hide' => ['yes'],
				],
			]
		);

		$repeater->add_control(
			'services_btn_icon',
			[
				'label' => esc_html__( 'Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'solid',
				],			
				'separator' => 'before',	
				'condition' => [
					'services_btn_show_hide' => ['yes'],
				],		
			]
		);

		$repeater->add_control(
		    'services_btn_icon_position',
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
		            'services_btn_icon!' => '',
					'services_btn_show_hide' => ['yes'],
		        ],
		    ]
		); 

		$repeater->add_control(
		    'services_btn_icon_spacing',
		    [
		        'label' => esc_html__( 'Icon Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		       
		        'condition' => [
		            'services_btn_icon!' => '',
					'services_btn_show_hide' => ['yes'],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .pixelaxis-addon-services .services-part .services-text .services-btn-part .services-btn.icon-before i' => 'margin-right: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .pixelaxis-addon-services .services-part .services-text .services-btn-part .services-btn.icon-after i' => 'margin-left: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_control(
            'slide_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                ]
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

        $this->end_controls_section();     
        $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,               
            ]
        );
        $this->add_control(
            'col_xl',
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
        $this->add_responsive_control(
            'slider_nav_top_gap',
            [
                'label' => esc_html__( 'Nav Top Gap', 'tp-elements' ),
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
                    '{{WRAPPER}} .navigation-center-bottom' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg',
            [
                'label' => esc_html__( 'Nav BG Color', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .swiper-button-next:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .navigation-center-bottom i:before' => 'color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .navigation-center-bottom i:hover::before' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

        $this->add_responsive_control(
            'pcat_nav_text_width',
            [
                'label' => esc_html__( 'Width', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .navigation-center-bottom > div' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_responsive_control(
            'pcat_nav_text_height',
            [
                'label' => esc_html__( 'Height', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .navigation-center-bottom > div' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_responsive_control(
            'pcat_nav_text_line_height',
            [
                'label' => esc_html__( 'Line Height', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .navigation-center-bottom > div' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );
        $this->add_control(
            'pcat_nav_text_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .navigation-center-bottom > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

        $this->add_control(
            'pcat_prev_text',
            [
                'label' => esc_html__( 'Previous Text', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '<i class="tp tp-arrow-left-long"></i>', 'tp-elements' ),
                'placeholder' => esc_html__( 'Type your title here', 'tp-elements' ),
                'condition' => [ 'slider_nav' => 'true', ],
            ]
        );

        $this->add_control(
            'pcat_next_text',
            [
                'label' => esc_html__( 'Next Text', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '<i class="tp tp-arrow-right-long"></i>', 'tp-elements' ),
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
                    'size' => 0,
                ],          
            ]
        ); 
                
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => esc_html__( 'Slider Item', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'item_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .tp-el-item',
			]
		);
        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_grid',
            [
                'label' => esc_html__( 'Slider Style', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-one-inner-four .big-thumbnail-area .content .disc' => 'color: {{VALUE}}',
                ],
            ]
        );

      
        $this->add_control(
            'btn_style_options',
            [
                'label' => esc_html__( 'Button Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__( 'Button Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .service-one-inner-four a.tps-btn' => 'color: {{VALUE}}',
                    
                ],
            ]
        );
        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__( 'Button Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .service-one-inner-four a.tps-btn' => 'background: {{VALUE}}',                    
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'btn__border',
				'selector' => '{{WRAPPER}} .service-one-inner-four a.tps-btn',
			]
		);
        $this->add_control(
            'btn_border_color',
            [
                'label' => esc_html__( 'Button Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                    
                    '{{WRAPPER}} .service-one-inner-four a.tps-btn' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_hover_color',
            [
                'label' => esc_html__( 'Button Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .service-one-inner-four a.tps-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_hover_bg_color',
            [
                'label' => esc_html__( 'Button Hover Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn:hover' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .service-one-inner-four a.tps-btn:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_btn_typography',
                'selector' => '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn',
            ]
        );

        $this->add_control(
            'slider_btn_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'slider_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'slider_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
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
        $item_gap        = $settings['item_gap_custom']['size'];
        $item_gap        = !empty($item_gap) ? $item_gap : '0';
        $prev_text       = $settings['pcat_prev_text'];
        $prev_text       = !empty($prev_text) ? $prev_text : '';
        $next_text       = $settings['pcat_next_text'];
        $next_text       = !empty($next_text) ? $next_text : '';
        $unique          = rand(2012,35120);

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

        if ( empty($settings['slide_list'] ) ) {
            return;
        }   

        ?>
        <?php $gray_scale = $settings['show_graycale']; ?>

        <div class="container">
            <div class="navigation-center-bottom text-center position-relative ">
                <?php if( $sliderNav =='true' ) : ?>
                <div class="swiper-button-next box-style"><i class="tp-arrow-left"></i></div>
                <div class="swiper-button-prev box-style"><i class="tp-arrow-right"></i></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="swiper tp-service--slider tp_slider-<?php echo esc_attr($unique); ?> gray_<?php echo $settings['show_graycale'];?> tp-service-style-<?php echo esc_attr( $settings['service_slider_style'] ); ?>">
           
            <div class="swiper-wrapper">   

                <?php
                foreach ( $settings['slide_list'] as $index => $item ) :                        
                    $imgId = $item['image']['id'];
                                            
                    if($imgId ){
                        $image = wp_get_attachment_image_src($imgId, 'full')[0];                        
                    }else{
                        $IMGstyle = '';
                        $image = '';
                    }                            
                   
                    $title        = !empty($item['name']) ? $item['name'] : '';                              
                    $services_meta_show_hide = !empty($item['services_meta_show_hide']) ? $item['services_meta_show_hide'] : '';                              
                    $topic_name   = !empty($item['topic_name']) ? $item['topic_name'] : '';                              
                    $trainer_name = !empty($item['trainer_name']) ? $item['trainer_name'] : '';                              
                    $description  = !empty($item['description']) ? $item['description'] : '';
                    $btn_text     = !empty($item['btn_text']) ? $item['btn_text'] : '';
                    $target       = !empty($item['link']['is_external']) ? 'target=_blank' : '';  
                    $link         = !empty($item['link']['url']) ? $item['link']['url'] : '';                                        
                    
                    ?>

                    <?php if( $settings['service_slider_style'] == 'style4' ) : ?>
                    <div class="swiper-slide">
                        <div class="single-item-wrapper tp-el-item">
                            <div class="single-item position-relative ">
                                <?php if(!empty($image)):?>
                                    <img src="<?php echo esc_attr($image); ?>" class="w-100" alt="image">
                                <?php endif;?>
                                <div class="hover-item p-4 p-md-6 p-lg-10 w-100 position-absolute bottom-0 cus-z1 d-center flex-wrap gap-4 justify-content-between">
                                    <div class="text-item">
                                        <?php if( !empty( $item['topic_name'] ) ){ ?>
                                        <span class="meta_topic"><?php echo esc_html( $item['topic_name'] ); ?></span>
                                        <?php } ?>
                                        <?php if(!empty($title)) : ?>
                                        <h5 class="title mb-3"><?php echo wp_kses_post($title); ?></h5>
                                        <?php endif;?>
                                        <?php if(!empty( $description )) : ?>
                                        <p><?php echo wp_kses_post( $description );?></p>
                                        <?php endif; ?>	
                                    </div>
                                    <a href="<?php echo $link;?>" class="box-style box-third rounded-circle fifth-alt d-center">
                                        <span class="d-center fs-four">
                                            <i class="tp tp-arrow-up-right"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php elseif( $settings['service_slider_style'] == 'style3' ) : ?>

                    <div class="swiper-slide">
                        <div class="single-item tp-el-item">
                            <?php if(!empty($image)):?>
                                <img src="<?php echo esc_attr($image); ?>" class="w-100" alt="image">
                            <?php endif;?>
                            <div class="text-area pt-4 pt-md-7">
                                <div class="text-item">
                                    <?php if(!empty($title)):?>
                                        <h5 class="mb-2 p2-color transition service-title"><?php echo wp_kses_post($title); ?></h5>
                                    <?php endif;?>
                                    <?php if(!empty($description)):?>
                                        <p class="s3-color"><?php echo  $description; ?></p>
                                    <?php endif;?>
                                </div>
                                <a href="<?php echo $link;?>" class="btn-area position-relative d-inline-flex gap-2 align-items-center ">
                                    <?php if(!empty($item['services_btn_text'])){ ?>
                                    <span class="text-uppercase p2-color fw-bold transition"><?php echo esc_html($item['services_btn_text']);?></span>
                                    <?php } ?>
                                    <span class="title-shape position-relative d-center v-line f-width"><span class="opacity-0 px-2"><?php echo esc_html__( 'title', 'tp-elements' ); ?></span></span>
                                </a>

                            </div>
                        </div>
                    </div>

                    <?php elseif( $settings['service_slider_style'] == 'style2' ) : ?>

                    <div class="swiper-slide">

                        <div class="single-item tp-el-item transition position-relative overflow-hidden">
                            <?php if(!empty($title)):?>
                                <h5 class="mb-4"><?php echo wp_kses_post($title); ?></h5>
                            <?php endif;?>
                            <?php if(!empty($description)):?>
                            <p><?php echo  $description; ?></p>
                            <?php endif;?>
                            <div class="d-center pt-10 pt-lg-20 justify-content-between">
                                <?php if(!empty($image)):?>
                                <div class="icon-area d-center s1-bg-color">
                                    <img src="<?php echo esc_attr($image); ?>" class="max-un" alt="image">
                                </div>
                                <?php endif;?>
                                <div class="btn-area">
                                    <a href="<?php echo $link;?>" class="box-style box-third fourth-alt d-center position-relative">
                                        <i class="tp tp-arrow-up-right fs-five"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php else : ?>
                    <div class="swiper-slide">
                        <div class="single-item tp-el-item">
                            <?php if(!empty($image)):?>
                            <div class="single-item-img">
                                <img src="<?php echo esc_attr($image); ?>" alt="service image">
                                <?php if(($item['services_meta_show_hide'] == 'yes') && !empty( $item['topic_fee'] ) ){ ?> 
                                <span class="meta_fee"><?php echo esc_html( $item['topic_fee'] ); ?> <span><?php echo esc_html__( '/ Person', 'tp-elements' ); ?></span></span> 
                                <?php } ?>
                            </div>
                            <?php endif;?>
                            <div class="single-item-content">

                                <?php if(($item['services_meta_show_hide'] == 'yes') ){ ?>
                                <ul class="service-meta">
                                    <?php if( !empty( $item['trainer_name'] ) ){ ?>
                                    <li><span class="meta_trainer"><i class="tp tp-user-2"></i><?php echo esc_html( $item['trainer_name'] ); ?></span></li>
                                    <?php } ?>
                                    <?php if( !empty( $item['topic_name'] ) ){ ?>
                                    <li><span class="meta_topic"><i class="tp tp-tags"></i><?php echo esc_html( $item['topic_name'] ); ?></span></li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>

                                <?php if(!empty($title)):?>
                                <div class="sigle-item-title">
                                    <h4 class="title"><?php echo wp_kses_post($title); ?></h4>
                                </div>
                                <?php endif;?>

                                <?php if(!empty( $description )) : ?>
                                    <p class="single-item-desc"><?php echo wp_kses_post( $description );?></p>
                                <?php endif; ?>	

                                <?php if(!empty($item['services_btn_show_hide'])){ ?>
                                <div class="services-btn-part mt-20">
                                    <?php 
                                        $link_open = $item['services_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 		    		 
                                        $icon_position = $item['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                                    ?>		    		
                                    <a class="services-btn <?php echo esc_html($icon_position); ?>" href="<?php echo esc_url($item['services_btn_link']);?>" <?php echo wp_kses_post($link_open); ?>>
                                        <?php if( $item['services_btn_icon_position'] == 'before' ) : ?>
                                            <?php if($item['services_btn_icon']): ?>
                                            <?php \Elementor\Icons_Manager::render_icon( $item['services_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(!empty($item['services_btn_text'])){ ?>
                                        <span class="btn_text">
                                            <?php echo esc_html($item['services_btn_text']);?>    						
                                        </span>	
                                        <?php } ?>
                                        <?php if( $item['services_btn_icon_position'] == 'after' ) : ?> 				
                                            <?php if($item['services_btn_icon']): ?>
                                            <?php \Elementor\Icons_Manager::render_icon( $item['services_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>	    		    		
                                </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php
                endforeach; ?>

            </div>
            <div class="pagination-arrow text-center position-relative">
            <?php
                if( $sliderDots == 'true' ) echo '<div class="swiper-pagination"></div>';
            ?>
        </div>

        <script type="text/javascript"> 
            jQuery(document).ready(function(){
                var swiper<?php echo esc_attr($unique); ?><?php echo esc_attr($unique); ?> = new Swiper(".tp_slider-<?php echo esc_attr($unique); ?>", {				
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
    }
}