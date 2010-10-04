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
	echo '<meta name="template" content="'.$theme_data['Title'] .  ' ' . $theme_data['Version'].'" />' . "\r";
}
add_action ('wp_head','rolo_meta_data');

/**
 * Loads standard CSS files
 *
 * @since 1.2
 */
function rolo_css_standard() {
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/reset.css" media="screen,projection,print" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/rebuild.css" media="screen,projection,print" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/wp.css" media="screen,projection,print" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/screen.css" media="screen,projection,print" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/widgets.css" media="screen,projection,print" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS . '/uni-form.css" media="screen,projection,print" />' . "\n";
}
add_action ('wp_head','rolo_css_standard');

/**
 * Define CSS file for layout
 *
 * @since 1.2
 */
function rolo_css_theme_layout() {
	$options = get_option('rolopress_layout_options');
	$layout = $options[theme_layout];
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_LAYOUTS . "/" . $layout . '.css" media="screen,projection" />' . "\r";
}
add_action ('wp_head','rolo_css_theme_layout');

/**
 * Define Child CSS file
 *
 * @since 1.2
 */
function rolo_css_child() {
	echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CHILD_CSS . '" media="screen,projection,print" />' . "\n";
}
add_action ('wp_head','rolo_css_child');

/**
 * Use default print.css if no child version exists
 *
 * Looks in child directory for print.css
 * uses default print.css if none exists
 *
 * @since 1.2
 */
function rolo_css_print() {
	$custom_print_css = ROLOPRESS_CHILD_DIR . '/print.css'; // here's the file we look for

	if (file_exists($custom_print_css)) {
		echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CHILD_URL . '/print.css" media="print" />' . "\r";
	} else {
		echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_PRINT . '/print.css" media="print" />' . "\r";
	}
}
add_action ('wp_head','rolo_css_print');


/**
 * Allows for hiding of widget areas when printing
 *
 * @since 1.2
 */
function rolo_css_widget_areas() {
	$options = get_option('rolopress_main_options');

	$rolo_print_primary = $options[print_primary];
	$rolo_print_secondary = $options[print_secondary];
	$rolo_print_contact_under_main = $options[print_contact_under_main];
	$rolo_print_company_under_main = $options[print_company_under_main];
	
	if ($rolo_print_primary != "on") { echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_PRINT . '/hide-primary.css" media="print" />' . "\r";};
	if ($rolo_print_secondary != "on") { echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_PRINT . '/hide-secondary.css" media="print" />' . "\r";};
	if ($rolo_print_contact_under_main != "on") { echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_PRINT . '/hide-contact-under-main.css" media="print" />' . "\r";};
	if ($rolo_print_company_under_main != "on") { echo '<link rel="stylesheet" type="text/css" href="' . ROLOPRESS_CSS_PRINT . '/hide-company-under-main" media="print" />' . "\r";};
}
add_action ('wp_head','rolo_css_widget_areas');

/**
 * Displays Javascript disabled warning if user is logged in.
 *
 * @since 0.1
 */
function rolopress_js_disabled() {

    if (is_user_logged_in() ) { // only display if user is logged in ?>
<noscript>
	<p class="error"><?php echo __('JavaScript is disabled. For RoloPress to work properly,', 'rolopress') . " <a href=\"http://rolopress.com/forums/topic/inline-editing-not-working\">". __('please enable JavaScript.', 'rolopress') . "</a>";?></p>
</noscript>
<?php }
}
add_action('rolopress_before_wrapper', 'rolopress_js_disabled');

/**
 * Create default menu
 *
 * Assembles menu and places before wrapper
 * @since 1.4
 */
function rolopress_default_top_menu() { 
	echo "<div id=\"menu\">";
	wp_nav_menu( array( 'menu' => 'default-menu') ); // display menu built in Appearance > Menus
	rolopress_default_top_menu_right(); // call function to create right side of menu.
	echo "</div>";
};
add_action('rolopress_before_wrapper', 'rolopress_default_top_menu');


/**
 * Create the right side of default menu
 *
 * called in rolopress_default_top_menu() 
 * @since 1.4
 */
function rolopress_default_top_menu_right() { ?>

        <ul class="menu_item sub_menu alignright default_menu">
            <li>
                <form id="searchform" method="get" action="<?php bloginfo('url') ?>">
<?php
                    if (isset($_GET['s'])) {
                        $s = $_GET['s'];
                    } else {
                        $s = '';
                    }
?>
                    <input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($s), true) ?>" size="20" tabindex="1" />
                    <input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Search', 'rolopress') ?>" tabindex="2" />
                </form>
            </li>
            <?php global $user_ID, $user_identity, $user_level ?>
            <?php if ( $user_level >= 1 ) : ?>
                <li><a title="settings" href="<?php bloginfo('url') ?>/wp-admin/"><span><?php _e('Settings', 'rolopress') ?></span></a></li>
            <?php endif // $user_level >= 1 ?>
            <li><?php wp_loginout(); ?></li>
        </ul>
<?php
}
?>