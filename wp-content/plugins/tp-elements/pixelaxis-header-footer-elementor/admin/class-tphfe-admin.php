<?php
use HFE\Lib\TPHF_Target_Rules_Fields;

defined( 'ABSPATH' ) or exit;

/**
 * HFE_Admin setup
 *
 * @since 1.0.0
 */
class HFE_Admin {

	/**
	 * Instance of HFE_Admin
	 */
	private static $_instance = null;

	/**
	 * Instance of HFE_Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		add_action( 'elementor/init', __CLASS__ . '::load_admin', 0 );

		return self::$_instance;
	}

	/**
	 * Load the icons style in editor.
	 *
	 * @since 1.3.0
	 */
	public static function load_admin() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::hfe_admin_enqueue_scripts' );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.3.0
	 * @param string $hook Current page hook.
	 * @access public
	 */
	public static function hfe_admin_enqueue_scripts( $hook ) {

		// Register the icons styles.
		wp_register_style(
			'hfe-style',
			TPHFE_URL . 'assets/css/style.css',
			[],
			TPHFE_VER
		);

		wp_enqueue_style( 'hfe-style' );
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'header_footer_posttype' ] );	
		add_action( 'admin_enqueue_scripts', array( $this, 'tphfe_admin_scripts' ) );
		add_action( 'add_meta_boxes', [ $this, 'ehf_register_metabox' ] );
		add_action( 'save_post', [ $this, 'ehf_save_meta' ] );
		add_action( 'admin_notices', [ $this, 'location_notice' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_filter( 'manage_elementor-hf_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_elementor-hf_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );

		if ( is_admin() ) {
			add_action( 'manage_elementor-hf_posts_custom_column', [ $this, 'column_content' ], 10, 2 );
			add_filter( 'manage_elementor-hf_posts_columns', [ $this, 'column_headings' ] );
			require_once TPHFE_DIR . 'admin/class-hfe-addons-actions.php';
		}

		add_action( 'admin_init', array( $this, 'tphfe_page_init' ) );
	}

	/**
	 * Admin Style
	 */
	public function tphfe_admin_scripts(){
        wp_register_style('tphfe-admin-styles', TPHFE_ASSETS_ADMIN . 'admin/assets/css/ehf-admin.css', array(), null );
        wp_enqueue_style('tphfe-admin-styles');
    }

	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['elementor_hf_display_rules'] = __( 'Display Rules', 'pixelaxis-header-footer-elementor' );
		$columns['date']                       = __( 'Date', 'pixelaxis-header-footer-elementor' );

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @param array $column Name of column.
	 * @param int   $post_id Post id.
	 * @return void
	 */
	public function column_content( $column, $post_id ) {

		if ( 'elementor_hf_display_rules' == $column ) {

			$locations = get_post_meta( $post_id, 'ehf_target_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'ehf_target_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headers-exclusion-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'ehf_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = [];
					foreach ( $users as $user ) {
						$user_label[] = TPHF_Target_Rules_Fields::get_user_by_key( $user );
					}
					echo '<div class="ast-advanced-headers-users-wrap">';
					echo '<strong>Users: </strong>';
					echo join( ', ', $user_label );
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = [];
		$index          = array_search( 'specifics', $locations['rule'] );
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = TPHF_Target_Rules_Fields::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = TPHF_Target_Rules_Fields::get_location_by_key( $location );
			}
		}

		echo join( ', ', $location_label );
	}


	/**
	 * Register Post type for Elementor Header & Footer Builder templates
	 */
	public function header_footer_posttype() {
		$labels = [
			'name'               => __( 'TP Header & Footer Builder', 'pixelaxis-header-footer-elementor' ),
			'singular_name'      => __( 'TP Header & Footer Builder', 'pixelaxis-header-footer-elementor' ),
			'menu_name'          => __( 'TP Header & Footer Builder', 'pixelaxis-header-footer-elementor' ),
			'name_admin_bar'     => __( 'TP Header & Footer Builder', 'pixelaxis-header-footer-elementor' ),
			'add_new'            => __( 'Add New', 'pixelaxis-header-footer-elementor' ),
			'add_new_item'       => __( 'Add New Header or Footer', 'pixelaxis-header-footer-elementor' ),
			'new_item'           => __( 'New Header Footer', 'pixelaxis-header-footer-elementor' ),
			'edit_item'          => __( 'Edit Header Footer', 'pixelaxis-header-footer-elementor' ),
			'view_item'          => __( 'View Header Footer', 'pixelaxis-header-footer-elementor' ),
			'all_items'          => __( 'All Header Footer', 'pixelaxis-header-footer-elementor' ),
			'search_items'       => __( 'Search Templates', 'pixelaxis-header-footer-elementor' ),
			'parent_item_colon'  => __( 'Parent Templates:', 'pixelaxis-header-footer-elementor' ),
			'not_found'          => __( 'No Templates found.', 'pixelaxis-header-footer-elementor' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'pixelaxis-header-footer-elementor' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'elementor' ],
		];
		register_post_type( 'elementor-hf', $args );
	}

	/**
	 * Register the admin menu
	 *
	 * @since  1.0.0
	 */
	
	

	/**
	 * 
	 */
	public function tphfe_page_init(){
        register_setting(
            'tphfe_addon_group',
            'tphfe_addon_option',
            array( $this, 'tpelements_sanitize' )
        );

        add_settings_section(
            'tphfe_section_field_id',
            esc_html__( 'Deactivate elements for better performance', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tpelements_section_info' ),
            'tphfe-addon-field'
        );

        /**
         * Copyright
         */
        add_settings_field(
            'tphfe_copyright',
            esc_html__( 'TP Copyright', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_copyright_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Header Button
         */
        add_settings_field(
            'tphfe_header_button',
            esc_html__( 'TP Header Button', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_header_button_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Navigation Menu
         */
        add_settings_field(
            'tphfe_navigation_menu',
            esc_html__( 'TP Navigation Menu', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_navigation_menu_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Site Logo
         */
        add_settings_field(
            'tphfe_site_logo',
            esc_html__( 'TP Site Logo', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_site_logo_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Page Title
         */
        add_settings_field(
            'tphfe_page_title',
            esc_html__( 'TP Page Title', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_page_title_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Search
         */
        add_settings_field(
            'tphfe_search',
            esc_html__( 'TP Search', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_search_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Search
         */
        add_settings_field(
            'tphfe_meta',
            esc_html__( 'TP Meta', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_meta_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

		/**
         * RS Cart
         */
        add_settings_field(
            'tphfe_cart',
            esc_html__( 'TP Cart', 'pixelaxis-header-footer-elementor' ),
            array( $this, 'tphfe_cart_block' ),
            'tphfe-addon-field',
            'tphfe_section_field_id',
            array( 'class' => 'tpelements_addon_field' )
        );

	}

	/**
     * Print the Section text
     */
    public function tpelements_section_info() {
        //print 'Enter your settings below:';
    }

	 /**
     * Copyright
     */
    public function tphfe_copyright_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_copyright]" id="tphfe_copyright" value="tphfe_copyright" %s/>',
                (isset( $this->tphfe_options['tphfe_copyright']) && $this->tphfe_options['tphfe_copyright'] ) == 'tphfe_copyright' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_copyright"></label>
        </div>
        <?php
    }

	/**
     * Copyright
     */
    public function tphfe_header_button_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_header_button]" id="tphfe_header_button" value="tphfe_header_button" %s/>',
                (isset( $this->tphfe_options['tphfe_header_button']) && $this->tphfe_options['tphfe_header_button'] ) == 'tphfe_header_button' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_header_button"></label>
        </div>
        <?php
    }

	/**
     * Navigation Menu
     */
    public function tphfe_navigation_menu_block() {
        ?>
        <div class="checkbox">
            <?php
			$this->tphfe_options = get_option('tphfe_addon_option');
			
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_navigation_menu]" id="tphfe_navigation_menu" value="tphfe_navigation_menu" %s/>',
			(isset( $this->tphfe_options['tphfe_site_logo']) && $this->tphfe_options['tphfe_navigation_menu'] ) == 'tphfe_navigation_menu' ? 'checked' : ''
		);
            ?>
            <label for="tphfe_navigation_menu"></label>
        </div>
        <?php
    }

	/**
     * Site Logo
     */
    public function tphfe_site_logo_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_site_logo]" id="tphfe_site_logo" value="tphfe_site_logo" %s/>',
                (isset( $this->tphfe_options['tphfe_site_logo']) && $this->tphfe_options['tphfe_site_logo'] ) == 'tphfe_site_logo' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_site_logo"></label>
        </div>
        <?php
    }

	/**
     * Page Title
     */
    public function tphfe_page_title_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_page_title]" id="tphfe_page_title" value="tphfe_page_title" %s/>',
                (isset( $this->tphfe_options['tphfe_page_title']) && $this->tphfe_options['tphfe_page_title'] ) == 'tphfe_page_title' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_page_title"></label>
        </div>
        <?php
    }

	/**
     * Search
     */
    public function tphfe_search_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_search]" id="tphfe_search" value="tphfe_search" %s/>',
                (isset( $this->tphfe_options['tphfe_search']) && $this->tphfe_options['tphfe_search'] ) == 'tphfe_search' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_search"></label>
        </div>
        <?php
    }

	/**
     * Meta
     */
    public function tphfe_meta_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_meta]" id="tphfe_meta" value="tphfe_meta" %s/>',
                (isset( $this->tphfe_options['tphfe_meta']) && $this->tphfe_options['tphfe_meta'] ) == 'tphfe_meta' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_meta"></label>
        </div>
        <?php
    }
	
	/**
     * Meta
     */
    public function tphfe_cart_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="tphfe_addon_option[tphfe_cart]" id="tphfe_cart" value="tphfe_cart" %s/>',
                (isset( $this->tphfe_options['tphfe_cart']) && $this->tphfe_options['tphfe_cart'] ) == 'tphfe_cart' ? 'checked' : ''
            );
            ?>
            <label for="tphfe_cart"></label>
        </div>
        <?php
    }

	/**
	 * Register meta box(es).
	 */
	function ehf_register_metabox() {
		add_meta_box(
			'ehf-meta-box',
			__( 'TP Header & Footer Builder Options', 'pixelaxis-header-footer-elementor' ),
			[
				$this,
				'efh_metabox_render',
			],
			'elementor-hf',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function efh_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['ehf_template_type'] ) ? esc_attr( $values['ehf_template_type'][0] ) : '';
		$display_on_canvas = isset( $values['display-on-canvas-template'] ) ? true : false;

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'ehf_meta_nounce', 'ehf_meta_nounce' );
		?>
		<table class="hfe-options-table widefat">
			<tbody>
				<tr class="hfe-options-row type-of-template">
					<td class="hfe-options-row-heading">
						<label for="ehf_template_type"><?php _e( 'Type of Template', 'pixelaxis-header-footer-elementor' ); ?></label>
					</td>
					<td class="hfe-options-row-content">
						<select name="ehf_template_type" id="ehf_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Option', 'pixelaxis-header-footer-elementor' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php _e( 'Header', 'pixelaxis-header-footer-elementor' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php _e( 'Before Footer', 'pixelaxis-header-footer-elementor' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php _e( 'Footer', 'pixelaxis-header-footer-elementor' ); ?></option>
						</select>
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
				<tr class="hfe-options-row hfe-shortcode">
					<td class="hfe-options-row-heading">
						<label for="ehf_template_type"><?php _e( 'Shortcode', 'pixelaxis-header-footer-elementor' ); ?></label>
						<i class="hfe-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Copy this shortcode and paste it into your post, page, or text widget content.', 'pixelaxis-header-footer-elementor' ); ?>">
						</i>
					</td>
					<td class="hfe-options-row-content">
						<span class="hfe-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[tphfe_template id='<?php echo esc_attr( $post->ID ); ?>']" class="hfe-large-text code">
						</span>
					</td>
				</tr>
				<tr class="hfe-options-row enable-for-canvas">
					<td class="hfe-options-row-heading">
						<label for="display-on-canvas-template">
							<?php _e( 'Enable Layout for Elementor Canvas Template?', 'pixelaxis-header-footer-elementor' ); ?>
						</label>
						<i class="hfe-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Enabling this option will display this layout on pages using Elementor Canvas Template.', 'pixelaxis-header-footer-elementor' ); ?>"></i>
					</td>
					<td class="hfe-options-row-content">
						<input type="checkbox" id="display-on-canvas-template" name="display-on-canvas-template" value="1" <?php checked( $display_on_canvas, true ); ?> />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 *
	 * @since  1.0.0
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		TPHF_Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'ehf_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'ehf_target_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'ehf_target_user_roles', true );
		?>
		<tr class="bsf-target-rules-row hfe-options-row">
			<td class="bsf-target-rules-row-heading hfe-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'pixelaxis-header-footer-elementor' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should appear.', 'pixelaxis-header-footer-elementor' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content hfe-options-row-content">
				<?php
				TPHF_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-location',
					[
						'title'          => __( 'Display Rules', 'pixelaxis-header-footer-elementor' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'pixelaxis-header-footer-elementor' ),
					],
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row hfe-options-row">
			<td class="bsf-target-rules-row-heading hfe-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'pixelaxis-header-footer-elementor' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should not appear.', 'pixelaxis-header-footer-elementor' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content hfe-options-row-content">
				<?php
				TPHF_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-exclusion',
					[
						'title'          => __( 'Exclude On', 'pixelaxis-header-footer-elementor' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'pixelaxis-header-footer-elementor' ),
						'rule_type'      => 'exclude',
					],
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row hfe-options-row">
			<td class="bsf-target-rules-row-heading hfe-options-row-heading">
				<label><?php esc_html_e( 'User Roles', 'pixelaxis-header-footer-elementor' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Display custom template based on user role.', 'pixelaxis-header-footer-elementor' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content hfe-options-row-content">
				<?php
				TPHF_Target_Rules_Fields::target_user_role_settings_field(
					'bsf-target-rules-users',
					[
						'title'          => __( 'Users', 'pixelaxis-header-footer-elementor' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add User Rule', 'pixelaxis-header-footer-elementor' ),
					],
					$users
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function ehf_save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ehf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ehf_meta_nounce'], 'ehf_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = TPHF_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-location' );
		$target_exclusion = TPHF_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-exclusion' );
		$target_users     = [];

		if ( isset( $_POST['bsf-target-rules-users'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['bsf-target-rules-users'] );
		}

		update_post_meta( $post_id, 'ehf_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'ehf_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'ehf_target_user_roles', $target_users );

		if ( isset( $_POST['ehf_template_type'] ) ) {
			update_post_meta( $post_id, 'ehf_template_type', esc_attr( $_POST['ehf_template_type'] ) );
		}

		if ( isset( $_POST['display-on-canvas-template'] ) ) {
			update_post_meta( $post_id, 'display-on-canvas-template', esc_attr( $_POST['display-on-canvas-template'] ) );
		} else {
			delete_post_meta( $post_id, 'display-on-canvas-template' );
		}
	}

	/**
	 * Display notice when editing the header or footer when there is one more of similar layout is active on the site.
	 *
	 * @since 1.0.0
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'elementor-hf' != $post->post_type ) {
			return;
		}

		$template_type = get_post_meta( $post->ID, 'ehf_template_type', true );

		if ( '' !== $template_type ) {
			$templates = Header_Footer_Elementor::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID != $templates[0] ) {
				$post_title        = '<strong>' . get_the_title( $templates[0] ) . '</strong>';
				$template_location = '<strong>' . $this->template_location( $template_type ) . '</strong>';
				/* Translators: Post title, Template Location */
				$message = sprintf( __( 'Template %1$s is already assigned to the location %2$s', 'pixelaxis-header-footer-elementor' ), $post_title, $template_location );

				echo '<div class="error"><p>';
				echo $message;
				echo '</p></div>';
			}
		}
	}

	/**
	 * Convert the Template name to be added in the notice.
	 *
	 * @since  1.0.0
	 *
	 * @param  String $template_type Template type name.
	 *
	 * @return String $template_type Template type name.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( str_replace( 'type_', '', $template_type ) );

		return $template_type;
	}

	/**
	 * Don't display the elementor Elementor Header & Footer Builder templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'elementor-hf' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @since  1.0.1
	 *
	 * @param  String $single_template Single template.
	 */
	function load_canvas_template( $single_template ) {
		global $post;

		if ( 'elementor-hf' == $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'pixelaxis-header-footer-elementor' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="hfe-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[tphfe_template id='<?php echo esc_attr( $post_id ); ?>']" class="hfe-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

HFE_Admin::instance();
