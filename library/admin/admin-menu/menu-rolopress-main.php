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
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>RoloPress Settings</h2>
		
		<form name="settings" action="options.php" method="post" enctype="multipart/form-action">
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
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