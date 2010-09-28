<?php

/**
 * Thanks to http://bavotasan.com/tutorials/how-to-add-nested-comments-to-your-wordpress-theme/
 */
 

 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'notes.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
<p class="nocomments"><?php _e('This item is password protected. Enter the password to view notes.', 'rolopress')?></p>
<?php
return;
}
?>

<!-- You can start editing here. -->
<div id="notes" class="group">

<?php if ( have_comments() ) : ?>
<h3><?php comments_number(__('No Notes','rolopress'), __('One Note','rolopress'),  __('% Notes','rolopress') );?> for &#8220;<?php the_title(); ?>&#8221;</h3>

<div class="note-nav">
<div class="alignleft"><?php previous_comments_link( '&laquo;  Older Notes' ); ?></div>
<div class="alignright"><?php next_comments_link( 'Newer Notes &raquo;', 0 ); ?></div>
</div>

<ol class="notelist">
<?php wp_list_comments('type=comment&callback=rolopress_notes'); ?>
</ol>

<div class="note-nav">
<div class="alignleft"><?php previous_comments_link( '&laquo;  Older Notes' ); ?></div>
<div class="alignright"><?php next_comments_link( 'Newer Notes &raquo;', 0 ); ?></div>
</div>

</div><!-- /notes -->



<?php else : // this is displayed if there are no notes so far ?>


<?php if ('open' == $post->comment_status) : ?>
<!-- If comments (notes) are open, but there are no comments (notes). -->

<?php else : // comments (notes) are closed ?>
<!-- If comments (notes) are closed. -->
<p class="nonotes"></p>

<?php endif; ?>
</div>
<?php endif; ?>

<?php if ( current_user_can('edit_posts') ) { ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="respond" class="group">

<h3><?php comment_form_title( __('Add a Note', 'rolopress'), __('Add a Note Attachment', 'rolopress'), true ); ?></h3>

<div class="cancel-note-reply">
<small><?php cancel_comment_reply_link( __('Cancel attachment to note', 'rolopress') ); ?> </small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be ', 'rolopress')?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in ', 'rolopress')?></a><?php _e(' to leave a note.', 'rolopress')?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="noteform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as ', 'rolopress')?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out ', 'rolopress')?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email"><small>Email (will not be shown) <?php if ($req) echo "(required)"; ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->


<p><textarea name="comment" id="note" cols="100%" rows="10" tabindex="4"></textarea></p>

<?php do_action('rolopress_before_note_submit', $post->ID); ?>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Add Note" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head 

}; ?>



<!--   overrides default WordPress comments layout  -->

<?php 
function rolopress_notes($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-note-<?php comment_ID() ?>">
<div id="comment-<?php comment_ID(); ?>" class="note">

<?php if ($comment->comment_approved == '0') : ?>
<em><?php _e('Your note is awaiting moderation.', 'rolopress') ?></em>
<br />
<?php endif; ?>


<?php comment_text() ?>
<?php if($args['max_depth']!=$depth) { ?>
    <div class="attach">
  <?php comment_reply_link(array_merge( $args, array('reply_text' => 'Attach','depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div><!-- /attach -->
<?php } ?>
</div><!-- /comment -->
<div class="note-meta notemetadata">
<a href="<?php echo htmlspecialchars(get_comment_link( $comment->comment_ID )) ?>">
<span class="note-author">
<?php printf(__('<span class="added-by">Added by: </span><cite class="commenter">%s</cite><span class="added-on"> on </span>', 'rolopress'), get_comment_author_link()) ?>
</span>
<span class="note-date-time">
<?php printf(__('%1$s at %2$s', 'rolopress'), get_comment_date(),get_comment_time()) ?></span></a>
</div><!-- note-meta -->

<?php
}
?>




<?php  //Custom Reply Link for Notes: http://www.aarongloege.com/blog/web-development/wordpress/advanced-comment-customization/
function my_replylink($c='',$post=null) {
  global $comment;
  // bypass
  if (!comments_open() || $comment->comment_type == "trackback" || $comment->comment_type == "pingback") return $c;
  // patch
  $id = $comment->comment_ID;
  $attach = 'Attach to this note';
  $o = '<a class="comment-reply-link" rel="'.$comment->comment_author.'" id="'.$id.'" href="'.get_permalink().'?replytocom='.$id.'#respond">'.$attach.'</a>';
  return $o;
}
add_filter('comment_reply_link', 'my_replylink');

?>