<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
				<?php rolopress_before_main(); // Before main hook ?>
				<div id="main">
			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			<?php rolopress_before_info_content(); // Before info content hook ?>		

<?php the_post(); ?>				
			
<?php if ( is_day() ) : ?>
				<h2 class="page-title"><?php printf( __( 'Items Created On: <span>%s</span>', 'rolopress' ), get_the_time(get_option('date_format')) ) ?></h2>
<?php elseif ( is_month() ) : ?>
				<h2 class="page-title"><?php printf( __( 'Items Created In: <span>%s</span>', 'rolopress' ), get_the_time('F Y') ) ?></h2>
<?php elseif ( is_year() ) : ?>
				<h2 class="page-title"><?php printf( __( 'Items Created In: <span>%s</span>', 'rolopress' ), get_the_time('Y') ) ?></h2>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
				<h2 class="page-title"><?php _e( 'Blog Archives', 'rolopress' ) ?></h2>
<?php endif; ?>

<?php rewind_posts(); ?>
			
			<?php rolo_loop();?>

			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>		


			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>