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
			'contact_sort_by' => 'Last Name',
			'contact_sort_order' => 'Ascending',
			'company_sort_by' => 'Name',
			'company_sort_order' => 'Ascending',
			'disable_rolosearch' => 'Use RoloSearch',
			'theme_version' => ROLOPRESS_CORE_THEME_VERSION // <-- no comma after the last option
	);
	return apply_filters('rolopress_main_settings_defaults', $defaults);
}

/**
 * Layout Settings: Register defaults
 */
function rolopress_layout_settings_defaults() {
	$defaults = array( // define our defaults
			'layout_option' => '3c-b-rw' // <-- no comma after the last option
	);
	return apply_filters('rolopress_layout_settings_defaults', $defaults);
}


/**
 * This registers all RoloPress settings field and adds defaults to the options table
 */
function rolopress_register_theme_settings() {
	register_setting(rolopress_main_options, rolopress_main_options);
	register_setting(rolopress_layout_options, rolopress_layout_options);
	
	add_option(rolopress_main_options, rolopress_main_settings_defaults(), '', 'yes');
	add_option(rolopress_layout_options, rolopress_layout_settings_defaults(), '', 'yes');
}
add_action('admin_init', 'rolopress_register_theme_settings', 5);


/**
 * Change permalink structure
 * @global object $wpdb, $wp_rewrite
 * @since 0.1
 */
function rolo_set_permalinks() {
	global $wpdb, $wp_rewrite;

	$permalink_structure = '/%postname%';
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
?>