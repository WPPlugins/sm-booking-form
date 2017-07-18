<?php
    global $wpdb;
    if($_POST['sm_booking_item_hidden'] == 'Y') {
        $itemType = $_POST['txtItemType'];				$data_array = array('type_name'=>$itemType);
		//print_r($data_array);
        $wpdb->insert( 'sm_item_type',$data_array );
        //$wpdb->print_errors();
?>
    <div class="updated"><div><strong><?php _e('Item Type Added.' ); ?></strong></div></div>
<?php } ?>
<div class="wrap"> 
<?php 
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/box--plus--itemtype.png';
    echo "<h2>" . "<img src=\"" . $url . "\" alt=\"book\" />" . __( 'New Item Type', 'sm_booking_itemtype_new' ) . "</h2>";
?>
<br/>
<form name="sm_booking_itemtype_form" id="sm_booking_itemtype_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
     <input type="hidden" name="sm_booking_item_hidden" value="Y">	 	 <input type="text" id="txtItemType" name="txtItemType" value="" />	 <span id="val_txtItemType" name="val_txtItemType" class="sm_form_notify_default">*</span>
     <input type="submit" name="Submit" value="<?php _e('Add Item', 'sm_booking_item_type_submit' ) ?>" />
</form>
</div>