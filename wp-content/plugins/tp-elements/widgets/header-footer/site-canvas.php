<?php use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * HFE Site Logo widget
 *
 * HFE widget for Site Logo.
 *
 * @since 1.3.0
 */
class Pixelaxis_Offcanvas extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'site-off-canvas';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'OffCanvas Hamburger', 'tp-elements' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-menu-bar';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'header_footer_category' ];
	}

	/**
	 * Register Site Logo controls.
	 *
	 * @since 1.5.7
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
            'section_general_fields',
            [
                'label' => __( 'Canvas Settings', 'tp-elements'),
            ]
        );

        $this->add_control(
            'layout_settings',
            [
                'label'     => __( 'Layout', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,               
                
            ]
        );
        $this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Select Layout', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1', 'tp-elements'),
					'2'  => esc_html__( 'Layout 2', 'tp-elements'),					
				],
			]
		);
 		$this->add_control(
            'icon_settings',
            [
                'label'     => __( 'Icon Settings', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,               
                
            ]
        );
		
		$this->add_control(
			'enable_flip_style',
			[
				'label' => esc_html__( 'Enable Flip Style ?', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
                	'layout' => '2',
                ],
			]
		);

        $this->add_control(
            'dot_icon_color',
            [
                'label'     => __( 'Off Canvas Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [                   
                    '{{WRAPPER}} .nav-menu-link svg rect' => 'fill: {{VALUE}}', 
                    '{{WRAPPER}} .nav-menu-link i' => 'color: {{VALUE}}', 
                ],
                'condition' => [
                	'layout' => '2',
                ],
                
            ]
        );

        $this->add_control(
            'bar_icon_color',
            [
                'label'     => __( 'Off Canvas Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [                   
                    '{{WRAPPER}} .offcanvas-icon .nav-link-container .nav-menu-link span' => 'background: {{VALUE}}', 
                ],
                'condition' => [
                	'layout' => '1',
                ],
                
            ]
        );

		$this->add_control(
            'dot_icon_color_hover',
            [
                'label'     => __( 'Off Canvas Icon Hover Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '{{WRAPPER}} .nav-menu-link:hover svg rect' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .nav-menu-link:hover i' => 'color: {{VALUE}}',
                
                ],
                'separator' => 'before',
                
            ]
        );
        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Off Canvas Icon Box Width', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} ul.offcanvas-icon .nav-link-container a' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Off Canvas Icon Box Height', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} ul.offcanvas-icon .nav-link-container a' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'line-height',
			[
				'label' => esc_html__( 'Off Canvas Icon Box Line Height', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} ul.offcanvas-icon .nav-link-container a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'dot_icon_color_box',
            [
                'label'     => __( 'Off Canvas Icon Box BG', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '{{WRAPPER}} ul.offcanvas-icon .nav-link-container a' => 'background: {{VALUE}}',
                ],
                
            ]
        );

		$this->add_control(
            'dot_icon_hover_color_box',
            [
                'label'     => __( 'Off Canvas Icon Box Hover BG', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '{{WRAPPER}} ul.offcanvas-icon .nav-link-container a.box-style::before, {{WRAPPER}} ul.offcanvas-icon .nav-link-container a::hover' => 'background-color: {{VALUE}} !important',
                ],
                
            ]
        );

		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'offcanvas_iconbox_border',
		        'selector' => '{{WRAPPER}} ul.offcanvas-icon .nav-link-container a',
		    ]
		);

        $this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label'              => __( 'Border Radius', 'tp-elements' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} ul.offcanvas-icon .nav-link-container a'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]
		);

        $this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
			]
		);

        $this->add_control(
            'content_settings',
            [
                'label'     => __( 'Content Area Settings', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                
                
            ]
        );

       
        $this->add_group_control(
        	\Elementor\Group_Control_Background::get_type(),
        	[
        		'name' => 'background',
        		'label' => esc_html__( 'Background', 'tp-elements' ),
        		'types' => [ 'classic', 'gradient', 'video' ],
        		'selector' => '.menu-wrap-off',
        				
        		]
        );

        $this->add_control(
            'close_icon_settings',
            [
                'label'     => __( 'Close Icon Settings', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                
                
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label'     => __( 'Close Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '.menu-wrap-off .inner-offcan .nav-link-container .close-button' => 'color: {{VALUE}}',
                ],
                
            ]
        );
         $this->add_control(
            'close_icon_bg',
            [
                'label'     => __( 'Close Icon Background', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '.menu-wrap-off .inner-offcan .nav-link-container .close-button' => 'background: {{VALUE}}',
                ],
                
            ]
        );

		$this->add_control(
            'responsive_settings',
            [
                'label'     => __( 'Responsive Menu Color Settings', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                
                
            ]
        );

        $this->add_control(
            'menu_icon',
            [
                'label'     => __( 'Menu Icon Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '#mobile_menu .submenu-button' => 'color: {{VALUE}}',
                ],
                
            ]
        );

		$this->add_control(
            'menu_icon_bg',
            [
                'label'     => __( 'Menu Icon Bg', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '#mobile_menu .submenu-button' => 'background: {{VALUE}}',
                ],
                
            ]
        );
         $this->add_control(
            'menu_text',
            [
                'label'     => __( 'Menu Text Hover Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [                   
                    '.sidenav .widget_nav_menu ul li a:hover' => 'color: {{VALUE}}',
					'.sidenav .widget_nav_menu ul li.current-menu-item a' => 'color: {{VALUE}}',
                ],
                
            ]
        );
	
	}
	
	protected function render() {
		
		$settings = $this->get_settings_for_display(); ?>

		<style>
            .box-style {
                overflow: hidden;
                min-width: 50px;
                height: 50px;
                position: relative;
                border-radius: 50%;
                text-align: center;
                line-height: 50px;
            }
            .box-style::before {
                content: "";
                position: absolute;
                top: var(--y);
                left: var(--x);
                transform: translate(-50%, -50%);
                width: 0;
                height: 0;
                border-radius: 100%;
                background-color: #00100B;
                transition: all .7s ease;
                z-index: -1;
            }
            .box-style i {
                transition: all 0.5s ease-in-out;
                display: inline-block;
				font-size: 20px;
            }
            .box-style:hover::before {
                width: 400%;
                height: 400%;
            }
            .box-style:hover i {
                transform: rotateY(180deg);
            }

        </style>

		<div class="sidebarmenu-area text-right desktop">			
			<ul class="offcanvas-icon layout-<?php echo $settings['layout'];?>">
				<li class="nav-link-container <?php echo esc_attr( $settings['icon_align']);?>"> 
					<a href='#' class="nav-menu-link menu-button <?php if( $settings['enable_flip_style'] == 'yes' ) : ?> box-style <?php endif; ?>">
						<?php if($settings['layout'] == '2'){ ?>
							<?php if( $settings['enable_flip_style'] == 'yes' ) : ?>
								<i class="tp-grid-2"></i>
							<?php else : ?>
								<svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect y="14" width="18" height="2" fill="#1C2539"/>
									<rect y="7" width="18" height="2" fill="#1C2539"/>
									<rect width="18" height="2" fill="#1C2539"/>
								</svg>
							<?php endif; ?>
						<?php } else{ ?> 
						<span class="dot1"></span>
						<span class="dot2"></span>
						<span class="dot3"></span>
						<span class="dot4"></span>
						<span class="dot5"></span>
						<span class="dot6"></span>
						<span class="dot7"></span>
						<span class="dot8"></span>
						<span class="dot9"></span>
						<?php } ?>                                         
					</a> 
				</li>
			</ul>		
		</div>

	<?php
	}

}
