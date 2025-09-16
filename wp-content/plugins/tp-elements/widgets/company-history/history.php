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

class Pixelaxis_History_Showcase_Widget extends \Elementor\Widget_Base {
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
        return 'tp-history';
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
        return esc_html__( 'TP History', 'tp-elements' );
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

            <div class="goals-number-section-start pb--90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-mid-wrapper-home-two left">
                        <span class="pre">Our History Overview</span>
                        <h2 class="title">Our Goals In Numbers</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--20">

                <section class="h--timeline js-h--timeline">
                    <div class="h--timeline-container">
                        <div class="h--timeline-dates">
                            <div class="h--timeline-line">
                                <ol>
                                    <li><a href="javascript:void(0);" data-date="16/01/2014" class="h--timeline-date h--timeline-date--selected">2014</a></li>
                                    <li><a href="javascript:void(0);" data-date="28/02/2014" class="h--timeline-date">2013</a></li>
                                    <li><a href="javascript:void(0);" data-date="20/04/2014" class="h--timeline-date">2013</a></li>
                                    <li><a href="javascript:void(0);" data-date="20/05/2014" class="h--timeline-date">2012</a></li>
                                    <li><a href="javascript:void(0);" data-date="09/07/2014" class="h--timeline-date">2011</a></li>
                                    <li><a href="javascript:void(0);" data-date="30/08/2014" class="h--timeline-date">2007</a></li>
                                    <li><a href="javascript:void(0);" data-date="15/09/2014" class="h--timeline-date">2001</a></li>
                                    <li><a href="javascript:void(0);" data-date="01/11/2014" class="h--timeline-date">1997</a></li>
                                    <li><a href="javascript:void(0);" data-date="10/12/2014" class="h--timeline-date">1994</a></li>
                                    <li><a href="javascript:void(0);" data-date="19/01/2015" class="h--timeline-date">1991</a></li>
                                    <li><a href="javascript:void(0);" data-date="03/03/2015" class="h--timeline-date">1988</a></li>
                                </ol>

                                <span class="h--timeline-filling-line" aria-hidden="true"></span>
                            </div> <!-- .h-timeline-line -->
                        </div> <!-- .h-timeline-dates -->

                        <nav class="h--timeline-navigation-container">
                            <ul>
                                <li><a href="javascript:void(0);" class="text-replace h--timeline-navigation h--timeline-navigation--prev h--timeline-navigation--inactive">Prev</a></li>
                                <li><a href="javascript:void(0);" class="text-replace h--timeline-navigation h--timeline-navigation--next">Next</a></li>
                            </ul>
                        </nav>
                    </div> <!-- .h-timeline-container -->

                    <div class="h--timeline-events">
                        <ol>
                            <li class="h--timeline-event h--timeline-event--selected text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $25,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $50,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $20,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $22,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $13,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $52,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $15,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $33,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $78,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $36,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="h--timeline-event text-component">
                                <div class="h--timeline-event-content container">
                                    <div class="row mt--0">
                                        <div class="col-lg-6">
                                            <div class="content-goal-time">
                                                <p class="disc">
                                                    senectus tellus aliquet parturient montes quisque penatibus. Venenatis nascetur aliquet pellentesque mi lacus dictumst fringilla sagittis, porta pharetra at porttitor ligula nulla dapibus justo inceptos fusce primis pellentesque
                                                </p>
                                                <a href="#" class="tps-btn btn-seconday"> Explore More</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 class="title-goal-doller">
                                                $63,000
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div> <!-- .h-timeline-events -->
                </section>
            </div>
        </div>
    </div>                            

