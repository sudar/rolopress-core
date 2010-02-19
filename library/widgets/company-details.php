<?php
/**
 * Company Details Widget
 *
 * Displays company details
 *
 * Many thanks to Justin Tadlock: http://www.themehybrid.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Company_Details extends WP_Widget {


	function Rolo_Widget_Company_Details() {
		$widget_ops = array( 'classname' => 'company-details', 'description' => __('Displays all details for your company.', 'rolopress') );
		$control_ops = array( 'width' => 230, 'height' => 350, 'id_base' => 'rolopress-company-details' );
		$this->WP_Widget( 'rolopress-company-details', __('Company Details', 'rolopress'), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
		if (is_single() && (rolo_type_is ('company'))) { // only display when viewing company page
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Company Details', 'rolopress') : $instance['title']);
		echo $before_widget;
		
		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;
				if ( rolo_type_is( 'company' ) ) rolo_company_details(get_the_ID());
			echo $after_widget;
	} 
}
	
			


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Company Details', 'rolopress'), 'initial' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays the details for an individual Company. A good place to place this widget is the Primary or Secondary sidebars, or Company:Under Main.', 'rolopress')?><br/><em>
		<?php _e('This is a Smart Widget, which means it only displays when it is supposed to: when you view an individual company page.', 'rolopress')?></em></p>
		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}

?>