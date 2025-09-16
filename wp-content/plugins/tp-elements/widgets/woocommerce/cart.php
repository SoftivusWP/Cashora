<?php
/**
 * Elementor Product List.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Product_Cart extends \Elementor\Widget_Base {

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
		return 'tp-product-cart';
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
		return __( 'TP Woo Cart', 'tp-elements' );
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
		return 'glyph-icon flaticon-multimedia';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'product', 'list', 'category' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
    {
    	$this->start_controls_section(
            'tp_cart_content',
            [
                'label' => esc_html__('Cart Item', 'tp-elements'),
               
            ]
        );

		$this->add_control(
			'cart_style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'cart_default',
				'separator' => 'before',
				'options' => [					
					'cart_default' => esc_html__( 'Cart Default', 'tp-elements'),
					'cart_flip' => esc_html__( 'Cart Flip', 'tp-elements'),
				],
			]
		);

        $this->add_control(
			'cart_icon',
			[
				'label'       => __( 'Cart Icon', 'tp-elements' ),
				'type'        => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				]
            ]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'tp_cart_style_start',
            [
                'label' => esc_html__('Cart Style', 'tp-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'cart_typography',
		        'selector' => '{{WRAPPER}} .menu-cart-area i',
		    ]
		);
		
		$this->add_control(
            'width',
            [
                'label' => esc_html__( 'width', 'tp-elements' ),
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
                    '{{WRAPPER}} .menu-cart-area' => 'width: {{SIZE}}{{UNIT}};',
                    
                ],
            ]
        );
        $this->add_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'tp-elements' ),
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
                    '{{WRAPPER}} .menu-cart-area' => 'height: {{SIZE}}{{UNIT}};',
                   
                ],
            ]
        );
        $this->add_control(
            'line-height',
            [
                'label' => esc_html__( 'Line Height', 'tp-elements' ),
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
                    '{{WRAPPER}} .menu-cart-area' => 'line-height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
			'align',
			[
				'label'              => __( 'Alignment', 'tp-elements' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'start'   => [
						'title' => __( 'Left', 'tp-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'tp-elements' ),
						'icon'  => 'eicon-h-align-center',
					],
					'end'  => [
						'title' => __( 'Right', 'tp-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				
				'selectors'          => [
					'{{WRAPPER}} .menu-cart-area' => 'text-align: {{VALUE}};',
				],
				'frontend_available' => true,
			]
		); 

		$this->start_controls_tabs( 'cart_woo_tab' );
		$this->start_controls_tab(
			'_tab_cart_normal',
			[
				'label' => esc_html__( 'Normal', 'tp-elements' ),
			]
		);
		//fields place here
        $this->add_control(
            'cart_icon_color',
            [
				'label'   => esc_html__('Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
				'default' => '#040404',
                'selectors' => [
                    '{{WRAPPER}} .menu-cart-area svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .menu-cart-area i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg',
                'label' => esc_html__( 'Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.menu-cart-area, .menu-cart-area::before',
            ]
        ); 
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'icon_border',
		        'selector' => '{{WRAPPER}} .menu-cart-area',
		    ]
		);
		$this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '.menu-cart-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
	
		$this->end_controls_tab();
	
		$this->start_controls_tab(
			'_tab_cart_hover',
			[
				'label' => esc_html__( 'Hover', 'tp-elements' ),
			]
		);
	
		//fields place here
		$this->add_control(
            'cart_icon_hover_color',
            [
				'label'   => esc_html__('Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
				'default' => '#040404',
                'selectors' => [
                    '{{WRAPPER}} .menu-cart-area:hover svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .menu-cart-area:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_hover_bg',
                'label' => esc_html__( 'Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.menu-cart-area:hover, .menu-cart-area:hover::before',
            ]
        ); 
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'icon_border_hover',
		        'selector' => '{{WRAPPER}} .menu-cart-area:hover',
		    ]
		);
		$this->add_control(
            'icon_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '.menu-cart-area:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
	
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


        $this->start_controls_section(
            'tp_count_style_start',
            [
                'label' => esc_html__('Cart Count Style', 'tp-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'cart_number_color',
            [
				'label'   => esc_html__('Cart Count Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
				'default' => '#272727',
                'selectors' => [
                    '{{WRAPPER}} .menu-cart-area span.icon-num' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'cart_count_bg_color',
            [
                'label' => esc_html__('Count Bg Color', 'tp-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#B79B6C',
                'selectors' => [
                    '{{WRAPPER}} .menu-cart-area span.icon-num' => 'background: {{VALUE}};',
                  

                ],
            ]
        );
        $this->add_responsive_control(
			'position',
			[
				'label'     => __( 'Count Bg Top Position', 'tp-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'max'  => 100,
						'min'  => 1,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .menu-cart-area span.icon-num' => 'top: {{SIZE}}%;',
				],
			]
		);
        $this->add_responsive_control(
			'position2',
			[
				'label'     => __( 'Count BG Right Position', 'tp-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'max'  => 100,
						'min'  => -50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .menu-cart-area span.icon-num' => 'right: {{SIZE}}%;',
				],
			]
		);

        $this->end_controls_section();
		
        $this->start_controls_section(
            'sticky_style_cart',
            [
                'label'     => __( 'Sticky Style ', 'tp-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                
            ]
        );

		$this->add_control(
			'sticky_cart_heading',
			[
				'label' => esc_html__( 'Sticky Cart', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->start_controls_tabs( 'tabs_toggle_sticky_color' );

        $this->start_controls_tab(
            'sticky_tab_toggle_normal',
            [
                'label' => __( 'Normal', 'tp-elements'),
            ]
        );

        $this->add_control(
            'sticky_cart_icon_color',
            [
				'label'   => esc_html__('Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}} .menu-cart-area svg path' => 'fill: {{VALUE}};',
                    '.tp-sticky {{WRAPPER}} .menu-cart-area i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sticky_icon_bg',
                'label' => esc_html__( 'Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.tp-sticky .menu-cart-area, .menu-cart-area::before',
            ]
        ); 
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'sticky_icon_border',
		        'selector' => '.tp-sticky {{WRAPPER}} .menu-cart-area',
		    ]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sticky_tab_toggle_hover',
            [
                'label' => __( 'Hover', 'tp-elements'),
            ]
        );

        $this->add_control(
            'sticky_cart_hover_icon_color',
            [
				'label'   => esc_html__('Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}} .menu-cart-area:hover svg path' => 'fill: {{VALUE}};',
                    '.tp-sticky {{WRAPPER}} .menu-cart-area:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sticky_hover_icon_bg',
                'label' => esc_html__( 'Background', 'tp-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.tp-sticky .menu-cart-area:hover, .menu-cart-area:hover::before',
            ]
        ); 
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'sticky_icon_hover_border',
		        'selector' => '.tp-sticky {{WRAPPER}} .menu-cart-area:hover',
		    ]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs(); 

		
		$this->add_control(
			'sticky_cartcount_heading',
			[
				'label' => esc_html__( 'Sticky Cart Count', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'sticky_cart_number_color',
            [
				'label'   => esc_html__('Cart Count Color', 'tp-elements'),
				'type'    => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}} .menu-cart-area span.icon-num' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sticky_cart_count_bg_color',
            [
                'label' => esc_html__('Count Bg Color', 'tp-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.tp-sticky {{WRAPPER}} .menu-cart-area span.icon-num' => 'background: {{VALUE}};',
                  

                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(){
        $settings = $this->get_settings_for_display();
		global $woocommerce;
		if ( class_exists( 'WooCommerce' ) ) {?>

			<style>
				.cart_flip.box-style:hover i {
					transform: rotateY(-180deg);
				}
				.menu-cart-area.cart_flip.box-style i {
					display: inline-block;
					transition: all 0.5s ease-in-out;
				}

				.cart_flip.box-style {
					overflow: hidden;
				}
				.box-style.cart_flip::before {
					content: "";
					position: absolute;
					top: var(--y);
					left: var(--x);
					transform: translate(-50%, -50%);
					width: 0;
					height: 0;
					border-radius: 100%;
					background-color: rgba(249,93,0, 1);
					transition: all .7s ease;
					z-index: 1;
				}
				.box-style.cart_flip:hover::before {
					width: 400%;
					height: 400%;
				}

			</style>

			<div class="menu-cart-area <?php if( $settings['cart_style'] == 'cart_flip' ) : ?> <?php echo esc_attr($settings['cart_style']);?> box-style <?php endif; ?>">
			<?php \Elementor\Icons_Manager::render_icon( $settings['cart_icon'], [ 'aria-hidden' => 'true' ] ); ?> 
			<?php if( $settings['cart_style'] == 'cart_flip' ) : ?> 
			<?php else : ?>
				<span class="icon-num"><?php echo is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : '';?></span>
			<?php endif; ?>
			
			</div>	
            		
		<?php } 
    	
    }   

}