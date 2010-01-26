<?php
/**
 * Dynamic Classes
 *
 * Adds contextual classes to major theme elements.
 * This gives a near unlimited amount of control over design elements.
 *
 * Many of the ideas behind this come from the great Sandbox theme.
 * @link http://www.plaintxt.org/themes/sandbox
 *
 * The majority of this code was borrowed from the rolopress theme because it's so good!
 * @link http://themerolopress.com/
 *
 * @package RoloPress
 * @subpackage Functions
 */
 

/**
 * @since 0.1
 * @global $wp_query The current page's query object.
 * @global $rolopress The global rolopress object.
 * @return array $rolopress->context Several contexts based on the current page.
 */
function rolopress_get_context() {
	global $wp_query, $rolopress;

	/* If $rolopress->context has been set, don't run through the conditionals again. Just return the variable. */
	if ($rolopress && is_array( $rolopress->context ) )
		return $rolopress->context;

	$rolopress->context = array();

	/* Front page of the site. */
	if ( is_front_page() )
		$rolopress->context[] = 'frontpage';

	/* Blog page. */
	if ( is_home() ) {
		$rolopress->context[] = 'home';
	}
	
	/* Singular views. */
	elseif ( is_singular() ) {
		$rolopress->context[] = 'singular';
		$rolopress->context[] = "singular-{$wp_query->post->post_type}";
		$rolopress->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";		
		
			
		if ( is_single() ) { // add Type for single items
		// get the taxonomies, strip the links and make them lower case to match the other classes
		$terms_as_text = strtolower(strip_tags( get_the_term_list( $wp_query->post->ID, 'type','' ,'' ) ) );
		$rolopress->context[] =  "type-" . $terms_as_text;
		}
	}

	/* Archive views. */
	elseif ( is_archive() ) {
		$rolopress->context[] = 'archive';

		/* Taxonomy archives. */
		if ( is_tax() || is_category() || is_tag() ) {
			$term = $wp_query->get_queried_object();
			$rolopress->context[] = 'taxonomy';
			$rolopress->context[] = 'taxonomy-' . $term->taxonomy;
			$rolopress->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
		}

		/* User/author archives. */
		elseif ( is_author() ) {
			$rolopress->context[] = 'user';
			$rolopress->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
		}

		/* Time/Date archives. */
		else {
			if ( is_date() ) {
				$rolopress->context[] = 'date';
				if ( is_year() )
					$rolopress->context[] = 'year';
				if ( is_month() )
					$rolopress->context[] = 'month';
				if ( get_query_var( 'w' ) )
					$rolopress->context[] = 'week';
				if ( is_day() )
					$rolopress->context[] = 'day';
			}
			if ( is_time() ) {
				$rolopress->context[] = 'time';
				if ( get_query_var( 'hour' ) )
					$rolopress->context[] = 'hour';
				if ( get_query_var( 'minute' ) )
					$rolopress->context[] = 'minute';
			}
		}
	}

	/* Search results. */
	elseif ( is_search() ) {
		$rolopress->context[] = 'search';
	}

	/* Error 404 pages. */
	elseif ( is_404() ) {
		$rolopress->context[] = 'error-404';
	}

	return $rolopress->context;
}

/**
 * Creates a set of classes for each site entry upon display. Each entry is given the class of 
 * 'hentry'. Posts are given category, tag, and author classes. Alternate post classes of odd, 
 * even, and alt are added.
 *
 * @since 0.1
 * @global $post The current post's DB object.
 * @param string|array $class Additional classes for more control.
 * @return string $class
 */
function rolopress_entry_class( $class = '' ) {
	global $post;
	static $post_alt;

	/* Add hentry for microformats compliance and the post type. */
	$classes = array( 'hentry', $post->post_type );

	/* Item alt class. */
	$classes[] = 'item-' . ++$post_alt;
	$classes[] = ( $post_alt % 2 ) ? 'odd' : 'even alt';

	/* Owner class. */
	$classes[] = 'owner-' . sanitize_html_class( get_the_author_meta( 'user_nicename' ), get_the_author_meta( 'ID' ) );

	/* Sticky class (only on home/blog page). */
	if ( is_home() && is_sticky() )
		$classes[] = 'sticky';
		
	/* 404 */
	if ( is_404() )
		$classes[] = 'error404 not-found';

	/* Password-protected posts. */
	if ( post_password_required() )
		$classes[] = 'protected';

	/* Add category and post tag terms as classes. */
	if ( 'post' == $post->post_type ) {

		foreach ( array( 'category', 'post_tag' ) as $tax ) {

			foreach ( (array)get_the_terms( $post->ID, $tax ) as $term ) {
				if ( !empty( $term->slug ) )
					$classes[] = $tax . '-' . sanitize_html_class( $term->slug, $term->term_id );
			}
		}
	}

	/* User-created classes. */
	if ( !empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	}

	/* Join all the classes into one string and echo them. */
	$class = join( ' ', $classes );

	echo apply_filters( 'entry_class', $class );
}

