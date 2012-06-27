<?php 
/**
 * @ File: delete-marker.php
 * @ Created: 06-06-2012
 * @ Last Updated: 06-06-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to delete a marker for a map
 */
 
require_once('config.php');

if ( !isset($_POST['mapno']) || $_POST['mapno'] == '' ) {
	die('no map number specified');
}
if ( !isset($_POST['lat']) || $_POST['lat'] == '' ) {
	die('no lat specified');
}
if ( !isset($_POST['lng']) || $_POST['lng'] == '' ) {
	die('no lng specified');
}

//REQUIRED
$mapno=mysql_real_escape_string($_POST['mapno']);
$lat=number_format($_POST['lat'],6,'.','');
$lng=number_format($_POST['lng'],6,'.','');

//OPTIONAL
$blockno='';
if ($_POST['blockno']
$blockno=mysql_real_escape_string($_POST['blockno']);
//gen sql
$sql = "DELETE FROM markers "
	 . "WHERE "
	 . "`mapno`='$mapno' AND "
	 . "`blockno`='$blockno' AND "
	 . "`lat`=$lat AND " //dont put quotes around these floats or the db times out for some reason
	 . "`lng`=$lng"
	 . ";";	 


if(!$result=$DB->query($sql)){
	header("HTTP/1.0 500 Error");
	die($DB->get_error() . $sql);
}