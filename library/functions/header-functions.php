<?php
/**
 * Header Functions
 *
 * Functions used in the header area
 *
 * @package RoloPress
 * @subpackage Functions
 */
 

/**
 * Display RoloPress version in meta
 *
 * @since 1.2
 */
 function rolo_meta_data() {
  $theme_data = get_theme_data(ROLOPRESS_DIR . '/style.css');
	echo '<meta name="template" content="'.$theme_data['Title'] .  ' ' . $theme_data['Version'].'" />' . "\r";?>
	<?php }
add_action ('wp_head','rolo_meta_data');

/**
 * Define CSS file for layout
 *
 * @since 1.2
 */
 function rolo_theme_layout() {
	global $rolo_layout_setting;
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/' . $rolo_layout_setting . '.css" media="screen,projection" />' . "\r";
}
add_action ('wp_head','rolo_theme_layout');


 
 
?>