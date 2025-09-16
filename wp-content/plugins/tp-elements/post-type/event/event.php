<?php

global $cashora_option;
// Register Event Post Type
function tp_event_register_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Events', 'tp-elements' ),
		'singular_name'      => esc_html__( 'Event', 'tp-elements' ),
		'add_new'            => esc_html_x( 'Add New Event', 'tp-elements'),
		'add_new_item'       => esc_html__( 'Add New Event', 'tp-elements' ),
		'edit_item'          => esc_html__( 'Edit Event', 'tp-elements' ),
		'new_item'           => esc_html__( 'New Event', 'tp-elements' ),
		'all_items'          => esc_html__( 'All Events', 'tp-elements' ),
		'view_item'          => esc_html__( 'View Event', 'tp-elements' ),
		'search_items'       => esc_html__( 'Search Events', 'tp-elements' ),
		'not_found'          => esc_html__( 'No Events found', 'tp-elements' ),
		'not_found_in_trash' => esc_html__( 'No Events found in Trash', 'tp-elements' ),
		'parent_item_colon'  => esc_html__( 'Parent Event:', 'tp-elements' ),
		'menu_name'          => esc_html__( 'TP Event', 'tp-elements' ),
	);
	global $cashora_option;
	$event_slug = (!empty($cashora_option['event_slug']))? $cashora_option['event_slug'] :'event';
	$args = array(
		'labels'             => $labels,
		'public'             => true,	
		'show_in_menu'       => true,
		'show_in_admin_bar'  => true,
		'can_export'         => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'rewrite' => 		 array('slug' => $event_slug,'with_front' => false),
		'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
		'supports'           => array( 'title', 'thumbnail','editor', 'tags' ),		
	);
	register_post_type( 'tp-events', $args );
}
add_action( 'init', 'tp_event_register_post_type' );
function tp_create_event() {
	register_taxonomy(
		'tp-event-category',
		'tp-events',
		array(
			'label' => __( 'Event Categories','tp-elements' ),
			'rewrite' => array( 'slug' => 'tp-event-category' ),
			'hierarchical' => true,
			'show_admin_column' => true,	
		)
	);
}
add_action( 'init', 'tp_create_event' );