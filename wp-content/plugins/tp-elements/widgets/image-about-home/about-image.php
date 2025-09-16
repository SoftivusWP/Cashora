<?php
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_About_Image_Widget extends \Elementor\Widget_Base {

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
		return 'tp-about-image';
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
		return esc_html__( 'TP About Image', 'tp-elements' );
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
		return 'glyph-icon flaticon-letter';
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
				'label' => esc_html__( 'About Image', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rt_about__style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',				
				'options' => [
					'style1' => esc_html__( 'Factory About', 'tp-elements' ),
					'style2' => esc_html__( 'Handyman About', 'tp-elements' ),
					'style3' => esc_html__( 'Industrial About', 'tp-elements' )
				],											
			]
		);



		$this->add_control(
			'main_image',
			[
				'label' => esc_html__( 'Main Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				'separator' => 'before',
				'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]

			]
		);

		$this->add_control(
			'animate_image',
			[
				'label' => esc_html__( 'Animate Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				'separator' => 'before',
				'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]

			]
		);

		$this->add_control(
			'year',
			[
				'label' => esc_html__( 'Experience Year', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '25+', 'tp-elements' ),				
				'separator' => 'before',
				'condition' => [
		            'rt_about__style' => ['style1']
		        ]
			]
		);
		$this->add_control(
			'year_text',
			[
				'label' => esc_html__( 'Experience Year Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Years', 'tp-elements' ),				
				'separator' => 'before',
				'condition' => [
		            'rt_about__style' => ['style1', 'style2', 'style3']
		        ]
			]
		);


		$this->add_control(
			'content',
			[
				'label'   => esc_html__( 'Year Content', 'tp-elements' ),
				'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Of experience in consulting service

                ', 'tp-elements' ),	
				'rows'    => 10,			
			]
		);


		$this->add_responsive_control(
            'content_align',
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
                    '{{WRAPPER}}  .description' => 'justify-content: {{VALUE}}'
				],
				'condition' => [
		            'rt_about__style' => ['style1']
		        ]
            ]
        );
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Quote Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}}  .description p',
				'condition' => [
		            'rt_about__style' => ['style1']
		        ]
			]
		);

		$this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Quote Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}}  .description' => 'color: {{VALUE}};',
                    '{{WRAPPER}}  .description p' => 'color: {{VALUE}};',
                    '{{WRAPPER}}  .description p a' => 'color: {{VALUE}};',
                ],  
				'condition' => [
		            'rt_about__style' => ['style1']
		        ]              
            ]
        ); 

        $this->add_responsive_control(
            'desc_margin',
            [
                'label' => esc_html__( 'Quote Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}  .description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
		            'rt_about__style' => ['style1']
		        ]
            ]
        ); 

		$this->add_control(
            '_heading_about_animate',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'About Animate Style', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        );
	
        $this->add_responsive_control(
            'aobut_animate_position',
            [
                'label' => esc_html__( 'Left to Right Position', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        );

		$this->add_responsive_control(
            'exp_year_animate_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}  .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        ); 


		$this->add_control(
            '_about_ex_text',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Experience Text', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exp_year_text_typo',
				'label' => esc_html__( 'Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}}  .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area p',
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
			]
		);

		
		$this->add_control(
            'exp_year_text_color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area p' => 'color: {{VALUE}};',
                ],  
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]              
            ]
        ); 

		
		$this->add_responsive_control(
            'exp_year_text_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}  .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        ); 

		$this->add_responsive_control(
            'exp_year_text_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}  .tp-elevate-about-warp.style2 .thumbnail-about-eight .experience-area p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
		            'rt_about__style' => ['style2']
		        ]
            ]
        ); 
		
		
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
		$settings = $this->get_settings_for_display(); 
		?>
		
		<div class="tp-elevate-about-warp <?php echo esc_attr($settings['rt_about__style']); ?>">
			<?php
				if( $settings['rt_about__style'] == 'style1' ) {
					include(plugin_dir_path(__FILE__)."/style1.php");
				}if( $settings['rt_about__style'] == 'style2' ) {
					include(plugin_dir_path(__FILE__)."/style2.php");
				}if( $settings['rt_about__style'] == 'style3' ) {
					include(plugin_dir_path(__FILE__)."/style3.php");
				}				
			?>
			
		</div>
		
	<?php 
	}
}?>