            <script>            
              var HorizontalTimeline = function(element) {
              this.element = element;
              this.datesContainer = this.element.getElementsByClassName('h--timeline-dates')[0];
              this.line = this.datesContainer.getElementsByClassName('h--timeline-line')[0]; // grey line in the top timeline section
              this.fillingLine = this.datesContainer.getElementsByClassName('h--timeline-filling-line')[0]; // green filling line in the top timeline section
              this.date = this.line.getElementsByClassName('h--timeline-date');
              this.selectedDate = this.line.getElementsByClassName('h--timeline-date--selected')[0];
              this.dateValues = parseDate(this);
              this.minLapse = calcMinLapse(this);
              this.navigation = this.element.getElementsByClassName('h--timeline-navigation');
              this.contentWrapper = this.element.getElementsByClassName('h--timeline-events')[0];
              this.content = this.contentWrapper.getElementsByClassName('h--timeline-event');
          
              this.eventsMinDistance = 60; // min distance between two consecutive events (in px)
              this.eventsMaxDistance = 255; // max distance between two consecutive events (in px)
              this.translate = 0; // this will be used to store the translate value of this.line
              this.lineLength = 0; //total length of this.line
          
              // store index of selected and previous selected dates
              this.oldDateIndex = Util.getIndexInArray(this.date, this.selectedDate);
              this.newDateIndex = this.oldDateIndex;
          
              initTimeline(this);
              initEvents(this);
            };
          
            function initTimeline(timeline) {
              // set dates left position
              var left = 0;
              for (var i = 0; i < timeline.dateValues.length; i++) {
                var j = (i == 0) ? 0 : i - 1;
                var distance = daydiff(timeline.dateValues[j], timeline.dateValues[i]),
                  distanceNorm = (Math.round(distance/timeline.minLapse) + 2)*timeline.eventsMinDistance,
                containerWidth = timeline.datesContainer.offsetWidth,
                distanceCorrecture = 0;
          
                if(distanceNorm < timeline.eventsMinDistance) {
                  distanceNorm = timeline.eventsMinDistance;
                } else if(distanceNorm > timeline.eventsMaxDistance) {
                  distanceNorm = timeline.eventsMaxDistance;
                }
                left = left + distanceNorm;
                timeline.date[i].setAttribute('style', 'left:' + left+'px');
              }
          
              // set line/filling line dimensions
              timeline.line.style.width = (left + timeline.eventsMinDistance)+distanceCorrecture+'px';
              timeline.lineLength = left + timeline.eventsMinDistance+distanceCorrecture;
              
              // add 100px more to line/filling line if container bigger then timeline lineLength
              if(containerWidth > timeline.lineLength) {
                timeline.line.style.width = (left + timeline.eventsMinDistance)+distanceCorrecture+'px';
                timeline.lineLength = timeline.lineLength + distanceCorrecture;
              }
              
              // reveal timeline
              Util.addClass(timeline.element, 'h--timeline--loaded');
              selectNewDate(timeline, timeline.selectedDate);
              resetTimelinePosition(timeline, 'next');
            };
          
            function initEvents(timeline) {
              var self = timeline;
              // deaktivate the buttons
              deaktivateNavigationButtons(self);
              
              // click on arrow navigation
              self.navigation[0].addEventListener('click', function(event){
                event.preventDefault();
                translateTimeline(self, 'prev');
                deaktivateNavigationButtons(self);
              });
              self.navigation[1].addEventListener('click', function(event){
                event.preventDefault();
                translateTimeline(self, 'next');
                deaktivateNavigationButtons(self);
              });
          
              //swipe on timeline
              new SwipeContent(self.datesContainer);
              self.datesContainer.addEventListener('swipeLeft', function(event){
                translateTimeline(self, 'next');
              });
              self.datesContainer.addEventListener('swipeRight', function(event){
                translateTimeline(self, 'prev');
              }); 
          
              //select a new event
              for(var i = 0; i < self.date.length; i++) {
                (function(i){
                  self.date[i].addEventListener('click', function(event){
                    event.preventDefault();
                    selectNewDate(self, event.target);
                  });
          
                  self.content[i].addEventListener('animationend', function(event){
                    if( i == self.newDateIndex && self.newDateIndex != self.oldDateIndex) resetAnimation(self);
                  });
                })(i);
              }
            };
          
            function updateFilling(timeline) { // update fillingLine scale value
              var dateStyle = window.getComputedStyle(timeline.selectedDate, null),
                left = dateStyle.getPropertyValue("left"),
                width = dateStyle.getPropertyValue("width");
          
              left = Number(left.replace('px', '')) + Number(width.replace('px', ''))/2;
              timeline.fillingLine.style.transform = 'scaleX('+(left/timeline.lineLength)+')';
            };
          
