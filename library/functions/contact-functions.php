<?php
/* 
 * Rolopress - Adds function related to setting up and saving contacts
 */

/**
 * Template function for adding new contact
 */
function rolo_add_contact() {

    $user = wp_get_current_user();
    if ( $user->ID ) {

        //TODO - Check user cababilites
        //TODO - Verify nounce here

        if (isset($_POST['rp_add_contact']) && $_POST['rp_add_contact'] == 'add_contact') {
            $contact_id = _rolo_save_contact_fields();
            if ($contact_id) {
                echo __("Contact information successfully added.");
            } else {
                echo __("There was some problem in inserting the contact info");
    //            TODO - Handle Error properly
            }
        } elseif (isset($_POST['rp_add_notes']) && $_POST['rp_add_notes'] == 'add_notes') {
            if (_rolo_save_contact_notes()) {
                echo __("Notes successfully added.");
            } else {
    //            TODO - Handle Error properly
                echo __("There was some problem in inserting the notes");
            }
        } else {
            _rolo_show_contact_fields();
        }
    }
}

/**
 * Show the list of contact fields in add contact page
 * @global array $company_fields List of contact fields
 */
function _rolo_show_contact_fields() {
	global $contact_fields;
	$rolo_tab_index = 1000;
//                <input type="hidden" name="<?php echo $name.'_noncename';? >" id="< ?php echo $name.'_noncename';? >" value="< ? php echo wp_create_nonce( plugin_basename(__FILE__) ); ? >" />
?>
<form action="" method="post" class="uniForm inlineLabels" id="contact-add">
    <div id="errorMsg">
        <h3><?php _e('Oops!, We Have a Problem.');?></h3>
        <ol>
        </ol>
    </div>

    <fieldset class="inlineLabels">


<?php
	foreach($contact_fields as $contact_field) {

        if (function_exists($contact_field['setup_function'])){
            call_user_func_array($contact_field['setup_function'], array($contact_field['name'], &$rolo_tab_index));
        } else {

            $default_value = $contact_field['default_value'];
            $name = 'rolo_contact_' . $contact_field['name'];
            $class = $contact_field['class'];
?>
        <div class="ctrlHolder <?php echo $contact_field['class']?>">
            <label for="<?php echo $name;?>">
<?php
                    if ($contact_field['mandatory'] == true) {
                        echo '<em>*</em>';
                    }
                    echo $contact_field['title'];
					
					if (isset($contact_field['prefix']) == true) {		
						echo '<span class="prefix '; echo $contact_field['name']; echo '">'; echo $contact_field['prefix']; echo '</span>';
						$class = $contact_field['class'] . " " . "input-prefix";
                    }
?>
            </label>
            <input type="text" name="<?php echo $name;?>" value="<?php echo $default_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index;?>" class="textInput <?php echo $class;?>" />
        </div>
<?php
            $rolo_tab_index++;
        }
	}
?>
    </fieldset>
   <div class="buttonHolder">
      <input type="hidden" name="rp_add_contact" value="add_contact" />
      <button type="submit" name="submit" id="submit" class="submitButton" tabindex="<?php echo $rolo_tab_index++;?>" ><?php _e('Add Contact');?></button>
   </div>
</form>
<?php
}

/**
 * Save contact fields to database
 *
 * @global array $company_fields List of contact fields
 * @return string|boolean Post id if succesful and false if on error
 */
