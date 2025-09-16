<?php
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined( 'ABSPATH' ) || die();
class Pixelaxis_Widget_Accordion extends \Elementor\Widget_Base {
  
    public function get_name() {
        return 'tp-custom-accordions';
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
        return esc_html__( 'TP Accordion', 'tp-elements' );
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
        return 'eicon-accordion';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'Accordion' ];
    } 

    protected function register_controls() {
        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Item', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

    

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Item Title', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Title', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Item Description', 'tp-elements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Description', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'logo_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                
            ]
        ); 

        $this->add_control(
			'accordion_icon',
			[
				'label' => esc_html__( 'Accordion Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-up',
					'library' => 'solid',
				],			
				'separator' => 'before',			
			]
		);

        $this->add_control(
			'accordion_active_icon',
			[
				'label' => esc_html__( 'Accordion Active Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-down',
					'library' => 'solid',
				],			
				'separator' => 'before',			
			]
		);
        $this->add_control(
            'accordion_style',
            [
                'label'   => esc_html__( 'Select Style', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',               
                'options' => [                    
                    'style1' => 'Style 1',
                    'style2' => 'Style 2',                                
                    'style3' => 'Style 3',                              
                ],                                          
            ]
        );

        $this->add_control(
            'show_title_count',
            [
                'label' => esc_html__( 'Show Title Count', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-elements' ),
                'label_off' => esc_html__( 'Hide', 'tp-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
       

       $this->end_controls_section();

       $this->start_controls_section(
            '_accordion_style',
            [
                'label' => esc_html__( 'Accordion Style', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'_accordion_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            '_accordion_item_color_bg',
            [
                'label' => esc_html__( 'Item Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header button' => 'background: {{VALUE}} !important',
                ],  
                'separator'   => 'before',              
            ]
        );
        $this->add_control(
            '_accordion_item_active_color_bg',
            [
                'label' => esc_html__( 'Active Item Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header .tp-accordion-button:not(.collapsed)' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header .tp-accordion-button:not(.collapsed)' => 'background: {{VALUE}} !important',
                ],  
                'separator'   => 'before',              
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => '_accordion_item_border',
				'selector' => '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item',
			]
		);

        $this->add_control(
		    '_accordion_item_border_radius',
		    [
		        'label' => esc_html__( 'Item Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
		        ],
		    ]
		);

       $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header button' => 'color: {{VALUE}} !important',
                ],    
                'separator'   => 'before',            
            ]
        );

        $this->add_control(
            'title_color_bg',
            [
                'label' => esc_html__( 'Title Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header button' => 'background: {{VALUE}} !important',
                ],  
                'separator'   => 'before',              
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button',
			]
		);

        $this->add_control(
			'title_height',
			[
				'label' => esc_html__( 'Height', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'title_color_active',
            [
                'label' => esc_html__( 'Active Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button[aria-expanded=true]' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header button[aria-expanded=true]' => 'color: {{VALUE}} !important',
                ],   
                'separator'   => 'before',                 
            ]
        );
        $this->add_control(
            'title_color_active_bg',
            [
                'label' => esc_html__( 'Active Title BG Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button[aria-expanded=true]' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-header button[aria-expanded=true]' => 'background: {{VALUE}} !important',
                ],   
                'separator'   => 'before',                 
            ]
        );      

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title__typography',
				'selector' => '{{WRAPPER}} .accordion .catp-button-tp',
                'selector' => '{{WRAPPER}} .tps-accordion .tp-accordion-item .tp-accordion-button',
			]
		);


       $this->add_control(
            'title_number_color',
            [
                'label' => esc_html__( 'Title Number Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button span' => 'color: {{VALUE}} !important',
                    
                ],
            ]
        );

        $this->add_control(
            'title_icon_color',
            [
                'label' => esc_html__( 'Title Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button:after' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button span i' => 'color: {{VALUE}} !important',                    
                ],
            ]
        );

        $this->add_control(
            'title_active_icon_color',
            [
                'label' => esc_html__( 'Active Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button:before' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header .accordion-icon-active i' => 'color: {{VALUE}} !important',                    
                ],
            ]
        );

        $this->add_control(
            'title_icon_bg_color',
            [
                'label' => esc_html__( 'Icon Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button .accordion-icon i' => 'background: {{VALUE}} !important',              
                ],
            ]
        );
        
        $this->add_control(
            'title_icon_active_bg_color',
            [
                'label' => esc_html__( 'Icon Active Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button:before' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header .accordion-icon-active i' => 'background: {{VALUE}} !important',                    
                ],
            ]
        );

        $this->add_control(
			'title_icon_position',
			[
				'label' => esc_html__( 'Icon Position Right to Left', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
                
				'selectors' => [
					'{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button .accordion-icon' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-header button .accordion-icon-active' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);


        $this->add_control(
            'desc__color',
            [
                'label' => esc_html__( 'Desccription Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion .card-body' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-body' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-body' => 'color: {{VALUE}} !important',
                ],   
                'separator'   => 'before',                 
            ]
        );

        $this->add_control(
            'desc___bg_color',
            [
                'label' => esc_html__( 'Desccription Bg Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion .card-body' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-body' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .tps-accordion.style3 .tp-accordion-item .tp-accordion-body' => 'background: {{VALUE}} !important',
                ],   
                'separator'   => 'before',                 
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc__typography',
				'selector' => '{{WRAPPER}} .accordion .card-body',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'desc__border',
				'selector' => '{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-body',
			]
		);
        
        $this->add_control(
			'desc__padding',
			[
				'label' => esc_html__( 'Padding', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tps-accordion.style2 .tp-accordion-item .tp-accordion-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

       $this->end_controls_section();

   }
    protected function render() {    	
        $settings = $this->get_settings_for_display();
        $unique = rand(2012,35120);
        ?>
        <div class="tps-accordion <?php echo $settings['accordion_style'];?>" id="accordionExample<?php echo $unique;?>">
            <?php $x = 0; 
            foreach ( $settings['logo_list'] as $index => $item ) :
                $title = !empty($item['name']) ? $item['name'] : '';
                $description = !empty($item['description']) ? $item['description'] : '';
             $x++;
         
            if($x== 1){
                $collapse  = '';
                $show = 'show';
                $true = 'true';
            }
            else{
                $collapse  = 'collapsed';
                $show = '';
                $true = 'false';
            }
           
            $dataUnique = $unique . $x;
           
            if( $settings['accordion_style'] == 'style1'): ?>                                
         
                <div class="tp-accordion-item">
                        <div class="tp-accordion-header" id="heading-<?php echo $dataUnique;?>">
                            <button class="tp-accordion-button w-100 <?php echo $collapse;?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $dataUnique;?>" aria-expanded="<?php echo $true;?>" aria-controls="collapse<?php echo $dataUnique;?>">
                            <?php echo wp_kses_post ($title);?> 
                            </button>
                        </div>
                        <div id="collapse<?php echo $dataUnique;?>" class="accordion-collapse collapse <?php echo $show;?>" aria-labelledby="heading<?php echo $dataUnique;?>" data-bs-parent="#accordionExample<?php echo $unique;?>">
                            <div class="tp-accordion-body">
                            <?php echo esc_attr ($description);?>
                            </div>
                        </div>
                </div>
            <?php else : ?>
                <div class="tp-accordion-item">
                        <div class="tp-accordion-header" id="heading-<?php echo $dataUnique;?>">
                            <button class="tp-accordion-button w-100 <?php echo $collapse;?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $dataUnique;?>" aria-expanded="<?php echo $true;?>" aria-controls="collapse<?php echo $dataUnique;?>">
                            
                                <?php if($settings['show_title_count']) :?><span><?php echo '0'.$x.'.';?></span><?php endif;?> 
                                    <?php echo wp_kses_post ($title);?> <span class="accordion-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['accordion_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                    <span class="accordion-icon-active"> <?php \Elementor\Icons_Manager::render_icon( $settings['accordion_active_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                            </button>
                        </div>
                        <div id="collapse<?php echo $dataUnique;?>" class="accordion-collapse collapse <?php echo $show;?>" aria-labelledby="heading<?php echo $dataUnique;?>" data-bs-parent="#accordionExample<?php echo $unique;?>">
                            <div class="tp-accordion-body">
                            <?php echo esc_attr ($description);?>
                            </div>
                        </div>
                </div>
            <?php    

            endif;
                endforeach; ?>                  
                  
            </div>            
        <?php
    }
} ?>