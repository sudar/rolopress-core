<?php
/**
 * Company setup and saving
 *
 * Adds function related to setting up and saving companies
 *
 * @package RoloPress
 * @subpackage Functions
 */

/**
 * Template function for adding new company
 * @since 0.1
 */
function rolo_add_company() {

    $user = wp_get_current_user();
    if ( $user->ID ) {

        //TODO - Check user capabilites
        //TODO - Verify nounce here

        if (isset($_POST['rp_add_company']) && $_POST['rp_add_company'] == 'add_company') {
            $company_id = _rolo_save_company_fields();
            if ($company_id) {
                echo __("Company information successfully added.", 'rolopress');
//                _rolo_show_company_notes($company_id);
            } else {
                echo __("There was some problem in inserting the company info", 'rolopress');
    //            TODO - Handle Error properly
            }
        } elseif (isset($_POST['rp_add_notes']) && $_POST['rp_add_notes'] == 'add_notes') {
            if (_rolo_save_company_notes()) {
                echo __("Notes successfully added.", 'rolopress');
            } else {
    //            TODO - Handle Error properly
                echo __("There was some problem in inserting the notes", 'rolopress');
            }
        } else {
            _rolo_show_company_fields();
        }
    }
}

/**
 * Template function for editing existing company
 *
 * @since 0.1
 */
function rolo_edit_company() {
    $company_id =  (isset($_GET['id'])) ? $_GET['id'] : 0;
    $company = &get_post($company_id);

    if ($company) {

        //TODO - Check user capabilites
        //TODO - Verify nounce here

        if (isset($_POST['rp_edit_company']) && $_POST['rp_edit_company'] == 'edit_company') {
            $company_id = _rolo_save_company_fields();
            if ($company_id) {
                echo __("Company information successfully edited.", 'rolopress');
            } else {
                echo __("There was some problem in inserting the company info", 'rolopress');
    //            TODO - Handle Error properly
            }
        } else {
            _rolo_show_edit_company_form($company_id);
        }
    } else {
        // TODO: should redirect properly
    }
}

/**
 * Show the list of company fields in edit company page
 *
 * @global array $company_fields List of company fields
 * @param <type> $company_id
 *
 * @since 0.1
 */
