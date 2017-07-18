<?php
/*
Plugin Name: Booking Form
Plugin URI: http://demo.stackemedia.co.uk/
Description: A plugin for making bookings of items (e.g. rooms, buildings, cars, tennis courts, etc). Add [smbookingform] to page to show form.
Version: 1.3.2
Author: Henrik Stacke
Author URI: http://stackemedia.co.uk/
*/
/*
	A Wordpress plugin for making and managing bookings of items (e.g. rooms, buildings, cars, tennis courts, etc).
    Copyright (C) 2010  Henrik Stacke

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
*/

load_sm_booking_dependencies();

function sm_booking_admin() {
    include('sm-booking-admin.php');
}

function sm_booking_form() {
    include('sm-booking-form.php');
}

function sm_booking_view() {
    include('sm-booking-view.php');
}

function sm_booking_cal() {
    include('sm-booking-cal.php');
}

function sm_booking_item_view() {
    include('sm-booking-item-view.php');
}

function sm_booking_user_view() {
    include('sm-booking-user-view.php');
}

function sm_booking_user_new() {
    include('sm-booking-user-new.php');
}

function sm_booking_item_new() {
	include('sm-booking-item-new.php');
}

function sm_booking_itemtype_view() {
	include('sm-booking-itemtype-view.php');
}

function sm_booking_itemtype_new() {
	include('sm-booking-itemtype-new.php');
}

function sm_booking_about() {
	include('sm-booking-about.php');
}

//[smbookingform]
add_shortcode('smbookingform', 'sm_booking_form');

function sm_booking_actions() {
	global $current_user;
	global $wpdb;
	get_currentuserinfo();
	$email = $current_user->user_email;
	
	$sql = "SELECT sm_role_id, email_address FROM sm_users WHERE email_address = '" . $email . "'";
	$myrows = $wpdb->get_results( $sql );
	$isGatekeeper = false;
	$isAdmin = false;
	foreach ($myrows as $row) {
		if ($row->sm_role_id = 1)
		{
			$isGatekeeper = true;
		}
		if ($row->sm_role_id = 2)
		{
			$isAdmin = true;
		}
	}
	//print_r($myrows);

	//codex.wordpress.org/Roles_and_Capabilities
	$permission = 'read';

    $siteurl = get_option('siteurl');
    $iconurl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/book.png'; 
    add_menu_page("Bookings", "Bookings", 'manage_options', "Bookings", "sm_booking_admin", $iconurl);
	
	$bookingTable = "sm_booking";
	$itemsTable = "sm_booking_item";
	$typeTable = "sm_item_type";

	if($wpdb->get_var("show tables like '$bookingTable'") == $bookingTable && $wpdb->get_var("show tables like '$itemsTable'") == $itemsTable && $wpdb->get_var("show tables like '$typeTable'") == $typeTable) {
		if ($isAdmin && !$isGatekeeper) //Administrator
		{
			add_submenu_page("Bookings", "View Users", "View Users", $permission, "sm-booking-user-view.php", 'sm_booking_user_view');
			add_submenu_page("Bookings", "New User", "New User", $permission, "sm-booking-user-new.php", 'sm_booking_user_new');
		}
		elseif ($isGatekeeper && !isAdmin) //Gatekeeper
		{
			add_submenu_page("Bookings", "View Bookings", "View Bookings", $permission, "sm-booking-view.php", 'sm_booking_view');
			add_submenu_page("Bookings", "Bookings Calendar", "Bookings Calendar", $permission, "sm-booking-cal.php", 'sm_booking_cal');
			add_submenu_page("Bookings", "View Items", "View Items", $permission, "sm-booking-item-view.php", 'sm_booking_item_view');
			add_submenu_page("Bookings", "New Item", "New Item", $permission, "sm-booking-item-new.php", 'sm_booking_item_new');
			add_submenu_page("Bookings", "View Items", "View Item Types", $permission, "sm-booking-itemtype-view.php", 'sm_booking_itemtype_view');
			add_submenu_page("Bookings", "New Item Type", "New Item Type", $permission, "sm-booking-itemtype-new.php", 'sm_booking_itemtype_new');
			add_submenu_page("Bookings", "Booking Form", "Booking Form", $permission, "sm-booking-form.php", 'sm_booking_form');
		}
		elseif ($isAdmin && $isGatekeeper) //Both permissions
		{
			add_submenu_page("Bookings", "View Users", "View Users", $permission, "sm-booking-user-view.php", 'sm_booking_user_view');
			add_submenu_page("Bookings", "New User", "New User", $permission, "sm-booking-user-new.php", 'sm_booking_user_new');
			add_submenu_page("Bookings", "View Bookings", "View Bookings", $permission, "sm-booking-view.php", 'sm_booking_view');
			add_submenu_page("Bookings", "Bookings Calendar", "Bookings Calendar", $permission, "sm-booking-cal.php", 'sm_booking_cal');
			add_submenu_page("Bookings", "View Items", "View Items", $permission, "sm-booking-item-view.php", 'sm_booking_item_view');
			add_submenu_page("Bookings", "New Item", "New Item", $permission, "sm-booking-item-new.php", 'sm_booking_item_new');
			add_submenu_page("Bookings", "View Items", "View Item Types", $permission, "sm-booking-itemtype-view.php", 'sm_booking_itemtype_view');
			add_submenu_page("Bookings", "New Item Type", "New Item Type", $permission, "sm-booking-itemtype-new.php", 'sm_booking_itemtype_new');
			add_submenu_page("Bookings", "Booking Form", "Booking Form", $permission, "sm-booking-form.php", 'sm_booking_form');
		}
		
		add_submenu_page("Bookings", "Booking Form", "About", 'read', "sm-booking-about.php", 'sm_booking_about');
		
	}
}

function admin_register_head() {
	$siteurl = get_option('siteurl');
	$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/admin.css';
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery-1.4.2.min.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery-ui-1.8.1.custom.min.js';
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/jquery-ui-1.8.1.custom.css';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    //custom jquery
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/sm-script.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    //jquery plug-ins
    //1. tablesorter
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery.tablesorter.min.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    //2. pagination
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery.tablePagination.0.1.min.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
}

function public_register_head() {
	$siteurl = get_option('siteurl');
	$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/frontend.css';
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery-1.3.2.min.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery-ui-1.8.1.custom.min.js';
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/jquery-ui-1.8.1.custom.css';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    //custom jquery 
    $urlScript = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/sm-script.js';
    echo "<script type='text/javascript' src='$urlScript'></script>\n";    
}

add_action('wp_head','public_register_head');
add_action('admin_head', 'admin_register_head');
add_action('admin_menu', 'sm_booking_actions');

function load_sm_booking_dependencies() {
	include('sm-booking-functions.php');
	if ( !function_exists('wp_get_current_user') ) {
		function wp_get_current_user() {
		// Insert pluggable.php before calling get_currentuserinfo()
		require_once (ABSPATH . WPINC . '/pluggable.php');
		global $current_user;
		get_currentuserinfo();
		return $current_user;
		}
		$current_user = wp_get_current_user();
		$email = $current_user->user_email;
		sm_setup_database($email);
	}
}

?>
