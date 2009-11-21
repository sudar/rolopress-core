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
    'name' => 'first_name',
    'class' => 'first_name',
    'filter' => "rolo_contact_first_name",
    'default_value' => '',
    'title' => "First Name",
    'description' => '',
    'mandatory' => true
    ),
    "last_name"=>
    array
    (
    'name' => 'last_name',
    'class' => 'last_name',
    'filter' => "rolo_contact_last_name",
    'default_value' => '',
    'title' => "Last Name",
    'description' => '',
    'mandatory' => true
    ),
    'title' =>
    array
    (
    'name' => 'title',
    'class' => 'title',
    'filter' => "rolo_contact_title",
    'default_value' => '',
    'title' => 'Title',
    'description' => ''
    ),
    "company" =>
    array
    (
    'name' => 'company',
    'class' => 'company',
    'filter' => "rolo_contact_company",
    'default_value' => '',
    'title' => "Company",
    'description' => '',
    'setup_function' => 'rolo_setup_contact_company',
    'save_function' => 'rolo_save_contact_company'
    ),
    "email" =>
    array
    (
    'name' => 'email',
    'class' => 'email',
    'filter' => "rolo_contact_email",
    'default_value' => '',
    'title' => "Email",
    'description' => ''
    ),
    "phone" =>
    array
    (
    'multiple' => array ('Home', 'Mobile', 'Work', 'Fax', 'Other'),
    'name' => 'phone',
    'class' => 'phone',
    'filter' => "rolo_contact_phone_",
    'default_value' => '',
    'title' => "Phone",
    'description' => '',
    'setup_function' => 'rolo_setup_contact_multiple',
    'save_function' => 'rolo_save_contact_multiple'
    ),
    "website" =>
    array
    (
    'name' => 'website',
    'class' => 'website',
    'filter' => "rolo_contact_website",
    'default_value' => "http://",
    'title' => "Website",
    'description' => ''
    ),
    'im' =>
    array
    (
    'multiple' => array ('Yahoo', 'MSN', 'AOL', 'GTalk', 'Skype'),
    'name' => 'im',
    'class' => 'im',
    'filter' => "rolo_contact_IM_",
    'default_value' => '',
    'title' => "IM",
    'description' => '',
    'setup_function' => 'rolo_setup_contact_multiple',
    'save_function' => 'rolo_save_contact_multiple'
    ),
    'twitter' =>
    array
    (
    'name' => 'twitter',
    'class' => 'twitter',
    'filter' => "rolo_contact_twitter",
    'default_value' => '',
    'title' => "Twitter",
	'url_preface' => "http://twitter.com/",
    'description' => ''
    ),
    "address" =>
    array
    (
    'name' => 'address',
    'class' => 'address',
    'filter' => "rolo_contact_address",
    'default_value' => '',
    'title' => "Address",
    'description' => '',
    "setup_function" => 'rolo_setup_contact_address',
    'save_function' => 'rolo_save_contact_address'
    ),
    'info' =>
    array
    (
    'name' => 'info',
    'class' => 'info',
    'filter' => "rolo_contact_info",
    'default_value' => '',
    'title' => "Background Info",
    'description' => '',
    'setup_function' => 'rolo_setup_contact_info',
    'save_function' => 'rolo_save_contact_info'
    )
);

$company_fields =
array
(
    'name' =>
    array
    (
    'name' => 'name',
    'class' => 'name',
    'filter' => "rolo_company_name",
    'default_value' => '',
    'title' => "Company name",
    'description' => '',
    'mandatory' => true
    ),
    "email" =>
    array
    (
    'name' => 'email',
    'class' => 'email',
    'filter' => "rolo_company_email",
    'default_value' => '',
    'title' => "Email",
    'description' => '',
    'mandatory' => false
    ),
    "phone" =>
    array
    (
    'multiple' => array ('Home', 'Mobile', 'Work', 'Fax', 'Other'),
    'name' => 'phone',
    'class' => 'phone',
    'filter' => "rolo_company_phone_",
    'default_value' => '',
    'title' => "Phone",
    'description' => '',
    'setup_function' => 'rolo_setup_company_multiple',
    'save_function' => 'rolo_save_company_multiple'
    ),
    "website" =>
    array
    (
    'name' => 'website',
    'class' => 'website',
    'filter' => "rolo_company_website",
    'default_value' => "http://",
    'title' => "Website",
    'description' => ''
    ),
    'im' =>
    array
    (
    'multiple' => array ('Yahoo', 'MSN', 'AOL', 'GTalk', 'Skype'),
    'name' => 'im',
    'class' => 'im',
    'filter' => "rolo_company_IM_",
    'default_value' => '',
    'title' => "IM",
    'description' => '',
    'setup_function' => 'rolo_setup_company_multiple',
    'save_function' => 'rolo_save_company_multiple'
    ),
    'twitter' =>
    array
    (
    'name' => 'twitter',
    'class' => 'twitter',
    'filter' => "rolo_company_twitter",
    'default_value' => "http://twitter.com/",
    'title' => "Twitter",
    'description' => ''
    ),
    "address" =>
    array
    (
    'name' => 'address',
    'class' => 'address',
    'filter' => "rolo_company_address",
    'default_value' => '',
    'title' => "Address",
    'description' => '',
    "setup_function" => 'rolo_setup_company_address',
    'save_function' => 'rolo_save_company_address'
    ),
    'info' =>
    array
    (
    'name' => 'info',
    'class' => 'info',
    'filter' => "rolo_company_info",
    'default_value' => '',
    'title' => "Background Info",
    'description' => '',
    'setup_function' => 'rolo_setup_company_info',
    'save_function' => 'rolo_save_company_info'
    )
);

/**
 *
 * @global <type> $post
 * @global <type> $contact_fields
 */
function rolo_append_meta_box() {
    global $post, $contact_fields;

    $rolo_tab_index = 1000;
    foreach($contact_fields as $contact_field) {
        $meta_box_value = get_post_meta($post->ID, $contact_field['name'].'_rolo_value', true);
        if($meta_box_value == '')
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
        if(get_post_meta($post_id, $contact_field['name'].'_rolo_value') == '')
            add_post_meta($post_id, $contact_field['name'].'_rolo_value', $data, true);
        elseif($data != get_post_meta($post_id, $contact_field['name'].'_rolo_value', true))
            update_post_meta($post_id, $contact_field['name'].'_rolo_value', $data);
        elseif($data == '')
            delete_post_meta($post_id, $contact_field['name'].'_rolo_value', get_post_meta($post_id, $contact_field['name'].'_rolo_value', true));
    }
}

//add_action('admin_menu', 'rolo_create_meta_box');
//add_action('save_post', 'rolo_save_postdata');
?>