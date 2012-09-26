<?php 
/**
 * @ File: update-polygon.php
 * @ Created: 29-03-2012
 * @ Last Updated: 24-05-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Used for ajax requests to save or update a polygon for a map
 */
 
require_once('config.php');

if ( !isset($_POST['mapno']) || $_POST['mapno'] == '' ) {
	error('no map number specified');
}
if ( !isset($_POST['path']) || $_POST['path'] == '' ) {
	error('no path specified');
}

//gen sql
$sql = "REPLACE INTO maps "
	 . "SET mapno = " . mysql_real_escape_string($_POST['mapno']) . ", path = '" . mysql_real_escape_string($_POST['path']) . "'"
	 . ";";

if (!$result=$DB->query($sql)){
	error($DB->get_error(),500,"SQL Error");
}