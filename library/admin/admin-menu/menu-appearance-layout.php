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
						
    array("name" => __('Layout Options','rolopress'),
          "desc" => "Set Content and Sidebar Postions",
          "id" => $shortname."_layout_setting",
          "type" => "radio",
          "std" => "3c-b-rw",
          "options" => array (
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
          ),
    ),
);

$default_menu_options = array (
    array("name" => __('Show Contact items','rolopress'),
        "id" => $shortname."_show_contact_items",
        "std" => "true",
        "type" => "checkbox"),

    array("name" => __('Show Company items','rolopress'),
        "id" => $shortname."_show_company_items",
        "std" => "true",
        "type" => "checkbox"),
);

/**
 * Display options page
 *
 * @global <type> $themename
 * @global <type> $shortname
 * @global <type> $layout_options
 */
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

/**
 *
 * @global <type> $themename
 * @global <type> $shortname
 * @global <type> $layout_options
 */
function rolo_menu_layout() {

    global $themename, $shortname, $layout_options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><em>'.$themename.' '.__('settings saved.','rolopress').'</em></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><em>'.$themename.' '.__('settings reset.','rolopress').'</em></p></div>';
    if ( $_REQUEST['reset_widgets'] ) echo '<div id="message" class="updated fade"><p><em>'.$themename.' '.__('widgets reset.','rolopress').'</em></p></div>';
    
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php _e('Layout', 'rolopress');?></h2>

<form method="post" action="">

<p class="submit">
	<input name="save" type="submit" value="<?php _e('Save changes','rolopress'); ?>" />    
	<input type="hidden" name="action" value="save" />
</p>

<?php foreach ($layout_options as $value) {
// Form Layout
?>
<div id="<?php echo $value['id']; ?>_form">
<?php
    // Radio button
	switch ( $value['type'] ) {
		case 'radio':
            foreach ($value['options'] as $key=>$option) {
				$radio_setting = get_option($value['id']);
				if ($radio_setting != ''){
					if ($key == get_option($value['id'])) {
						$checked = "checked=\"checked\"";
					} else {
							$checked = "";
					}
				} else {
					if ($key == $value['std']) {
						$checked = "checked=\"checked\"";
					} else {
						$checked = "";
					}
				}
?>
				<div class="<?php echo $value['id']; ?>_column">
                    <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><br/>
                    <img src="<?php echo ROLOPRESS_IMAGES.'/admin/'. $key .'.gif'?>" /><br/>
                    <label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label>
				</div>
<?php
            }
		break;
	}
}
?>
</div>
<!-- <?php echo $value['id']; ?>_form -->
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
<?php
}
add_action('admin_menu' , 'rolo_menu_layout_add'); 

?>