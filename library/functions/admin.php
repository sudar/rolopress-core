<?php
/*
 * RoloPress Admin Settings
 *
*/


/*	
 * Filter Admin.css and add new logos
 *
 * http://blue-anvil.com/archives/wordpress-snippet-2-style-the-login-page/
 * http://codex.wordpress.org/Creating_Admin_Themes
*/

function rolo_admin_css() { //Admin CSS
    $admin_css = ROLOPRESS_CSS . '/admin/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $admin_css . '" />';
}
add_action('admin_head', 'rolo_admin_css');


function rolo_loginpage_logo_link($url) { // Return a url; in this case the homepage url of wordpress
     return get_bloginfo('wpurl');
}
add_filter("login_headerurl","rolo_loginpage_logo_link");


function rolo_loginpage_logo_title($message){ // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
     return get_bloginfo('name');
}
add_filter("login_headertitle","rolo_loginpage_logo_title");


function rolo_loginpage_head(){ //Admin CSS for login page
    $admin_css = ROLOPRESS_CSS . '/admin/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $admin_css . '" media="screen" />';
}
add_action("login_head","rolo_loginpage_head");


function rolo_admin_footer() {
   echo '<div id="footer-rolo">Powered by <a href="http://www.rolopress.com">RoloPress</a>. | <a href="http://rolopress.com/documentation">Documentation</a> | <a href="http://rolopress.com/forums">Support</a></div>';
}
add_action('admin_footer', 'rolo_admin_footer');



/*	
 * Setup custom Admin dashboard
 *
 * http://www.smashingmagazine.com/2009/12/14/advanced-power-tips-for-wordpress-template-developers-reloaded/
*/

add_action('wp_dashboard_setup', 'rolo_custom_dashboard_widgets');

function rolo_custom_dashboard_widgets() {
   global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);

	wp_add_dashboard_widget('rolo_help_widget', 'RoloPress Help and Support', 'rolo_dashboard_help');
	wp_add_dashboard_widget('rolo_news_widget', 'RoloPress News', 'rolo_dashboard_news_widget');
}

function rolo_dashboard_help() {
   echo '<p>For RoloPress Help and Support, please visit our <a href="http://www.rolopress.com/forums">Forums</a></p>';
}

function rolo_dashboard_news_widget () {
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