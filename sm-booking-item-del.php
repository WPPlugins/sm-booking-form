<?php	global $wpdb;
	$id = $_GET["id"];
	if ($id < 0) {
		echo "<div class=\"\">No Item Id provided, go to <strong>View Items</strong> on the menu</div>.";
	} else {
		$sql = "DELETE FROM sm_booking_item WHERE itemId = " . $id;
		$wpdb->query($sql);
		echo "<div class=\"\">The item has been deleted.</div>";
	}
?>