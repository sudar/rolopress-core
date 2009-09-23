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
    "description" => "",
    "mandatory" => true
    ),
    "last_name"=>
    array
    (
    "name" => "last_name",
    "filter" => "rolo_contact_last_name",
    "std" => "",
    "title" => "Last Name",
    "description" => "",
    "mandatory" => true
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
    "phone" =>
    array
    (
    'multiple' => array ('Home', 'Mobile', 'Work', 'Fax', 'Other'),
    "name" => "phone",
    "filter" => "rolo_contact_phone_",
    "std" => "",
    "title" => "Phone",
    "description" => "",
    'setup_function' => 'rolo_setup_contact_multiple',
    'save_function' => 'rolo_save_contact_multiple'
    ),
    "website" =>
    array
    (
    "name" => "website",
    "filter" => "rolo_contact_website",
    "std" => "http://",
    "title" => "Website",
    "description" => ""
    ),
    'im' =>
    array
    (
    'multiple' => array ('Yahoo', 'MSN', 'AOL', 'GTalk', 'Skype'),
    "name" => "im",
    "filter" => "rolo_contact_IM_",
    "std" => "",
    "title" => "IM",
    "description" => "",
    'setup_function' => 'rolo_setup_contact_multiple',
    'save_function' => 'rolo_save_contact_multiple'
    ),
    'twitter' =>
    array
    (
    "name" => "twitter",
    "filter" => "rolo_contact_twitter",
    "std" => "http://twitter.com/",
    "title" => "Twitter",
    "description" => ""
    ),
    "address" =>
    array
    (
    "name" => "address",
    "filter" => "rolo_contact_address",
    "std" => "",
    "title" => "Address",
    "description" => "",
    "setup_function" => 'rolo_setup_contact_address',
    'save_function' => 'rolo_save_contact_address'
    )
//    array
//    (
//    "name" => "address_1",
//    "filter" => "rolo_contact_address_1",
//    "std" => "",
//    "title" => "Address 1",
//    "description" => ""
//    ),
//    "address_2" =>
//    array
//    (
//    "name" => "address_2",
//    "filter" => "rolo_contact_address_2",
//    "std" => "",
//    "title" => "Address 2",
//    "description" => ""
//    ),
//    "city" =>
//    array
//    (
//    "name" => "city",
//    "filter" => "rolo_contact_city",
//    "std" => "",
//    "title" => "City",
//    "description" => ""
//    ),
//    "state" =>
//    array
//    (
//    "name" => "state",
//    "filter" => "rolo_contact_state",
//    "std" => "",
//    "title" => "State",
//    "description" => ""
//    ),
//    "postal_code" =>
//    array
//    (
//    "name" => "postal_code",
//    "filter" => "rolo_contact_postal_code",
//    "std" => "",
//    "title" => "Postal Code",
//    "description" => ""
//    ),
//    "country" =>
//    array
//    (
//    "name" => "country",
//    "filter" => "rolo_contact_country",
//    "std" => "",
//    "title" => "Country",
//    "description" => ""
//    ),
//    "image_path" =>
//    array
//    (
//    "name" => "image_path",
//    "filter" => "rolo_contact_image_path",
//    "std" => "",
//    "title" => "Image Path",
//    "description" => ""
//)
);

/**
 * Setup field for editing address
 * 
 * @global <type> $contact_fields
 * @param <type> $field_name
 */
