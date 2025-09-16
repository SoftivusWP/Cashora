<?php
/**
 * Image widget class
 *
 */
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Image_Showcase_Widget extends \Elementor\Widget_Base {
    /**    
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'tp-image-showcase';
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
        return esc_html__( 'TP Image Showcase', 'tp-elements' );
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
        return 'glyph-icon flaticon-image';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'logo', 'clients', 'brand', 'parnter', 'image' ];
    }

    

	protected function register_controls() {
		$this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Image Settings', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        ); 

        $this->add_control(
            'first_image',
            [
                'label' => esc_html__( 'Choose Image', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::MEDIA,     
                'separator' => 'before',
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-image' => 'text-align: {{VALUE}}'
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_animation_reveal',
            [
                'label' => esc_html__( 'Image Reveal', 'tp-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        ); 


        $this->add_control(
            'image_animation_rotate',
            [
                'label' => esc_html__( 'Image Rotate', 'tp-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        ); 

        $this->add_control(
            'image_animation_scale',
            [
                'label' => esc_html__( 'Image Scale', 'tp-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        ); 

        $this->add_control(
            'image_animation',
            [
                'label' => esc_html__( 'Animation', 'tp-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_responsive_control(
            'tp_image_size',
            [

                'label' => esc_html__( 'Image Size', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size'=> '150',
				],
                'selectors' => [
					'{{WRAPPER}} img.pixelaxis-multi-image' => 'width: {{SIZE}}{{UNIT}};',
				],
                
            ]
        ); 
        

        $this->add_control(
            'images_translate',
            [
                'label'   => esc_html__( 'Translate Position', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'veritcal',
                'options' => [                  
                    'veritcal' => esc_html__( 'Veritcal', 'tp-elements'),
                    'horizontal' => esc_html__( 'Horizontal', 'tp-elements'),
                ],
                'condition' => [
                    'image_animation' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'rs_image_duration',
            [

                'label' => esc_html__( 'Animation Duration', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 20,
                   ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixelaxis-image.pixelaxis-multi-image' => 'animation-duration: {{SIZE}}s;',
                ],
                'condition' => [
                    'image_animation' => 'yes',
                ],
            ]
        ); 

        $this->add_responsive_control(
            'tp_image_animation_start_x',
            [

                'label' => esc_html__( 'Translate X Start', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 100,
                   ],
                ],
                'condition' => [
                    'image_animation' => 'yes',
                    'images_translate' => 'horizontal',
                ],
            ]
        );  

        $this->add_responsive_control(
            'tp_image_animation_end_x',
            [

                'label' => esc_html__( 'Translate X End', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                   'px' => [
                       'min' => -100,
                       'max' => 100,
                   ],
                ],
                'condition' => [
                    'image_animation' => 'yes',
                    'images_translate' => 'horizontal',
                ],
            ]
        ); 


        $this->add_responsive_control(
            'tp_image_animation_start_y',
            [

                'label' => esc_html__( 'Translate Y Start', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 100,
                   ],
                   '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'image_animation' => 'yes',
                    'images_translate' => 'veritcal',
                ],
            ]
        );  

        $this->add_responsive_control(
            'tp_image_animation_end_y',
            [

                'label' => esc_html__( 'Translate Y End', 'tp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                   'px' => [
                       'min' => -100,
                       'max' => 100,
                   ],
                   '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'image_animation' => 'yes',
                    'images_translate' => 'veritcal',
                ],
            ]
        );     
       

        $this->add_control(
		    'overlay_color',
		    [
		        'label' => esc_html__( 'Image Reveal Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .reveal-item .reveal-animation' => 'background: {{VALUE}} !important',
		        ],
		    ]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); 
        $image_rotate =  !empty($settings['image_animation_rotate']) ? 'image-rotate' : '';
        $image_scale =  !empty($settings['image_animation_scale']) ? 'image-scale' : '';
        ?>
        <?php if(!empty($settings['image_animation_reveal'])) {
           if(!empty($settings['first_image']['url'])) : ?>

           <div class="reveal-item overflow-hidden aos-init">
                <div class="reveal-animation reveal-end reveal-primary aos aos-init" data-aos="reveal-end"></div>
                <img class="pixelaxis-multi-image <?php echo esc_attr($settings['images_translate']); ?> " src="<?php echo esc_url($settings['first_image']['url']);?>" alt="image"/>
            </div>
            <?php endif;
        }else {
            ?>
                <div class="pixelaxis-image <?php echo esc_attr($settings['image_animation']); ?>">
                    <?php if(!empty($settings['first_image']['url'])) : ?>
                        <img class="pixelaxis-multi-image <?php echo esc_attr($settings['images_translate']); ?> <?php echo esc_attr($image_rotate);?> <?php echo esc_attr($image_scale);?>" src="<?php echo esc_url($settings['first_image']['url']);?>" alt="image"/>
                    <?php endif; ?>
                </div>
            <?php

        }?>
        
        <?php        
             if(!empty($settings['tp_image_animation_start_x']['size'])):
                $start   = $settings['tp_image_animation_start_x']['size'].$settings['tp_image_animation_start_x']['unit'];   
            endif; 

            if(!empty($settings['tp_image_animation_end_x']['size'])):         
            $end     = $settings['tp_image_animation_end_x']['size'].$settings['tp_image_animation_end_x']['unit'];  
            endif;

            if(!empty($settings['tp_image_animation_start_y']['size'])):          
            $start_y = $settings['tp_image_animation_start_y']['size'].$settings['tp_image_animation_start_y']['unit'];  
            endif; 

            if(!empty($settings['tp_image_animation_end_y']['size'])):          
            $end_y   = $settings['tp_image_animation_end_y']['size'].$settings['tp_image_animation_end_y']['unit'];
            endif; 
        ?>
       
    <?php
    }
}