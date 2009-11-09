<?php
/**
 * Contact Details Widget
 *
 * Displays contact details
 *
 * Many thanks to Justin Tadlock: http://www.themehybrid.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Contact_Details extends WP_Widget {


	function Rolo_Widget_Contact_Details() {
		$widget_ops = array( 'classname' => 'contact-details', 'description' => __('Displays all details for your contact.', 'rolopress') );
		$control_ops = array( 'width' => 230, 'height' => 350, 'id_base' => 'rolopress-contact-details' );
		$this->WP_Widget( 'rolopress-contact-details', __('Contact Details', 'rolopress'), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
	if (is_single() && (rolo_type_is ('contact'))) { // only display when viewing contact page
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		
		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;
			echo "\n\t\t\t" . '<ul id="hcard-<?php echo basename(get_permalink());?>" class="vcard">';
					if ( rolo_type_is( 'contact' ) ) rolo_contact_details(get_the_ID());
			echo "\n\t\t\t" . '</ul><!-- .vcard -->';

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
		$defaults = array( 'title' => __('Contact Details', 'rolopress'), 'initial' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}

?>