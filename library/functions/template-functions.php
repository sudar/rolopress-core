<?php
/**
 * Contains all the template functions used in theme
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
                _rolo_show_contact_notes($contact_id);
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
 * @global array $new_meta_boxes List of contact fields
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

            $meta_box_value = $contact_field['std'];
            if (isset ($contact_field['multiple'])) {
                $multiples = $contact_field['multiple'];

                $i = 0;
                foreach ($multiples as $multiple) {

                    $name = $contact_field['name'] . $multiple;
                    if ($i == 0) {
                        $ctrl_class = ' multipleInput ' . $contact_field['name'];
                        $title = $contact_field['title'];
                    } else {
                        $ctrl_class = ' multipleInput ctrlHidden ' . $contact_field['name'];
                        $title = '';
                    }
?>
        <div class="ctrlHolder<?php echo $ctrl_class;?>">

            <label for="<?php echo $name.'_rolo_value';?>">
                <?php echo $title;?>
            </label>
            <input type="text" name="<?php echo $name.'_rolo_value';?>" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index;?>" class="textInput" />
            <select>
<?php
                    foreach ($multiples as $option) {
?>
                        <option value ="<?php echo $option; ?>"><?php echo $option; ?></option>
<?php
                    }
?>
            </select>
<?php
                if ($i == 0) {
                    $i ++;
                    $hidden = 'style = "display:none"';
                } else {
                    $hidden = '';
                }
?>
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/delete.png" class="rolo_delete_ctrl" alt="<?php _e('Delete');?>" <?php echo $hidden;?> />
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another');?>" />
        </div>
<?php
                $rolo_tab_index++;
                }
            } else {
                $name = 'rolo_contact_' . $contact_field['name'];
?>
        <div class="ctrlHolder">
            <label for="<?php echo $name;?>">
<?php
                    if ($contact_field['mandatory'] == true) {
                        echo '<em>*</em>';
                    }
                    echo $contact_field['title'];
?>
            </label>
            <input type="text" name="<?php echo $name;?>" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index;?>" class="textInput" />
        </div>
<?php
                $rolo_tab_index++;
            }
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
 * @global array $new_meta_boxes List of contact fields
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

    // TODO - Set custom taxonomy

    $post_id = wp_insert_post($new_post);

    if ($post_id) {
        foreach($contact_fields as $contact_field) {

            if (function_exists($contact_field['save_function'])){
                call_user_func_array($contact_field['save_function'], array($contact_field['name'], $post_id));
            } else {

                $data = $_POST['rolo_contact_' . $contact_field['name']];

    //            TODO - Validate data
                update_post_meta($post_id, 'rolo_contact_' . $contact_field['name'], $data);
            }
        }

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
            <textarea rows="3" cols="20" name ="rolo_contact_notes"></textarea>
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
 * Save notes information to database
 *
 * @return int notes(comment) id
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
 * Print summary information about contact
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_summary($contact_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$contact_id) {
        return false;
    }
?>
    <div class="span-3 first" id="contact_image">
        <img class="contact_image" src="<?php echo rolo_contact_photo_url($contact_id);?>" alt="image" width="100" height="100"/>
    </div>

     <div class="span-4" id="contact-left">
         <div class="contact">
             <h4><a href="<?php echo rolo_contact_url($contact_id); ?>" rel="bookmark"><?php echo rolo_contact_name($contact_id);?></a></h4>
         </div><!-- /contact -->

         <div class="info small" id="info_box">
             <?php
             //TODO Find out how to associate companies
             ?>
             <ul>
                 <li class="company">
                     Company:<a href="http://crmdemo.slipfire.com/list/microsoft" title="View all posts in Microsoft" rel="category tag">Microsoft</a>
                 </li>
                 <li class="email">
                    <a href="<?php echo rolo_contact_email_link($contact_id);?>"><?php echo rolo_contact_email($contact_id);?></a>
                 </li>
             </ul>
        </div><!-- /info_box -->

    </div><!-- /contact-left -->

    <div class="span-4" id="contact-middle">
        <div class="phone small">
            <ul>
                <li>Mobile: <?php echo rolo_contact_mobile_phone($contact_id); ?></li>
                <li>Home: <?php echo rolo_contact_home_phone($contact_id); ?></li>
                <li>Work: <?php echo rolo_contact_work_phone($contact_id); ?></li>
                <li>Fax: <?php echo rolo_contact_fax($contact_id); ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /contact-middle -->

    <div class="span-2" id="contact-right">
        <p>
            <span class="commentnum">
                <a href="http://crmdemo.slipfire.com/people/id-60#comments" title="Comment on ballmer.jpg">3 Notes</a>
            </span>
        </p>
    </div><!-- /contact-right -->

<?php
}

/**
 * Get contact url
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_url($contact_id) {
    return get_permalink($contact_id);
}

/**
 * Get contact full name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_name($contact_id) {
    return apply_filters('rolo_contact_name', rolo_contact_first_name($contact_id) . ' ' . rolo_contact_last_name($contact_id) );
}

/**
 * Get contact first name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_first_name($contact_id) {
    return _rolo_get_field($contact_id, 'first_name');
}

/**
 * Get contact last name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_last_name($contact_id) {
    return _rolo_get_field($contact_id, 'last_name');
}

/**
 * Get contact email link
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_email_link($contact_id) {
    return apply_filters('rolo_email_link', 'mailto:' . _rolo_get_field($contact_id, 'email'));
}

/**
 * Get contact email
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_email($contact_id) {
    return _rolo_get_field($contact_id, 'email');
}

/**
 * Get contact mobile phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_mobile_phone($contact_id) {
    return _rolo_get_field($contact_id, 'mobile_phone');
}

/**
 * Get Contact home phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_home_phone($contact_id) {
    return _rolo_get_field($contact_id, 'home_phone');
}

/**
 * Get Contact work Phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_work_phone($contact_id) {
    return _rolo_get_field($contact_id, 'work_phone');
}

/**
 * Get contact fax
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_fax($contact_id) {
    return _rolo_get_field($contact_id, 'fax');
}

/**
 * Photo url
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_photo_url($contact_id) {
    return _rolo_get_field($contact_id, 'image_path');
}

/**
 * Private function used to retrieve the contact field value from custom fields
 * @global array $contact_fields
 * @param string $post_id Post whose custom field to be retrieved
 * @param string $field_name The custom field name
 * @return <type>
 */
