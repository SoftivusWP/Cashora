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
class Pixelaxis_Elementor_Hero_Slider_Widget  extends \Elementor\Widget_Base {
  
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
        return 'tp-hero-slider';
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
        return esc_html__( 'TP Hero Slider', 'tp-elements' );
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
        return [ 'slider' ];
    }
    protected function register_controls() {

        $this->start_controls_section(
            '_services_slider_s',
            [
                'label' => esc_html__( 'Slider Style', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_slider_style',
            [
                'label'   => esc_html__( 'Select Style', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [					
                    'style1' => esc_html__( 'Style 1', 'tp-elements'),
                ],
            ]
        );        

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Slider Item', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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
            'image2',
            [
                'label' => esc_html__('Arrow Image', 'tp-elements'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Title', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'New Level Of', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Title', 'tp-elements' ),
                'separator'   => 'before',
            ]
        ); 
        
        $repeater->add_control(
            'multi_text',
            [
                'label' => esc_html__('Multi Mission Text', 'tp-elements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Sports Training 
Fitness Goals
Workout Routine 
Athletic Training
                ', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Write a Mission and Press Enter for another mission', 'tp-elements' ),
                'separator'   => 'before',
            ]
        ); 

        $repeater->add_control(
            'sub-name',
            [
                'label' => esc_html__('Sub Title', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Top Rated Gym', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Sub Title', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'logo_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                ]
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
                'label'   => esc_html__( 'Wide Screen > 1399px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'tp-elements' ), 
                    '2' => esc_html__( '2 Column', 'tp-elements' ),
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
                'default' => 'true',
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
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_dot_active_width',
            [
                'label' => esc_html__( 'Active Dot Height', 'tp-elements' ),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                ],
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
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}} .pixelaxis-addon-slider.swiper.swiper-horizontal' => 'padding-bottom: {{SIZE}}{{UNIT}};',                    
                ],
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
                    '{{WRAPPER}} .pixelaxis-addon-slider .swiper-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_dot_padding',
            [
                'label' => esc_html__( 'Pagination Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-addon-slider .swiper-pagination' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'media_border',
		        'selector' => '{{WRAPPER}} .tp-slider-navigation .tp-slider-prev i, {{WRAPPER}} .tp-slider-navigation .tp-slider-next i',
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
                    'size' => 24,
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
                    '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area .content--box .slider-title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slider-inner-wrapper .tp-el-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area .content--box .slider-title, .slider-inner-wrapper .tp-el-subtitle',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__( 'Sub Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider .single--item .content--box .slider-subtitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area .content--box .slider-subtitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slider-inner-wrapper .tp-el-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area .content--box .slider-subtitle, {{WRAPPER}} .slider-inner-wrapper .tp-el-subtitle',
            ]
        );

         $this->add_control(
            'slider_content_styles',
            [
                'label' => esc_html__( 'Slider Item Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

         $this->add_control(
            'slider_item_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_item_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slide_item_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp--slider.slider-style5 .slider-content-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_control(
            'slider_quote_style',
            [
                'label' => esc_html__( 'Quote Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                 'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_control(
            'slider_left_quote_style',
            [
                'label' => esc_html__( 'Left Quote', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                 'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_left_quote_width',
            [
                'label' => esc_html__( 'Size', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .left-quote img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_left_quote_horizontal',
            [
                'label' => esc_html__( 'Horizontal', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .left-quote' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_left_quote_vertical',
            [
                'label' => esc_html__( 'Verticale', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .left-quote' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_right_quote_style',
            [
                'label' => esc_html__( 'Right Quote', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                 'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_right_quote_width',
            [
                'label' => esc_html__( 'Size', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .right-quote img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_right_quote_horizontal',
            [
                'label' => esc_html__( 'Horizontal', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .right-quote' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'slider_right_quote_vertical',
            [
                'label' => esc_html__( 'Verticale', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .right-quote' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_control(
            'slider_text_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                 'condition' => [ 'tp_slider_style' => 'style5', ],
            ]
        );

        $this->add_responsive_control(
            'tes-name-desig-align',
            [
                'label' => esc_html__( 'Name & Designation', 'tp-elements' ),
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
                    '{{WRAPPER}} .slider-style5 .slider-content-area .bottom--area' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [ 'tp_slider_style' => 'style5', ],
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
        $infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
        $centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
        $col_lg          = $settings['col_lg'];
        $col_md          = $settings['col_md'];
        $col_sm          = $settings['col_sm'];
        $col_xs          = $settings['col_xs'];
        $item_gap        = $settings['item_gap_custom']['size'];
        $item_gap        = !empty($item_gap) ? $item_gap : '30';        
        $prev_text       = !empty($prev_text) ? $prev_text : '';       
        $next_text       = !empty($next_text) ? $next_text : '';
        $unique          = rand(2012,35120);
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

        if ( empty($settings['logo_list'] ) ) {
            return;
        }

        $sstyle = $settings['tp_slider_style'];
       


        ?>

            <!-- banner section start-->
            <section class="banner-section position-relative index-one pt-120 pb-120">
                <div class="position-relative">
                    <div class="element-area d-none d-xxl-block">
                        <div class="icon-area position-absolute end-0 tp-abs-jigjag">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/banner-elements.png" class="pt-20 me-20" alt="icon">
                        </div>
                    </div>
                    <div class="container pt-20 mt-8">
                        <div class="row justify-content-center">
                            <div class="banner-carousel col-lg-12 ">
                                <div class="swiper-wrapper py-8 py-lg-20">

                                    <?php
                                    foreach ( $settings['logo_list'] as $index => $item ) :                        
                                    $imgId = $item['image']['id'];
                                                            
                                    if($imgId ){
                                        $image = wp_get_attachment_image_src($imgId, 'full')[0];
                                        $IMGstyle = 'style="background-image: url( '. $image .' );"';
                                    }else{
                                        $IMGstyle = '';
                                        $image = '';
                                    }   
                                    $imgId2 = $item['image2']['id'];                                            
                                    if($imgId2 ){
                                        $image2 = wp_get_attachment_image_src($imgId2, 'full')[0];
                                    
                                    }else{                           
                                        $image2 = '';
                                    }                               
                                    $title        = !empty($item['name']) ? $item['name'] : '';                              
                                    $sub_title    = !empty($item['sub-name']) ? $item['sub-name'] : '';   
                                    
                                    $multi_text   = !empty($item['multi_text']) ? $item['multi_text'] : '';  
                                    $multi_text_array = explode("\n", $multi_text);
                                    ?>

                                    <div class="swiper-slide">
                                        <div class="main-content cus-z2">
                                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center new-level gap-6 gap-md-12">
                                                <?php if(!empty($title)):?>
                                                <span class="display-one"><?php echo wp_kses_post($title); ?></span>
                                                <?php endif;?>
                                                <div class="img-area d-center gap-4 gap-md-7 cus-border border b-second rounded-pill pe-8 d-inline-flex">
                                                    <img src="<?php echo esc_url($image); ?>" class="profile-img" alt="img">
                                                    <div class="img-area">
                                                        <img src="<?php echo esc_url($image2); ?>" alt="img">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="head-text py-4 py-md-5 position-relative">
                                                    <?php
                                                    for($i = 0; $i < count($multi_text_array); $i++){

                                                        echo '<span class="cmn-text display-one d-inline px-0 px-md-6 px-lg-12  ">' . $multi_text_array[$i] . ' </span>';
                                                    } ?>
                                            </div>
                                            <?php if(!empty($sub_title)):?>
                                            <span class="display-one"><?php echo wp_kses_post($sub_title); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute start-0 position-area d-none d-lg-block ps-10 ps-xxl-15 ms-5">
                        <span class="banner-line">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/banner-line.png" alt="icon">
                        </span>
                        <div class="video-bg-thumb d-center">
                            <a href="https://www.youtube.com/watch?v=BHACKCNDMW8" class="popup-video popup-videos btn-popup-animation position-relative p1-bg-color d-center rounded-circle">
                                <i class="tp-play fs-six s1-color"></i>
                            </a>
                        </div>
                    </div>
                    <div class="side-menubar position-area">
                        <div class="sidebar-mid-area d-none d-sm-flex flex-column gap-8 gap-xl-20">
                            <div class="bottom-area">
                                <ul class="d-grid gap-4 py-6 social-area">
                                    <li>
                                        <a href="https://twitter.com" aria-label="Twitter" class="d-center cus-border border b-sixth">
                                            TW
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com" aria-label="Facebook" class="d-center cus-border border b-sixth">
                                            FB
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com" aria-label="Youtube" class="d-center cus-border border b-sixth">
                                            YT
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php if( $sliderDots == 'true' ) : ?>
                            <div class="cus-z1 position-relative d-flex flex-column">
                                <span class="n1-color fs-six slide-number curString"></span>
                                <div class="swiper-pagination my-8"></div>
                                <span class="n1-color fs-six slide-number totalString"></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </section>
            <!-- banner section end -->
          
            <script type="text/javascript"> 
                jQuery(document).ready(function(){


                    // banner Carousel
                    let bannerCarousel = document.querySelector('.banner-carousel');
                    let bannerCarouselBtn = document.querySelector('.sidebar-mid-area');
                    if(bannerCarousel){
                        const mySwiper = new Swiper(bannerCarousel, {
                        // loop: true,
                        // speed: 1200,
                        // autoplay: {
                        //     delay: 2000,
                        //     disableOnInteraction: false,
                        // },
                        spaceBetween: 24,
                        slidesPerView: 1,
                        paginationClickable: true,
                        pagination: {
                            el: '.sidebar-mid-area .swiper-pagination',
                            clickable: true,
                            renderBullet: function (index, className) {
                            return '<span class="' + className + '">' + '</span>';
                            },
                        },
                        });
                        function renderCustom(swiper) {
                        var current = swiper.realIndex + 1;
                        var total = swiper.slides.length;
                        var total = total-2;
                        bannerCarouselBtn.querySelector('.curString').innerHTML = ('0' + current).slice(-2);
                        bannerCarouselBtn.querySelector('.totalString').innerHTML = '0' + total;
                        }
                        renderCustom(mySwiper);
                        mySwiper.on('slideChange', function () {
                        renderCustom(mySwiper);
                        });
                    }



                    // header text animation
                    function toggleActive(elements, index) {
                        elements.eq(index).addClass("active");
                        setTimeout(function() {
                            elements.eq(index).removeClass("active");
                            toggleActive(elements, (index + 1) % elements.length);
                        }, 5000);
                    }
                    jQuery(".head-text").each(function() {
                        var cmnTextElements = jQuery(this).find(".cmn-text");
                        toggleActive(cmnTextElements, 0);
                    });

                });



            </script>
            
        <?php
    }
}