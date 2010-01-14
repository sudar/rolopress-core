<?php
/**
 * Administration Area
 *
 * Modifies Administration area to be more RoloPress friendly
 *
 * @package RoloPress
 * @subpackage Administration
 */


/**
 * Filter Admin.css and add new logos
 *
 * @Credits: http://blue-anvil.com/archives/wordpress-snippet-2-style-the-login-page/
 * @Credits: http://codex.wordpress.org/Creating_Admin_Themes
 */
 
function rolo_admin_css() { // Admin CSS
    $admin_css = ROLOPRESS_CSS . '/admin/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $admin_css . '" />';
}
add_action('admin_head', 'rolo_admin_css');


function rolo_loginpage_logo_link($url) { // Return a url; in this case the homepage url of wordpress
     return get_bloginfo('wpurl');
}
add_filter("login_headerurl","rolo_loginpage_logo_link");


function rolo_admin_loginpage_logo_title($message){ // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
     return get_bloginfo('name');
}
add_filter("login_headertitle","rolo_admin_loginpage_logo_title");


function rolo_admin_loginpage_head(){ // Admin CSS for login page
    $admin_css = ROLOPRESS_CSS . '/admin/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $admin_css . '" media="screen" />';
}
add_action("login_head","rolo_admin_loginpage_head");


function rolo_admin_footer() { // Add custom footer to Admin
   echo '<div id="footer-rolo">Powered by <a href="http://www.rolopress.com">RoloPress</a>. | <a href="http://rolopress.com/documentation">Documentation</a> | <a href="http://rolopress.com/forums">Support</a></div>';
}
add_action('admin_footer', 'rolo_admin_footer');



/**
 * Setup custom Admin dashboard
 *
 * @Credits: http://www.smashingmagazine.com/2009/12/14/advanced-power-tips-for-wordpress-template-developers-reloaded/
 */


/**
 * Remove Dashboard widgets we don't need
 */
function rolo_admin_remove_dashboard_widgets() {
   global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'rolo_admin_remove_dashboard_widgets');

/**
 * Create Help and Support widget for dashboard
 */
function rolo_admin_dashboard_help() {
   echo '<p>For RoloPress Help and Support, please visit our <a href="http://www.rolopress.com/forums">Forums</a></p>';
}

/**
 * Create News widget for dashboard
 */
function rolo_admin_dashboard_news_widget () {
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed('http://feeds.feedburner.com/rolopress');
	$rss_items = $rss->get_items( 0, $rss->get_item_quantity(5) );
		if ( !$rss_items ) {
			echo 'no items';
			} else {
			foreach ( $rss_items as $item ) {
			echo '<p><a href="' . $item->get_permalink() . '">' . $item->get_title() . '</a></p>';
			}
		}
}

/**
 * Add RoloPress custom dashboard widgets
 */
function rolo_admin_custom_dashboard_widgets() {
	wp_add_dashboard_widget('rolo_help_widget', 'RoloPress Help and Support', 'rolo_admin_dashboard_help');
	wp_add_dashboard_widget('rolo_news_widget', 'RoloPress News', 'rolo_admin_dashboard_news_widget');
}
add_action('wp_dashboard_setup', 'rolo_admin_custom_dashboard_widgets');


/**
 * Edit Posts Page
 */
 
/**
 * Set / Unset columns
 * 
 * @credits http://johnathanandersendesign.com
 */
function rolo_admin_setup_custom_column($defaults) {
    unset($defaults['date']);
	$defaults['image'] = __('Image', 'rolopress'); // adds new column to column array
	return $defaults;
}
add_filter('manage_posts_columns', 'rolo_admin_setup_custom_column');


/**
 * Add item image
 * 
 * @credits http://johnathanandersendesign.com
 */
function rolo_admin_insert_image_column($column_name, $item_id){

	if( $column_name == 'image' ) {
	
		if (!$item_id) {
			return false;
		}
				
		if ( rolo_type_is('contact') ) { 	
			$contact = get_post_meta($item_id, 'rolo_contact', true);
	        echo get_avatar (($contact['rolo_contact_email']),48,ROLOPRESS_IMAGES . "/icons/rolo-contact.jpg");
		}
		
		if ( rolo_type_is('company') ) { 	
			$company = get_post_meta($item_id, 'rolo_company', true);
	        echo get_avatar (($company['rolo_company_email']),48,ROLOPRESS_IMAGES . "/icons/rolo-company.jpg");
		}
	}
}
add_action('manage_posts_custom_column', 'rolo_admin_insert_image_column', 10, 2);


?>