<?php
/**
 * Setup overall menu system
 *
 * Calls individual admin pages
 *
 * @package RoloPress
 * @subpackage Functions
 */
 


function rolo_add_admin_menu() { // adds all top level and sub menus
  
  /** Appearance Menu **/
	add_submenu_page("themes.php", __('Layout Options','rolopress'), __('Layout','rolopress'), 7, 'menu-appearance-layout.php', 'rolo_menu_layout');
	
  /** Settings Menu **/
	add_submenu_page("options-general.php", __('Print Options','rolopress'), __('Printing','rolopress'), 7, 'menu-settings-print.php', 'rolo_print_options');
	add_submenu_page("options-general.php", __('Search Options','rolopress'), __('Search','rolopress'), 7, 'menu-settings-search.php', 'rolo_search_options');
 
 /** Contacts Menu **/
	// Add a new top-level menu:
	add_menu_page(__('Contacts','rolopress'), __('Contacts','rolopress'), 7, "menu-contacts-settings.php", 'rolo_menu_contacts', ROLOPRESS_IMAGES . '/admin/menu-contact.png');

	// Add sub:
	add_submenu_page("menu-contacts-settings.php", __('Contact Settings','rolopress'), __('Settings','rolopress'), 7, 'menu-contacts-settings.php', 'rolo_menu_contacts');

	
 /** Companies Menu **/
	// Add a new top-level menu:
	add_menu_page(__('Companies','rolopress'), __('Companies','rolopress'), 7, "menu-companies-settings.php", 'rolo_menu_companies', ROLOPRESS_IMAGES . '/admin/menu-company.png');

	// Add sub:
	add_submenu_page("menu-companies-settings.php", __('Company Settings','rolopress'), __('Settings','rolopress'), 7, 'menu-companies-settings.php', 'rolo_menu_companies');
	

}
add_action('admin_menu', 'rolo_add_admin_menu');













/**
 * Setup RoloPress section in admin
 */
function rolopress_setup_dashboard() {
	
		require_once ROLOPRESS_ADMIN_MENU . '/rolopress-admin-settings.php';
		//require_once ROLOPRESS_ADMIN_MENU . '/rolopress-main-menu.php';
		add_menu_page(__('Dashboard','rolopress'), __('rolopress','rolopress'), 'manage_options', 'rolopress-main', 'rolopress_do_page', ROLOPRESS_IMAGES . 'admin/rolopress-icon-bk.gif)');
		
};
add_action('admin_menu', 'rolopress_setup_dashboard');




?>