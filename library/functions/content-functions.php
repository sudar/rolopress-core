<?php
/**
 * Loop Functions
 *
 * Functions used in the RoloPress loop
 *
 * @package RoloPress
 * @subpackage Functions
 */
 

 
/**
 * For category lists on category archives: Returns other categories except the current one (redundant)
 *
 * @since 0.1
 */
function cats_meow($glue) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list($separator) );
    foreach ( $cats as $i => $str ) {
        if ( strstr( $str, ">$current_cat<" ) ) {
            unset($cats[$i]);
            break;
        }
    }
    if ( empty($cats) )
        return false;

    return trim(join( $glue, $cats ));
}
 
function rolo_category_list() {
	if ( $cats_meow = cats_meow(', ') ) { // Returns categories other than the one queried ?>
		<span class="cat-links"><?php printf( __( 'Also assigned to %s', 'rolopress' ), $cats_meow ) ?><span class="meta-sep"> | </span></span>
<?php
	};
}
 
function rolo_tag_list() {
	the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged: ', 'rolopress' ) . '</span>', ", ", "<span class=\"meta-sep\"> | </span>\n</span>\n\t\t\t\t\t\t" );
}				
 
function rolo_notes () {
	if ( comments_open() ) : 
		if (is_user_logged_in() ) { // only allow logged in users to write notes ?>
			<span class="notes-link"><?php comments_popup_link( __( 'Write a Note', 'rolopress' ), __( '1 Note', 'rolopress' ), __( '% Notes', 'rolopress' ) ) ?></span><?php
		} else { ?>
			<span class="notes-link"><?php comments_popup_link( __( '', 'rolopress' ), __( '1 Note', 'rolopress' ), __( '% Notes', 'rolopress' ) ) ?></span><?php
		};
	endif;
}

function rolo_edit_item() {
		if ( current_user_can('edit_posts') ) { ?>
                <span>
				<span class="meta-sep"> | </span>
                <?php
					if (rolo_type_is('contact')) {
						$edit_contact_page = get_page_by_title('Edit Contact');
						?>
						<a class="post-edit-link" href="<?php echo get_permalink($edit_contact_page->ID) . '?id=' . get_the_ID(); ?>" ><?php _e('Edit', 'rolopress'); ?></a>
						<?php
					}
					elseif (rolo_type_is('company')) {
						$edit_company_page = get_page_by_title('Edit Company');
						?>
						<a class="post-edit-link" href="<?php echo get_permalink($edit_company_page->ID) . '?id=' . get_the_ID(); ?>" ><?php _e('Edit', 'rolopress'); ?></a>
						<?php
					}
					else {
						edit_post_link(__('Edit','rolopress'), '','');
					};
                ?>
                </span>
            <?php
	}
};


function rolo_entry_footer() { 
		global $post; ?>
		<div class="entry-meta">
			<span class="meta-prep meta-prep-author"><?php _e('By ', 'rolopress'); ?></span>
			<span class="author"><a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'rolopress' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
			<span class="meta-sep"> | </span>
			<span class="meta-prep meta-prep-entry-date"><?php _e('Created on ', 'rolopress'); ?></span>
			<span class="entry-date"><abbr class="created" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
		</div><!-- .entry-meta -->
					
		<div class="entry-utility group">
			<?php rolo_category_list(); ?>
			<?php rolo_tag_list(); ?>
			<?php if ($post->post_type == 'post') { rolo_notes();}  // only show notes for posts  ?>
			<?php rolo_edit_item(); ?>
		</div><!-- #entry-utility -->
<?php 
};


function rolo_loop() { ?>

<ul class="item-list">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post();  ?>

		<li id="entry-<?php the_ID(); ?>" class="<?php rolopress_entry_class(); ?>">
			<?php rolopress_before_entry(); // Before entry hook ?>

				<div class="entry-main group">
				<?php 
					
					if (is_archive() || is_home() ) { 
								if ( rolo_type_is( 'contact' ) ) { rolo_contact_header(get_the_ID());}
								if ( rolo_type_is( 'company' ) ) { rolo_company_header(get_the_ID());} ?>
					<?php }
					
					elseif (is_single() ) { 
								if ( rolo_type_is( 'contact' ) ) { rolo_contact_header(get_the_ID()); the_content();
										if ( is_active_sidebar("contact-under-main")){ ?>
											<div class="widget-area contact-under-main">
											<?php dynamic_sidebar("contact-under-main"); ?>
											</div> 
										<?php }
								}

								if ( rolo_type_is( 'company' ) ) { rolo_company_header(get_the_ID()); the_content();
										if ( is_active_sidebar("company-under-main")){ ?>
											<div class="widget-area company-under-main">
											<?php dynamic_sidebar("company-under-main"); ?>
											</div> 
										<?php }
								}
					}
					
					elseif (is_search() ) { echo 'is_search';?>
							<?php 					
								if 
									( rolo_type_is( 'contact' ) ) { rolo_contact_header(get_the_ID()); }
								elseif
									( rolo_type_is( 'company' ) ) { rolo_company_header(get_the_ID()); }
								else { ?>
											<li id="entry-<?php echo basename(get_permalink());?>" class="entry-header">
												<?php echo '<img class="entry-icon" src=' . ROLOPRESS_IMAGES . '/icons/rolo-default.jpg />' ?>
												<a class="entry-title" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
											</li>
								<?php }
					}
									
					elseif (is_page() ) { the_content(); }
							
					else { ?>
								<li id="entry-<?php echo basename(get_permalink());?>" class="entry-header">
									<?php echo '<img class="entry-icon" src=' . ROLOPRESS_IMAGES . '/icons/rolo-default.jpg />' ?>
									<a class="entry-title" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
								</li>
					
					<?php }; ?>
					
				</div><!-- .entry-main -->
					
				<?php rolo_entry_footer(); ?>

				<?php rolopress_after_entry(); // After entry hook ?>

		</li><!-- #entry-<?php the_ID(); ?> -->

<?php endwhile; ?>
</ul><!-- item-list-->

<?php else : // 404 or no search results ?>

		<li id="entry-0" class="<?php rolopress_entry_class(); ?>">
			<?php rolopress_before_entry(); // Before entry hook ?>
				<div class="entry-main">
					<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'rolopress' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-main -->
			<?php rolopress_after_entry(); // After entry hook ?>
		</li><!-- #entry-0 -->

<?php endif;

}; ?>

		

<?php
function rolo_navigation_above() {

global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>

					<div id="nav-above" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-above -->
<?php }
}

add_action('rolopress_before_info', 'rolo_navigation_above');


function rolo_navigation_below() {

global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>

					<div id="nav-below" class="navigation">
					<div class="nav-next"><?php next_posts_link(__( 'Next <span class="meta-nav">&raquo;</span>', 'rolopress' )) ?></div>
					<div class="nav-previous"><?php previous_posts_link(__( '<span class="meta-nav">&laquo;</span> Previous', 'rolopress' )) ?></div>
				</div><!-- #nav-below -->
<?php }
}

add_action('rolopress_after_info', 'rolo_navigation_below');


 
 
?>