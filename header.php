<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }       
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title> 
	
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php rolopress_head(); // rolopress head hook ?>
	<?php wp_head(); // wordpress head hook ?>
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'rolopress' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'rolopress' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
</head>

<body class="<?php rolopress_body_class() ?>">

<?php rolopress_before_wrapper(); // before wrapper hook ?> 
<div id="wrapper" class="hfeed">

	<?php rolopress_before_header(); // before header hook ?>
	<div id="header">
				<?php rolopress_header(); // Header hook ?>
		<div id="masthead">
		
		<div id="access">
				<div class="skip-link"><a href="#main" title="<?php _e( 'Skip to main', 'rolopress' ) ?>"><?php _e( 'Skip to main', 'rolopress' ) ?></a></div>
			</div><!-- #access -->
				
		</div><!-- #masthead -->	
	</div><!-- #header -->
	<?php rolopress_after_header(); ?>  