function _rolo_save_contact_fields() {
	global $contact_fields;

    //TODO - Check whether the current use is logged in or not
    //TODO - Check for nounce

    // Verify
//    if ( !wp_verify_nonce( $_POST[$contact_field['name'].'_noncename'], plugin_basename(__FILE__) )) {
//        return false;
//        }

    $new_post = array();

    $new_post['post_title'] = $_POST['rolo_contact_first_name'];
    if (isset($_POST['rolo_contact_last_name'])) {
        $new_post['post_title'] .= ' ' . $_POST['rolo_contact_last_name'];
    }

    $new_post['post_type'] = 'post';
    $new_post['post_status'] = 'publish';

    $post_id = wp_insert_post($new_post);

    // Store only first name and last name as seperate custom fields
    update_post_meta($post_id, 'rolo_contact_first_name', $_POST['rolo_contact_first_name']);
    update_post_meta($post_id, 'rolo_contact_last_name', $_POST['rolo_contact_last_name']);

    if ($post_id) {
        $new_contact = array();

        foreach($contact_fields as $contact_field) {

            if (function_exists($contact_field['save_function'])){
               call_user_func_array($contact_field['save_function'], array($contact_field['name'], $post_id, &$new_contact));
            } else {

                $data = $_POST['rolo_contact_' . $contact_field['name']];

    //            TODO - Validate data
                $new_contact['rolo_contact_' . $contact_field['name']] = $data;
//                update_post_meta($post_id, 'rolo_contact_' . $contact_field['name'], $data);
            }
        }

        // store the array as post meta
        update_post_meta($post_id, 'rolo_contact' , $new_contact);

        // Set the custom taxonmy for the post
        wp_set_post_terms($post_id, 'Contact', 'type');
    } else {
//        TODO - handle error
    }
    return $post_id;
}

/**
 * Show add notes field
 *
 * @param <type> $contact_id
 */
function _rolo_show_contact_notes($contact_id) {
?>
<form action="" method="post" class="uniForm inlineLabels">
    <div id="errorMsg">
        <h3><?php _e('Oops!, We Have a Problem.');?></h3>
        <ol>
        </ol>
    </div>

    <fieldset class="inlineLabels">

      <legend><?php _e('Add notes');?></legend>

        <div class="ctrlHolder">
            <label for="rolo_contact_notes">
                <?php _e('Notes');?>
            </label>
            <textarea rows="3" cols="20" name ="rolo_contact_notes" class="textArea notes"></textarea>
        </div>
    </fieldset>
   <div class="buttonHolder">
      <input type="hidden" name="rp_add_notes" value="add_notes" />
      <input type="hidden" name="rolo_contact_id" value="<?php echo $contact_id; ?>" />
      <button type="submit" name="submit" id="submit" class="submitButton"><?php _e('Add Notes');?></button>
   </div>

</form>
<?php
}

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
            <textarea rows="3" cols="20" name ="rolo_contact_address" tabindex="<?php echo $rolo_tab_index++;?>" class="textArea address" ></textarea>
        </div>

<?php
        //TODO: Set the default values in a proper way
?>
        <div class="ctrlHolder">
            <input type="text" name="rolo_contact_city" value="<?php _e('City', 'rolopress') ;?>" size="30" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput city" onChange=applet onFocus="this.value='';this.onfocus='';" />
            <input type="text" name="rolo_contact_state" value="<?php _e('State', 'rolopress') ;?>" size="15" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput state" onChange=applet onFocus="this.value='';this.onfocus='';" />
            <input type="text" name="rolo_contact_zip" value="<?php _e('Zip', 'rolopress') ;?>" size="10" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput zip" onChange=applet onFocus="this.value='';this.onfocus='';" />
        </div>

        <div class="ctrlHolder">
            <label for="rolo_contact_country"></label>
            <input type="text" name="rolo_contact_country" value="<?php _e('Country', 'rolopress') ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput country" onChange=applet onFocus="this.value='';this.onfocus='';" />
        </div>
<?php
}

/**
 * Save contact address information
 *
 * @param <type> $field_name
 * @param <type> $post_id
 */
