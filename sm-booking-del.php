<?php	global $wpdb;
	$id = $_GET["id"];
	if ($id < 0) {
		echo "<div class=\"\">No Booking Id provided, go to <strong>View Bookings</strong> on the menu</div>.";
	} else {
		$sql = "DELETE FROM sm_booking WHERE booking_id = " . $id;
		$wpdb->query($sql);
		echo "<div class=\"\">The booking has been deleted.</div>";
	}
?>