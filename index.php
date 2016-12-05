<?php
session_start();

// Debug: Display ALL errors
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// Include configuration and library
require 'conf/config.inc.php';
require 'lib/lib.inc.php';

// Retrieve request URI
$uri = explode('/', $_SERVER['REQUEST_URI']);
// Empty array to store parameters
$params = Array(); 
// Include everything but empty parameters
foreach($uri as $param){
    if ($param != ""){ array_push($params, $param); }
}

// If no parameters are found, default to home
if (empty($params)){ array_push($params, "home"); }

$section = array_shift($params);
$next_file = "";

// If the required section is defined, include it
if (isset($SECTIONS[$section])){
    $next_file = $SECTIONS[$section];
} else {
// Otherwise, give a 404 error
    sendError(404); 
}

// Include the next relevant file
include($next_file);


?>
