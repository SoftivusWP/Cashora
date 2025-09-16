<?php
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Portfolio_List_Widget extends \Elementor\Widget_Base {

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
		return 'tp-portfolio-list';
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
		return __( 'TP Portfolio List', 'tp-elements' );
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
		return 'glyph-icon flaticon-grid';
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
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		

		$this->add_control(
			'show_releted_post',
			[
				'label' => esc_html__( 'Show Releted Post', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tp-elements' ),
				'label_off' => esc_html__( 'No', 'tp-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'portfolio_grid_style' => '6',
				],

			]
		);


		$this->add_control(
			'portfolio_category',
			[
				'label'   => esc_html__( 'Category', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getCategories(),
				'multiple' => true,	
				'separator' => 'before',		
			]

		);

		

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Project Show Per Page', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => -1,
				'separator' => 'before',
			]
		);

		$this->add_control(
				'show_filter',
				[
					'label'   => esc_html__( 'Show Filter', 'tp-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'filter_hide',	
					'separator' => 'before',		
					'options' => [
						'filter_show' => 'Show',
						'filter_hide' => 'Hide',				
					],											
				]
			);

			$this->add_control(
				'filter_title',
				[
					'label' => esc_html__( 'Filter Default Title', 'tp-elements' ),
					'type' => Controls_Manager::TEXT,
					'default' => 'All',
					'condition' => [
	                	'show_filter' => 'filter_show',
	                ],
	                	
					'separator' => 'before',
				]
			);
	
		$this->add_control(
			'portfolio_columns',
			[
				'label'   => esc_html__( 'Columns', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,				
				'options' => [
					'6' => esc_html__( '2 Column', 'tp-elements' ),
					'4' => esc_html__( '3 Column', 'tp-elements' ),
					'3' => esc_html__( '4 Column', 'tp-elements' ),
					'2' => esc_html__( '6 Column', 'tp-elements' ),
					'1' => esc_html__( '1 Column', 'tp-elements' ),					
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
			'details_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'tp-elements' ),
				'type' => Controls_Manager::TEXT,				
				'separator' => 'before',
				  
		        'condition' => ['portfolio_grid_style' => ['1', '3']],
			]
		);	 


        $this->add_control(
			'image_spacing_custom',
			[
				'label' => esc_html__( 'Item Bottom Gap', 'tp-elements' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => true,
				'separator' => 'before',
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],			

				'selectors' => [
                    '{{WRAPPER}} .portfolio-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .portfolio-inner-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
			]
		);    

				
		$this->end_controls_section();

		
        $this->start_controls_section(
			'section_slider_style',
			[
				'label' => esc_html__( 'Style', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .p-title a' => 'color: {{VALUE}};',                   

                ],                
            ]
        );



        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .p-title a:hover' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .p-title a',                    
			]
		);


        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .p-category a' => 'color: {{VALUE}};',                   

                ],                
            ]
        );

        $this->add_control(
            'category_color_hover',
            [
                'label' => esc_html__( 'Category Hover Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .p-category a:hover' => 'color: {{VALUE}};',                    
                ],                
            ]            
        ); 


        $this->add_control(
            'image_overlay',
            [
                'label' => esc_html__( 'Image Overlay', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .portfolio-content:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .slider-style-5 .tp-portfolio4 .portfolio-item' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tp-portfolio-style3 .portfolio-item .portfolio-img:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tp-portfolio-style2 .portfolio-item:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .tp-portfolio-style4 .portfolio-item .portfolio-img:before' => 'background: {{VALUE}};',


                ],                
            ]
        );

        $this->add_control(
            'image_overlay_color',
            [
                'label' => esc_html__( 'Image Overlay 2nd Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .tp-portfolio-style2 .portfolio-item:hover:before' => 'background: {{VALUE}};',                ],  
                    'condition' => [
					'portfolio_grid_style' => '2',
				],              
            ]
        );
        
        $this->end_controls_section();

        	$this->start_controls_section(
        		    '_section_style_button',
        		    [
        		        'label' => esc_html__( 'Button', 'tp-elements' ),
        		        'tab' => Controls_Manager::TAB_STYLE,
        		        'condition' => [
							'portfolio_grid_style' => '1',
						],
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
        		            '{{WRAPPER}} .tp-portfolio-style1 .read-btn' => 'color: {{VALUE}};',
        		        ],
        		    ]
        		);

        		$this->add_group_control(
        		    Group_Control_Background::get_type(),
        			[
        				'name' => 'background_normal',
        				'label' => esc_html__( 'Background', 'tp-elements' ),
        				'types' => [ 'classic', 'gradient' ],
        				'selector' => '{{WRAPPER}} .portfolio-item .link-button',
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
        		            '{{WRAPPER}}  .tp-portfolio-style1 .grid-item:hover .read-btn' => 'color: {{VALUE}};',
        		        ],
        		    ]
        		);

        		$this->add_group_control(
        		    Group_Control_Background::get_type(),
        			[
        				'name' => 'background',
        				'label' => esc_html__( 'Background', 'tp-elements' ),
        				'types' => [ 'classic', 'gradient' ],
        				'selector' => '{{WRAPPER}} .tp-portfolio-style1 .grid-item:hover .read-btn:before',
        			]
        		);

        		$this->end_controls_tab();
        		$this->end_controls_tabs();	
        		

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
	$popup_port_title_color = !empty( $settings['popup_port_title_color']) ? 'style="color: '.$settings['popup_port_title_color'].'"' : '';
	$popup_port_content_color = !empty( $settings['popup_port_content_color']) ? 'style="color: '.$settings['popup_port_content_color'].'"' : '';
	$popup_port_info_color = !empty( $settings['popup_port_info_color']) ? 'style="color: '.$settings['popup_port_info_color'].'"' : '';
	$popup_port_background = !empty( $settings['popup_port_background']) ? 'style="background: '.$settings['popup_port_background'].'"' : '';
	if($settings['show_filter'] == 'filter_show') : ?>	
		<div class="portfolio-filter">
			<button class="active" data-filter="*"><?php echo esc_html($settings['filter_title']);?></button>
			<?php $taxonomy = "tp-portfolio-category";
				$select_cat = $settings['portfolio_category'];
				foreach ($select_cat as $catid) {
				$term = get_term_by('slug', $catid, $taxonomy);
				$term_name  =  $term->name;
				$term_slug  =  $term->slug;
			?>
				<button data-filter=".filter_<?php echo esc_html($term_slug);?>"><?php echo esc_html($term_name);?></button>
			<?php  } ?>

		</div>
	
	<?php endif; ?>


	<div class="tp-portfolio-style<?php echo esc_attr($settings['portfolio_grid_style']); ?> grid-portfolio">

		<div class="grid">
			<div class="row">
				
					<?php 
					$cat = $settings['portfolio_category']; 
					if(empty($cat)){
						$best_wp = new wp_Query(array(
								'post_type'      => 'tp-portfolios',
								'posts_per_page' => $settings['per_page'],								
						));	  
					}   
					else{
						$best_wp = new wp_Query(array(
							'post_type'      => 'tp-portfolios',
							'posts_per_page' => $settings['per_page'],				
							'tax_query'      => array(
								array(
									'taxonomy' => 'tp-portfolio-category',
									'field'    => 'slug', //can be set to ID
										'terms'    => $cat //if field is ID you can reference by cat/term number
								),
							)
						));	  
					}

					while($best_wp->have_posts()): $best_wp->the_post();	
					$cats_show = get_the_term_list( $best_wp->ID, 'tp-portfolio-category', ' ', '<span class="separator">,</span> ');	
					$termsArray  = get_the_terms( $best_wp->ID, 'tp-portfolio-category' );  //Get the terms for this particular item
					$termsString = ""; //initialize the string that will contain the terms
					$termsSlug   = "";

					foreach ( $termsArray as $term ) { 
						$termsString .= 'filter_'.$term->slug.' '; 
						$termsSlug .= $term->name;
					}								
					?>	

						<div class="col-lg-8  offset-lg-4 main-content-wrapper-s-service grid-item <?php echo $termsString;?>">		
							<div class="single-varticle-product one">
									<div class="name-area">
										<span>01</span>
										<?php if(get_the_title()):?>
											<h4 class="p-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
										<?php endif;?>
									</div>
									<div class="mid-disc">
										
											<span class="p-category"><?php echo wp_kses_post($cats_show); ?></span>
										
									</div>
									<div class="end">
									<a class="pf-btn" href="<?php the_permalink();?>"><button><i class="tp-arrow-up-right"></i></button></a>
									</div>
								</div>
							</div>			
						</div>
						
					<?php	
					endwhile;
					wp_reset_query();  
					?>
			</div>
		</div>
	</div>

	<?php	

	}
public function getCategories(){
    $cat_list = [];
     	if ( post_type_exists( 'tp-portfolios' ) ) { 
      	$terms = get_terms( array(
         	'taxonomy'    => 'tp-portfolio-category',
         	'hide_empty'  => true            
     	) );
        
        foreach($terms as $post) {
        	$cat_list[$post->slug]  = [$post->name];
        }
	}  
    return $cat_list;
}
}?>