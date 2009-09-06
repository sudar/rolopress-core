<?php

/* 

Auto create custom fields for RoloPress

Special thanks to
WeFunction.com for their tutorial: http://wefunction.com/2008/10/tutorial-creating-custom-write-panels-in-wordpress/
and David Yeiser for the inspiration: http://artisanthemes.com/themes/wp-contact-manager/
*/

$new_meta_boxes =  
	array
	(
		"rolo_create_contact_info" =>
		array
		(
			"name" => "first_name",
			"std" => "",
			"title" => "First Name",
			"description" => ""
		),
		array
		(
			"name" => "last_name",
			"std" => "",
			"title" => "Last Name",
			"description" => ""
		),
		array
		(
			"name" => "title",
			"std" => "",
			"title" => "Title",
			"description" => ""
		),
		array
		(
			"name" => "email",
			"std" => "",
			"title" => "Email",
			"description" => ""
		),
		array
		(
			"name" => "mobile_phone",
			"std" => "",  
			"title" => "Mobile",
			"description" => ""
		),
		array
		(
			"name" => "work_phone",
			"std" => "",
			"title" => "Work Phone",
			"description" => ""
		),
		array
		(
			"name" => "home_phone",
			"std" => "",
			"title" => "Home Phone",
			"description" => ""
		),
		array
		(
			"name" => "fax",
			"std" => "",
			"title" => "Fax",
			"description" => ""
		),
		array
		(
			"name" => "other",
			"std" => "",
			"title" => "Other Phone",
			"description" => ""
		),
		array
		(
			"name" => "website",
			"std" => "",
			"title" => "Website",
			"description" => ""
		),
		array
		(
			"name" => "address_1",
			"std" => "",
			"title" => "Address 1",
			"description" => ""
		),
		array
		(
			"name" => "address_2",
			"std" => "",
			"title" => "Address 2",
			"description" => ""
		),
		array
		(
			"name" => "city",
			"std" => "",
			"title" => "City",
			"description" => ""
		),
		array
		(
			"name" => "state",
			"std" => "",
			"title" => "State",
			"description" => ""
		),
		array
		(
			"name" => "postal_code",
			"std" => "",
			"title" => "Postal Code",
			"description" => ""
		),
		array
		(
			"name" => "country",
			"std" => "",
			"title" => "Country",
			"description" => ""
		),
		array
		(
			"name" => "image_path",
			"std" => "",
			"title" => "Image Path",
			"description" => ""
		)		
	);

function new_meta_boxes()
{  
	global $post, $new_meta_boxes; 
	$rolo_tab_index = 1000;
	foreach($new_meta_boxes as $meta_box)
	{  
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_rolo_value', true);  
		if($meta_box_value == "")
			$meta_box_value = $meta_box['std'];
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';  
		echo'<p><label style="letter-spacing:1px; text-transform:uppercase; color:#777;" for="'.$meta_box['name'].'_rolo_value">'.$meta_box['title'].'</label><br/>'; 
		echo'<input style="padding:4px; font-weight:bold; border-top:1px solid #ccc; border-right:1px solid #ddd; border-bottom:1px solid #ddd; border-left:1px solid #ccc;" type="text" name="'.$meta_box['name'].'_rolo_value" value="'.$meta_box_value.'" size="55" tabindex="'.$rolo_tab_index.'" /></p>'; 
		$rolo_tab_index++;
	}
}
  
function create_meta_box()
{  
	global $theme_name;  
	if ( function_exists('add_meta_box') )
	{  
		add_meta_box('new-meta-boxes', 'Contact Details', 'new_meta_boxes', 'post', 'normal', 'high');  
	}  
}

