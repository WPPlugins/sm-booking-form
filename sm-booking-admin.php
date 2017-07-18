<?php 
	$sm_booking_version = "1.3.1";
?>
 <?php
    if($_POST['sm_booking_form_hidden'] == 'Y') {
        //sent        
		$sysemailfrom = $_POST['sm_booking_form_sysemailfrom'];
		$googlemapskey = $_POST['sm_booking_form_googlemapskey'];
		$arrOptions['sm_booking_form_sysemailfrom'] = $sysemailfrom;
		$arrOptions['sm_booking_form_googlemapskey'] = $googlemapskey;
		$arrOptions['Version'] = $sm_booking_version;
		update_option('sm_booking_form', $arrOptions);
?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php
    } else {
		$arrOptions = get_option('sm_booking_form');
		$sysemailfrom = $arrOptions['sm_booking_form_sysemailfrom'];
		$googlemapskey = $arrOptions['sm_booking_form_googlemapskey'];
    }
 
 ?>
 <div class="wrap">
     <?php    echo "<h2>" . __( 'SM Booking Plugin Settings', 'sm_booking_form' ) . "</h2>"; ?>
     <p>You are running Version <strong><?php echo $sm_booking_version; ?></strong> of the booking plugin.</p>
     <form name="sm_booking_form_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
         <input type="hidden" name="sm_booking_form_hidden" value="Y">  
		 <div id="sm_accordian">
			<?php    echo "<h3><a href=\"#\">" . __( 'Email settings', 'sm_booking_form' ) . "</h3></a>"; ?>
			 <div>
				<p>Edit default email settings</p>
				<p><?php _e("System Email from: " ); ?><input type="text" name="sm_booking_form_sysemailfrom" value="<?php echo $sysemailfrom; ?>" size="20"><?php _e(" ex: John Smith" ); ?></p>
			 </div>
			 <?php    echo "<h3><a href=\"#\">" . __( 'Google Maps key', 'sm_booking_form' ) . "</h3></a>"; ?>
			 <div>
				<p>Add your sites Google Maps API key</p>
				<p><?php _e("Google Maps API key: " ); ?><input type="text" name="sm_booking_form_googlemapskey" value="<?php echo $googlemapskey; ?>" size="20"></p>
                <p>Google maps key may be obtained from the following link: <a href="http://code.google.com/apis/maps/signup.html" target="_blank" title="Get Key">Get API Key</a> (it's free).
			 </div>
			 <?php    //echo "<h3><a href=\"#\">" . __( 'Database settings', 'sm_booking_form' ) . "</a></h3>"; ?>
			 <!--div>
				 <p>Use these settings if you want to use a seperate database to Wordpress.</p>
				 <p><?php _e("Database host: " ); ?><input type="text" name="sm_booking_form_dbhost" value="<?php echo $dbhost; ?>" size="20"><?php _e(" ex: localhost" ); ?></p>
				 <p><?php _e("Database name: " ); ?><input type="text" name="sm_booking_form_dbname" value="<?php echo $dbname; ?>" size="20"><?php _e(" ex: oscommerce_shop" ); ?></p>  
				 <p><?php _e("Database user: " ); ?><input type="text" name="sm_booking_form_dbuser" value="<?php echo $dbuser; ?>" size="20"><?php _e(" ex: root" ); ?></p>  
				 <p><?php _e("Database password: " ); ?><input type="text" name="sm_booking_form_dbpwd" value="<?php echo $dbpwd; ?>" size="20"><?php _e(" ex: secretpassword" ); ?></p> 
			 </div-->
		 </div>
         <p class="submit">  
         <input type="submit" name="Submit" value="<?php _e('Update Options', 'sm_booking_form_trdom' ) ?>" />  
         </p>  
     </form>
 </div>
 <?php
 function tableExists($tablename) {

	// Get a list of tables contained within the database.
	$result = mysql_list_tables("DBNAME");
	$rcount = mysql_num_rows($result);

	// Check each in list for a match.
	for ($i=0;$i<$rcount;$i++) {
		if (mysql_tablename($result, $i)==$tablename) return true;
	}
	return false;
}
 ?>
