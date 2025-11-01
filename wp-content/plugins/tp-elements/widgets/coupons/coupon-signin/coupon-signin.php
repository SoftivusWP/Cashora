<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
    exit;   // Exit if accessed directly.
}

/**
 * HFE Search Button.
 *
 * HFE widget for Search Button.
 *
 * @since 1.5.0
 */
class Themephi_Coupon_Sign_In_Button extends Widget_Base {
    /**
     * Retrieve the widget name.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'hfe-coupon-signin';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'TP Coupon Signin', 'tp-elements');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'hfe-icon-search';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.5.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'tpaddon_category' ];
    }

    /**
     * Retrieve the list of scripts the navigation menu depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.5.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
 

    /**
     * Register Search Button controls.
     *
     * @since 1.5.7
     * @access protected
     */
    protected function register_controls() {
        $this->register_general_content_controls();
        $this->register_search_style_controls();
    }
    /**
     * Register Search General Controls.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function register_general_content_controls() {
        $this->start_controls_section(
            'section_general_fields',
            [
                'label' => __( 'Login / Register', 'tp-elements'),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'        => __( 'Select Layout', 'tp-elements'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'style1',
                'options'      => [
                    'style1'      => __( 'Style 1', 'tp-elements'),
                ],
            ]
        );


        $this->end_controls_section();
    }
    /**
     * Register Search Style Controls.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function register_search_style_controls() {
        
        $this->start_controls_section(
            'section_signin_style',
            [
                'label' => __( 'Style', 'tp-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,

            ]
        );

		$this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'tp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    (is_rtl() ? 'right' : 'left') => [
                        'title' => esc_html__( 'Left', 'tp-elements' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tp-elements' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    (is_rtl() ? 'left' : 'right') => [
                        'title' => esc_html__( 'Right', 'tp-elements' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'tp-elements' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tp-coupon-signin' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        
		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'tp-elements' ),
            ]
        ); 

        $this->add_responsive_control(
		    'link_margin',
		    [
		        'label' => esc_html__( 'Margin', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-signin a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-signin a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'btn_text_color',
		    [
		        'label' => esc_html__( 'Text Color', 'tp-elements' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-signin a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .tp-coupon-signin a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background_normal',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-coupon-signin a',
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .tp-coupon-signin a',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-signin a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupon-signin a',
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
		            '{{WRAPPER}} .tp-coupon-signin a:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Background', 'tp-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-coupon-signin a:hover',
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_hover_border',
		        'selector' => '{{WRAPPER}} .tp-coupon-signin a:hover',
		    ]
		);

		$this->add_control(
		    'button_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'tp-elements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .tp-coupon-signin a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_hover_box_shadow',
		        'selector' => '{{WRAPPER}} .tp-coupon-signin a:hover',
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->end_controls_section();

    }
    /**
     * Render Search button output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.5.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        global $tptheme_option; 
        if (post_type_exists('coupon')): ?>

            <style>
                .tp-coupon-signin a {
                    display: inline-block;
                }
                /* .tp-coupon-signin svg {
                    vertical-align: middle;
                    width: 1em;
                    height: 1em;
                } */
            </style>

            <div class="tp-coupon-signin">
                <?php
                if ( function_exists( 'couponis_get_permalink_by_tpl' ) ) {
                    $whishlist_url = '#';
                    $submit_url = esc_url( couponis_get_permalink_by_tpl( 'page-tpl_submit' ) );
                    $account_url = esc_url( couponis_get_permalink_by_tpl( 'page-tpl_account' ) );
                    $login_url = esc_url( couponis_get_permalink_by_tpl( 'page-tpl_login' ) );
                    $register_url = esc_url( couponis_get_permalink_by_tpl( 'page-tpl_register' ) );
                    $recover_password_url = esc_url( couponis_get_permalink_by_tpl( 'page-tpl_recover_password' ) );
                } else {
                    $whishlist_url = '#';
                    $submit_url = home_url();
                    $account_url = home_url();
                    $login_url = home_url();
                    $register_url = home_url();
                    $recover_password_url = home_url();
                }

