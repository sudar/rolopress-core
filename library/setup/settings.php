<?php
/**
 * Default Settings
 *
 * Modifies WordPress default settings so RoloPress works nice
 *
 * @package RoloPress
 * @subpackage Functions
 */
 
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
	wp_create_nav_menu('Main Menu', array('slug' => 'main-menu'));
}
add_action( 'init', 'rolopress_create_menus' );


/**
 * Add Default menu content
 *
 * Uses new menu system introduced in WordPress 3.0
 * @since 1.4
 */
function rolopress_add_default_menu_content(){ 
	$get_default_menu =  get_term_by( 'slug', 'main-menu','nav_menu');
	$menu_id = $get_default_menu->term_id;
	
	// Add Home link 
	$website_name = get_bloginfo('name');
	$website_url = get_bloginfo('siteurl');
	wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title' => $website_name,
			'menu-item-type' => 'custom',
			'menu-item-url' => $website_url,
			'menu-item-attr-title' => $website_name,
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
			'menu-item-title' => 'Contacts',
			'menu-item-type' => 'taxonomy',
			'menu-item-object' => 'type',
			'menu-item-attr-title' => 'Contacts',
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
			'menu-item-title' => 'Add Contact',
			'menu-item-type' => 'post_type',
			'menu-item-object' => 'page',
			'menu-item-attr-title' => 'Add Contact',
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
			'menu-item-title' => 'Companies',
			'menu-item-type' => 'taxonomy',
			'menu-item-object' => 'type',
			'menu-item-attr-title' => 'Companies',
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
			'menu-item-title' => 'Add Company',
			'menu-item-type' => 'post_type',
			'menu-item-object' => 'page',
			'menu-item-attr-title' => 'Add Company',
			'menu-item-classes' => 'add-companies icon-add',
			'menu-item-object-id' => $page_id,
			'menu-item-position' => 5,
			'menu-item-status' => 'publish'
		)
	);
}
add_action('init', 'rolopress_add_default_menu_content');



?>