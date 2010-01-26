<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
			<?php rolopress_before_main(); // Before main hook ?>
			<div id="main">
			
			<?php rolopress_before_page_info(); // Before info hook ?>
			<div id="info">
			<?php rolopress_before_page_info_content(); // Before page info content hook ?>
			
				<h2 class="page-title"><?php the_title(); ?></h2>
				
				<?php rolo_loop();?>	
			
            <?php rolopress_after_page_info_content(); // After page info content hook ?>
        </div><!-- #info -->
			<?php rolopress_after_page_info(); // After page info hook ?>		
			
			</div><!-- #main -->		
			<?php rolopress_after_main(); // After main hook ?>
		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>