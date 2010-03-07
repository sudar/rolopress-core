<?php
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
function rolo_admin_dashboard_help() { ?>
	<p>
	<?php _e('For RoloPress Help and Support, please visit our ','rolopress') ?>
	<a href="http://www.rolopress.com/forums"><?php _e('Forums','rolopress') ?></a>
	</p>
   
<?php };

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
			echo '<p><a class="rsswidget" href="' . $item->get_permalink() . '">' . $item->get_title() . '</a></p><p>' . $item->get_description() . '</p>';
			
			}
		echo '<p class="rolo_dashboard_widget_footer"><a class="rss_subscribe" target="_blank" href="http://feeds.feedburner.com/rolopress">'. __('Subscribe to RSS','rolopress').'</a> <a class="email_subscribe" target="_blank" href="http://feedburner.google.com/fb/a/mailverify?uri=rolopress&loc=en_US"></a><a target="_blank" href="http://feedburner.google.com/fb/a/mailverify?uri=rolopress&loc=en_US">'.__('Subscribe via Email','rolopress').'</a></p>';
		}
}

/**
 * Add RoloPress custom dashboard widgets
 */
function rolo_admin_custom_dashboard_widgets() {
	wp_add_dashboard_widget('rolo_help_widget', __('RoloPress Help and Support','rolopress'), 'rolo_admin_dashboard_help');
	wp_add_dashboard_widget('rolo_news_widget', __('RoloPress News','rolopress'), 'rolo_admin_dashboard_news_widget');
}
add_action('wp_dashboard_setup', 'rolo_admin_custom_dashboard_widgets');


?>