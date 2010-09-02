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

// Posts menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-posts-edit.php' );

// Appearance menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-appearance-layout.php' );

// Settings menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-settings-print.php' );
require_once( ROLOPRESS_ADMIN_MENU . '/menu-settings-search.php' );

// Contacts menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-contacts-settings.php' );

// Companies menu
require_once( ROLOPRESS_ADMIN_MENU . '/menu-companies-settings.php' );


// only load if viewing admin
if (function_exists ('login_header') || is_admin()) { 
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-branding.php' ); // Change to RoloPress branding
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin-dashboard.php' ); // Setup custom dashboard
}


?>