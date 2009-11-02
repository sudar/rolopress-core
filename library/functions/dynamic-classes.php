
<?php
/**
 * Adds contextual classes to major theme elements.
 * This gives a near unlimited amount of control over design elements.
 *
 * Many of the functions behind this come from the great Sandbox theme.
 * @link http://www.plaintxt.org/themes/sandbox
 *
 * This file was taken from the Hybrid theme because it's so good!
 * @link http://themehybrid.com/
 *
 * @package RoloPress
 * @subpackage Functions
 */

/**
 * Creates a set of classes for each site entry. Each entry is 
 * given the class of 'hentry'. Posts are given category, tag, and 
 * author classes. Alternates post classes of odd, even, and alt are added.
 *
 * Mostly relies on conditional tags but several other functions are key.
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Template_Tags/get_the_category
 * @link http://codex.wordpress.org/Template_Tags/get_the_tags
 *
 */
function rolopress_entry_class( $class = '' ) {
	global $post;
	static $post_alt;

	$args = array(
		'entry_tax' => array( 'category', 'post_tag' )
	);

	/* Microformats. */
	$classes[] = 'hentry';

	/* Post type. For backwards compatibility w/stylesheets, all entries should be given a class of 'post'. */
	if ( $post->post_type != 'post' )
		$classes[] = 'post';
	$classes[] = $post->post_type;

	/* Post alt class. */
	$classes[] = 'post-' . ++$post_alt;

	if ( $post_alt % 2 )
		$classes[] = 'odd';
	else
		$classes[] = 'even alt';

	/* Sticky class (only on home/blog page). */
	if( is_sticky() && is_home() )
		$classes[] = 'sticky';

	/* Author class. */
	if ( !is_attachment() )
		$classes[] = 'author-' . sanitize_html_class( get_the_author_meta( 'user_nicename' ), get_the_author_meta( 'ID' ) );

	/* Password-protected posts. */
	if ( post_password_required() )
		$classes[] = 'protected';

	/* Add each taxonomy as a class. */
	if ( $post->post_type == 'post' ) :

		foreach ( $args['entry_tax'] as $tax ) :

			foreach ( (array)get_the_terms( $post->ID, $tax ) as $term ) :
				if ( !empty( $term->slug ) ) :
					$classes[] = $tax . '-' . sanitize_html_class( $term->slug, $term->term_id );
				endif;
			endforeach;

		endforeach;

	endif;

	/* User-created classes. */
	if ( !empty( $class ) ) :
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	endif;

	/* Join all the classes into one string and echo them. */
	$class = join( ' ', $classes );

	echo apply_filters( 'rolopress_entry_class', $class );
}

/**
 * Sets a class for each note. Sets alt, odd/even, and author/user classes. 
 * Adds author, user, and reader classes. Needs more work because WP, by 
 * default, assigns even/odd backwards (Odd should come first, even second).
 *
 * @link http://codex.wordpress.org/Template_Tags/get_comment_author_url
 * @link http://codex.wordpress.org/Function_Reference/get_userdata
 *
 * @todo Find a better way to get the user's role b/c these can be custom.
 */
function rolopress_note_class() {
	global $comment, $wpdb, $wp_roles;
	static $comment_alt;
	$classes = array();

	/* Gets default WP comment classes. */
	$classes = str_replace( array( 'byuser', 'bypostauthor' ), '', get_comment_class() );

	/* User classes to match user role.  Major props to Ptah Dunbar for original idea. @link http://wpframework.com */
	if ( $comment->user_id > 0 && $user = get_userdata( $comment->user_id ) ) :

		/* Set a class with the commenter's role. */
		$capabilities = $user->{$wpdb->prefix . 'capabilities'};

		if ( !isset( $wp_roles ) ) :
			$wp_roles = new WP_Roles();
		endif;

		foreach ( $wp_roles->role_names as $role => $name ) :

			if ( is_array( $capabilities) && array_key_exists( $role, $capabilities ) ) :
				$classes[] = $role . ' ' . $role . '-' . sanitize_html_class( $user->user_nicename, $user->user_id );
			endif;

		endforeach;

		/* Comment by the entry/post author. */
		if ( $post = get_post( $post_id ) ) :
			if ( $comment->user_id === $post->post_author )
				$classes[] = 'entry-author';
		endif;

	else :
		/* If not a registered user */
		$classes[] = 'reader';

	endif;

	/* @link http://microid.org */
	$email = get_comment_author_email();
	$url = get_comment_author_url();
	if ( !empty( $email ) && !empty( $url ) )
		$classes[] = 'microid-mailto+http:sha1:' . sha1( sha1( 'mailto:'.$email ) . sha1( $url ) );

	/* Join all the classes into one string and echo them. */
	$class = join( ' ', $classes );

	echo apply_filters( 'rolopress_note_class', $class );
}

