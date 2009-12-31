<?php
/**
 * Template Name: Contact: Edit
 *
 * Edit Contact page.
 *
 * @package RoloPress
 * @subpackage Template
 */
 get_header(); ?>
	
<div id="container">
    <div id="main">

        <?php rolopress_before_info(); // Before info hook ?>
        <div id="info">
            <?php rolopress_before_info_content(); // Before info content hook ?>
            <h2 class="page-title"><?php _e('Edit Contact');?></h2>
            <?php the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-main">
<?php               if ( current_user_can('publish_posts') ) { // only display if user has proper permissions
			$post_id =  (isset($_GET['id']) ? $_GET['id'] : 0;
			if ($post_id > 0) {
	                        rolo_edit_contact($post_id);
			}
                    } else {
                         _e("Sorry, you don't have permission to view this page.");
                    }
?>
                </div><!-- .entry-main -->
            </div><!-- #post-<?php the_ID(); ?> -->

            <?php rolopress_after_info_content(); // After info content hook ?>
        </div><!-- #info -->
        <?php rolopress_after_info(); // After info hook ?>

    </div><!-- #main -->
</div><!-- #container -->
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>
