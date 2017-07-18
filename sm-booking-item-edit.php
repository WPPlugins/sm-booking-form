<?php
    function sm_booking_getitemedit() {
        global $wpdb;
        $siteurl = get_option('siteurl');
        $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));
        $itemId = $_GET["id"];		$sql = "SELECT i.itemId, i.title, i.description, i.AddressLn1, i.AddressLn2, i.CityTown, i.CountyState, i.PostalCode, i.notes, i.statistics, i.image_name, i.type, it.type_name FROM sm_booking_item as i JOIN sm_item_type it ON it.typeid = i.type Where i.itemId = " . $itemId;
		$type_sql = "SELECT sm_item_type.typeid, sm_item_type.type_name FROM sm_item_type";
		$type_rows = $wpdb->get_results( $type_sql );
        $row = $wpdb->get_row( $sql );        
        $itemImage = $row->image_name;
        $output .= "\n <table id=\"Item_Detailss\" name=\"Item_Detailss\" summary=\"Item Detail\">";
        $output .= "\n <tr>";
        $output .= "\n <td id=\"Item_Image\" rowspan=\"22\">";
        if ($itemImage != "") {
            $output .= "\n <img src=\"" . $itemImage . "\" alt=\"Item Image\"/>";
            $output .= "\n <br/>";
        }
        $output .= "\n </td>";
        $output .= "\n <td>";
        $output .= "\n <input type=\"hidden\" id=\"hidId\" name=\"hidId\" value=\"" . $row->itemId . "\"/>";
        $output .= "\n <label for=\"txtTitle\">Title: </label><input type=\"text\" id=\"txtTitle\" name=\"txtTitle\" value=\"" . $row->title . "\"/>";				$output .= "\n <span id=\"val_txtTitle\" name=\"val_txtTitle\" class=\"sm_form_notify_default\">*</span>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <div id=\"image_upload_url\">" . $row->imageImage . "</div>";
        $output .= "\n <label for=\"txtImageName\">Image Name: </label><input type=\"text\" id=\"txtImageName\" name=\"txtImageName\" value=\"" . $row->image_name . "\"/>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <label for=\"txtImageUpload\">Upload New Name: </label><input type=\"file\" id=\"txtImageUpload\" name=\"txtImageUpload\" />";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <label for=\"txtDescription\">Description:</label>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "<textarea rows=\"5\" cols=\"50\" id=\"txtDescription\" name=\"txtDescription\">" . $row->description . "</textarea>";				$output .= "\n <span id=\"val_txtDescription\" name=\"val_txtDescription\" class=\"sm_form_notify_default\">*</span>";
        $output .= "\n </td>";
        $output .= "\n </tr>";				// Start Item Address				$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <p><strong>Item Address</strong></p>";		$output .= "\n <label for=\"txtAddressLn1\">Address Line 1:</label>";		$output .= "\n <td>";		$output .= "\n </tr>";		$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <input type=\"text\" id=\"txtAddressLn1\" name=\"txtAddressLn1\" value=\"" . $row->AddressLn1 . "\"/>";		$output .= "\n <span id=\"val_txtAddressLn1\" name=\"val_txtAddressLn1\" class=\"sm_form_notify_default\">*</span>";		$output .= "\n <td>";		$output .= "\n </tr>";				$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <label for=\"txtAddressLn2\">Address Line 2:</label>";		$output .= "\n <td>";		$output .= "\n </tr>";		$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <input type=\"text\" id=\"txtAddressLn2\" name=\"txtAddressLn2\" value=\"" . $row->AddressLn2 . "\"/>";		$output .= "\n <td>";		$output .= "\n </tr>";				$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <label for=\"txtCityTown\">City / Town:</label>";		$output .= "\n <td>";		$output .= "\n </tr>";		$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <input type=\"text\" id=\"txtCityTown\" name=\"txtCityTown\" value=\"" . $row->CityTown . "\"/>";		$output .= "\n <td>";		$output .= "\n </tr>";				$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <label for=\"txtCountyState\">County / State:</label>";		$output .= "\n <td>";		$output .= "\n </tr>";		$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <input type=\"text\" id=\"txtCountyState\" name=\"txtCountyState\" value=\"" . $row->CountyState . "\"/>";		$output .= "\n <td>";		$output .= "\n </tr>";				$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <label for=\"txtPostalCode\">Postal Code / Zip Code:</label>";		$output .= "\n <td>";		$output .= "\n </tr>";		$output .= "\n <tr>";		$output .= "\n <td>";		$output .= "\n <input type=\"text\" id=\"txtPostalCode\" name=\"txtPostalCode\" value=\"" . $row->PostalCode . "\"/>";		$output .= "\n <span id=\"val_txtPostalCode\" name=\"val_txtPostalCode\" class=\"sm_form_notify_default\">*</span>";        if ( $googlemapskey != "" ) {            $output .= "<input type=\"button\" name=\"btnMap\" id=\"btnMap\" value=\"Show map\" onclick=\"javascript:usePointFromPostcode(document.getElementById('txtPostalCode').value, placeMarkerAndCenterToPoint)\" />";            $output .= "<div id=\"GoogleMap\" style=\"display:none;\">";            $output .= "<div id=\"map\"></div>";            $output .= "</div>";        }		$output .= "\n <td>";		$output .= "\n </tr>";				// End Item Address
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <label for=\"txtNotes\">Notes:</label>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <textarea rows=\"5\" cols=\"50\" id=\"txtNotes\" name=\"txtNotes\">" . $row->notes . "</textarea>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <label for=\"txtStats\">Statistics</label>";
        $output .= "\n <p>Comma seperated list. (i.e. item1, item2, item3, etc.)</p>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <textarea rows=\"5\" cols=\"50\" id=\"txtStats\" name=\"txtStats\">" . $row->statistics . "</textarea>";
        $output .= "\n </td>";
		$output .= "\n </tr>";
		$output .= "\n <tr>";
        $output .= "\n <td>";
        $output .= "\n <label for=\"ddlType\">Select item type:</label>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
		$output .= "\n <tr>";
		$output .= "\n <td>";
        $output .= "\n <select id=\"ddlType\" name=\"ddlType\">";
		$output .= "\n <option value=\"\"></option>";
		foreach ( $type_rows as $type_row )
		{
			if  ( $row->type == $type_row->typeid ) {
				$output .= "\n     <option value=\"" . $type_row->typeid . "\" selected>	" . $type_row->type_name . "</option>";
			} else {
				$output .= "\n     <option value=\"" . $type_row->typeid . "\">	" . $type_row->type_name . "</option>";
			}
		}
		$output .= "\n </select>";				$output .= "\n <span id=\"val_ddlType\" name=\"val_ddlType\" class=\"sm_form_notify_default\">*</span>";
        $output .= "\n </td>";
        $output .= "\n </tr>";
        $output .= "\n </table>";
        
        return $output;
    }
    global $wpdb;
    if($_POST['sm_booking_item_hidden'] == 'Y') {		if ($_FILES["txtImageUpload"]["name"] != null) {
			if ($_FILES["txtImageUpload"]["size"] < 150000) {
				$upload = wp_upload_bits($_FILES["txtImageUpload"]["name"], null, file_get_contents($_FILES["txtImageUpload"]["tmp_name"]));
				if ($upload["error"]!="")
				{
					echo "<div class=\"error\">Error: " . $upload["error"] . "</div>";
				}
			}else {
				echo "<div class=\"error\">Error: Only images under 150Kb are accepted for upload</div>";
			}		}		
        $itemId = $_POST['hidId'];
        $title = $_POST['txtTitle'];
        $description = $_POST['txtDescription'];
        $notes = $_POST['txtNotes'];
        $type =  $_POST['ddlType'];
        $statistics = $_POST['txtStats'];
        if ($upload["url"]!="") {
            $image_name = $upload["url"];
        } else {
            $image_name = $_POST['txtImageName'];
        }
        $sql = "UPDATE sm_booking_item SET title='" . $title. "', description='" . $description . "', notes='" . $notes . "', type='" . $type . "', statistics='" . $statistics . "', image_name='" . $image_name . "' where itemId=". $itemId;
        $wpdb->query($sql);
        //$wpdb->print_errors();
?>
    <div class="updated"><div><strong><?php _e('Item Saved.' ); ?></strong></div></div>
<?php } ?>
<div class="wrap"> 
<?php
    $edit = $_GET["edit"];
    if($edit=="true")
    {    
        $siteurl = get_option('siteurl');
        $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/box--pencil.png';
        echo "<h2>" . "<img src=\"" . $url . "\" alt=\"book\" />" . __( 'Edit Item', 'sm_booking_item_edit' ) . "</h2>";
    }
?>
<br/>
<form name="sm_booking_item_form" id="sm_booking_item_form" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
     <?php echo sm_booking_getitemedit(); ?>
     <input type="hidden" name="sm_booking_item_hidden" value="Y">
     <input type="submit" name="Submit" value="<?php _e('Save Item', 'sm_booking_item_submit' ) ?>" /><span id="sm_error_count"></span>
</form>
</div>   