<?php

//Auto create pages
	require_once( 'library/setup/add-pages.php' );

//Auto create custom fields
	require_once( 'library/setup/setup-fields.php' );

//load hooks and filters
	require_once( 'library/functions/hooks-filters.php' );

//loads framework functions
	require_once( 'library/functions/framework.php' );

//load widget areas
	require_once( 'library/functions/widgets.php' );

//load dynamic classes
	require_once( 'library/functions/dynamic-classes.php' );

//load Template functions
	require_once( 'library/functions/template-functions.php' );


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


// Register widgetized areas
function theme_widgets_init() {
	// Area 1
  register_sidebar( array (
  'name' => 'Primary Widget Area',
  'id' => 'primary-widget-area',
  'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
  'after_widget' => "</li>",
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
  ) );

	// Area 2
  register_sidebar( array (
  'name' => 'Secondary Widget Area',
  'id' => 'secondary-widget-area', 
  'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
  'after_widget' => "</li>",
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
  ) );
} // end theme_widgets_init

add_action( 'init', 'theme_widgets_init' );


// Pre-set Widgets
$preset_widgets = array (
	'primary-aside'  => array( 'search', 'pages', 'categories', 'archives' ),
	'secondary-aside'  => array( 'links', 'meta' )
);
if ( isset( $_GET['activated'] ) ) {
	update_option( 'sidebars_widgets', $preset_widgets );
}


// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
  global $wp_registered_sidebars;

  $widgetcolums = wp_get_sidebars_widgets();
		 
  if ($widgetcolums[$index]) return true;
  
	return false;
} // end is_sidebar_active


// Produces an avatar image with the hCard-compliant photo class
function commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
} // end commenter_link


// Custom callback to list comments in the rolopress style
function custom_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
  ?>
  	<li id="comment-<?php comment_ID() ?>" class="<?php rolopress_comment_class() ?>">
  		<div class="comment-author vcard"><?php commenter_link() ?></div>
  		<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'rolopress'),
  					get_comment_date(),
  					get_comment_time(),
  					'#comment-' . get_comment_ID() );
  					edit_comment_link(__('Edit', 'rolopress'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'rolopress') ?>
          <div class="comment-main">
      		<?php comment_text() ?>
  		</div>
		<?php // echo the comment reply link with help from Justin Tadlock http://justintadlock.com/ and Will Norris http://willnorris.com/
			if($args['type'] == 'all' || get_comment_type() == 'comment') :
				comment_reply_link(array_merge($args, array(
					'reply_text' => __('Reply','rolopress'), 
					'login_text' => __('Log in to reply.','rolopress'),
					'depth' => $depth,
					'before' => '<div class="comment-reply-link">', 
					'after' => '</div>'
				)));
			endif;
		?>
<?php } // end custom_comments


// Custom callback to list pings
function custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
    		<li id="comment-<?php comment_ID() ?>" class="<?php comment_class() ?>">
    			<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'rolopress'),
    					get_comment_author_link(),
    					get_comment_date(),
    					get_comment_time() );
    					edit_comment_link(__('Edit', 'rolopress'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'rolopress') ?>
            <div class="comment-main">
    			<?php comment_text() ?>
			</div>
<?php } // end custom_pings


add_action('template_redirect', 'rolo_add_script');

/**
 * Add JavaScript to the theme on needed pages
 */
function rolo_add_script() {
    if (is_page(array('Add Contact','Add Company', 'Edit Company', 'Edit Contact'))) {
        wp_enqueue_script( 'uni-form', get_bloginfo('template_directory') . '/uni-form/js/uni-form.jquery.js', array('jquery'), '', true );
        wp_enqueue_script( 'rolopress-js', get_bloginfo('template_directory') . '/js/rolopress.js', array('jquery', 'uni-form'), '', true );
        wp_enqueue_style('uniform', get_bloginfo('template_directory') . '/uni-form/css/uni-form.css');
    }
}

/**
 * Create taxonomies
 */
function rolo_create_taxonomy() {
    register_taxonomy( 'type', 'post', array( 'hierarchical' => false, 'label' => __('Rolopress Type'), 'query_var' => true, 'rewrite' => true ) );
    register_taxonomy( 'company', 'post', array( 'hierarchical' => false, 'label' => __('Company'), 'query_var' => true, 'rewrite' => true ) );
}

add_action('init', 'rolo_create_taxonomy', 0);
?>