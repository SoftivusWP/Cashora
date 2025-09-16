<?php
define( 'TPElements__FILE__', __FILE__ );
define( 'TPElements_PLUGIN_BASE', plugin_basename( TPElements__FILE__ ) );
define( 'TPElements_URL', plugins_url( '/', TPElements__FILE__ ) );
define( 'TPElements_PATH', plugin_dir_path( TPElements__FILE__ ) );
define( 'TPElements_ASSETS_URL', TPElements_URL . 'includes/assets/' );

require_once( TPElements_PATH . 'includes/post-type.php' );
require_once( TPElements_PATH . 'includes/settings.php' );


class tpelements_pro_Elementor_Shortcode{

	function __construct(){
		add_action( 'manage_tpelements_pro_posts_custom_column' , array( $this, 'tpelements_pro_tp_global_templates_columns' ), 10, 2);
		add_filter( 'manage_tpelements_pro_posts_columns', array($this,'tpelements_pro_custom_edit_global_templates_posts_columns' ));		
	}

	function tpelements_pro_custom_edit_global_templates_posts_columns($columns) {		
		$columns['tppro_shortcode_column'] = esc_html__( 'Shortcode', 'tp-elements' );
		return $columns;
	}


	function tpelements_pro_tp_global_templates_columns( $column, $post_id ) {

		switch ( $column ) {

			case 'tppro_shortcode_column' :
				echo '<input type=\'text\' class=\'widefat\' value=\'[SHORTCODE_ELEMENTOR id="'.$post_id.'"]\' readonly="">';
				break;
		}
	}
	
}
new tpelements_pro_Elementor_Shortcode();