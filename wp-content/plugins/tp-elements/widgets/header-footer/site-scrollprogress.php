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
class Pixelaxis_Scroll_Progress extends Widget_Base {

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
		return 'site-scroll-progress';
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
		return __( 'Scroll Progress Bar', 'tp-elements' );
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
                'label'     => __( 'Cart', 'tp-elements'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                
                
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label'     => __( 'Cart Color', 'tp-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                   
                    '.menu-wrap-off .inner-offcan .nav-link-container .close-button' => 'color: {{VALUE}}',
                ],
                
            ]
        );
         $this->add_control(
            'close_icon_bg',
            [
                'label'     => __( 'Cart Background', 'tp-elements'),
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

			.scrollbar-area {
				min-height: 70vh;
			}
			.scrollbar-area span{
				width: 1px;
				display: inline-block;
			}

			.navbar-toggle-wrapper{
				width: 45px;
				min-width: 45px;
				height: 45px;
				min-height: 45px;
			}
			.navbar-toggle-btn.second {
				width: 25px;
				height: 25px;
				min-height: 18px;
				z-index: 10;
				padding: 0;
			}

			.navbar-toggle-btn.second.open span:nth-child(1) {
				top: 50%;
				width: 0%;
			}
			.navbar-toggle-btn.second.open span:nth-child(2) {
				transform: rotate(45deg);
			}
			.navbar-toggle-btn.second.open span:nth-child(3) {
				transform: rotate(-45deg);
			}
			.navbar-toggle-btn.second.open span:nth-child(4) {
				bottom: 50%;
				width: 0%;
			}
			.navbar-toggle-btn.second span {
				height: 1px;
				width: 25px;
				background: rgb(245,245,245);
				transform: rotate(0deg);
			}
			.navbar-toggle-btn.second span:nth-child(1) {
				top: 0;
			}
			.navbar-toggle-btn.second span:nth-child(2),
			.navbar-toggle-btn.second span:nth-child(3) {
				top: 50%;
			}
			.navbar-toggle-btn.second span:nth-child(4) {
				bottom: 0;
			}

        </style>

		<div class="site-progress-scrollbar-wrapper">
			<div class="d-flex gap-3 gap-md-5 flex-column h-100 justify-content-between align-items-center px-2 px-lg-4 px-xl-0 py-3 py-md-6">
				<div class="navbar-toggle-wrapper d-center p1-bg-color d-none d-xl-flex">
					<button class="navbar-toggle-btn second position-relative transition header-btn d-center menu-button" type="button">
						<span class="position-absolute transition"></span>
						<span class="position-absolute transition"></span>
						<span class="position-absolute transition"></span>
						<span class="position-absolute transition"></span>
					</button>
				</div>
				<div class="scrollbar-area position-relative h-100 d-none d-sm-flex justify-content-center mt-20 mt-xl-0 s2-bg-color">
					<span class="progress-scrollbar position-absolute transition p1-bg-color"></span>
					<span class="h-100 "></span>
				</div>
				<div class="bottom-area">
					<a href="#" class="d-center box-style box-third first-alt position-relative">
						<span class="fs-five d-center">
							<i class="tp tp-cart-shopping"></i>
						</span>
					</a>
				</div>
			</div>
		</div>

		<script type="text/javascript"> 

			jQuery(window).on('scroll', function() {
				const scrollTop = jQuery(window).scrollTop();
				const scrollHeight = jQuery(document).height() - jQuery(window).height();
				const scrollPercentage = (scrollTop / scrollHeight) * 100;
				jQuery('.progress-scrollbar').css('height', scrollPercentage + '%');
			});

		</script>

	<?php
	}

}
