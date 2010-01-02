<?php
/**
 * Template Functions
 *
 * Contains template functions used in theme
 *
 * @package RoloPress
 * @subpackage Functions
 */
  
/**
 * Displays a summarized version of contact information
 *
 * @param int $contact_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_contact_header($contact_id) {
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
?>
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

			<li><?php echo get_avatar (($contact['rolo_contact_email']),96,ROLOPRESS_IMAGES . "/icons/rolo-contact.jpg");?></li>

			<li><a class="fn" href="<?php the_permalink();?>"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></li>
			<li>
				<span class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></span>
				<span class="org"><?php echo get_the_term_list($contact_id, 'company', __('')); ?></span>		
            </li>
			 <li class="email url-field"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li>
    </ul><!-- vcard -->
<?php
}

/**
 * Displays a contact detail information
 *
 * @param int $contact_id
 * @return <type>
 *
 * @since 0.1
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
        <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $contact_id;?>" />
		<ul id="vcard-<?php basename(get_permalink());?>" class="vcard">

			<li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
            <li class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></li>
			<li class="org"><span class="value"><?php echo get_the_term_list($contact_id, 'company'); ?></span></li>
				
			<ul class="adr map label"><span class="type"><?php _e('Map', 'rolopress'); ?></span><a class="url" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $contact['rolo_contact_address'] . "+" . $contact['rolo_contact_city']  . "+" . $contact['rolo_contact_state']  . "+" . $contact['rolo_contact_zip']  . "+" . $contact['rolo_contact_country'];?> ">Map</a>
				<li class="adr group">
                <span class="street-address" id="rolo_contact_address"><?php echo $contact['rolo_contact_address']; ?></span>
                <span class="locality" id="city"><?php echo rolo_get_term_list($contact_id, 'city') ?></span>
                <abbr class="region" id ="state" title ="<?php echo rolo_get_term_list($contact_id, 'state'); ?>" ><?php echo rolo_get_term_list($contact_id, 'state'); ?></abbr>
                <span class="postal-code" id="zip" ><?php echo rolo_get_term_list($contact_id, 'zip'); ?></span>
                <span class="country-name" id="country" ><?php echo rolo_get_term_list($contact_id, 'country'); ?></span>
				</li>
			</ul>
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
                    <li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $contact['rolo_contact_twitter']; ?>"><?php echo $contact['rolo_contact_twitter']; ?></a><span id="rolo_contact_twitter" class="edit-icon" style=""><?php echo $contact['rolo_contact_twitter']; ?></span></li>
                </ul>
            </li>
            <li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span><a class="url" href="http://<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a><span id="rolo_contact_website" class="edit-icon" style=""><?php echo $contact['rolo_contact_website']; ?></span></li>
        </ul><!-- vcard -->
    </form>
<?php
}

/**
 * Displays a summarized version of company information
 *
 * @param <type> $company_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_company_header($company_id) {

    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
	$post_id = get_post($post->ID); // get current company id
    $slug = $post_id->post_name; // define slug as $slug

?>
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

			<li><?php echo get_avatar (($company['rolo_company_email']),96,ROLOPRESS_IMAGES . "/icons/rolo-company.jpg");?></li>
			<li>
                <a class="fn"
                    <?php if (is_single()) : // show proper links on single or archive company pages ?>
                        href="<?php get_bloginfo('url');?>/company/<?php echo $slug; ?>"><?php echo $company['rolo_company_name'];?>
                    <?php else: ?>
                        href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?>
                    <?php endif;?>
                </a>
			</li>
		
			<li class="email url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?> </a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li>
            <li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="http://<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></span></li>
    </ul><!-- vcard -->
<?php
}

/**
 * Displays company detail information
 *
 * @param int $company_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_company_details($company_id) {
    //TODO Need to display the information in Microformat friendly format
    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
    $slug = $post_id->post_name; // define slug as $slug
//    print_r($company);
?>
    <form id="company-form">
        <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $company_id;?>" />
		<ul id="vcard-<?php basename(get_permalink());?>" class="vcard">

            <li class="fn">
				<?php if (is_single()) : // show proper links on single or archive company pages ?>
					<a href="<?php get_bloginfo('url');?>/company/<?php echo $slug; ?>"><?php echo $company['rolo_company_name'];?></a>
				<?php else: ?>
					<a href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?></a>
				<?php endif;?>
			</li>	
			
			<li class="adr map label">
                <span class="type"><?php _e('Map', 'rolopress'); ?></span><a class="url" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $company['rolo_company_address'] . "+" . $company['rolo_company_city']  . "+" . $company['rolo_company_state']  . "+" . $company['rolo_company_zip']  . "+" . $company['rolo_company_country'];?> ">Map</a>
                <ul>
                    <li class="adr group">
                    <span class="street-address" id="rolo_company_address"><?php echo $company['rolo_company_address']; ?></span>
                    <span class="locality" id="city"><?php echo rolo_get_term_list($company_id, 'city') ?></span>
                    <abbr class="region" id ="state" title ="<?php echo rolo_get_term_list($company_id, 'state'); ?>" ><?php echo rolo_get_term_list($company_id, 'state'); ?></abbr>
                    <span class="postal-code" id="zip" ><?php echo rolo_get_term_list($company_id, 'zip'); ?></span>
                    <span class="country-name" id="country" ><?php echo rolo_get_term_list($company_id, 'country'); ?></span>
                    </li>
                </ul>
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
                    <li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $company['rolo_company_twitter']; ?>"><?php echo $company['rolo_company_twitter']; ?></a><span id="rolo_company_twitter" class="edit-icon" style=""><?php echo $company['rolo_company_twitter']; ?></span></li>
                </ul>
            </li>

    		<li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="http://<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></span></li>
    </ul><!-- vcard -->
    </form>
<?php
}

/**
 *
 * @param <type> $post_id
 * @param <type> $taxonomy
 * @return <type>
 *
 * @since 1.0
 */
