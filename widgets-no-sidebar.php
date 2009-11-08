<?php
/**
 * Template Name: Widget Page: No Sidebars
 *
 * Fully Widgetized Page with No Sidebars
 *
 * @package RoloPress
 * @subpackage Template
 */
 get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">
			
			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			
				<div class="<?php rolopress_entry_class(); ?> widget-area">
					<?php rolopress_before_entry(); // Before entry hook ?>
					<div class="entry-main">
					<ul class="xoxo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("widget-page") ) :
						echo '<div class="default-text">This page is totally widgetized. <a href="/wp-admin/widgets.php">Just drop some widgets here to fill it up.</a></div>';
					 endif; ?>
					</ul> 
					<br />
	
					</div><!-- .entry-main -->
					<?php rolopress_after_entry(); // After entry hook ?>
				</div><!-- #widget-area -->				
			
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>	
			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_footer(); ?>