<?php
/**
 * Logo widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\register_controls;

defined( 'ABSPATH' ) || die();
class Pixelaxis_Elementor_Project_Custom_Widget  extends \Elementor\Widget_Base {
  
    /**
     * Get widget name.
     *   
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'tp-project-custom-widget';
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
        return esc_html__( 'TP Custom Widget', 'tp-elements' );
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
        return [ 'slider' ];
    }
    protected function register_controls() {

        $this->start_controls_section(
            'project_custom_section',
            [
                'label' => esc_html__( 'Project Content', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'project_grid_source',
			[
				'label'   => esc_html__( 'Select Project Type', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',				
				'options' => [
					'custom' => esc_html__('Custom', 'tp-elements'),
					'dynamic' => esc_html__('Dynamic', 'tp-elements')					
				],											
			]
		);

        $this->add_control(
            'tp_project_style',
            [
                'label'   => esc_html__( 'Select Style', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [					
                    'style1' => esc_html__( 'Style 1', 'tp-elements'),
                    'style2' => esc_html__( 'Style 2', 'tp-elements'),
                    'style3' => esc_html__( 'Style 3', 'tp-elements'),
                    'style4' => esc_html__( 'Style 4', 'tp-elements'),
                    'style5' => esc_html__( 'Style 5', 'tp-elements'),
                ],
            ]
        ); 
        $this->add_control(
			'image_position',
			[
				'label' => esc_html__( 'Image Position', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
					'yes' => esc_html__( 'Before Content', 'tp-elements' ),
					'no' => esc_html__( 'After Content', 'tp-elements' ),
				],
				'default' => 'yes',
                'condition' => [
                    'tp_project_style' => ['style5'],
                ]
			]
		);
        
		$this->add_control(
			'project_category',
			[
				'label'   => esc_html__( 'Category', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getCategories(),
				'multiple' => true,	
				'separator' => 'before',	
				'condition' => [
					'project_grid_source' => 'dynamic',
				],	
			]
		);

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Project Show Per Page', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'tp-elements' ),
				'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
			'section_custom_content',
			[
				'label' => esc_html__( 'Project Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
					'project_grid_source' => 'custom',
				],
			]
		);

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'tp-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );  

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Video Link', 'tp-elements'),
                'type' => Controls_Manager::URL,     
            ]
        );

        $this->add_control(
            'cat_text',
            [
                'label' => esc_html__('Category Text', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Robot', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Category Name', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );
        
        $this->add_control(
            'cat_link',
            [
                'label' => esc_html__('Cat Link', 'tp-elements'),
                'type' => Controls_Manager::URL,                
            ]
        );

        $this->add_control(
            'project_title',
            [
                'label' => esc_html__('Title', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Education AI Studies', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Project Title', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );
        $this->add_control(
            'project_desc',
            [
                'label' => esc_html__('Description', 'tp-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...', 'tp-elements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Project Description', 'tp-elements' ),
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'services_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
				'placeholder' => esc_html__( 'Button Text', 'tp-elements' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Button Link', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'Button Link', 'tp-elements' ),
				'separator' => 'before',
                'condition' => [
					'project_grid_source' => 'custom',
				],	
			]
		);

		$this->add_control(
			'services_btn_link_open',
			[
				'label'   => esc_html__( 'Link Open New Window', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [					
					'no' => esc_html__( 'No', 'tp-elements'),
					'yes' => esc_html__( 'Yes', 'tp-elements'),
					

				],
			]
		);

		$this->add_control(
			'services_btn_icon',
			[
				'label' => esc_html__( 'Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICON,
				'options' => tp_framework_get_icons(),				
				'default' => 'fa fa-angle-right',
				'separator' => 'before',			
			]
		);

		$this->add_control(
		    'services_btn_icon_position',
		    [
		        'label' => esc_html__( 'Icon Position', 'tp-elements' ),
		        'type' => Controls_Manager::CHOOSE,
		        'label_block' => false,
		        'options' => [
		            'before' => [
		                'title' => esc_html__( 'Before', 'tp-elements' ),
		                'icon' => 'eicon-h-align-left',
		            ],
		            'after' => [
		                'title' => esc_html__( 'After', 'tp-elements' ),
		                'icon' => 'eicon-h-align-right',
		            ],
		        ],
		        'default' => 'after',
		        'toggle' => false,
		        'condition' => [
		            'services_btn_icon!' => '',
		        ],
		    ]
		); 

		$this->add_control(
		    'services_btn_icon_spacing',
		    [
		        'label' => esc_html__( 'Icon Spacing', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 10
		        ],
		        'condition' => [
		            'services_btn_icon!' => '',
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-el-project-item .tp-el-btn.icon-before i' => 'margin-right: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .tp-el-project-item .tp-el-btn.icon-after i' => 'margin-left: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();


        $this->start_controls_section(
            'content_project_device',
            [
                'label' => esc_html__( 'Display Items on Devices', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,               
            ]
        );

		$this->add_control(
            'col_xxl',
            [
                'label'   => esc_html__( 'Desktops > 1399px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],	        
            ]
            
        );
		$this->add_control(
            'col_xl',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],	        
            ]
            
        );

		$this->add_control(
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 4,
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],	        
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Desktops > 767px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 6,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                   
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],           
            ]
            
        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 575px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 6,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                  
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],           
            ] 
        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__( 'Tablets < 576px', 'tp-elements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 12,         
                'options' => [
                    '12' => esc_html__( '1 Column', 'tp-elements' ), 
                    '6' => esc_html__( '2 Column', 'tp-elements' ),
                    '4' => esc_html__( '3 Column', 'tp-elements' ),
                    '3' => esc_html__( '4 Column', 'tp-elements' ),
                    '2' => esc_html__( '6 Column', 'tp-elements' ),                 
                ],
                'separator' => 'before',
				'condition' => [
					'project_grid_source' => 'dynamic',
				],           
            ]
        );
       
        $this->end_controls_section();

   
        $this->start_controls_section(
            '_section_style_grid',
            [
                'label' => esc_html__( 'Project Style', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'selector' => '{{WRAPPER}} .tp-el-project-item',
			]
		);

        $this->add_responsive_control(
			'project_image_height',
			[
				'label' => esc_html__( 'Image Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 800,
					],
				],
				'mobile_default' => [
					'unit' => 'vw',
					'size' => 100,
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tp-el-project-item .thumb > img' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);
        
        $this->add_control(
            'cat_style_options',
            [
                'label' => esc_html__( 'Category Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label' => esc_html__( 'Category Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cat_bg_color',
            [
                'label' => esc_html__( 'Category Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cat_hover_color',
            [
                'label' => esc_html__( 'Category Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cat_hover_bg_color',
            [
                'label' => esc_html__( 'Category Hover Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_cat_typography',
                'selector' => '{{WRAPPER}} .tp-el-cat-btn',
            ]
        );

        $this->add_responsive_control(
            'slider_cat_margin',
            [
                'label' => esc_html__( 'Category Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_cat_padding',
            [
                'label' => esc_html__( 'Category Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'slider_cat_border_radius',
            [
                'label' => esc_html__( 'Category Border Radius', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-cat-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .tp-el-title',
            ]
        );

        $this->add_control(
            'des__styles',
            [
                'label' => esc_html__( 'Description Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'des__color',
            [
                'label' => esc_html__( 'Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'des__typography',
                'selector' => '{{WRAPPER}} .tp-el-desc',
            ]
        );

        $this->add_responsive_control(
            'des__padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'des__margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'btn_style_options',
            [
                'label' => esc_html__( 'Button Styles', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__( 'Button Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-btn span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-btn i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__( 'Button Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_hover_color',
            [
                'label' => esc_html__( 'Button Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-btn:hover span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tp-el-btn:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_hover_bg_color',
            [
                'label' => esc_html__( 'Button Hover Background', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_btn_typography',
                'selector' => '{{WRAPPER}} .tp-el-btn',
            ]
        );

        $this->add_responsive_control(
            'slider_btn_margin',
            [
                'label' => esc_html__( 'Margin', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'slider_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'tp-elements' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tp-el-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

         $this->add_control(
            'slider_item_bg_color',
            [
                'label' => esc_html__( 'Item Background Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-el-project-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>

        <?php if($settings['project_grid_source'] == 'dynamic'){ 

        if('style1' == $settings['tp_project_style']){
            require plugin_dir_path(__FILE__)."/style1.php";
        }
        if('style2' == $settings['tp_project_style']){
            require plugin_dir_path(__FILE__)."/style2.php";
        }
        if('style3' == $settings['tp_project_style']){
            require plugin_dir_path(__FILE__)."/style3.php";
        }
        if('style4' == $settings['tp_project_style']){
            require plugin_dir_path(__FILE__)."/style4.php";
        }
        if('style5' == $settings['tp_project_style']){
            require plugin_dir_path(__FILE__)."/style5.php";
        }

        } else {  

            $imgId = $settings['image']['id'];
                                                    
            if($imgId ){
                $image = wp_get_attachment_image_src($imgId, 'full')[0];
                $IMGstyle = 'style="background-image: url( '. $image .' );"';
            }else{
                $IMGstyle = '';
                $image = '';
            }                            

            $title        = !empty($settings['project_title']) ? $settings['project_title'] : '';                                         
            $cat_text    = !empty($settings['cat_text']) ? $settings['cat_text'] : '';                              
            $description  = !empty($settings['project_desc']) ? $settings['project_desc'] : '';
            $btn_text     = !empty($settings['services_btn_text']) ? $settings['services_btn_text'] : '';
            //$target       = !empty($settings['link']['is_external']) ? 'target=_blank' : '';  
            $link         = !empty($settings['link']['url']) ? $settings['link']['url'] : '';
            $cat_link     = !empty($settings['cat_link']['url']) ? $settings['cat_link']['url'] : '';
            $video_link   = !empty($settings['video_link']['url']) ? $settings['video_link']['url'] : 'https://www.youtube.com/watch?v=PHNJ2_4oefE';


            if('style1' == $settings['tp_project_style']){ ?>
            <div class="capabilities__items tp-el-project-item">

                <div class="thumb">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                    <?php if( !empty( $video_link ) ) : ?>
                    <a href="<?php echo esc_url( $video_link ); ?>" class="play__btn video-btn">
                        <i class="material-symbols-outlined">
                        play_arrow
                        </i>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="content">
                    <a href="<?php echo esc_url( $cat_link ); ?>" class="cmn--btn capabilites__btn tp-el-cat-btn">
                        <span><?php echo esc_html( $cat_text ); ?></span>
                        
                    </a>

                    <h4 class="title tp-el-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>

                    <p class="tp-el-desc"><?php echo esc_html( $description ); ?></p>

                    <?php if(!empty($settings['services_btn_text'])){ ?>
                    <div class="services-btn-part">
                        <?php if(!empty($settings['services_btn_text'])) : 
                            $link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                        ?>

                        <?php  
                            $icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                        ?>

                            <a class="services-btn tp-el-btn <?php echo esc_attr($icon_position) ?>" href="<?php echo esc_url( $link ); ?>" <?php echo wp_kses_post( $link_open ); ?>>
                                <?php if( $settings['services_btn_icon_position'] == 'before' ) : ?>
                                    <?php if(!empty($settings['services_btn_icon'])) : ?>
                                        <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <span class="btn-txt"><?php echo wp_kses_post( $btn_text );?></span>
                                <?php if( $settings['services_btn_icon_position'] == 'after' ) : ?>
                                <?php if(!empty($settings['services_btn_icon'])) : ?>
                                    <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                <?php endif; endif; ?>
                            </a>
                        <?php else: ?>
                        <?php endif;
                        ?>
                        
                    </div>
                    <?php } ?>

                </div>

            </div>
            <?php
            }
            if('style2' == $settings['tp_project_style']){ ?>
            <div class="realworld__items tp-el-project-item">
                <div class="thumb">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                    <?php if( !empty( $video_link ) ) : ?>
                    <a href="<?php echo esc_url( $video_link ); ?>" class="play__btn video-btn">
                        <i class="material-symbols-outlined">
                        play_arrow
                        </i>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="content">

                <a href="<?php echo esc_url( $cat_link ); ?>" class="tp-el-cat-btn">
                    <span><?php echo esc_html( $cat_text ); ?></span>
                </a>
                <h4 class="tp-el-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>
                <p class="tp-el-desc"><?php echo esc_html( $description ); ?></p>

                <?php if(!empty($settings['services_btn_text'])){ ?>
                <div class="services-btn-part">
                    <?php if(!empty($settings['services_btn_text'])) : 
                        $link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                    ?>

                    <?php  
                        $icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                    ?>
                        <a class="real__btn tp-el-btn <?php echo esc_attr($icon_position) ?>" href="<?php the_permalink();?>" <?php echo wp_kses_post( $link_open ); ?>>
                            <?php if( $settings['services_btn_icon_position'] == 'before' ) : ?>
                                <?php if(!empty($settings['services_btn_icon'])) : ?>
                                    <span class="icon"><i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i></span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <span class="btn-txt"><?php echo wp_kses_post( $settings['services_btn_text'] );?></span>
                            <?php if( $settings['services_btn_icon_position'] == 'after' ) : ?>
                            <?php if(!empty($settings['services_btn_icon'])) : ?>
                                <span class="icon"><i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i></span>
                            <?php endif; endif; ?>
                        </a>
                    <?php else: ?>
                    <?php endif;
                    ?>
                    
                </div>
                <?php } ?>

                </div>
            </div>
           <?php } 
           
           if('style3' == $settings['tp_project_style']){ ?>
            <div class="success__stry__item tp-el-project-item">
                <div class="thumb">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                </div>
                <div class="content">

                    <h4 class="tp-el-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>
                    <p class="tp-el-desc"><?php echo esc_html( $description ); ?></p>

                    <?php if(!empty($settings['services_btn_text'])){ ?>
                    <div class="services-btn-part">
                        <?php if(!empty($settings['services_btn_text'])) : 
                            $link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                        ?>

                        <?php  
                            $icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                        ?>
                            <a class="services-btn tp-el-btn <?php echo esc_attr($icon_position) ?>" href="<?php the_permalink();?>" <?php echo wp_kses_post( $link_open ); ?>>
                                <?php if( $settings['services_btn_icon_position'] == 'before' ) : ?>
                                    <?php if(!empty($settings['services_btn_icon'])) : ?>
                                        <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <span class="btn-txt"><?php echo wp_kses_post( $settings['services_btn_text'] );?></span>
                                <?php if( $settings['services_btn_icon_position'] == 'after' ) : ?>
                                <?php if(!empty($settings['services_btn_icon'])) : ?>
                                    <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                <?php endif; endif; ?>
                            </a>
                        <?php else: ?>
                        <?php endif;
                        ?>
                        
                    </div>
                    <?php } ?>

                </div>
            </div>
            <?php } 
            if( 'style4' == $settings['tp_project_style'] ) { ?>
            <div class="case__trough">
                <div class="capa__case__box tp-el-project-item">
                    <div class="capabilities__items">
                        <a href="<?php echo esc_url( $link ); ?>" class="thumb">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                        </a>
                        <div class="content">
                            <a href="<?php echo esc_url( $cat_link ); ?>" class="cmn--btn capabilites__btn tp-el-cat-btn">
                                <span><?php echo esc_html( $cat_text ); ?></span>
                            </a>
                            <h4 class="tp-el-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>
                        </div>
                    </div>
                </div>
            </div>
           <?php
            } 
            if( 'style5' == $settings['tp_project_style'] ) { ?> 
            <div class="case__trough case__different__section">
                <div class="capabilities__items tp-el-project-item">
                    <?php if( $settings['image_position'] == 'yes' ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="thumb">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                        </a>
                    <?php endif; ?>

                    <div class="content">

                        <a href="<?php echo esc_url( $cat_link ); ?>" class="cmn--btn capabilites__btn tp-el-cat-btn">
                            <span><?php echo esc_html( $cat_text ); ?></span>
                        </a>
                        <h4 class="title tp-el-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>
                        <p class="tp-el-desc"><?php echo esc_html( $description ); ?></p>

                        <?php if(!empty($settings['services_btn_text'])){ ?>
                        <div class="services-btn-part">
                            <?php if(!empty($settings['services_btn_text'])) : 
                                $link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                            ?>

                            <?php  
                                $icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                            ?>
                                <a class="difference__btn tp-el-btn <?php echo esc_attr($icon_position) ?>" href="<?php the_permalink();?>" <?php echo wp_kses_post( $link_open ); ?>>
                                    <?php if( $settings['services_btn_icon_position'] == 'before' ) : ?>
                                        <?php if(!empty($settings['services_btn_icon'])) : ?>
                                            <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <span class="btn-txt"><?php echo wp_kses_post( $settings['services_btn_text'] );?></span>
                                    <?php if( $settings['services_btn_icon_position'] == 'after' ) : ?>
                                    <?php if(!empty($settings['services_btn_icon'])) : ?>
                                        <i class="fa <?php echo esc_html( $settings['services_btn_icon'] );?>"></i>
                                    <?php endif; endif; ?>
                                </a>
                            <?php else: ?>
                            <?php endif;
                            ?>
                            
                        </div>
                        <?php } ?>

                    </div>
                    <?php if( $settings['image_position'] == 'no' ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="thumb">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__('project-img', 'tp-elements'); ?>">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
            } ?> 

            <script type="text/javascript"> 
            jQuery(document).ready(function(){                

                jQuery('.video-btn').magnificPopup({
                    type: 'iframe',
                    callbacks: {
                        
                    }
                });
            
            });
            </script>

            <?php
		}
	}

	public function getCategories(){
        $cat_list = [];
             if ( post_type_exists( 'services' ) ) { 
              $terms = get_terms( array(
                 'taxonomy'    => 'service-category',
                 'hide_empty'  => true            
             ) ); 
            foreach($terms as $post) {
                $cat_list[$post->slug]  = [$post->name];
            }
        }  
        return $cat_list;
    }

}