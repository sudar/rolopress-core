<?php
/**
 * Default Pages
 *
 * Auto create pages needed for RoloPress
 *
 * Special thanks to Sarah G for her help with this code
 * http://www.stuffbysarah.net/wordpress-plugins
 *
 * @package RoloPress
 */
 
/**
 * Create initial pages
 * @global object $wpdb
 * @since 0.1
 */
function rolo_create_initial_pages() {
    global $wpdb;
    //TODO: Check for proper user permission

    // Create a new Add Contact page
    $add_contact_page = get_page_by_title("Add Contact");
    if (!($add_contact_page->ID >  0)) {
        $new_page = array();
        $new_page['post_title'] = 'Add Contact';
        $new_page['post_type'] = 'page';
        $new_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $new_page['post_status'] = 'publish';

        // TODO add current user id [post_author] =>    [post_date]
        $page_id = wp_insert_post($new_page);

        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'contact-add.php');
        }
    }

    // Create a new Add Company page
    $add_company_page = get_page_by_title("Add Company");
    if (!($add_company_page->ID >  0)) {
        $new_page = array();
        $new_page['post_title'] = 'Add Company';
        $new_page['post_type'] = 'page';
        $new_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $new_page['post_status'] = 'publish';

        // TODO add current user id [post_author] =>    [post_date]
        $page_id = wp_insert_post($new_page);

        if ($page_id) {
            // Set the page template
            update_post_meta($page_id, '_wp_page_template', 'company-add.php');
        }
    }

    // Create a new Edit Contact page
    $edit_contact_page = get_page_by_title("Edit Contact");
    if (!($edit_contact_page->ID >  0)) {
        $new_page = array();
        $new_page['post_title'] = 'Edit Contact';
        $new_page['post_type'] = 'page';
        $new_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $new_page['post_status'] = 'publish';

        // TODO add current user id [post_author] =>    [post_date]
        $page_id = wp_insert_post($new_page);

        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'contact-edit.php');
        }
    }

    // Create a new Edit Company page
    $edit_company_page = get_page_by_title("Edit Company");
    if (!($edit_company_page->ID >  0)) {
        $new_page = array();
        $new_page['post_title'] = 'Edit Company';
        $new_page['post_type'] = 'page';
        $new_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $new_page['post_status'] = 'publish';

        // TODO add current user id [post_author] =>    [post_date]
        $page_id = wp_insert_post($new_page);

        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'company-edit.php');
        }
    }
}
add_action('init', 'rolo_create_initial_pages', 0);

?>