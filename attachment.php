<?php include (ROLOPRESS_ADMIN_FUNCTIONS .'/get-options-core.php'); ?>
<?php get_header(); ?>
	
		<?php rolopress_before_container(); // Before container hook ?>
		<div id="container">	
				<?php rolopress_before_main(); // Before main hook ?>
				<div id="main">
			<?php rolo_navigation_above() ?>			

			<?php rolopress_before_info(); // Before info hook ?>
			<div id="info">		
			<?php rolopress_before_info_content(); // Before info content hook ?>
				
			
<?php the_post(); ?>

				<h1 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" title="<?php printf( __( 'Return to %s', 'rolopress' ), wp_specialchars( get_the_title($post->post_parent), 1 ) ) ?>" rev="attachment"><span class="meta-nav">&laquo; </span><?php echo get_the_title($post->post_parent) ?></a></h1>
				
				<div id="contact-<?php the_ID(); ?>" <?php rolopress_entry_class(); ?>>
					<?php rolopress_before_entry(); // Before entry hook ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
					
					<div class="entry-meta">
						<span class="meta-prep meta-prep-author"><?php _e('By ', 'rolopress'); ?></span>
						<span class="author"><a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'rolopress' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
						<span class="meta-sep"> | </span>
						<span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'rolopress'); ?></span>
						<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
						<?php edit_post_link( __( 'Edit', 'rolopress' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>						
					</div><!-- .entry-meta -->
					
					<div class="entry-main">
						<div class="entry-attachment">					
<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "medium"); ?>
						<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
						</p>
<?php else : ?>		
						<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>		
<?php endif; ?>		
						</div>				
						<div class="entry-caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></div>
						
					
<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'rolopress' )  ); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'rolopress' ) . '&after=</div>') ?>

					</div><!-- .entry-main -->
					
					<div class="entry-utility">
					<?php printf( __( 'This entry has been assigned to %1$s%2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>. Follow any notes here with the <a href="%5$s" title="Comments RSS to %4$s" rel="alternate" type="application/rss+xml">RSS feed for this item</a>.', 'rolopress' ),
						get_the_category_list(', '),
						get_the_tag_list( __( ' and tagged ', 'rolopress' ), ', ', '' ),
						get_permalink(),
						the_title_attribute('echo=0'),
						comments_rss() ) ?>

<?php if ( ('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Comments and trackbacks open ?>
						<?php printf( __( '<a class="comment-link" href="#respond" title="Add a note">Add a note</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your item" rel="trackback">Trackback URL</a>.', 'rolopress' ), get_trackback_url() ) ?>
<?php elseif ( !('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Only trackbacks open ?>
						<?php printf( __( 'Notes are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your item" rel="trackback">Trackback URL</a>.', 'rolopress' ), get_trackback_url() ) ?>
<?php elseif ( ('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Only notes open ?>
						<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Add a note">Add a note</a>.', 'rolopress' ) ?>
<?php elseif ( !('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Comments and trackbacks closed ?>
						<?php _e( 'Both notes and trackbacks are currently closed.', 'rolopress' ) ?>
<?php endif; ?>
<?php edit_post_link( __( 'Edit', 'rolopress' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" ) ?>
					</div><!-- .entry-utility -->	
				<?php rolopress_after_entry(); // After entry hook ?>					
				</div><!-- #post-<?php the_ID(); ?> -->		

			<?php rolopress_after_info_content(); // After info content hook ?>
			</div><!-- #info -->		
			<?php rolopress_after_info(); // After info hook ?>
			
			<?php rolo_navigation_below() ?>					

<?php comments_template(); ?>	
			</div><!-- #main -->			
			<?php rolopress_after_main(); // After main hook ?>			

		</div><!-- #container -->
		<?php rolopress_after_container(); // After container hook ?>
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>