<?php
/**
 * Tab widget class
 *
 */
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Tab_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'tp-tab';
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
        return esc_html__( 'TP Tab', 'tp-elements' );
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
        return 'glyph-icon flaticon-tabs-1';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'tab', 'vertical', 'icon', 'horizental' ];
    }


	protected function register_controls() {
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => esc_html__( 'Tabs', 'tp-elements' ),
            ]
        );

       

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__( 'Title & Description', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Tab Title', 'tp-elements' ),
                'placeholder' => esc_html__( 'Tab Title', 'tp-elements' ),
                'label_block' => true,
            ]
        );
       
        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__( 'Content', 'tp-elements' ),
                'default' => __( 'Tab Content', 'tp-elements' ),
                'placeholder' => esc_html__( 'Tab Content', 'tp-elements' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,                
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'tp-elements' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'is_external' => 'true',
                ],
                'dynamic' => [
                    'active' => true,
                ],                
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs Items', 'tp-elements' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [

                        'tab_title' => esc_html__( 'Tab #1', 'tp-elements' ),
                        'tab_content' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Tab #2', 'tp-elements' ),
                        'tab_content' => esc_html__( 'Ohh your data click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],

                    [
                        'tab_title' => esc_html__( 'Tab #3', 'tp-elements' ),
                        'tab_content' => esc_html__( 'You can Click edit/delete button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'tp-elements' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );




        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    
                    'vertical' => esc_html__( 'Vertical', 'tp-elements' ),
                    'horizontal' => esc_html__( 'Horizontal', 'tp-elements' ),
                ],                
                'separator' => 'before',
            ]
        );


        $this->end_controls_section();

        //start title styling

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__( 'Title', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .tps-tab-style-one .button-area button',
            ]
        );
      

        $this->add_responsive_control(
		    'tab_title_spacing_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],  
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-style-one .button-area button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'tab_title_spacing_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],  
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-style-one .button-area button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);    

        $this->add_control(
            'tab_active_border_color',
            [
                'label' => esc_html__( 'Active Border Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .button-area button.active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tps-tab-style-one .button-area button:last-child.active' => 'border-color: {{VALUE}};',
                ],
               
            ]
        );

    
        $this->add_responsive_control(
            'tab_title_area_padding',
            [
                'label' => esc_html__( 'Title Area Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .button-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( '_tabs_title_icon' );

        $this->start_controls_tab(
            'tab_icon_bg_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
            ]
        ); 

        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .button-area button' => 'color: {{VALUE}};',
                ],               
            ]
        );


        $this->end_controls_tab();



        $this->start_controls_tab(
            'tab_icon_bg_hover_tab',
            [
                'label' => esc_html__( 'Active', 'tp-elements' ),
            ]
        );
        
        $this->add_control(
            'tab_active_color',
            [
                'label' => esc_html__( 'Active Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .button-area button.active' => 'color: {{VALUE}};',
                   
                ],
               
            ]
        );
     

        $this->end_controls_tab();
        $this->end_controls_tabs();      


        $this->end_controls_section();

        //start content styling

         $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__( 'Content', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one' => 'color: {{VALUE}};',
                ],               
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one',                
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'content_bg',
                'selector' => '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one',
                'separator' => 'before',            
            ]
        );

   

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Bg', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one a.tps-btn' => 'background: {{VALUE}};',
                ],               
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Button text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one a.tps-btn' => 'color: {{VALUE}};',
                ],               
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__( 'Button Hover Bg', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one a.tps-btn:hover' => 'background: {{VALUE}};',
                ],               
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__( 'Button hover text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one a.tps-btn:hover' => 'color: {{VALUE}};',
                ],               
            ]
        );
       

        $this->add_responsive_control(
            'content_top_gap',
            [
                'label' => esc_html__( 'Content Top Gap', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],                
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one' => 'margin-top: {{SIZE}}{{UNIT}};',                   
                ],
            ]
        );  


        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],      
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-style-one .tab-content .tps-tab-content-one' => 'padding: {{SIZE}}{{UNIT}};',
              
                ],
            ]
        ); 

      
        

        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $tabs     = $this->get_settings_for_display('tabs');  
        $settings = $this->get_settings_for_display();  
        $id_int   = substr( $this->get_id_int(), 0, 3 ); 

        require plugin_dir_path(__FILE__)."/style1.php";
      
    }
}