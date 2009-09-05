<?php
/**
 * Handles widgets and widget areas
 *
 * Main functions file for the RoloPress framework.
 *
 * Based on Hybrid theme: http://themehybrid.com/themes/hybrid
 *
 * @package RoloPress
 * @subpackage Widgets
 */
 

function rolopress_info_heading() {
				{ ?>
				<h3 class="section-heading"><span>Contacts</span></h3>
				<?php }
					
};

add_filter('rolopress_before_info_content', 'rolopress_info_heading');







?>