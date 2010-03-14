<?php
/**
 * Menu: Settings - Print
 *
 * @package RoloPress
 * @subpackage Functions
 */

// Theme options adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/


// Create options

$print_options = array (
					
				array(	"name" => __('Primary Sidebar','rolopress'),
						"id" => $shortname."_print_primary",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Secondary Sidebar','rolopress'),
						"id" => $shortname."_print_secondary",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Contact-Under Main','rolopress'),
						"id" => $shortname."_print_contact_under_main",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Company-Under Main','rolopress'),
						"id" => $shortname."_print_company_under_main",
						"std" => "false",
						"type" => "checkbox"),
						
);

		
		
// Display options page
function rolo_print_options_add () {

    global $themename, $shortname, $print_options;


    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($print_options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($print_options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: options-general.php?page=menu-settings-print.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($print_options as $value) {
                delete_option( $value['id'] ); }

            header("Location: options-general.php?page=menu-settings-print.php&reset=true");
            die;

        }
    }


}

function rolo_print_options() {

    global $themename, $shortname, $print_options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.','rolopress').'</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.','rolopress').'</strong></p></div>';
    
    
?>

<div class="wrap">
	<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
	<h2><?php _e('Print Options', 'rolopress'); ?> </h2>
		<form method="post" action="">
		
		<div style="float: right; margin-bottom:10px; padding:0; " id="top-update" class="submit"></div>

				<table style="margin-bottom: 20px;"></table>
				<table class="widefat fixed">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Print these Widget Areas', 'rolopress'); ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>

<?php foreach ($print_options as $value) {

// Set styles for different option types


// Basic text	
	switch ( $value['type'] ) {
		case 'text':
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'rolopress'); ?></label></th>
			<td>
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
				<?php echo __($value['desc'],'rolopress'); ?>

			</td>
		</tr>
		<?php
		break;

// Select box
		case 'select':
		?>
		<tr valign="top">
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'rolopress'); ?></label></th>
				<td>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php foreach ($value['options'] as $option) { ?>
					<option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
		break;

// Text Area
		case 'textarea':
		$ta_options = $value['options'];
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'rolopress'); ?></label></th>
			<td><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_option($value['id']) != "") {
						echo __(stripslashes(get_option($value['id'])),'rolopress');
					}else{
						echo __($value['std'],'rolopress');
				}?></textarea><br /><?php echo __($value['desc'],'rolopress'); ?></td>
		</tr>
		<?php
		break;

// Radio button
		case 'radio':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'rolopress'); ?></th>
			<td>
				<?php foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_option($value['id']);
				if($radio_setting != ''){
					if ($key == get_option($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><br />
				<?php } ?>
			</td>
		</tr>
		<?php
		break;

// Checkbox
		case 'checkbox':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'rolopress'); ?></th>
			<td>
				<?php
					if(get_option($value['id'])){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				?>
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<label for="<?php echo $value['id']; ?>"><?php echo __($value['desc'],'rolopress'); ?></label>
			</td>
		</tr>
		<?php
		break;

		default:

		break;
	}
}
?>

	</table>

	

	<p class="submit">
		<input name="save" type="submit" value="<?php _e('Save changes','rolopress'); ?>" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>
<form method="post" action="">
	<p class="submit">
		<input name="reset" type="submit" value="<?php _e('Reset to default','rolopress'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

</div>
<?php
}


add_action('admin_menu' , 'rolo_print_options_add'); 


?>