function rolo_get_term_list($post_id, $taxonomy) {
    $actual_terms = array();
    $terms = get_the_terms($post_id, $taxonomy);
    if (is_array($terms)) {
        foreach ( $terms as $term ) {
            $actual_terms[] = $term->name;
        }
    }
    return join(',' , $actual_terms);
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
 * Get contact home phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_home_phone($contact_id) {
    return _rolo_get_field($contact_id, 'home_phone');
}

/**
 * Get contact work Phone
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

function wt_get_ID_by_page_name($page_name) {
	global $wpdb;
	$page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name_id;
}

/**
 * Displays Javascript disabled warning
 *
 * @since 0.1
 */
function rolopress_js_disabled() {
?>
    <noscript>
        <p class="error"><?php __('JavaScript is disabled. For RoloPress to work properly, <a href="http://rolopress.com/forums/topic/inline-editing-not-working">please enable JavaScript.</a>');?></p>
    </noscript>
<?php
}
add_action('rolopress_before_wrapper', 'rolopress_js_disabled');

/**
 * Assembles default menu
 *
 * @since 0.1
 */
function rolopress_default_menu() {
?>
    <div id="menu">
<?php 
    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu') ) {
?>
        <ul class="menu_item site-title">
            <li id="app-title"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></li>
        </ul>
        <ul class="menu_item menu_main">
            <li>
                <a title="contacts" class="contacts" href="<?php echo get_term_link('Contact', 'type'); ?>"><span><?php _e('Contacts ', 'rolopress'); ?></span></a>
            </li>
<?php   
            if ( current_user_can('publish_posts') ) {
              // only display if user has proper permissions
               $add_contact_page = get_page_by_title('Add Contact');
               $id= $add_contact_page->ID;
               wp_list_pages("include=$id & title_li=");
            }
?>
            <li>
                <a title="companies" class="companies" href="<?php echo get_term_link('Company', 'type'); ?>"><span><?php _e('Companies ', 'rolopress'); ?></span></a>
            </li>
<?php 
            if ( current_user_can('publish_posts') ) {
                // only display if user has proper permissions
                $add_company_page = get_page_by_title('Add Company');
                $id= $add_company_page->ID;
                wp_list_pages("include=$id & title_li=");
            }
?>
        </ul>
        <ul class="menu_item sub_menu alignright">
            <li>
                <form id="searchform" method="get" action="<?php bloginfo('home') ?>">
                    <input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="20" tabindex="1" />
                    <input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Search', 'rolopress') ?>" tabindex="2" />
                </form>
            </li>
            <?php global $user_ID, $user_identity, $user_level ?>
            <?php if ( $user_level >= 1 ) : ?>
                <li><a title="settings" href="<?php bloginfo('url') ?>/wp-admin/"><span>Settings</span></a></li>
            <?php endif // $user_level >= 1 ?>
            <li><?php wp_loginout(); ?></li>
        </ul>
<?php
    }
?>
    </div>
<?php
}
add_action('rolopress_before_wrapper', 'rolopress_default_menu');

/**
 * Identifies taxonomy type
 *
 * Use to identify the item type and do something.
 * Example: if ( rolo_type_is( 'contact' ) ) { do something }	
 *
 * @credits: Justin Tadlock: http://wordpress.org/support/topic/281899
 */
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

/**
 * Get the page number
 */
function get_page_number() {
    if (get_query_var('paged')) {
        print ' | ' . __( 'Page ' , 'rolopress') . get_query_var('paged');
    }
}

/**
 * For category lists on category archives: Returns other categories except the current one (redundant)
 */
function cats_meow($glue) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list($separator) );
    foreach ( $cats as $i => $str ) {
        if ( strstr( $str, ">$current_cat<" ) ) {
            unset($cats[$i]);
            break;
        }
    }
    if ( empty($cats) )
        return false;

    return trim(join( $glue, $cats ));
}

/**
 * For tag lists on tag archives: Returns other tags except the current one (redundant)
 */
function tag_ur_it($glue) {
    $current_tag = single_tag_title( '', '',  false );
    $separator = "\n";
    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
    foreach ( $tags as $i => $str ) {
        if ( strstr( $str, ">$current_tag<" ) ) {
            unset($tags[$i]);
            break;
        }
    }
    if ( empty($tags) )
        return false;

    return trim(join( $glue, $tags ));
}
?>