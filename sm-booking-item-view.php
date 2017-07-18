<?php

$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

function sm_booking_item_details() {
    include('sm-booking-item-detail.php');
}

function sm_booking_item_edit() {
    include('sm-booking-item-edit.php');
}

function sm_booking_getbooking_items($url) {

global $wpdb;

$sql =   'SELECT i.itemId, i.title, it.type_name FROM sm_booking_item as i JOIN sm_item_type as it ON it.typeId = i.type ';
$myrows = $wpdb->get_results( $sql );

$output .= "\n <table id=\"table_bookings\" name=\"table_bookings\" cellspacing=\"1\" class=\"tablesorter booking_view\" summary=\"items table\">";
$output .= "\n <thead>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n Item Name";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Type";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </thead>";
$output .= "\n <tfoot>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n Item Name";
$output .= "\n </th>";
$output .= "\n <th>";
$output .= "\n Type";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </tfoot>";
$output .= "\n<tbody>";
foreach ($myrows as $row) {
    $output .= "\n <tr>";
    $output .= "\n     <td>";
    $output .= "\n <div><a href=\"" . $base_url . "?page=sm-booking-item-view.php&id=" . $row->itemId . "\" title=\"View booking detail\">" . $row->title . "</a></div>";
    $output .= "\n     </td>";
    $output .= "\n     <td>";
    $output .= "\n <div>" . $row->type_name . "</div>";
    $output .= "\n     </td>";
    $output .= "\n </tr>";
}
$output .= "\n</tbody>";
$output .= "\n </table>";
$output .= $post_HTML;
return $output;

}

add_action('sm_booking_item_details', 'admin_register_item_detail');

?>

<div class="wrap">
<?php
    $itemId = $_GET["id"];
    $edit = $_GET["edit"];
    if($edit=="true")
    {
       sm_booking_item_edit();
    }
    else if($itemId > 0 && $edit != "true")
    {
       sm_booking_item_details();
    }
    else 
    {
    $bookurl = $url . '/images/box-search-result.png'; 
    echo "<h2>" . "<img src=\"" . $bookurl . "\" alt=\"items\" />" . __( 'View Items', 'sm_booking_item' ) . "</h2>"; ?>
    <div>Below is a summary of all the items currently on the system.</div><br/>
<?php 
    echo sm_booking_getbooking_items($url);
    }
?>
 </div>
