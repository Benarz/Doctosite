<?php
// Edition du compte
// - Page d'index

// Vérification de la connexion
if( !($user->is_logged_in()) ){ 
	session_destroy();
	header('Location: http://doctosite.fr');
}

// Choix de la page
if(empty($params)) { array_push($params, "logged"); }
$param = array_shift($params);

$next_file = "";

switch ($param){
	case "logged":
		$next_file = "memberpage.php";
		break;
	case "blog":
		$next_file = "blog.php";
		break;
	case "create":
		$next_file = "createPage.php";
		break;
	case "edit":
		$next_file = "editPage.php";
		break;
	case "info":
		$next_file = "infoUser.php";
		break;
	case "publier":
		$next_file = "publish.php";
		break;
	case "publier?doIt":
		$next_file = "publish.php";
		break;
	case "blog":
		$next_file = "blogpost.php";
		break;
	case "logout":
		header('Location: http://doctosite.fr/account/logout.php');
		break;
	default:
		$next_file = "memberpage.php";
		break;
}

// Vérification: 1st logins
$query = $db->prepare('SELECT firstLogin FROM members WHERE memberID = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$row = $query->fetch(PDO::FETCH_ASSOC);
if ($row['firstLogin'] != 1 && $next_file != "infoUser.php") {
	$_SESSION['firstLogin'] = True;
	header('Location: http://doctosite.fr/account/info');
}

// inclusion
require $next_file;




?>