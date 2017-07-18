<?php

$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

function sm_booking_user_edit() {
    include('sm-booking-user-edit.php');
}

function sm_booking_user_delete() {
	include('sm-booking-user-del.php');
}

function sm_booking_getusers($url) {

global $wpdb;

$sql =   'SELECT ur.role_name, u.sm_user_id, u.email_address FROM sm_users as u JOIN sm_user_role as ur ON ur.sm_role_id = u.sm_role_id ';
$myrows = $wpdb->get_results( $sql );

$output .= "\n <table id=\"table_bookings\" name=\"table_bookings\" cellspacing=\"1\" class=\"tablesorter booking_view\" summary=\"items table\">";
$output .= "\n <thead>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n User Email";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Permission";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Delete";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </thead>";
$output .= "\n <tfoot>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n User Email";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Permission";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Delete";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </tfoot>";
$output .= "\n<tbody>";
foreach ($myrows as $row) {
    $output .= "\n <tr>";
    $output .= "\n     <td>";
    $output .= "\n <div><a href=\"" . $base_url . "?page=sm-booking-user-view.php&id=" . $row->sm_user_id . "&action=edit\" title=\"Edit User Permission\">" . $row->email_address . "</a></div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->role_name . "</div>";
    $output .= "\n     </td>";
	$output .= "\n <td>";
	$output .= "\n <div><a href=\"" . $base_url . "?page=sm-booking-user-view.php&id=" . $row->sm_user_id . "&action=delete\" title=\"Delete User Permission\" class=\"sm_delete_button\">Delete</a></div>";
	$output .= "\n </td>";
    $output .= "\n </tr>";
}
$output .= "\n</tbody>";
$output .= "\n </table>";
$output .= $post_HTML;
return $output;

}

?>

<div class="wrap">
<?php
    $itemId = $_GET["id"];
	$action = $_GET["action"];
	
	switch ($action) {
			case "edit":
				sm_booking_user_edit();
				break;
			case "delete":
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/user--minus.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\">\" />" . __( 'Delete User Permissions', 'sm_booking_form' ) . "</h2>";
				sm_booking_user_delete();
				break;
			default:
				$userurl = $url . '/images/users.png'; 
				echo "<h2>" . "<img src=\"" . $userurl . "\" alt=\"items\" />" . __( 'View Users', 'sm_booking_item' ) . "</h2>";
				echo "<p>Below is a summary of all the users currently assigned permissions on the booking system.</p>";
				echo "<p>Permissions are based on the Wordpress users email address, which is set in the \"<strong>Your Profile</strong>\" section of the Wordpress Dashboard.</p>";
				echo sm_booking_getusers($url);
				break;
		}
?>
</div>