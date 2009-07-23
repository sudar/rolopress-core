<?php
/*
Auto create pages needed for RoloPress

Special thanks to Sarah G for her help with this code
http://www.stuffbysarah.net/wordpress-plugins/
*/

add_action('init', 'create_new_page');

function create_new_page() {
	global $wpdb;
        @$sql = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_title = 'Add Contact' LIMIT 1");
        if (@!count($sql)) :
          $add_page = array();
          $add_page['post_title'] = 'Add Contact';
          $add_page['post_type'] = 'page';
          $add_page['post_content'] = 'This page was automatically created by RoloPress.  Do not delete.';
          $add_page['post_status'] = 'publish';
		  // $add_page['page_template'] = 'add_contact.php';  * doesn't work *
          $add_page['post_category'] = array(1);
           wp_insert_post($add_page);
      endif;
} 
?>