<?php
class Pixelaxis_Project_Portfolio{	

	public function __construct() {
		add_action( 'init', array( $this, 'tp_portfolio_register_post_type' ) );		
		add_action( 'init', array( $this, 'tp_create_portfolio_category' ) );
	}

	// Register Portfolio Post Type
	function tp_portfolio_register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Portfolio', 'tp-elements'),
			'singular_name'      => esc_html__( 'Portfolio', 'tp-elements'),
			'add_new'            => esc_html_x( 'Add New Portfolio', 'tp-elements'),
			'add_new_item'       => esc_html__( 'Add New Portfolio', 'tp-elements'),
			'edit_item'          => esc_html__( 'Edit Portfolio', 'tp-elements'),
			'new_item'           => esc_html__( 'New Portfolio', 'tp-elements'),
			'all_items'          => esc_html__( 'All Portfolio', 'tp-elements'),
			'view_item'          => esc_html__( 'View Portfolio', 'tp-elements'),
			'search_items'       => esc_html__( 'Search Portfolio', 'tp-elements'),
			'not_found'          => esc_html__( 'No Portfolio found', 'tp-elements'),
			'not_found_in_trash' => esc_html__( 'No Portfolio found in Trash', 'tp-elements'),
			'parent_item_colon'  => esc_html__( 'Parent Portfolio:', 'tp-elements'),
			'menu_name'          => esc_html__( 'Portfolio', 'tp-elements'),
		);
		global $cashora_option;
	   	$portfolio_slug = (!empty($cashora_option['portfolio_slug']))? $cashora_option['portfolio_slug'] :'tp-portfolio';
		$args = array(
			'labels'             => $labels,
			'public'             => true,	
			'show_in_menu'       => true,
			'show_in_admin_bar'  => true,
			'can_export'         => true,
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => 20,		
			'rewrite' => 		 array('slug' => $portfolio_slug,'with_front' => false),
			'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
			'supports'           => array( 'title', 'thumbnail','editor', 'excerpt'),	
		);
		register_post_type( 'tp-portfolios', $args );
	}

	function tp_create_portfolio_category() {
		
		register_taxonomy(
			'tp-portfolio-category',
			'tp-portfolios',
			array(
				'label' => esc_html__( 'Portfolio Categories','tp-elements'),			
				'hierarchical' => true,
				'show_admin_column' => true,
			)
		);
	}


}
new Pixelaxis_Project_Portfolio();