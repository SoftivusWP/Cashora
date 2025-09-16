<?php
/**
 * Logo widget class
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

class Pixelaxis_Client_Thumb_Showcase_Widget extends \Elementor\Widget_Base {   
   
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
        return 'tp-client-thumb';
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
        return esc_html__( 'TP Client Thumb', 'tp-elements' );
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
            '_section_logo',
            [
                'label' => esc_html__( 'Clint Thumb', 'tp-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image 1', 'tp-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );     

        $this->add_control(
            'logo_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],                    
                ]
            ]
        );
        $this->add_control(
			'text_info',
			[
				'label'       => esc_html__( 'Tag Line', 'tp-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '',			
				'separator'   => 'before',
			]
		);        
        $this->end_controls_section();       
    }

    protected function render() {

        $settings = $this->get_settings_for_display(); ?>
        
        <div class="happy-clients-area-start">
        <div class="img-area-person">
            <?php 
            foreach ( $settings['logo_list'] as $index => $item ) :
               $image = wp_get_attachment_image_url( $item['image']['id'], $settings['thumbnail_size'] );
                
                if ( empty($image) ) {
                    $image = Utils::get_placeholder_image_src();  }
                ?>
                    <img src="<?php echo esc_url($image);?>" alt="team">
                    <?php 
                 endforeach; ?>             
            
            
        </div>
        <p><?php echo $settings['text_info'];?></p>
    </div>  
<?php
 }
}