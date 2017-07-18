<?php

$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));


$itemTypeId = $_POST["TypeId"];
$newTypeName = $_POST["TypeName"];
$isDelete = $_POST["smDelete"];
$isUpdate = $_POST["smUpdate"];

if ($newTypeName != "" && $isUpdate == "Update") {
	global $wpdb;
	$sql = "UPDATE sm_item_type it SET it.type_name = '" . $newTypeName . "' WHERE it.typeId = " . $itemTypeId;
	$wpdb->query($sql);
	echo "<div id=\"sm_submit\" class=\"updated\"><div><strong>The Item Type has been updated.</strong></div></div>";
}
elseif ($isDelete == "Delete") {
	global $wpdb;
	$sql = "DELETE FROM sm_item_type WHERE typeId = " . $itemTypeId;
	$wpdb->query($sql);
	echo "<div id=\"sm_submit\" class=\"updated\"><div><strong>The Item Type has been deleted.</strong></div></div>";
}
else {
	$typeId = $_GET["id"];
}

function sm_booking_getbooking_itemtypes($url, $typeId) {

global $wpdb;

$sql =   'SELECT it.typeId, it.type_name FROM sm_item_type as it ';
$myrows = $wpdb->get_results( $sql );

$output .= "\n    <ul class=\"sm_navigation\">";
$output .= "\n    <li><a href=\"?page=sm-booking-itemtype-new.php" . $bookingId . "&approve=true\" class=\"sm_button ui-corner-all\"><img src=\"".$url."/images/box--plus--itemtype.png\" alt=\">\"/> New Item Type</a></li>";
$output .= "\n</ul>";
$output .= "\n<br/><br/>";

$output .= "\n <table id=\"table_bookings\" name=\"table_bookings\" cellspacing=\"1\" class=\"tablesorter booking_view\" summary=\"item type table\">";
$output .= "\n <thead>";
$output .= "\n <tr>";
$output .= "\n <th>";
$output .= "\n Item Type Name";
$output .= "\n <img src=\"" . $url . "/images/sort.png\" alt=\"*\"/>";
$output .= "\n </th>";
$output .= "\n </tr>";
$output .= "\n </tfoot>";
$output .= "\n<tbody>";
foreach ($myrows as $row) {
    $output .= "\n <tr>";
    $output .= "\n     <td>";
	if ($typeId == $row->typeId)
	{
		$output .= "\n <div><input type=\"text\" id=\"TypeName\" name=\"TypeName\" value=\"" . $row->type_name . "\" /> ";
		$output .= "\n <input type=\"hidden\" id=\"TypeId\" name=\"TypeId\" value=\"" . $row->typeId . "\" /> ";
		$output .= "\n <input type=\"submit\" name=\"smUpdate\" id=\"smUpdate\" value=\"Update\" />";
		$output .= "\n <input type=\"submit\" name=\"smDelete\" id=\"smDelete\" value=\"Delete\" />";
	}
	else
	{
		$output .= "\n <div><a href=\"" . $base_url . "?page=sm-booking-itemtype-view.php&id=" . $row->typeId . "\" title=\"View Item Type detail\">" . $row->type_name . "</a></div>";
	}
    $output .= "\n     </td>";
    $output .= "\n </tr>";
}
$output .= "\n</tbody>";
$output .= "\n </table>";
$output .= $post_HTML;
return $output;

}

add_action('sm_booking_itemtype_details', 'admin_register_itemtype_detail');

?>

<div class="wrap">
<?php
    $bookurl = $url . '/images/box-search-result.png'; 
    echo "<h2>" . "<img src=\"" . $bookurl . "\" alt=\"items\" />" . __( 'View Item Types', 'sm_bookingtype_item' ) . "</h2>"; ?>
	
    <div>Below is a summary of all the item types currently on the system. Click on its name to edit.</div><br/>
	<form id="sm_booking_itemtype_form" name="sm_booking_itemtype_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php 
    echo sm_booking_getbooking_itemtypes($url, $typeId);
?>
	</form>
 </div>
