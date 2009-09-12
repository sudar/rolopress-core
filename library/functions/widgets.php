<?php
/**
 * Handles widgets and widget areas
 *
 * @package RoloPress
 * @subpackage Widgets
 */


/* widget areas */
register_sidebar( array( 'name' => __('Menu', 'rolopress'), 'id' => 'menu', 'before_widget' => '<div class="menu_item widget %2$s widget-%2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Primary', 'rolopress'), 'id' => 'primary', 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );
register_sidebar( array( 'name' => __('Secondary', 'rolopress'), 'id' => 'secondary', 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );


/**
 * Register utility widget areas
 * @since 0.5
 */
register_sidebar( array( 'name' => __('Utility: Before Content', 'rolopress'), 'id' => 'utility-before-content', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Content', 'rolopress'), 'id' => 'utility-after-content', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Single', 'rolopress'), 'id' => 'utility-after-single', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Page', 'rolopress'), 'id' => 'utility-after-page', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Widgets Template', 'rolopress'), 'id' => 'utility-widgets-template', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('404 Template', 'rolopress'), 'id' => 'utility-404', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</li>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );

?>