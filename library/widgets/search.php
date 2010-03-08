<?php
/**
 * Search Widget
 *
 * Replaces the default WordPress Search widget.
 *
 * Many thanks to Justin Tadlock: http://www.themerolopress.com
 *
 * @package RoloPress
 * @subpackage Widgets
 */
 
class Rolo_Widget_Search extends WP_Widget {

	function Rolo_Widget_Search() {
		$widget_ops = array( 'classname' => 'search', 'description' => __('An advanced widget that gives you total control over the output of your search form.', 'rolopress') );
		$control_ops = array( 'width' => 500, 'height' => 350, 'id_base' => 'rolopress-search' );
		$this->WP_Widget( 'rolopress-search', __('Search', 'rolopress'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$search_label = $instance['search_label'];
		$search_text = $instance['search_text'];
		$search_submit = $instance['search_submit'];
		$theme_search = isset( $instance['theme_search'] ) ? $instance['theme_search'] : false;

		echo $before_widget;

		if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;

		if ( $theme_search ) :

			get_search_form();

		else :
			global $search_form_num;

			if ( !$search_form_num ) :
				$search_num = false;
			else :
				$search_num = '-' . $search_form_num;
			endif;

			if ( is_search() )
				$search_text = esc_attr( get_search_query() );

			$search = "\n\t\t\t" . '<form method="get" class="search-form" id="search-form' . $search_num . '" action="' . get_bloginfo("home") . '/">';
			$search .= '<div>';
			if ( $search_label )
				$search .= '<label for="search-text' . $search_num . '">' . $search_label . '</label>';
			$search .= '<input class="search-text" type="text" name="s" id="search-text' . $search_num . '" value="' . $search_text . '" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;" />';
			if ( $search_submit )
				$search .= '<input class="search-submit button" name="submit" type="submit" id="search-submit' . $search_num . '" value="' . $search_submit . '" />';
			$search .= '</div>';
			$search .= '</form><!-- .search-form -->';

			echo $search;

			$search_form_num++;

		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['search_label'] = strip_tags( $new_instance['search_label'] );
		$instance['search_text'] = strip_tags( $new_instance['search_text'] );
		$instance['search_submit'] = strip_tags( $new_instance['search_submit'] );
		$instance['theme_search'] = $new_instance['theme_search'];

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Search', 'rolopress'), 'theme_search' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'search_label' ); ?>"><?php _e('Search Label:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'search_label' ); ?>" name="<?php echo $this->get_field_name( 'search_label' ); ?>" value="<?php echo $instance['search_label']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'search_text' ); ?>"><?php _e('Search Text:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'search_text' ); ?>" name="<?php echo $this->get_field_name( 'search_text' ); ?>" value="<?php echo $instance['search_text']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:right;width:48%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'search_submit' ); ?>"><?php _e('Search Submit:', 'rolopress'); ?></label>
			<input id="<?php echo $this->get_field_id( 'search_submit' ); ?>" name="<?php echo $this->get_field_name( 'search_submit' ); ?>" value="<?php echo $instance['search_submit']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'theme_search' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['theme_search'], true ); ?> id="<?php echo $this->get_field_id( 'theme_search' ); ?>" name="<?php echo $this->get_field_name( 'theme_search' ); ?>" /> <?php echo __('Use theme\'s','rolopress') . "<code>searchform.php</code>?</label>";?>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>