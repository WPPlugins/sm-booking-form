 <?php
 
    function sm_booking_delete() {
		include('sm-booking-item-del.php');
	}

	$siteurl = get_option('siteurl');
    global $wpdb;
	$edit = $_GET["edit"];
            
    function sm_booking_getitemdetails() {
        global $wpdb;
        $siteurl = get_option('siteurl');        
		$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/';
        $itemId = $_GET["id"];
        $sql = "SELECT i.title, i.description, i.notes, i.statistics, i.image_name, i.AddressLn1, i.AddressLn2, i.CityTown, i.CountyState, i.PostalCode FROM sm_booking_item as i Where i.itemId = " . $itemId;
        $results = $wpdb->get_results( $sql );
		echo $edit;
		
        foreach ($results as $row) {
            $itemImage = $row->image_name;
			$output .= "\n    <ul class=\"sm_navigation\">";
			$output .= "<li><a href=\"" . $base_url . "?page=sm-booking-item-view.php&id=" . $itemId . "&action=edit\" title=\"Edit this item\" class=\"sm_button ui-corner-all\"><img src=\"".$url."box--pencil.png\" alt=\">\"/> Edit Item</a></li>";
			$output .= "<li><a href=\"" . $base_url . "?page=sm-booking-item-view.php&id=" . $itemId . "&action=delete\" title=\"Delete this item\" class=\"sm_button ui-corner-all\"><img src=\"".$url."box--pencil.png\" alt=\">\"/> Delete Item</a></li>";
			$ouput .= "\n    </ul>";
            $output .= "\n <table id=\"Item_Details\" name=\"Item_Details\" summary=\"Item Detail\">";
            $output .= "\n <tr>";
            $output .= "\n <td id=\"Item_Image\" rowspan=\"9\">";
            if ($itemImage != "") {
            $output .= "\n <div id=\"Image_Container\"><img src=\"" . $itemImage . "\" alt=\"Item Image\"/></div>";
            }
            $output .= "\n </td>";
            $output .= "\n <td>";
            $output .= "\n <h3>" . $row->title . "</h3>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
			$output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <h4>Location</h4>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
			$output .= "\n <tr>";
			$output .= "\n <td>";
			$output .= "\n <div id=\"ItemAddress\">";
			$output .= "\n <div>" . $row->AddressLn1 . "</div>";
			$output .= "\n <div>" . $row->AddressLn2 . "</div>";
			$output .= "\n <div>" . $row->CityTown . "</div>";
			$output .= "\n <div>" . $row->CountyState . "</div>";
			$output .= "\n <div>" . $row->PostalCode . "</div>";
			$output .= "\n </div>";
            if ( $googlemapskey != "" ) {
                $output .= "\n <div id=\"ItemMap\">";
                $output .= "\n     <div id=\"map\"></div>";
                $output .= "\n </div>";
            }
			$output .= "<script type=\"text/javascript\">usePointFromPostcode('" . $row->PostalCode . "', placeMarkerAndCenterToPoint);</script>";
			$output .= "\n </td>";
			$output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <h4>Description</h4>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <div>" . $row->description . "</div>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <h4>Notes</h4>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <div>" . $row->notes . "</div>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <h4>Statistics</h4>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n <tr>";
            $output .= "\n <td>";
            $output .= "\n <div>" . $row->statistics . "</div>";
            $output .= "\n </td>";
            $output .= "\n </tr>";
            $output .= "\n </table>";
        }
        
        return $output;
    }
    
    add_action('sm_booking_item_edit', 'admin_register_item_edit');
    
?>
<?php
	$arrOptions = get_option('sm_booking_form');
	$googlemapskey = $arrOptions['sm_booking_form_googlemapskey'];
    if ( $googlemapskey != "" ) {
?>
<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $googlemapskey ?>" type="text/javascript"></script>
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=<?php echo $googlemapskey ?>" type="text/javascript"></script>
<script src="http://localhost:81/wordpress/wp-content/plugins/sm-booking-form/js/gmap.js" type="text/javascript"></script>
<?php } ?>
 <div class="wrap"> 
     <?php
		$action = $_GET["action"];
		switch ($action) {
			case "edit":
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/box--pencil.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\">\" />" . __( 'Edit Item', 'sm_booking_form' ) . "</h2>";
				sm_booking_item_edit();
				break;
			case "delete":
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/box--minus.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\">\" />" . __( 'Delete Item', 'sm_booking_form' ) . "</h2>";
				sm_booking_delete();
				break;
			default:
				$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/box.png';
				echo "<h2>" . "<img src=\"" . $url . "\" alt=\">\" />" . __( 'Item Detail', 'sm_booking_form' ) . "</h2>";
				echo "<br/>" . sm_booking_getitemdetails();
				break;
		}
        ?>
     <br/>
 </div>