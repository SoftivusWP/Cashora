<?php
function tpelements_pro_shortcode_register_post_type() {
    $labels = array(
        'name'               => esc_html__( 'TP Global Shortcodes', 'tp-elements'),
        'singular_name'      => esc_html__( 'Elementor Shortcodes', 'tp-elements'),
        'add_new'            => esc_html_x( 'Add New Shorcode', 'tp-elements'),
        'add_new_item'       => esc_html__( 'Add New Shorcode', 'tp-elements'),
        'edit_item'          => esc_html__( 'Edit Element', 'tp-elements'),
        'new_item'           => esc_html__( 'New Shortcode', 'tp-elements'),
        'all_items'          => esc_html__( 'All Shorcodes', 'tp-elements'),
        'view_item'          => esc_html__( 'View Elements', 'tp-elements'),    
        'not_found'          => esc_html__( 'No Elements found', 'tp-elements'),
        'not_found_in_trash' => esc_html__( 'No Elements found in Trash', 'tp-elements'),
        'parent_item_colon'  => esc_html__( 'Parent Team:', 'tp-elements'),
        'menu_name'          => esc_html__( 'TP Shorcode', 'tp-elements'),
    );  
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'can_export'         => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,     
        'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
        'supports'           => array( 'title', 'thumbnail', 'editor', 'page-attributes' )
    );
    register_post_type( 'tpelements_pro', $args );
}
add_action( 'init', 'tpelements_pro_shortcode_register_post_type' );



function tpelements_pro_add_meta_box(){
    add_meta_box('tp-shortcode-box','Elements Shortcode','tpelemetns_pro_shortcode_box','tpelements_pro','side','high');
}
add_action("add_meta_boxes", "tpelements_pro_add_meta_box");


function tpelemetns_pro_shortcode_box($post){
    ?>
    <h4><?php echo esc_html__('Shortcode','tp-elements');?></h4>
    <input type='text' class='widefat' value='[SHORTCODE_ELEMENTOR id="<?php echo esc_attr($post->ID); ?>"]' readonly="">

     <h4><?php echo esc_html('PHP Code','tp-elements');?></h4>
    <input type='text' class='widefat' value="&lt;?php echo do_shortcode('[SHORTCODE_ELEMENTOR id=&quot;<?php echo esc_attr($post->ID); ?>&quot;]'); ?&gt;" readonly="">
    <?php
}