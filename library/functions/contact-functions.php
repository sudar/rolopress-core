<?php
/**
 * Contact setup and saving
 *
 * Adds function related to setting up and saving contacts
 *
 * @package RoloPress
 * @subpackage Functions
 */

/**
 * Template function for adding new contacts
 * @since 0.1
 */
function rolo_add_contact() {

    $user = wp_get_current_user();
    if ( $user->ID ) {

        //TODO - Check user capabilites
        //TODO - Verify nounce here

        if (isset($_POST['rp_add_contact']) && $_POST['rp_add_contact'] == 'add_contact') {
            $contact_id = _rolo_save_contact_fields();
            if ($contact_id) {
                echo __("Contact information successfully added.", 'rolopress');
            } else {
                echo __("There was some problem in inserting the contact info", 'rolopress');
    //            TODO - Handle Error properly
            }
        } elseif (isset($_POST['rp_add_notes']) && $_POST['rp_add_notes'] == 'add_notes') {
            if (_rolo_save_contact_notes()) {
                echo __("Notes successfully added.", 'rolopress');
            } else {
    //            TODO - Handle Error properly
                echo __("There was some problem in inserting the notes", 'rolopress');
            }
        } else {
            _rolo_show_contact_fields();
        }
    }
}

/**
 * Template function for adding editing contacts
 *
 * @since 0.1
 */
function rolo_edit_contact() {
    $contact_id =  (isset($_GET['id'])) ? $_GET['id'] : 0;
    $contact = &get_post($contact_id);

    if ($contact) {

        //TODO - Check user capabilites
        //TODO - Verify nounce here

        if (isset($_POST['rp_edit_contact']) && $_POST['rp_edit_contact'] == 'edit_contact') {
            $contact_id = _rolo_save_contact_fields();
            if ($contact_id) {
                echo __("Contact information successfully added.", 'rolopress');
            } else {
                echo __("There was some problem in inserting the contact info", 'rolopress');
    //            TODO - Handle Error properly
            }
        } else {
            _rolo_show_edit_contact_form($contact_id);
        }
    } else {
        // TODO: should redirect properly
    }
}

/**
 * Show the list of contact fields in edit contact page
 * 
 * @global array $company_fields List of contact fields
 * @param <type> $contact_id
 *
 * @since 0.1
 */
function _rolo_show_edit_contact_form($contact_id) {
	global $contact_fields;
	$rolo_tab_index = 1000;

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
?>
<form action="" method="post" class="uniForm inlineLabels" id="contact-edit">
    <div id="errorMsg">
        <h3><?php _e('Mandatory fields are not filled.', 'rolopress');?></h3>
    </div>

    <fieldset class="inlineLabels">

<?php
	foreach($contact_fields as $contact_field) {

        if (function_exists($contact_field['setup_function'])){
            call_user_func_array($contact_field['setup_function'], array($contact_field['name'], &$rolo_tab_index, $contact_id));
        } else {

            $name = 'rolo_contact_' . $contact_field['name'];
            $current_value = $contact[$name];
            $class = $contact_field['class'];

            $mandatory_class = '';
            if ($contact_field['mandatory'] == true) {
                $mandatory_class = ' mandatory';
            }
?>
        <div class="ctrlHolder <?php echo $contact_field['class']; echo $mandatory_class; ?>">
            <label for="<?php echo $name;?>">
<?php
                    if ($contact_field['mandatory'] == true) {
                        echo '<em>*</em>';
                    }
                    echo $contact_field['title'];?>
			</label>
			
<?php					
					if (isset($contact_field['prefix']) == true) {		
						echo '<span class="prefix '; echo $contact_field['name']; echo '">'; echo $contact_field['prefix']; echo '</span>';
						$class = $contact_field['class'] . " " . "input-prefix";
                    }
?>

            <input type="text" name="<?php echo $name;?>" value="<?php echo $current_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index;?>" class="textInput <?php echo $class;?>" />
        </div>
<?php
            $rolo_tab_index++;
        }
	}
?>
    </fieldset>
   <div class="buttonHolder">
       <input type="hidden" name="contact_id" value="<?php echo $contact_id;?>" />
      <input type="hidden" name="rp_edit_contact" value="edit_contact" />
      <button type="submit" name="submit" id="edit_contact" class="submitButton" tabindex="<?php echo $rolo_tab_index++;?>" ><?php _e('Edit Contact', 'rolopress');?></button>
   </div>
</form>
<?php
}

