<?php
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Topbar_Icon_Bar_Widget extends \Elementor\Widget_Base {

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
        return 'topbar-icon-bar';
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
        return esc_html__( 'TP Iconbox Top', 'tp-elements' );
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
        return 'glyph-icon flaticon-price';
    }


    public function get_categories() {
        return [ 'header_footer_category' ];
    }

    public function get_keywords() {
        return [ 'list', 'title', 'features', 'heading', 'plan' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'_section_header',
			[
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);     

        $this->add_control(
            'field_type',
            [
                'label'        => __( 'Field Type', 'tp-elements'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'default',
                'options'      => [
                    'default' => __( 'Default Icon box', 'tp-elements'),
                    'mail'      => __( 'Mail Field', 'tp-elements'),
                    'phone'      => __( 'Phone Field', 'tp-elements'),
                   
                ],               
            ]
        );

        
        $this->add_control(
            'sub-text',
            [
                'label' => esc_html__( 'Sub Title', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Phone Number', 'tp-elements' ),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Title', 'tp-elements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '', 'tp-elements' ),
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'        => __( 'Icon Type', 'tp-elements'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'default',
                'options'      => [
                    'default' => __( 'Default Icon', 'tp-elements'),
                    'theme'      => __( 'Theme Icon', 'tp-elements'),                   
                   
                ],               
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],   
                
                'condition' =>[
                    'icon_type' =>  'default'
                ]
                
            ]
        );

        $this->add_control(
			'theme_icon',
			[
				'label' => esc_html__( 'Icon', 'tp-elements' ),
				'type' => Controls_Manager::SELECT2,
				'options' => tp_custom_get_icons(),				
				'default' => 'tp-angle-right',
				'separator' => 'before',
                'condition' =>[
                    'icon_type' =>  'theme'
                ]			
			]
		);

        

       
        $this->end_controls_section();


           
        $this->start_controls_section(
            '_section_style_text',
            [
                'label' => esc_html__( 'Text', 'tp-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__( 'Sub Title', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Sub Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list-content ul li .sub-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        

         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .tp-features-list-content ul li .sub-text',
            ]
        );  

        $this->add_control(
			'padding-sub',
			[
				'label' => esc_html__( 'Sub title padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-features-list-content ul li .sub-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'more_options_title',
            [
                'label' => esc_html__( 'Title', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list-content ul li .text-heading' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list-content ul li .text-heading:hover' => 'color: {{VALUE}};',
                ],
                'condition' =>[
                    'field_type' => [ 'mail', 'phone', 'default' ]
                ]
            ]
        ); 

         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_text_typography',
                'selector' => '{{WRAPPER}} .tp-features-list-content ul li .text-heading',
            ]
        );   
        
        $this->add_control(
			'show_separator',
			[
				'label' => esc_html__( 'Show Speator', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__( 'Separator Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list.separator_yes:after' => 'background: {{VALUE}};',
                   
                ],
            ]
        );    

        $this->add_control(
            'separtor_width',
            [
                'label' => esc_html__( 'Separator Height', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				
				'selectors' => [
					'{{WRAPPER}} .tp-features-list.separator_yes:after' => 'height: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}} ',
                  
				],
            ]
        );

        $this->add_control(
			'show_rotate',
			[
				'label' => esc_html__( 'Enable Skew', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        
        
        

        $this->add_control(
			'enable_hover_border',
			[
				'label' => esc_html__( 'Enable Hover Border', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Title Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-features-list-content ul li .query-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'alignment',
            [
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label' => esc_html__( 'Alignment', 'tp-elements' ),
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
                    '{{WRAPPER}} .tp-features-list-content ul' => 'justify-content: {{VALUE}}',
                ],
                'default' => 'center',
            ]
        );
        

        $this->end_controls_section();       


        $this->start_controls_section(
            '_section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'tp-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list-content ul li .icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tp-features-list-content ul li .icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );    
        
        $this->add_responsive_control(
            'icon_width',
            [
                'label' => esc_html__( 'Icon Size', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				
				'selectors' => [
					'{{WRAPPER}} .tp-features-list .icon svg' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}} ',
                    '{{WRAPPER}} .tp-features-list .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg',
                'label' => esc_html__( 'Icon Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tp-features-list-content ul li .icon i',
            ]
        );  

        $this->add_responsive_control(
            'icon_box_width',
            [
                'label' => esc_html__( 'Icon Box Width', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				
				'selectors' => [					
                    '{{WRAPPER}} .tp-features-list .icon i' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_box_height',
            [
                'label' => esc_html__( 'Icon Box Height', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				
				'selectors' => [                    
                    '{{WRAPPER}} .tp-features-list .icon i' => 'height: {{SIZE}}{{UNIT}};',                   
				],
            ]
        );
        $this->add_responsive_control(
            'icon_box_lineheight',
            [
                'label' => esc_html__( 'Icon Box With Size', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				
				'selectors' => [					
                  
                    '{{WRAPPER}} .tp-features-list .icon i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .tp-features-list-content ul li .icon',
            ]
        ); 

        $this->add_responsive_control(
            'icon_item_alignment',
            [
                'label' => esc_html__( 'Icon Alignment', 'tp-elements' ),
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
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tp-features-list-content ul li .icon i' => 'text-align: {{VALUE}}',
                ],
                
            ]
        );
        
        $this->add_control(
			'padding-icon',
			[
				'label' => esc_html__( 'Icon area Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-features-list-content ul li .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border-radius',
			[
				'label' => esc_html__( 'Icon area Border Radius', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-features-list-content ul li .icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'general_hover_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .tp-features-list-content ul li .icon i'
            ]
        );         
        $this->end_controls_section();
    } 

	protected function render() {
        $settings = $this->get_settings_for_display();?> 

        <div class="tp-features-list-content">                
            <ul class="tp-features-list separator_<?php echo $settings['show_separator'];?> border_<?php echo $settings['enable_hover_border'];?> rotate_<?php echo $settings['show_rotate'];?>">
                    <li>
                        <?php if ( $settings['icon'] ) : ?>
                            <div class="icon"><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></div>                            
                        <?php endif; ?>
                        <?php if ( $settings['theme_icon'] ) : ?>
                            <div class="icon"><i class="<?php echo  $settings['theme_icon'];?>"></i></div>                            
                        <?php endif; ?>
                        <div class="query-list">
                            <span class="sub-text"><?php echo wp_kses_post( $settings['sub-text'] ); ?></span>
                            <?php if('mail' == $settings['field_type']) : ?>
                                <a href="mailto:<?php echo esc_attr($settings['text']);?>"><span class="text-heading"><?php echo wp_kses_post( $settings['text'] ); ?></span></a>                            
                            <?php elseif('phone' == $settings['field_type']) : ?>
                                <a href="tel:<?php echo esc_attr(str_replace(" ","",($settings['text'])))?>"><span class="text-heading"><?php echo wp_kses_post( $settings['text'] ); ?></span></a>
                                <?php else: ?>
                                <span class="text-heading"><?php echo wp_kses_post( $settings['text'] ); ?></span>
                            <?php endif; ?>
                        </div>                        
                    </li>
                
            </ul>                          
        </div>
        <?php
    }
}