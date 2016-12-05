<?php
session_start();

// Debug: Display ALL errors
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// Security : prevent direct inclusion
$wentThroughIndex = TRUE;

// Include configuration and library
require 'inc/config.inc.php';
include 'backoffice.php';
?>