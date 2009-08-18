    <?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">				
				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title"><?php _e( 'Not Found', 'shape' ); ?></h1>
					<?php rolopress_before_entry(); // Before entry hook ?>
					<div class="entry-main">
						<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'shape' ); ?></p>
	<?php get_search_form(); ?>
					</div><!-- .entry-main -->
				  <?php rolopress_after_entry(); // After entry hook ?>
				</div><!-- #post-0 -->
			</div><!-- #main -->		
		    <?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>