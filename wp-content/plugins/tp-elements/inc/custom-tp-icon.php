<?php /**
 * Adding custom icon to icon control in Elementor
 */
function tp_add_custom_icons_tab( $tabs = array() ) {

	// Append new icons
	$new_icons = array(
		'linkedin-in',
		'location-dot',
		'message',
		'phone-flip',
		'play',
		'tp-plus',
		'quote-left',
		'check',
		'angle-down',
		'angle-up',
		'angle-right',
		'angle-left',
		'angles-up',
		'arrow-left',
		'arrow-right',
		'arrow-left-long',
		'arrow-right-long',
		'search',
		'user-2',
		'user',
		'cart',
		'plus',
		'icon-check',
		'basket-shopping',
		'phone-office',
		'phone-volume',
		'plus-regular',
		'minus-regular',
		'cart-shopping',
		'map-location-dot',
		'headset-1',
		'arrow-right-regular',
		'envelope-open-text',
		'arrow-up-right'
	);

	$dir =  get_template_directory_uri();	
	$tabs['tp-custom-icons'] = array(
		'name'          => 'tp-custom-icons',
		'label'         => esc_html__( 'TP Custom Icons', 'tp-framework' ),
		'prefix'        => 'tp-',
		'displayPrefix' => 'tp',
		'labelIcon'     => 'icon tp-icon',
		'url'           =>  $dir.'/assets/css/tp-icons.css',
		'icons'         => $new_icons,
		'ver'           => '6.0',
	);
	return $tabs;
}

add_filter( 'elementor/icons_manager/additional_tabs', 'tp_add_custom_icons_tab' );