<?php
$siteurl = get_option('siteurl');

function sm_booking_edit(){
	include('sm-booking-edit.php');
}

function sm_booking_delete() {
	include('sm-booking-del.php');
}

function dateDiff($date1, $date2, $round=true) {
$date1Array = explode('/', $date1);
$date1Epoch = mktime(0, 0, 0, $date1Array[1],
$date1Array[0], $date1Array[2]);

$date2Array = explode('/', $date2);
$date2Epoch = mktime(0, 0, 0, $date2Array[1],
$date2Array[0], $date2Array[2]);

$date_diff = $date2Epoch - $date1Epoch;
return round($date_diff / 60 / 60 / 24)+1; 
}
function sm_booking_getbookingdetail() {
global $wpdb;
$isapproved = $_GET["approve"];
$bookingId = $_GET["id"];
if ($isapproved=="true")
{
$wpdb->update('sm_booking', array( 'approved'=>'1' ), array( 'booking_id'=>$bookingId ) );
Send_Booking_Email($email, $fname, $surname, $startdate, $enddate, 'approved');
}
else if ($isapproved=="false")
{
$wpdb->update('sm_booking', array( 'approved'=>'0' ), array( 'booking_id'=>$bookingId ) );
}
$sql = 'SELECT b.booking_id, b.approved, b.transaction_reference, b.firstname, b.surname, b.checkin_date, b.checkout_date, b.no_adults, b.no_children, b.address_line1, b.address_line2, b.county_state, b.postal_code, b.country, b.phone_number, b.email, i.title, i.itemId, i.image_name FROM sm_booking as b JOIN sm_booking_item as i ON i.itemId = b.itemId WHERE b.booking_id = ' . $bookingId;
$row = $wpdb->get_row( $sql );
$approved = "Approved";
$approvedclass = "NotApproved";
$bookingId = $row->booking_id;
$startdate = date('d/m/Y',strtotime($row->checkin_date));
$enddate = date('d/m/Y',strtotime($row->checkout_date));
$duration = dateDiff($startdate,$enddate);
$fname = $row->firstname;
$surname = $row->surname;
$email = $row->email;
$itemImage = $row->image_name;
$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));
if ($duration > 1) {
    $strday = " days";
}
else {
    $strday = " day";
}
if($row->approved==1)
{
    $approved = "Approved";
    $approvedclass = "IsApproved";
}
else
{
    $approved = "Not Approved";
    $approvedclass = "NotApproved";
}
$output .= "\n<div>This booking is <span class=\"" . $approvedclass . "\">" . $approved . "</span>.</div>";
$output .= "\n<br/>";
$output .= "\n    <ul class=\"sm_navigation\">";
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/';
if($approvedclass=="NotApproved")
{
    $output .= "\n    <li><a href=\"?page=sm-booking-view.php&id=" . $bookingId . "&approve=true\" class=\"sm_button ui-corner-all\"><img src=\"".$url."book--plus.png\" alt=\">\"/> Approve Booking</a></li>";
}
else
{
    $output .= "\n    <li><a href=\"?page=sm-booking-view.php&id=" . $bookingId . "&approve=false\" class=\"sm_button ui-corner-all\"><img src=\"".$url."book--minus.png\" alt=\">\"/> Decline Booking</a></li>";
}
$output .= "\n    <li><a href=\"?page=sm-booking-view.php&id=" . $bookingId . "&action=edit\" class=\"sm_button ui-corner-all\"><img src=\"".$url."book--pencil.png\" alt=\">\"/> Edit Booking</a></li>";
$output .= "\n    <li><a href=\"?page=sm-booking-view.php&id=" . $bookingId . "&action=delete\" class=\"sm_button ui-corner-all\"><img src=\"".$url."book--minus.png\" alt=\">\"/> Delete Booking</a></li>";
$output .= "\n</ul>";
$output .= "\n<br/>";
$output .= "\n<h3>" . $row->title . "</h3>";
if ($itemImage != "") {
        $output .= "\n <img class=\"booking_detail_image\" src=\"" . $itemImage . "\" alt=\"Item Image\"/>";
}
$output .= "\n <table id=\"table_bookingdetail\" summary=\"Booking detail\">";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Item #  </td><td>" . $row->itemId . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Transaction # </td><td>" . $row->transaction_reference. "  </td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Booking for: </td><td>" . $startdate . " to " . $enddate . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Duration: </td><td>" . $duration . $strday . "</td>";
$output .= "<tr>";
$output .= "</table>";
$output .= "\n <hr/>";
$output .= "\n <h3>Bookie Contact Details</h3>";
$output .= "\n <table id=\"table_bookingdetail\" summary=\"Booking detail\">";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Surname: </td><td>" . $surname . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Firstname: </td><td>" . $fname . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Address: </td><td>" . $row->address_line1 . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">&nbsp;</td><td>" . $row->address_line2 . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">&nbsp;</td><td>" . $row->county_state . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">&nbsp;</td><td>" . $row->postal_code . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Country: </td><td>" . $row->country . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Phone number: </td><td> " . $row->phone_number . "</td>";
$output .= "</tr>";
$output .= "<tr>";
$output .= "\n <td class=\"booking_head\">Email: </td><td>" . $email . "</td>";
$output .= "</tr>";
$output .= "</table>";

return $output;
}
?>
<div class="wrap">  
    <?php
		$action = $_GET["action"];
		switch ($action) {
			case "edit":
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/book--pencil.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\"book\" />" . __( 'Edit Booking', 'sm_booking_form' ) . "</h2>";
				sm_booking_edit();
				break;
			case "delete":
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/book--minus.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\">\" />" . __( 'Delete Booking', 'sm_booking_form' ) . "</h2>";
				sm_booking_delete();
				break;
			default:
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/book-open.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\"book\" />" . __( 'Booking Detail', 'sm_booking_form' ) . "</h2>";
				echo "<br/>" . sm_booking_getbookingdetail();
				break;
		}
	?>
</div>
