
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
                    <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; echo " List"; ?>
                </h2>
				
				<ul class="item-list">

				
<?php if ( rolo_type_is( 'contact' ) ) query_posts('meta_key=rolo_contact_last_name&orderby=meta_value&order=ASC');?>
<?php if ( rolo_type_is( 'company' ) ) query_posts('meta_key=rolo_company&orderby=title&order=ASC');?>

				<?php rolo_loop();?>
			
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