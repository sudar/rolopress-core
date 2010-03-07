<?php include (ROLOPRESS_ADMIN_FUNCTIONS .'/get-options-core.php'); ?>
<?php get_header(); ?>
	
	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">

				<?php rolo_pageheader();?>
				<?php rolo_loop();?>
				<?php comments_template( '/notes.php' ); ?>
				
			</div><!-- #info -->
			<?php rolopress_after_info(); // After info hook ?>
			
		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>

	</div><!-- #container -->
	<?php rolopress_after_container(); // After container hook ?>

<?php get_sidebar(); ?>	
<?php get_footer(); ?>



