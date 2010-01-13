<?php get_header(); ?>

		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">
        <?php rolopress_before_main(); // Before main hook ?>
        <div id="main">
			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">
<?php the_post(); ?>
 			<h2 class="page-title">
            <?php _e(get_the_term_list( $post->ID, 'type', ' ', ', ', ': ' ));?><?php the_title(); ?>
            </h2>
					<div id="entry-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
					<?php rolopress_before_entry(); // Before entry hook ?>
					<div class="entry-meta">
                    <span class="meta-prep meta-prep-author"><?php _e('Owner: ', 'rolopress'); ?></span>
                    <span class="author"><a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all items by %s', 'rolopress' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
                    </div><!-- .entry-meta -->
					<div class="entry-main group">
					
						<!-- What are we looking at? -->
						<?php if ( rolo_type_is( 'contact' ) ) { rolo_contact_header(get_the_ID());	
							if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("contact-under-main") ); } ?>
							
						<?php if ( rolo_type_is( 'company' ) ) { rolo_company_header(get_the_ID());		
							if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("company-under-main") ); } ?>	

						<?php the_content(); ?>	
                 	
					</div><!-- .entry-main -->
					<div class="entry-utility group">
<?php if ( $cats_meow = cats_meow(', ') ) : // Returns categories other than the one queried ?>
						<span class="cat-links"><?php printf( __( 'Also assigned to %s', 'rolopress' ), $cats_meow ) ?></span>
						<span class="meta-sep"> | </span>
<?php endif ?>
						<?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged: ', 'rolopress' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
						
						<?php if ( current_user_can('edit_posts') ) { ?>
							<span class="edit-item">
							<?php
							if (rolo_type_is('contact')) { 
								$edit_contact_page = get_page_by_title('Edit Contact'); ?>
								<a href="<?php echo get_permalink($edit_contact_page->ID) . '?id=' . get_the_ID(); ?>" ><?php _e('Edit', 'rolopress'); ?></a>
								<?php
							}
							if (rolo_type_is('company')) {
								$edit_company_page = get_page_by_title('Edit Company');?>
								<a href="<?php echo get_permalink($edit_company_page->ID) . '?id=' . get_the_ID(); ?>" ><?php _e('Edit', 'rolopress'); ?></a>
								<?php
							} ?>
							</span>
						<?php
						} ?>
						
						<?php if ( comments_open() ) : 
							if (is_user_logged_in() ) { // only allow logged in users to write notes ?>
								<span class="notes-link"><?php comments_popup_link( __( 'Write a Note', 'rolopress' ), __( '1 Note', 'rolopress' ), __( '% Notes', 'rolopress' ) ) ?></span><?php
							} else { ?>
								<span class="notes-link"><?php comments_popup_link( __( '', 'rolopress' ), __( '1 Note', 'rolopress' ), __( '% Notes', 'rolopress' ) ) ?></span><?php
							};
						endif;?>
						
					</div><!-- #entry-utility -->	
                    <?php rolopress_after_entry(); // After entry hook ?>
                    </div><!-- #post-<?php the_ID(); ?> -->
<?php comments_template( '/notes.php' ); ?> 
					</div><!-- #info -->
					<?php rolopress_after_info(); // After info hook ?>
					</div><!-- #main -->
                    <?php rolopress_after_main(); // After main hook ?>
					</div><!-- #container -->
                    <?php rolopress_after_container(); // After container hook ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>