function _rolo_get_field($post_id, $field_name) {
    global $contact_fields;
    
    //TODO The meta key should also be stored in the contact fields array
    $value = get_post_meta($post_id, $contact_fields[$field_name]['name'] . '_rolo_value', true);
    $value = ($value == "") ? $contact_fields[$field_name]['std'] : $value;
    return apply_filters($contact_fields[$field_name]['filter'], $value);
}

function rolopress_default_menu() {
			{ ?>
			<div id="menu">
			<?php }
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu') ) : {
					{ ?>
					<div class="menu_item">
					<h1 id="app-title"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></h1>
					<ul class="menu_item">
                    <li><a title="contacts" href="/type/contact"<span>Contacts</span></a></li>
                    <li><a title="companies" href="/type/company"<span>Companies</span></a></li>
                    <ul>					
					</div>
					<ul class="menu_item alignright">
						<li><form id="searchform" method="get" action="<?php bloginfo('home') ?>">
						<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="20" tabindex="1" />
					 	<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Search', 'rolopress') ?>" tabindex="2" />
						</form></li>
						<?php global $user_ID, $user_identity, $user_level ?>
						<?php if ( $user_level >= 1 ) : ?>
							<li><a title="settings" href="<?php bloginfo('url') ?>/wp-admin/"><span>Settings</span></a></li>
						<?php endif // $user_level >= 1 ?>
						<li><?php wp_loginout(); ?></li>
					</ul>
			</div>
			<?php }
}
			endif; 
};

