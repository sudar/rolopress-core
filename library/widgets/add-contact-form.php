<?php
/**
 * Add Contact Form Widget
 *
 * Displays add contact form
 *
 * Many thanks to Justin Tadlock: http://www.themehybrid.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Add_Contact extends WP_Widget {


	function Rolo_Widget_Add_Contact() {
		$widget_ops = array( 'classname' => 'add-contact', 'description' => __('Displays Add Contact Form', 'rolopress') );
		$control_ops = array( 'width' => 230, 'height' => 350, 'id_base' => 'rolopress-add-contact' );
		$this->WP_Widget( 'rolopress-add-contact', __('Add Contact Form', 'rolopress'), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
	if ( current_user_can('publish_posts') ) { // only display if user has proper permissions
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Add Contact', 'rolopress') : $instance['title']);
		echo $before_widget;
		
		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;
			echo "\n\t\t\t\t" . '<ul class="xoxo add-contact-form form">';
					 rolo_add_contact();
			echo "\n\t\t\t\t" . '</ul><!-- .xoxo .add-contact-form -->';

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
		$defaults = array( 'title' => __('Add Contact Form', 'rolopress'), 'initial' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays the Add Contact Form.  Great for a sidebar or a Widgets page.', 'rolopress'); ?>
		</p>
		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}

?>