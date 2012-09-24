<?php 
/**
 * @ File: delete-marker.php
 * @ Created: 06-06-2012
 * @ Last Updated: 24-09-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to delete a marker for a map
 */
 
require_once('config.php');

if ( isset($_POST['sysid']) && $_POST['sysid'] != '' ) { // check if sysid is set
	//REQUIRED
	$sysid=mysql_real_escape_string($_POST['sysid']); // if set escape it
} else { //otherwise check for other stuff
	if ( !isset($_POST['mapno']) || $_POST['mapno'] == '' ) {
		error('no map number specified');
	}
	if ( !isset($_POST['lat']) || $_POST['lat'] == '' ) {
		error('no lat specified');
	}
	if ( !isset($_POST['lng']) || $_POST['lng'] == '' ) {
		error('no lng specified');
	}
	//REQUIRED
	$mapno=mysql_real_escape_string($_POST['mapno']);
	$lat=number_format($_POST['lat'],6,'.','');
	$lng=number_format($_POST['lng'],6,'.','');
}

//OPTIONAL
$blockno='';
if (isset($_POST['blockno'])){
	$blockno=mysql_real_escape_string($_POST['blockno']);
}

if ($sysid){
	//gen sql
	$sql = "DELETE FROM markers "
		 . "WHERE "
		 . "`sysid`='$sysid';";
} else {
	//gen sql
	$sql = "DELETE FROM markers "
		 . "WHERE "
		 . "`mapno`='$mapno' AND "
		 . "`blockno`='$blockno' AND "
		 . "`lat`=$lat AND " //dont put quotes around these floats or the db times out for some reason
		 . "`lng`=$lng"
		 . ";";	 
}


if(!$result=$DB->query($sql)){
	error($DB->get_error(),500,"SQL Error");
}