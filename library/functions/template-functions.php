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
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="vcard">

			<?php echo get_avatar($contact['rolo_contact_email']);?>
			<!--img class="contact_image" src="" alt="image" width="100" height="100"/-->	

			<li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
			<li class="title"><?php echo $contact['rolo_contact_title'] . ' ' . $contact['rolo_contact_title'];?></li>
		
			<?php //TODO Find out how to associate companies ?>
			<li class="org"><?php echo get_the_term_list($contact_id, 'company', __('Company:')); ?></li>
		
			<li class="email group"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a></li>
		
            <span class="website group"><a class="url" href="<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a></span>

</ul><!-- vcard -->


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

<ul id="hcard-<?php echo basename(get_permalink());?>" class="vcard">

			<?php echo get_avatar($contact['rolo_contact_email']);?>
			<!--img class="contact_image" src="" alt="image" width="100" height="100"/-->	

			<li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
			<li class="title"><?php echo $contact['rolo_contact_title'] . ' ' . $contact['rolo_contact_title'];?></li>
		
			<?php //TODO Find out how to associate companies ?>
			<li class="org"><?php echo get_the_term_list($contact_id, 'company', __('Company:')); ?></li>
		
			<li class="email group"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a></li>
		 
		 <ul class="tel group">
			<li class="tel"><span class="type"><?php _e('Mobile ', 'rolopress'); ?></span>:<span class="value"><?php echo $contact['rolo_contact_phone_Mobile']; ?></span></li>
			<li class="tel"><span class="type"><?php _e('Home ', 'rolopress'); ?></span>:<span class="value"><?php echo $contact['rolo_contact_phone_Home']; ?></span></li>
			<li class="tel"><span class="type"><?php _e('Work ', 'rolopress'); ?></span>:<span class="value"><?php echo $contact['rolo_contact_phone_Work']; ?></span></li>
			<li class="tel"><span class="type"><?php _e('Fax ', 'rolopress'); ?></span>:<span class="value"><?php echo $contact['rolo_contact_phone_Fax']; ?></span></li>
			<li class="tel"><span class="type"><?php _e('Other ', 'rolopress'); ?></span>:<span class="value"><?php echo $contact['rolo_contact_phone_Other']; ?></span></li>
		</ul>
		
		<ul class="im social group">
			<li class="social"><span class="type"><?php _e('Yahoo ', 'rolopress'); ?></span>:<a class="yahoo" href="ymsgr:sendIM?<?php echo $contact['rolo_contact_im_Yahoo']; ?>"><?php echo $contact['rolo_contact_im_Yahoo']; ?></a></li>
			<li class="social"><span class="type"><?php _e('MSN ', 'rolopress'); ?></span>:<a class="msn" href="msnim:chat?contact=<?php echo $contact['rolo_contact_im_MSN']; ?>"><?php echo $contact['rolo_contact_im_MSN']; ?></a></li>
			<li class="social"><span class="type"><?php _e('AIM ', 'rolopress'); ?></span>:<a class="aim" href="aim:goIM?<?php echo $contact['rolo_contact_im_AOL']; ?>"><?php echo $contact['rolo_contact_im_AOL']; ?></a></li>
			<li class="social"><span class="type"><?php _e('GTalk ', 'rolopress'); ?></span>:<a class="gtalk" href="gtalk:chat?jid=<?php echo $contact['rolo_contact_im_GTalk']; ?>"><?php echo $contact['rolo_contact_im_GTalk']; ?></a></li>
			<li class="social"><span class="type"><?php _e('Skype ', 'rolopress'); ?></span>:<a class="skype" href="skype:<?php echo $contact['rolo_contact_im_Skype']; ?>?chat"><?php echo $contact['rolo_contact_im_Skype']; ?></a></li>
			<li class="social"><span class="type"><?php _e('Twitter ', 'rolopress'); ?></span>:<a class="twitter" href="http://www.twitter.com/<?php echo $contact['rolo_contact_twitter']; ?>"><?php echo $contact['rolo_contact_twitter']; ?></a></li>
		</ul>
		
		<span class="website group"><a class="url" href="<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a></span>

		<span class="adr label group">
			<span class="street-address"><?php echo $contact['rolo_contact_address']; ?></span>
			<span class="locality"><?php echo $contact['rolo_contact_city']; ?></span>,
			<abbr class="region" title="<?php echo $contact['rolo_contact_state']; ?>"><?php echo $contact['rolo_contact_state']; ?></abbr>
			<span class="postal-code"><?php echo $contact['rolo_contact_zip']; ?></span>
			<span class="country-name"><?php echo $contact['rolo_contact_country']; ?></span>
		</span>

 
</ul><!-- vcard -->



<?php
}

/**
 * Print summary information about company
 * @param <type> $company_id
 * @return <type>
 */
