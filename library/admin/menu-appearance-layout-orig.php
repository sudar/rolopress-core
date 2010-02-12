<?php
/**
 * Menu: Appearance - Layout
 *
 * @package RoloPress
 * @subpackage Functions
 */

// Theme options adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/


// Create options

$layout_options = array (

						
				array(  "name" => "Layout Options",
						"desc" => "Set Content and Sidebar Postions",
						"id" => $shortname."_layout_setting",
						"type" => "radio",
						"std" => "3c-b-rw",
						"options" => array(
							"1c-b" => "1 Column",
							"2c-l" => "2 Columns - Sidebars on left",
							"2c-r" => "2 Columns - Sidebars on right",
							"2c-l-w" => "2 Columns - <strong>Wide</strong> sidebar on left",
							"2c-r-w" => "2 Columns - <strong>Wide</strong> sidebar on right",
							"3c-l" => "3 Columns - Two sidebars on left",
							"3c-r" => "3 Columns - Two sidebars on right",
							"3c-b" => "3 Columns - 1 sidebar on left / 1 sidebar on right",
							"3c-l-w" => "3 Columns - Two <strong>Wide</strong> sidebars on left",
							"3c-r-w" => "3 Columns - Two <strong>Wide</strong> sidebars on right",
							"3c-b-w" => "3 Columns - 1 <strong>Wide</strong> sidebar on left / 1 <strong>Wide</strong> sidebar on right",
							"3c-b-lw" => "3 Columns - 1 <strong>Wide</strong> sidebar on left / 1 sidebar on right",
							"3c-b-rw" => "3 Columns - 1 sidebar on left / 1 <strong>Wide</strong> sidebar on right",

						),
				),
);

		
		
// Display options page
function rolo_menu_layout_add () {

    global $themename, $shortname, $layout_options;


    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($layout_options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($layout_options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=menu-appearance-layout.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($layout_options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=menu-appearance-layout.php&reset=true");
            die;

        } else if ( 'reset_widgets' == $_REQUEST['action'] ) {
            $null = null;
            update_option('sidebars_widgets',$null);
            header("Location: themes.php?page=menu-appearance-layout.php&reset=true");
            die;
        }
    }


}

function rolo_menu_layout() {

    global $themename, $shortname, $layout_options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.','rolopress').'</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.','rolopress').'</strong></p></div>';
    if ( $_REQUEST['reset_widgets'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('widgets reset.','rolopress').'</strong></p></div>';
    
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php _e('Layout', 'rolopress');?></h2>

<form method="post" action="">

	<table class="form-table">

<?php foreach ($layout_options as $value) {

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
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><img src="<?php echo ROLOPRESS_IMAGES.'/admin/'.$key.'.gif'?>" /><br />
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
		<input name="reset" type="submit" value="<?php _e('Reset','rolopress'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

</div>
<?php
}

add_action('admin_menu' , 'rolo_menu_layout_add'); 


?>
