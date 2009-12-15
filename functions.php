<?php

/* Functions File
 *
 * Loads theme functions
 * Defines constants
 *
 * @package RoloPress
 * @subpackage Functions
 */

/* Load theme textdomain. 
	load_theme_textdomain( 'rolopress' );*/

/* Define constant paths (PHP files). 
	define( ROLOPRESS_DIR, TEMPLATEPATH );
	define( ROLOPRESS_LIBRARY, ROLOPRESS_DIR . '/library' );
	define( ROLOPRESS_ADMIN, ROLOPRESS_LIBRARY . '/admin' );
	define( ROLOPRESS_EXTENSIONS, ROLOPRESS_LIBRARY . '/extensions' );
	define( ROLOPRESS_FUNCTIONS, ROLOPRESS_LIBRARY . '/functions' );
	define( ROLOPRESS_LEGACY, ROLOPRESS_LIBRARY . '/legacy' );
	define( ROLOPRESS_WIDGETS, ROLOPRESS_LIBRARY . '/widgets' );*/

/* Define constant paths (other file types). 
	$hybrid_dir = get_bloginfo( 'template_directory' );
	define( ROLOPRESS_IMAGES, $hybrid_dir . '/library/images' );
	define( ROLOPRESS_CSS, $hybrid_dir . '/library/css' );
	define( ROLOPRESS_JS, $hybrid_dir . '/library/js' );*/

/* Define child theme paths. 
	define( ROLOPRESS_CHILD_DIR, get_stylesheet_directory() );
	define( ROLOPRESS_CHILD_URL, get_stylesheet_directory_uri() );*/

/* Load theme action and filter hooks 
	require_once( ROLOPRESS_FUNCTIONS . '/hooks-actions.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/hooks-filters.php' );*/

/* Load theme functions. 
	require_once( ROLOPRESS_FUNCTIONS . '/comments.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/dynamic-classes.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/framework.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/media.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/shortcodes.php' );*/

/* Load extensions (external projects). 
	require_once( ROLOPRESS_EXTENSIONS . '/breadcrumb-trail.php' );
	require_once( ROLOPRESS_EXTENSIONS . '/custom-field-series.php' );
	require_once( ROLOPRESS_EXTENSIONS . '/get-the-image.php' );
	require_once( ROLOPRESS_EXTENSIONS . '/get-the-object.php' );*/

/* Load widgets and widget functions. 
	require_once( ROLOPRESS_FUNCTIONS . '/widgets.php' );*/

/* Load legacy functions for backwards compatibility. 
	require_once( ROLOPRESS_LEGACY . '/deprecated.php' );*/

/* Load admin files. */
	if ( is_admin() ) :
		require_once( ROLOPRESS_ADMIN . '/theme-settings.php' );
		require_once( ROLOPRESS_ADMIN . '/meta-box.php' );
	endif;

/* Get theme settings. */
	$hybrid_settings = get_option( 'hybrid_theme_settings' );
	

//change admin section to RoloPress style
require_once( 'library/functions/admin.php' );

//load RoloSearch
require_once( 'library/extensions/rolosearch/rolosearch.php' );

//load Multiple Taxonomy Query
require_once( 'library/extensions/query-multiple-taxonomies/query-multiple-taxonomies.php' );

//Auto create pages
require_once( 'library/setup/add-pages.php' );

//Auto create custom fields
require_once( 'library/setup/setup-fields.php' );

//load hooks and filters
require_once( 'library/functions/hooks-filters.php' );

//load widget areas
require_once( 'library/functions/widgets.php' );

//load dynamic classes
require_once( 'library/functions/dynamic-classes.php' );

//load Template functions
require_once( 'library/functions/template-functions.php' );

//load contact functions
require_once( 'library/functions/contact-functions.php' );

//load company functions
require_once( 'library/functions/company-functions.php' );

//load note functions
require_once( 'library/functions/note-functions.php' );


// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'rolopress', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);



/**
 * Add JavaScript to the theme on needed pages and only if user has proper permissions
 */
	function rolo_add_script() {
    //TODO: Need to include JS only in required pages.
    
//    if (is_page(array('Add Contact','Add Company', 'Edit Company', 'Edit Contact'))) {
        wp_enqueue_script( 'uni-form', get_bloginfo('template_directory') . '/library/js/uni-form.jquery.js', array('jquery'), '', true );
        wp_enqueue_script( 'rolopress-js', get_bloginfo('template_directory') . '/library/js/rolopress.js', array('jquery', 'uni-form'), '', true );
        // Build in tag auto complete script - Code explanation at http://bit.ly/2vbemR
        wp_enqueue_script( 'suggest' );
//    }
    wp_enqueue_script( 'jeip', get_bloginfo('template_directory') . '/library/js/jeip.js', array('jquery'), '', true );
	}
	
if ( current_user_can('edit_posts') ) { add_action('template_redirect', 'rolo_add_script'); } // only load if user has proper permissions 


// This is a dirty way to get the path in js. TODO: need to have a proper way to fix it.
add_action('wp_footer', 'rolo_print_script');

function rolo_print_script() {
$wpurl = get_bloginfo('wpurl');
$ajax_url = admin_url("admin-ajax.php");

echo <<<SCRIPT
<script>
var wpurl = "$wpurl";
var ajax_url = '$ajax_url';
</script>
SCRIPT;

}
/**
 * Add JavaScript to the theme on needed notes (comments) pages
 */
function theme_queue_js() {
    if (!is_admin()) {
        if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script( 'comment-reply' );
    }
}
add_action('get_header', 'theme_queue_js');

/**
 * Create taxonomies
 */
function rolo_create_taxonomy() {
    register_taxonomy( 'type', 'post', array( 'hierarchical' => false, 'label' => __('Rolopress Type'), 'query_var' => true, 'rewrite' => true ) );
    register_taxonomy( 'company', 'post', array( 'hierarchical' => false, 'label' => __('Company'), 'query_var' => true, 'rewrite' => true ) );
}
add_action('init', 'rolo_create_taxonomy', 0);

?>