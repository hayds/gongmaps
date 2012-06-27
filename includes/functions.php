<?php
/**
 * @ File: config.php
 * @ Created: 29-03-2012
 * @ Last Updated: 29-03-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Additional functions for use in code site wide
 * @ Use: 
 */



/**
 *
 * STRING AND NUMBER FUNCTIONS
 *
 */

// Pads 0's to the left of 
function num_pad($num,$length) {
	return str_pad($num,$length,'0',STR_PAD_LEFT);
}

// Strips , \ / from address and replaces spaces with dash great for seo url's
function seo_url($string){
	$chars = array(",","/","\\");
	$string = str_replace($chars,' ',$string);
	$string = capitalise($string);
	$string = preg_replace('/\s+/','-',$string);
	return $string;
}

// Capitalise a string
function capitalise($string) {
	return ucwords(strtolower($string));
}

// Change backslash \  to forwardslash /
function backslash_to_forwardslash($string) {
	return str_replace('\\', '/', $string); 
}

// Change forwardslash / to backslash \
function forwardslash_to_backslash($string) {
	return str_replace('/', '\\', $string); 
}

// Strip forward slashes
function strip_forward_slashes($string) {
	$string = str_replace("/","",$string);
	return $string;
}


function gen_map_links(){
	global $DB;
	$sql = "SELECT * from maps "
		 . "ORDER BY mapno;";
	$results = $DB->get_results($sql);
	foreach ($results as $key => $val){
		echo '<li><a class="maplink" data-transition="flow" data-ajax="false" href="/map/' . $val['mapno'] . '/">Map ' . $val['mapno'] . '</a></li>' . "\n";
	}	
}

function error($errormessage="Sorry page not found.", $errorno="404", $errorstatus="Not Found"){
	include("error.php");
	exit;
}