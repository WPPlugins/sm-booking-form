 <?php
    global $wpdb;
    
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/';	   
        
    if($_POST['sm_booking_form_hidden'] == 'Y') {
        $itemid = $_POST['sm_booking_form_itemId'];
        $fname = $_POST['sm_booking_form_fname'];
        $surname = $_POST['sm_booking_form_surname'];
        $transref = 'booking_' . date('dmy') . rand(0,10) . substr($surname, 0, 2);
        
		$startdate =  $_POST['sm_booking_form_startdate'];
		$startdate1 = strtotime($startdate);
		$startdate2 = date('Y/n/j', $startdate1);
		
        $enddate = $_POST['sm_booking_form_enddate'];
		$enddate1 = strtotime($enddate);
		$enddate2 = date('Y/n/j', $enddate1);
		
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
		
		// First do a check to see if the booking already exists in the database.
		$check_sql = "SELECT * FROM sm_booking WHERE ('" . $startdate2 . "' BETWEEN checkin_date AND checkout_date OR '" . $enddate2 . "' BETWEEN checkin_date AND checkout_date) AND itemId = " . $itemid;
		$check_row = $wpdb->get_row( $check_sql );
		$check_result = count($check_row);
		
		if ($check_result > 0)
		{
			$SubmitMsg = "Your booking conflicts with another booking, please try different dates.";
		}
		else
		{		
			$data_array = array('transaction_reference'=>$transref,
								'itemId'=>$itemid,
								'firstname'=>$fname,
								'surname'=>$surname,
								'checkin_date'=>$startdate2,
								'checkout_date'=>$enddate2,
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
			$wpdb->insert( 'sm_booking',$data_array );
			
			Send_Booking_Email($email, $fname, $surname, $startdate, $enddate, 'requested');
			$SubmitMsg = "Your booking has been submitted, you should receive a confirmation email shortly.";
		}
?>
    <div id="sm_submit" class="updated"><div><strong><?php _e($SubmitMsg); ?></strong></div></div>
<?php } ?>    
<div class="wrap">
<div class="booking_form_wrap">
    <?php    echo "<h2>" . __( 'Booking Form', 'sm_booking_form' ) . "</h2>"; ?>
	<p>Use the form below to make your booking.</p>
    <form id="sm_booking_form_form" name="sm_booking_form_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="sm_booking_form_hidden" value="Y">
        <div class="span-15">
        <div class="span-5">Select an Item</div>
        <div class="span-10 last">
            <select name="sm_booking_form_itemId" id="sm_booking_form_itemId" class="ui-corner-all">
            <option value=""><?php echo attribute_escape(__('Select Item')); ?></option>
                <?php echo sm_booking_getitemtitles(); ?>
            </select><span id="val_sm_booking_form_itemId" name="val_sm_booking_form_itemId" class="sm_form_notify_default">*</span>
            <img id="ItemInfo" src="<?php echo $url ?>information.png" alt="information" />
            <div id="itemDetails">
                <?php echo sm_booking_geitemdetails(); ?>
            </div>
        </div>
        </div>
        <hr/>
        <div class="span-21 sm_white_background">
        <div class="span-5"><?php _e("First Name: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_fname" name="sm_booking_form_fname" value="" size="15" class="ui-corner-all"><span id="val_sm_booking_form_fname" name="val_sm_booking_form_fname" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Surname: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_surname" name="sm_booking_form_surname" value="" size="15" class="ui-corner-all"><span id="val_sm_booking_form_surname" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Contact Number: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_phonenumber" name="sm_booking_form_phonenumber" value="" size="20" class="ui-corner-all"><span id="val_sm_booking_form_phonenumber" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Contact Email: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_email" name="sm_booking_form_email" value="" size="20" class="ui-corner-all"><span id="val_sm_booking_form_email" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Address: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_addln1" name="sm_booking_form_addln1" value="" size="20" class="ui-corner-all"><span id="val_sm_booking_form_addln1" class="sm_form_notify_default">*</span></div>
        <div class="span-5">&nbsp;</div><div class="span-15 last"><input type="text" id="sm_booking_form_addln2" name="sm_booking_form_addln2" value="" size="20" class="ui-corner-all"></div>
        <div class="span-5"><?php _e("County/State: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_countystate" name="sm_booking_form_countystate" value="" size="15" class="ui-corner-all"><span id="val_sm_booking_form_countystate" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Country: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_country" name="sm_booking_form_country" value="" size="15" class="ui-corner-all"><span id="val_sm_booking_form_country" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Postal Code: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_postalcode" name="sm_booking_form_postalcode" value="" size="10" class="ui-corner-all"><span id="val_sm_booking_form_postalcode" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Start Date: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_startdate" name="sm_booking_form_startdate" value="" size="10" class="ui-corner-all"> <?php _e("Start Time: " ); ?>
		<input type="text" id="sm_booking_form_starttime" name="sm_booking_form_starttime" value="" size="5"><span id="val_sm_booking_form_startdate" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("End Date: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_enddate" name="sm_booking_form_enddate" value="" size="10" class="ui-corner-all"> <?php _e("End Time: " ); ?><input type="text" id="sm_booking_form_endtime" name="sm_booking_form_endtime" value="" size="5"><span id="val_sm_booking_form_enddate" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Number of Adults: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_noadults" name="sm_booking_form_noadults" value="" size="1" class="ui-corner-all"><span id="val_sm_booking_form_noadults" class="sm_form_notify_default">*</span></div>
        <div class="span-5"><?php _e("Number of Children: " ); ?></div><div class="span-15 last"><input type="text" id="sm_booking_form_nochildren" name="sm_booking_form_nochildren" value="" size="1" class="ui-corner-all"></div>
		<br/>
        <div class="submit span-15">
        <input id="smSubmit" name="smSubmit" type="submit" name="Submit" value="<?php _e('Submit Booking', 'sm_booking_form_submit' ) ?>" class="ui-corner-all" /><span id="sm_error_count"></span>
        </div>
        </div>
    </form>
</div>
</div>