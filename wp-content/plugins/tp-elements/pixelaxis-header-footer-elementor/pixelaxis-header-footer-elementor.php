<?php

define( 'TPHFE_VER', '1.0.0' );
define( 'TPHFE_FILE', __FILE__ );
define( 'TPHFE_DIR', plugin_dir_path( __FILE__ ) );
define( 'TPHFE_URL', plugins_url( '/', __FILE__ ) );
define( 'TPHFE_PATH', plugin_basename( __FILE__ ) );
define( 'TPHFE_DOMAIN', trailingslashit( 'https://pixelaxis.net' ) );
define( 'TPHFE_DIR_URL_ADMIN', plugin_dir_url( __FILE__ ) );
define( 'TPHFE_ASSETS_ADMIN', trailingslashit( TPHFE_DIR_URL_ADMIN ) );

/**
 * Load the class loader.
 */
require_once TPHFE_DIR . '/inc/class-header-footer-elementor.php';

/**
 * Load the Plugin Class.
 */
function pixelaxis_header_footer_plugin_activation() {	
	update_option( 'pixelaxis_hfe_plugin_is_activated', 'yes' );
	update_option( 'tphfe_addon_option', $footer_widget );
}
register_activation_hook( TPHFE_FILE, 'pixelaxis_header_footer_plugin_activation' );

/**
 * Load the Plugin Class.
 */
function pixelaxis_header_footer_init() {
	Header_Footer_Elementor::instance();
}
add_action( 'plugins_loaded', 'pixelaxis_header_footer_init' );
