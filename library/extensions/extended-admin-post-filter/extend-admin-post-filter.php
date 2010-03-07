<?php
/*
Plugin Name: Extended Admin Post Filter
Plugin URI: http://www.cozmoslabs.com/2010/02/08/extending-the-admin-post-filtering/
Description: Filter posts in the admin panel
Version: 1.0
Author: Cozmos Labs
Author URI: http://www.cozmoslabs.com/

Modifyed to work with RoloPress
*/



/*
	Copyright 2010  Cozmos Labs

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// thanks to sojweb for this the author filtering part!
function soj_manage_posts_by_author()
{
	global $user_ID;
	//echo('<label>Owners</label>'); 
	$editable_ids = get_editable_user_ids( $user_ID );
	wp_dropdown_users(
		array(
			'include' => $editable_ids,
			'show_option_all' => __('View all Owners'),
			'name' => 'author',
			'selected' => isset($_GET['author']) ? $_GET['author'] : 0
		)
	);
}

add_action('restrict_manage_posts', 'soj_manage_posts_by_author');

function soj_manage_posts_by_tax(){
	global $wp_taxonomies;
	if ( is_array( $wp_taxonomies ) )
	{
		$no_category_and_links = array('');
		foreach( $wp_taxonomies as $tax )
		{
			if($tax->label!='Categories'){ // the categories dropdown is default wordpress behaviour
				//echo('<label>'.$tax->label.'</label>'); 

				$the_terms = get_terms($tax->name,'orderby=name&hide_empty=0' );
					
				$content  = '<select name="'.$tax->name.'" id="'.$tax->name.'" class="postform">';
				$content .= '<option value="0">View all '.$tax->label.'</option>';
				foreach ($the_terms as $term){
					$content .= '<option value="' . $term->slug . '">'. $term->slug . '</option>';
				}
				$content .= '</select>';
				
				$content = str_replace('post_tag', 'tag', $content); // for some reason, when you get 'post_tag' in the url, it doesn't work. it needs to be just 'tag'
				
				echo($content);
			}
		}
	}
}

add_action('restrict_manage_posts', 'soj_manage_posts_by_tax');