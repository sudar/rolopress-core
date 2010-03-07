<?php
/**
 * Recent Items Widget
 *
 * Lists all your recently created Items
 *
 * Many thanks to Justin Tadlock: http://www.themehybrid.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Recent_Items extends WP_Widget {

	function Rolo_Widget_Recent_Items() {
		$widget_ops = array( 'classname' => 'recent-items', 'description' => __('An advanced widget that gives you total control over the output of your recently created items.', 'rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-recent-items' );
		$this->WP_Widget( 'rolopress-recent-items', __('Recent Items', 'rolopress'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Items', 'rolopress') : $instance['title']);
//		$type = $instance['type'];
		$format = $instance['format'];
		$before = $instance['before'];
		$after = $instance['after'];
		$limit = (int)$instance['limit'];

		$show_post_count = isset( $instance['show_post_count'] ) ? $instance['show_post_count'] : false;

		if ( !$limit )
			$limit = '';

		$recent_items = array(
			'type' => 'postbypost',
			'limit' => $limit,
			'format' => $format,
			'before' => $before,
			'after' => $after,
			'show_post_count' => $show_post_count,
			'echo' => 0,
		);

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t\t" . $before_title . $title . $after_title;

		if ( $format == 'option' ) :

			if ( $type == 'yearly' ) :
				$option_title = __('Select Year','rolopress');
			elseif ( $type == 'monthly' ) :
				$option_title = __('Select Month','rolopress');
			elseif ( $type == 'weekly' ) :
				$option_title = __('Select Week','rolopress');
			elseif ( $type == 'daily' ) :
				$option_title = __('Select Day','rolopress');
			elseif ( $type == 'postbypost' ) :
				$option_title = __('Select Post','rolopress');
			endif;

			echo "\n\t\t\t\t" . '<select name="recent-item-dropdown" onchange=\'document.location.href=this.options[this.selectedIndex].value;\'>';

			echo '<option value="">' . esc_attr( $option_title ) . '</option>';

			echo "\n\t\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_get_archives( $recent_items ) );

			echo "\n\t\t\t\t" . '</select>';

		elseif ( $format == 'html' ) :

			echo "\n\t\t\t\t" . '<ul class="xoxo recent-items">';
			echo "\n\t\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_get_archives( $recent_items ) );
			echo "\n\t\t\t\t" . '</ul><!-- .xoxo .recent-items -->';

		else :

			echo "\n\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_get_archives( $recent_items ) );

		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['before'] = strip_tags( $new_instance['before'] );
		$instance['after'] = strip_tags( $new_instance['after'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
//		$instance['type'] = $new_instance['type'];
		$instance['format'] = $new_instance['format'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Recent Items', 'rolopress'), 'limit' => '', 'type' => 'postbypost', 'format' => 'html', 'before' => '', 'after' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays your recently created items.', 'rolopress')?>
		</p>
		</div>
		<div style="float:left;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Limit:', 'rolopress'); ?> <code>limit</code></label>
			<input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'format' ); ?>"><?php _e('Format:','rolopress'); ?> <code>format</code></label> 
			<select id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'html' == $instance['format'] ) echo 'selected="selected"'; ?>>html</option>
				<option <?php if ( 'option' == $instance['format'] ) echo 'selected="selected"'; ?>>option</option>
				<option <?php if ( 'custom' == $instance['format'] ) echo 'selected="selected"'; ?>>custom</option>
			</select>
		</p>
		</div>

		<div style="float:right;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'before' ); ?>"><?php _e('Before:', 'rolopress'); ?> <code>before</code></label>
			<input id="<?php echo $this->get_field_id( 'before' ); ?>" name="<?php echo $this->get_field_name( 'before' ); ?>" value="<?php echo $instance['before']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'after' ); ?>"><?php _e('After:', 'rolopress'); ?> <code>after</code></label>
			<input id="<?php echo $this->get_field_id( 'after' ); ?>" name="<?php echo $this->get_field_name( 'after' ); ?>" value="<?php echo $instance['after']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_post_count' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_post_count'], true ); ?> id="<?php echo $this->get_field_id( 'show_post_count' ); ?>" name="<?php echo $this->get_field_name( 'show_post_count' ); ?>" /> <?php _e('Show post count?', 'rolopress'); ?> <code>show_post_count</code></label>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>