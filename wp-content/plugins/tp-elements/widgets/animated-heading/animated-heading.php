<?php
/**
 * Elementor Animated Heading
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

defined( 'ABSPATH' ) || die();

class Pixelaxis_Elementor_Animated_Heading_Widget extends \Elementor\Widget_Base {

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
		return 'tp-animated-heading';
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
		return esc_html__( 'TP Animated Heading', 'tp-elements' );
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
		return 'glyph-icon flaticon-files-and-folders';
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
			'animated_section',
			[
				'label' => esc_html__( 'Animated Title', 'tp-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,							
			]
		);

		$this->add_control(
			'animated_pre_text',
			[
				'type' => Controls_Manager::TEXT,							
				'placeholder' => esc_html__( 'Animated Pre Text ', 'tp-elements' ),
			]
		);

		$repeater = new Repeater();


		$repeater->add_control(
			'animated_text',
			[
				'type' => Controls_Manager::TEXT,
				'rows' => 10,				
				'placeholder' => esc_html__( 'Animated Text here', 'tp-elements' ),
			]
		);
		$this->add_control(
            'title_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ animated_text }}}',
                
            ]
        );

		$this->add_control(
			'pre_color',
			[
				'label' => esc_html__( 'Pre Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-marketing .animate-pre-text' => 'color: {{VALUE}};',
					
                ],
				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'animate_pre_title_typography',
				'label' => esc_html__( 'Animate Pre Title Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .banner-marketing .animate-pre-text',
			]
		);

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'animate_title_typography',
				'label' => esc_html__( 'Animate Title Typography', 'tp-elements' ),
				'selector' => '{{WRAPPER}} .banner-marketing .banner-title .title .changebox span',
			]
		);		

		$this->add_control(
			'show_stroke',
			[
				'label' => esc_html__( 'Enable Stroke', 'tp-elements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tp-elements' ),
				'label_off' => esc_html__( 'Hide', 'tp-elements' ),
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label' => esc_html__( 'Text Color', 'tp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-marketing.stroke-yes .letter' => 'color: {{VALUE}};',
					'{{WRAPPER}} .banner-marketing .letter' => 'color: {{VALUE}};',
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
		<div class="banner-marketing stroke-<?php echo $settings['show_stroke'];?>">
			<div class="banner-title">							
				<div class="title">		
					<?php if($settings['animated_pre_text']) : ?>
						<div class="animate-pre-text"><?php echo $settings['animated_pre_text'];?></div>	
					<?php endif; ?>	
					<div class="changebox">
						<?php foreach ( $settings['title_list'] as $index => $item ) : ?>
							<span class="word"><?php echo $item['animated_text'];?></span>
						<?php endforeach ;?>
					</div>
				</div>
			</div>			
		</div>
		<script>
			jQuery(document).ready(function(){
			var words = document.getElementsByClassName('word');
			var wordArray = [];
			var currentWord = 0;

			words[currentWord].style.opacity = 1;
			for (var i = 0; i < words.length; i++) {
			splitLetters(words[i]);
			}

			function changeWord() {
			var cw = wordArray[currentWord];
			var nw = currentWord == words.length-1 ? wordArray[0] : wordArray[currentWord+1];
			for (var i = 0; i < cw.length; i++) {
				animateLetterOut(cw, i);
			}
			
			for (var i = 0; i < nw.length; i++) {
				nw[i].className = 'letter behind';
				nw[0].parentElement.style.opacity = 1;
				animateLetterIn(nw, i);
			}
			
			currentWord = (currentWord == wordArray.length-1) ? 0 : currentWord+1;
			}

			function animateLetterOut(cw, i) {
			setTimeout(function() {
					cw[i].className = 'letter out';
			}, i*80);
			}

			function animateLetterIn(nw, i) {
			setTimeout(function() {
					nw[i].className = 'letter in';
			}, 340+(i*80));
			}

			function splitLetters(word) {
			var content = word.innerHTML;
			word.innerHTML = '';
			var letters = [];
			for (var i = 0; i < content.length; i++) {
				var letter = document.createElement('span');
				letter.className = 'letter';
				letter.innerHTML = content.charAt(i);
				word.appendChild(letter);
				letters.push(letter);
			}
			
			wordArray.push(letters);
			}

			changeWord();
			setInterval(changeWord, 4000);
		
			});
		</script>
	<?php }
}?>