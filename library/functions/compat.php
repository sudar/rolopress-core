<?php
/**
 * Rolopress implementation for PHP functions missing from older PHP versions and WordPress functions which *should* be in core
 *
 * @package PHP
 * @access private
 */

/**
 * Retrieve a post given its title.
 *
 * @uses $wpdb
 *
 * @param string $post_title Post title
 * @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
 * @return mixed Post data if successful (type depends on $output) | Null if no posts found
 */
if (!function_exists('get_post_by_title'))  {
    // this will go away if this WordPress ticket is blessed <http://core.trac.wordpress.org/ticket/10865>

    function get_post_by_title($post_title, $output = OBJECT) {
        global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='post'", $post_title ));
        if ( $post )
            return get_post($post, $output);

        return null;
    }
}
?>