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

class Pixelaxis_Advance_Tab_Widget extends \Elementor\Widget_Base {
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
        return 'tp-tab-advanced';
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
        return esc_html__( 'TP Advance Tab', 'tp-elements' );
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
        return [ 'tpaddon_category' ];
    }

    public function get_keywords() {
        return [ 'tab', 'vertical', 'icon', 'horizental' ];
    }

	protected function register_controls() {
        // $category_dropdown[0] = 'Select Template';
        // $best_wp = new wp_Query(array(
        // 'post_type'      => 'tpelements_pro',
        // 'posts_per_page' => -1
                                         
        // ));  

        //  while($best_wp->have_posts()): $best_wp->the_post(); 

        //     $title = get_the_title();
        //     $id = get_the_ID();
        //     $category_dropdown[$id] = $title;

        //  endwhile; 
        //  wp_reset_query();  
      

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
                'label'       => esc_html__( 'Tab Title ', 'tp-elements' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Tab Title', 'tp-elements' ),
                'placeholder' => esc_html__( 'Tab Title', 'tp-elements' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_sub_title',
            [
                'label'       => esc_html__( 'Tab Sub Title', 'tp-elements' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Tab Sub Title', 'tp-elements' ),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'content_location',
            [
                'label'       => esc_html__( 'Select Content Location', 'tp-elements' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT,
                'default'     => 'editor',               
                'options' => [
                    'editor'    => 'Editor',
                    'shortcodes' => 'Shortcodes',                                
                    // 'templates' => 'Templates',                                
                ],                                          
            ]
        );

        // $repeater->add_control(
        //     'template',
        //     [
        //         'label'       => esc_html__( 'Template', 'tp-elements' ),
        //         'type'        => Controls_Manager::SELECT, 
        //         'label_block' => true,
        //         'default'     => 0,         
        //         'options' => [      
                        
        //         ]+ $category_dropdown,                
        //         'separator' => 'before', 
        //         'condition' => [
        //             'content_location' => 'templates',
        //         ],      
        //     ]
        // );
 
        $repeater->add_control(
            'tab_shortcode',
            [
                'label'       => esc_html__( 'Tab Shortcode', 'tp-elements' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( '', 'tp-elements' ),
                'placeholder' => esc_html__( 'Shortcode here', 'tp-elements' ),
                'label_block' => true,
                'condition' => [
                    'content_location' => 'shortcodes',
                ],
            ]
        );
        $repeater->add_control(
            'tab_content',
            [
                'label'       => esc_html__( 'Content', 'tp-elements' ),
                'default'     => __( 'Tab Content', 'tp-elements' ),
                'placeholder' => esc_html__( 'Tab Content', 'tp-elements' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
                 'condition' => [
                    'content_location' => 'editor',
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'  => esc_html__( 'Tabs Items', 'tp-elements' ),
                'type'   => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [

                        'tab_title'   => esc_html__( 'Tab #1', 'tp-elements' ),
                        'tab_content' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],
                    [
                        'tab_title'   => esc_html__( 'Tab #2', 'tp-elements' ),
                        'tab_content' => esc_html__( 'Ohh your data click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],

                    [
                        'tab_title'   => esc_html__( 'Tab #3', 'tp-elements' ),
                        'tab_content' => esc_html__( 'You can Click edit/delete button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.With thousands of Flash Components, Files and Templates, Star & Shield is the largest library of stock Flash online. Starting at just $2 and by a huge community.', 'tp-elements' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__( 'View', 'tp-elements' ),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );


        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'tp-elements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'vertical' => esc_html__( 'Vertical', 'tp-elements' ),
                    'horizontal' => esc_html__( 'Horizontal', 'tp-elements' ),
                ],                
                'separator' => 'before',
            ]
        );


        $this->end_controls_section();

        //start title & sub title styling

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__( 'Tab Title & Subtitle', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tab_title_width',
            [
                'label' => esc_html__( 'Nav Width', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '1',
                'options' => [
                    '1' => [
                        'title' => esc_html__( 'Max Width', 'tp-elements' ),
                        'icon' => 'eicon-form-vertical',
                    ],
                    'initial' => [
                        'title' => esc_html__( 'Inline', 'tp-elements' ),
                        'icon' => 'eicon-navigation-horizontal',
                    ],
             
                ],
                'separator' => 'before',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li' => 'flex: {{VALUE}};',
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'width: 100%;',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_title_align',
            [
                'label' => esc_html__( 'Nav Alignment', 'tp-elements' ),
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
             
                ],
                'separator' => 'before',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
			'_accordion_item_padding',
			[
				'label' => esc_html__( 'Nav Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tps-tab-advance .nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'border_item_border',
		        'selector' => '{{WRAPPER}} .tps-tab-advance .nav',
		    ]
		);

        $this->start_controls_tabs( '_tabs_tab_button' );

        $this->start_controls_tab(
            'tab_icon_bg_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
            ]
        ); 

        $this->add_responsive_control(
            'tab_btn_alignment',
            [
                'label' => esc_html__( 'Text Alignment', 'tp-elements' ),
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
             
                ],
                'separator' => 'before',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'text-align: {{VALUE}}',
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'label' => esc_html__( 'Title Typography', 'tp-elements' ),
                'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button',
            ]
        );

        $this->add_control(
            'tab__text_color',
            [
                'label' => esc_html__( 'Button Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'color: {{VALUE}};',
                ],
               
            ]
        );

        $this->add_control(
            'tab__bg_color',
            [
                'label' => esc_html__( 'Button Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'background: {{VALUE}};',
                ],
               
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button',
		    ]
		);

        $this->add_responsive_control(
            'tab_title_border_radius',
            [
                'label' => esc_html__( 'Button Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        ); 
        
        $this->add_responsive_control(
		    'tab_title_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-advance .nav li button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'tab_title_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-advance .nav li button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_subtitle_typography',
                'label' => esc_html__( 'Subtitle Typography', 'tp-elements' ),
                'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button .tp-sub-title',
            ]
        );

        $this->add_control(
            'tab_subtitle_text_color',
            [
                'label' => esc_html__( 'Subtitle Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button .tp-sub-title' => 'color: {{VALUE}};',
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
        

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_active_typography',
                'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button.active',
            ]
        );

        $this->add_control(
            'tab_active_text_color',
            [
                'label' => esc_html__( 'Button Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button.active' => 'color: {{VALUE}};',
                ],
               
            ]
        );

        $this->add_control(
            'tab_active_bg_color',
            [
                'label' => esc_html__( 'Button Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button.active' => 'background: {{VALUE}};',
                ],
               
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_active_border',
		        'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button.active',
		    ]
		);

        $this->add_responsive_control(
            'tab_title_active_border_radius',
            [
                'label' => esc_html__( 'Button Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        ); 
        
        $this->add_responsive_control(
		    'tab_title_active_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-advance .nav li button.active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'tab_title_active_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tps-tab-advance .nav li button.active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_subtitle_active_typography',
                'selector' => '{{WRAPPER}} .tps-tab-advance .nav li button.active .tp-sub-title',
            ]
        );

        $this->add_control(
            'tab_subtitle_active_text_color',
            [
                'label' => esc_html__( 'Subtitle Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-advance .nav li button.active .tp-sub-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .tps-tab-content-one' => 'color: {{VALUE}};',
                ],               
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .tps-tab-content-one',                
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'content_bg',
                'selector' => '{{WRAPPER}} .tps-tab-content-one',
                'separator' => 'before',            
            ]
        );

        $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'content_button_border',
		        'selector' => '{{WRAPPER}} .tps-tab-advance .tabItem .table-responsive .table tbody',
		    ]
		);

         $this->add_responsive_control(
            'tab_content_align',
            [
                'label' => esc_html__( 'Content Alignment', 'tp-elements' ),
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
             
                ],
                'separator' => 'before',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tps-tab-content-one' => 'text-align: {{VALUE}}'
                ]
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
                    '{{WRAPPER}} .tps-tab-content-one' => 'margin-top: {{SIZE}}{{UNIT}};',                   
                ],
            ]
        );  

        $this->add_responsive_control(
			'_content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tps-tab-content-one' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $tabs = $this->get_settings_for_display('tabs');  
        $settings = $this->get_settings_for_display();  
        $id_int = substr( $this->get_id_int(), 0, 3 ); 


        ?>

        <style>
            .tps-tab-advance.vertical {
                display: flex;
            }
            .tps-tab-advance.vertical .nav {
                flex-direction: column;
            }
            .tps-tab-advance.vertical .nav li {
                margin-right: 0;
                width: max-content;
            }
            .tab-content {
                width: 100%;
            }
            @media (max-width: 767px) {
                .tps-tab-advance.vertical {
                flex-direction: column;
                padding-left: 0;
            }
            }

        </style>

        <div class="tps-tab-advance  <?php echo $settings['type'];?>">        
            <ul class="nav" id="v-pills-tab" role="tablist" aria-orientation="<?php echo $settings['type'];?>">
                <?php
                $unique = rand(2012,3554120);
                $x = 0;
                $y = 1;
                foreach ( $tabs as $index => $item ) :
                    $x++;
                    $span = $y++;

                    if($x == 1){
                        $active_tab = 'active';
                    }else{
                        $active_tab = '';
                    }

                    $tab_count = $index + 1;
                    $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                    $this->add_render_attribute( $tab_title_setting_key, [
                        'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title' ],
                        'data-tab' => $tab_count,
                        'role' => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ] );

                    $icon = !empty($item['tab_icon']) ? '<i class="'.$item['tab_icon'].'"></i>': '';
                    
                    $titleimg    = !empty($item['selected_image']['url']) ? '<img src="'. $item['selected_image']['url']. '" />' : '';
                    ?>           

                    <li class="nav-item">
                        <button class="nav-link <?php echo $active_tab;?>" id="v-pills<?php echo esc_html($x);?><?php echo esc_html($unique);?>" data-bs-toggle="pill" data-bs-target="#v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" type="button" role="tab" aria-controls="v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" aria-selected="false"><?php echo esc_html($item['tab_title']); ?>
                        <?php if( !empty( $item['tab_sub_title'] ) ) : ?>
                        <span class="tp-sub-title d-block"><?php echo esc_html( $item['tab_sub_title'] ); ?></span>
                        <?php endif; ?>
                        </button>
                    </li>
                <?php endforeach; ?>                    
                
            
                    </ul>

            <div class="tab-content" id="v-pills-tabContent">
            
                <?php
                    $x = 0;
                    foreach ( $tabs as $index => $item ) :
                        $tab_count = $index + 1;
                        $x++;
                        if($x == 1){
                            $active_tab = 'active show';
                        }else{
                            $active_tab = '';
                        }
                        $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                        $tab_title_mobile_setting_key = $this->get_repeater_setting_key( 'tab_title_mobile', 'tabs', $tab_count );

                        $this->add_render_attribute( $tab_content_setting_key, [
                            'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                            'class' => [ 'elementor-tab-content', 'elementor-clearfix' ],
                            'data-tab' => $tab_count,
                            'role' => 'tabpanel',
                        ] );

                        $this->add_render_attribute( $tab_title_mobile_setting_key, [
                            'class' => [ 'elementor-tab-title', 'elementor-tab-mobile-title' ],
                            'data-tab' => $tab_count,
                            'role' => 'tab',
                        ] );

                        $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );                       
                        ?>                
                    
                        <div class="tab-pane fade <?php echo esc_attr($active_tab);?>" id="v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" role="tabpanel">
                        <!-- start tab content -->
                        <div class="tps-tab-content-one">
                            <?php if ( $item['content_location'] == 'shortcodes' ) {
                                echo do_shortcode( $item['tab_shortcode'] );
                            } else {
                                echo $this->parse_text_editor( $item['tab_content'] ); 
                            }
                             
                            
                            ?>                        
                        </div>
                        <!-- start tab content End -->     
                         
                        <?php // echo do_shortcode( $item['tab_shortcode'] ); ?>
                    </div>
                <?php endforeach; ?>
            
                
            </div>
    
        </div>
   
        <?php
    }
}