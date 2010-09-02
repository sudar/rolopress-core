<?php get_header(); ?>
	
	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">

				<?php rolo_pageheader();?>
				<?php rolo_loop();?>
			
		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>

	</div><!-- #container -->
	<?php rolopress_after_container(); // After container hook ?>

<?php get_sidebar(); ?>	
<?php get_footer(); ?>