<?php
/**
 * Admin Functions File
 *
 * Load admin theme functions
 *
 * @package RoloPress
 * @subpackage Functions
 */
 
 // Globals for menu pages
$themename = "RoloPress";
$shortname = "rolo";


 // Change to RoloPress branding
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-branding.php' );

 // Setup custom dashboard
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-dashboard.php' );

 // Setup overall menu system
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-setup-menus.php' );

 // Posts menu
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/menu-posts-edit.php' );

 // Contacts menu
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/menu-contacts-settings.php' );

 // Companies menu
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/menu-companies-settings.php' );

?>