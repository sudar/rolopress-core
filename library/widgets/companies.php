<?php
/**
 * Company List Widget
 *
 * Lists Companies as tagcloud or list
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

/**
 * Output of the tags widget.
 * Each setting is an argument for wp_tag_cloud()
 * @link http://codex.wordpress.org/Template_Tags/wp_tag_cloud
 *
 * @since 0.6
 */
class Rolo_Widget_Companies extends WP_Widget {

	function Rolo_Widget_Companies() {
		$widget_ops = array( 'classname' => 'companies', 'description' => __('An advanced widget to create a Company list or cloud.','rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-companies' );
		$this->WP_Widget( 'rolopress-companies', __('Companies', 'rolopress'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

//		$title = apply_filters( 'widget_title', $instance['title'] );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Companies', 'rolopress') : $instance['title']);
//		$taxonomy = $instance['taxonomy'];
		$format = $instance['format'];
		$order = $instance['order'];
		$orderby = $instance['orderby'];
		$unit = $instance['unit'];
		$largest = (int)$instance['largest'];
		$smallest = (int)$instance['smallest'];
		$number = (int)$instance['number'];
		$exclude = $instance['exclude'];
		$include = $instance['include'];
		$link = $instance['link'];

		if ( !$largest )
			$largest = 22;
		if ( !$smallest )
			$smallest = 8;

		$tags = array(
			'taxonomy' => 'company',
			'smallest' => $smallest,
			'largest' => $largest,
			'unit' => $unit,
			'number' => $number,
			'format' => $format,
			'orderby' => $orderby,
			'order' => $order,
			'exclude' => $exclude,
			'include' => $include,
			'link' => $link,
			'echo' => 0,
		);

		echo "\n\t\t\t" . $before_widget;

		if ( $title )
			echo "\n\t\t\t\t" . $before_title . $title . $after_title;

		if ( $format == 'flat' ) :
			echo "\n\t\t\t\t" . '<p class="company-cloud">';
			echo "\n\t\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), ' ', wp_tag_cloud( $tags ) );
			echo "\n\t\t\t\t" . '</p><!-- .company-cloud -->';
		else :
			echo "\n\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_tag_cloud( $tags ) );
		endif;

		echo "\n\t\t\t" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['smallest'] = strip_tags( $new_instance['smallest'] );
		$instance['largest'] = strip_tags( $new_instance['largest'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['include'] = strip_tags( $new_instance['include'] );
		$instance['unit'] = $new_instance['unit'];
		$instance['format'] = $new_instance['format'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
//		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['link'] = $new_instance['link'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Companies', 'rolopress'), 'format' => 'list', 'unit' => 'px', 'smallest' => 12, 'largest' => 12, 'link' => 'view', 'number' => 45, 'taxonomy' => 'company'  );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays your Companies as a list by default.  But can also be used to create a Company Cloud. To display a cloud change the "Format" to "Flat", and change the smallest and largest font sizes.', 'rolopress'); ?>
		</p>
		</div>
		<div style="float:left;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'format' ); ?>"><?php _e('Format:', 'rolopress'); ?> <code>format</code></label> 
			<select id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'flat' == $instance['format'] ) echo 'selected="selected"'; ?>>flat</option>
				<option <?php if ( 'list' == $instance['format'] ) echo 'selected="selected"'; ?>>list</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'rolopress'); ?> <code>order</code></label> 
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>>DESC</option>
				<option <?php if ( 'RAND' == $instance['order'] ) echo 'selected="selected"'; ?>>RAND</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By:', 'rolopress'); ?> <code>orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'count' == $instance['orderby'] ) echo 'selected="selected"'; ?>>count</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number:', 'rolopress'); ?> <code>number</code></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:right;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'largest' ); ?>"><?php _e('Largest:', 'rolopress'); ?> <code>largest</code></label>
			<input id="<?php echo $this->get_field_id( 'largest' ); ?>" name="<?php echo $this->get_field_name( 'largest' ); ?>" value="<?php echo $instance['largest']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'smallest' ); ?>"><?php _e('Smallest:', 'rolopress'); ?> <code>smallest</code></label>
			<input id="<?php echo $this->get_field_id( 'smallest' ); ?>" name="<?php echo $this->get_field_name( 'smallest' ); ?>" value="<?php echo $instance['smallest']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'unit' ); ?>"><?php _e('Unit:', 'rolopress'); ?> <code>unit</code></label> 
			<select id="<?php echo $this->get_field_id( 'unit' ); ?>" name="<?php echo $this->get_field_name( 'unit' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'pt' == $instance['unit'] ) echo 'selected="selected"'; ?>>pt</option>
				<option <?php if ( 'px' == $instance['unit'] ) echo 'selected="selected"'; ?>>px</option>
				<option <?php if ( 'em' == $instance['unit'] ) echo 'selected="selected"'; ?>>em</option>
				<option <?php if ( '%' == $instance['unit'] ) echo 'selected="selected"'; ?>>%</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'rolopress'); ?> <code>exclude</code></label>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'rolopress'); ?> <code>include</code></label>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link:', 'rolopress'); ?> <code>link</code></label> 
			<select id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'view' == $instance['link'] ) echo 'selected="selected"'; ?>>view</option>
				<option <?php if ( 'edit' == $instance['link'] ) echo 'selected="selected"'; ?>>edit</option>
			</select>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>