add_action('rolopress_before_wrapper', 'rolopress_default_menu');



/**
 * Show the list of contact fields in add contact page
 * @global array $new_meta_boxes List of contact fields
 */
function _rolo_show_contact_fields_old() {
	global $contact_fields;
	$rolo_tab_index = 1000;
?>
<form action="" method="post" class="uniForm inlineLabels">
    <div id="errorMsg">
        <h3><?php _e('Oops!, We Have a Problem.');?></h3>
        <ol>
        </ol>
    </div>

    <fieldset class="inlineLabels">
    
<?php
	foreach($contact_fields as $meta_box) {

        $meta_box_value = $meta_box['std'];
        if (isset ($meta_box['multiple'])) {
            $multiples = $meta_box['multiple'];
            $name = $meta_box['name'] . $multiples[0];

            $ctrl_class = 'multipleInput ' . $meta_box['name'];
        } else {
            $name = $meta_box['name'];
            $ctrl_class = "";
        }
?>
        <div class="ctrlHolder">
            <input type="hidden" name="<?php echo $name.'_noncename';?>" id="<?php echo $name.'_noncename';?>" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) );?>" />
            <label for="<?php echo $name.'_rolo_value';?>">
<?php
                if ($meta_box['mandatory'] == true) {
                    echo '<em>*</em>';
                }
                echo $meta_box['title'];
?>
            </label>
            <input type="text" name="<?php echo $name.'_rolo_value';?>" value="<?php echo $meta_box_value ;?>" size="55" tabindex="<?php echo $rolo_tab_index;?>" class="textInput <?php echo $ctrl_class; ?>" />
<?php
            if (isset ($meta_box['multiple'])) {
?>
            <select>
<?php
                foreach ($multiples as $multiple) {
?>
                    <option value ="<?php echo $multiple ?>"><?php echo $multiple; ?></option>
<?php
                }
?>
            </select>
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another');?>" />
<?php
            }
?>
        </div>
<?php
		$rolo_tab_index++;
	}
?>
    </fieldset>
   <div class="buttonHolder">
      <input type="hidden" name="rp_add_contact" value="add_contact" />
      <button type="submit" name="submit" id="submit" class="submitButton"><?php _e('Add Contact');?></button>
   </div>
</form>
<?php
}





// Produces an avatar image with the hCard-compliant photo class
function commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
} // end commenter_link


// Custom callback to list comments in the rolopress style
function custom_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
  ?>
  	<li id="comment-<?php comment_ID() ?>" class="<?php rolopress_comment_class() ?>">
  		<div class="comment-author vcard"><?php commenter_link() ?></div>
  		<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'rolopress'),
  					get_comment_date(),
  					get_comment_time(),
  					'#comment-' . get_comment_ID() );
  					edit_comment_link(__('Edit', 'rolopress'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'rolopress') ?>
          <div class="comment-main">
      		<?php comment_text() ?>
  		</div>
		<?php // echo the comment reply link with help from Justin Tadlock http://justintadlock.com/ and Will Norris http://willnorris.com/
			if($args['type'] == 'all' || get_comment_type() == 'comment') :
				comment_reply_link(array_merge($args, array(
					'reply_text' => __('Reply','rolopress'), 
					'login_text' => __('Log in to reply.','rolopress'),
					'depth' => $depth,
					'before' => '<div class="comment-reply-link">', 
					'after' => '</div>'
				)));
			endif;
		?>
<?php } // end custom_comments


// Custom callback to list pings
function custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
    		<li id="comment-<?php comment_ID() ?>" class="<?php comment_class() ?>">
    			<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'rolopress'),
    					get_comment_author_link(),
    					get_comment_date(),
    					get_comment_time() );
    					edit_comment_link(__('Edit', 'rolopress'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'rolopress') ?>
            <div class="comment-main">
    			<?php comment_text() ?>
			</div>
<?php } // end custom_pings
?>