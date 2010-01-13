<?php
/**
 * Categories Widget
 *
 * Replaces the default WordPress Categories widget.
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */

class Rolo_Widget_Categories extends WP_Widget {

	function Rolo_Widget_Categories() {
		$widget_ops = array( 'classname' => 'categories', 'description' => __('An advanced widget that gives you total control over the output of your category links.', 'rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-categories' );
		$this->WP_Widget( 'rolopress-categories', __('Categories', 'rolopress'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$style = $instance['style'];
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$exclude = $instance['exclude'];
		$exclude_tree = $instance['exclude_tree'];
		$include = $instance['include'];
		$depth = (int)$instance['depth'];
		$number = (int)$instance['number'];
		$child_of = (int)$instance['child_of'];
		$current_category = (int)$instance['current_category'];
		$feed_image = $instance['feed_image'];

		$hierarchical = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : false;
		$use_desc_for_title = isset( $instance['use_desc_for_title'] ) ? $instance['use_desc_for_title'] : false;
		$show_last_update = isset( $instance['show_last_update'] ) ? $instance['show_last_updated'] : false;
		$show_count = isset( $instance['show_count'] ) ? $instance['show_count'] : false;
		$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : false;
		$feed = isset( $instance['feed'] ) ? $instance['feed'] : false;

		if ( $feed )
			$feed = __('RSS', 'rolopress');

		$categories = array(
			'exclude' => $exclude,
			'exclude_tree' => $exclude_tree,
			'include' => $include,
			'number' => $number,
			'depth' => $depth,
			'orderby' => $orderby,
			'order' => $order,
			'show_last_update' => $show_last_update,
			'style' => $style,
			'show_count' => $show_count,
			'hide_empty' => $hide_empty,
			'use_desc_for_title' => $use_desc_for_title,
			'child_of' => $child_of,
			'feed' => $feed,
			'feed_image' => $feed_image,
			'hierarchical' => $hierarchical,
			'title_li' => false,
			'current_category' => $current_category,
			'echo' => 0,
			'depth' => $depth,
		);

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;

		if ( 'list' == $style )
			echo "\n\t\t\t" . '<ul class="xoxo categories">';

		echo "\n\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_list_categories( $categories ) );

		if ( 'list' == $style )
			echo "\n\t\t\t" . '</ul><!-- .xoxo .categories -->';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['exclude_tree'] = strip_tags( $new_instance['exclude_tree'] );
		$instance['include'] = strip_tags( $new_instance['include'] );
		$instance['depth'] = strip_tags( $new_instance['depth'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['child_of'] = strip_tags( $new_instance['child_of'] );
		$instance['current_category'] = strip_tags( $new_instance['current_category'] );
		$instance['feed_image'] = strip_tags( $new_instance['feed_image'] );
		$instance['style'] = $new_instance['style'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['hierarchical'] = $new_instance['hierarchical'];
		$instance['use_desc_for_title'] = $new_instance['use_desc_for_title'];
		$instance['show_last_update'] = $new_instance['show_last_update'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['hide_empty'] = $new_instance['hide_empty'];
		$instance['feed'] = $new_instance['feed'];

		return $instance;
	}

	function form( $instance ) {

		// Defaults
		$defaults = array( 'title' => __('Categories', 'rolopress'), 'style' => 'list', 'hierarchical' => true, 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style:', 'rolopress'); ?> <code>style</code></label> 
			<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'list' == $instance['style'] ) echo 'selected="selected"'; ?>>list</option>
				<option <?php if ( 'none' == $instance['style'] ) echo 'selected="selected"'; ?>>none</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'rolopress'); ?> <code>order</code></label> 
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>>DESC</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By:', 'rolopress'); ?> <code>orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'ID' == $instance['orderby'] ) echo 'selected="selected"'; ?>>ID</option>
				<option <?php if ( 'count' == $instance['orderby'] ) echo 'selected="selected"'; ?>>count</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'rolopress'); ?> <code>include</code></label>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'rolopress'); ?> <code>exclude</code></label>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_tree' ); ?>"><?php _e('Exclude Tree:', 'rolopress'); ?> <code>exclude_tree</code></label>
			<input id="<?php echo $this->get_field_id( 'exclude_tree' ); ?>" name="<?php echo $this->get_field_name( 'exclude_tree' ); ?>" type="text" value="<?php echo $instance['exclude_tree']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'depth' ); ?>"><?php _e('Depth:', 'rolopress'); ?> <code>depth</code></label>
			<input id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" value="<?php echo $instance['depth']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:right;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number:', 'rolopress'); ?> <code>number</code></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><?php _e('Child Of:', 'rolopress'); ?> <code>child_of</code></label>
			<input id="<?php echo $this->get_field_id( 'child_of' ); ?>" name="<?php echo $this->get_field_name( 'child_of' ); ?>" value="<?php echo $instance['child_of']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'current_category' ); ?>"><?php _e('Current Category:', 'rolopress'); ?> <code>current_category</code></label>
			<input id="<?php echo $this->get_field_id( 'current_category' ); ?>" name="<?php echo $this->get_field_name( 'current_category' ); ?>" value="<?php echo $instance['current_category']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed_image' ); ?>"><?php _e('Feed Image:', 'rolopress'); ?> <code>feed_image</code></label>
			<input id="<?php echo $this->get_field_id( 'feed_image' ); ?>" name="<?php echo $this->get_field_name( 'feed_image' ); ?>" value="<?php echo $instance['feed_image']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hierarchical'], true ); ?> id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" /> <?php _e('Hierarchical?', 'rolopress'); ?> <code>hierarchical</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'use_desc_for_title' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['use_desc_for_title'], true ); ?> id="<?php echo $this->get_field_id( 'use_desc_for_title' ); ?>" name="<?php echo $this->get_field_name( 'use_desc_for_title' ); ?>" /> <?php _e('Use description for title?', 'rolopress'); ?> <code>use_desc_for_title</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_last_update' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_last_update'], true ); ?> id="<?php echo $this->get_field_id( 'show_last_update' ); ?>" name="<?php echo $this->get_field_name( 'show_last_update' ); ?>" /> <?php _e('Show last update?', 'rolopress'); ?> <code>show_last_update</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_count'], true ); ?> id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" /> <?php _e('Show count?', 'rolopress'); ?> <code>show_count</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e('Hide empty?', 'rolopress'); ?> <code>hide_empty</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['feed'], true ); ?> id="<?php echo $this->get_field_id( 'feed' ); ?>" name="<?php echo $this->get_field_name( 'feed' ); ?>" /> <?php _e('Show RSS feed?', 'rolopress'); ?> <code>feed</code></label>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>