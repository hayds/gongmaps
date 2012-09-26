<?php
require_once('config.php');
$sql="SELECT * from maps;";
if(!$DB->query($sql)){
	error($DB->get_error(),500,"SQL Error");
} else {
 echo "query OK!";	
}