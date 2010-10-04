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

// Define constant paths
define( 'ROLOPRESS_ADMIN_MENU', ROLOPRESS_ADMIN_FUNCTIONS . '/admin-menu' );


// Setup overall menu system
require_once( ROLOPRESS_ADMIN_MENU . '/admin-setup-menus.php' );

// Load Main RoloPress menu
require_once ROLOPRESS_ADMIN_MENU . '/menu-rolopress-main.php';

// Load sub menu's
require_once( ROLOPRESS_ADMIN_MENU . '/menu-rolopress-layout.php' );
require_once( ROLOPRESS_ADMIN_MENU . '/menu-rolopress-contact.php' );
require_once( ROLOPRESS_ADMIN_MENU . '/menu-rolopress-company.php' );

// Load Posts menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-posts-edit.php' );


// only load if viewing admin
if (function_exists ('login_header') || is_admin()) { 
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-branding.php' ); // Change to RoloPress branding
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-dashboard.php' ); // Setup custom dashboard
}


?>