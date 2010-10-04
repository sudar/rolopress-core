<?php
/**
 * Recent Notes Widget
 *
 * Displays Recent Notes
 *
 * @package RoloPress
 * @subpackage Widgets
 */
class Rolo_Widget_Recent_Notes extends WP_Widget {

	function Rolo_Widget_Recent_Notes() {
		$widget_ops = array('classname' => 'widget_recent_notes', 'description' => __( 'Display your recent Notes' ) );
		$this->WP_Widget('recent-notes', __('Recent Notes'), $widget_ops);
		$this->alt_option_name = 'widget_recent_notes';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'recent_notes_style') );

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	function recent_notes_style() { ?>
	<style type="text/css">.recentnotes a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<?php
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_notes', 'widget');
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_notes', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Notes') : $instance['title']);

		if ( ! $number = (int) $instance['number'] )
 			$number = 5;
 		else if ( $number < 1 )
 			$number = 1;
			
		if ( $instance['datetime'] == 'date') {
			$new_instance['datetime'] = get_comment_date() . ": ";
		} elseif ($instance['datetime'] == 'date/time') {
			$new_instance['datetime'] = get_comment_date() . " at " . get_comment_time() . ": ";
		} else {
			$new_instance['datetime'] = null;
		};
		
		$datetime = $new_instance['datetime'];

		$comments = get_comments( array( 'number' => $number, 'status' => 'approve' ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul id="recentnotes">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				$output .=  '<li class="recentnotes">' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s', 'widgets'), $datetime . '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . ': ' . get_comment_excerpt() . '</a>') . '</li>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_notes', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['datetime'] = $new_instance['datetime'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_notes']) )
			delete_option('widget_recent_notes');

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$datetime = $instance['datetime'];
?>
		<div style="float:left;width:98%;">
		<p><img class="rolo_widget_icon" src= <?php echo ROLOPRESS_IMAGES  . '/admin/rolopress-icon.gif' ?> />
		<?php _e('Displays your recently created Notes.', 'rolopress')?>
		</p>
		</div>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of notes to show:'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		
		<p>
				<label for="<?php echo $this->get_field_id( 'datetime' ); ?>"><?php _e('Show Date and Time:', 'rolopress'); ?></label> 
					<select id="<?php echo $this->get_field_id( 'datetime' ); ?>" name="<?php echo $this->get_field_name( 'datetime' ); ?>" class="widefat" style="width:100%;">
						<option <?php if ( 'none' == $instance['datetime'] ) echo 'selected="selected"'; ?>>none</option>
						<option <?php if ( 'date' == $instance['datetime'] ) echo 'selected="selected"'; ?>>date</option>
						<option <?php if ( 'date/time' == $instance['datetime'] ) echo 'selected="selected"'; ?>>date/time</option>
			</select>
					</select></p>
<?php
	}
}
?>