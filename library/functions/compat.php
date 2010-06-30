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

/**
 * Generates a permalink for a taxonomy term archive.
 *
 * @since 2.5.0
 *
 * @param object|int|string $term
 * @param string $taxonomy
 * @param string $field Either 'slug', 'name', or 'id'
 * @return string HTML link to taxonomy term archive
 */
function rp_get_term_link( $term, $taxonomy, $field = 'slug' ) {
    // this will go away if this WordPress ticket is blessed <http://core.trac.wordpress.org/ticket/14156>
	global $wp_rewrite;

	if ( !is_object($term) ) {
		if ( is_int($term) ) {
			$term = &get_term($term, $taxonomy);
		} else {
			$term = &get_term_by($field, $term, $taxonomy);
		}
	}

	if ( !is_object($term) )
		$term = new WP_Error('invalid_term', __('Empty Term'));

	if ( is_wp_error( $term ) )
		return $term;

	// use legacy functions for core taxonomies until they are fully plugged in
	if ( $taxonomy == 'category' )
		return get_category_link((int) $term->term_id);
	if ( $taxonomy == 'post_tag' )
		return get_tag_link((int) $term->term_id);

	$termlink = $wp_rewrite->get_extra_permastruct($taxonomy);

	$slug = $term->slug;

	if ( empty($termlink) ) {
		$t = get_taxonomy($taxonomy);
		if ( $t->query_var )
			$termlink = "?$t->query_var=$slug";
		else
			$termlink = "?taxonomy=$taxonomy&term=$slug";
		$termlink = home_url($termlink);
	} else {
		$termlink = str_replace("%$taxonomy%", $slug, $termlink);
		$termlink = home_url( user_trailingslashit($termlink, 'category') );
	}
	return apply_filters('term_link', $termlink, $term, $taxonomy);
}
?>