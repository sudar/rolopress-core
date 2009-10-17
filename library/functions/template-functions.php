<?php
/**
 * Contains all the template functions used in theme
 */

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

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
?>
    <div class="span-3 first" id="contact_image">
        <?php echo get_avatar($contact['rolo_contact_email']);?>
        <!--img class="contact_image" src="" alt="image" width="100" height="100"/-->
    </div>

     <div class="span-4" id="contact-left">
         <div class="contact">
             <h4><a href="<?php echo get_permalink($contact_id); ?>" rel="bookmark"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></h4>
         </div><!-- /contact -->

         <div class="info small" id="info_box">
             <?php
             //TODO Find out how to associate companies
             ?>
             <ul>
                 <li class="company">
                     <?php echo get_the_term_list($contact_id, 'company', __('Company:')); ?>
                 </li>
                 <li class="email">
                    <a href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?></a>
                 </li>
             </ul>
        </div><!-- /info_box -->

    </div><!-- /contact-left -->

    <div class="span-4" id="contact-middle">
        <div class="phone small">
            <ul>
                <li>Mobile: <?php echo $contact['rolo_contact_phone_Mobile']; ?></li>
                <li>Home: <?php echo $contact['rolo_contact_phone_Home']; ?></li>
                <li>Work: <?php echo $contact['rolo_contact_phone_Work']; ?></li>
                <li>Fax: <?php echo $contact['rolo_contact_phone_Fax']; ?></li>
                <li>Other: <?php echo $contact['rolo_contact_phone_Other']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /contact-middle -->

    <div class="span-2" id="contact-right">
        <p>
            <span class="commentnum">
                <a href="<?php get_permalink(get_the_ID()); ?>#comments" title="Comment on ">Notes</a>
            </span>
        </p>
    </div><!-- /contact-right -->

<?php
}

/**
 * Display full contact information
 *
 * @param int $contact_id
 * @return <type>
 */
function rolo_contact_full($contact_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
//    print_r($contact);
?>
    <div class="span-3 first" id="contact_image">
        <?php echo get_avatar($contact['rolo_contact_email']);?>
        <!--img class="contact_image" src="" alt="image" width="100" height="100"/-->
    </div>

     <div class="span-4" id="contact-left">
         <div class="contact">
             <h4><a href="<?php echo get_permalink($contact_id); ?>" rel="bookmark"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></h4>
         </div><!-- /contact -->

         <div class="info small" id="info_box">
             <?php
             //TODO Find out how to associate companies
             ?>
             <ul>
                 <li class="company">
                     <?php echo get_the_term_list($contact_id, 'company', __('Company:')); ?>
                 </li>
                 <li class="email">
                    <a href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?></a>
                 </li>
             </ul>
        </div><!-- /info_box -->

    </div><!-- /contact-left -->

    <div class="span-4" id="contact-middle">
        <div class="phone small">
            <ul>
                <li>Mobile: <?php echo $contact['rolo_contact_phone_Mobile']; ?></li>
                <li>Home: <?php echo $contact['rolo_contact_phone_Home']; ?></li>
                <li>Work: <?php echo $contact['rolo_contact_phone_Work']; ?></li>
                <li>Fax: <?php echo $contact['rolo_contact_phone_Fax']; ?></li>
                <li>Other: <?php echo $contact['rolo_contact_phone_Other']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /contact-middle -->

    <div class="span-4" id="contact-middle">
        <div class="IM small">
            <ul>
                <li>Yahoo: <?php echo $contact['rolo_contact_im_Yahoo']; ?></li>
                <li>MSN: <?php echo $contact['rolo_contact_im_MSN']; ?></li>
                <li>AOL: <?php echo $contact['rolo_contact_im_AOL']; ?></li>
                <li>GTalk: <?php echo $contact['rolo_contact_im_GTalk']; ?></li>
                <li>Skype: <?php echo $contact['rolo_contact_im_Skype']; ?></li>
                <li>Website: <?php echo $contact['rolo_contact_website']; ?></li>
                <li>Twitter: <?php echo $contact['rolo_contact_twitter']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /contact-middle -->

    <div class="span-4" id="contact-middle">
        <div class="IM small">
            <ul>
                <li>Address: <?php echo $contact['rolo_contact_address']; ?></li>
                <li>City: <?php echo $contact['rolo_contact_city']; ?></li>
                <li>State: <?php echo $contact['rolo_contact_state']; ?></li>
                <li>Zip: <?php echo $contact['rolo_contact_zip']; ?></li>
                <li>Country: <?php echo $contact['rolo_contact_country']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /contact-middle -->

    <div class="span-2" id="contact-right">
        <p>
            <span class="commentnum">
                <a href="<?php get_permalink(get_the_ID()); ?>#comments" title="Comment on ">Notes</a>
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
                    <li><a title="contacts" href="/type/contact"><span>Contacts</span></a></li>
                    <li><a title="companies" href="/type/company"><span>Companies</span></a></li>
                    </ul>					
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