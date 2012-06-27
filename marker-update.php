<?php 
/**
 * @ File: update-marker.php
 * @ Created: 29-03-2012
 * @ Last Updated: 24-05-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to save or update a marker for a map
 */
 
require_once('config.php');

if ( !isset($_POST['mapno']) || $_POST['mapno'] == '' ) {
	die('no map number specified');
}
if ( !isset($_POST['type']) || $_POST['type'] == '' ) {
	die('no type specified');
}

$mapno=mysql_real_escape_string($_POST['mapno']);
$type=mysql_real_escape_string($_POST['type']);
$blockno=mysql_real_escape_string($_POST['blockno']);
$lat=mysql_real_escape_string($_POST['lat']);
$lng=mysql_real_escape_string($_POST['lng']);

//gen sql
$sql = "REPLACE INTO `markers` "
	 . "SET "
	 . "`mapno`='$mapno', "
	 . "`type`='$type', "
	 . "`blockno`='$blockno', "
	 . "`lat`='$lat', "
	 . "`lng`='$lng' "
	 . ";";

if(!$result=$DB->query($sql)){
	header("HTTP/1.0 500 Error");
	die($DB->get_error());
} //supposed to either insert a new one if it doesnt exist or if it does meet an error based on the duplicate key blockno_key then to update that one so should never get a 404