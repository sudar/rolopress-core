<?php

/* 

Auto create custom fields for RoloPress

Special thanks to
WeFunction.com for their tutorial: http://wefunction.com/2008/10/tutorial-creating-custom-write-panels-in-wordpress/
and David Yeiser for the inspiration: http://artisanthemes.com/themes/wp-contact-manager/
*/

//TODO - We should make the contact_fields array plugable.
//TODO - The meta key name should be added to the contact_fields array.
$contact_fields =
array
(
    "first_name" =>
    array
    (
    "name" => "first_name",
    "filter" => "rolo_contact_first_name",
    "std" => "",
    "title" => "First Name",
    "description" => ""
    ),
    "last_name"=>
    array
    (
    "name" => "last_name",
    "filter" => "rolo_contact_last_name",
    "std" => "",
    "title" => "Last Name",
    "description" => ""
    ),
    "title" =>
    array
    (
    "name" => "title",
    "filter" => "rolo_contact_title",
    "std" => "",
    "title" => "Title",
    "description" => ""
    ),
    "email" =>
    array
    (
    "name" => "email",
    "filter" => "rolo_contact_email",
    "std" => "",
    "title" => "Email",
    "description" => ""
    ),
    "mobile_phone" =>
    array
    (
    "name" => "mobile_phone",
    "filter" => "rolo_contact_mobile_phone",
    "std" => "",
    "title" => "Mobile",
    "description" => ""
    ),
    "work_phone" =>
    array
    (
    "name" => "work_phone",
    "filter" => "rolo_contact_work_phone",
    "std" => "",
    "title" => "Work Phone",
    "description" => ""
    ),
    "home_phone" =>
    array
    (
    "name" => "home_phone",
    "filter" => "rolo_contact_home_phone",
    "std" => "",
    "title" => "Home Phone",
    "description" => ""
    ),
    "fax" =>
    array
    (
    "name" => "fax",
    "filter" => "rolo_contact_fax",
    "std" => "",
    "title" => "Fax",
    "description" => ""
    ),
    "other" =>
    array
    (
    "name" => "other",
    "filter" => "rolo_contact_other",
    "std" => "",
    "title" => "Other Phone",
    "description" => ""
    ),
    "website" =>
    array
    (
    "name" => "website",
    "filter" => "rolo_contact_website",
    "std" => "",
    "title" => "Website",
    "description" => ""
    ),
    "address_1" =>
    array
    (
    "name" => "address_1",
    "filter" => "rolo_contact_address_1",
    "std" => "",
    "title" => "Address 1",
    "description" => ""
    ),
    "address_2" =>
    array
    (
    "name" => "address_2",
    "filter" => "rolo_contact_address_2",
    "std" => "",
    "title" => "Address 2",
    "description" => ""
    ),
    "city" =>
    array
    (
    "name" => "city",
    "filter" => "rolo_contact_city",
    "std" => "",
    "title" => "City",
    "description" => ""
    ),
    "state" =>
    array
    (
    "name" => "state",
    "filter" => "rolo_contact_state",
    "std" => "",
    "title" => "State",
    "description" => ""
    ),
    "postal_code" =>
    array
    (
    "name" => "postal_code",
    "filter" => "rolo_contact_postal_code",
    "std" => "",
    "title" => "Postal Code",
    "description" => ""
    ),
    "country" =>
    array
    (
    "name" => "country",
    "filter" => "rolo_contact_country",
    "std" => "",
    "title" => "Country",
    "description" => ""
    ),
    "image_path" =>
    array
    (
    "name" => "image_path",
    "filter" => "rolo_contact_image_path",
    "std" => "",
    "title" => "Image Path",
    "description" => ""
));

function rolo_append_meta_box() {
    global $post, $contact_fields;

    $rolo_tab_index = 1000;
    foreach($contact_fields as $contact_field) {
        $meta_box_value = get_post_meta($post->ID, $contact_field['name'].'_rolo_value', true);
        if($meta_box_value == "")
            $meta_box_value = $contact_field['std'];
        echo'<input type="hidden" name="'.$contact_field['name'].'_noncename" id="'.$contact_field['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
        echo'<p><label style="letter-spacing:1px; text-transform:uppercase; color:#777;" for="'.$contact_field['name'].'_rolo_value">'.$contact_field['title'].'</label><br/>';
        echo'<input style="padding:4px; font-weight:bold; border-top:1px solid #ccc; border-right:1px solid #ddd; border-bottom:1px solid #ddd; border-left:1px solid #ccc;" type="text" name="'.$contact_field['name'].'_rolo_value" value="'.$meta_box_value.'" size="55" tabindex="'.$rolo_tab_index.'" /></p>';
        $rolo_tab_index++;
    }
}

function rolo_create_meta_box() {
    add_meta_box('rolo_append_meta_box', 'Contact Details', 'new_meta_boxes', 'post', 'normal', 'high');
}

function rolo_save_postdata( $post_id ) {
    global $post, $contact_fields;
    foreach($contact_fields as $contact_field) {
    // Verify
        if ( !wp_verify_nonce( $_POST[$contact_field['name'].'_noncename'], plugin_basename(__FILE__) )) {
            return $post_id;
        }
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
                return $post_id;
        }
        else {
            if ( !current_user_can( 'edit_post', $post_id ))
                return $post_id;
        }

        $data = $_POST[$contact_field['name'].'_rolo_value'];

        //TODO The meta key name for each contact field should be accessed from the contact_fields array
        if(get_post_meta($post_id, $contact_field['name'].'_rolo_value') == "")
            add_post_meta($post_id, $contact_field['name'].'_rolo_value', $data, true);
        elseif($data != get_post_meta($post_id, $contact_field['name'].'_rolo_value', true))
            update_post_meta($post_id, $contact_field['name'].'_rolo_value', $data);
        elseif($data == "")
            delete_post_meta($post_id, $contact_field['name'].'_rolo_value', get_post_meta($post_id, $contact_field['name'].'_rolo_value', true));
    }
}

add_action('admin_menu', 'rolo_create_meta_box');
add_action('save_post', 'rolo_save_postdata');
?>