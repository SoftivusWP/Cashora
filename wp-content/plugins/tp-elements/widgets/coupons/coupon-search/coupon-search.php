<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Themephi_Elementor_Coupon_Search_Widget extends \Elementor\Widget_Base {

	 
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
		return 'tp-coupon-search';
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
		return esc_html__( 'TP Coupon Search', 'tp-elements' );
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
			'section_coupon',
			[
				'label' => esc_html__( 'Coupons Global', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->add_control(
			'coupon_style',
			[
				'label'   => esc_html__( 'Select Coupon Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'tp-elements'),	
					'style2' => esc_html__( 'Style 2', 'tp-elements'),	
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
                    '{{WRAPPER}} .themephi-addon-coupons .coupons-part' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
            ]
        );
		
		$this->end_controls_section();	

		// STyle Start From Here
		$this->start_controls_section(
		    '_section_wrapper_style',
		    [
		        'label' => esc_html__( 'Search', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'item_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'item_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupn-search',
		    ]
		);

		$this->add_control(
		    'item_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'item_border',
		        'selector' => '{{WRAPPER}} .tp-coupn-search',
		    ]
		);

		$this->add_control(
		    'item_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'tp_item_border_color',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_title_style',
		    [
		        'label' => esc_html__( 'Search Category', 'tp-elements' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'category_typography',
		        'label' => esc_html__( 'Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .tp-coupon-category',
		    ]
		);

		$this->add_control(
		    'category_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		             '{{WRAPPER}} .tp-coupon-category' => 'color: {{VALUE}}',
		        ],
		    ]
		);	
		
		$this->add_responsive_control(
		    'category_width',
		    [
		        'label' => esc_html__( 'Max Width', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
		        'selectors' => [    
		            '{{WRAPPER}} .tp-coupon-category' => 'max-width: {{SIZE}}{{UNIT}};',		            
		        ],
		    ]
		);		
		

		$this->end_controls_section();


		
		$this->start_controls_section(
			'_section_style_desc',
		    [
			'label' => esc_html__( 'Input', 'tp-elements' ),
			'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'input_typography',
		        'label' => esc_html__( 'Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}} .tp-coupn-search-input',
		    ]
		);

		$this->add_control(
		    'input_color',
		    [
		        'label' => esc_html__( 'Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-input' => 'color: {{VALUE}} !important;',
		            
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'input_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'input_height',
		    [
		        'label' => esc_html__( 'Height', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
		        'selectors' => [    
		            '{{WRAPPER}} .tp-coupn-search-input' => 'height: {{SIZE}}{{UNIT}};',		            
		        ],
		    ]
		);		
		
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'input_border',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-input',
		    ]
		);

		$this->add_control(
		    'input_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'input_border_color_normal',
		    [
		        'label' => esc_html__( 'Border Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-input' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Submit Button', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
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
		            '{{WRAPPER}} .tp-coupn-search-btn' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-btn',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background_normal',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-coupn-search-btn',
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-btn',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-btn',
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
		            '{{WRAPPER}} .tp-coupn-search-btn:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'btn_hover_background',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-coupn-search-btn:hover',
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_hover_border',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-btn:hover',
		    ]
		);

		$this->add_control(
		    'button_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupn-search-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupn-search-btn:hover',
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
		$sstyle = $settings['coupon_style'];

		?>
		<div class="tp-coupon-search-wrapper tp-coupon-search-<?php echo esc_attr( $sstyle ); ?>">
			<?php
			if($sstyle){
				require plugin_dir_path(__FILE__)."/$sstyle.php";
			}else{
				require plugin_dir_path(__FILE__)."/style1.php";
			} ?>
		</div>
		<?php
	}
	public function getCategories(){
        $cat_list = [];
             if ( post_type_exists( 'coupon' ) ) { 
              $terms = get_terms( array(
                 'taxonomy'    => 'coupon-category',
                 'hide_empty'  => true            
             ) ); 
            foreach($terms as $post) {
                $cat_list[$post->slug]  = [$post->name];
            }
        }  
        return $cat_list;
    }

}