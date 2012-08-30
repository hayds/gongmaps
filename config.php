<?php 
/**
 * @ File: config.php
 * @ Created: 29-03-2012
 * @ Last Updated: 30-08-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Main configuration file for the server.
 * @ Use: Specifies database connection defaults and site wide constants
 */


/** 
 * Constants
 */

define('APPNAME', 'Gongmaps');

define('VERSION', '1.5');
 
// Set ROOT to current directory of this file
define('ROOT', dirname(__FILE__));

// Define Classes folder
define('INCLUDES', ROOT . '/includes');

// Define host
define('HOST', $_SERVER['HTTP_HOST']);

// Define url
define('URL', $_SERVER['REQUEST_URI']);


/**
 * MYSQL Database Connection Settings 
 */

// Database username 
define('DB_USER', 'a1682995_gongmap');

// Database password */
define('DB_PASSWORD', 'quality99');

// Database name
define('DB_NAME', 'a1682995_gongmap');

// MySQL hostname
define('DB_HOST', 'mysql14.000webhost.com');

// Include additional include files
require_once(INCLUDES . '/class-db.php');
require_once(INCLUDES . '/class-map.php');
require_once(INCLUDES . '/functions.php');

// Load the db
$DB = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);