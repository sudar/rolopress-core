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
	add_submenu_page("themes.php", 'Layout Options', 'Layout', 7, 'menu-appearance-layout.php', 'rolo_menu_layout');
 
 
 /** Contacts Menu **/
	// Add a new top-level menu:
	add_menu_page('Contacts', 'Contacts', 7, "menu-contacts-settings.php", 'rolo_menu_contacts', ROLOPRESS_IMAGES . '/admin/menu-contact.png');

	// Add sub:
	add_submenu_page("menu-contacts-settings.php", 'Contact Settings', 'Settings', 7, 'menu-contacts-settings.php', 'rolo_menu_contacts');

	
 /** Companies Menu **/
	// Add a new top-level menu:
	add_menu_page('Companies', 'Companies', 7, "menu-companies-settings.php", 'rolo_menu_companies', ROLOPRESS_IMAGES . '/admin/menu-company.png');

	// Add sub:
	add_submenu_page("menu-companies-settings.php", 'Company Settings', 'Settings', 7, 'menu-companies-settings.php', 'rolo_menu_companies');
	

}
add_action('admin_menu', 'rolo_add_admin_menu');




?>