/**
 * Provides classes for the <body> element depending on page context.
 *
 * Mostly relies on conditional tags but several other functions are key
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Template_Tags/get_the_category
 * @link http://codex.wordpress.org/Template_Tags/get_the_tags
 * @link http://codex.wordpress.org/Function_Reference/get_userdata
 * @link http://codex.wordpress.org/Function_Reference/get_post_mime_type
 * @link http://codex.wordpress.org/Function_Reference/get_post_meta
 *
 */
function rolopress_body_class( $class = '' ) {
	global $wp_query;

	$classes = array();

	/* Text direction (which direction does the text flow). */
	if ( 'rtl' == get_bloginfo( 'text_direction' ) )
		$classes[] = 'rtl';
	else
		$classes[] = 'ltr';

	/* Date classes. */
	$time = time() + ( get_option( 'gmt_offset' ) * 3600 );
	$classes[] = 'y' . gmdate( 'Y', $time );
	$classes[] = 'm' . gmdate( 'm', $time );
	$classes[] = 'd' . gmdate( 'd', $time );
	$classes[] = 'h' . gmdate( 'H', $time );
	$classes[] = strtolower( gmdate( 'l', $time ) );

	/* Is the current user logged in. */
	if ( is_user_logged_in() )
		$classes[] = 'logged-in';
	else
		$classes[] = 'not-logged-in';

	/* Basic classes generated by is_* functions. */
	if ( is_front_page() )
		$classes[] = 'home front-page';
	if ( is_home() )
		$classes[] = 'blog';
	if ( is_archive() )
		$classes[] = 'archive';
	if ( is_date() )
		$classes[] = 'date';
	if ( is_tax() )
		$classes[] = 'taxonomy';
	if ( is_author() )
		$classes[] = 'author';
	if ( is_singular() )
		$classes[] = 'singular';
	if ( is_404() )
		$classes[] = 'error-404';
	if ( is_paged() )
		$classes[] = 'paged';
	if ( is_preview() && is_single() )
		$classes[] = 'preview preview-single';
	if ( is_preview() && is_page() )
		$classes[] = 'preview preview-page';

	/* Attachments. */
	if ( is_attachment() ) :
		$classes[] = 'attachment attachment-' . $wp_query->post->ID;
		$mime_type = explode( '/', get_post_mime_type() );
		foreach ( $mime_type as $type ) :
			$classes[] = 'attachment-' . $type;
		endforeach;

	/* Single posts. */
	elseif ( is_single() ) :
		$classes[] = 'single single-' . $wp_query->post->ID;
		if ( is_sticky( $wp_query->post->ID ) ) :
			$classes[] = 'single-sticky';
		endif;

		foreach ( (array)get_the_category( $wp_query->post->ID ) as $cat ) :
			$classes[] = 'single-category-' . sanitize_html_class( $cat->slug, $cat->term_id );
		endforeach;

		$wp_query->in_the_loop = true;
		foreach ( ( array )get_the_tags( $wp_query->post->ID ) as $tag ) :
				$classes[] = 'single-post_tag-' . sanitize_html_class( $tag->slug, $tag->term_id );
		endforeach;
		$wp_query->in_the_loop = false;

		$classes[] = 'single-author-' . get_the_author_meta( 'user_nicename', $wp_query->post->post_author );

	/* Pages. */
	elseif ( is_page() ) :
		$classes[] = 'page page-' . $wp_query->post->ID;

		if ( is_page_template() ) :
			$classes[] = 'page-template page-template-' . str_replace( '.php', '', get_post_meta( $wp_query->post->ID, '_wp_page_template', true ) );
		endif;

		$classes[] = 'page-author-' . get_the_author_meta( 'user_nicename', $wp_query->post->post_author );

	/* Archives (author, category, date, tag). */
	elseif ( is_author() ) :
		$classes[] = 'author-' . get_the_author_meta( 'user_nicename', get_query_var( 'author' ) );

	/* Taxomonies (tags, categories, etc.). */
	elseif ( is_tax() || is_category() || is_tag() ) :
		$term = $wp_query->get_queried_object();
		$classes[] = $term->taxonomy . ' ' . $term->taxonomy . '-' . sanitize_html_class( $term->slug, $term->term_id );

	/* Time and date. */
	elseif ( is_time() ) :
		$classes[] = 'time';

	elseif ( is_day() ) :
		$classes[] = 'day';

	elseif ( get_query_var( 'w' ) ) :
		$classes[] = 'week';

	elseif ( is_month() ) :
		$classes[] = 'month';

	elseif ( is_year() ) :
		$classes[] = 'year';

	/* Search results. */
	elseif ( is_search() ) :
		if ( have_posts() ) :
			$classes[] = 'search search-results';
		else :
			$classes[] = 'search search-no-results';
		endif;

	endif;

	/* Paged views. */
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) :
		$page = intval( $page );
		$classes[] = 'paged-' . $page;

		if ( is_front_page() )
			$classes[] = 'home-paged home-paged-' . $page . ' front-page-paged front-page-paged-' . $page;
		if ( is_home() )
			$classes[] = 'blog-paged blog-paged-' . $page;
		if ( is_single() )
			$classes[] = 'single-paged single-paged-' . $page;
		elseif ( is_page() )
			$classes[] = 'page-paged page-paged-' . $page;
		elseif ( is_category() )
			$classes[] = 'category-paged category-paged-' . $page;
		elseif ( is_tag() )
			$classes[] = 'post_tag-paged post_tag-paged-' . $page;
		elseif ( is_date() )
			$classes[] = 'date-paged date-paged-' . $page;
		elseif ( is_author() )
			$classes[] = 'author-paged author-paged-' . $page;
		elseif ( is_search() )
			$classes[] = 'search-paged search-paged-' . $page;
	endif;

	/* Browser and OS detection.  Major props to Ptah Dunbar. @link http://wpframework.com */
	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];

	/* OS detection. */
	if ( preg_match( "/Windows/", $browser ) )
		$classes[] = 'windows';
	elseif ( preg_match( "/Mac/", $browser ) )
		$classes[] = 'mac';
	elseif ( preg_match( "/Linux/", $browser ) )
		$classes[] = 'linux';
	else
		$classes[] = 'unknown-os';

	/* Chrome */
	if ( preg_match( "/Chrome/", $browser ) ) :
		preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches );
		$classes[] = 'chrome chrome-' . str_replace( ".", "-", $matches[1] );

	/* Safari */
	elseif ( preg_match( "/Safari/", $browser ) ) :
		preg_match( "/Version\/(\d.\d)/si", $browser, $matches );
		$classes[] = 'safari safari-' . str_replace( ".", "-", $matches[1] );

	/* Opera */
	elseif ( preg_match( "/Opera/", $browser ) ) :
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches );
		$classes[] = 'opera opera-' . str_replace( ".", "-", $matches[1] );

	/* Internet Explorer */
	elseif ( preg_match( "/MSIE/", $browser ) ) :
		$classes[] = 'msie';
		if ( preg_match( "/MSIE 6.0/", $browser ) ) :
			$classes[] = 'ie6';
		elseif ( preg_match( "/MSIE 7.0/", $browser ) ) :
			$classs[] = 'ie7';
		elseif ( preg_match( "/MSIE 8.0/", $browser ) ) :
			$classes[] = 'ie8';
		endif;

	/* Firefox */
	elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) :
		preg_match( "/Firefox\/(\d)/si", $browser, $matches );
		$classes[] = 'firefox firefox-' . str_replace( ".", "-", $matches[1] );

	/* Unknown browser */
	else :
		$classes[] = 'unknown-browser';

	endif;

	/* rolopress theme widgets detection. */
	if ( is_sidebar_active( 'primary' ) ) :
		$classes[] = 'primary-active';
	else :
		$classes[] = 'primary-inactive';
		$primary = 'inactive';
	endif;

	if ( is_sidebar_active( 'secondary' ) ) :
		$classes[] = 'secondary-active';
	else :
		$classes[] = 'secondary-inactive';
		$secondary = 'inactive';
	endif;

	if ( is_sidebar_active( 'subsidiary' ) ) :
		$classes[] = 'subsidiary-active';
	else :
		$classes[] = 'subsidiary-inactive';
		$subsidiary = 'inactive';
	endif;

	if ( $primary == 'inactive' && $secondary == 'inactive' && $subsidiary == 'inactive' )
		$classes[] = 'no-widgets';

	/* Input class. */
	if ( !empty( $class ) ) :
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	endif;

	/* Join all the classes into one string. */
	$class = join( ' ', $classes );

	/* Print the body class. */
	echo apply_filters( 'rolopress_body_class', $class );
}

