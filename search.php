<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>	
			<div id="main">
			
<?php if ( have_posts() ) : ?>
								
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-above" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-above -->
<?php } ?>			

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			
			<h2 class="page-title"><?php _e( 'Search Results for: ', 'rolopress' ); ?><span><?php the_search_query(); ?></span></h2>
				
<ul class="item-list">			
			<?php rolo_loop();?>
</ul>

			<?php rolopress_after_info_content(); // After info content hook ?>
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>	

<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-below" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-below -->
<?php } ?>			

<?php else : ?>
					<?php rolopress_before_info(); // Before info hook ?>
						<div id="info">		
							<h2 class="page-title"><?php _e( 'Nothing Found For: ', 'rolopress' ); ?><span><?php the_search_query(); ?></span></h2>
								<div id="post-0" class="post no-results not-found">
		
					<div class="entry-main">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'rolopress' ); ?></p>
				<?php get_search_form(); ?>						
					</div><!-- .entry-main -->
				</div>
				</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>	

<?php endif; ?>			

			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>