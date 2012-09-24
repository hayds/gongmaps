<?php 
/**
 * @ File: update-marker.php
 * @ Created: 29-03-2012
 * @ Last Updated: 24-09-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to save or update a marker for a map
 */
 
require_once('config.php');

if ( !isset($_POST['mapno']) || $_POST['mapno'] == '' ) {
	error('no map number specified');
}
if ( !isset($_POST['type']) || $_POST['type'] == '' ) {
	error('no type specified');
}

// MANDATORY
$mapno=mysql_real_escape_string($_POST['mapno']);
$type=mysql_real_escape_string($_POST['type']);
$lat=mysql_real_escape_string($_POST['lat']);
$lng=mysql_real_escape_string($_POST['lng']);

// OPTIONAL
$blockno='';
if (isset($_POST['blockno'])){
	$blockno=mysql_real_escape_string($_POST['blockno']);
}
$subpremise='';
if (isset($_POST['subpremise'])){
	$subpremise=mysql_real_escape_string($_POST['subpremise']);	
}
$streetno='';
if (isset($_POST['streetno'])){
	$streetno=mysql_real_escape_string($_POST['streetno']);	
}
$street='';
if (isset($_POST['street'])){
	$street=mysql_real_escape_string($_POST['street']);	
}
$suburb='';
if (isset($_POST['suburb'])){
	$suburb=mysql_real_escape_string($_POST['suburb']);	
}
$state='';
if (isset($_POST['state'])){
	$state=mysql_real_escape_string($_POST['state']);	
}
$postcode='';
if (isset($_POST['postcode'])){
	$postcode=mysql_real_escape_string($_POST['postcode']);	
}

//gen sql
//"update into" is supposed to either insert a new one if it doesnt exist or if it does meet an error based on the duplicate key blockno_key then to update that one so should never get a 404
$sql = "INSERT INTO `markers` "
	 . "(mapno, type, blockno, lat, lng, subpremise, streetno, street, suburb, state, postcode) "
	 . "VALUES "
	 . "('$mapno', '$type', '$blockno', '$lat', '$lng', '$subpremise', '$streetno', '$street', '$suburb', '$state', '$postcode');";

if(!$result=$DB->query($sql)){
	header("HTTP/1.0 500 Error");
	error($DB->get_error());
} 

echo mysql_insert_id();