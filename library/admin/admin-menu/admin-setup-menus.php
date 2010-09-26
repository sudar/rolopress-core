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

	/** Main RoloPress Menu **/
	add_menu_page(__('Dashboard','rolopress'), __('rolopress','rolopress'), 'manage_options', 'rolopress-main', 'rolopress_do_page', ROLOPRESS_IMAGES . 'admin/rolopress-icon-bk.gif)');
		
	/** Appearance Menu **/
	add_submenu_page("themes.php", __('Layout Options','rolopress'), __('Layout','rolopress'), 7, 'menu-appearance-layout.php', 'rolo_menu_layout');

}
add_action('admin_menu', 'rolo_add_admin_menu');

?>