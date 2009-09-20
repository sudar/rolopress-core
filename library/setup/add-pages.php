<?php
/*
Auto create pages needed for RoloPress

Special thanks to Sarah G for her help with this code
http://www.stuffbysarah.net/wordpress-plugins/
*/

// Code based on http://www.nabble.com/Activation-hook-exist-for-themes--td25211004.html
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    rolo_create_initial_pages();
}

/**
 * Create initial pages
 * @global object $wpdb
 */
function rolo_create_initial_pages() {
    global $wpdb;

    // Create a new Add Contact page
    //TODO: Check for proper user permission

    $contact_page = get_page_by_title("Add Contact");
    if (!($contact_page->ID >  0)) {
        $add_page = array();
        $add_page['post_title'] = 'Add Contact';
        $add_page['post_type'] = 'page';
        $add_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $add_page['post_status'] = 'publish';
//        $add_page['post_category'] = array(1);

        // TODO add current user id [post_author] =>    [post_date]
        $page_id = wp_insert_post($add_page);

        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'contact-add.php');
        }
    }

    // Create a new Add Company page
    
    //TODO: Should handle this better
    $company_page = get_page_by_title("Add Company");
    if (!($company_page->ID >  0)) {
        $add_page = array();
        $add_page['post_title'] = 'Add Company';
        $add_page['post_type'] = 'page';
        $add_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $add_page['post_status'] = 'publish';
        
        $add_page['post_category'] = array(1);

        // TODO add current user id [post_author] =>    [post_date]

        $page_id = wp_insert_post($add_page);

        if ($page_id) {
            // Set the page template
            update_post_meta($page_id, '_wp_page_template', 'company-add.php');
        }
    }
}
?>