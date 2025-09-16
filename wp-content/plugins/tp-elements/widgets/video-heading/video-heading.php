<?php
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;
use Elementor\Control_Media;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Video_Heading_Widget extends \Elementor\Widget_Base {

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
		return 'tp-video-heading';
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
		return esc_html__( 'TP Video Heading', 'tp-elements' );
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
		return 'glyph-icon flaticon-error';
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
		return [ 'video' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_cta',
			[
				'label' => esc_html__( 'Video Heading', 'tp-elements' ),
			]
		);				

		$this->add_control(
			'video_bg_image',
			[
				'label' => esc_html__( 'Video BG Image', 'tp-elements' ),
				'type'  => Controls_Manager::MEDIA,				
				'separator' => 'before',
				'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],

			]
		);

		$this->add_control(
			'heading_video',
			[
				'label' => esc_html__( 'Choose Video', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => [ 'video' ],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    '_section_style_heading',
		    [
		        'label' => esc_html__( 'Heading', 'tp-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
            'heading_position',
            [
                'label' => esc_html__( 'Align Items', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
		        'default' => '',
		        'options' => [
		            'center' => esc_html__( 'Center', 'tp-elements' ),
                    'start' => esc_html__( 'Start', 'tp-elements' ),
                    'baseline' => esc_html__( 'Baseline', 'tp-elements' ),
                    'unset' => esc_html__( 'Unset', 'tp-elements' ),
		        ],
                'selectors' => [
                    '{{WRAPPER}} .tp-heading-video-area' => 'align-items: {{VALUE}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'cta_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-heading-video-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cta_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-heading-video-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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

        ?>

		<style>
		<?php if( $settings['video_bg_image']['url'] ) : ?>
		.tp-heading-video-area video {
			width: 100%;
			-webkit-mask-image: url(<?php echo esc_attr( $settings['video_bg_image']['url'] ); ?>);
			mask-image: url(<?php echo esc_attr( $settings['video_bg_image']['url'] ); ?>);
			-webkit-mask-size: 100% 100%;
			mask-size: 100% 100%;
			aspect-ratio: 100/40;
			height: 100%;
			-o-object-fit: cover;
			object-fit: cover;
		}
		<?php endif; ?>

		</style>
			<?php if( !empty( $settings['heading_video']['url'] ) ) : ?>
			<div class="tp-heading-video-area position-relative">
				<video src="<?php echo esc_url( $settings['heading_video']['url'] ); ?>" autoplay="" loop=""></video>
			</div>
			<?php endif; ?>
	<?php 
	}
}