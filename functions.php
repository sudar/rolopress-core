<?php

/* Functions File
 *
 * Loads theme functions
 * Defines constants
 *
 * @package RoloPress
 * @subpackage Functions
 */


/* Define constant paths */
	define( ROLOPRESS_DIR, TEMPLATEPATH );
	define( ROLOPRESS_LIBRARY, ROLOPRESS_DIR . '/library' );
	define( ROLOPRESS_EXTENSIONS, ROLOPRESS_LIBRARY . '/extensions' );
	define( ROLOPRESS_FUNCTIONS, ROLOPRESS_LIBRARY . '/functions' );
	define( ROLOPRESS_SETUP, ROLOPRESS_LIBRARY . '/setup' );
	define( ROLOPRESS_WIDGETS, ROLOPRESS_LIBRARY . '/widgets' );

/* Define constant paths (other file types). */
	$rolopress_dir = get_bloginfo( 'template_directory' );
	define( ROLOPRESS_IMAGES, $rolopress_dir . '/library/images' );
	define( ROLOPRESS_CSS, $rolopress_dir . '/library/styles' );
	define( ROLOPRESS_JS, $rolopress_dir . '/library/js' );

/* Define child theme paths. */
	define( ROLOPRESS_CHILD_DIR, get_stylesheet_directory() );
	define( ROLOPRESS_CHILD_URL, get_stylesheet_directory_uri() );

/* Load hooks and filters */
	require_once( ROLOPRESS_FUNCTIONS . '/hooks-filters.php' );
	
/* Change admin section to RoloPress style */
	require_once( ROLOPRESS_FUNCTIONS . '/admin.php' );

/* Run default setup */
	require_once( ROLOPRESS_SETUP . '/add-pages.php' );
	require_once( ROLOPRESS_SETUP . '/setup-fields.php' );
	
/* Load RoloPress functions */
	require_once( ROLOPRESS_FUNCTIONS . '/template-functions.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/contact-functions.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/company-functions.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/note-functions.php' );
	require_once( ROLOPRESS_FUNCTIONS . '/dynamic-classes.php' );
	
/* Load widget areas and custom widgets */
	require_once( ROLOPRESS_FUNCTIONS . '/widgets.php' );
	
/* Load extensions */
	require_once( ROLOPRESS_EXTENSIONS . '/rolosearch/rolosearch.php' );
	require_once( ROLOPRESS_EXTENSIONS . '/query-multiple-taxonomies/query-multiple-taxonomies.php' );
	
	
	


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


?>