function save_postdata( $post_id )
{  
	global $post, $new_meta_boxes;  
	foreach($new_meta_boxes as $meta_box)
	{  
		// Verify  
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))
		{  
			return $post_id;  
		}
		if ( 'page' == $_POST['post_type'] )
		{  
			if ( !current_user_can( 'edit_page', $post_id ))  
			return $post_id;  
		}
		else
		{  
			if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;  
		}
		
		$data = $_POST[$meta_box['name'].'_rolo_value'];
		
		if(get_post_meta($post_id, $meta_box['name'].'_rolo_value') == "")
			add_post_meta($post_id, $meta_box['name'].'_rolo_value', $data, true);  
		elseif($data != get_post_meta($post_id, $meta_box['name'].'_rolo_value', true))
			update_post_meta($post_id, $meta_box['name'].'_rolo_value', $data);
		elseif($data == "")
			delete_post_meta($post_id, $meta_box['name'].'_rolo_value', get_post_meta($post_id, $meta_box['name'].'_rolo_value', true));  
	}  
}
  
add_action('admin_menu', 'create_meta_box');  
add_action('save_post', 'save_postdata');

/**
 * Template function for adding new contact
 */
function rolo_add_contact() {
    if (isset($_POST['rp_add_contact']) && $_POST['rp_add_contact'] == 'add_contact') {
        if (rolo_save_contact_fields()) {
            echo("Contact information succesfully added.");
        } else {
            echo("There was some problem in inserting the contact info");
        }
    }
    rolo_show_contact_fields();
}

/**
 * Show the list of contact fields in add contact page
 * @global array $new_meta_boxes List of contact fields
 */
function rolo_show_contact_fields() {
	global $new_meta_boxes;
	$rolo_tab_index = 1000;
?>
<form action="" method="post">
<?php
	foreach($new_meta_boxes as $meta_box) {

        $meta_box_value = $meta_box['std'];

		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		echo'<p><label style="letter-spacing:1px; text-transform:uppercase; color:#777;" for="'.$meta_box['name'].'_rolo_value">'.$meta_box['title'].'</label><br/>';
		echo'<input style="padding:4px; font-weight:bold; border-top:1px solid #ccc; border-right:1px solid #ddd; border-bottom:1px solid #ddd; border-left:1px solid #ccc;" type="text" name="'.$meta_box['name'].'_rolo_value" value="'.$meta_box_value.'" size="55" tabindex="'.$rolo_tab_index.'" /></p>';
		$rolo_tab_index++;
	}
?>
    <input type="hidden" name="rp_add_contact" value="add_contact" />
    <input type="submit" value="Add Contact" />
</form>
<?php
}

/**
 * Save contact fields to database
 * @global array $new_meta_boxes List of contact fields
 * @return string|boolean Post id if succesful and false if on error
 */
function rolo_save_contact_fields() {
	global $new_meta_boxes;

    $new_post = array();

    $new_post['post_title'] = $_POST['first_name_rolo_value'];
    if (isset($_POST['last_name_rolo_value'])) {
        $new_post['post_title'] .= ' ' . $new_post['post_title'];
    }
    
    $new_post['post_type'] = 'post';
    $new_post['post_status'] = 'publish';
    $new_post['post_category'] = array(1);

    $post_id = wp_insert_post($new_post);

	foreach($new_meta_boxes as $meta_box) {
		// Verify
        //TODO - Check whether the current use is logged in or not
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))
		{
			return false;
		}

		$data = $_POST[$meta_box['name'].'_rolo_value'];

//		if(get_post_meta($post_id, $meta_box['name'].'_rolo_value') == "")
//			add_post_meta($post_id, $meta_box['name'].'_rolo_value', $data, true);
//		elseif($data != get_post_meta($post_id, $meta_box['name'].'_rolo_value', true))
//			update_post_meta($post_id, $meta_box['name'].'_rolo_value', $data);
//		elseif($data == "")
//			delete_post_meta($post_id, $meta_box['name'].'_rolo_value', get_post_meta($post_id, $meta_box['name'].'_rolo_value', true));

		if($data == "") {
            delete_post_meta($post_id, $meta_box['name'].'_rolo_value', get_post_meta($post_id, $meta_box['name'].'_rolo_value', true));
        } else {
			update_post_meta($post_id, $meta_box['name'].'_rolo_value', $data);
        }
	}
    return $post_id;
}
?>