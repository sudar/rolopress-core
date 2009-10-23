<?php

//Auto create pages
require_once( 'library/setup/add-pages.php' );

//Auto create custom fields
require_once( 'library/setup/setup-fields.php' );

//load hooks and filters
require_once( 'library/functions/hooks-filters.php' );

//load widget areas
require_once( 'library/functions/widgets.php' );

//load dynamic classes
require_once( 'library/functions/dynamic-classes.php' );

//load Template functions
require_once( 'library/functions/template-functions.php' );

//load contact functions
require_once( 'library/functions/contact-functions.php' );

//load company functions
require_once( 'library/functions/company-functions.php' );

//detect mobile
require_once( 'library/functions/mobile.php' );





// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'rolopress', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);

// Get the page number
function get_page_number() {
    if (get_query_var('paged')) {
        print ' | ' . __( 'Page ' , 'rolopress') . get_query_var('paged');
    }
} // end get_page_number

// For category lists on category archives: Returns other categories except the current one (redundant)
function cats_meow($glue) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list($separator) );
    foreach ( $cats as $i => $str ) {
        if ( strstr( $str, ">$current_cat<" ) ) {
            unset($cats[$i]);
            break;
        }
    }
    if ( empty($cats) )
        return false;

    return trim(join( $glue, $cats ));
} // end cats_meow

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function tag_ur_it($glue) {
    $current_tag = single_tag_title( '', '',  false );
    $separator = "\n";
    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
    foreach ( $tags as $i => $str ) {
        if ( strstr( $str, ">$current_tag<" ) ) {
            unset($tags[$i]);
            break;
        }
    }
    if ( empty($tags) )
        return false;

    return trim(join( $glue, $tags ));
} // end tag_ur_it

//TODO:  ****** SUDAR - NOT SURE WHAT THIS DOES, BUT WHEN I DELETE IT I GET AN ERROR.  TAKEN FROM SHAPE THEME
// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ) {
    global $wp_registered_sidebars;

    $widgetcolums = wp_get_sidebars_widgets();

    if ($widgetcolums[$index]) return true;

    return false;
} // end is_sidebar_active

add_action('template_redirect', 'rolo_add_script');

/**
 * Add JavaScript to the theme on needed pages
 */
function rolo_add_script() {
    if (is_page(array('Add Contact','Add Company', 'Edit Company', 'Edit Contact'))) {
        wp_enqueue_script( 'uni-form', get_bloginfo('template_directory') . '/js/uni-form.jquery.js', array('jquery'), '', true );
        wp_enqueue_script( 'rolopress-js', get_bloginfo('template_directory') . '/js/rolopress.js', array('jquery', 'uni-form'), '', true );
        // Build in tag auto complete script - Code explanation at http://bit.ly/2vbemR
        wp_enqueue_script( 'suggest' );
    }
}

/**
 * Add JavaScript to the theme on needed notes (comments) pages
 */
function theme_queue_js() {
    if (!is_admin()) {
        if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script( 'comment-reply' );
    }
}
add_action('get_header', 'theme_queue_js');

/**
 * Create taxonomies
 */
function rolo_create_taxonomy() {
    register_taxonomy( 'type', 'post', array( 'hierarchical' => false, 'label' => __('Rolopress Type'), 'query_var' => true, 'rewrite' => true ) );
    register_taxonomy( 'company', 'post', array( 'hierarchical' => false, 'label' => __('Company'), 'query_var' => true, 'rewrite' => true ) );
}
add_action('init', 'rolo_create_taxonomy', 0);




?>