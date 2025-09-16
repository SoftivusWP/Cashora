<?php

// Register Team Post Type
function pixelaxis_team_register_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Team', 'tp-elements'),
		'singular_name'      => esc_html__( 'Team', 'tp-elements'),
		'add_new'            => esc_html_x( 'Add New Team', 'tp-elements'),
		'add_new_item'       => esc_html__( 'Add New Team', 'tp-elements'),
		'edit_item'          => esc_html__( 'Edit Team', 'tp-elements'),
		'new_item'           => esc_html__( 'New Team', 'tp-elements'),
		'all_items'          => esc_html__( 'All Team', 'tp-elements'),
		'view_item'          => esc_html__( 'View Team', 'tp-elements'),
		'search_items'       => esc_html__( 'Search Teams', 'tp-elements'),
		'not_found'          => esc_html__( 'No Teams found', 'tp-elements'),
		'not_found_in_trash' => esc_html__( 'No Teams found in Trash', 'tp-elements'),
		'parent_item_colon'  => esc_html__( 'Parent Team:', 'tp-elements'),
		'menu_name'          => esc_html__( 'Teams', 'tp-elements'),
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
	register_post_type( 'teams', $args );
}
add_action( 'init', 'pixelaxis_team_register_post_type' );

function pixelaxis_tr_create_team() {
	
	register_taxonomy(
		'team-category',
		'teams',
		array(
			'label' => esc_html__( 'Team Categories','tp-elements'),			
			'hierarchical' => true,
			'show_admin_column' => true,		
		)
	);
}
add_action( 'init', 'pixelaxis_tr_create_team' );




// Meta Box
/*--------------------------------------------------------------
*			Member info
*-------------------------------------------------------------*/
function pixelaxis_pro_team_member_info_meta_box() {
	add_meta_box( 'member_info_meta', esc_html__( 'Member General Info', 'tp-elements'), 'pixelaxis_pro_team_member_info_meta_callback', 'teams', 'advanced', 'high', 1 );
}
add_action( 'add_meta_boxes', 'pixelaxis_pro_team_member_info_meta_box');
// member info callback
function pixelaxis_pro_team_member_info_meta_callback( $member_info ) {
	wp_nonce_field( 'member_social_metabox', 'member_social_metabox_nonce' ); ?>
		
	<div class="tp-admin-input"><label for="designation"><?php esc_html_e( 'Designation', 'tp-elements') ?></label>
	<?php $designation = get_post_meta( $member_info->ID, 'designation', true ); ?>
		<input type="text" name="designation" id="designation" class="designation" value="<?php echo esc_html($designation); ?>"/>
	</div> 
 
	<div  class="tp-admin-input"><label for="shortbio"><?php esc_html_e( 'Short Description', 'tp-elements') ?></label>
	<?php $shortbio = get_post_meta( $member_info->ID, 'shortbio', true ); ?>
	<textarea name="shortbio" id="shortbio" rows="4" cols="50"><?php echo esc_html($shortbio); ?></textarea>	
	</div> 



<?php }
/*--------------------------------------------------------------
* Member social links
*-------------------------------------------------------------*/
function pixelaxis_pro_team_member_social_link_meta_box() {
	add_meta_box( 'member_social_link_meta', esc_html__( 'Social Links', 'tp-elements'), 'pixelaxis_pro_team_social_meta_link_callback', 'teams', 'advanced', 'high', 2 );
}
add_action( 'add_meta_boxes', 'pixelaxis_pro_team_member_social_link_meta_box' );
// Social Meta Callback
function pixelaxis_pro_team_social_meta_link_callback( $social_meta ) {
	wp_nonce_field( 'member_social_metabox', 'member_social_metabox_nonce' ); ?>
	<!-- member social -->
	<div class="wrap-meta-group">
		<div class="tp-admin-input"><label for="facebook"><?php esc_html_e( 'Facebook', 'tp-elements') ?></label>
			<?php $facebook = get_post_meta( $social_meta->ID, 'facebook', true ); ?>
			<input type="text" name="facebook" id="facebook" class="facebook" value="<?php echo esc_html($facebook); ?>"/>
		</div>
		<div class="tp-admin-input"><label for="twitter"><?php esc_html_e(
					'Twitter', 'tp-elements') ?></label>
			<?php $twitter = get_post_meta( $social_meta->ID, 'twitter', true ); ?>
			<input type="text" name="twitter" id="twitter" class="twitter" value="<?php echo esc_html($twitter); ?>"/>
		</div>
		<div class="tp-admin-input"><label for="instagram"><?php esc_html_e( 'Instagram', 'tp-elements') ?></label>
			<?php $instagram = get_post_meta( $social_meta->ID, 'instagram', true ); ?>
			<input type="text" name="instagram" id="instagram" class="instagram" value="<?php echo esc_html($instagram); ?>"/>
		</div>
		<div class="tp-admin-input"><label for="linkedin"><?php esc_html_e( 'Linkedin', 'tp-elements') ?></label>
			<?php $linkedin= get_post_meta( $social_meta->ID, 'linkedin', true ); ?>
			<input type="text" name="linkedin" id="linkedin" class="linkedin" value="<?php echo esc_html($linkedin); ?>"/>
		</div>
	</div>
<?php }
/*--------------------------------------------------------------
 *			Save member social meta
*-------------------------------------------------------------*/
function save_tp_pro_team_member_social_meta( $post_id ) {
	if ( ! isset( $_POST['member_social_metabox_nonce'] ) ) {
		return $post_id;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if ( 'teams' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}
	$mymeta = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'designation', 'shortbio', );
	foreach ( $mymeta as $keys ) {
		if ( is_array( sanitize_text_field ($_POST[ $keys ]) ) ) {
			$data = array();
			foreach ( sanitize_text_field($_POST[ $keys ]) as $key => $value ) {
				$data[] = $value;
			}
		} else {
			$data = sanitize_text_field( $_POST[ $keys ] );
		}
		update_post_meta( $post_id, $keys, $data );
	}
}
add_action( 'save_post', 'save_tp_pro_team_member_social_meta' );