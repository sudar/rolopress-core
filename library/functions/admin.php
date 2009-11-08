<?php
/**
 * RoloPress Admin Screen
 *
 * http://blue-anvil.com/archives/wordpress-snippet-2-style-the-login-page/
 * http://codex.wordpress.org/Creating_Admin_Themes
*/

function rolo_admin_css() { //Admin CSS
    $url = get_settings('siteurl');
    $url = $url . '/wp-content/themes/rolopress-core/styles/admin/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $url . '" />';
}
function rolo_loginpage_logo_link($url) { // Return a url; in this case the homepage url of wordpress
     return get_bloginfo('wpurl');
}
function rolo_loginpage_logo_title($message){ // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
     return get_bloginfo('name');
}
function rolo_loginpage_head(){
     $stylesheet_uri = get_bloginfo('template_url')."/styles/admin/admin.css";
     echo '<link rel="stylesheet" href="'.$stylesheet_uri.'" type="text/css" media="screen" />';
}
function rolo_admin_footer() {
   echo '<div id="footer-rolo">Powered by <a href="http://www.rolopress.com">RoloPress</a>. | <a href="http://rolopress.com/documentation">Documentation</a> | <a href="http://rolopress.com/forums">Support</a></div>';
}
// Hook in
add_filter("login_headerurl","rolo_loginpage_logo_link");
add_filter("login_headertitle","rolo_loginpage_logo_title");
add_action("login_head","rolo_loginpage_head");
add_action('admin_head', 'rolo_admin_css');
add_action('admin_footer', 'rolo_admin_footer');
?>