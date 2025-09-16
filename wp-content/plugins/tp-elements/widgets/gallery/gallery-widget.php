<?php
/**
 * Elementor rsgallery Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_pro_Gallery_Widget extends \Elementor\Widget_Base {

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
		return 'tp-gallery';
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
		return esc_html__( 'TP Gallery', 'tp-elements' );
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
		return 'glyph-icon flaticon-attach';
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
        return [ 'tpaddon_category' ];
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
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rs-gallery',
			[
				'label' => esc_html__( 'Gallery Images', 'tp-elements' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);


		$this->add_control(
			'gallery_style',
			[
				'label'   => esc_html__( 'Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => esc_html__( 'Style 1', 'tp-elements' ),
					'style2' => esc_html__( 'Style 2', 'tp-elements' ),
					
				],
				'separator' => 'before',
			]
		);
		
	
		$this->add_control(
			'gallery_columns',
			[
				'label'   => esc_html__( 'Columns', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 4,
				'options' => [
					'6' => esc_html__( '2 Column', 'tp-elements' ),
					'4' => esc_html__( '3 Column', 'tp-elements' ),
					'3' => esc_html__( '4 Column', 'tp-elements' ),
					'2' => esc_html__( '6 Column', 'tp-elements' ),
					
				],
				'separator' => 'before',
			]
		);
		
	
	
		$this->add_control(
			'gallery_column_gap',
			[
				'label'   => esc_html__( 'Column Gaps', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Yes', 'tp-elements' ),
					'no-gutters' => esc_html__( 'No', 'tp-elements' ),
				],
				'separator' => 'before',
			]
		);
		
	
		$this->add_control(
			'gallery_effice',
			[
				'label'   => esc_html__( 'Background Hover Effect', 'tp-elements' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'tp-elements' ),
					'top' => esc_html__( 'Top', 'tp-elements' ),
					'right' => esc_html__( 'Right', 'tp-elements' ),
					'bottom' => esc_html__( 'Bottom', 'tp-elements' ),
					
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'gallery_cation_style',
			[
				'label'       => esc_html__( 'Caption Title Show/Hide', 'tp-elements' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'hide',
				'options' => [
					'show' => esc_html__( 'Show', 'tp-elements' ),
					'hide' => esc_html__( 'Hide', 'tp-elements' ),
				],
				'separator' => 'before',
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
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Select Hover Icon', 'tp-elements' ),
				'type' => Controls_Manager::ICON,
				'options'   => tp_framework_get_icons(),	
				'default'   => 'fa fa-search',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'tp-elements' ),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'Default', 'tp-elements' ),
					'custom' => esc_html__( 'Custom', 'tp-elements' ),
				],
				'prefix_class' => 'gallery-spacing-',
				'default'      => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => esc_html__( 'Image Spacing', 'tp-elements' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => false,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
				],
			
				'condition' => [
					'image_spacing' => 'custom',
				],

				'selectors' => [
                    '{{WRAPPER}} .galley-img' => 'padding-right: {{SIZE}}{{UNIT}} ; margin-bottom: {{SIZE}}{{UNIT}};'
                ],
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_gallery_images',
			[
				'label' => esc_html__( 'Gallery Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_font_size',
			[
				'label' => esc_html__( 'Icon Font Size', 'tp-elements' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => true,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 22,
				],				

				'selectors' => [
                     '{{WRAPPER}}  .rs-galleys .galley-img .p-zoom i:before, .rs-galleys .galley-img .zoom-icon i:before' => 'font-size: {{SIZE}}{{UNIT}}'
                ],
			]
		);


        $this->add_control(
            'gallery_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-galleys .galley-img .zoom-icon' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control(
            'gallery_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-galleys .galley-img .zoom-icon:hover' => 'color: {{VALUE}};',
                ],                
            ]
        );

		$this->add_control(
		    'gallery_title_color',
		    [
		        'label' => esc_html__( 'Caption Title Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}}  .rs-galleys .galley-img .gallery-titles' => 'color: {{VALUE}}',
		        ],
		        'condition' => [
		            'gallery_cation_style' => 'show'
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'gallery_title_typography',
		        'label' => esc_html__( 'Caption Title Typography', 'tp-elements' ),
		        'selector' => '{{WRAPPER}}  .rs-galleys .galley-img .gallery-titles',
		        'condition' => [
		            'gallery_cation_style' => 'show'
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'gallery_left_position',
		    [
		        'label' => esc_html__( 'Caption Title Left Right Position', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            '%' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-galleys .galley-img .gallery-titles' => 'left: {{SIZE}}{{UNIT}};',
		        ],
		        'condition' => [
		            'gallery_cation_style' => 'show'
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'gallery_top_position',
		    [
		        'label' => esc_html__( 'Caption Title Top Bottom Position', 'tp-elements' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px', '%' ],
		        'range' => [
		            '%' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		            'px' => [
		                'min' => -1000,
		                'max' => 1000,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-galleys .galley-img .gallery-titles' => 'top: {{SIZE}}{{UNIT}};',
		        ],
		        'condition' => [
		            'gallery_cation_style' => 'show'
		        ],
		    ]
		);

		$this->add_control(
            'image_overlay_color',
            [
                'label' => esc_html__( 'Image Hover Overlay Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-galleys .file-list-image:before, .rs-galleys .galley-img:before' => 'background: {{VALUE}};',
                ],                
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
	    <div class="row rs-galleys elementor-image-gallery <?php echo esc_html( $settings['gallery_column_gap'] );?>"> 	   			
	   		<?php
				foreach ( $settings['rs-gallery'] as $image ) { 
					$gallery_item = wp_get_attachment_image_url( $image['id'], $settings['thumbnail_size'] );
					$gallery_titles =  get_post_field( 'post_title', $image['id'] );
					?>						
					<div class="col-md-<?php echo esc_html( $settings['gallery_columns'] );?>">
						<div class="galley-img <?php echo esc_html( $settings['gallery_effice'] );?> <?php echo esc_html( $settings['gallery_style'] );?>">
							<a class="image-popup zoom-icon" href="<?php echo esc_url (wp_get_attachment_image_url( $image['id'], 'Full'));?>">
			    				<i class="<?php echo esc_html( $settings['selected_icon']);?>"></i>
			    			</a>							
							<a class="img-wrap" href="<?php echo esc_url ( wp_get_attachment_image_url( $image['id'], 'Full'));?>" title="Title 1">
								<img src="<?php echo esc_url($gallery_item);?>" alt=" ">
							</a>
							<?php
								if(!empty($gallery_titles) && ($settings['gallery_cation_style'] == 'show')){
				                    echo '<h5 class="gallery-titles">'.$gallery_titles.'</h5>';
				                }
							?>
						</div>
					</div>						
			<?php }?>		
		</div>


		<script type="text/javascript">			
			jQuery(document).ready(function(){
				jQuery('.image-popup').magnificPopup({
			        type: 'image',
			        callbacks: {
			            beforeOpen: function() {
			               this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated zoomInDown');
			            }
			        },
			        gallery: {
			            enabled: true
			        }
			    });
			});
		</script>
		<?php
	}
}?>



