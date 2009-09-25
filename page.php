<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">
			
			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			
<?php the_post(); ?>

				<h2 class="page-title"><?php the_title(); ?></h2>
				
				<div id="post-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					<?php rolopress_before_entry(); // Before entry hook ?>
					<div class="entry-main">
<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'rolopress' ) . '&after=</div>') ?>					
<?php edit_post_link( __( 'Edit', 'rolopress' ), '<span class="edit-link">', '</span>' ) ?>
					</div><!-- .entry-main -->
					<?php rolopress_after_entry(); // After entry hook ?>
				</div><!-- #post-<?php the_ID(); ?> -->			
			
<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>			
			
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>	
			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>