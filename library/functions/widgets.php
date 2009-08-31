<?php
/**
 * Handles widgets and widget areas
 *
 * Based on Hybrid theme: http://themehybrid.com/themes/hybrid
 *
 * @package RoloPress
 * @subpackage Widgets
 */


/* widget areas */
register_sidebar( array( 'name' => __('Menu', 'rolopress'), 'id' => 'menu', 'before_widget' => '<div class="menu_item widget %2$s widget-%2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Primary', 'rolopress'), 'id' => 'primary', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Secondary', 'rolopress'), 'id' => 'secondary', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );


/**
 * Register utility widget areas
 * @since 0.5
 */
register_sidebar( array( 'name' => __('Utility: Before Content', 'rolopress'), 'id' => 'utility-before-content', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Content', 'rolopress'), 'id' => 'utility-after-content', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Single', 'rolopress'), 'id' => 'utility-after-single', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Utility: After Page', 'rolopress'), 'id' => 'utility-after-page', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('Widgets Template', 'rolopress'), 'id' => 'utility-widgets-template', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
register_sidebar( array( 'name' => __('404 Template', 'rolopress'), 'id' => 'utility-404', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );



function rolopress_default_menu() {
				{ ?>
				<div id="menu">
				<?php }
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu') ) :
						wp_page_menu( 'sort_column=menu_order&show_home=Home&menu_class=menu_item&link_before=<span>&link_after=</span> ');

						{ ?>
						<div class="menu_item">
						<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
							<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="20" tabindex="1" />
					    	<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Search', 'rolopress') ?>" tabindex="2" />
						</form>
						</div>
				</div>
				<?php }
		
					endif; 
};

add_filter('rolopress_before_wrapper', 'rolopress_default_menu');


/** 
* To replace default menu use widgets or add the following code to your child theme's functions.php:
 
add_action('init', 'remove_rolopress_default_menu'); // first call the function to remove the default menu

 function remove_rolopress_default_menu() { // here's the function we just called
     remove_filter('rolopress_menu', 'rolopress_default_menu'); // removing the default menu
}

 function my_new_menu() { // here's our new menu
    [new menu stuff]
	}

add_filter('rolopress_menu', 'my_new_menu'); // make sure you use the filter
**/





?>