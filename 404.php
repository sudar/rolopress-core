    <?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">	

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
            	
                <h2 class="page-title"><?php _e( 'Not Found' , 'rolopress'); ?></h2>
			
				<div id="post-0" class="post error404 not-found">
					<?php rolopress_before_entry(); // Before entry hook ?>
					<div class="entry-main">
					<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'rolopress' ); ?></p>
	<?php get_search_form(); ?>
					</div><!-- .entry-main -->
				  <?php rolopress_after_entry(); // After entry hook ?>
				</div><!-- #post-0 -->
				
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>	
			
			
			</div><!-- #main -->		
		    <?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>
