<?php
/**
 * Widgets
 *
 * Creates widgets and widget areas
 *
 * Many thanks to Justin Tadlock: http://www.themehybrid.com
 * and Ian Stewart: http://www.themeshaper.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */
 
/**
 * Unregister WP widgets
 */
add_action( 'widgets_init', 'rolopress_unregister_widgets' );

/**
 * Register RoloPress Widgets
 */
add_action( 'widgets_init', 'rolopress_register_widgets' );

/**
 * Create Widget areas
 */
register_sidebar( array( 'name' => __('Menu', 'rolopress'), 'id' => 'menu', 'description' => __('Adds items to the default menu', 'rolopress'),
'before_widget' => '<div class="menu_item widget %2$s widget-%2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Primary', 'rolopress'), 'id' => 'primary', 'description' => __('In 2-column themes, this area is located on top of the sidebar.  In 3-column themes, this area will appear on the left', 'rolopress'), 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );
register_sidebar( array( 'name' => __('Secondary', 'rolopress'), 'id' => 'secondary', 'description' => __('In 2-column themes, this area is located on bottom of the sidebar.  In 3-column themes, this area will appear on the right', 'rolopress'), 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );
register_sidebar( array( 'name' => __('Widget Page', 'rolopress'), 'id' => 'widget-page', 'description' => __('Must be used with the WIDGETS or WIDGETS-NO-SIDEBAR Page templates.', 'rolopress'),'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );
register_sidebar( array( 'name' => __('Contact: Under Main', 'rolopress'), 'id' => 'contact-under-main', 'description' => __('Located under the contact header information on the single contact page.', 'rolopress'),'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );
register_sidebar( array( 'name' => __('Company: Under Main', 'rolopress'), 'id' => 'company-under-main', 'description' => __('Located under the company header information on the single company page.', 'rolopress'),'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );


/**
 * Register RoloPress custom widgets. 
 */
function rolopress_register_widgets() {

// Load each widget file.
	require_once( TEMPLATEPATH . '/library/widgets/owners.php' );
	require_once( TEMPLATEPATH . '/library/widgets/bookmarks.php' );
	require_once( TEMPLATEPATH . '/library/widgets/calendar.php' );
	require_once( TEMPLATEPATH . '/library/widgets/categories.php' );
	require_once( TEMPLATEPATH . '/library/widgets/pages.php' );
	require_once( TEMPLATEPATH . '/library/widgets/search.php' );
	require_once( TEMPLATEPATH . '/library/widgets/tags.php' );
	require_once( TEMPLATEPATH . '/library/widgets/companies.php' );
	require_once( TEMPLATEPATH . '/library/widgets/recent-items.php' );
	require_once( TEMPLATEPATH . '/library/widgets/contact-details.php' );
    require_once( TEMPLATEPATH . '/library/widgets/company-details.php' );
	require_once( TEMPLATEPATH . '/library/widgets/add-contact-form.php' );
	require_once( TEMPLATEPATH . '/library/widgets/add-company-form.php' );
	require_once( TEMPLATEPATH . '/library/widgets/recent-notes.php' );
		
// Register each widget.
	register_widget( 'Rolo_Widget_owners' );
	register_widget( 'Rolo_Widget_Bookmarks' );
	register_widget( 'Rolo_Widget_Calendar' );
	register_widget( 'Rolo_Widget_Categories' );
	register_widget( 'Rolo_Widget_Pages' );
	register_widget( 'Rolo_Widget_Search' );
	register_widget( 'Rolo_Widget_Tags' );
	register_widget( 'Rolo_Widget_Companies' );
	register_widget( 'Rolo_Widget_Recent_Items' );
	register_widget( 'Rolo_Widget_Contact_Details' );
	register_widget( 'Rolo_Widget_Company_Details' );
	register_widget( 'Rolo_Widget_Add_Contact' );
	register_widget( 'Rolo_Widget_Add_Company' );
	register_widget( 'Rolo_Widget_Recent_Notes' );
}

/**
 * Unregister default WordPress widgets we don't need.
 */
function rolopress_unregister_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
}

/**
 * Check for widgets in widget-ready areas. Allows user to completely
 * collapse widget-ready areas by not adding widgets to particular widget areas.
 * Checks widget areas by name and/or ID.
 *
 * Realizing that WordPress 2.8 introduced is_active_sidebar(), we're still using this
 * function because the WP function doesn't perform correctly.  See ticket #10136.
 * @link http://core.trac.wordpress.org/ticket/10136
 *
 * Major props to Chaos Kaizer and Ian Stewart.
 * @link http://wordpress.org/support/topic/190184#post-808787
 * @link http://blog.kaizeku.com
 * @link http://themeshaper.com/collapsing-wordpress-widget-ready-areas-sidebars
 *
 * @since 0.2
 * @param string|int $index name|ID of widget area.
 * @return bool
 */
function is_sidebar_active( $index = 1 ) {
	$sidebars_widgets = wp_get_sidebars_widgets();

	$index = ( is_int( $index ) ) ? "sidebar-$index" : sanitize_title( $index );

	if ( isset( $sidebars_widgets[$index] ) && !empty( $sidebars_widgets[$index] ) )
		return true;
  
	return false;
}


/**
 * Preset Widget Areas
 *
 * @credits:  http://ptahdunbar.com/wordpress/round-2-preset-widgets-to-widget-areas/
 */
$current_theme = get_option( 'template' ); // variable stores the current theme
$target_theme = 'rolopress-core'; // variable stores the theme we want to target


global $pagenow;

if ( 'themes.php' == $pagenow ) {
	if ( isset( $_GET['activated'] ) && $current_theme == $target_theme ) {
		
		// Setup some instances of the default widgets:
		update_option( 'Rolo_Widget_Recent_Items', array( 2 => array( 'title' => 'Recent Items' ), '_multiwidget' => 1 ) );
		update_option( 'Rolo_Widget_Companies', array( 2 => array( 'title' => 'Companies' ), '_multiwidget' => 1 ) );
		update_option( 'Rolo_Widget_Recent_Notes', array( 2 => array( 'title' => 'Recent Notes' ), '_multiwidget' => 1 ) );
		update_option( 'Rolo_Widget_Contact_Details', array( 2 => array( 'title' => 'Contact Details' ), '_multiwidget' => 1 ) );
		update_option( 'Rolo_Widget_Company_Details', array( 2 => array( 'title' => 'Company Details' ), '_multiwidget' => 1 ) );

		// Update the sidebars with those widgets
		update_option( 'sidebars_widgets', array(
			'primary' => array(
				'rolopress-recent-items-2',
				'rolopress-companies-2',
				'rolopress-recent-notes-2',
			),
			'secondary' => array(
				'rolopress-contact-details-2',
				'rolopress-company-details-2',
			),
			'wp_inactive_widgets' => array(),
		));
	}
}

?>