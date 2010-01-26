<?php
/**
 * Template Name: Company: Add
 *
 * Add Company page.
 *
 * @package RoloPress
 * @subpackage Template
 */
 get_header(); ?>

<div id="container">
    <div id="main">

        <?php rolopress_before_page_info(); // Before info hook ?>
        <div id="info">
            <?php rolopress_before_page_info_content(); // Before info content hook ?>
            <h2 class="page-title"><?php _e('Edit Company', 'rolopress');?></h2>
            <?php the_post(); ?>

		<li id="entry-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
			                <div class="entry-main">
<?php               if ( current_user_can('publish_posts') ) { // only display if user has proper permissions
                        rolo_edit_company();
                    } else {
                         _e("Sorry, you don't have permission to view this page.", 'rolopress');
                    }
?>
                </div><!-- .entry-main -->
            </div><!-- #post-<?php the_ID(); ?> -->

            <?php rolopress_after_page_info_content(); // After page info content hook ?>
        </div><!-- #info -->
			<?php rolopress_after_page_info(); // After page info hook ?>	

    </div><!-- #main -->
</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>