function rolo_company_summary($company_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
?>
    <div class="span-3 first" id="company_image">
        <?php echo get_avatar($company['rolo_company_email']);?>
        <!--img class="company_image" src="" alt="image" width="100" height="100"/-->
    </div>

     <div class="span-4" id="company-left">
         <div class="company">
             <h4><a href="<?php echo get_permalink($company_id); ?>" rel="bookmark"><?php echo $company['rolo_company_name'];?></a></h4>
         </div><!-- /company -->

         <div class="info small" id="info_box">
             <?php
             //TODO Find out how to associate companies
             ?>
             <ul>
                 <li class="email">
                    <a href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?></a>
                 </li>
             </ul>
        </div><!-- /info_box -->

    </div><!-- /company-left -->

    <div class="span-4" id="company-middle">
        <div class="phone small">
            <ul>
                <li>Mobile: <?php echo $company['rolo_company_phone_Mobile']; ?></li>
                <li>Home: <?php echo $company['rolo_company_phone_Home']; ?></li>
                <li>Work: <?php echo $company['rolo_company_phone_Work']; ?></li>
                <li>Fax: <?php echo $company['rolo_company_phone_Fax']; ?></li>
                <li>Other: <?php echo $company['rolo_company_phone_Other']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /company-middle -->

    <div class="span-2" id="company-right">
        <p>
            <span class="commentnum">
                <a href="<?php get_permalink(get_the_ID()); ?>#comments" title="Comment on ">Notes</a>
            </span>
        </p>
    </div><!-- /company-right -->

<?php
}

/**
 * Display full company information
 *
 * @param int $company_id
 * @return <type>
 */
function rolo_company_full($company_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
//    print_r($company);
?>
    <div class="span-3 first" id="company_image">
        <?php echo get_avatar($company['rolo_company_email']);?>
        <!--img class="company_image" src="" alt="image" width="100" height="100"/-->
    </div>

     <div class="span-4" id="company-left">
         <div class="company">
             <h4><a href="<?php echo get_permalink($company_id); ?>" rel="bookmark"><?php echo $company['rolo_company_first_name'] . ' ' . $company['rolo_company_last_name'];?></a></h4>
         </div><!-- /company -->

         <div class="info small" id="info_box">
             <?php
             //TODO Find out how to associate companies
             ?>
             <ul>
                 <li class="company">
                     <?php echo get_the_term_list($company_id, 'company', __('Company:')); ?>
                 </li>
                 <li class="email">
                    <a href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?></a>
                 </li>
             </ul>
        </div><!-- /info_box -->

    </div><!-- /company-left -->

    <div class="span-4" id="company-middle">
        <div class="phone small">
            <ul>
                <li>Mobile: <?php echo $company['rolo_company_phone_Mobile']; ?></li>
                <li>Home: <?php echo $company['rolo_company_phone_Home']; ?></li>
                <li>Work: <?php echo $company['rolo_company_phone_Work']; ?></li>
                <li>Fax: <?php echo $company['rolo_company_phone_Fax']; ?></li>
                <li>Other: <?php echo $company['rolo_company_phone_Other']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /company-middle -->

    <div class="span-4" id="company-middle">
        <div class="IM small">
            <ul>
                <li>Yahoo: <?php echo $company['rolo_company_im_Yahoo']; ?></li>
                <li>MSN: <?php echo $company['rolo_company_im_MSN']; ?></li>
                <li>AOL: <?php echo $company['rolo_company_im_AOL']; ?></li>
                <li>GTalk: <?php echo $company['rolo_company_im_GTalk']; ?></li>
                <li>Skype: <?php echo $company['rolo_company_im_Skype']; ?></li>
                <li>Website: <?php echo $company['rolo_company_website']; ?></li>
                <li>Twitter: <?php echo $company['rolo_company_twitter']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /company-middle -->

    <div class="span-4" id="company-middle">
        <div class="IM small">
            <ul>
                <li>Address: <?php echo $company['rolo_company_address']; ?></li>
                <li>City: <?php echo $company['rolo_company_city']; ?></li>
                <li>State: <?php echo $company['rolo_company_state']; ?></li>
                <li>Zip: <?php echo $company['rolo_company_zip']; ?></li>
                <li>Country: <?php echo $company['rolo_company_country']; ?></li>
            </ul>
        </div><!-- /phone small -->
    </div><!-- /company-middle -->

    <div class="span-2" id="company-right">
        <p>
            <span class="commentnum">
                <a href="<?php get_permalink(get_the_ID()); ?>#comments" title="Comment on ">Notes</a>
            </span>
        </p>
    </div><!-- /company-right -->

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
                    <ul class="menu_item site-title">
					<li id="app-title"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></li>
					</ul>
					<ul class="menu_item menu_main">
					<li><a title="contacts" href="/type/contact"><span><?php _e('Contacts ', 'rolopress'); ?></span></a></li>
					<li><a title="companies" href="/type/company"><span><?php _e('Companies ', 'rolopress'); ?></span></a></li>	
					
	<!-- SUDAR: IF WE CONVERT WP_TAG_CLOUD TO AN ARRAY CAN WE USE IT TO FORMAT THE MENU BETTER -->	
							<!-- <?php wp_tag_cloud('taxonomy=type&smallest=12&largest=12&unit=px&format=list'); ?> -->

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