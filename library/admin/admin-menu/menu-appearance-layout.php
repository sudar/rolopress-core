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

						
				array(	"name" => __('Layout Options','rolopress'),
						"desc" => "Set Content and Sidebar Postions",
						"id" => $shortname."_layout_setting",
						"type" => "radio",
						"std" => "3c-b-rw",
						"options" => array(
							"1c-b" => __('<strong>1 Column</strong><br/>Primary on left<br/>Secondary on right','rolopress'),
							"2c-l" => __('<strong>2 Columns</strong><br/>Primary on top left<br/>Secondary on Bottom left','rolopress'),
							"2c-r" => __('<strong>2 Columns</strong><br/>Primary on top right<br/>Secondary on Bottom right','rolopress'),
							"2c-l-w" => __('<strong>2 Columns</strong><br/><em>Wide</em> Primary on top left<br/><em>Wide</em> Secondary on Bottom left','rolopress'),
							"2c-r-w" => __('<strong>2 Columns</strong><br/><em>Wide</em> Primary on top right<br/><em>Wide</em> Secondary on Bottom right','rolopress'),
							"3c-l" => __('<strong>3 Columns</strong><br/>Primary on left<br/>Secondary on left','rolopress'),
							"3c-r" => __('<strong>3 Columns</strong><br/>Primary on right<br/>Secondary on right','rolopress'),
							"3c-b" => __('<strong>3 Columns</strong><br/>Primary on left<br/>Secondary on right','rolopress'),
							"3c-l-w" => __('<strong>3 Columns</strong><br/><em>Wide</em> Primary on left<br/><em>Wide</em> Secondary on left','rolopress'),
							"3c-r-w" => __('<strong>3 Columns</strong><br/><em>Wide</em> Primary on right<br/><em>Wide</em> Secondary on right','rolopress'),
							"3c-b-w" => __('<strong>3 Columns</strong><br/><em>Wide</em> Primary on left<br/><em>Wide</em> Secondary on right','rolopress'),
							"3c-b-lw" => __('<strong>3 Columns</strong><br/>1 <em>Wide</em> sidebar on left<br/>1 sidebar on right','rolopress'),
							"3c-b-rw" => __('<strong>3 Columns</strong><br/>1 sidebar on left<br/>1 <em>Wide</em> sidebar on right','rolopress'),

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
		?>

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
				<div class="<?php echo $value['id']; ?>_column">
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><br/>
				<img src="<?php echo ROLOPRESS_IMAGES.'/admin/'. $key .'.gif'?>" /><br/>
				<label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label>
				</div>
				<?php } ?>

		<?php
		break;

	}
}
?>

</div><!-- <?php echo $value['id']; ?>_form -->


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

add_action('admin_menu' , 'rolo_menu_layout_add'); 


?>