/**
 * Sets a class for each note. Sets alt, odd/even, and owner/user classes. Adds owner, user, 
 * and reader classes. Needs more work because WP, by default, assigns even/odd backwards 
 * (Odd should come first, even second).
 *
 * @since 0.1
 * @global $wpdb WordPress DB access object.
 * @global $comment The current comment's DB object.
 */
function rolopress_note_class() {
	global $post, $comment, $rolopress;

	/* Gets default WP comment classes. */
	$classes = get_comment_class();

	/* Get the comment type. */
	$classes[] = get_comment_type();

	/* User classes to match user role and user. */
	if ( $comment->user_id > 0 ) {

		/* Create new user object. */
		$user = new WP_User( $comment->user_id );

		/* Set a class with the user's role. */
		if ( is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
				$classes[] = "role-{$role}";
		}

		/* Set a class with the user's name. */
		$classes[] = 'user-' . sanitize_html_class( $user->user_nicename, $user->user_id );
	}

	/* If not a registered user */
	else {
		$classes[] = 'reader';
	}

	/* Comment by the entry/item author. */
	if ( $post = get_post( $post_id ) ) {
		if ( $comment->user_id === $post->post_author )
			$classes[] = 'entry-author';
	}

	/* Join all the classes into one string and echo them. */
	$class = join( ' ', $classes );

	echo apply_filters( "{$rolopress->prefix}_comment_class", $class );
}

/**
 * Provides classes for the <body> element depending on page context.
 *
 * @since 0.1
 * @uses $wp_query
 * @param string|array $class Additional classes for more control.
 * @return string
 */
function rolopress_body_class( $class = '' ) {
	global $wp_query, $is_lynx, $is_gecko, $is_firefox, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

	/* Text direction (which direction does the text flow). */
	$classes = array( 'rolopress', get_bloginfo( 'text_direction' ), get_locale() );

	/* Date classes. */
	$time = time() + ( get_option( 'gmt_offset' ) * 3600 );
	foreach ( array( 'Y', 'm', 'd', 'H', 'l' ) as $type )
		$classes[] = str_replace( 'l', '', strtolower( $type . gmdate( $type, $time ) ) );

	/* Is the current user logged in. */
	$classes[] = ( is_user_logged_in() ) ? 'logged-in' : 'not-logged-in';
	
	/* Can the current user edit items. */
	if ( current_user_can('edit_posts') )
		$classes[] = 'can-edit-items';
		
	/* Can the current user add items. */
	if ( current_user_can('publish_posts') )
		$classes[] = 'can-add-items';	
		
		

	/* Merge base contextual classes with $classes. */
	$classes = array_merge( $classes, rolopress_get_context() );

	/* Singular post (post_type) classes. */
	if ( is_singular() ) {
	
		/* Checks for custom template. */
		$template = str_replace( '.php', '', get_post_meta( $wp_query->post->ID, "_wp_{$wp_query->post->post_type}_template", true ) );
		if ( $template )
			$classes[] = "{$wp_query->post->post_type}-template-{$template}";

		/* Attachment mime types. */
		if ( is_attachment() ) {
			foreach ( explode( '/', get_post_mime_type() ) as $type )
				$classes[] = "attachment-{$type}";
		}

		/* Deprecated classes. */
		elseif ( is_page() )
			$classes[] = "page-{$wp_query->post->ID}"; // Use singular-page-ID
		elseif ( is_single() )
			$classes[] = "single-{$wp_query->post->ID}"; // Use singular-post-ID
	}

	/* Paged views. */
	if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 ) {
		$page = intval( $page );
		$classes[] = 'paged paged-' . $page;
	}

	/* Browser detection. */
