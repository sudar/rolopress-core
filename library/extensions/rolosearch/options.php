<?php

Class se_admin {

	var $se_version = '6.3.1';
	var $rs_version = '.1';

	function se_admin() {

		// Load language file
		$locale = get_locale();
		if ( !empty($locale) )
			load_textdomain('RoloSearch', SE_ABSPATH .'lang/se-'.$locale.'.mo');


		add_action('admin_head', array(&$this, 'se_options_style'));
		add_action('admin_menu', array(&$this, 'se_add_options_panel'));

        }

	function se_add_options_panel() {
		add_options_page('Search', 'RoloSearch', 7, 'extend_search', array(&$this, 'se_option_page'));
	}

	//build admin interface
	function se_option_page() 
	{
		global $wpdb, $table_prefix, $wp_version;
			
			$new_options = array(
				'se_exclude_categories'			=> $_POST["exclude_categories"],
				'se_exclude_categories_list'	=> $_POST["exclude_categories_list"],
				'se_exclude_posts'				=> $_POST["exclude_posts"],
				'se_exclude_posts_list'			=> $_POST["exclude_posts_list"],
				'se_use_page_search'			=> $_POST["search_pages"],
				'se_use_comment_search'			=> $_POST["search_comments"],
				'se_use_tag_search'				=> $_POST["search_tags"],
				'se_use_category_search'		=> $_POST["search_categories"],
				'se_approved_comments_only'		=> $_POST["appvd_comments"],
				'se_approved_pages_only'		=> $_POST["appvd_pages"],
				'se_use_excerpt_search'			=> $_POST["search_excerpt"],
				'se_use_draft_search'			=> $_POST["search_drafts"],
				'se_use_attachment_search'		=> $_POST["search_attachments"],
				'se_use_authors'				=> $_POST["search_authors"],
				'se_use_cmt_authors'			=> $_POST["search_cmt_authors"],
				'se_use_metadata_search'		=> $_POST["search_metadata"],
				'se_use_highlight'				=> $_POST["search_highlight"],
				'se_highlight_color'			=> $_POST["highlight_color"],
				'se_highlight_style'			=> $_POST["highlight_style"]

			);
			
		if($_POST['action'] == "save") 
		{
			echo "<div class=\"updated fade\" id=\"limitcatsupdatenotice\"><p>" . __('Your default search settings have been <strong>updated</strong> by RoloSearch. </p><p> What are you waiting for? Go check out the new search results!', 'RoloSearch', 'rolopress') . "</p></div>";
			update_option("se_options", $new_options);

		}
		
		if($_POST['action'] == "reset") 
		{ 
			echo "<div class=\"updated fade\" id=\"limitcatsupdatenotice\"><p>" . __('Your default search settings have been <strong>updated</strong> by RoloSearch. </p><p> What are you waiting for? Go check out the new search results!', 'RoloSearch', 'rolopress') . "</p></div>";
			delete_option("se_options", $new_options);
		}
		

		$options = get_option('se_options');

		?>

	<div class="wrap">
		<h2><?php _e('RoloSearch Version:', 'RoloSearch', 'rolopress'); ?> <?php echo $this->rs_version; ?></h2>
			<form method="post">
		
				<div style="float: right; margin-bottom:10px; padding:0; " id="top-update" class="submit">
					<input type="hidden" name="action" value="save" />
					<input type="submit" value="<?php _e('Update Options', 'RoloSearch', 'rolopress') ?>" />
				</div>

				
				<table style="margin-bottom: 20px;"></table>
				<table class="widefat fixed">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Basic Configuration', 'RoloSearch', 'rolopress'); ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
					<?php
					// Show options for 2.5 and below
					if ($wp_version <= '2.5') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every page','RoloSearch', 'rolopress'); ?>:<br/><small></small></td>
				        <td class="forminp">
				            <select id="search_pages" name="search_pages">
							<option<?php if ($options['se_use_page_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_page_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							
				        </td>
				    </tr>
					
					<tr class="mainrow"> 
				        <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Search approved pages only','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="appvd_pages" name="appvd_pages">
							<option<?php if ($options['se_approved_pages_only'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_approved_pages_only'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<?php
					// Show tags only for WP 2.3+
					if ($wp_version >= '2.3') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every tag name','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_tags" name="search_tags" >
								<option<?php if ($options['se_use_tag_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
				                <option<?php if ($options['se_use_tag_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>				            
							</select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<?php
					// Show categories only for WP 2.5+
					if ($wp_version >= '2.5') : ?>
					<tr class="mainrow">
				        <td class="titledesc"><?php _e('Search every category name and description','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_categories" name="search_categories">
							<option<?php if ($options['se_use_category_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_category_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every note','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select name="search_comments" id="search_comments">
							<option<?php if ($options['se_use_comment_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_comment_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Search note authors','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_cmt_authors" name="search_cmt_authors">
							<option<?php if ($options['se_use_cmt_authors'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_cmt_authors'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Search approved notes only','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="appvd_comments" name="appvd_comments">
							<option<?php if ($options['se_approved_comments_only'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_approved_comments_only'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every excerpt','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_excerpt" name="search_excerpt">
							<option <?php if ($options['se_use_excerpt_search'] == 'Yes') { echo ' selected="selected"'; } ?> selected value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_excerpt_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php
					// Show categories only for WP 2.5+
					if ($wp_version >= '2.5') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every draft','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_drafts" name="search_drafts">
							<option<?php if ($options['se_use_draft_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_draft_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every attachment','RoloSearch', 'rolopress'); ?>:<br/><small><?php _e('(post type = attachment)','RoloSearch', 'rolopress'); ?></small></td>
				        <td class="forminp">
				            <select id="search_attachments" name="search_attachments">
							<option<?php if ($options['se_use_attachment_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_attachment_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search Item Details','RoloSearch', 'rolopress'); ?>:<br/></td>
				        <td class="forminp">
				            <select id="search_metadata" name="search_metadata">
							<option<?php if ($options['se_use_metadata_search'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_metadata_search'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every item owner','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_authors" name="search_authors">
							<option<?php if ($options['se_use_authors'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_authors'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Highlight Search Terms','RoloSearch', 'rolopress'); ?>:</td>
				        <td class="forminp">
				            <select id="search_highlight" name="search_highlight">
							<option<?php if ($options['se_use_highlight'] == 'Yes') { echo ' selected="selected"'; } ?> value="Yes"><?php _e('Yes', 'RoloSearch', 'rolopress'); ?></option>
							<option<?php if ($options['se_use_highlight'] == 'No') { echo ' selected="selected"'; } ?> value="No">&nbsp;&nbsp;</option>
							</select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
					    <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Highlight Background Color','RoloSearch', 'rolopress'); ?>:</td>
					    <td class="forminp">
					        <input type="text" id="highlight_color" name="highlight_color" value="<?php echo $options['se_highlight_color'];?>" />
						    <br/><small><?php _e('Examples:<br/>\'#FFF984\' or \'red\'','RoloSearch', 'rolopress'); ?></small>
					    </td>
					</tr>
				
				</table>
				<table style="margin-bottom: 20px;"></table>
					
				<table class="widefat">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Advanced Configuration - Exclusion', 'RoloSearch', 'rolopress'); ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
				
					<tr class="mainrow"> 
					    <td class="titledesc"><?php _e('Exclude some post or page IDs','RoloSearch', 'rolopress'); ?>:</td>
					    <td class="forminp">
					        <input type="text" id="exclude_posts_list" name="exclude_posts_list" value="<?php echo $options['se_exclude_posts_list'];?>" />
						    <br/><small><?php _e('Comma separated Post IDs (example: 1, 5, 9)','RoloSearch', 'rolopress'); ?></small>
					    </td>
					</tr>
					<tr class="mainrow"> 
					    <td class="titledesc"><?php _e('Exclude Categories','RoloSearch', 'rolopress'); ?>:</td>
					    <td class="forminp">
					        <input type="text" id="exclude_categories_list" name="exclude_categories_list" value="<?php echo $options['se_exclude_categories_list'];?>" />
						    <br/><small><?php _e('Comma separated category IDs (example: 1, 4)','RoloSearch', 'rolopress'); ?></small>
					    </td>
					</tr>
					<tr class="mainrow"> 
					    <td class="titledesc"><?php _e('Full Highlight Style','RoloSearch', 'rolopress'); ?>:</td>
					    <td class="forminp">
					        <small><?php _e('Important: \'Highlight Background Color\' must be blank to use this advanced styling.', 'RoloSearch', 'rolopress') ?></small><br/>
							<input type="text" id="highlight_style" name="highlight_style" value="<?php echo $options['se_highlight_style'];?>" />
						    <br/><small><?php _e('Example:<br/>background-color: #FFF984; font-weight: bold; color: #000; padding: 0 1px;','RoloSearch', 'rolopress'); ?></small>
					    </td>
					</tr>
				</table>


		<p class="submit">
			<input type="hidden" name="action" value="save" />
			<input type="submit" value="<?php _e('Update Options', 'RoloSearch', 'rolopress') ?>" />
		</p>
	</form>


		<div style="float: left; margin:0; padding:0; " class="submit">
			<form method="post">
				<input name="reset" type="submit" value="<?php _e('Reset Button', 'RoloSearch', 'rolopress') ?>" />
				<input type="hidden" name="action" value="reset" />
			</form><br/><br/>
		<div style="clear:both;"></div>



</div>			

				<table style="margin-bottom: 20px;"></table>
				<table class="widefat">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Test Search Form', 'RoloSearch', 'rolopress'); ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
				
					<tr class="mainrow"> 
						<td class="thanks">
							<p><?php _e('Use this search form to run a live search test.', 'RoloSearch', 'rolopress'); ?></p>
						</td>
						<td>
							<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">
							<p class="srch submit">
								<input type="text" class="srch-txt" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="30" />
								<input type="submit" class="SE5_btn" id="searchsubmit" value="<?php _e('Run Test Search', 'RoloSearch', 'rolopress'); ?>" />
							</p>
			      			</form>
						</td>
					</tr>
				</table>
				
				<table style="margin-bottom: 20px;"></table>

			</div>

			
			<div style="float: left; padding-top:4px;">
			<h5><?php _e('RoloSearch Version: ', 'RoloSearch', 'rolopress'); ?> <?php echo $this->rs_version; ?> <?php _e('was based on Search Everything Version: ', 'RoloSearch', 'rolopress'); ?> <?php echo $this->se_version; ?>: <?php _e('Developed by Dan Cameron of', 'RoloSearch', 'rolopress'); ?> <a href="http://sproutventure.com?search-everything" title="Custom WordPress Development"><?php _e('Sprout Venture', 'RoloSearch', 'rolopress'); ?></a>.</h5>
		</div>

		<?php
	}	//end se_option_page

	//styling options page
	function se_options_style() {
		?>
		<style type="text/css" media="screen">
			.titledesc {width:300px;}
			.thanks {width:400px; }
			.thanks p {padding-left:20px; padding-right:20px;}
			.info { background: #FFFFCC; border: 1px dotted #D8D2A9; padding: 10px; color: #333; }
			.info a { color: #333; text-decoration: none; border-bottom: 1px dotted #333 }
			.info a:hover { color: #666; border-bottom: 1px dotted #666; }
		</style>
		<?php
	}

}
?>