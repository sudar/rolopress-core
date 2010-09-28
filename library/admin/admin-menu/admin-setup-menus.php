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
	add_menu_page(__('Dashboard','rolopress'), __('RoloPress','rolopress'), 'manage_options', 'rolopress-main', 'rolopress_do_page', ROLOPRESS_IMAGES . '/admin/rolopress-menu-icon.png');
		
	/** Appearance Menu **/
	add_submenu_page("rolopress-main", __('Layout Options','rolopress'), __('Layout','rolopress'), 7, 'menu-rolopress-layout.php', 'rolopress_do_layout_page');

}
add_action('admin_menu', 'rolo_add_admin_menu');

?>