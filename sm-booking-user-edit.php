<?php
$userId = $_GET["id"];
$siteurl = get_option('siteurl');
$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

function sm_booking_getuserdetail($url, $userId)
{
	global $wpdb;

	$sqlUser = 'SELECT ur.role_name, ur.sm_role_id, u.sm_user_id, u.email_address FROM sm_users as u JOIN sm_user_role as ur ON ur.sm_role_id = u.sm_role_id WHERE u.sm_user_id = ' . $userId;
	$sqlRoles = 'SELECT sm_role_id, role_name FROM sm_user_role';
	$user_row = $wpdb->get_row( $sqlUser );
	$role_rows = $wpdb->get_results( $sqlRoles );
	//print_r($role_rows);	
	
	$output .= "\n    <label for=\"emailAddress\">Email Address:</label> <input type=\"text\" id=\"emailAddress\" name=\"emailAddress\" value=\"" . $user_row->email_address . "\" >";
	$output .= "\n <br />";
	$output .= "\n    <label for\"roleName\">User Role:</label> ";
	$output .= "\n    <select id=\"roleName\" name=\"roleName\">";
	foreach ( $role_rows as $role_row )
	{
		if  ( $user_row->sm_role_id == $role_row->sm_role_id ) 
		{
			$output .= "\n     <option value=\"" . $role_row->sm_role_id . "\" selected>	" . $role_row->role_name . "</option>";
		} 
		else 
		{
			$output .= "\n     <option value=\"" . $role_row->sm_role_id . "\">	" . $role_row->role_name . "</option>";
		}
	}
	$output .= "\n    </select>";
	$output .= $post_HTML;
	return $output;
}

global $wpdb;

if($_POST['sm_booking_user_hidden'] == 'Y') {
        $userEmail = $_POST['emailAddress'];
        $userRole = $_POST['roleName'];
        $sql = "UPDATE sm_users SET sm_role_id=" . $userRole. ", email_address='" . $userEmail . "' where sm_user_id=". $userId;
        $wpdb->query($sql);
        //$wpdb->print_errors();
?>
	    <div class="updated"><div><strong><?php _e('Item Saved.' ); ?></strong></div></div>
<?php } ?>

<div class="wrap">

<form name="sm_booking_users_form" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php  
	$userIconUrl = $url . '/images/user--pencil.png';
	echo "<h2>" . "<img src=\"" . $userIconUrl . "\" alt=\"user\" />" . __( 'Edit User Permissions', 'sm_booking_user' ) . "</h2>";
	
    if ( $userId > 0 )
	{
		echo "<p>Modify user permissions assigned to an email address</p>";
		echo sm_booking_getuserdetail($url, $userId);
	}
	else
	{
		echo "<p>No user ID supplied, please select a user</p>";
	}
?>
	<br />
	<input type="hidden" name="sm_booking_user_hidden" value="Y">
	<input type="submit" name="Submit" value="<?php _e('Save Permission', 'sm_booking_user_role' ) ?>" />
</form>
 </div>