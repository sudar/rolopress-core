<?php
/**
 * Contains all the template functions used in theme
 */

/**
 * Print summary information about contact
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_header($contact_id) {
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
?>
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

			<?php echo get_avatar (($contact['rolo_contact_email']),96,get_bloginfo('template_url') . "/img/icons/rolo-contact.jpg");?>

			<li class="fn"><a href="<?php the_permalink();?>"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></li>
			<li>
				<span class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></span>
				<span class="org"><?php echo get_the_term_list($contact_id, 'company', __('')); ?></span>
            </li>
			 <li class="email url-field"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li>
    </ul><!-- vcard -->

<?php
}

/**
 * Display contact details
 *
 * @param int $contact_id
 * @return <type>
 */
function rolo_contact_details($contact_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
//    print_r($contact);
?>
    <form id="contact-form">
        <input type="hidden" name="rolo_contact_id" id="rolo_contact_id" value ="<?php echo $contact_id;?>" />
        <ul id="hcard-<?php echo basename(get_permalink());?>" class="vcard">

			<li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
            <li class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></li>
			<li class="org"><span class="value"><?php echo get_the_term_list($contact_id, 'company'); ?></span></li>
        <li class="adr label group">
                <span class="street-address" id="rolo_contact_address"><?php echo $contact['rolo_contact_address']; ?></span>
                <span class="locality" id="rolo_contact_city"><?php echo $contact['rolo_contact_city']; ?></span>
                <abbr class="region" id ="rolo_contact_state" title="<?php echo $contact['rolo_contact_state']; ?>"><?php echo $contact['rolo_contact_state']; ?></abbr>
                <span class="postal-code" id="rolo_contact_zip" ><?php echo $contact['rolo_contact_zip']; ?></span>
                <span class="country-name" id="rolo_contact_country" ><?php echo $contact['rolo_contact_country']; ?></span>
		</li>
        <li class="email url-field group"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li>
        <li>
             <ul class="tel group">
                 <li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Mobile"><?php echo $contact['rolo_contact_phone_Mobile']; ?></span></li>
                 <li class="tel tel-home"><span class="type"><?php _e('Home', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Home"><?php echo $contact['rolo_contact_phone_Home']; ?></span></li>
                 <li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Work"><?php echo $contact['rolo_contact_phone_Work']; ?></span></li>
                <li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Fax"><?php echo $contact['rolo_contact_phone_Fax']; ?></span></li>
                <li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Other"><?php echo $contact['rolo_contact_phone_Other']; ?></span></li>
            </ul>
        </li>
		
        <li>
            <ul class="im social group">
			
				<li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span>: <a class="yahoo" href="ymsgr:sendIM?<?php echo $contact['rolo_contact_im_Yahoo']; ?>"><?php echo $contact['rolo_contact_im_Yahoo']; ?></a><span id="rolo_contact_im_Yahoo" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Yahoo']; ?></span></li>
				
				<li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span>: <a class="msn" href="msnim:chat?contact=<?php echo $contact['rolo_contact_im_MSN']; ?>"><?php echo $contact['rolo_contact_im_MSN']; ?></a><span id="rolo_contact_im_MSN" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_MSN']; ?></span></li>
								
				<li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span>: <a class="aim" href="aim:goIM?<?php echo $contact['rolo_contact_im_AOL']; ?>"><?php echo $contact['rolo_contact_im_AOL']; ?></a><span id="rolo_contact_im_AOL" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_AOL']; ?></span></li>
												
				<li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span>: <a class="gtalk" href="gtalk:chat?jid=<?php echo $contact['rolo_contact_im_GTalk']; ?>"><?php echo $contact['rolo_contact_im_GTalk']; ?></a><span id="rolo_contact_im_GTalk" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Yahoo']; ?></span></li>
																
				<li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="<?php echo $contact['rolo_contact_twitter']; ?>"><?php echo $contact['rolo_contact_twitter']; ?></a><span id="rolo_contact_twitter" class="edit-icon" style=""><?php echo $contact['rolo_contact_twitter']; ?></span></li>
            </ul>
        </li>
		
        <li>
            <li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a><span id="rolo_contact_website" class="edit-icon" style=""><?php echo $contact['rolo_contact_website']; ?></li>
        </li>
		
        </ul><!-- vcard -->
    </form>

<?php
}

/**
 * Print summary information about company
 * @param <type> $company_id
 * @return <type>
 */
function rolo_company_header($company_id) {

    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
?>

<ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

			<?php echo get_avatar (($company['rolo_company_email']),96,get_bloginfo('template_url') . "/img/icons/rolo-company.jpg");?>

			<li class="fn"><a href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?></li></a>
		
			<li class="email url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?> </a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li>
		
            <li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></li>

</ul><!-- vcard -->

<?php
}

/**
 * Display company details
 *
 * @param int $company_id
 * @return <type>
 */
function rolo_company_details($company_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
//    print_r($company);
?>
    <form id="company-form">
        <input type="hidden" name="rolo_company_id" id="rolo_company_id" value ="<?php echo $company_id;?>" />
        <ul id="hcard-<?php echo basename(get_permalink());?>" class="vcard">

        <li class="fn"><a href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?></li></a>
        <li>
            <span class="adr label group">
                <span id="rolo_company_address" class="street-address"><?php echo $company['rolo_company_address']; ?></span>
                <span id ="rolo_company_city" class="locality"><?php echo $company['rolo_company_city']; ?></span>
                <abbr id ="rolo_company_state" class="region" title="<?php echo $company['rolo_company_state']; ?>"><?php echo $company['rolo_company_state']; ?></abbr>
                <span id="rolo_company_zip" class="postal-code"><?php echo $company['rolo_company_zip']; ?></span>
                <span id="rolo_company_country" class="country-name"><?php echo $company['rolo_company_country']; ?></span>
            </span>
		</li>

        <li>
    		<a class="map" id ="rolo_company_address" href="http://maps.google.com/maps?f=q&hl=en&geocode=&q= <?php echo $company['rolo_company_address'];?> + <?php echo $company['rolo_company_city'];?> + <?php echo $company['rolo_company_state'];?> + <?php echo $company['rolo_company_zip'];?> + <?php echo $company['rolo_company_country']; ?> &ie=UTF8&iwloc=addr" target="_blank"><span>Map</span></a>
		</li>
	
        <li class="email url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?> </a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li>

        <li>
             <ul class="tel group">
                 <li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Mobile"><?php echo $company['rolo_company_phone_Mobile']; ?></span></li>
                <li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Work"><?php echo $company['rolo_company_phone_Work']; ?></span></li>
                <li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Fax"><?php echo $company['rolo_company_phone_Fax']; ?></span></li>
                <li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Other"><?php echo $company['rolo_company_phone_Other']; ?></span></li>
			</ul>
		</li>

        <li>
            <ul class="im social group">
			
				<li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span>: <a class="yahoo" href="ymsgr:sendIM?<?php echo $company['rolo_company_im_Yahoo']; ?>"><?php echo $company['rolo_company_im_Yahoo']; ?></a><span id="rolo_company_im_Yahoo" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li>
				
				<li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span>: <a class="msn" href="msnim:chat?company=<?php echo $company['rolo_company_im_MSN']; ?>"><?php echo $company['rolo_company_im_MSN']; ?></a><span id="rolo_company_im_MSN" class="edit-icon" style=""><?php echo $company['rolo_company_im_MSN']; ?></span></li>
								
				<li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span>: <a class="aim" href="aim:goIM?<?php echo $company['rolo_company_im_AOL']; ?>"><?php echo $company['rolo_company_im_AOL']; ?></a><span id="rolo_company_im_AOL" class="edit-icon" style=""><?php echo $company['rolo_company_im_AOL']; ?></span></li>
												
				<li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span>: <a class="gtalk" href="gtalk:chat?jid=<?php echo $company['rolo_company_im_GTalk']; ?>"><?php echo $company['rolo_company_im_GTalk']; ?></a><span id="rolo_company_im_GTalk" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li>
																
				<li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="<?php echo $company['rolo_company_twitter']; ?>"><?php echo $company['rolo_company_twitter']; ?></a><span id="rolo_company_twitter" class="edit-icon" style=""><?php echo $company['rolo_company_twitter']; ?></span></li>
            </ul>
        </li>

        <li>
    		<li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></li>
        </li>
    </ul><!-- vcard -->
    </form>
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

function wt_get_ID_by_page_name($page_name)
{
	global $wpdb;
	$page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name_id;
}



function rolopress_default_menu() {
			{ ?>
			<div id="menu">
			<?php }
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu') ) : {
					{ ?>
                    <ul class="menu_item site-title">
					<li id="app-title"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></li>
					</ul>
					<ul class="menu_item menu_main">
					<li><a title="contacts" class="contacts" href="/type/contact"><span><?php _e('Contacts ', 'rolopress'); ?></span></a></li>
					<?php $add_contact_page = get_page_by_title('Add Contact'); $id= $add_contact_page->ID; wp_list_pages("include=$id & title_li=");?>
					<li><a title="companies" class="companies" href="/type/company"><span><?php _e('Companies ', 'rolopress'); ?></span></a></li>	
					<?php $add_company_page = get_page_by_title('Add Company'); $id= $add_company_page->ID; wp_list_pages("include=$id & title_li=");?>
					
					</ul>
					<ul class="menu_item sub_menu alignright">
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
				<?php }

}
			endif; 
				{ ?>  </div> <?php }
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
            <img src ="<?php echo get_bloginfo('template_directory') ?>/img/forms/add.png" class="rolo_add_ctrl" alt="<?php _e('Add another');?>" />
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


// Identifies taxonomy type
// thanks to Justin Tadlock: http://wordpress.org/support/topic/281899
function rolo_type_is( $type, $_post = null ) {
	if ( empty( $type ) )
		return false;

	if ( $_post )
		$_post = get_post( $_post );
	else
		$_post =& $GLOBALS['post'];

	if ( !$_post )
		return false;

	$r = is_object_in_term( $_post->ID, 'type', $type );

	if ( is_wp_error( $r ) )
		return false;

	return $r;
}


?>