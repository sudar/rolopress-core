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
	add_submenu_page("options-general.php", __('Menu Options','rolopress'), __('Menu','rolopress'), 7, 'menu-settings-menu.php', 'rolo_default_menu_options');
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




?>