function rolo_save_contact_address($field_name, $post_id, &$new_contact) {
    // TODO - Validate fields

    $new_contact['rolo_contact_address'] = $_POST['rolo_contact_address'];
    $new_contact['rolo_contact_city'] = ($_POST['rolo_contact_city'] == 'City') ? '' : $_POST['rolo_contact_city'];
    $new_contact['rolo_contact_state'] = ($_POST['rolo_contact_state'] == 'State') ? '' : $_POST['rolo_contact_state'];
    $new_contact['rolo_contact_zip'] = ($_POST['rolo_contact_zip'] == 'Zip') ? '' : $_POST['rolo_contact_zip'];
    $new_contact['rolo_contact_country'] = ($_POST['rolo_contact_country'] == 'Country') ? '' : $_POST['rolo_contact_country'];

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

        $name  = $multiple_field['name'] . "[$i]";
        $class = $multiple_field['class'];
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
            <input type="text" name="<?php echo $name;?>" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput <?php echo $class;?>" />
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
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/forms/delete.png" class="rolo_delete_ctrl" alt="<?php _e('Delete');?>" <?php echo $hidden;?> />
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/forms/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another');?>" />
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
function rolo_save_contact_multiple($field_name, $post_id, &$new_contact) {
    global $contact_fields;

    $multiple_field = $contact_fields[$field_name];

    // TODO - Validate fields

    $multiple_field_values  = $_POST[$multiple_field['name']];
    $multiple_field_selects = $_POST[$multiple_field['name'] . '_select'];

    for ($i = 0 ; $i < count($multiple_field_values) ; $i++) {
//        update_post_meta($post_id, 'rolo_contact_' . $multiple_field['name'] . '_' . $multiple_field_selects[$i], $multiple_field_values[$i]);
        $new_contact['rolo_contact_' . $multiple_field['name'] . '_' . $multiple_field_selects[$i]] = $multiple_field_values[$i];
    }
}

/**
 * Setup function for background info
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be shown
 * @param <type> $rolo_tab_index
 */
function rolo_setup_contact_info($field_name, &$rolo_tab_index) {
    global $contact_fields;

    $info_field = $contact_fields[$field_name];
    $name = 'rolo_contact_' . $info_field['name'];
?>
    <div class="ctrlHolder">
        <label for="<?php echo $name;?>">
<?php
            if ($info_field['mandatory'] == true) {
                echo '<em>*</em>';
            }
            echo $info_field['title'];
?>
        </label>
        <textarea rows="3" cols="20" name ="<?php echo $name; ?>" tabindex="<?php echo $rolo_tab_index++;?>" class="textArea info" ></textarea>
    </div>
<?php
}

/**
 * Save function for background info
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be saved
 * @param id $post_id Post ID
 */
function rolo_save_contact_info($field_name, $post_id) {
    global $contact_fields;

    $info_field = $contact_fields[$field_name];

    $notes = $_POST['rolo_contact_' . $info_field['name']];

    if ($notes != '') {
        wp_update_post(array('ID' => $post_id, 'post_content' => $notes));
    }
}

/**
 * Setup function for contact company
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be shown
 * @param <type> $rolo_tab_index
 */
function rolo_setup_contact_company($field_name, &$rolo_tab_index) {
    global $contact_fields;

    $company_field = $contact_fields[$field_name];
    $name = 'rolo_contact_' . $company_field['name'];
    $default_value = $company_field['default_value'];
?>
    <div class="ctrlHolder">
        <label for="<?php echo $name;?>">
<?php
            if ($company_field['mandatory'] == true) {
                echo '<em>*</em>';
            }
            echo $company_field['title'];
?>
        </label>
        <input type="text" name="<?php echo $name;?>" value="<?php echo $default_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput company" />
    </div>
<?php
}

/**
 * Save function for contact company
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be saved
 * @param id $post_id Post ID
 */
function rolo_save_contact_company($field_name, $post_id) {
    global $contact_fields;

    $company_field = $contact_fields[$field_name];

    $company = $_POST['rolo_contact_' . $company_field['name']];

    if ($company != '') {
       // Set the custom taxonmy for the post
        wp_set_post_terms($post_id, $company, 'company');
    }
}

/**
 * callback function for inline contact edits
 */
function rolo_edit_contact_callback() {
    $new_value = $_POST['new_value'];
    $contact_id = $_POST['id_field'];
    $id = $_POST['id'];

    $old_values = get_post_meta($contact_id, 'rolo_contact');
    $old_values = $old_values[0];

    $old_values[$id] = $new_value;
    update_post_meta($contact_id, 'rolo_contact', $old_values);

    $results = array(
        'is_error' => false,
        'error_text' => '',
        'html' => $new_value
    );

    include_once(ABSPATH . 'wp-includes/js/tinymce/plugins/spellchecker/classes/utils/JSON.php');

    $json = new Moxiecode_JSON();
    $results = $json->encode($results);

    die($results);
}

add_action('wp_ajax_rolo_edit_contact', 'rolo_edit_contact_callback');
add_action('wp_ajax_nopriv_rolo_edit_contact', 'rolo_edit_contact_callback');

?>