/**
 * Show the list of contact fields in add contact page
 * @global array $company_fields List of contact fields
 * @since 0.1
 */
function _rolo_show_contact_fields() {
	global $contact_fields;
	$rolo_tab_index = 1000;
?>
<form action="" method="post" class="uniForm inlineLabels" id="contact-add">
    <div id="errorMsg">
        <h3><?php _e('Mandatory fields are not filled.', 'rolopress');?></h3>
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
            
            $mandatory_class = '';
            if ($contact_field['mandatory'] == true) {
                $mandatory_class = ' mandatory';
            }
?>
		<div class="ctrlHolder <?php echo $contact_field['class']; echo $mandatory_class; ?>">
            <label for="<?php echo $name;?>">
<?php
                    if ($contact_field['mandatory'] == true) {
                        echo '<em>*</em>';
                    }
                    echo $contact_field['title'];?>
			</label>
			
<?php
					if (isset($contact_field['prefix']) == true) {
						echo '<span class="prefix '; echo $contact_field['name']; echo '">'; echo $contact_field['prefix']; echo '</span>';
						$class = $contact_field['class'] . " " . "input-prefix";
                    }
?>

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
      <button type="submit" name="submit" id="add_contact" class="submitButton" tabindex="<?php echo $rolo_tab_index++;?>" ><?php _e('Add Contact', 'rolopress');?></button>
   </div>
</form>
<?php
}

/**
 * Save contact fields to database
 *
 * @global array $company_fields List of contact fields
 * @return string|boolean Post id if succesful and false if on error
 * @since 0.1
 */
