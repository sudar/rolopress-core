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
  $theme_data = get_theme_data(ROLOPRESS_DIR . '/style.css');
   echo '<div id="footer-rolo">Powered by <a href="http://www.rolopress.com">RoloPress '.$theme_data['Version'].'</a> | <a href="http://rolopress.com/documentation">Documentation</a> | <a href="http://rolopress.com/forums">Support</a></div>';
}
add_action('admin_footer', 'rolo_admin_footer');



?>