/**
 * Function for handling what the browser title should be.
 */
function rolopress_document_title( $doctitle ) {
	global $wp_query, $rolopress_settings;

	$separator = ':';

	if ( is_singular() && !is_attachment() ) :
		$doctitle = wp_specialchars( get_post_meta( $wp_query->post->ID, 'Title', true ), true );

	elseif ( is_home() ) :
		$doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );

	elseif ( is_attachment() ) :
		$doctitle = single_post_title( false, false );

	elseif ( is_category() ) :
		$doctitle = single_cat_title( false, false );

	elseif ( is_tag() ) :
		$doctitle = single_tag_title( false, false );

	elseif ( is_tax() ) :
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$doctitle = $term->name;

	elseif ( is_author() ) :
		$doctitle = get_the_author_meta( 'display_name', get_query_var( 'author' ) );

	elseif ( is_search() ) :
		$doctitle = sprintf( __('Search results for &quot;%1$s&quot;', 'rolopress'), esc_attr( get_search_query() ) );

	elseif ( get_query_var( 'minute' ) && get_query_var( 'hour' ) ) :
		$doctitle = sprintf( __('Archive for %1$s', 'rolopress'), get_the_time( __('g:i a', 'rolopress') ) );

	elseif ( get_query_var( 'minute' ) ) :
		$doctitle = sprintf( __('Archive for minute %1$s', 'rolopress'), get_the_time( __('i', 'rolopress') ) );

	elseif ( get_query_var( 'hour' ) ) :
		$doctitle = sprintf( __('Archive for %1$s', 'rolopress'), get_the_time( __('g a', 'rolopress') ) );

	elseif ( is_day() ) :
		$doctitle = sprintf( __('Archive for %1$s', 'rolopress'), get_the_time( __('F jS, Y', 'rolopress') ) );

	elseif ( get_query_var( 'w' ) ) :
		$doctitle = sprintf( __('Archive for week %1$s of %2$s', 'rolopress'), get_the_time( __('W', 'rolopress') ), get_the_time( __('Y', 'rolopress') ) );

	elseif ( is_month() ) :
		$doctitle = sprintf( __('Archive for %1$s', 'rolopress'), single_month_title( ' ', false) );

	elseif ( is_year() ) :
		$doctitle = sprintf( __('Archive for %1$s', 'rolopress'), get_the_time( __('Y', 'rolopress') ) );

	elseif ( is_404() ) :
		$doctitle = __('404 Not Found', 'rolopress');

	endif;

	if ( !$doctitle && is_front_page() )
		$doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );
	elseif ( !$doctitle && is_singular() )
		$doctitle = single_post_title( false, false );

	/* If paged. */
	if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 )
		$doctitle = sprintf( __('%1$s Page %2$s', 'rolopress'), $doctitle . $separator, $page );

	return apply_filters( 'rolopress_document_title', $doctitle );
}

?>