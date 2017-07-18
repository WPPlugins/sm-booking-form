<?php

$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

function sm_booking_detail() {
    include('sm-booking-detail.php');
}

function sm_booking_getbookings($url) {

global $wpdb;

$sql =   'SELECT b.booking_id, b.approved, b.firstname, b.surname, b.checkin_date, b.checkout_date, b.no_adults, b.no_children, i.title FROM sm_booking as b JOIN sm_booking_item as i ON i.itemId = b.itemId ';
$myrows = $wpdb->get_results( $sql );

$output .= "\n <table id=\"table_bookings\" name=\"table_bookings\" cellspacing=\"1\" class=\"tablesorter booking_view ui-corner-all\" summary=\"booking table\">";
$output .= "\n <thead>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n Booked Item";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Approved";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Full Name";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Start Date";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n End Date";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Adults";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Children";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </thead>";
$output .= "\n <tfoot>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n Booked Item";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Approved";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Full Name";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Start Date";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n End Date";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Adults";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Children";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </tfoot>";

//$approved = "No";
$dclass = "NotApproved";

$output .= "\n<tbody>";
foreach ($myrows as $row) {
    if($row->approved==1)
    {
        $approved = "Yes";
        $approvedclass = "IsApproved";
    }
    else
    {
        $approved = "No";
        $approvedclass = "NotApproved";
    }
    $output .= "\n <tr>";
    $output .= "\n     <td>";
    $output .= "\n <div><a href=\"" . $base_url . "?page=sm-booking-view.php&id=" . $row->booking_id . "\" title=\"View booking detail\">" . $row->title . "</a></div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div class=\"" . $approvedclass . "\">" . $approved . " ";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->firstname . " ";
    $output .= $row->surname . "</div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->checkin_date . "</div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->checkout_date . "</div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->no_adults . "</div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->no_children . "</div>";
    $output .= "\n     </td>";
    $output .= "\n </tr>";
}
$output .= "\n</tbody>";
$output .= "\n </table>";
$output .= $post_HTML;
return $output;

}

add_action('sm_booking_detail', 'admin_register_detail');

?>

 <div class="wrap">
     <?php
     $bookingId = $_GET["id"];
     if($bookingId > 0)
     {
        sm_booking_detail();
     }
     else 
     {
     $bookurl = $url . '/images/book.png'; 
     echo "<h2>" . "<img src=\"" . $bookurl . "\" alt=\"book\" />" . __( 'View Bookings', 'sm_booking_form' ) . "</h2>"; ?>
     <div>Below is a summary of all the bookings currently on the system.</div><br/>
     <?php 
     echo sm_booking_getbookings($url);
     }
     ?>
 </div>