                $special_actions = '';
                if (is_user_logged_in()) {
                    if (!empty($tptheme_option['can_submit']) && $tptheme_option['can_submit'] === 'yes') {
                        $special_actions .= '
                        <a href="' . $submit_url . '" title="' . esc_html__('Submit Coupon', 'tp-elements') . '">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.612 14.875L15.75 4.01298C15.5881 3.84977 15.3954 3.72037 15.183 3.63231C14.9706 3.54425 14.7429 3.49927 14.513 3.50001H4.37501C4.14294 3.50001 3.92038 3.5922 3.75629 3.75629C3.5922 3.92038 3.50001 4.14294 3.50001 4.37501V14.513C3.49927 14.7429 3.54425 14.9706 3.63231 15.183C3.72037 15.3954 3.84977 15.5881 4.01298 15.75L14.875 26.612C15.0375 26.7746 15.2305 26.9035 15.4428 26.9915C15.6551 27.0795 15.8827 27.1247 16.1126 27.1247C16.3424 27.1247 16.57 27.0795 16.7824 26.9915C16.9947 26.9035 17.1877 26.7746 17.3502 26.612L26.612 17.3502C26.7746 17.1877 26.9035 16.9947 26.9915 16.7824C27.0795 16.57 27.1247 16.3424 27.1247 16.1126C27.1247 15.8827 27.0795 15.6551 26.9915 15.4428C26.9035 15.2305 26.7746 15.0375 26.612 14.875ZM16.112 25.375L5.25001 14.513V5.25001H14.513L25.375 16.112L16.112 25.375ZM10.5 9.18751C10.5 9.4471 10.423 9.70086 10.2788 9.91669C10.1346 10.1325 9.92961 10.3008 9.68978 10.4001C9.44995 10.4994 9.18605 10.5254 8.93145 10.4748C8.67685 10.4241 8.44299 10.2991 8.25943 10.1156C8.07587 9.93203 7.95087 9.69817 7.90023 9.44357C7.84959 9.18897 7.87558 8.92507 7.97492 8.68524C8.07426 8.44541 8.24248 8.24042 8.45832 8.0962C8.67416 7.95199 8.92792 7.87501 9.18751 7.87501C9.53561 7.87501 9.86945 8.01329 10.1156 8.25943C10.3617 8.50557 10.5 8.83941 10.5 9.18751Z" fill="currentColor"/>
                            </svg>
                        </a>';
                    }
                    $special_actions .= '
                    <a href="' . $whishlist_url . '" title="' . esc_html__('Whishlist', 'tp-elements') . '">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.3907 6.23427C23.202 5.04849 21.592 4.38166 19.913 4.37961C18.2339 4.37756 16.6224 5.04046 15.4307 6.22334L14.0001 7.55224L12.5684 6.21896C11.377 5.03094 9.76251 4.36483 8.08003 4.36719C6.39755 4.36955 4.78491 5.04018 3.59689 6.23154C2.40887 7.4229 1.74276 9.03741 1.74512 10.7199C1.74748 12.4024 2.41811 14.015 3.60947 15.203L13.3821 25.119C13.4635 25.2016 13.5606 25.2673 13.6676 25.3121C13.7747 25.3569 13.8895 25.38 14.0056 25.38C14.1216 25.38 14.2365 25.3569 14.3435 25.3121C14.4505 25.2673 14.5476 25.2016 14.629 25.119L24.3907 15.203C25.5796 14.0134 26.2474 12.4005 26.2474 10.7186C26.2474 9.03683 25.5796 7.42385 24.3907 6.23427ZM23.1493 13.9736L14.0001 23.253L4.84541 13.9649C3.98387 13.1034 3.49986 11.9349 3.49986 10.7165C3.49986 9.49806 3.98387 8.32956 4.84541 7.46802C5.70694 6.60648 6.87544 6.12248 8.09384 6.12248C9.31224 6.12248 10.4807 6.60648 11.3423 7.46802L11.3642 7.4899L13.404 9.38755C13.5659 9.53824 13.7789 9.62201 14.0001 9.62201C14.2213 9.62201 14.4343 9.53824 14.5962 9.38755L16.636 7.4899L16.6579 7.46802C17.52 6.60706 18.6888 6.12384 19.9072 6.12466C21.1257 6.12548 22.2938 6.61028 23.1548 7.4724C24.0157 8.33452 24.499 9.50334 24.4981 10.7217C24.4973 11.9401 24.0125 13.1083 23.1504 13.9693L23.1493 13.9736Z" fill="currentColor"/>
                        </svg>
                    </a>';
                    $special_actions .= '
                    <a href="' . $account_url . '" title="' . esc_html__('My Account', 'tp-elements') . '">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.2571 23.1866C23.5913 20.3067 21.0243 18.2417 18.0285 17.2628C19.5104 16.3807 20.6617 15.0365 21.3056 13.4367C21.9496 11.8368 22.0506 10.0699 21.5931 8.40712C21.1356 6.74435 20.145 5.27772 18.7733 4.23246C17.4017 3.18719 15.7248 2.62109 14.0002 2.62109C12.2757 2.62109 10.5988 3.18719 9.22714 4.23246C7.85546 5.27772 6.86482 6.74435 6.40736 8.40712C5.94989 10.0699 6.05089 11.8368 6.69485 13.4367C7.3388 15.0365 8.49011 16.3807 9.97195 17.2628C6.97617 18.2406 4.40914 20.3056 2.74336 23.1866C2.68227 23.2862 2.64175 23.397 2.62419 23.5125C2.60664 23.628 2.61239 23.7459 2.64112 23.8592C2.66985 23.9724 2.72098 24.0788 2.79148 24.172C2.86198 24.2651 2.95043 24.3433 3.05161 24.4017C3.15279 24.4601 3.26465 24.4977 3.38059 24.5122C3.49653 24.5268 3.6142 24.5179 3.72666 24.4862C3.83913 24.4545 3.9441 24.4006 4.03539 24.3277C4.12669 24.2547 4.20245 24.1643 4.2582 24.0616C6.31883 20.5003 9.96102 18.3741 14.0002 18.3741C18.0395 18.3741 21.6816 20.5003 23.7423 24.0616C23.798 24.1643 23.8738 24.2547 23.9651 24.3277C24.0564 24.4006 24.1613 24.4545 24.2738 24.4862C24.3863 24.5179 24.5039 24.5268 24.6199 24.5122C24.7358 24.4977 24.8477 24.4601 24.9489 24.4017C25.05 24.3433 25.1385 24.2651 25.209 24.172C25.2795 24.0788 25.3306 23.9724 25.3593 23.8592C25.3881 23.7459 25.3938 23.628 25.3763 23.5125C25.3587 23.397 25.3182 23.2862 25.2571 23.1866ZM7.87523 10.4991C7.87523 9.28766 8.23446 8.10345 8.90748 7.0962C9.58051 6.08895 10.5371 5.30389 11.6563 4.84031C12.7755 4.37672 14.007 4.25542 15.1952 4.49176C16.3833 4.72809 17.4747 5.31144 18.3313 6.16804C19.1879 7.02464 19.7712 8.11601 20.0075 9.30414C20.2439 10.4923 20.1226 11.7238 19.659 12.843C19.1954 13.9622 18.4104 14.9188 17.4031 15.5918C16.3959 16.2648 15.2116 16.6241 14.0002 16.6241C12.3763 16.6223 10.8194 15.9765 9.67112 14.8282C8.52284 13.6799 7.87697 12.123 7.87523 10.4991Z" fill="currentColor"/>
                        </svg>
                    </a>';
                } else {
                    $special_actions = '
                    <a href="' . $login_url . '" title="' . esc_html__('Login', 'tp-elements') . '">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.4941 14.6191L11.1191 18.9941C11.0378 19.0754 10.9413 19.1398 10.835 19.1838C10.7288 19.2278 10.615 19.2505 10.5 19.2505C10.385 19.2505 10.2712 19.2278 10.165 19.1838C10.0587 19.1398 9.96223 19.0754 9.88094 18.9941C9.79964 18.9128 9.73515 18.8163 9.69116 18.71C9.64716 18.6038 9.62451 18.49 9.62451 18.375C9.62451 18.26 9.64716 18.1462 9.69116 18.04C9.73515 17.9337 9.79964 17.8372 9.88094 17.7559L12.763 14.875H2.625C2.39294 14.875 2.17038 14.7828 2.00628 14.6187C1.84219 14.4546 1.75 14.2321 1.75 14C1.75 13.7679 1.84219 13.5454 2.00628 13.3813C2.17038 13.2172 2.39294 13.125 2.625 13.125H12.763L9.88094 10.2441C9.71675 10.0799 9.62451 9.85719 9.62451 9.625C9.62451 9.39281 9.71675 9.17012 9.88094 9.00594C10.0451 8.84175 10.2678 8.74951 10.5 8.74951C10.7322 8.74951 10.9549 8.84175 11.1191 9.00594L15.4941 13.3809C15.5754 13.4622 15.64 13.5587 15.684 13.6649C15.728 13.7712 15.7507 13.885 15.7507 14C15.7507 14.115 15.728 14.2288 15.684 14.3351C15.64 14.4413 15.5754 14.5378 15.4941 14.6191ZM21 3.5H14.875C14.6429 3.5 14.4204 3.59219 14.2563 3.75628C14.0922 3.92038 14 4.14294 14 4.375C14 4.60706 14.0922 4.82962 14.2563 4.99372C14.4204 5.15781 14.6429 5.25 14.875 5.25H21V22.75H14.875C14.6429 22.75 14.4204 22.8422 14.2563 23.0063C14.0922 23.1704 14 23.3929 14 23.625C14 23.8571 14.0922 24.0796 14.2563 24.2437C14.4204 24.4078 14.6429 24.5 14.875 24.5H21C21.4641 24.5 21.9092 24.3156 22.2374 23.9874C22.5656 23.6592 22.75 23.2141 22.75 22.75V5.25C22.75 4.78587 22.5656 4.34075 22.2374 4.01256C21.9092 3.68437 21.4641 3.5 21 3.5Z" fill="currentColor"/>
                        </svg>
                    </a>
                    <a href="' . $register_url . '" title="' . esc_html__('Register', 'tp-elements') . '">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.9997 14.8755C27.9997 15.1075 27.9075 15.3301 27.7434 15.4942C27.5793 15.6583 27.3568 15.7505 27.1247 15.7505H25.3747V17.5005C25.3747 17.7325 25.2825 17.9551 25.1184 18.1192C24.9543 18.2833 24.7318 18.3755 24.4997 18.3755C24.2677 18.3755 24.0451 18.2833 23.881 18.1192C23.7169 17.9551 23.6247 17.7325 23.6247 17.5005V15.7505H21.8747C21.6427 15.7505 21.4201 15.6583 21.256 15.4942C21.0919 15.3301 20.9997 15.1075 20.9997 14.8755C20.9997 14.6434 21.0919 14.4208 21.256 14.2567C21.4201 14.0927 21.6427 14.0005 21.8747 14.0005H23.6247V12.2505C23.6247 12.0184 23.7169 11.7958 23.881 11.6317C24.0451 11.4677 24.2677 11.3755 24.4997 11.3755C24.7318 11.3755 24.9543 11.4677 25.1184 11.6317C25.2825 11.7958 25.3747 12.0184 25.3747 12.2505V14.0005H27.1247C27.3568 14.0005 27.5793 14.0927 27.7434 14.2567C27.9075 14.4208 27.9997 14.6434 27.9997 14.8755ZM21.6702 21.3122C21.8196 21.49 21.8922 21.7199 21.8721 21.9513C21.852 22.1826 21.7408 22.3965 21.563 22.5459C21.3852 22.6953 21.1553 22.768 20.9239 22.7479C20.6926 22.7278 20.4786 22.6166 20.3292 22.4387C18.1286 19.8181 15.1033 18.3755 11.8122 18.3755C8.52112 18.3755 5.49581 19.8181 3.29518 22.4387C3.14579 22.6164 2.93194 22.7275 2.70067 22.7475C2.4694 22.7675 2.23966 22.6948 2.06198 22.5454C1.88431 22.396 1.77326 22.1821 1.75326 21.9509C1.73326 21.7196 1.80595 21.4899 1.95534 21.3122C3.5894 19.3675 5.62159 17.9861 7.88019 17.2467C6.50852 16.3924 5.45241 15.1146 4.87164 13.6066C4.29088 12.0986 4.21705 10.4425 4.66133 8.88878C5.10561 7.33509 6.04383 5.96836 7.33404 4.99538C8.62425 4.0224 10.1963 3.49609 11.8122 3.49609C13.4282 3.49609 15.0002 4.0224 16.2904 4.99538C17.5806 5.96836 18.5188 7.33509 18.9631 8.88878C19.4074 10.4425 19.3336 12.0986 18.7528 13.6066C18.172 15.1146 17.1159 16.3924 15.7442 17.2467C18.0028 17.9861 20.035 19.3675 21.6702 21.3122ZM11.8122 16.6255C12.9371 16.6255 14.0367 16.2919 14.972 15.667C15.9073 15.042 16.6363 14.1537 17.0668 13.1145C17.4973 12.0752 17.6099 10.9317 17.3904 9.82839C17.171 8.72512 16.6293 7.71171 15.8339 6.9163C15.0385 6.12089 14.0251 5.5792 12.9218 5.35975C11.8185 5.1403 10.675 5.25293 9.6357 5.6834C8.59645 6.11388 7.70818 6.84286 7.08323 7.77816C6.45828 8.71347 6.12472 9.81309 6.12472 10.938C6.12645 12.4459 6.72623 13.8915 7.79246 14.9577C8.8587 16.024 10.3043 16.6237 11.8122 16.6255Z" fill="currentColor"/>
                        </svg>
                    </a>';
                }
                
                echo wp_kses($special_actions, [
                    'a' => [
                        'href' => [],
                        'title' => [],
                        'class' => [],
                    ],
                    'i' => [
                        'title' => [],
                        'class' => [],
                    ],
                    'svg' => [
                        'width' => [],
                        'height' => [],
                        'viewBox' => [],
                        'fill' => [],
                        'xmlns' => [],
                    ],
                    'path' => [
                        'd' => [],
                        'fill' => [],
                        'stroke' => [],
                        'stroke-width' => [],
                        'stroke-linecap' => [],
                        'stroke-linejoin' => [],
                    ],
                ]);
                ?>
            </div>
        <?php endif;
    }
}
