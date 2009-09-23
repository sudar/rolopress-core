<?php
/**
 * Template Name: Company: Add
 *
 * Add Company page.
 *
 * @package RoloPress
 * @subpackage Template
 */
?>
<?php get_header(); ?>
	
		<div id="container">	
			<div id="main">
			

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			<?php rolopress_before_info_content(); // Before info content hook ?>
			<h3 class="section-title"><span>Add Contact</span></h3>
            <?php the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-main">

                        <?php rolo_add_contact()                        ;?>

					</div><!-- .entry-main -->
				</div><!-- #post-<?php the_ID(); ?> -->			
			
			<?php rolopress_after_info_content(); // After info content hook ?>
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>		
			
			</div><!-- #main -->		
		</div><!-- #container -->
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>