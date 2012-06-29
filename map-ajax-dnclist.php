<?php
require_once('config.php');
if (isset($_REQUEST['mapno']) && $_REQUEST['mapno']!=''){
	$map = new map(array(
		'mapno' => $_REQUEST['mapno'],
		'editable' => FALSE
	));
} else {
	error('no map specified');
}

$map->genDNCList();