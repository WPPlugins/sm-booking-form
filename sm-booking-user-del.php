<?php
	global $wpdb;
	$id = $_GET["id"];
	if ($id < 0) {
		echo "<div class=\"\">No User Id provided, go to <strong>View Users</strong> on the menu</div>.";
	} else {
		$sql = "DELETE FROM sm_users WHERE sm_user_id = " . $id;
		$wpdb->query($sql);
		echo "<div class=\"\">The item has been deleted.</div>";
	}
?>