<?php
/**
 * Functions File
 *
 * Define constants
 * Auto setup up custom fields and custom taxonomies
 * Auto create pages
 * Load theme functions
 * Load extensions
 *
 * @package RoloPress
 * @subpackage Functions
 */
 
// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'rolopress', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	
// Define theme version
define ( 'ROLOPRESS_VERSION', '1.5');

// Define constant paths
define( 'ROLOPRESS_DIR', TEMPLATEPATH );
define( 'ROLOPRESS_LIBRARY', ROLOPRESS_DIR . '/library' );
define( 'ROLOPRESS_EXTENSIONS', ROLOPRESS_LIBRARY . '/extensions' );
define( 'ROLOPRESS_FUNCTIONS', ROLOPRESS_LIBRARY . '/functions' );
define( 'ROLOPRESS_SETUP', ROLOPRESS_LIBRARY . '/setup' );
define( 'ROLOPRESS_WIDGETS', ROLOPRESS_LIBRARY . '/widgets' );
define( 'ROLOPRESS_INCLUDES', ROLOPRESS_LIBRARY . '/includes' );
define( 'ROLOPRESS_ADMIN_FUNCTIONS', ROLOPRESS_LIBRARY . '/admin' );

// Define constant paths (other file types)
$rolopress_dir = get_bloginfo( 'template_directory' );
define( 'ROLOPRESS_IMAGES', $rolopress_dir . '/library/images' );
define( 'ROLOPRESS_CSS', $rolopress_dir . '/library/styles' );
define( 'ROLOPRESS_CSS_LAYOUTS', ROLOPRESS_CSS . '/layouts' );
define( 'ROLOPRESS_CSS_PRINT', ROLOPRESS_CSS . '/print' );
define( 'ROLOPRESS_JS', $rolopress_dir . '/library/js' );

// Define child theme paths
define( 'ROLOPRESS_CHILD_DIR', get_stylesheet_directory() );
define( 'ROLOPRESS_CHILD_URL', get_stylesheet_directory_uri() );
define( 'ROLOPRESS_CHILD_CSS', get_stylesheet_directory_uri() . '/style.css' );

// Load compatability function
require_once( ROLOPRESS_FUNCTIONS . '/compat.php' );

// Load action hooks
require_once( ROLOPRESS_FUNCTIONS . '/hooks-actions.php' );

// Setup custom fields and custom taxonomies
require_once( ROLOPRESS_SETUP . '/setup-fields.php' );

// Run setup -- only when theme is activated
// @credits: http://www.nabble.com/Activation-hook-exist-for-themes--td25211004.html
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    require_once( ROLOPRESS_SETUP . '/add-pages.php' );
	require_once( ROLOPRESS_SETUP . '/settings.php' );
}

// Load RoloPress Admin functions
require_once( ROLOPRESS_ADMIN_FUNCTIONS . '/admin.php' );

// Load RoloPress Template functions
require_once( ROLOPRESS_FUNCTIONS . '/template-functions.php' );
require_once( ROLOPRESS_FUNCTIONS . '/contact-functions.php' );
require_once( ROLOPRESS_FUNCTIONS . '/company-functions.php' );
require_once( ROLOPRESS_FUNCTIONS . '/note-functions.php' );
require_once( ROLOPRESS_FUNCTIONS . '/dynamic-classes.php' );
require_once( ROLOPRESS_FUNCTIONS . '/messages.php' );
require_once( ROLOPRESS_FUNCTIONS . '/header-functions.php' );
require_once( ROLOPRESS_FUNCTIONS . '/content-functions.php' );

// Load widget areas and custom widgets
require_once( ROLOPRESS_FUNCTIONS . '/widgets.php' );

// Load extensions
$options = get_option('rolopress_main_options');
	
require_once( ROLOPRESS_EXTENSIONS . '/query-multiple-taxonomies/query-multiple-taxonomies.php' );
require_once( ROLOPRESS_EXTENSIONS . '/extended-admin-post-filter/extend-admin-post-filter.php' );
require_once( ROLOPRESS_EXTENSIONS . '/twitter-image.php' );
	
$rolosearch = $options[disable_rolosearch];
	if ( $rolosearch !== "Disable RoloSearch") {
		require_once( ROLOPRESS_EXTENSIONS . '/rolosearch/rolosearch.php' );
	}

// Load javascript - only if user has proper permissions
if ( current_user_can('edit_posts') ) {
	require_once( ROLOPRESS_INCLUDES . '/js-load.php' ); }

?>