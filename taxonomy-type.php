<?php get_header(); ?>
	
	<?php rolopress_before_container(); // Before container hook ?>
	<div id="container">
	
		<?php rolopress_before_main(); // Before main hook ?>
		<div id="main">

			<?php rolo_navigation_above() ?>			

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">

				<?php rolo_pageheader();?>
				
				<?php if ( rolo_type_is( 'contact' ) ) query_posts('meta_key=rolo_contact_last_name&orderby=meta_value&order=ASC');?>
				<?php if ( rolo_type_is( 'company' ) ) query_posts('meta_key=rolo_company&orderby=title&order=ASC');?>
				<?php rolo_loop();?>
				
			</div><!-- #info -->
			<?php rolopress_after_info(); // After info hook ?>
			
			<?php rolo_navigation_below() ?>
			
		</div><!-- #main -->
		<?php rolopress_after_main(); // After main hook ?>

	</div><!-- #container -->
	<?php rolopress_after_container(); // After container hook ?>

<?php get_sidebar(); ?>	
<?php get_footer(); ?>



