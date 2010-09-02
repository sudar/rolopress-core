<?php
/**
 * Add/Delete Posts and Pages
 *
 * Auto create/delete posts/pages needed for RoloPress
 *
 * Special thanks to Sarah G for her help with this code
 * http://www.stuffbysarah.net/wordpress-plugins
 *
 * @package RoloPress
 */
 
 
/**
 * Delete Hello world! post
 * @since 1.4
 */
function rolo_goodbye_world() {
	$remove_post = get_post_by_title('Hello world!');
	wp_delete_post($remove_post->ID);
};
add_action('init', 'rolo_goodbye_world', 0);
 
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

/**
 * Create initial posts (contact and company)
 * @global object $wpdb
 * @since 1.4
 */
function rolo_create_initial_posts() {
    global $wpdb;
    //TODO: Check for proper user permission

    $company_name = "RoloPress Inc";
	$company_website = "www.RoloPress.com";
	$company_twitter = "rolopress";
	$company_email = "info@rolopress.com";
	$contact_first_name = "Rolo";
	$contact_last_name = "Press";
	$contact_name = $contact_first_name . " " . $contact_last_name;
	
    // Create a default company
    $default_company_post = get_post_by_title($company_name);
    if (!($default_company_post->ID >  0)) {
        $new_post = array();
        $new_post['post_title'] = $company_name;
        $new_post['post_type'] = 'post';
        $new_post['post_content'] = 'This is a sample company. You can delete this if you like.<br/>You might be interested to know that the company picture is being pulled from twitter.';
        $new_post['post_status'] = 'publish';

        $post_id = wp_insert_post($new_post);
		update_post_meta($post_id, 'rolo_company_name', $company_name);

        $new_company = array();
        $new_company['rolo_company_name'] = $company_name;
        $new_company['rolo_company_website'] = $company_website;
        $new_company['rolo_company_twitter'] = $company_twitter;
        $new_company['rolo_company_email'] = $company_email;
		update_post_meta($post_id, 'rolo_company' , $new_company);

		wp_set_post_terms($post_id, 'Company', 'type');

        $current_name = wp_get_post_terms($post_id, 'company');
        if (count($current_name) > 0) {
            //update the current taxonomy
            $new_value = array();
            $new_value['name'] = $company_name;
            $new_value['term_id'] = $current_name[0]->term_id;
            wp_update_term($current_name[0]->term_id, 'company', $new_value);
        } else {
            // create the new taxonomy
            wp_set_post_terms($post_id, $company_name, 'company', true);
        }
	}
	
	  // Create a default contact
    $default_contact_post = get_post_by_title($contact_name);
    if (!($default_contact_post->ID >  0)) {
        $new_post = array();
        $new_post['post_title'] = $contact_name;
        $new_post['post_type'] = 'post';
        $new_post['post_content'] = 'This is a sample contact. You can delete this if you like.<br/> (Yes, we know this wasn\'t the most creative name we can come up with)';
        $new_post['post_status'] = 'publish';

        $post_id = wp_insert_post($new_post);
		update_post_meta($post_id, 'rolo_contact_first_name', $contact_first_name);
		update_post_meta($post_id, 'rolo_contact_last_name', $contact_last_name);

        $new_contact = array();
        $new_contact['rolo_contact_first_name'] = $contact_first_name;
        $new_contact['rolo_contact_last_name'] = $contact_last_name;
        update_post_meta($post_id, 'rolo_contact' , $new_contact);

		wp_set_post_terms($post_id, 'Contact', 'type');
        // Set the custom taxonmy for the post
        wp_set_post_terms($post_id, $company_name, 'company');
	}
}
add_action('init', 'rolo_create_initial_posts', 0);

?>