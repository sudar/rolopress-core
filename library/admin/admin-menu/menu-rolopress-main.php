<?php
/**
 * RoloPress Admin Settings
 *
 * @package rolopress
 * @subpackage Functions
 */
 
// Register our settings. Add the settings section, and settings fields
function options_init_rolo_main(){
	register_setting('rolopress_main_options', 'rolopress_main_options', 'rolopress_main_options_validate' );
	
	//Contacts Section
	add_settings_section('contacts_section','Contact Settings','section_text_rolo_main_contacts',__FILE__);
	add_settings_field('contact_sort_by', 'Sort Contact List by', 'setting_contact_sort_by', __FILE__, 'contacts_section');
	add_settings_field('contact_sort_order', 'Order by', 'setting_contact_sort_order', __FILE__, 'contacts_section');
	
	//Company Section
	add_settings_section('company_section','Company Settings','section_text_rolo_main_company',__FILE__);
	add_settings_field('company_sort_by', 'Sort Company List by', 'setting_company_sort_by', __FILE__, 'company_section');
	add_settings_field('company_sort_order', 'Order by', 'setting_company_sort_order', __FILE__, 'company_section');
		
	//Search Section
	add_settings_section('search_section','Search Settings','section_text_rolo_main_search',__FILE__);
	add_settings_field('disable_rolosearch', 'RoloSearch Setting', 'setting_disable_rolosearch', __FILE__, 'search_section');
	
	//Print Section
	add_settings_section('print_section','Print Settings','section_text_rolo_main_print',__FILE__);
	add_settings_field('print_primary', 'Primary Sidebar', 'setting_print_primary', __FILE__, 'print_section');
	add_settings_field('print_secondary', 'Secondary Sidebar', 'setting_print_secondary', __FILE__, 'print_section');
	add_settings_field('print_contact_under_main', 'Contact: Under Main', 'setting_print_contact_under_main', __FILE__, 'print_section');
	add_settings_field('print_company_under_main', 'Company: Under Main', 'setting_print_company_under_main', __FILE__, 'print_section');
	
}
add_action('admin_init', 'options_init_rolo_main' );


/****************************************************************
 ************************** Admin Sections ********************** 
*****************************************************************/

///////////////////////////
//   Contact Settings
//////////////////////////

function section_text_rolo_main_contacts(){
	echo '<p>Settings for your Contacts</p>';
}

// DROP-DOWN-BOX - Name: rolopress_main_options[setting_contact_sort_by]
function setting_contact_sort_by() {
	$options = get_option('rolopress_main_options');
	$items = array("First Name", "Last Name", "Owner", "Date Created", "Last Modified", "ID", "Note Count");
	echo "<select id='contact_sort_by' name='rolopress_main_options[contact_sort_by]'>";
	foreach($items as $item) {
		$selected = ($options['contact_sort_by']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

// DROP-DOWN-BOX - Name: rolopress_main_options[setting_contact_sort_order]
function setting_contact_sort_order() {
	$options = get_option('rolopress_main_options');
	$items = array("Ascending", "Descending");
	echo "<select id='contact_sort_order' name='rolopress_main_options[contact_sort_order]'>";
	foreach($items as $item) {
		$selected = ($options['contact_sort_order']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

///////////////////////////
//   Company Settings
//////////////////////////

function section_text_rolo_main_company(){
	echo '<p>Settings for your Contacts</p>';
}

// DROP-DOWN-BOX - Name: rolopress_main_options[setting_company_sort_by]
function setting_company_sort_by() {
	$options = get_option('rolopress_main_options');
	$items = array("Name", "Owner", "Date Created", "Last Modified", "ID", "Note Count");
	echo "<select id='company_sort_by' name='rolopress_main_options[company_sort_by]'>";
	foreach($items as $item) {
		$selected = ($options['company_sort_by']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

// DROP-DOWN-BOX - Name: rolopress_main_options[setting_company_sort_order]
function setting_company_sort_order() {
	$options = get_option('rolopress_main_options');
	$items = array("Ascending", "Descending");
	echo "<select id='company_sort_order' name='rolopress_main_options[company_sort_order]'>";
	foreach($items as $item) {
		$selected = ($options['company_sort_order']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

///////////////////////////
//   Search Settings
//////////////////////////

function section_text_rolo_main_search(){
	echo '<p>If you are going to use a search plugin, you should disable RoloSearch to eliminate conflicts.</p>';
}

// DROP-DOWN-BOX - Name: rolopress_main_options[setting_contact_sort_by]
function setting_disable_rolosearch() {
	$options = get_option('rolopress_main_options');
	$items = array("Use RoloSearch", "Disable RoloSearch");
	echo "<select id='disable_rolosearch' name='rolopress_main_options[disable_rolosearch]'>";
	foreach($items as $item) {
		$selected = ($options['disable_rolosearch']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

///////////////////////////
//   Print Settings
//////////////////////////

function section_text_rolo_main_print(){
	echo '<p>Print these Widget Areas:</p>';
}

// CHECKBOX - Print Primary Sidebar
function setting_print_primary(){
	$options = get_option('rolopress_main_options');
	if($options['print_primary']){ $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='print-primary-sidebar' name='rolopress_main_options[print_primary]' type='checkbox' />";
}
// CHECKBOX - Print Secondary Sidebar
function setting_print_secondary(){
	$options = get_option('rolopress_main_options');
	if($options['print_secondary']){ $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='print-secondary-sidebar' name='rolopress_main_options[print_secondary]' type='checkbox' />";
}
// CHECKBOX - Print Contact: Under Main
function setting_print_contact_under_main(){
	$options = get_option('rolopress_main_options');
	if($options['print_contact_under_main']){ $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='print-contact-under-main' name='rolopress_main_options[print_contact_under_main]' type='checkbox' />";
}
// CHECKBOX - Print Company: Under Main
function setting_print_company_under_main(){
	$options = get_option('rolopress_main_options');
	if($options['print_company_under_main']){ $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='print-company-under-main' name='rolopress_main_options[print_company_under_main]' type='checkbox' />";
}

/****************************************************************
 ******************** Build the Admin Page ********************** 
*****************************************************************/
function rolopress_do_page() { ?>

	<div class="wrap" style="margin: 10px 0 0 0;">
		<h2>RoloPress Settings</h2>
		
		<form name="settings" action="options.php" method="post" enctype="multipart/form-action">
		<?php settings_fields('rolopress_main_options'); ?>
		<?php do_settings_sections(__FILE__);?>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>

	</div>
<?php 
}


// Validate user data for some/all of our input fields
function rolopress_main_options_validate($input) {
	
	// all field validation code will go here

	return $input; // return validated input
}