            function translateTimeline(timeline, direction) { // translate timeline (and date elements)
              var containerWidth = timeline.datesContainer.offsetWidth;
              if(direction) {
                timeline.translate = (direction == 'next') ? timeline.translate - containerWidth + timeline.eventsMinDistance : timeline.translate + containerWidth - timeline.eventsMinDistance;
              }
              if( 0 - timeline.translate > timeline.lineLength - containerWidth ) timeline.translate = containerWidth - timeline.lineLength;
              if( timeline.translate > 0 ) timeline.translate = 0;
          
              timeline.line.style.transform = 'translateX('+timeline.translate+'px)';
              // update the navigation items status (toggle inactive class)
              (timeline.translate == 0 ) ? Util.addClass(timeline.navigation[0], 'h--timeline-navigation--inactive') : Util.removeClass(timeline.navigation[0], 'h--timeline-navigation--inactive');
              (timeline.translate == containerWidth - timeline.lineLength ) ? Util.addClass(timeline.navigation[1], 'h--timeline-navigation--inactive') : Util.removeClass(timeline.navigation[1], 'h--timeline-navigation--inactive');
            };
            
            function deaktivateNavigationButtons(timeline) {
              var containerWidth = timeline.datesContainer.offsetWidth;
              // deaktivate next button if container bigger then timeline lineLength
              if(containerWidth >= timeline.lineLength) {
                Util.addClass(timeline.navigation[0], 'h--timeline-navigation--inactive');
                Util.addClass(timeline.navigation[1], 'h--timeline-navigation--inactive');
              }
            };
          
            function selectNewDate(timeline, target) { // ned date has been selected -> update timeline
              timeline.newDateIndex = Util.getIndexInArray(timeline.date, target);
              timeline.oldDateIndex = Util.getIndexInArray(timeline.date, timeline.selectedDate);
              Util.removeClass(timeline.selectedDate, 'h--timeline-date--selected');
              Util.addClass(timeline.date[timeline.newDateIndex], 'h--timeline-date--selected');
              timeline.selectedDate = timeline.date[timeline.newDateIndex];
              updateOlderEvents(timeline);
              updateVisibleContent(timeline);
              updateFilling(timeline);
            };
          
            function updateOlderEvents(timeline) { // update older events style
              for(var i = 0; i < timeline.date.length; i++) {
                (i < timeline.newDateIndex) ? Util.addClass(timeline.date[i], 'h--timeline-date--older-event') : Util.removeClass(timeline.date[i], 'h--timeline-date--older-event');
              }
            };
          
            function updateVisibleContent(timeline) { // show content of new selected date
              if (timeline.newDateIndex > timeline.oldDateIndex) {
                var classEntering = 'h--timeline-event--selected h--timeline-event--enter-right',
                  classLeaving = 'h--timeline-event--leave-left';
              } else if(timeline.newDateIndex < timeline.oldDateIndex) {
                var classEntering = 'h--timeline-event--selected h--timeline-event--enter-left',
                  classLeaving = 'h--timeline-event--leave-right';
              } else {
                var classEntering = 'h--timeline-event--selected',
                  classLeaving = '';
              }
          
              Util.addClass(timeline.content[timeline.newDateIndex], classEntering);
              if (timeline.newDateIndex != timeline.oldDateIndex) {
                Util.removeClass(timeline.content[timeline.oldDateIndex], 'h--timeline-event--selected');
                Util.addClass(timeline.content[timeline.oldDateIndex], classLeaving);
                //timeline.contentWrapper.style.height = timeline.content[timeline.newDateIndex].offsetHeight + 'px';
              }
            };
          
            function resetAnimation(timeline) { // reset content classes when entering animation is over
              //timeline.contentWrapper.style.height = null;
              Util.removeClass(timeline.content[timeline.newDateIndex], 'h--timeline-event--enter-right h--timeline-event--enter-left');
              Util.removeClass(timeline.content[timeline.oldDateIndex], 'h--timeline-event--leave-right h--timeline-event--leave-left');
            };
          
