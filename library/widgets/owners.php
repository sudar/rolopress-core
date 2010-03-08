<?php
/**
 * Owners Widget
 *
 * Displays a list of item owners.
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */
 
class Rolo_Widget_Owners extends WP_Widget {

	function Rolo_Widget_Owners() {
		$widget_ops = array( 'classname' => 'owners', 'description' => __('An advanced widget that gives you total control over the output of your item owner lists.','rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-owners' );
		$this->WP_Widget( 'rolopress-owners', __('Owners', 'rolopress'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Owners', 'rolopress') : $instance['title']);
		$style = $instance['style'];
		$feed = $instance['feed']; 
		$feed_image = $instance['feed_image'];

		$optioncount = isset( $instance['optioncount'] ) ? $instance['optioncount'] : false;
		$exclude_admin = isset( $instance['exclude_admin'] ) ? $instance['exclude_admin'] : false;
		$show_fullname = isset( $instance['show_fullname'] ) ? $instance['show_fullname'] : false;
		$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : false;
		$html = isset( $instance['html'] ) ? $instance['html'] : false;

		$owners = array(
			'optioncount' => $optioncount,
			'exclude_admin' => $exclude_admin,
			'show_fullname' => $show_fullname,
			'hide_empty' => $hide_empty,
			'feed' => $feed,
			'feed_image' => $feed_image,
			'style' => $style,
			'html' => $html,
			'echo' => 0,
		);

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;

		if ( 'list' == $style && $html )
			echo "\n\t\t\t" . '<ul class="xoxo owners">';

		echo "\n\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_list_authors( $owners ) );

		if ( 'list' == $style && $html )
			echo "\n\t\t\t" . '</ul><!-- .xoxo .owners -->';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feed'] = strip_tags( $new_instance['feed'] );
		$instance['feed_image'] = strip_tags( $new_instance['feed_image'] );
		$instance['style'] = $new_instance['style'];
		$instance['html'] = $new_instance['html'];
		$instance['optioncount'] = $new_instance['optioncount'];
		$instance['exclude_admin'] = $new_instance['exclude_admin'];
		$instance['show_fullname'] = $new_instance['show_fullname'];
		$instance['hide_empty'] = $new_instance['hide_empty'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Owners', 'rolopress'), 'optioncount' => false, 'exclude_admin' => false, 'show_fullname' => true, 'hide_empty' => true, 'style' => 'list', 'html' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays a list of users (owners) that have created items.  Best for multiuser installs where you would want to see what items each user created.', 'rolopress')?>
		</p>
		</div>
		<div style="float:left;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed' ); ?>"><?php _e('Feed:', 'rolopress'); ?> <code>feed</code></label>
			<input id="<?php echo $this->get_field_id( 'feed' ); ?>" name="<?php echo $this->get_field_name( 'feed' ); ?>" value="<?php echo $instance['feed']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed_image' ); ?>"><?php _e('Feed Image:', 'rolopress'); ?> <code>feed_image</code></label>
			<input id="<?php echo $this->get_field_id( 'feed_image' ); ?>" name="<?php echo $this->get_field_name( 'feed_image' ); ?>" value="<?php echo $instance['feed_image']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style:', 'rolopress'); ?> <code>style</code></label> 
			<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'list' == $instance['style'] ) echo 'selected="selected"'; ?>>list</option>
				<option <?php if ( 'none' == $instance['style'] ) echo 'selected="selected"'; ?>>none</option>
			</select>
		</p>
		</div>

		<div style="float:right;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'html' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['html'], true ); ?> id="<?php echo $this->get_field_id( 'html' ); ?>" name="<?php echo $this->get_field_name( 'html'); ?>" /><acronym title="Hypertext Markup Language"><?php echo __(' HTML?','rolopress') . "</acronym>" . "<code>" . __('html','rolopress') . "</code></label>";?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'optioncount' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['optioncount'], true ); ?> id="<?php echo $this->get_field_id( 'optioncount' ); ?>" name="<?php echo $this->get_field_name( 'optioncount' ); ?>" /> <?php _e('Show post count?', 'rolopress'); ?> <code>optioncount</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_admin' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['exclude_admin'], true ); ?> id="<?php echo $this->get_field_id( 'exclude_admin' ); ?>" name="<?php echo $this->get_field_name( 'exclude_admin' ); ?>" /> <?php _e('Exclude admin?', 'rolopress'); ?> <code>exclude_admin</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_fullname' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_fullname'], true ); ?> id="<?php echo $this->get_field_id( 'show_fullname' ); ?>" name="<?php echo $this->get_field_name( 'show_fullname' ); ?>" /> <?php _e('Show full name?', 'rolopress'); ?> <code>show_fullname</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e('Hide empty?', 'rolopress'); ?> <code>hide_empty</code></label>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>