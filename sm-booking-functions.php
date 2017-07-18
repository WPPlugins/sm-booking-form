<?php
$arrOptions = get_option('sm_booking_form');
$sysemailfrom = $arrOptions['sm_booking_form_sysemailfrom'];
//Send a email with booking start and end times. Will send different message depending on whether the notification_type variable is set to 'requested' or 'approved'.
function Send_Booking_Email($email, $fname, $surname, $startdate, $enddate, $notification_type) {
    $to = $email;
    
    if ($notification_type == "requested") {
		$subject = "Your booking request";
        $message = "Dear " . $fname . " " . $surname . ", \n\nA booking request has been made for " . $startdate . " to " . $enddate . ". \n\nYour booking will be confirmed by a Gatekeeper. \n\nYours Sincerely, \n\n". $sysemailfrom;
    }
    
    if ($notification_type == "approved") {
        $subject = "Your booking is now approved";
        $message = "Dear " . $fname . " " . $surname . ", \n\nYour booking request for the dates " . $startdate . " to " . $enddate . " \nhave been approved. \n\nYours Sincerely, \n\n". $sysemailfrom;
    }
    
    wp_mail( $to, $subject, $message );
}
//Get item titles and output them in a list.
function sm_booking_getitemtitles($item) {
	global $wpdb;
	$sql = "SELECT i.itemID, i.title FROM sm_booking_item as i";
	$results = $wpdb->get_results( $sql );
	
	foreach ($results as $row) {
		if ($item == $row->itemID) {
			$output .= "\n <option value=\"" . $row->itemID . "\" selected>" . $row->title . "</option>";
		} else {
			$output .= "\n <option value=\"" . $row->itemID . "\">" . $row->title . "</option>";
		}
	}
	
	return $output;
}

//Get and output item summary.
function sm_booking_geitemdetails() {
	global $wpdb;
	$sql = "SELECT i.itemId, i.title, i.description, i.addressln1, i.addressln2, i.citytown, i.countystate, i.postalcode, i.notes, i.statistics, i.image_name FROM sm_booking_item as i";
	$results = $wpdb->get_results( $sql );
	
	foreach ($results as $row) {
		$output .= "\n <div id=\"item_" . $row->itemId . "\" class=\"hide\">";
		$output .= "\n <h4>" . $row->title . "</h4>";
		$output .= "\n <div id=\"BookingFormItemDetailLeftColumn\">";
		$output .= "\n <img src=\"" . $row->image_name . "\" alt=\"Item Image\" />";
		$output .= "\n <div><strong>Description: </strong>" . $row->description . "</div>";
		$output .= "\n <div><strong>Notes: </strong>" . $row->notes . "</div>";
		$output .= "\n <div><strong>Statistics: </strong>" . $row->statistics . "</div>";
		$output .= "\n </div>";
		$output .= "\n <div>";
		$output .= "\n <div><strong>Address: </strong></div>";
		$output .= "\n <div>" . $row->addressln1 . "</div>";
		$output .= "\n <div>" . $row->addressln2 . "</div>";
		$output .= "\n <div>" . $row->citytown . "</div>";
		$output .= "\n <div>" . $row->countystate . "</div>";
		$output .= "\n <div>" . $row->postalcode . "</div>";
		$output .= "\n </div>";
		$output .= "\n </div>";
	}
	
	return $output;
}

function sm_setup_database($userEmail) {
	global $wpdb;
	$table_name = "sm_booking";	
	$sql = "CREATE TABLE " . $table_name . " (
				booking_id int(11) NOT NULL AUTO_INCREMENT,
				transaction_reference varchar(250) NOT NULL,
				Approved tinyint(1) NOT NULL,
				itemId int(11) NOT NULL,
				firstname varchar(50) NOT NULL,
				surname varchar(50) NOT NULL,
				checkin_date DATE NOT NULL,
				checkout_date DATE NOT NULL,
				start_time varchar(5) NOT NULL,
				end_time varchar(5) NOT NULL,
				no_adults int(11) NOT NULL,
				no_children int(11) NOT NULL,
				address_line1 varchar(250) NOT NULL,
				address_line2 varchar(250) DEFAULT NULL,
				county_state varchar(250) NOT NULL,
				postal_code varchar(50) NOT NULL,
				country varchar(250) NOT NULL,
				phone_number varchar(50) NOT NULL,
				email varchar(250) NOT NULL,
				PRIMARY KEY  (booking_id),
				KEY booking_id (booking_id)
			);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	$table_name = "sm_booking_item";
	$sql = "CREATE TABLE " . $table_name . " (
				itemId int(11) NOT NULL AUTO_INCREMENT,
				title varchar(50) NOT NULL,
				description varchar(250) NOT NULL,
				notes varchar(250) NOT NULL,
				type int(11) NOT NULL,
				statistics varchar(250) NOT NULL,
				image_name varchar(250) NOT NULL,
				AddressLn1 varchar(250) NOT NULL,
				AddressLn2 varchar(250) NOT NULL,
				CityTown varchar(50) NOT NULL,
				CountyState varchar(50) NOT NULL,
				PostalCode varchar(50) NOT NULL,
				PRIMARY KEY (itemId),
				KEY itemId (itemId)
			);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	$table_name = "sm_item_type";	
	$sql = "CREATE TABLE " . $table_name . " (
				typeId int(11) NOT NULL AUTO_INCREMENT,
				type_name varchar(50) NOT NULL,
				PRIMARY KEY  (typeId),
				KEY typeId (typeId)
			);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
		
	$table_name = "sm_user_role";
	$sql = "CREATE TABLE " . $table_name . " (
				sm_role_id int(11) NOT NULL AUTO_INCREMENT,
				role_name varchar(250) NOT NULL,
				PRIMARY KEY  (sm_role_id),
				KEY sm_role_id (sm_role_id)
			);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);	
	$wpdb->insert( $table_name, array( 'sm_role_id' => '1', 'role_name' => 'Gatekeeper' ) );
	$wpdb->insert( $table_name, array( 'sm_role_id' => '2', 'role_name' => 'Administrator' ) );
	
	$table_name = "sm_users";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
					sm_user_id int(11) NOT NULL AUTO_INCREMENT,
					sm_role_id int(11) NOT NULL,
					email_address varchar(150) NOT NULL,
					PRIMARY KEY  (sm_user_id),
					KEY sm_user_id (sm_user_id)
				);";
	}
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	$wpdb->insert( $table_name, array( 'sm_user_id' => '1', 'sm_role_id' => '2', 'email_address' => $userEmail ) );
	$wpdb->insert( $table_name, array( 'sm_user_id' => '2', 'sm_role_id' => '1', 'email_address' => $userEmail ) );
	
	// Get Options
	$arrOptions = get_option('sm_booking_form');
	$sysemailfrom = $arrOptions['sm_booking_form_sysemailfrom'];
	$googlemapskey = $arrOptions['sm_booking_form_googlemapskey'];
	$sm_booking_version = $arrOptions['Version'];
	// Set Options
	$arrOptions['sm_booking_form_sysemailfrom'] = $sysemailfrom;
	$arrOptions['sm_booking_form_googlemapskey'] = $googlemapskey;
	$arrOptions['Version'] = "1.3.1";
	update_option('sm_booking_form', $arrOptions);
}

?>