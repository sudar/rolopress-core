<?php
/**
 * Default Settings
 *
 * Modifies WordPress default settings so RoloPress works nice
 *
 *
 * @package RoloPress
 * @subpackage Functions
 */
 
/**
 * Change permalink structure
 * @global object $wpdb, $wp_rewrite
 * @since 0.1
 */
function rolo_set_permalinks() {
	global $wpdb, $wp_rewrite;

	$permalink_structure = '/%postname%';
	$wp_rewrite->set_permalink_structure($permalink_structure);
	$wp_rewrite->flush_rules();
}
add_action('init', 'rolo_set_permalinks');

?>