<?php
/**
 * Template Name: Company: Edit
 *
 * Edit Company page.
 *
 * This page should not be accessed directly.  
 * Format is /edit-company?id=X
 *
 * @package RoloPress
 * @subpackage Template
 */
get_header(); ?>
	
	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">
			
				<?php rolo_pageheader();?>
				
				<?php if ( current_user_can('publish_posts') ) { // only display if user has proper permissions
						rolo_edit_company();
					} else {
						rolo_permission_message();
					}
				?>	
			
		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>
		
	</div><!-- #container -->
	<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>