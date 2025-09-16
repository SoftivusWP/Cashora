<?php
/**
 * Marquee widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_pro_Line_Draw_Widget extends \Elementor\Widget_Base {


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
        return 'tp-linedraw';
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
        return esc_html__( 'TP Line Draw', 'tp-elements' );
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
        return [ 'logo', 'clients', 'brand', 'parnter', 'image' ];
    }

    protected function register_controls() {   


        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tp-elements' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'line_style',
			[
				'label'   => esc_html__( 'Select Style', 'tp-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
                    'style1' => esc_html__( 'Style 1', 'tp-elements'),
					'style2' => esc_html__( 'Style 2', 'tp-elements'),
				],
			]
		);

		$this->add_control(
			'top-to-bottom',
			[
				'label' => esc_html__( 'Link', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'please insert your link', 'tp-elements' ),
			]
		);

		$this->end_controls_section();

        
    }

    protected function render() {

        $settings = $this->get_settings_for_display();   

        ?>

        <style>

            .scroll-bottom {
                width: 74px;
                height: 172px;
                background-color: rgba(249,93,0, 1);
                transition: ease-out 1s;
                position: relative;
                z-index: 2;
                border: 1px solid transparent;
                @media (max-width: 991px) {
                    height: 100px;
                    width: 50px;
                }
            }
            .scroll-bottom::before, .scroll-bottom::after {
                content: "";
                position: absolute;
                height: 100%;
                width: 100%;
                background-color: rgba(249,93,0, 0.8);
                transition: all 1.5s ease-in-out;
                transform: translateY(-100%);
            }
            .scroll-bottom::after {
                background-color: rgba(249,93,0, 0.4);
                transition: all 2.5s ease-in-out;
                transform: translateY(-200%);
            }
            .scroll-bottom i{
                transform: translateY(10%);
                transition: all 1.5s ease-in-out;
                display: inline-block;
                font-size: 26px;
                font-weight: 700;
            }
            .scroll-bottom:hover::before {
                transform: translateY(100%);
            }
            .scroll-bottom:hover::after {
                transform: translateY(100%);
            }
            .scroll-bottom:hover i {
                transform: translateY(200%);
            }
            .scroll-bottom:hover {
                background-color: rgba(9,9,8, 1);
                border-color: rgba(9,9,8,1);
            }

        </style>

        <?php if( $settings['line_style'] == 'style2' ) : ?>

        <button type="button" class="scroll-bottom overflow-hidden d-flex justify-content-center position-relative cus-border border">
            <span class="fs-three cus-z2">
                <i class="tp tp-arrow-down-long"></i>
            </span>
        </button>

        <?php else : ?>

        <div class="tp-line-draw">
            <div class="tps-to-bottom-start">
                <a href="<?php echo esc_html($settings['top-to-bottom']); ?>" class="active"></a>
            </div>          
        </div>

        <?php endif; ?>

<?php
    }
}