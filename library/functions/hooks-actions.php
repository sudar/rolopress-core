<?php
/**
 * Action Hooks
 *
 * @link http://rolopress.com/action-hooks
 *
 * @package RoloPress
 * @subpackage Hooks
 */

// Located in header.php 
function rolopress_head() { do_action('rolopress_head'); }

function rolopress_before_wrapper() { do_action('rolopress_before_wrapper'); }

function rolopress_before_header() { do_action('rolopress_before_header'); }

function rolopress_header() { do_action('rolopress_header'); }

function rolopress_menu() { do_action('rolopress_menu'); }

function rolopress_after_header() { do_action('rolopress_after_header'); }


// Located in body files 

function rolopress_before_container() { do_action('rolopress_before_container'); }

function rolopress_before_main() { do_action('rolopress_before_main'); }

function rolopress_before_info() { do_action('rolopress_before_info'); }

function rolopress_before_info_content() { do_action('rolopress_before_info_content'); }

function rolopress_before_page_info() { do_action('rolopress_before_page_info'); } //Pages only

function rolopress_before_page_info_content() { do_action('rolopress_before_page_info_content'); } //Pages only

function rolopress_before_entry() { do_action('rolopress_before_entry'); }

function rolopress_after_entry() { do_action('rolopress_after_entry'); }

function rolopress_after_info() { do_action('rolopress_after_info'); }

function rolopress_after_info_content() { do_action('rolopress_after_info_content'); }

function rolopress_after_page_info() { do_action('rolopress_after_page_info'); } //Pages only

function rolopress_after_page_info_content() { do_action('rolopress_after_page_info_content'); } //Pages only

function rolopress_after_main() { do_action('rolopress_after_main'); }

function rolopress_after_container() { do_action('rolopress_after_container'); }


// Located in List pages
function rolopress_after_contact_header() { do_action('rolopress_after_contact_header'); }

function rolopress_after_company_header() { do_action('rolopress_after_company_header'); }

// Located in Item Details
function rolopress_after_contact_details() { do_action('rolopress_after_contact_details'); }

function rolopress_after_company_details() { do_action('rolopress_after_company_details'); }


// Located in footer.php
function rolopress_before_footer() { do_action('rolopress_before_footer'); }

function rolopress_footer() { do_action('rolopress_footer'); }

function rolopress_after_footer() { do_action('rolopress_after_footer'); }

function rolopress_after_wrapper() { do_action('rolopress_after_wrapper'); }

/* Hooks located in other files
 * These are for reference
 
 Notes.php
 rolopress_before_note_submit()
 
 */

?>