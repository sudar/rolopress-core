<?php get_header(); ?>

	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">
				
				<?php rolo_pageheader();?>
				
				<ul class="item-list">
				
					<?php 
					// Show the Company info on top 
					
					$company_query = new WP_Query('type=company&company=' . $term->name );
					while ($company_query->have_posts()) : $company_query->the_post(); $do_not_duplicate = $post->ID;
					?>

					<li id="entry-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					
						<?php rolopress_before_entry(); // Before entry hook ?>     	
						<div class="entry-main group">

						<?php if ( rolo_type_is( 'company' ) ) rolo_company_header(get_the_ID()); ?>

						</div><!-- .entry-main -->
						
						<?php rolo_entry_footer();?>

						<?php rolopress_after_entry(); // After entry hook ?>
					
					</li><!-- #entry-<?php the_ID(); ?> -->
					
					<?php endwhile; ?>
					

					<?php
					// Now show the contacts
					
					rewind_posts();
					
					$contacts_query = new WP_Query('company=' . $term->name );
					if ($contacts_query->have_posts()) : while ($contacts_query->have_posts()) : $contacts_query->the_post();
						if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

					<li id="entry-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					
					<?php rolopress_before_entry(); // Before entry hook ?>     	
					<div class="entry-main group">
					
					<?php if ( rolo_type_is( 'contact' ) ) rolo_contact_header(get_the_ID()); ?>
					
					</div><!-- .entry-main -->

					<?php rolo_entry_footer();?>

					<?php rolopress_after_entry(); // After entry hook ?>
					
					</li><!-- #entry-<?php the_ID(); ?> -->

					<?php endwhile; endif; ?>
	
				</ul><!-- item-list-->

		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>

</div><!-- #container -->
<?php rolopress_after_container(); // After container hook ?>

<?php get_sidebar(); ?>	
<?php get_footer(); ?>