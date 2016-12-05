<?php
/**
 * Configuration file
 * ------------------
 */

ob_start();
date_default_timezone_set('Europe/London');
 
// Database
DEFINE('DBHOST', "localhost");
DEFINE('DBNAME', "db329628_doctosite");
DEFINE('DBUSER', "db88190");
DEFINE('DBPASS', "Limayrac2016!");

// Mailing
DEFINE('DIR', 'http://doctosite.fr/');
DEFINE('SITEEMAIL', 'no-reply@doctosite.fr');
DEFINE('mailFrom', "no-reply@doctosite.fr");

// Site sections
$SECTIONS = Array(
    "login" => "login/login.php",
    "home" => "home/index.php",
    "medecin" => "medecin/medecin.php",
    "mon-compte" => "mon-compte/mon-compte.php",
    "register" => "register/register.php",
);

// PDO Connectivity
try {
	//création du lien avec la bdd
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

// BootStrap
$bootstrapFolder = "/static/bootstrap/";

// EOF
?>
