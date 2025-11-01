<?php 
/** Added all post type
*/
class TP_Elements_Post_Type{
	public function __construct(){
		$this->load_post_type();
	}
	public function load_post_type(){		
		require plugin_dir_path( __FILE__ ). '/canvas-content.php';	
	}	
}
new TP_Elements_Post_Type();