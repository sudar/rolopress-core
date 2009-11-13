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
		$widget_ops = array('classname' => 'recent-notes', 'description' => __('Displays Your Most Recent Notes', 'rolopress') );
		$this->WP_Widget('recent-notes', __('Recent Notes'), $widget_ops);
		$this->alt_option_name = 'widget_recent_notes';

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'wp_set_comment_status', array(&$this, 'flush_widget_cache') );
	}


	function flush_widget_cache() {
		wp_cache_delete('recent_notes', 'widget');
	}

	function widget( $args, $instance ) {
		global $wpdb, $comments, $comment;

		extract($args, EXTR_SKIP);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Notes') : $instance['title']);
		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;

		if ( !$comments = wp_cache_get( 'recent_notes', 'widget' ) ) {
			$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 15");
			wp_cache_add( 'recent_notes', $comments, 'widget' );
		}

		$comments = array_slice( (array) $comments, 0, $number );
?>
		<?php echo $before_widget;
			if ( $title )
			echo "\n\t\t\t" . $before_title . $title . $after_title;
			echo "\n\t\t\t\t" . '<ul class="xoxo recent-notes">';
			
			if ( $comments ) : foreach ( (array) $comments as $comment) :
			echo  '<li class="recentnote">' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s : %2$s', 'widgets'), get_the_title($comment->comment_post_ID) ,  '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_comment_excerpt($comment->comment_post_ID) . '</a>') . '</li><!-- .recent-note -->';
			endforeach; endif;
			
			echo "\n\t\t\t\t" . '</ul><!-- .xoxo .recent-notes -->';
		echo $after_widget; ?>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_notes']) )
			delete_option('widget_recent_notes');

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$defaults = array( 'title' => __('Recent Notes', 'rolopress'));
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of notes to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e('(at most 15)'); ?></small></p>
<?php
	}
}
