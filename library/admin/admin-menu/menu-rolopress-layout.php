<?php
/**
 * RoloPress Admin Settings
 *
 * @package rolopress
 * @subpackage Functions
 */
 
// Register our settings. Add the settings section, and settings fields
function options_init_rolo_layout(){
	register_setting('rolopress_layout_options', 'rolopress_layout_options', 'rolopress_layout_options_validate' );
	
	//Layout settings
	add_settings_section('layout_section','Layout Settings','section_text_rolo_layout_options',__FILE__);
	add_settings_field('theme_layout', 'RoloPress sidebars come in two different sizes;<br/>Standard and Wide.<p/>Your layout can be one or both of these sidebar sizes. Wide is a good size for showing contact info, while standard works well with the regular WordPress widgets.', 'setting_theme_layout', __FILE__, 'layout_section');
	
}
add_action('admin_init', 'options_init_rolo_layout' );


/****************************************************************
 ************************** Admin Sections ********************** 
*****************************************************************/

///////////////////////////
//   Contact Settings
//////////////////////////

function section_text_rolo_layout_options(){
	echo '<p>Choose from 13 different layouts:</p>';
}

// RADIO BUTTON - Name: rolopress_layout_options[setting_theme_layout]
function setting_theme_layout() {
	$options = get_option('rolopress_layout_options');
	$items = array("1c-b", "2c-l", "2c-r","2c-l-w","2c-r-w","3c-l","3c-r","3c-b","3c-l-w","3c-r-w","3c-b-w","3c-b-lw","3c-b-rw");
	$itemval = array(
				"1c-b" => '<strong>' . __('1 Column', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on left %s Secondary on right','rolopress'), '<br />'),
                "2c-l" => '<strong>' . __('2 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on top left %s Secondary on Bottom left','rolopress'), '<br />'),
                "2c-r" => '<strong>' . __('2 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on top right %s Secondary on Bottom right','rolopress'), '<br />'),
                "2c-l-w" => '<strong>' . __('2 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Wide Primary on top left %s Wide Secondary on Bottom left','rolopress'), '<br />'),
                "2c-r-w" => '<strong>' . __('2 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Wide Primary on top right %s Wide Secondary on Bottom right','rolopress'), '<br />'),
                "3c-l" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on left %s Secondary on left','rolopress'), '<br />'),
                "3c-r" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on right %s Secondary on right','rolopress'), '<br />'),
                "3c-b" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Primary on left %s Secondary on right','rolopress'), '<br />'),
                "3c-l-w" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Wide Primary on left %s Wide Secondary on left','rolopress'), '<br />'),
                "3c-r-w" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Wide Primary on right %s Wide Secondary on right','rolopress'), '<br />'),
                "3c-b-w" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('Wide Primary on left %s Wide Secondary on right','rolopress'), '<br />'),
                "3c-b-lw" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('1 Wide sidebar on left %s 1 sidebar on right','rolopress'), '<br />'),
                "3c-b-rw" => '<strong>' . __('3 Columns', 'rolopress') . '</strong><br/>' . sprintf(__('1 sidebar on left %s 1 Wide sidebar on right','rolopress'), '<br />'),
				);
	foreach($items as $item) { ?>
		<div class="rolo_layout_setting_column">
		<?php $checked = ($options['theme_layout']==$item) ? ' checked="checked" ' : '';
		echo "<img src=". ROLOPRESS_IMAGES. "/admin/" . $item . ".gif /><br/><label><input ".$checked." value='$item' name='rolopress_layout_options[theme_layout]' type='radio' /> $itemval[$item]</label><br />";?>
		</div>
<?php
	}
}




/****************************************************************
 ******************** Build the Admin Page ********************** 
*****************************************************************/
function rolopress_do_layout_page() { ?>

	<div class="wrap" style="margin: 10px 0 0 0;">
		<div class="icon32" id="icon-themes"><br></div>
		<h2>RoloPress Layout</h2>
		
		<form name="settings" action="options.php" method="post" enctype="multipart/form-action">
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		<?php settings_fields('rolopress_layout_options'); ?>
		<?php do_settings_sections(__FILE__);?>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>

	</div>
<?php 
}


// Validate user data for some/all of our input fields
function rolopress_layout_options_validate($input) {
	
	// all field validation code will go here

	return $input; // return validated input
}