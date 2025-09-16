<?php
/**
 * Elementor Buisness Hour Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Experience_Widget extends \Elementor\Widget_Base {

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
		return 'tp-experience';
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
		return esc_html__( 'TP Experience', 'tp-elements' );
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
		return 'glyph-icon flaticon-24-hours';
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
        return [ 'tpaddon_category' ];
    }

	protected function register_controls() {


		$this->start_controls_section(
			'tps_section_title',
			[
				'label' => esc_html__( 'Content', 'tp-elements' ),
			]
		);

		$this->add_control(
			'ex_style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Style 1',
					'2' => 'Style 2',
				],											
			]
		);

		$this->add_control(
			'experience_text',
			[
				'label' => esc_html__( 'Title', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Year Experience * Year Experience *', 'tp-elements' ),
				'placeholder' => esc_html__( 'Type Experience Text here', 'tp-elements' ),
			]
		);

		$this->add_control(
			'experience_year',
			[
				'label' => esc_html__( 'Experience Year', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '25+', 'tp-elements' ),
				'placeholder' => esc_html__( 'Type Experience Year here', 'tp-elements' ),
				'condition' => [
					'ex_style' => ['1'],
				],
			]
		);

       $this->end_controls_section();


		$this->start_controls_section(
			'experience_style',
			[
				'label' => esc_html__( 'Text', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ex_text_color',
			[
				'label' => esc_html__( 'Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-text' => 'color: {{VALUE}};',
				],
				'separator' => 'before',				
			]
		);

		$this->add_control(
			'ex_text_background',
			[
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-text-wrapper' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ex_text_typography',
				'selector' => '{{WRAPPER}} .tp-el-text',
			]
		);

		
		$this->add_responsive_control(
			'ex_text_padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-el-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'ex_text_margin',
			[
				'label' => esc_html__( 'Margin', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-el-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'ex_text_border',
    	        'selector' => '{{WRAPPER}} .tp-el-text',
    	    ]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'ex_number_style',
			[
				'label' => esc_html__( 'Number/Icon', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ex_number_color',
			[
				'label' => esc_html__( 'Color', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-number' => 'color: {{VALUE}};',
				],
				'separator' => 'before',				
			]
		);

		$this->add_control(
			'ex_number_background',
			[
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-number-wrapper::before' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ex_number_typography',
				'selector' => '{{WRAPPER}} .tp-el-number',
			]
		);

		
		$this->add_responsive_control(
			'ex_number_padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-el-number-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'ex_number_margin',
			[
				'label' => esc_html__( 'Margin', 'tp-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-el-number-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'ex_number_border',
    	        'selector' => '{{WRAPPER}} .tp-el-number-wrapper',
    	    ]
		);

		$this->end_controls_section();

	}

	/**
	 * Render accordion widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<?php 	
		if('1' == $settings['ex_style']){
			include plugin_dir_path(__FILE__)."/style1.php";
		} 
		if('2' == $settings['ex_style']){
			include plugin_dir_path(__FILE__)."/style2.php";
		}
		?>

		<script type="text/javascript"> 
        jQuery(document).ready(function(){   

			// Circle Text
			const texts = document.querySelectorAll(".circle-text.first p");
			const text2 = document.querySelectorAll(".circle-text.second p");
			texts.forEach((text) => {
			text.innerHTML = text.innerText.split('').map((char, i) =>
				`<span style="transform:rotate(${i * 10}deg)">${char}</span>`
			).join('');
			});
			text2.forEach((text2) => {
			text2.innerHTML = text2.innerText.split('').map((char, i) =>
				`<span style="transform:rotate(${i * 6}deg)">${char}</span>`
			).join('');
			});

		});
		</script>

		<?php		
	}
}