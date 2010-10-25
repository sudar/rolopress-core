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

			<?php echo get_avatar (($contact['rolo_contact_email']),96, rolo_get_twitter_profile_image($contact['rolo_contact_twitter'], ROLOPRESS_IMAGES . "/icons/rolo-contact.jpg") );?>

			<li><a class="fn" href="<?php the_permalink();?>"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></li>
			<li>
			<?php 
			if ($contact['rolo_contact_title'] != "") { ?>
				<span class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></span><?php }
			if (get_the_term_list($contact_id, 'company') != "") { ?>
				<span class="org"><?php echo get_the_term_list($contact_id, 'company', ''); ?></span><?php }
			?>
            </li>
			<?php if ($contact['rolo_contact_email'] != "") { ?><li class="email url-field"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li><?php } ?>

			<?php rolopress_after_contact_header();?>
    </ul><!-- hcard -->
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
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact', true);
?>
    <form id="contact-form">
        <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $contact_id;?>" />
		<ul id="vcard-<?php echo basename(get_permalink());?>" class="vcard">

			<li class="vcard-export"><a class="url-field" href="http://h2vx.com/vcf/<?php the_permalink();?>"><span><?php _e('Export vCard', 'rolopress'); ?></span></a></li>
			
			<li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
			
			<?php if ($contact['rolo_contact_title'] != "") { ?>
			<li class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></li><?php }
			?>
			<?php if (get_the_term_list($contact_id, 'company') != "") { ?>
			<li class="org"><span class="value"><?php echo get_the_term_list($contact_id, 'company', ''); ?></span></li><?php }
			?>
				
			<?php $rolo_contact_full_address = $contact['rolo_contact_address'] . get_the_term_list($contact_id, 'city', '', '', '') . get_the_term_list($contact_id, 'state', '', '', '') . get_the_term_list($contact_id, 'zip', '', '', '') . get_the_term_list($contact_id, 'country', '', '', '');
				if ($rolo_contact_full_address != "") { ?>
				<li class="map"><a class="url-field" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $contact['rolo_contact_address'] . " " . rolo_get_term_list($contact_id, 'city') . " " . rolo_get_term_list($contact_id, 'state') . " " . rolo_get_term_list($contact_id, 'country')  . " " . rolo_get_term_list($contact_id, 'zip');?> "><span><?php _e('Map', 'rolopress'); ?></span></a></li><?php }
			?>
									   
			<li>
				<ul class="adr group">
				<span class="type hide">Home</span><!-- certain hcard parsers need this -->
				<?php
					if ($contact['rolo_contact_address'] != "") { ?><li class="street-address" id="rolo_contact_address"><?php echo $contact['rolo_contact_address']; ?></li><?php }
                    if (get_the_term_list($contact_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('City', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'city', '', '', '');?><span id="city" class="locality edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'city'); ?></span></li><?php }
					if (get_the_term_list($contact_id, 'state', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('State', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'state', '', '', '');?><span id="state" class="region edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'state'); ?></span></li><?php }
                    if (get_the_term_list($contact_id, 'zip', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Zip', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'zip', '', '', '');?></a><span id="zip" class="postal-code edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'zip'); ?></span></li><?php }
                    if (get_the_term_list($contact_id, 'country', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Country', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'country', '', '', '');?><span id="country" class="country-name edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'country'); ?></span></li><?php }
				?>
				</ul>
			</li>
			
			<?php if ($contact['rolo_contact_email'] != "") { ?><li class="email-address url-field group"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li><?php } ?>
            <li>
				<ul class="tel group">
				<?php
					if ($contact['rolo_contact_phone_Mobile'] != "") { ?><li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Mobile"><?php echo $contact['rolo_contact_phone_Mobile']; ?></span></li> <?php }
					if ($contact['rolo_contact_phone_Home'] != "") { ?><li class="tel tel-home"><span class="type"><?php _e('Home', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Home"><?php echo $contact['rolo_contact_phone_Home']; ?></span></li><?php }
					if ($contact['rolo_contact_phone_Work'] != "") { ?><li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Work"><?php echo $contact['rolo_contact_phone_Work']; ?></span></li><?php }
					if ($contact['rolo_contact_phone_Fax'] != "") { ?><li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Fax"><?php echo $contact['rolo_contact_phone_Fax']; ?></span></li><?php }
					if ($contact['rolo_contact_phone_Other'] != "") { ?><li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Other"><?php echo $contact['rolo_contact_phone_Other']; ?></span></li><?php }
				?>
                </ul>
            </li>
            <li>
                <ul class="im social group">
				<?php
					if ($contact['rolo_contact_im_Yahoo'] != "") { ?><li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span> <a class="yahoo" href="ymsgr:sendIM?<?php echo $contact['rolo_contact_im_Yahoo']; ?>"><?php echo $contact['rolo_contact_im_Yahoo']; ?></a><span id="rolo_contact_im_Yahoo" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Yahoo']; ?></span></li><?php }
					if ($contact['rolo_contact_im_MSN'] != "") { ?><li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span> <a class="msn" href="msnim:chat?contact=<?php echo $contact['rolo_contact_im_MSN']; ?>"><?php echo $contact['rolo_contact_im_MSN']; ?></a><span id="rolo_contact_im_MSN" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_MSN']; ?></span></li><?php }
					if ($contact['rolo_contact_im_AOL'] != "") { ?><li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span> <a class="aim" href="aim:goIM?<?php echo $contact['rolo_contact_im_AOL']; ?>"><?php echo $contact['rolo_contact_im_AOL']; ?></a><span id="rolo_contact_im_AOL" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_AOL']; ?></span></li><?php }
					if ($contact['rolo_contact_im_GTalk'] != "") { ?><li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span> <a class="gtalk" href="gtalk:chat?jid=<?php echo $contact['rolo_contact_im_GTalk']; ?>"><?php echo $contact['rolo_contact_im_GTalk']; ?></a><span id="rolo_contact_im_GTalk" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_GTalk']; ?></span></li><?php }
					if ($contact['rolo_contact_im_Skype'] != "") { ?><li class="social social-skype url-field"><span class="type"><?php _e('Skype', 'rolopress'); ?></span> <a class="skype" href="skype:=<?php echo $contact['rolo_contact_im_Skype']; ?>"><?php echo $contact['rolo_contact_im_Skype']; ?></a><span id="rolo_contact_im_Skype" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Skype']; ?></span></li><?php }
					if ($contact['rolo_contact_twitter'] != "") { ?><li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $contact['rolo_contact_twitter']; ?>"><?php echo $contact['rolo_contact_twitter']; ?></a><span id="rolo_contact_twitter" class="edit-icon" style=""><?php echo $contact['rolo_contact_twitter']; ?></span></li><?php }
				?>
                </ul>
            </li>
				<?php if ($contact['rolo_contact_website'] != "") { ?><li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span><a class="url" href="http://<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a><span id="rolo_contact_website" class="edit-icon" style=""><?php echo $contact['rolo_contact_website']; ?></span></li><?php } ?>
				
				<?php if ($contact['rolo_contact_post_tag'] != "" ) { ?>
						<li class="tags url-field"><span class="type"><?php _e('Tags', 'rolopress');?></span>
							<?php $post_tags = get_the_tags();
							$tag_list = '';
							$i = 0;
							foreach ( $post_tags as $pt ) {
								$tag_list .= $pt->name;
								if ( $i+1<sizeof($post_tags) )
								$tag_list	.= ', ';
								$i++;
							}
							$tag_links	= get_the_term_list($cid, 'post_tag', '', ',','');
							$tag_links	= explode(', ', $tag_links );
							?>
							
							<ul class="tags group">
								<?php foreach ( $tag_links as $i=>$tag ): ?>
										<li class="url-field">
											<?php echo $tag; ?>
											<?php if ($i+1==sizeof($tag_links)): ?>
											<span id="post_tag" class="edit-icon" style=""><?php echo $tag_list; ?></span>
											<?php endif; ?>
										</li>
								<?php if ($i+1<sizeof($tag_links)): echo ', '; endif ?>
								<?php endforeach; ?>
							</ul>
				<?php } ?>
</li>		
				
				<?php rolopress_after_contact_details();?>
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

    $company = get_post_meta($company_id, 'rolo_company', true);
    
	$post_id = get_post($post->ID); // get current company id
    $slug = $post_id->post_name; // define slug as $slug

?>
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

			<?php echo get_avatar (($company['rolo_company_email']),96, rolo_get_twitter_profile_image($company['rolo_company_twitter'], ROLOPRESS_IMAGES . "/icons/rolo-company.jpg"));?>
			<li>
                 <a class="fn"
                    <?php if (is_single()) : // show proper links on single or archive company pages ?>
                        href="<?php echo get_term_link($company['rolo_company_name'], 'company'); ?>"><?php echo $company['rolo_company_name'];?>
                    <?php else: ?>
                        href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?>
                    <?php endif;?>
                </a>
			</li>
		
			<?php 
			if ($company['rolo_company_email'] != "") { ?>
				<li class="email url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?> </a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li><?php }
			if ($company['rolo_company_website'] != "") { ?>
				<li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="http://<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></span></li><?php }
			?>
			<?php rolopress_after_company_header();?>
    </ul><!-- hcard -->
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
    if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company', true);
    $slug = $post_id->post_name; // define slug as $slug
//    print_r($company);
?>
    <form id="company-form">
        <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $company_id;?>" />
		<ul id="vcard-<?php basename(get_permalink());?>" class="vcard">

		<li class="vcard-export"><a class="url-field" href="http://h2vx.com/vcf/<?php the_permalink();?>"><span><?php _e('Export vCard', 'rolopress'); ?></span></a></li>
		
			<li>
                 <a class="fn org"
                    <?php if (is_single()) : // show proper links on single or archive company pages ?>
                        href="<?php echo get_term_link($company['rolo_company_name'], 'company'); ?>"><?php echo $company['rolo_company_name'];?>
                    <?php else: ?>
                        href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?>
                    <?php endif;?>
                </a>
			</li>
	               
			<?php $rolo_company_full_address = $company['rolo_company_address'] . get_the_term_list($company_id, 'city', '', '', '') . get_the_term_list($company_id, 'state', '', '', '') . get_the_term_list($company_id, 'zip', '', '', '') . get_the_term_list($company_id, 'country', '', '', '');
				if ($rolo_company_full_address != "") { ?>
					<li class="map"><a class="url" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $company['rolo_company_address'] . " " . rolo_get_term_list($company_id, 'city') . " " . rolo_get_term_list($company_id, 'state') . " " . rolo_get_term_list($company_id, 'country')  . " " . rolo_get_term_list($company_id, 'zip');?> "><span><?php _e('Map', 'rolopress'); ?></span></a></li><?php }
			?>
		
			<li>
				<ul class="adr group">
				<span class="type hide">Work</span><!-- certain hcard parsers need this -->
				<?php
					if ($company['rolo_company_address'] != "") { ?><li class="street-address" id="rolo_company_address"><?php echo $company['rolo_company_address']; ?></li><?php }
                   	if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('City', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'city', '', '', '');?><span id="city" class="locality edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'city'); ?></span></li><?php }
                    if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('State', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'state', '', '', '');?><span id="state" class="region edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'state'); ?></span></li><?php }
                    if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Zip', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'zip', '', '', '');?></a><span id="zip" class="postal-code edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'zip'); ?></span></li><?php }
                    if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Country', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'country', '', '', '');?><span id="country" class="country-name edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'country'); ?></span></li><?php }
				?>
				
				</ul>
			</li>


            <?php if ($company['rolo_company_email'] != "") { ?><li class="email-address url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?></a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li><?php } ?>

            <li>
                <ul class="tel group">
				<?php
					if ($company['rolo_company_phone_Mobile'] != "") { ?><li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Mobile"><?php echo $company['rolo_company_phone_Mobile']; ?></span></li><?php }
                    if ($company['rolo_company_phone_Work'] != "") { ?><li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Work"><?php echo $company['rolo_company_phone_Work']; ?></span></li><?php }
                    if ($company['rolo_company_phone_Fax'] != "") { ?><li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Fax"><?php echo $company['rolo_company_phone_Fax']; ?></span></li><?php }
                    if ($company['rolo_company_phone_Other'] != "") { ?><li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Other"><?php echo $company['rolo_company_phone_Other']; ?></span></li><?php }
				?>
                </ul>
            </li>

            <li>
                <ul class="im social group">
				<?php
					if ($company['rolo_company_im_Yahoo'] != "") { ?><li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span>: <a class="yahoo" href="ymsgr:sendIM?<?php echo $company['rolo_company_im_Yahoo']; ?>"><?php echo $company['rolo_company_im_Yahoo']; ?></a><span id="rolo_company_im_Yahoo" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li><?php }
                    if ($company['rolo_company_im_MSN'] != "") { ?><li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span>: <a class="msn" href="msnim:chat?company=<?php echo $company['rolo_company_im_MSN']; ?>"><?php echo $company['rolo_company_im_MSN']; ?></a><span id="rolo_company_im_MSN" class="edit-icon" style=""><?php echo $company['rolo_company_im_MSN']; ?></span></li><?php }
                    if ($company['rolo_company_im_AIM'] != "") { ?><li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span>: <a class="aim" href="aim:goIM?<?php echo $company['rolo_company_im_AOL']; ?>"><?php echo $company['rolo_company_im_AOL']; ?></a><span id="rolo_company_im_AOL" class="edit-icon" style=""><?php echo $company['rolo_company_im_AOL']; ?></span></li><?php }
                    if ($company['rolo_company_im_GTalk'] != "") { ?><li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span>: <a class="gtalk" href="gtalk:chat?jid=<?php echo $company['rolo_company_im_GTalk']; ?>"><?php echo $company['rolo_company_im_GTalk']; ?></a><span id="rolo_company_im_GTalk" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li><?php }
					if ($company['rolo_company_twitter'] != "") { ?><li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $company['rolo_company_twitter']; ?>"><?php echo $company['rolo_company_twitter']; ?></a><span id="rolo_company_twitter" class="edit-icon" style=""><?php echo $company['rolo_company_twitter']; ?></span></li><?php }
				?>
                </ul>
            </li>

    		<?php if ($company['rolo_company_website'] != "") { ?><li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="http://<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></span></li><?php } ?>
			
			<?php if ($company['rolo_company_post_tag'] != "" ) { ?>
				<li class="tags url-field"><span class="type"><?php _e('Tags', 'rolopress');?></span>
					<?php $post_tags = get_the_tags();
					$tag_list = '';
					$i = 0;
					foreach ( $post_tags as $pt ) {
						$tag_list	.= $pt->name;
						if ( $i+1<sizeof($post_tags) )
						$tag_list	.= ', ';
						$i++;
					}
					$tag_links	= get_the_term_list($cid, 'post_tag', '', ', ');
					$tag_links	= explode(', ', $tag_links );
					?>
					
				<ul class="tags group">
					<?php foreach ( $tag_links as $i=>$tag ): ?>
						<li class="url-field">
							<?php echo $tag; ?>
							<?php if ($i+1==sizeof($tag_links)): ?>
								<span id="post_tag" class="edit-icon" style=""><?php echo $tag_list; ?></span>
							<?php endif; ?>
						</li>
			
				<?php if ($i+1<sizeof($tag_links)): echo ', '; endif ?>
					<?php endforeach; ?>
				</ul>
			<?php } ?>

</li>
			
			
			
			
			<?php rolopress_after_company_details();?>
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


/**
 * Get Page ID by page title
 *
 * @param string $page_name Page title
 *
 * @Credits: http://www.web-templates.nu/2008/09/02/get-id-by-page-name/
 *
 * @since 0.2
 */
function rolo_get_ID_by_page_title($page_title)
{
	global $wpdb;
	$page_title_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$page_title."'");
	return $page_title_id;
}

?>