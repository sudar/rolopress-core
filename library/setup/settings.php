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
 * This function registers the default values for Genesis theme settings
 */
function rolopress_settings_defaults() {
	$defaults = array( // define our defaults
			'update' => 1,
			'blog_title' => 'text',
			'header_right' => 0,
			'site_layout' => 'content-sidebar',
			'nav' => 1,
			'nav_superfish' => 1,
			'nav_home' => 1,
			'nav_type' => 'pages',
			'nav_pages_sort' => 'menu_order',
			'nav_categories_sort' => 'name',
			'nav_depth' => 0,
			'nav_extras_enable' => 0,
			'nav_extras' => 'date',
			'nav_extras_twitter_id' => '',
			'nav_extras_twitter_text' => 'Follow me on Twitter',
			'subnav' => 0,
			'subnav_superfish' => 1,
			'subnav_home' => 0,
			'subnav_type' => 'categories',
			'subnav_pages_sort' => 'menu_order',
			'subnav_categories_sort' => 'name',
			'subnav_depth' => 0,
			'comments_pages' => 0,
			'comments_posts' => 1,
			'trackbacks_pages' => 0,
			'trackbacks_posts' => 1,
			'author_box' => 1,
			'breadcrumb_home' => 1,
			'breadcrumb_single' => 1,
			'breadcrumb_page' => 1,
			'breadcrumb_archive' => 1,
			'content_archive' => 'full',
			'content_archive_thumbnail' => 0,
			'posts_nav' => 'older-newer',
			'blog_cat' => '',
			'blog_cat_exclude' => '',
			'blog_cat_num' => 10,
			'header_scripts' => '',
			'footer_scripts' => '',
			'theme_version' => PARENT_THEME_VERSION // <-- no comma after the last option
	);
	
	return apply_filters('rolopress_settings_defaults', $defaults);
}

/**
 * This registers the settings field and adds defaults to the options table
 */

function rolopress_register_theme_settings() {
	register_setting(ROLOPRESS_SETTINGS_FIELD, ROLOPRESS_SETTINGS_FIELD);
	add_option(ROLOPRESS_SETTINGS_FIELD, rolopress_settings_defaults(), '', 'yes');
}
add_action('admin_init', 'rolopress_register_theme_settings', 5);

/**
 * This is the notice that displays when you successfully save or reset
 * the theme settings.
 */
function rolopress_theme_settings_notice() {
	
	if ( !isset($_REQUEST['page']) || $_REQUEST['page'] != 'rolopress' )
		return;
	
	if ( rolopress_get_option('reset') ) {
		update_option(ROLOPRESS_SETTINGS_FIELD, rolopress_settings_defaults());
		echo '<div id="message" class="updated" id="message"><p><strong>'.__('Theme Settings Reset', 'rolopress').'</strong></p></div>';
	}
	elseif ( isset($_REQUEST['updated']) && $_REQUEST['updated'] == 'true') {  
		echo '<div id="message" class="updated" id="message"><p><strong>'.__('Theme Settings Saved', 'rolopress').'</strong></p></div>';
	}
	
}
add_action('admin_notices', 'rolopress_theme_settings_notice');






/********************************************
*********************************************
*********************************************/

















 
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