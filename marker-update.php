<?php 
/**
 * @ File: update-marker.php
 * @ Created: 29-03-2012
 * @ Last Updated: 24-09-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to update a marker for a map
 */
 
require_once('config.php');

if ( isset($_POST['sysid']) && $_POST['sysid'] != '' ) { // check if sysid is set
	//REQUIRED
	$sysid=mysql_real_escape_string($_POST['sysid']); // if set escape it
} else { 
	error('no sysid specified');
}
 
@$lat=mysql_real_escape_string($_POST['lat']);
@$lng=mysql_real_escape_string($_POST['lng']);

$sql = "UPDATE `markers` "
	 . "SET "
	 . "`lat`='$lat', "
	 . "`lng`='$lng' "
	 . "WHERE `sysid`='$sysid' "
	 . ";";

if(!$result=$DB->query($sql)){
	error($DB->get_error(),500,"SQL Error");
} 