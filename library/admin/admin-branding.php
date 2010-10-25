<?php
/**
 * Administration Branding
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
    echo '<link rel="stylesheet" type="text/css" href="' . $admin_css . '" media="screen" />';
}
add_action('admin_head', 'rolo_admin_css'); //admin css
add_action("login_head","rolo_admin_css"); //login css


function rolo_loginpage_logo_link($url) { // Return a url; in this case the homepage url of wordpress
     return get_bloginfo('wpurl');
}
add_filter("login_headerurl","rolo_loginpage_logo_link");


function rolo_admin_loginpage_logo_title($message){ // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
     return get_bloginfo('name');
}
add_filter("login_headertitle","rolo_admin_loginpage_logo_title");

function rolo_admin_footer() { // Add custom footer to Admin
  $theme_data = get_theme_data(ROLOPRESS_DIR . '/style.css');
   echo '<div id="footer-rolo">'.__('Powered by ','rolopress').'<a href="http://www.rolopress.com">RoloPress '.$theme_data['Version'].'</a> | <a href="http://rolopress.com/documentation">'.__('Documentation','rolopress').'</a> | <a href="http://forum.rolopress.com/">'.__('Support','rolopress').'</a></div>';
}
add_action('admin_footer', 'rolo_admin_footer');


/**
 * Change menu names
 *
 * @Credits: http://www.cmurrayconsulting.com/wordpress-tips/customizing-wordpress-admin/
 */
function rolo_change_menu_names( $translated ) {

	// Change Posts to Items
	$translated = str_replace( 'Posts', 'Items', $translated );
	$translated = str_replace( 'post', 'item', $translated );
	
	// Change Post Tags to Tags
	$translated = str_replace( 'Post Tags', 'Tags', $translated );
	$translated = str_replace( 'post tags', 'tags', $translated );
	$translated = str_replace( 'Post Tag', 'Tag', $translated );
	$translated = str_replace( 'post tag', 'tag', $translated );

	// Change Comments
	$translated = str_replace( 'Comments', 'Notes', $translated );
	$translated = str_replace( 'Comment', 'Note', $translated );
	$translated = str_replace( 'comment', 'note', $translated );
	$translated = str_replace( 'Discussion', 'Notes', $translated );

	// Change Author to Owner
	$translated = str_replace( 'Authors', 'Owners', $translated );
	$translated = str_replace( 'Author', 'Owner', $translated );
	
	// Change Misc items
	$translated = str_replace( 'In Response To', 'For Item', $translated );
	
	return $translated;
}
add_filter( 'gettext', 'rolo_change_menu_names' );
add_filter( 'ngettext', 'rolo_change_menu_names' );
add_filter( 'gettext_with_context', 'rolo_change_menu_names' );
add_filter( 'ngettext_with_context', 'rolo_change_menu_names' );

/**
 * Remove menu items
 *
 * @Credits: http://sixrevisions.com/wordpress/how-to-customize-the-wordpress-admin-area/
 */
function rolo_remove_submenus() {
  global $submenu;
  unset($submenu['edit.php'][10]); // Removes Add New
}

add_action('admin_menu', 'rolo_remove_submenus');

/**
 * Customize favorites dropdown
 *
 * @Credits: http://sixrevisions.com/wordpress/how-to-customize-the-wordpress-admin-area/
 */
function rolo_custom_favorite_actions($actions) {
  unset($actions['post-new.php?post_type=post']); // Remove New Post
  unset($actions['post-new.php']); // Remove New Post
  return $actions;
}

add_filter('favorite_actions', 'rolo_custom_favorite_actions');


?>