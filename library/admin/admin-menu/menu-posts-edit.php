<?php
/**
 * Menu: Posts - Edit
 *
 * @package RoloPress
 * @subpackage Functions
 */
 
/**
 * Set / Unset columns
 * 
 * @credits http://johnathanandersendesign.com
 */
function rolo_admin_setup_custom_column($defaults) {
    unset($defaults['date']);
	$defaults['image'] = __('Image', 'rolopress'); // adds new column to column array
	return $defaults;
}
add_filter('manage_posts_columns', 'rolo_admin_setup_custom_column');


/**
 * Add item image
 * 
 * @credits http://johnathanandersendesign.com
 */
function rolo_admin_insert_image_column($column_name, $item_id){

	if( $column_name == 'image' ) {
	
		if (!$item_id) {
			return false;
		}
				
		if ( rolo_type_is('contact') ) { 	
			$contact = get_post_meta($item_id, 'rolo_contact', true);
	        echo get_avatar (($contact['rolo_contact_email']),48,ROLOPRESS_IMAGES . "/icons/rolo-contact.jpg");
		}
		
		if ( rolo_type_is('company') ) { 	
			$company = get_post_meta($item_id, 'rolo_company', true);
	        echo get_avatar (($company['rolo_company_email']),48,ROLOPRESS_IMAGES . "/icons/rolo-company.jpg");
		}
	}
}
add_action('manage_posts_custom_column', 'rolo_admin_insert_image_column', 10, 2);

?>