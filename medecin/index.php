<?php

// Récupération des paramètres
if (empty($params)){
	echo "Out of params";
} else {
	// Paramètre "bidon"
	$dummy = array_shift($params);
	if (empty($params)){
		// Manque l'ID du mécin
		echo "Only 1 param found";
	}else {
		// Répération du nom-prenom-id
		$actualId = array_shift($params);
	}
}

if (isset($actualId)){
	// Extraction de l'ID
	$actualId = explode('-', $actualId);
	$id = array_pop((array_slice($actualId, -1)));
}

// Vérification 1 : Le profil peut-il être affiché (ADMIN)
$query = $db->prepare('SELECT displaySite FROM members WHERE memberID = :memberID');
$query->execute(Array(':memberID' => $id));
$displayOk = $query->fetch(PDO::FETCH_ASSOC);
// Vérification 2 : L'utilisateur souhaite afficher son profil
// TODO

// Vérif 1 ?
if ($displayOk['displaySite']){
	// Vérif 2 ?
	if(True){
		// Afficher la page ou le blog ?
		if(!empty($params) && (array_shift($params) == 'blog')) {
			echo "blog";
		}else{
			$query = $db->prepare('SELECT * FROM SiteLiveData WHERE idx_member = :memberID');
			$query->execute(Array(':memberID' => $id));
			$user = $query->fetch(PDO::FETCH_ASSOC);
			// echo $id;
			// print_r($user);
			// Debug
			include "template1.php";
		}
	} else{
		// L'utilisateur a désactivé l'affichage
		echo "L'utilisateur a masqué ce profil";
	}
} else {
	echo "Affichage désactivé par l'Administrateur";
}


?>