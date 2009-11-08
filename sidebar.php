<?php if (is_single() && (( rolo_type_is( 'contact' ) ))): // if contact single load contact widget area ?>
		<div id="primary" class="widget-area">
			<ul class="xoxo">		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("contact-primary-top") ); ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("primary") ); ?>
			</ul>
		</div><!-- #primary .widget-area -->

<?php elseif (is_single() && (( rolo_type_is( 'company' ) ))): // if company single load contact widget area ?>
		<div id="primary" class="widget-area">
			<ul class="xoxo">		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("company-primary-top") ); ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("primary") ); ?>
			</ul>
		</div><!-- #primary .widget-area -->
		
<?php elseif ( is_sidebar_active('primary') ) : // if neither just check if primary is active ?>
		<div id="primary" class="widget-area">
			<ul class="xoxo">
				<?php dynamic_sidebar('primary'); ?>
			</ul>
		</div><!-- #primary .widget-area -->
<?php endif; ?>		
		
<?php if ( is_sidebar_active('secondary') ) : ?>
		<div id="secondary" class="widget-area">
			<ul class="xoxo">
				<?php dynamic_sidebar('secondary'); ?>
			</ul>
		</div><!-- #secondary .widget-area -->
<?php endif; ?>		


<?php	 if (!$company_id) {
        return false;
    }

    $company = get_post_meta($company_id, 'rolo_company');
    $company = $company[0];
?>
		
		<?php
global $wpdb;
$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,30) AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE comment_approved = '1' AND comment_type = '' AND
post_password = '' AND taxonomy=$company
ORDER BY comment_date_gmt DESC
LIMIT 10";
$comments = $wpdb->get_results($sql);
$output = $pre_HTML;
$output .= "\n<ul>";
foreach ($comments as $comment) {
$output .= "\n<li>".strip_tags($comment->comment_author)
.":" . "<a href=\"" . get_permalink($comment->ID) .
"#comment-" . $comment->comment_ID . "\" title=\"on " .
$comment->post_title . "\">" . strip_tags($comment->com_excerpt)
."</a></li>";
}
$output .= "\n</ul>";
$output .= $post_HTML;
echo $output;?>