            function keyNavigateTimeline(timeline, direction) { // navigate the timeline using the keyboard
              var newIndex = (direction == 'next') ? timeline.newDateIndex + 1 : timeline.newDateIndex - 1;
              if(newIndex < 0 || newIndex >= timeline.date.length) return;
              selectNewDate(timeline, timeline.date[newIndex]);
              resetTimelinePosition(timeline, direction);
            };
          
            function resetTimelinePosition(timeline, direction) { //translate timeline according to new selected event position
              var eventStyle = window.getComputedStyle(timeline.selectedDate, null),
                eventLeft = Number(eventStyle.getPropertyValue('left').replace('px', '')),
                timelineWidth = timeline.datesContainer.offsetWidth;
          
              if( (direction == 'next' && eventLeft >= timelineWidth - timeline.translate) || (direction == 'prev' && eventLeft <= - timeline.translate) ) {
                timeline.translate = timelineWidth/2 - eventLeft;
                translateTimeline(timeline, false);
              }
            };
          
            function parseDate(timeline) { // get timestamp value for each date
              var dateArrays = [];
              for(var i = 0; i < timeline.date.length; i++) {
                var singleDate = timeline.date[i].getAttribute('data-date'),
                  dateComp = singleDate.split('T');
          
                if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
                  var dayComp = dateComp[0].split('/'),
                    timeComp = dateComp[1].split(':');
                } else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
                  var dayComp = ["2000", "0", "0"],
                    timeComp = dateComp[0].split(':');
                } else { //only DD/MM/YEAR
                  var dayComp = dateComp[0].split('/'),
                    timeComp = ["0", "0"];
                }
                var	newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
                dateArrays.push(newDate);
              }
              return dateArrays;
            };
          
            function calcMinLapse(timeline) { // determine the minimum distance among events
              var dateDistances = [];
              for(var i = 1; i < timeline.dateValues.length; i++) {
                var distance = daydiff(timeline.dateValues[i-1], timeline.dateValues[i]);
                if(distance > 0) dateDistances.push(distance);
              }
          
              return (dateDistances.length > 0 ) ? Math.min.apply(null, dateDistances) : 86400000;
            };
          
            function daydiff(first, second) { // time distance between events
              return Math.round((second-first));
            };
          
            window.HorizontalTimeline = HorizontalTimeline;
          
            var horizontalTimeline = document.getElementsByClassName('js-h--timeline'),
              horizontalTimelineTimelineArray = [];
            if(horizontalTimeline.length > 0) {
              for(var i = 0; i < horizontalTimeline.length; i++) {
                horizontalTimelineTimelineArray.push(new HorizontalTimeline(horizontalTimeline[i]));
              }
              // navigate the timeline when inside the viewport using the keyboard
              document.addEventListener('keydown', function(event){
                if( (event.keyCode && event.keyCode == 39) || ( event.key && event.key.toLowerCase() == 'arrowright') ) {
                  updateHorizontalTimeline('next'); // move to next event
                } else if((event.keyCode && event.keyCode == 37) || ( event.key && event.key.toLowerCase() == 'arrowleft')) {
                  updateHorizontalTimeline('prev'); // move to prev event
                }
              });
            };
          
            function updateHorizontalTimeline(direction) {
              for(var i = 0; i < horizontalTimelineTimelineArray.length; i++) {
                if(elementInViewport(horizontalTimeline[i])) keyNavigateTimeline(horizontalTimelineTimelineArray[i], direction);
              }
            };
          
            /*
              How to tell if a DOM element is visible in the current viewport?
              http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
            */
            function elementInViewport(el) {
              var top = el.offsetTop;
              var left = el.offsetLeft;
              var width = el.offsetWidth;
              var height = el.offsetHeight;
          
              while(el.offsetParent) {
                  el = el.offsetParent;
                  top += el.offsetTop;
                  left += el.offsetLeft;
              }
          
              return (
                  top < (window.pageYOffset + window.innerHeight) &&
                  left < (window.pageXOffset + window.innerWidth) &&
                  (top + height) > window.pageYOffset &&
                  (left + width) > window.pageXOffset
              );
            }
        
            </script>
           
        <?php

    }
}