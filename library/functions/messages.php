<?php
/**
 * User Messages
 *
 * One place to edit all user messages
 *
 * @package RoloPress
 * @subpackage Functions
 */


/**
 * Displays when user views a page and does not have the proper permissions
 *
 * @since 1.2
 */
 
function rolo_permission_message() { ?>
		<li id="entry-0" class="<?php rolopress_entry_class(); ?> no-permission">
			<?php rolopress_before_entry(); // Before entry hook ?>
				<div class="entry-main">
					<p><?php _e( 'Sorry, you don\'t have permission to view this page.', 'rolopress' ); ?></p>
				</div><!-- .entry-main -->
			<?php rolopress_after_entry(); // After entry hook ?>
		</li><!-- #entry-0 -->
<?php }

function rolo_add_some_widgets_message() { ?>
		<div class="default-text">
		<?php _e('This page is totally widgetized.','rolopress')?> <a href="/wp-admin/widgets.php"><?php _e('Just drop some widgets here to fill it up.','rolopress')?></a>
		</div>
<?php }
?>