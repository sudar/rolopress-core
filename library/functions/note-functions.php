<?php
/**
 * Notes Functions
 *
 * Save notes information to database
 *
 * @return int notes(comment) id
 *
 * @package RoloPress
 * @subpackage Functions
 */

function _rolo_save_contact_notes() {
    global $wpdb;

    //TODO - Validate fields
    //TODO - Validate that the notes field is not empty
    //TODO - Apply a filter for notes

    $notes = trim($_POST['rolo_contact_notes']);
    $contact_id = (int) $_POST['rolo_contact_id'];

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

    $commentdata['comment_post_ID'] = $contact_id;
    $commentdata['comment_content'] = $notes;

    $notes_id = wp_new_comment($commentdata);

    return $notes_id;
}

/**
 * callback function for inline note edits
 */
function rolo_edit_note_callback() {
    $new_value = $_POST['new_value'];
    $note_id   = $_POST['note_id'];
    $note_id = substr($note_id, strripos($note_id, "-") + 1);

    $current_comment = get_comment($note_id, ARRAY_A);
    $current_comment['comment_content'] = $new_value;

    wp_update_comment($current_comment);

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

add_action('wp_ajax_rolo_edit_note', 'rolo_edit_note_callback');
add_action('wp_ajax_nopriv_rolo_edit_note', 'rolo_edit_note_callback');


?>