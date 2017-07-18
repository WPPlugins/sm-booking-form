<?php
    function sm_booking_getbookingedit() {
        global $wpdb;
        $siteurl = get_option('siteurl');
        $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));
        $bookingId = $_GET["id"];
        $sql = 'SELECT b.booking_id, b.approved, b.transaction_reference, b.firstname, b.surname, b.checkin_date, b.checkout_date, b.start_time, b.end_time, b.no_adults, b.no_children, b.address_line1, b.address_line2, b.county_state, b.postal_code, b.country, b.phone_number, b.email, i.title, i.itemId, i.image_name FROM sm_booking as b JOIN sm_booking_item as i ON i.itemId = b.itemId WHERE b.booking_id = ' . $bookingId;
        $row = $wpdb->get_row( $sql );
        $output .= "\n<table id=\"Edit_Booking\">";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_transref\">Transaction Ref.</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_transref\" name=\"sm_booking_form_transref\" value=\"".$row->transaction_reference."\"/></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_startdate\">Start Date</label></td>";
		$output .= "\n    <td><input type=\"text\" id=\"sm_booking_form_startdate\" name=\"sm_booking_form_startdate\" value=\"".$row->checkin_date."\"/></td>";
		$output .= "\n    <td><label for=\"sm_booking_form_starttime\">Start Time</label></td>";
		$output .= "\n    <td><input type=\"text\" id=\"sm_booking_form_starttime\" name=\"sm_booking_form_starttime\" value=\"".$row->start_time."\"/><span id=\"val_sm_booking_form_startdate\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_enddate\">End Date</label></td>";
		$output .= "\n    <td><input type=\"text\" id=\"sm_booking_form_enddate\" name=\"sm_booking_form_enddate\" value=\"".$row->checkout_date."\"/></td>";
		$output .= "\n    <td><label for=\"sm_booking_form_endtime\">End Time</label></td>";
		$output .= "\n    <td><input type=\"text\" id=\"sm_booking_form_endtime\" name=\"sm_booking_form_endtime\" value=\"".$row->end_time."\"/><span id=\"val_sm_booking_form_enddate\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_fname\">First Name</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_fname\" name=\"sm_booking_form_fname\" value=\"".$row->firstname."\"/><span id=\"val_sm_booking_form_fname\" name=\"val_sm_booking_form_fname\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_surname\">Surname</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_surname\" name=\"sm_booking_form_surname\" value=\"".$row->surname."\"/><span id=\"val_sm_booking_form_surname\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_phonenumber\">Contact Number</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_phonenumber\" name=\"sm_booking_form_phonenumber\" value=\"".$row->phone_number."\"/><span id=\"val_sm_booking_form_phonenumber\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_email\">Email</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_email\" name=\"sm_booking_form_email\" value=\"".$row->email."\"/><span id=\"val_sm_booking_form_email\"></span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_addln1\">Address</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_addln1\" name=\"sm_booking_form_addln1\" value=\"".$row->address_line1."\"/><span id=\"val_sm_booking_form_addln1\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_addln2\">&nbsp;</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_addln2\" name=\"sm_booking_form_addln2\" value=\"".$row->address_line2."\"/></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_countystate\">County/State</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_countystate\" name=\"sm_booking_form_countystate\" value=\"".$row->county_state."\"/><span id=\"val_sm_booking_form_countystate\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_postalcode\">Post Code</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_postalcode\" name=\"sm_booking_form_postalcode\" value=\"".$row->postal_code."\"/><span id=\"val_sm_booking_form_postalcode\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_country\">County</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_country\" name=\"sm_booking_form_country\" value=\"".$row->country."\"/><span id=\"val_sm_booking_form_country\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_noadults\">Number of Adults</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_noadults\" name=\"sm_booking_form_noadults\" value=\"".$row->no_adults."\"/><span id=\"val_sm_booking_form_noadults\" class=\"sm_form_notify_default\">*</span></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_nochildren\">Number of Children</label></td>";
		$output .= "\n    <td colspan=\"3\"><input type=\"text\" id=\"sm_booking_form_nochildren\" name=\"sm_booking_form_nochildren\" value=\"".$row->no_children."\"/></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td><label for=\"sm_booking_form_itemId\">Booked Item</label></td>";
		$output .= "\n    <td colspan=\"3\">";
		$output .= "\n        <select name=\"sm_booking_form_itemId\" id=\"sm_booking_form_itemId\">";
		$output .= "\n        <option value=\"\">" . attribute_escape(__('Select Item')) . "</option>";
		$output .= "\n            " . sm_booking_getitemtitles($row->itemId);
		$output .= "\n        </select><span id=\"val_sm_booking_form_itemId\" name=\"val_sm_booking_form_itemId\" class=\"sm_form_notify_default\">*</span>";
		$output .= "\n    </td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td></td>";
		$output .= "\n    <td colspan=\"3\"></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td></td>";
		$output .= "\n    <td colspan=\"3\"></td>";
		$output .= "\n</tr>";
		$output .= "\n<tr>";
		$output .= "\n    <td></td>";
		$output .= "\n    <td colspan=\"3\"></td>";
		$output .= "\n</tr>";
		$output .= "\n</table>";
        
        return $output;
    }
    global $wpdb;
    if($_POST['sm_booking_hidden'] == 'Y') {		
		$itemid = $_POST['sm_booking_form_itemId'];
		$tansref = $_POST['sm_booking_form_transref'];
        $fname = $_POST['sm_booking_form_fname'];
        $surname = $_POST['sm_booking_form_surname'];
        $transref = 'booking_' . date('dmy') . rand(0,10) . substr($surname, 0, 2);
        $startdate =  date('Y/m/d', strtotime($_POST['sm_booking_form_startdate']));
        $enddate = date('Y/m/d', strtotime($_POST['sm_booking_form_enddate']));
        $starttime = $_POST['sm_booking_form_starttime'];
        $endtime = $_POST['sm_booking_form_endtime'];
        $noadults = $_POST['sm_booking_form_noadults'];
        $nochild = $_POST['sm_booking_form_nochildren'];
        $addln1 = $_POST['sm_booking_form_addln1'];
        $addln2 = $_POST['sm_booking_form_addln2'];
        $county_state = $_POST['sm_booking_form_countystate'];
        $postal_code = $_POST['sm_booking_form_postalcode'];
        $country = $_POST['sm_booking_form_country'];
        $phone_number = $_POST['sm_booking_form_phonenumber'];
        $email = $_POST['sm_booking_form_email'];
        $data_array = array('transaction_reference'=>$transref,
                            'itemId'=>$itemid,
                            'firstname'=>$fname,
                            'surname'=>$surname,
                            'checkin_date'=>$startdate,
                            'checkout_date'=>$enddate,
                            'start_time'=>$starttime,
                            'end_time'=>$endtime,
                            'no_adults'=>$noadults,
                            'no_children'=>$nochild,
                            'address_line1'=>$addln1,
                            'address_line2'=>$addln2,
                            'county_state'=>$county_state,
                            'postal_code'=>$postal_code,
                            'country'=>$country,
                            'phone_number'=>$phone_number,
                            'email'=>$email
                            );
		$where_array = array('booking_id' => $_GET["id"]);
        $wpdb->update( 'sm_booking',$data_array, $where_array );
        //$wpdb->print_errors();
?>
    <div class="updated"><div><strong><?php _e('Booking Saved.' ); ?></strong></div></div>
<?php } ?>
<div class="wrap"> 
<?php
    $edit = $_GET["edit"];
    if($edit=="true")
    {    
        $siteurl = get_option('siteurl');
        $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/book_open.png';
        echo "<h2>" . "<img src=\"" . $url . "\" alt=\"book\" />" . __( 'Edit Booking', 'sm_booking_edit' ) . "</h2>";
    }
?>
<br/>
<form id="sm_booking_form_form" name="sm_booking_form_form" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
     <?php echo sm_booking_getbookingedit(); ?>
     <input type="hidden" name="sm_booking_hidden" value="Y">
     <input id="smSubmit" name="smSubmit" type="submit" name="Submit" value="<?php _e('Submit Booking', 'sm_booking_form_submit' ) ?>" class="ui-corner-all" /><span id="sm_error_count"></span>
</form>
</div>   