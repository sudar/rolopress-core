<?php
/**
 * Default Settings
 *
 * Sets RoloPress settings and modifies WordPress default settings so RoloPress works nice
 *
 * @package RoloPress
 * @subpackage Functions
 */

 
/**
 * Main Settings: Register defaults
 */
function rolopress_main_settings_defaults() {
	$defaults = array( // define our defaults
			'disable_rolosearch' => 'Use RoloSearch',
			'theme_version' => ROLOPRESS_VERSION // <-- no comma after the last option
	);
	return apply_filters('rolopress_main_settings_defaults', $defaults);
}

/**
 * Layout Settings: Register defaults
 */
function rolopress_layout_settings_defaults() {
	$defaults = array( // define our defaults
			'theme_layout' => '3c-b-rw' // <-- no comma after the last option
	);
	return apply_filters('rolopress_layout_settings_defaults', $defaults);
}

/**
 * Contact Settings: Register defaults
 */
function rolopress_contact_settings_defaults() {
	$defaults = array( // define our defaults
			'contact_sort_by' => 'Last Name',
			'contact_sort_order' => 'Ascending' // <-- no comma after the last option
	);
	return apply_filters('rolopress_contact_settings_defaults', $defaults);
}

/**
 * Company Settings: Register defaults
 */
function rolopress_company_settings_defaults() {
	$defaults = array( // define our defaults
			'company_sort_by' => 'Name',
			'company_sort_order' => 'Ascending' // <-- no comma after the last option
	);
	return apply_filters('rolopress_company_settings_defaults', $defaults);
}

/**
 * This registers all RoloPress settings fields, adds defaults to the options table and updates WordPress settings
 */
function rolopress_register_theme_settings() {
	register_setting(rolopress_main_options, rolopress_main_options);
	register_setting(rolopress_layout_options, rolopress_layout_options);
	register_setting(rolopress_contact_options, rolopress_layout_options);
	register_setting(rolopress_company_options, rolopress_layout_options);
	
	add_option(rolopress_main_options, rolopress_main_settings_defaults(), '', 'yes');
	add_option(rolopress_layout_options, rolopress_layout_settings_defaults(), '', 'yes');
	add_option(rolopress_contact_options, rolopress_contact_settings_defaults(), '', 'yes');
	add_option(rolopress_company_options, rolopress_company_settings_defaults(), '', 'yes');
	
	
	// UPDATE WORDPRESS SETTINGS
	
	// Settings - Discussions
	update_option( 'comment_order', 'desc' );			// sort notes by newest
	update_option( 'thread_comments', '1' );			// enable threaded notes
	update_option( 'thread_comments_depth', '5' );		// set threaded notes to 5 deep
	update_option( 'default_pingback_flag', '0' );		// don't ping
	update_option( 'default_ping_status', 'closed' );	// turn off pingbacks
	update_option( 'comment_whitelist', '0' );			// note author does not have to have another note approved
	
	// Update Settings - Privacy
	update_option( 'blog_public', '0' );				// make private
	
}
add_action('admin_init', 'rolopress_register_theme_settings', 5);


/**
 * Change permalink structure
 * @global object $wpdb, $wp_rewrite
 * @since 0.1
 */
function rolo_set_permalinks() {
	global $wpdb, $wp_rewrite;

	$permalink_structure = '/%post_id%-%postname%';
	$wp_rewrite->set_permalink_structure($permalink_structure);
	$wp_rewrite->flush_rules();
}
add_action('init', 'rolo_set_permalinks');

