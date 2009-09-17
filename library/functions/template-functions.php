<?php
/**
 * Contains all the template functions used in theme
 */

/**
 * Template function for adding new contact
 */
function rolo_add_contact() {
    if (isset($_POST['rp_add_contact']) && $_POST['rp_add_contact'] == 'add_contact') {
        if (_rolo_save_contact_fields()) {
            echo("Contact information successfully added.");
        } else {
            echo("There was some problem in inserting the contact info");
        }
    }
    _rolo_show_contact_fields();
}

/**
 * Show the list of contact fields in add contact page
 * @global array $new_meta_boxes List of contact fields
 */
function _rolo_show_contact_fields() {
	global $contact_fields;
	$rolo_tab_index = 1000;
?>
<form action="" method="post">
<?php
	foreach($contact_fields as $meta_box) {

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
function _rolo_save_contact_fields() {
	global $contact_fields;

    $new_post = array();

    $new_post['post_title'] = $_POST['first_name_rolo_value'];
    if (isset($_POST['last_name_rolo_value'])) {
        $new_post['post_title'] .= ' ' . $new_post['post_title'];
    }

    $new_post['post_type'] = 'post';
    $new_post['post_status'] = 'publish';
    $new_post['post_category'] = array(1);

    $post_id = wp_insert_post($new_post);

	foreach($contact_fields as $meta_box) {
		// Verify
        //TODO - Check whether the current use is logged in or not
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))
		{
			return false;
		}

		$data = $_POST[$meta_box['name'].'_rolo_value'];

		if($data == "") {
            delete_post_meta($post_id, $meta_box['name'].'_rolo_value', get_post_meta($post_id, $meta_box['name'].'_rolo_value', true));
        } else {
			update_post_meta($post_id, $meta_box['name'].'_rolo_value', $data);
        }
	}
    return $post_id;
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
					<?php }
					wp_page_menu( 'sort_column=menu_order&menu_class=menu_item&link_before=<span>&link_after=</span>');
					 { ?>							
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


?>