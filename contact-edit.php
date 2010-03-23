<?php
/**
 * Template Name: Contact: Edit
 *
 * Edit Contact page.
 *
 * This page should not be accessed directly.  
 * Format is /edit-contact?id=X
 *
 * @package RoloPress
 * @subpackage Template
 */
get_header(); ?>
	
	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">
		
			<?php rolopress_before_page_info(); // Before info hook ?>
			<div id="info">
			<?php rolopress_before_page_info_content(); // Before page info content hook ?>
			
				<?php rolo_pageheader();?>
				
				<?php if ( current_user_can('publish_posts') ) { // only display if user has proper permissions
						rolo_edit_contact();
					} else {
						rolo_permission_message();
					}
				?>	
			
			<?php rolopress_after_page_info_content(); // After page info content hook ?>
			</div><!-- #info -->
			<?php rolopress_after_page_info(); // After page info hook ?>
			
		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>
		
	</div><!-- #container -->
	<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>