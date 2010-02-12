<?php
//allows RoloPress to get options from admin pages that are used on ALL pages
global $layout_options;
foreach ($layout_options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }


?>