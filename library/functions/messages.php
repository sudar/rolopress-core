<?php
/**
 * User Messages
 *
 * One place to keep all user messages
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

/**
 * Default message for Widget page templates
 *
 * @since 1.2
 */
function rolo_add_some_widgets_message() { ?>
		<div class="default-text">
		<?php _e('This page is totally widgetized.','rolopress')?> <a href="/wp-admin/widgets.php"><?php _e('Just drop some widgets here to fill it up.','rolopress')?></a>
		</div>
<?php }

/**
 * On inital setup if no contacts or companies are created then 
 * the menu items produce a 404
 * This will provide instructions on how to fix
 *
 * @since 1.2
 */
function rolo_type_tax_message() { ?>
	<h3>
	<?php _e('If you want to get rid of this message, you really need to enter a ','rolopress') ?>
	<a href="/add-contact/"><?php _e('Contact','rolopress') ?></a>
	<?php _e(' and a ','rolopress') ?>
	<a href="/add-company/"><?php _e('Company.','rolopress') ?></a><br/>
	<?php _e('You may also want to make sure your ','rolopress') ?>
	<a href="/wp-admin/options-permalink.php"><?php _e('Permalinks','rolopress') ?></a>
	<?php _e(' are set to ','rolopress') ?>
	<strong><?php _e('%postname%','rolopress') ?></strong><?php _e(' in "Custom Structure".','rolopress') ?>
	</h3>
<?php }


/**
 * 404 Message
 *
 * @since 1.2
 */
function rolo_404_message() { ?>
	<p>
	<?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'rolopress' ); ?></p>
	<?php get_search_form();
}









?>