/**
 * Create Default Menus
 *
 * Uses new menu system introduced in WordPress 3.0
 * @since 1.4
 */
 function rolopress_create_menus() {

	// does our menu already exist?
	$mainmenu = wp_get_nav_menu_object( 'RoloPress Main' );

	// if the menu doesn't exist, let's create it
	if ( !$mainmenu ) {
	
		// first create menu
		wp_create_nav_menu('RoloPress Main', array('slug' => 'rolopress-main'));
		
		// then add the menu items
		$get_default_menu =  get_term_by( 'slug', 'rolopress-main','nav_menu');
		$menu_id = $get_default_menu->term_id;
	
			// Add Home link 
			$website_name = get_bloginfo('name');
			$website_url = get_bloginfo('siteurl');
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title' => __($website_name,'rolopress'),
					'menu-item-type' => 'custom',
					'menu-item-url' => $website_url,
					'menu-item-attr-title' => __($website_name,'rolopress'),
					'menu-item-classes' => 'home',
					'menu-item-position' => 1,
					'menu-item-status' => 'publish'
				)
			);
	
			// Add "Contacts" taxonomy archive 
			$term = get_term_by( 'slug', 'contact', 'type');
			$term_id = $term->term_id; 
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title' => __('Contacts','rolopress'),
					'menu-item-type' => 'taxonomy',
					'menu-item-object' => 'type',
					'menu-item-attr-title' => __('Contacts','rolopress'),
					'menu-item-classes' => 'contacts',
					'menu-item-object-id' => $term_id,
					'menu-item-position' => 2,
					'menu-item-status' => 'publish'
				)
			);
 
			// Add "Add Contact" page
			$page = get_page_by_title('Add Contact');
			$page_id = $page->ID; 
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title' => __('Add Contact','rolopress'),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-attr-title' => __('Add Contact','rolopress'),
					'menu-item-classes' => 'add-contacts icon-add',
					'menu-item-object-id' => $page_id,
					'menu-item-position' => 3,
					'menu-item-status' => 'publish'
				)
			);
	
			// Add "Company" taxonomy archive
			$term = get_term_by( 'slug', 'company', 'type');
			$term_id = $term->term_id; 
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title' => __('Companies','rolopress'),
					'menu-item-type' => 'taxonomy',
					'menu-item-object' => 'type',
					'menu-item-attr-title' => __('Companies','rolopress'),
					'menu-item-classes' => 'companies',
					'menu-item-object-id' => $term_id,
					'menu-item-position' => 4,
					'menu-item-status' => 'publish'
				)
			);

			// Add "Add Company" page
			$page = get_page_by_title('Add Company');
			$page_id = $page->ID; 
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title' => __('Add Company','rolopress'),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-attr-title' => __('Add Company','rolopress'),
					'menu-item-classes' => 'add-companies icon-add',
					'menu-item-object-id' => $page_id,
					'menu-item-position' => 5,
					'menu-item-status' => 'publish'
				)
			);
	}
}
add_action('init', 'rolopress_create_menus');

/**
 * Upgrade option from v1.4 to v1.5
 *
 * Changed to WP settings api in 1.5
 *
 * @param string $old_option - Old Option name
 * @param string $new_option - new Option name
 * @param string $new_option_key - new option key name
 * 
 * Since v1.5
 */
function upgrade_option($old_option, $new_option, $new_option_key) {
    $old_value = get_option($old_option);
    if ($old_value != false) {
        $new_value = get_option($new_option);
        $new_value = ($new_value == false) ? array() : $new_value;

        $new_value[$new_option_key] = $old_value;
        update_option($new_option, $new_value);
    }
}


/* Old -> New options
 *
 */
upgrade_option('rolo_disable_rolosearch', 'rolopress_main_options', 'disable_rolosearch');
upgrade_option('rolo_print_primary', 'rolopress_main_options', 'print_primary');
upgrade_option('rolo_print_secondary', 'rolopress_main_options', 'print_secondary');
upgrade_option('rolo_print_contact_under_main', 'rolopress_main_options', 'print_contact_under_main');
upgrade_option('rolo_print_company_under_main', 'rolopress_main_options', 'print_company_under_main');
upgrade_option('rolo_layout_setting', 'rolopress_layout_options', 'theme_layout');
upgrade_option('rolo_contact_sort_by', 'rolopress_contact_options', 'contact_sort_by');
upgrade_option('rolo_contact_sort_order', 'rolopress_contact_options', 'contact_sort_order');
upgrade_option('rolo_company_sort_by', 'rolopress_company_options', 'company_sort_by');
upgrade_option('rolo_company_sort_order', 'rolopress_company_options', 'company_sort_order');
?>