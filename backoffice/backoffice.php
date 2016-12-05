<?php
/*
 * =============================
 * =	  BackOffice Root      =
 * =============================
 *
 */

// Sécurité : Vérification d'inclusion
if (!(isset($wentThroughIndex) && $wentThroughIndex)) {
	exit(1);
}

// Pages autorisées
$actions = Array("login", "overview", "settings", "users", "user", "delete", "logout");

// Page header
include "inc/phead.php";

// Choix de la page
if (isset($_GET['action']) && $_GET['action']){
	if (in_array($_GET['action'], $actions)){
		$action = $_GET['action'];
	} else {
		$action = "logout";
	}

	// Connexion de l'utilisateur
	if ($action=="login") {
		// Requête de connexion
		$logchk = $db->prepare('SELECT login, passwd, salt FROM Admins WHERE login = :login');
		$logchk->execute(array(':login' => $_POST['login']));
		$row = $logchk->fetch(PDO::FETCH_ASSOC);

		if (crypt($_POST['password'], $row['salt']) == $row['passwd']){
			$_SESSION['logged'] = TRUE;
			include 'inc/sidenav.php';
			include 'pages/overview.php';
		}
	} else {
		include 'inc/sidenav.php';
		include "pages/$action.php";
	}
} elseif (isset($_SESSION['logged']) && $_SESSION['logged']) {
	include 'inc/sidenav.php';
	include 'pages/overview.php';
}else{
	include "loginform.php";
}
include "inc/pfoot.php";
?>
