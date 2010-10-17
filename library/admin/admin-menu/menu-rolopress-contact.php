<?php
/**
 * RoloPress Admin Settings
 *
 * @package rolopress
 * @subpackage Functions
 */
 
// Register our settings. Add the settings section, and settings fields
function options_init_rolo_contact(){
	register_setting('rolopress_contact_options', 'rolopress_contact_options', 'rolopress_contact_options_validate' );
	
	//Contacts Section
	add_settings_section('sort_section','Sort Options','section_text_rolo_main_contacts',__FILE__);
	add_settings_field('contact_sort_by', 'Sort Contact List by', 'setting_contact_sort_by', __FILE__, 'sort_section');
	add_settings_field('contact_sort_order', 'Order by', 'setting_contact_sort_order', __FILE__, 'sort_section');
	
}
add_action('admin_init', 'options_init_rolo_contact' );


/****************************************************************
 ************************** Admin Sections ********************** 
*****************************************************************/

///////////////////////////
//   Contact Settings
//////////////////////////

function section_text_rolo_main_contacts(){
	echo '<p>Sort your contacts on any list page.</p>';
}

// DROP-DOWN-BOX - Name: rolopress_contact_options[setting_contact_sort_by]
function setting_contact_sort_by() {
	$options = get_option('rolopress_contact_options');
	$items = array("First Name", "Last Name", "Owner", "Date Created", "Last Modified", "ID", "Note Count");
	echo "<select id='contact_sort_by' name='rolopress_contact_options[contact_sort_by]'>";
	foreach($items as $item) {
		$selected = ($options['contact_sort_by']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

// DROP-DOWN-BOX - Name: rolopress_contact_options[setting_contact_sort_order]
function setting_contact_sort_order() {
	$options = get_option('rolopress_contact_options');
	$items = array("Ascending", "Descending");
	echo "<select id='contact_sort_order' name='rolopress_contact_options[contact_sort_order]'>";
	foreach($items as $item) {
		$selected = ($options['contact_sort_order']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

/****************************************************************
 ******************** Build the Admin Page ********************** 
*****************************************************************/
function rolopress_do_contact_settings_page() { ?>

	<div class="wrap" style="margin: 10px 0 0 0;">
		<?php echo '<img class="icon32" src=' . ROLOPRESS_IMAGES . '/admin/contact-menu-header.png />' ?>
		<h2>Contact Settings</h2>
		
		<form name="settings" action="options.php" method="post" enctype="multipart/form-action">
		<?php settings_fields('rolopress_contact_options'); ?>
		<?php do_settings_sections(__FILE__);?>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>

	</div>
<?php 
}


// Validate user data for some/all of our input fields
function rolopress_contact_options_validate($input) {
	
	// all field validation code will go here

	return $input; // return validated input
}