// A little Browser detection shall we?
	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	
	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ){
			$classes[] = 'mac';
		
	} elseif ( preg_match( "/Windows/", $browser ) ){
			$classes[] = 'windows';
		
	} elseif ( preg_match( "/Linux/", $browser ) ) {
			$classes[] = 'linux';

	} else {
			$classes[] = 'unknown-os';
	}
	
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Chrome/", $browser ) ) {
			$classes[] = 'chrome';

			preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
			$ch_version = 'ch' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $ch_version;

	} elseif ( preg_match( "/Safari/", $browser ) ) {
			$classes[] = 'safari';
			
			preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
			$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $sf_version;
			
	} elseif ( preg_match( "/Opera/", $browser ) ) {
			$classes[] = 'opera';
			
			preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
			$op_version = 'op' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $op_version;
			
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
			$classes[] = 'msie';
			
			if( preg_match( "/MSIE 6.0/", $browser ) ) {
					$classes[] = 'ie6';
			} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
					$classes[] = 'ie7';
			} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
					$classes[] = 'ie8';
			}
			
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
			$classes[] = 'firefox';
			
			preg_match( "/Firefox\/(\d)/si", $browser, $matches);
			$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $ff_version;
			
	} else {
			$classes[] = 'unknown-browser';
	}
	

	/* rolopress theme widgets detection. */
	 // Need to handle better.  Widget areas register as active if they contain smart widgets, even if the widgets are not visible
	 
	if ( is_singular () ) { /* Detect widgets in single page widget areas */
			foreach ( array( 'contact-under-main', 'company-under-main' ) as $sidebar )
			$classes[] = ( is_sidebar_active( $sidebar ) ) ? "{$sidebar}-widgets-active" : "{$sidebar}-widgets-inactive";
		}
	if ( is_page_template('widgets.php' || 'widgets-no-sidebar.php' ) ) { /* Detect widgets on widget template pages */
			foreach ( array( 'widget-page') as $sidebar )
			$classes[] = ( is_sidebar_active( $sidebar ) ) ? "{$sidebar}-widgets-active" : "{$sidebar}-widgets-inactive";
		}		
		
	foreach ( array( 'menu', 'primary', 'secondary' ) as $sidebar ) /* Detect widgets everywhere else */
		$classes[] = ( is_sidebar_active( $sidebar ) ) ? "{$sidebar}-widgets-active" : "{$sidebar}-widgets-inactive";

	/* Input class. */
	if ( !empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	}

	/* Join all the classes into one string. */
	$class = join( ' ', $classes );

	/* Print the body class. */
	echo apply_filters( 'body_class', $class );
}


/**
 * Function for handling what the browser/search engine title should be. Tries to handle every 
 * situation to make for the best SEO.
 *
 * @since 0.1
 * @global $wp_query
 */
function rolopress_document_title() {
	global $wp_query;

	$separator = ':';

	if ( is_front_page() && is_home() )
		$doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );

	elseif ( is_home() || is_singular() ) {
		$id = $wp_query->get_queried_object_id();

		$doctitle = get_post_meta( $id, 'Title', true );

		if ( !$doctitle && is_front_page() )
			$doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );
		elseif ( !$doctitle )
			$doctitle = get_post_field( 'post_title', $id );
	}

	elseif ( is_archive() ) {

		if ( is_category() || is_tag() || is_tax() ) {
			$term = $wp_query->get_queried_object();
			$doctitle = $term->name . " List";
		}

		elseif ( is_author() )
			$doctitle = get_the_author_meta( 'display_name', get_query_var( 'author' ) );

		elseif ( is_date () ) {
			if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
				$doctitle = sprintf( __( 'Archive for %1$s', 'rolopress' ), get_the_time( __( 'g:i a', 'rolopress' ) ) );

			elseif ( get_query_var( 'minute' ) )
				$doctitle = sprintf( __( 'Archive for minute %1$s', 'rolopress' ), get_the_time( __( 'i', 'rolopress' ) ) );

			elseif ( get_query_var( 'hour' ) )
				$doctitle = sprintf( __( 'Archive for %1$s', 'rolopress' ), get_the_time( __( 'g a', 'rolopress' ) ) );

			elseif ( is_day() )
				$doctitle = sprintf( __( 'Archive for %1$s', 'rolopress' ), get_the_time( __( 'F jS, Y', 'rolopress' ) ) );

			elseif ( get_query_var( 'w' ) )
				$doctitle = sprintf( __( 'Archive for week %1$s of %2$s', 'rolopress' ), get_the_time( __( 'W', 'rolopress' ) ), get_the_time( __( 'Y', 'rolopress' ) ) );

			elseif ( is_month() )
				$doctitle = sprintf( __( 'Archive for %1$s', 'rolopress'), single_month_title( ' ', false) );

			elseif ( is_year() )
				$doctitle = sprintf( __( 'Archive for %1$s', 'rolopress' ), get_the_time( __( 'Y', 'rolopress' ) ) );
		}
	}

	elseif ( is_search() )
		$doctitle = sprintf( __( 'Search results for &quot;%1$s&quot;', 'rolopress' ), esc_attr( get_search_query() ) );

	elseif ( is_404() )
		$doctitle = __( '404 Not Found', 'rolopress' );
		

	/* If paged. */
	if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 )
		$doctitle = sprintf( __( '%1$s Page %2$s', rolopress , 'rolopress'), $doctitle . $separator, $page );
		

	/* Apply the wp_title filters so we're compatible with plugins. */
	$doctitle = apply_filters( 'wp_title', $doctitle, $separator, '' );

	echo apply_filters( 'document_title', esc_attr( $doctitle ) );
}

?>
