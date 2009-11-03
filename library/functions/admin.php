<?php
/**
 * Changes to WordPress admin screens
 * http://blue-anvil.com/archives/wordpress-snippet-2-style-the-login-page/
 */


function rolo_loginpage_logo_link($url)
{
     // Return a url; in this case the homepage url of wordpress
     return get_bloginfo('wpurl');
}
function rolo_loginpage_logo_title($message)
{
     // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
     return get_bloginfo('name');
}
function rolo_loginpage_head()
{
     $stylesheet_uri = get_bloginfo('template_url')."/styles/admin/admin.css";
     echo '<link rel="stylesheet" href="'.$stylesheet_uri.'" type="text/css" media="screen" />';
}
// Hook in
add_filter("login_headerurl","rolo_loginpage_logo_link");
add_filter("login_headertitle","rolo_loginpage_logo_title");
add_action("login_head","rolo_loginpage_head");

?>