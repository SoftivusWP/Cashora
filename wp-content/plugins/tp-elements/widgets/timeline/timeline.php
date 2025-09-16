<?php
/**
 * Logo widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Timeline_Showcase_Widget extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * Retrieve logo widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'tp-timeline';
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
        return esc_html__( 'TP Timeline', 'tp-elements' );
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
        return 'eicon-gallery-grid';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'timeline', 'time', 'company', 'history'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Timeline Item', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'tp-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'year',
            [
                'label'       => esc_html__( 'Year', 'tp-elements' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Year',
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'tp-elements' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Title',
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label'       => esc_html__( 'Text', 'tp-elements' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => 'Text',
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label'       => esc_html__( 'Icon', 'tp-elements' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,                
                'separator'   => 'before',
            ]
        );


        $this->add_control(
            'items_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                ]
            ]
        );  

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

		$this->add_control(
			'show_image_in_left',
			[
				'label' => esc_html__( 'Show Image In Left', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Left', 'tp-elements' ),
				'label_off' => esc_html__( 'Right', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'content__alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Top', 'tp-elements' ),
						'icon' => 'eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'tp-elements' ),
						'icon' => 'eicon-align-center-v',
					],
					'end' => [
						'title' => esc_html__( 'Bottom', 'tp-elements' ),
						'icon' => 'eicon-align-end-v',
					],
				],
				'default' => 'start',
				'toggle' => true,
			]
		);


        $this->end_controls_section();

        $this->start_controls_section(
            'timeline_section_style',
            [
                'label' => esc_html__( 'Style', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'year_options',
			[
				'label' => esc_html__( 'Year', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'year__color',
			[
				'label' => esc_html__( 'Year Color', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .journey-list li .timeline-box .left-content h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tptimeline .draw-line' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'year__typography',
				// 'selector' => '{{WRAPPER}} .journey-list li.in-view .timeline-box .left-content h2',
                'selector' => '{{WRAPPER}} .journey-list li .timeline-box .left-content h2',
			]
		);

		$this->add_control(
			'title_options',
			[
				'label' => esc_html__( 'Title', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title__color',
			[
				'label' => esc_html__( 'Title Color', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .back-timeline.our-journey-area h4' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title__typography',
				'selector' => '{{WRAPPER}} .back-timeline.our-journey-area h4',
			]
		);

		$this->add_control(
			'text__options',
			[
				'label' => esc_html__( 'Text', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'text___color',
			[
				'label' => esc_html__( 'Text Color', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .journey-list li .timeline-box .left-content p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text__typography',
				'selector' => '{{WRAPPER}} .journey-list li .timeline-box .left-content p',
			]
		);


    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( empty($settings['items_list'] ) ) {
            return;
        }
        $img_left = $settings['show_image_in_left'];
        $c_alignment = $settings['content__alignment'];

        $order2 = $img_left == 'yes' ? ' order-2' : '';
        $align_items = !empty($c_alignment) ? ' align-items-'.$c_alignment : '';

        ?>

            <div class="tps-company-storyhear"> 
              

                    <section class="timeline">
                    <ul>
                    <?php foreach ( $settings['items_list'] as $index => $item ) :
                        $image = wp_get_attachment_image_url( $item['image']['id'], $settings['thumbnail_size'] );
                        
                        

                        $year   = !empty($item['year']) ? $item['year'] : '';                         
                        $title   = !empty($item['title']) ? $item['title'] : '';                         
                        $text   = !empty($item['text']) ? $item['text'] : '';                         

                        ?>
                        <li class="item">
                            <div>
                                <section>
                                    <?php if(!empty($image)) : ?>
                                        <img src="<?php echo esc_url( $image ); ?>" alt="image">
                                    <?php endif ; ?>
                                    <?php if(!empty($item['icon'])) : ?>
							            <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						            <?php endif; ?>
                                    <span class="time"><?php echo esc_html($year);?></span>
                                    <h6 class="title"><?php echo esc_html($title);?></h6>
                                    <p><?php echo esc_html($text);?></p>
                                </section>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </div>
            <script>
                var items = document.querySelectorAll(".timeline li");          
            
                function isElementInViewport(el) {
                    var rect = el.getBoundingClientRect();
                    return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    );
                }
                
                function callbackFunc() {
                    for (var i = 0; i < items.length; i++) {
                    if (isElementInViewport(items[i])) {
                        items[i].classList.add("in-view");
                    }
                    }
                }
                
                // listen for events
                window.addEventListener("load", callbackFunc);
                window.addEventListener("resize", callbackFunc);
                window.addEventListener("scroll", callbackFunc);
            </script>
           
        <?php

    }
}