function _rolo_save_contact_fields() {
	global $contact_fields;

    //TODO - Check whether the current use is logged in or not
    //TODO - Check for nounce
    $post_id = 0;

    if (isset($_POST['contact_id'])) {
        $old_post = array();

        $post_id = $_POST['contact_id'];

        $old_post['post_title'] = $_POST['rolo_contact_first_name'];
        if (isset($_POST['rolo_contact_last_name'])) {
            $old_post['post_title'] .= ' ' . $_POST['rolo_contact_last_name'];
        }

        $old_post['ID'] = $post_id;
        $post_id = wp_update_post($old_post);

    } else {
        $new_post = array();

        $new_post['post_title'] = $_POST['rolo_contact_first_name'];
        if (isset($_POST['rolo_contact_last_name'])) {
            $new_post['post_title'] .= ' ' . $_POST['rolo_contact_last_name'];
        }

        $new_post['post_type'] = 'post';
        $new_post['post_status'] = 'publish';

        $post_id = wp_insert_post($new_post);
    }

    // Store only first name and last name as seperate custom fields
    update_post_meta($post_id, 'rolo_contact_first_name', $_POST['rolo_contact_first_name']);
    update_post_meta($post_id, 'rolo_contact_last_name', $_POST['rolo_contact_last_name']);
    wp_set_post_terms($post_id, $_POST['rolo_contact_post_tag']);

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
 * @since 0.1
 */
function _rolo_show_contact_notes($contact_id) {
?>
<form action="" method="post" class="uniForm inlineLabels">
    <div id="errorMsg">
        <h3><?php _e('Oops!, We Have a Problem.', 'rolopress');?></h3>
        <ol>
        </ol>
    </div>

    <fieldset class="inlineLabels">

      <legend><?php _e('Add notes', 'rolopress');?></legend>

        <div class="ctrlHolder">
            <label for="rolo_contact_notes">
                <?php _e('Notes', 'rolopress');?>
            </label>
            <textarea rows="3" cols="20" name ="rolo_contact_notes" class="textArea notes"></textarea>
        </div>
    </fieldset>
   <div class="buttonHolder">
      <input type="hidden" name="rp_add_notes" value="add_notes" />
      <input type="hidden" name="rolo_contact_id" value="<?php echo $contact_id; ?>" />
      <button type="submit" name="submit" id="submit" class="submitButton"><?php _e('Add Notes', 'rolopress');?></button>
   </div>

</form>
<?php
}

/**
 * Setup field for editing address
 *
 * @global <type> $contact_fields
 * @param <type> $field_name
 * @since 0.1
 */
function rolo_setup_contact_address($field_name, &$rolo_tab_index, $contact_id = '') {
    global $contact_fields;

    $address_field = $contact_fields[$field_name];

    $contact = get_post_meta($contact_id, 'rolo_contact', true);

    if (isset($contact['rolo_contact_address'])) {
        $current_value = $contact['rolo_contact_address'];
    } else {
        $current_value = '';
    }
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
            <textarea rows="3" cols="20" name ="rolo_contact_address" tabindex="<?php echo $rolo_tab_index++;?>" class="textArea address" ><?php echo $current_value;?></textarea>
        </div>

<?php
        $city = rolo_get_term_list($contact_id, 'city');
        $state = rolo_get_term_list($contact_id, 'state');
        $zip = rolo_get_term_list($contact_id, 'zip');
        $country = rolo_get_term_list($contact_id, 'country');

        $city = ($city == '') ? 'City' : $city;
        $state = ($state == '') ? 'State' : $state;
        $zip = ($zip == '') ? 'Zip' : $zip;
        $country = ($country == '') ? 'Country' : $country;
?>
        <div class="ctrlHolder nolabel">
            <input type="text" name="rolo_contact_city" value="<?php echo $city ;?>" size="30" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput city" />
			<input type="text" name="rolo_contact_state" value="<?php echo $state ;?>" size="15" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput state" />
            <input type="text" name="rolo_contact_zip" value="<?php echo $zip ;?>" size="10" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput zip" />
		</div>

        <div class="ctrlHolder">
            <label for="rolo_contact_country"></label>
            <input type="text" name="rolo_contact_country" value="<?php echo $country ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput country" />
        </div>
<?php
}

/**
 * Save contact address information
 *
 * @param <type> $field_name
 * @param <type> $post_id
 * @since 0.1
 */
function rolo_save_contact_address($field_name, $post_id, &$new_contact) {
    // TODO - Validate fields

    // store the address in custom field
    $new_contact['rolo_contact_address'] = $_POST['rolo_contact_address'];

    // store the rest as custom taxonomies
    wp_set_post_terms($post_id, ($_POST['rolo_contact_city'] == 'City') ? '' : $_POST['rolo_contact_city'], 'city');
    wp_set_post_terms($post_id, ($_POST['rolo_contact_state'] == 'State') ? '' : $_POST['rolo_contact_state'], 'state');
    wp_set_post_terms($post_id, ($_POST['rolo_contact_zip'] == 'Zip') ? '' : $_POST['rolo_contact_zip'], 'zip');
    wp_set_post_terms($post_id, ($_POST['rolo_contact_country'] == 'Country') ? '' : $_POST['rolo_contact_country'], 'country');
}

/**
 * Setup function for fields involving more than one instance (phone, IM)
 *
 * @global <type> $contact_fields
 * @param <type> $field_name
 * @since 0.1
 */
function rolo_setup_contact_multiple($field_name, &$rolo_tab_index, $contact_id = '') {
    global $contact_fields;

    $multiple_field = $contact_fields[$field_name];
    $multiples = $multiple_field['multiple'];

    $contact = get_post_meta($contact_id, 'rolo_contact', true);

    for ($i = 0 ; $i < count($multiples) ; $i++) {

        $multiple = $multiples[$i];
        $current_value = '';
        $title = '';
        $ctrl_class = '';
        $hidden = '';

        $name  = $multiple_field['name'] . "[$i]";
        $class = $multiple_field['class'];
        $select_name = $multiple_field['name'] . "_select[$i]";
        $title = $multiple_field['title'];

        if (isset($contact['rolo_contact_' . $field_name . '_' . $multiple])) {
            $current_value = $contact['rolo_contact_' . $field_name . '_' . $multiple];
            $ctrl_class = ' multipleInput ' . $multiple_field['name'];
        } else {
            if ($i == 0) {
                $ctrl_class = ' multipleInput ' . $multiple_field['name'];
            } else {
                $ctrl_class = ' multipleInput ctrlHidden ' . $multiple_field['name'];
            }
        }
?>
        <div class="ctrlHolder<?php echo $ctrl_class;?>">

            <label for="<?php echo $name;?>">
                <?php echo $title;?>
            </label>
            <input type="text" name="<?php echo $name;?>" value="<?php echo $current_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput <?php echo $class;?>" />
            <select name="<?php echo $select_name;?>" tabindex="<?php echo $rolo_tab_index++;?>">
<?php
                foreach ($multiples as $option) {
                    echo "<option value ='" , $option, "'", selected($multiple, $option, FALSE) , ">", $option, "</option>\n";
                }
?>
            </select>
<?php
            if ($i == 0) {
                $hidden = 'style = "display:none"';
            }
?>
            <img src ="<?php echo get_bloginfo('template_directory') ?>/library/images/forms/delete.png" class="rolo_delete_ctrl" alt="<?php _e('Delete', 'rolopress');?>" <?php echo $hidden;?> />
            <img src ="<?php echo get_bloginfo('template_directory') ?>/library/images/forms/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another', 'rolopress');?>" />
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
 * @since 0.1
 */
function rolo_save_contact_multiple($field_name, $post_id, &$new_contact) {
    global $contact_fields;

    $multiple_field = $contact_fields[$field_name];

    // TODO - Validate fields

    $multiple_field_values  = $_POST[$multiple_field['name']];
    $multiple_field_selects = $_POST[$multiple_field['name'] . '_select'];

    for ($i = 0 ; $i < count($multiple_field_values) ; $i++) {
        if ($multiple_field_values[$i] != '') {
            $new_contact['rolo_contact_' . $multiple_field['name'] . '_' . $multiple_field_selects[$i]] = $multiple_field_values[$i];
        }
    }
}

/**
 * Setup function for background info
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be shown
 * @param <type> $rolo_tab_index
 * @since 0.1
 */
function rolo_setup_contact_info($field_name, &$rolo_tab_index, $contact_id ='') {
    global $contact_fields;

    $info_field = $contact_fields[$field_name];
    $name = 'rolo_contact_' . $info_field['name'];

    if ($contact_id > 0) {
        $contact = get_post($contact_id);
    }

    if (isset($contact->post_content)) {
        $current_value = $contact->post_content;
    } else {
        $current_value = '';
    }
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
        <textarea rows="3" cols="20" name ="<?php echo $name; ?>" tabindex="<?php echo $rolo_tab_index++;?>" class="textArea info" ><?php echo $current_value;?></textarea>
    </div>
<?php
}

/**
 * Save function for background info
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be saved
 * @param id $post_id Post ID
 * @since 0.1
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
 * @since 0.1
 */
function rolo_setup_contact_company($field_name, &$rolo_tab_index, $contact_id = '') {
    global $contact_fields;

    $company_field = $contact_fields[$field_name];
    $name = 'rolo_contact_' . $company_field['name'];
    if ($contact_id > 0) {
        $current_value = rolo_get_term_list($contact_id, 'company');
    } else {
        $current_value = $company_field['default_value'];
    }
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
        <input type="text" name="<?php echo $name;?>" value="<?php echo $current_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput company" />
    </div>
<?php
}

/**
 * Save function for contact company
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be saved
 * @param id $post_id Post ID
 * @since 0.1
 */
function rolo_save_contact_company($field_name, $post_id) {
    global $contact_fields;

    $company_field = $contact_fields[$field_name];
    $company_name = $_POST['rolo_contact_' . $company_field['name']];

    if ($company_name != '') {
       // Set the custom taxonmy for the post
        wp_set_post_terms($post_id, $company_name, 'company');

        $company_id = get_post_by_title(stripslashes($company_name));
        if (!$company_id) {
            // create an empty post for company
            $new_post = array();

            $new_post['post_title'] = $company_name;
            $new_post['post_type'] = 'post';
            $new_post['post_status'] = 'publish';

            $company_id = wp_insert_post($new_post);

            // Store only company name as seperate custom field
            update_post_meta($company_id, 'rolo_company_name', $company_name);

            $new_company = array();
            $new_company['rolo_company_name'] = $company_name;
            update_post_meta($company_id, 'rolo_company', $new_company);

            // Set the custom taxonmy for the post
            wp_set_post_terms($company_id, 'Company', 'type');
            wp_set_post_terms($company_id, $company_name, 'company');
        }
    }
}


/**
 * Setup function for contact tags
 *
 * @global array $contact_fields List of contact fields
 * @param string $field_name Field Name to be shown
 * @param <type> $rolo_tab_index
 * @since 1.5
 */
function rolo_setup_contact_post_tags($fieldname, $tabidx, $cid=-1 ) {
    if ( $cid >= 0 ):
	$post_tags = wp_get_post_terms($cid, 'post_tag');
	$tag_list = '';
	$i = 0;
	foreach ( $post_tags as $tag ) {
	    $tag_list .= $tag->name;
	    if ( $i+1<sizeof($post_tags) )
		$tag_list .= ', ';
	}
    else:
	$tag_list = '';
    endif;
?>
<div class="ctrlHolder">
        <label for="rolo_contact_post_tag">
Tags        </label>
        <input type="text" class="textInput post_tag" tabindex="1003" size="55" value="<?php echo $tag_list; ?>" name="rolo_contact_post_tag" autocomplete="off">
    </div>
<?php
}

/**
 * callback function for inline contact edits
 * @since 0.1
 */
function rolo_edit_contact_callback() {
    $new_value = $_POST['new_value'];
    $contact_id = $_POST['id_field'];
    $id = $_POST['id'];

    $old_values = get_post_meta($contact_id, 'rolo_contact');
    $old_values = $old_values[0];

    $old_values[$id] = $new_value;
    update_post_meta($contact_id, 'rolo_contact', $old_values);

    _rolo_edit_callback_success($new_value);
}

add_action('wp_ajax_rolo_edit_contact', 'rolo_edit_contact_callback');
add_action('wp_ajax_nopriv_rolo_edit_contact', 'rolo_edit_contact_callback');

/**
 * callback function for inline address edits
 * @since 0.1
 */
function rolo_edit_address_callback() {
    $new_value = $_POST['new_value'];
    $post_id = $_POST['id_field'];
    $id = $_POST['id'];

    wp_set_post_terms($post_id, $new_value, $id);

    _rolo_edit_callback_success($new_value);
}

add_action('wp_ajax_rolo_edit_address', 'rolo_edit_address_callback');
add_action('wp_ajax_nopriv_rolo_edit_address', 'rolo_edit_address_callback');

// for post tags
add_action('wp_ajax_rolo_edit_tag', 'rolo_edit_address_callback');
add_action('wp_ajax_nopriv_rolo_tag', 'rolo_edit_address_callback');

/**
 * helper function for callback function
 * @param <type> $new_value 
 * @since 0.1
 */
function _rolo_edit_callback_success($new_value) {
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

?>