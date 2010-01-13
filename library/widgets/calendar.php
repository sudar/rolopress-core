<?php
/**
 * Calendar Widget
 *
 * Replaces the default WordPress Calendar widget.
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Calendar extends WP_Widget {

	function Rolo_Widget_Calendar() {
		$widget_ops = array( 'classname' => 'calendar', 'description' => __('An advanced widget that gives you total control over the output of your calendar.', 'rolopress') );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'rolopress-calendar' );
		$this->WP_Widget( 'rolopress-calendar', __('Calendar', 'rolopress'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$hide_empty = isset( $instance['initial'] ) ? $instance['initial'] : false;

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;

			echo "\n\t\t\t" . '<div class="calendar-wrap">';
				get_calendar( $initial );
			echo "\n\t\t\t" . '</div><!-- .calendar-wrap -->';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['initial'] = $new_instance['initial'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Calendar', 'rolopress'), 'initial' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'initial' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['initial'], true ); ?> id="<?php echo $this->get_field_id( 'initial' ); ?>" name="<?php echo $this->get_field_name( 'initial' ); ?>" /> <?php _e('One-letter abbreviation?', 'rolopress'); ?> <code>initial</code></label>
		</p>
	<?php
	}
}

?>