<?php
/**
 * Pages Widget
 *
 * Replaces the default WordPress Pages widget.
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */
 


class Rolo_Widget_Pages extends WP_Widget {

	function Rolo_Widget_Pages() {
		$widget_ops = array( 'classname' => 'pages', 'description' => __('An advanced widget that gives you total control over the output of your page links.', 'rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-pages' );
		$this->WP_Widget( 'rolopress-pages', __('Pages', 'rolopress'), $widget_ops, $control_ops );
	}
	
	

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Pages', 'rolopress') : $instance['title']);
		$sort_column = $instance['sort_column'];
		$sort_order = $instance['sort_order'];
		$exclude = $instance['exclude'];
		$include = $instance['include'];
		$depth = (int)$instance['depth'];
		$child_of = $instance['child_of'];
		$meta_key = $instance['meta_key'];
		$meta_value = $instance['meta_value'];
		$authors = $instance['authors'];
		$exclude_tree = $instance['exclude_tree'];
		$link_before = $instance['link_before'];
		$link_after = $instance['link_after'];
		$date_format = $instance['date_format'];
		$show_date = $instance['show_date'];

		$hierarchical = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : false;
		$show_home = isset( $instance['show_home'] ) ? $instance['show_home'] : false;

		if ( !$date_format )
			$date_format = get_option( 'date_format' );
			

		// Remove the "Edit Company" and "Edit Contact" pages from the widget because they cannot be accessed directly.
		$edit_company_page =rolo_get_ID_by_page_title('Edit Company');
		$edit_contact_page =rolo_get_ID_by_page_title('Edit Contact');

		$pages = array(
			'depth' => $depth,
			'sort_column' => $sort_column,
			'sort_order' => $sort_order,
			'show_date' => $show_date,
			'date_format' => $date_format,
			'child_of' => $child_of,
			'exclude' => $exclude . "," . $edit_company_page . "," . $edit_contact_page,
			'include' => $include,
			'hierarchical' => $hierarchical,
			'meta_key' => $meta_key,
			'meta_value' => $meta_value,
			'authors' => $authors,
			'exclude_tree' => $exclude_tree,
			'link_before' => $link_before,
			'link_after' => $link_after,
			'title_li' => '',
			'echo' => 0,
		);

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;

		echo "\n\t\t\t" . '<ul class="xoxo pages">';

		if ( $show_home ) :
			echo "\n\t\t\t\t" . '<li class="page_item';
			if ( is_home() ) echo ' current_page_item';
			echo '"><a href="' . get_bloginfo( 'url' ) . '" title="' . get_bloginfo( 'name' ) . '">' . $link_before . __('Home', 'rolopress') . $link_after . '</a></li>';
		endif;

		echo "\n\t\t\t\t" . str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $pages ) );

		echo "\n\t\t\t" . '</ul><!-- .xoxo .pages -->' . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['depth'] = strip_tags( $new_instance['depth'] );
		$instance['child_of'] = strip_tags( $new_instance['child_of'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['include'] = strip_tags( $new_instance['include'] );
		$instance['meta_key'] = strip_tags( $new_instance['meta_key'] );
		$instance['meta_value'] = strip_tags( $new_instance['meta_value'] );
		$instance['authors'] = strip_tags( $new_instance['authors'] );
		$instance['show_home'] = strip_tags( $new_instance['show_home'] );
		$instance['exclude_tree'] = strip_tags( $new_instance['exclude_tree'] );
		$instance['date_format'] = strip_tags( $new_instance['date_format'] );
		$instance['sort_column'] = $new_instance['sort_column'];
		$instance['sort_order'] = $new_instance['sort_order'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['hierarchical'] = $new_instance['hierarchical'];
		$instance['link_before'] = $new_instance['link_before'];
		$instance['link_after'] = $new_instance['link_after'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Pages', 'rolopress'), 'hierarchical' => true, 'sort_column' => 'post_title', 'sort_order' => 'ASC', 'date_format' => get_option( 'date_format' ) );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays Pages with appropriate RoloPress options.', 'rolopress'); ?>
		</p>
		</div>
		<div style="float:left;width:31%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'sort_column' ); ?>"><?php _e('Order By:','rolopress'); ?> <code>sort_column</code></label>
			<select id="<?php echo $this->get_field_id( 'sort_column' ); ?>" name="<?php echo $this->get_field_name( 'sort_column' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'post_title' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>post_title</option>
				<option <?php if ( 'menu_order' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>menu_order</option>
				<option <?php if ( 'post_date' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>post_date</option>
				<option <?php if ( 'post_modified' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>post_modified</option>
				<option <?php if ( 'ID' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>ID</option>
				<option <?php if ( 'post_author' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>post_author</option>
				<option <?php if ( 'post_name' == $instance['sort_column'] ) echo 'selected="selected"'; ?>>post_name</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'sort_order' ); ?>"><?php _e('Sort Order:', 'rolopress'); ?> <code>sort_order</code></label>
			<select id="<?php echo $this->get_field_id( 'sort_order' ); ?>" name="<?php echo $this->get_field_name( 'sort_order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['sort_order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['sort_order'] ) echo 'selected="selected"'; ?>>DESC</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'depth' ); ?>"><?php _e('Depth:', 'rolopress'); ?> <code>depth</code></label>
			<input id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" type="text" value="<?php echo $instance['depth']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'rolopress'); ?> <code>exclude</code></label>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" type="text" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
			<small>
			<?php _e('"Edit Contact" and "Edit Company" pages are automatically excluded, since they should not be accessed directly.', 'rolopress')?>
			</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_tree' ); ?>"><?php _e('Exclude Tree:', 'rolopress'); ?> <code>exclude_tree</code></label>
			<input id="<?php echo $this->get_field_id( 'exclude_tree' ); ?>" name="<?php echo $this->get_field_name( 'exclude_tree' ); ?>" type="text" value="<?php echo $instance['exclude_tree']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:left;width:31%;margin-left:3.5%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'rolopress'); ?> <code>include</code></label>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" type="text" value="<?php echo $instance['include']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><?php _e('Child Of:', 'rolopress'); ?> <code>child_of</code></label>
			<input id="<?php echo $this->get_field_id( 'child_of' ); ?>" name="<?php echo $this->get_field_name( 'child_of' ); ?>" type="text" value="<?php echo $instance['child_of']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'authors' ); ?>"><?php _e('Authors:', 'rolopress'); ?> <code>authors</code></label>
			<input id="<?php echo $this->get_field_id( 'authors' ); ?>" name="<?php echo $this->get_field_name( 'authors' ); ?>" type="text" value="<?php echo $instance['authors']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'meta_key' ); ?>"><?php _e('Meta Key:', 'rolopress'); ?> <code>meta_key</code></label>
			<input id="<?php echo $this->get_field_id( 'meta_key' ); ?>" name="<?php echo $this->get_field_name( 'meta_key' ); ?>" type="text" value="<?php echo $instance['meta_key']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'meta_value' ); ?>"><?php _e('Meta Value:', 'rolopress'); ?> <code>meta_value</code></label>
			<input id="<?php echo $this->get_field_id( 'meta_value' ); ?>" name="<?php echo $this->get_field_name( 'meta_value' ); ?>" type="text" value="<?php echo $instance['meta_value']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:right;width:31%;margin-left:3.5%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'link_before' ); ?>"><?php _e('Before Link:', 'rolopress'); ?> <code>link_before</code></label>
			<input id="<?php echo $this->get_field_id( 'link_before' ); ?>" name="<?php echo $this->get_field_name( 'link_before' ); ?>" type="text" value="<?php echo $instance['link_before']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_after' ); ?>"><?php _e('After Link:', 'rolopress'); ?> <code>link_after</code></label>
			<input id="<?php echo $this->get_field_id( 'link_after' ); ?>" name="<?php echo $this->get_field_name( 'link_after' ); ?>" type="text" value="<?php echo $instance['link_after']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e('Show date?:', 'rolopress'); ?> <code>show_date</code></label>
			<select id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( '' == $instance['show_date'] ) echo 'selected="selected"'; ?>></option>
				<option <?php if ( 'created' == $instance['show_date'] ) echo 'selected="selected"'; ?>>created</option>
				<option <?php if ( 'modified' == $instance['show_date'] ) echo 'selected="selected"'; ?>>modified</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'date_format' ); ?>"><?php _e('Date Format:', 'rolopress'); ?> <code>date_format</code></label>
			<input id="<?php echo $this->get_field_id( 'date_format' ); ?>" name="<?php echo $this->get_field_name( 'date_format' ); ?>" type="text" value="<?php echo $instance['date_format']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hierarchical'], true ); ?> id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" /> <?php _e('Hierarchical?', 'rolopress'); ?> <code>hierarchical</code></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_home'], true ); ?> id="<?php echo $this->get_field_id( 'show_home' ); ?>" name="<?php echo $this->get_field_name( 'show_home' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_home' ); ?>"><?php _e('Show home?', 'rolopress'); ?> <code>show_home</code></label>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>