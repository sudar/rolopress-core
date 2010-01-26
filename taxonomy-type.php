
<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">
            
			
<?php the_post(); ?>			
			
				
<?php rewind_posts(); ?>	

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
            
                <h2 class="page-title">
                    <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; echo " List"; ?>
                </h2>
				
				
<?php if ( rolo_type_is( 'contact' ) ) query_posts('meta_key=rolo_contact_last_name&orderby=meta_value&order=ASC');?>
<?php if ( rolo_type_is( 'company' ) ) query_posts('meta_key=rolo_company&orderby=title&order=ASC');?>

				<?php rolo_loop();?>
			


			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>			
			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>