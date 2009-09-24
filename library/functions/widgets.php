<?php
/** * Handles widgets and widget areas * * @package RoloPress * @subpackage Widgets */
/* widget areas */register_sidebar( array( 'name' => __('Menu', 'rolopress'), 'id' => 'menu', 'before_widget' => '<div class="menu_item widget %2$s widget-%2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );register_sidebar( array( 'name' => __('Primary', 'rolopress'), 'id' => 'primary', 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );register_sidebar( array( 'name' => __('Secondary', 'rolopress'), 'id' => 'secondary', 'before_widget' => '<li id="%1$s" class="widget %2$s widget-%2$s">', 'after_widget' => '</div></li>', 'before_title' => '<h3 class="widget-title section-title">', 'after_title' => '</h3> <div class="inside">' ) );



?>