function _rolo_show_edit_company_form($company_id) {
	global $company_fields;
	$rolo_tab_index = 1000;

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
?>
<form action="" method="post" class="uniForm inlineLabels" id="company-edit">
    <div id="errorMsg">
        <h3><?php _e('Mandatory fields are not filled.', 'rolopress');?></h3>
    </div>

    <fieldset class="inlineLabels">

<?php
	foreach($company_fields as $company_field) {

        if (function_exists($company_field['setup_function'])){
            call_user_func_array($company_field['setup_function'], array($company_field['name'], &$rolo_tab_index, $company_id));
        } else {

            $name = 'rolo_company_' . $company_field['name'];
            $current_value = $company[$name];
            $class = $company_field['class'];

            $mandatory_class = '';
            if ($company_field['mandatory'] == true) {
                $mandatory_class = ' mandatory';
            }
?>
        <div class="ctrlHolder <?php echo $company_field['class']; echo $mandatory_class; ?>">
            <label for="<?php echo $name;?>">
<?php
                    if ($company_field['mandatory'] == true) {
                        echo '<em>*</em>';
                    }
                    echo $company_field['title'];?>
			</label>
<?php
					if (isset($company_field['prefix']) == true) {
						echo '<span class="prefix '; echo $company_field['name']; echo '">'; echo $company_field['prefix']; echo '</span>';
						$class = $company_field['class'] . " " . "input-prefix";
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
       <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
      <input type="hidden" name="rp_edit_company" value="edit_company" />
      <button type="submit" name="submit" id="edit_company" class="submitButton" tabindex="<?php echo $rolo_tab_index++;?>" ><?php _e('Edit company', 'rolopress');?></button>
   </div>
</form>
<?php
}

/**
 * Show the list of company fields in add company page
 *
 * @global array $company_fields List of company fields
 * @since 0.1
 */
function _rolo_show_company_fields() {
	global $company_fields;
	$rolo_tab_index = 1000;
//                <input type="hidden" name="<?php echo $name.'_noncename';? >" id="< ?php echo $name.'_noncename';? >" value="< ? php echo wp_create_nonce( plugin_basename(__FILE__) ); ? >" />
?>
<form action="" method="post" class="uniForm inlineLabels" id="company-add">
    <div id="errorMsg">
        <h3><?php _e('Mandatory fields are not filled.', 'rolopress');?></h3>
    </div>

    <fieldset class="inlineLabels">

<?php
	foreach($company_fields as $company_field) {

        if (function_exists($company_field['setup_function'])){
            call_user_func_array($company_field['setup_function'], array($company_field['name'], &$rolo_tab_index));
        } else {

            $default_value = $company_field['default_value'];
            $name  = 'rolo_company_' . $company_field['name'];
            $class = $company_field['class'];

            $mandatory_class = '';
            if ($company_field['mandatory'] == true) {
                $mandatory_class = ' mandatory';
            }
?>
        <div class="ctrlHolder <?php echo $company_field['class']; echo $mandatory_class; ?>">
            <label for="<?php echo $name;?>">
<?php
                if ($company_field['mandatory'] == true) {
                    echo '<em>*</em>';
                }
                echo $company_field['title'];?>
			</label>
<?php				
				if (isset($company_field['prefix']) == true) {		
                    echo '<span class="prefix '; echo $company_field['name']; echo '">'; echo $company_field['prefix']; echo '</span>';
                    $class = $company_field['class'] . " " . "input-prefix";
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
      <input type="hidden" name="rp_add_company" value="add_company" />
      <button type="submit" name="submit" id="add_company" class="submitButton" tabindex="<?php echo $rolo_tab_index++;?>" ><?php _e('Add company', 'rolopress');?></button>
   </div>
</form>
<?php
}

/**
 * Save company fields to database
 *
 * @global array $company_fields List of company fields
 * @return string|boolean Post id if succesful and false if on error
 * @since 0.1
 */
function _rolo_save_company_fields() {
	global $company_fields;

    //TODO - Check whether the current use is logged in or not
    //TODO - Check for nounce
    // TODO Validation

    $company_name = $_POST['rolo_company_name'];

    $post_id = 0;
    if (isset($_POST['company_id'])) {
        $old_post = array();
        
        $post_id = $_POST['company_id'];
        $old_post['post_title'] = $company_name;
        $old_post['ID'] = $post_id;
        $post_id = wp_update_post($old_post);
    } else {
        $new_post = array();

        $new_post['post_title'] = $company_name;
        $new_post['post_type'] = 'post';
        $new_post['post_status'] = 'publish';

        $post_id = wp_insert_post($new_post);
    }

    // Store only company name as seperate custom field
    update_post_meta($post_id, 'rolo_company_name', $_POST['rolo_company_name']);
    wp_set_post_terms($post_id, $_POST['rolo_company_post_tag']);
    if ($post_id) {
        $new_company = array();

        foreach($company_fields as $company_field) {

            if (function_exists($company_field['save_function'])){
                call_user_func_array($company_field['save_function'], array($company_field['name'], $post_id, &$new_company));
            } else {

                $data = $_POST['rolo_company_' . $company_field['name']];

    //            TODO - Validate data
                $new_company['rolo_company_' . $company_field['name']] = $data;
//                update_post_meta($post_id, 'rolo_company_' . $company_field['name'], $data);
            }
        }

        // store the array as post meta
        update_post_meta($post_id, 'rolo_company' , $new_company);

        // Set the custom taxonmy for the post
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
    } else {
//        TODO - handle error
    }
    return $post_id;
}

/**
 * Show add notes field
 *
 * @param <type> $company_id
 * @since 0.1
 */
function _rolo_show_company_notes($company_id) {
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
            <label for="rolo_company_notes">
                <?php _e('Notes', 'rolopress');?>
            </label>
            <textarea rows="3" cols="20" name ="rolo_company_notes" class="textArea notes"></textarea>
        </div>
    </fieldset>
   <div class="buttonHolder">
      <input type="hidden" name="rp_add_notes" value="add_notes" />
      <input type="hidden" name="rolo_company_id" value="<?php echo $company_id; ?>" />
      <button type="submit" name="submit" id="submit" class="submitButton"><?php _e('Add Notes', 'rolopress');?></button>
   </div>

</form>
<?php
}

/**
 * Save notes information to database
 *
 * @return int notes(comment) id
 * @since 0.1
 */
function _rolo_save_company_notes() {
    global $wpdb;

    //TODO - Validate fields
    //TODO - Validate that the notes field is not empty
    //TODO - Apply a filter for notes

    $notes = trim($_POST['rolo_company_notes']);
    $company_id = (int) $_POST['rolo_company_id'];

    $commentdata = array();

    $user = wp_get_current_user();
    if ( $user->ID ) {
        if ( empty( $user->display_name ) )
            $user->display_name=$user->user_login;
        $commentdata['comment_author'] = $wpdb->escape($user->display_name);
        $commentdata['comment_author_url'] = $wpdb->escape($user->user_url);
        $commentdata['comment_author_email'] = $wpdb->escape($user->user_email);
    } else {
        // user is not logged in
        return false;
    }

    $commentdata['comment_post_ID'] = $company_id;
    $commentdata['comment_content'] = $notes;

    $notes_id = wp_new_comment($commentdata);

    return $notes_id;
}

/**
 * Setup field for editing address
 *
 * @global <type> $company_fields
 * @param <type> $field_name
 * @since 0.1
 */
function rolo_setup_company_address($field_name, &$rolo_tab_index, $company_id = '') {
    global $company_fields;

    $address_field = $company_fields[$field_name];
    $company = get_post_meta($company_id, 'rolo_company', true);
    
    if (isset($company['rolo_company_address'])) {
        $current_value = $company['rolo_company_address'];
    } else {
        $current_value = '';
    }
?>
        <div class="ctrlHolder">
            <label for="rolo_company_address">
<?php
                if ($address_field['mandatory'] == true) {
                    echo '<em>*</em>';
                }
                echo $address_field['title'];
?>
            </label>
            <textarea rows="3" cols="20" name ="rolo_company_address" tabindex="<?php echo $rolo_tab_index++;?>" class="textArea address" ><?php echo $current_value;?></textarea>
        </div>

<?php
        $city = rolo_get_term_list($company_id, 'city');
        $state = rolo_get_term_list($company_id, 'state');
        $zip = rolo_get_term_list($company_id, 'zip');
        $country = rolo_get_term_list($company_id, 'country');

        $city = ($city == '') ? 'City' : $city;
        $state = ($state == '') ? 'State' : $state;
        $zip = ($zip == '') ? 'Zip' : $zip;
        $country = ($country == '') ? 'Country' : $country;
?>
        <div class="ctrlHolder">
            <input type="text" name="rolo_company_city" value="<?php echo $city ;?>" size="30" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput city" />
            <input type="text" name="rolo_company_state" value="<?php echo $state ;?>" size="15" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput state" />
            <input type="text" name="rolo_company_zip" value="<?php echo $zip ;?>" size="10" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput zip" />
        </div>

        <div class="ctrlHolder">
            <label for="rolo_company_country"></label>
            <input type="text" name="rolo_company_country" value="<?php echo $country ;?>" size="55" tabindex="<?php echo $rolo_tab_index++;?>" class="textInput country" />
        </div>
<?php
}

/**
 * Save company address information
 *
 * @param <type> $field_name
 * @param <type> $post_id
 * @since 0.1
 */
function rolo_save_company_address($field_name, $post_id, &$new_company) {
    // TODO - Validate fields
    // store the address in custom field
    $new_company['rolo_company_address'] = $_POST['rolo_company_address'];
    
    // store the rest as custom taxonomies
    wp_set_post_terms($post_id, ($_POST['rolo_company_city'] == 'City') ? '' : $_POST['rolo_company_city'], 'city');
    wp_set_post_terms($post_id, ($_POST['rolo_company_state'] == 'State') ? '' : $_POST['rolo_company_state'], 'state');
    wp_set_post_terms($post_id, ($_POST['rolo_company_zip'] == 'Zip') ? '' : $_POST['rolo_company_zip'], 'zip');
    wp_set_post_terms($post_id, ($_POST['rolo_company_country'] == 'Country') ? '' : $_POST['rolo_company_country'], 'country');
}

/**
 * Setup function for fields involving more than one instance (phone, IM)
 *
 * @global <type> $company_fields
 * @param <type> $field_name
 */
function rolo_setup_company_multiple($field_name, &$rolo_tab_index, $company_id = '') {
    global $company_fields;

    $multiple_field = $company_fields[$field_name];
    $multiples = $multiple_field['multiple'];

    $company = get_post_meta($company_id, 'rolo_company', true);

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

        if (isset($company['rolo_company_' . $field_name . '_' . $multiple])) {
            $current_value = $company['rolo_company_' . $field_name . '_' . $multiple];
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
 * @global <type> $company_fields
 * @param <type> $field_name
 * @param <type> $post_id
 * @since 0.1
 */
function rolo_save_company_multiple($field_name, $post_id, &$new_company) {
    global $company_fields;

    $multiple_field = $company_fields[$field_name];

    // TODO - Validate fields

    $multiple_field_values  = $_POST[$multiple_field['name']];
    $multiple_field_selects = $_POST[$multiple_field['name'] . '_select'];

    for ($i = 0 ; $i < count($multiple_field_values) ; $i++) {
        if ($multiple_field_values[$i] != '') {
            $new_company ['rolo_company_' . $multiple_field['name'] . '_' . $multiple_field_selects[$i]] = $multiple_field_values[$i];
        }
    }
}

/**
 * Setup function for company background info
 *
 * @global array $company_fields List of company fields
 * @param string $field_name Field Name to be shown
 * @param <type> $rolo_tab_index
 * @since 0.1
 */
function rolo_setup_company_info($field_name, &$rolo_tab_index, $company_id = '') {
    global $company_fields;

    $info_field = $company_fields[$field_name];
    $name = 'rolo_company_' . $info_field['name'];

    if ($company_id > 0) {
        $company = get_post($company_id);
    }

    if (isset($company->post_content)) {
        $current_value = $company->post_content;
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
 * @global array $company_fields List of company fields
 * @param string $field_name Field Name to be saved
 * @param id $post_id Post ID
 * @since 0.1
 */
function rolo_save_company_info($field_name, $post_id) {
    global $company_fields;

    $info_field = $company_fields[$field_name];

    $notes = $_POST['rolo_company_' . $info_field['name']];

    if ($notes != '') {
        wp_update_post(array('ID' => $post_id, 'post_content' => $notes));
    }
}

/**
 * callback function for inline company edits
 * @since 0.1
 */
function rolo_edit_company_callback() {
    $new_value = $_POST['new_value'];
    $company_id = $_POST['id_field'];
    $id = $_POST['id'];

    $old_values = get_post_meta($company_id, 'rolo_company');
    $old_values = $old_values[0];

    $old_values[$id] = $new_value;
    update_post_meta($company_id, 'rolo_company', $old_values);
    
    _rolo_edit_callback_success($new_value);
}

add_action('wp_ajax_rolo_edit_company', 'rolo_edit_company_callback');
add_action('wp_ajax_nopriv_rolo_edit_company', 'rolo_edit_company_callback');

?>