function rolo_setup_contact_address($field_name, &$rolo_tab_index) {
    global $contact_fields;

    $address_field = $contact_fields[$field_name];
?>
        <div class="ctrlHolder">
            <label for="rolo_contact_address">
<?php
                if ($address_field['mandatory'] == true) {
                    echo '<em>*</em>';
                }
                echo $address_field['title'];
?>
            </label>
            <textarea rows="3" cols="20" name ="rolo_contact_address" tabindex="<?php echo $rolo_tab_index++;?>" ></textarea>
        </div>

        <div class="ctrlHolder">
            <label for="rolo_contact_city"></label>
            <input type="text" name="rolo_contact_city" value="<?php echo $meta_box_value ;?>" size="30" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput city" />
            <input type="text" name="rolo_contact_state" value="<?php echo $meta_box_value ;?>" size="15" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput state" />
            <input type="text" name="rolo_contact_zip" value="<?php echo $meta_box_value ;?>" size="10" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput zip" />
        </div>

        <div class="ctrlHolder">
            <label for="rolo_contact_country"></label>
            <input type="text" name="rolo_contact_country" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput" />
        </div>
<?php
}

/**
 * Save contact address information
 *
 * @param <type> $field_name
 * @param <type> $post_id
 */
function rolo_save_contact_address($field_name, $post_id) {
    // TODO - Validate fields

    update_post_meta($post_id, 'rolo_contact_address', $_POST['rolo_contact_address']);
    update_post_meta($post_id, 'rolo_contact_city', $_POST['rolo_contact_city']);
    update_post_meta($post_id, 'rolo_contact_state', $_POST['rolo_contact_state']);
    update_post_meta($post_id, 'rolo_contact_zip', $_POST['rolo_contact_zip']);
    update_post_meta($post_id, 'rolo_contact_country', $_POST['rolo_contact_country']);
}

/**
 * Setup function for fields involving more than one instance (phone, IM)
 *
 * @global <type> $contact_fields
 * @param <type> $field_name
 */
function rolo_setup_contact_multiple($field_name, &$rolo_tab_index) {
    global $contact_fields;

    $multiple_field = $contact_fields[$field_name];
    $multiples = $multiple_field['multiple'];

    $options = "";
    foreach ($multiples as $option) {
        $options .= "<option value ='$option'>$option</option>";
    }

    for ($i = 0 ; $i < count($multiples) ; $i++) {

        $multiple = $multiples[$i];
        
        $name = $multiple_field['name'] . "[$i]";
        $select_name = $multiple_field['name'] . "_select[$i]";
        if ($i == 0) {
            $ctrl_class = ' multipleInput ' . $multiple_field['name'];
            $title = $multiple_field['title'];
        } else {
            $ctrl_class = ' multipleInput ctrlHidden ' . $multiple_field['name'];
            $title = '';
        }
?>
        <div class="ctrlHolder<?php echo $ctrl_class;?>">

            <label for="<?php echo $name;?>">
                <?php echo $title;?>
            </label>
            <input type="text" name="<?php echo $name;?>" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput" />
            <select name="<?php echo $select_name;?>" tabindex="<?php echo $rolo_tab_index++;?>">
                <?php echo $options;?>
            </select>
<?php
            if ($i == 0) {
                $hidden = 'style = "display:none"';
            } else {
                $hidden = '';
            }
?>
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/delete.png" class="rolo_delete_ctrl" alt="<?php _e('Delete');?>" <?php echo $hidden;?> />
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another');?>" />
        </div>
<?php
    }
}

/**
 * Save function for multiple fields
 *
 * @global <type> $contact_fields
 * @param <type> $field_name
 * @param <type> $post_id
 */
function rolo_save_contact_multiple($field_name, $post_id) {
    global $contact_fields;

    $multiple_field = $contact_fields[$field_name];

    // TODO - Validate fields

    $multiple_field_values  = $_POST[$multiple_field['name']];
    $multiple_field_selects = $_POST[$multiple_field['name'] . '_select'];

    for ($i = 0 ; $i < count($multiple_field_values) ; $i++) {
        update_post_meta($post_id, 'rolo_contact_' . $multiple_field['name'] . '_' . $multiple_field_selects[$i], $multiple_field_values[$i]);
    }
}

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

//add_action('admin_menu', 'rolo_create_meta_box');
//add_action('save_post', 'rolo_save_postdata');
?>