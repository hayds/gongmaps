<?php
require_once('config.php');


$sql = "CREATE TABLE IF NOT EXISTS `maps` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) binary NOT NULL,
  `mapno` int(11) NOT NULL,
  `updated` timestamp NULL,
  PRIMARY KEY (`sysid`),
  UNIQUE KEY `mapno` (`mapno`)
)DEFAULT CHARSET=utf8;";

if(!$DB->query($sql)){
	//error($DB->get_error(),500,"SQL Error");
} 

$sql = "CREATE TABLE IF NOT EXISTS `markers` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `blockno` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `mapno` int(11) NOT NULL,
  `subpremise` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `streetno` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `street` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `suburb` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `postcode` int(4) DEFAULT NULL,
  PRIMARY KEY (`sysid`),
  UNIQUE KEY `position_key` (`lat`,`lng`),
  KEY `blockno_key` (`type`,`mapno`,`blockno`)
)DEFAULT CHARSET=utf8;";


if(!$DB->query($sql)){
	error($DB->get_error(),500,"SQL Error");
} 

?>
<!DOCTYPE html> 
<html> 
	<head>
  <meta charset="utf-8">
	<title><?php echo APPNAME; ?> <?php echo VERSION; ?> - Install</title>
	<link rel="stylesheet" href="/css/site.css" />    
<body>
<h1>Tables Created</h1>
</body>
</html>