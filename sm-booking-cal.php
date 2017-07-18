<?php

$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

//check if time is set in the URL
if(isset($_GET['time'])) {
	$time = $_GET['time'];
} else {
	$time = time();
}

$today = date("Y/n/j", time());

$current_month = date("n", $time);

$current_year = date("Y", $time);

$current_month_text = date("F Y", $time);

$total_days_of_current_month = date("t", $time);

$bookings = array();
$bookingsSummary = array();

global $wpdb;

$sql = "SELECT b.booking_id, b.firstname, b.surname, b.checkin_date, b.checkout_date, b.start_time, b.end_time, i.title FROM sm_booking as b JOIN sm_booking_item as i ON i.itemId = b.itemId WHERE b.checkin_date BETWEEN '$current_year/$current_month/01' AND '$current_year/$current_month/$total_days_of_current_month' ORDER BY b.checkin_date ";
//echo $sql;
$myrows = $wpdb->get_results( $sql );
foreach ($myrows as $row) {
	//Get the first day
	$start_date = $row->checkin_date;
	$start_day = substr($start_date,8,2);
	//Get the last day
	$end_date = $row->checkout_date;
	$end_day = substr($end_date,8,2);
	//Build the title
	$title = "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=sm-booking-view.php&id=" . $row->booking_id ."\" title=\"View More\">" . $row->title . "</a>";
	//Build the popup body
	if ($row->start_time != "" && $row->end_time != "") {
		$times = $row->start_time . " to " . $row->end_time;
	} else {
		$times = "Full Day";
	}
	$bookie = $row->firstname . " " . $row->surname;
	$body = "<p>Booked by " . $bookie . ".</p>";
	$body = $body . "<p>For " . $times . ". </p>";
	$counter = $start_day;
	while ( $counter <= $end_day ) {
		$bookings[$counter] .= '<li><span class="title">'.stripslashes($title).'</span><span class="desc">'.stripslashes($body).'</span></li>';
		$counter++;
	}
}
//print_r($bookings);
$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);

//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
$first_w_of_month = date("w", $first_day_of_month);

//how many rows will be in the calendar to show the dates
$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);

//trick to show empty cell in the first row if the month doesn't start from Sunday
$day = -$first_w_of_month;

$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
$next_month_text = date("F \'y", $next_month);

$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
$previous_month_text = date("F \'y", $previous_month);

$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
$next_year_text = date("F \'y", $next_year);

$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
$previous_year_text = date("F \'y", $previous_year);

?>

 <div class="wrap">
    <?php
    $bookurl = $url . '/images/calendar.png'; 
    echo "<h2>" . "<img src=\"" . $bookurl . "\" alt=\"book\" />" . __( 'Booking Overview Calendar', 'sm_booking_form' ) . "</h2>"; ?>
	<h3><?php echo $current_month_text?></h3>
	<table id="sm_booking_cal" cellspacing="0">
		<thead>
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
		</tr>
		</thead>
		<tr>
			<?php
			for($i=0; $i< $total_rows; $i++)
			{
				for($j=0; $j<7;$j++)
				{
					$day++;
					
					if($day>0 && $day<=$total_days_of_current_month)
					{
						//YYYY-MM-DD date format
						$date_form = "$current_year/$current_month/$day";
						
						echo '<td';
						
						//check if the date is today
						if($date_form == $today)
						{
							echo ' class="today"';
						}

						//check if any event stored for the date
						
						if(array_key_exists($day,$bookings))
						{
							//adding the date_has_event class to the <td> and close it
							echo ' class="date_has_event"> '.$day;
							//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
							echo '<div class="events"><ul>'.$bookings[$day].'</ul></div>';
						}
						else 
						{
							//if there is not event on that date then just close the <td> tag
							echo '> '.$day;
						}
						echo "</td>";
					}
					else 
					{
						//showing empty cells in the first and last row
						echo '<td class="padding">&nbsp;</td>';
					}
				}
				echo "</tr><tr>";
			}
			
			?>
		</tr>
		<tfoot>		
			<th>
				<a href="<?php echo $_SERVER['PHP_SELF']?>?page=sm-booking-cal.php&time=<?php echo $previous_year?>" title="<?php echo $previous_year_text?>">&laquo;&laquo;</a>
			</th>
			<th>
				<a href="<?php echo $_SERVER['PHP_SELF']?>?page=sm-booking-cal.php&time=<?php echo $previous_month?>" title="<?php echo $previous_month_text?>">&laquo;</a>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
				<a href="<?php echo $_SERVER['PHP_SELF']?>?page=sm-booking-cal.php&time=<?php echo $next_month?>" title="<?php echo $next_month_text?>">&raquo;</a>
			</th>
			<th>
				<a href="<?php echo $_SERVER['PHP_SELF']?>?page=sm-booking-cal.php&time=<?php echo $next_year?>" title="<?php echo $next_year_text?>">&raquo;&raquo;</a>
			</th>		
		</tfoot>
		</table>
 </div>
