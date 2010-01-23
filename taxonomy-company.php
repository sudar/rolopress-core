
<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">
            
			
<?php the_post(); ?>			
			
				
<?php rewind_posts(); ?>
			
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-above" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-above -->
<?php } ?>			

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
            
                <h2 class="page-title">
                    <?php $term; $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; echo " List"; ?>
                </h2>
				
				<ul class="item-list">	

				
<?php // Show company on top
$company_query = new WP_Query('type=company&company=' . $term->name );
while ($company_query->have_posts()) : $company_query->the_post();
$do_not_duplicate = $post->ID; ?>

				<li id="post-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					<?php rolopress_before_entry(); // Before entry hook ?>     	

					<div class="entry-main group">

					<?php if ( rolo_type_is( 'company' ) ) rolo_company_header(get_the_ID()); ?>						

                    <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'rolopress' ) . '&after=</div>') ?>
					</div><!-- .entry-main -->

				<?php rolo_entry_footer() ;?>
				
     			<?php rolopress_after_entry(); // After entry hook ?>
				</li><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>	



<?php // Show contacts
rewind_posts();
$contacts_query = new WP_Query('company=' . $term->name );
if ($contacts_query->have_posts()) : while ($contacts_query->have_posts()) : $contacts_query->the_post();
	if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>		


				<li id="post-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					<?php rolopress_before_entry(); // Before entry hook ?>     	

					<div class="entry-main group">
					<?php if ( rolo_type_is( 'contact' ) ) rolo_contact_header(get_the_ID()); ?>					

                    <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'rolopress' ) . '&after=</div>') ?>
					</div><!-- .entry-main -->

				<?php rolo_entry_footer() ;?>
				
     			<?php rolopress_after_entry(); // After entry hook ?>
				</li><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; endif; ?>
	
			
				</ul><!-- item-list-->


			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>		

<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
				<div id="nav-below" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-below -->
<?php } ?>			
			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>