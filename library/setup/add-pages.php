<?php
/*
Auto create pages needed for RoloPress

Special thanks to Sarah G for her help with this code
http://www.stuffbysarah.net/wordpress-plugins/
*/

//TODO This should be done only when the theme is activated. 
add_action('init', 'create_new_page');

function create_new_page() {
	global $wpdb;
    //TODO: Should handle this better
    @$sql = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_title = 'Add Contact' LIMIT 1");
    if (@!count($sql)) {
        $add_page = array();
        $add_page['post_title'] = 'Add Contact';
        $add_page['post_type'] = 'page';
        $add_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
        $add_page['post_status'] = 'publish';
        $add_page['post_category'] = array(1);

        $page_id = wp_insert_post($add_page);

        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'contact-add.php');
        }
    }
} 
?>