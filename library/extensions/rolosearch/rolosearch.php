<?php 
/**
 * RoloSearch
 *
 * Allows searching of custom fields, custom taxonomies and meta data
 * Excludes all pages from search
 *
 * @credits Search Everything plugin v6.5.1 https://redmine.sproutventure.com/projects/show/search-everything
 *
 * @package RoloPress
 * @subpackage RoloSearch
 */


 // only search posts
 // @credits http://wpvibe.com/exclude-pages-wordpress-search-253/
function RoloSearchExcludePages($query) {
        if ($query->is_search) {
        $query->set('post_type', 'post');
                                }
        return $query;
}
add_filter('pre_get_posts','RoloSearchExcludePages');

Class RoloSearch {

	//var $logging = false;
	//var $options;
	//var $wp_ver23;
	//var $wp_ver25;
	//var $wp_ver28;

	function RoloSearch(){
		global $wp_version;
		$this->wp_ver23 = ($wp_version >= '2.3');
		//$this->wp_ver25 = ($wp_version >= '2.5');
		//$this->wp_ver28 = ($wp_version >= '2.8');
		//$this->options = get_option('rps_options');

		//add filters based upon option settings
			add_filter('posts_join', array(&$this, 'rps_terms_join'));
			add_filter('posts_join', array(&$this, 'rps_notes_join'));
			add_filter('posts_join', array(&$this, 'rps_search_metadata_join'));
			add_filter('posts_where', array(&$this, 'rps_search_where'));
			add_filter('posts_where', array(&$this, 'rps_no_revisions'));
			add_filter('posts_request', array(&$this, 'rps_distinct'));
			add_filter('posts_where', array(&$this, 'rps_no_future'));		
	}

	// creates the list of search keywords from the 's' parameters.
	function rps_get_search_terms()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$sentence = $wp_query->query_vars['sentence'];
		$search_terms = array();
			
		if ( !empty($s) )
		{
			// added slashes screw with quote grouping when done early, so done later
			$s = stripslashes($s);
			if ($sentence)
			{
				$search_terms = array($s);
			} else {
				preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $s, $matches);
				$search_terms = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
			}
		}
		return $search_terms;
	}

	// add where clause to the search query
	function rps_search_where($where)
	{
		global $wp_query, $wpdb;
		$searchQuery = '';

		//add filters based upon option settings
			$searchQuery .= $this->rps_build_search_tag();
			$searchQuery .= $this->rps_build_search_categories();
			$searchQuery .= $this->rps_build_search_metadata();
			$searchQuery .= $this->rps_build_search_excerpt();
			$searchQuery .= $this->rps_build_search_notes();
	
		if ($searchQuery != '')
		{
			$index1 = strpos($where, '((');
			$index2 = strrpos($where, ')) ');
			$firstPart = substr($where, 0, $index1);
			$secondPart = substr($where, $index1, $index2-1);
			$lastPart = substr($where, $index2-1+3);
			$where = $firstPart."(".$secondPart.$searchQuery.")".$lastPart;
		}
		return $where;
	}

	// Exclude post revisions
	function rps_no_revisions($where)
	{
		global $wp_query, $wpdb;
		if (!empty($wp_query->query_vars['s']))
		{
			if(!$this->wp_ver28)
			{
				$where = 'AND (' . substr($where, strpos($where, 'AND')+3) . ") AND $wpdb->posts.post_type != 'revision'";
			}
			$where = 'AND (' . substr($where, strpos($where, 'AND')+3) . ') AND post_type != \'revision\'';
		}
		return $where;
	}

	// Exclude future posts fix provided by Mx
	function rps_no_future($where)
	{
		global $wp_query, $wpdb;
		if (!empty($wp_query->query_vars['s']))
		{
			if(!$this->wp_ver28)
			{
				$where = 'AND (' . substr($where, strpos($where, 'AND')+3) . ") AND $wpdb->posts.post_status != 'future'";
			}
				$where = 'AND (' . substr($where, strpos($where, 'AND')+3) . ') AND post_status != \'future\'';
		}
		return $where;
	}
	

	//Duplicate fix provided by Tiago.Pocinho
	function rps_distinct($query)
	{
		global $wp_query, $wpdb;
		if (!empty($wp_query->query_vars['s']))
		{
			if (strstr($where, 'DISTINCT'))
			{}
			else
			{
				$query = str_replace('SELECT', 'SELECT DISTINCT', $query);
			}
		}
		return $query;
	}

	// create the search excerpts query
	function rps_build_search_excerpt()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$search_terms = $this->rps_get_search_terms();
		$exact = $wp_query->query_vars['exact'];
		$search = '';

		if ( !empty($search_terms) ) {
			// Building search query
			$n = ($exact) ? '' : '%';
			$searchand = '';
			foreach($search_terms as $term) {
				$term = addslashes_gpc($term);
				$search .= "{$searchand}($wpdb->posts.post_excerpt LIKE '{$n}{$term}{$n}')";
				$searchand = ' AND ';
			}
			$sentence_term = $wpdb->escape($s);
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $sentence_term )
			{
				$search = "($search) OR ($wpdb->posts.post_excerpt LIKE '{$n}{$sentence_term}{$n}')";
			}
			if ( !empty($search) )
			$search = " OR ({$search}) ";
		}

		return $search;
	}
	
	// create the notes data query
	function rps_build_search_notes()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$search_terms = $this->rps_get_search_terms();
		$exact = $wp_query->query_vars['exact'];

		if ( !empty($search_terms) ) {
			// Building search query on notes content
			$n = ($exact) ? '' : '%';
			$searchand = '';
			$searchContent = '';
			foreach($search_terms as $term) {
				$term = addslashes_gpc($term);
				if ($this->wp_ver23)
				{
					$searchContent .= "{$searchand}(cmt.comment_content LIKE '{$n}{$term}{$n}')";
				}
				$searchand = ' AND ';
			}
			$sentenrps_term = $wpdb->escape($s);
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $sentenrps_term )
			{
				if ($this->wp_ver23)
				{
					$searchContent = "($searchContent) OR (cmt.comment_content LIKE '{$n}{$sentenrps_term}{$n}')";
				}
			}
			$search = $searchContent;
	
				$comment_approved = "AND cmt.comment_approved =  '1'";
				$search = "($search) $comment_approved";

			if ( !empty($search) )
			$search = " OR ({$search}) ";
		}
		return $search;
	}

	// create the search meta data query
	function rps_build_search_metadata()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$search_terms = $this->rps_get_search_terms();
		$exact = $wp_query->query_vars['exact'];
		$search = '';

		if ( !empty($search_terms) ) {
			// Building search query
			$n = ($exact) ? '' : '%';
			$searchand = '';
			foreach($search_terms as $term) {
				$term = addslashes_gpc($term);
				if ($this->wp_ver23)
				{
					$search .= "{$searchand}(m.meta_value LIKE '{$n}{$term}{$n}')";
				} else {
					$search .= "{$searchand}(meta_value LIKE '{$n}{$term}{$n}')";
				}
				$searchand = ' AND ';
			}
			$sentence_term = $wpdb->escape($s);
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $sentence_term )
			{
				if ($this->wp_ver23)
				{
					$search = "($search) OR (m.meta_value LIKE '{$n}{$sentence_term}{$n}')";
				} else {
					$search = "($search) OR (meta_value LIKE '{$n}{$sentence_term}{$n}')";
				}
			}
				
			if ( !empty($search) )
			$search = " OR ({$search}) ";
		}
		return $search;
	}

	// create the search tag query
	function rps_build_search_tag()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$search_terms = $this->rps_get_search_terms();
		$exact = $wp_query->query_vars['exact'];
		$search = '';

		if ( !empty($search_terms) )
		{
			// Building search query
			$n = ($exact) ? '' : '%';
			$searchand = '';
			foreach($search_terms as $term)
			{
				$term = addslashes_gpc($term);
				if ($this->wp_ver23)
				{
					$search .= "{$searchand}(tter.name LIKE '{$n}{$term}{$n}')";
				}
				$searchand = ' AND ';
			}
			$sentence_term = $wpdb->escape($s);
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $sentence_term )
			{
				if ($this->wp_ver23)
				{
					$search = "($search) OR (tter.name LIKE '{$n}{$sentence_term}{$n}')";
				}
			}
			if ( !empty($search) )
			$search = " OR ({$search}) ";
		}
		return $search;
	}

	// create the search categories query
	function rps_build_search_categories()
	{
		global $wp_query, $wpdb;
		$s = $wp_query->query_vars['s'];
		$search_terms = $this->rps_get_search_terms();
		$exact = $wp_query->query_vars['exact'];
		$search = '';

		if ( !empty($search_terms) )
		{
			// Building search query for categories slug.
			$n = ($exact) ? '' : '%';
			$searchand = '';
			$searchSlug = '';
			foreach($search_terms as $term)
			{
				$term = addslashes_gpc($term);
				$searchSlug .= "{$searchand}(tter.slug LIKE '{$n}".sanitize_title_with_dashes($term)."{$n}')";
				$searchand = ' AND ';
			}
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $s )
			{
				$searchSlug = "($searchSlug) OR (tter.slug LIKE '{$n}".sanitize_title_with_dashes($s)."{$n}')";
			}
			if ( !empty($searchSlug) )
			$search = " OR ({$searchSlug}) ";

			// Building search query for categories description.
			$searchand = '';
			$searchDesc = '';
			foreach($search_terms as $term)
			{
				$term = addslashes_gpc($term);
				$searchDesc .= "{$searchand}(ttax.description LIKE '{$n}{$term}{$n}')";
				$searchand = ' AND ';
			}
			$sentence_term = $wpdb->escape($s);
			if (!$sentence && count($search_terms) > 1 && $search_terms[0] != $sentence_term )
			{
				$searchDesc = "($searchDesc) OR (ttax.description LIKE '{$n}{$sentence_term}{$n}')";
			}
			if ( !empty($searchDesc) )
			$search = $search." OR ({$searchDesc}) ";
		}

		return $search;
	}

	//join for searching notes
	function rps_notes_join($join)
	{
		global $wp_query, $wpdb;

		if (!empty($wp_query->query_vars['s']))
		{
			if ($this->wp_ver23)
			{
				$join .= " LEFT JOIN $wpdb->comments AS cmt ON ( cmt.comment_post_ID = $wpdb->posts.ID ) ";
					
			} else {

				$comment_approved = " AND comment_approved =  '1'";

				$join .= "LEFT JOIN $wpdb->comments ON ( comment_post_ID = ID " . $comment_approved . ") ";
			}
		}
		return $join;
	}

	//join for searching authors
	function rps_search_authors_join($join)
	{
		global $wp_query, $wpdb;

		if (!empty($wp_query->query_vars['s']))
		{
			$join .= " LEFT JOIN $wpdb->users AS u ON ($wpdb->posts.ID = u.ID) ";
		}
		return $join;
	}

	//join for searching metadata
	function rps_search_metadata_join($join)
	{
		global $wp_query, $wpdb;

		if (!empty($wp_query->query_vars['s']))
		{

			if ($this->wp_ver23)
			$join .= " LEFT JOIN $wpdb->postmeta AS m ON ($wpdb->posts.ID = m.post_id) ";
			else
			$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
		}
		return $join;
	}

	//join for searching tags
	function rps_terms_join($join)
	{
		global $wp_query, $wpdb;

		if (!empty($wp_query->query_vars['s']))
		{
			// categories
				$on[] = "ttax.taxonomy = 'category'";
			// tags
				$on[] = "ttax.taxonomy = 'post_tag'";
			// custom taxonomies
					$all_taxonomies = get_object_taxonomies('post');
					foreach ($all_taxonomies as $taxonomy) 
					{
						if ($taxonomy == 'post_tag' || $taxonomy == 'category')
						continue;
						$on[] = "ttax.taxonomy = '".addslashes($taxonomy)."'";
					}
				
			// build our final string
			$on = ' ( ' . implode( ' OR ', $on ) . ' ) ';

			$join .= " LEFT JOIN $wpdb->term_relationships AS trel ON ($wpdb->posts.ID = trel.object_id) LEFT JOIN $wpdb->term_taxonomy AS ttax ON ( " . $on . " AND trel.term_taxonomy_id = ttax.term_taxonomy_id) LEFT JOIN $wpdb->terms AS tter ON (ttax.term_id = tter.term_id) ";
		}

		return $join;
	}
}

$RPS = new RoloSearch();

 // END
?>