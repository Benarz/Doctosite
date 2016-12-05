<?php
// Sécurité : Vérification d'inclusion
if (!(isset($wentThroughIndex) && $wentThroughIndex)) {
	exit(1);
}

// Traitement données user
if(isset($_POST['id'])){
	$query = $db->prepare('
					UPDATE members 
					SET		canLogin	= :canLogin,
							canEdit		= :canEdit,
							displaySite = :displaySite
					WHERE memberID = :memberID
				');
				
	$query->execute(array(
				':memberID' => $_POST['id'],
				':canLogin' => $_POST['canLogin'],
				':canEdit' => $_POST['canEdit'],
				':displaySite' => $_POST['displaySite'] 
					)
				);
}

// Affichage simple
if (isset($_GET['id'])){
	// Récupération des données
	$query = $db->prepare('
			SELECT *
			FROM members
			WHERE memberID = :memberID
		');
	$query->execute(array(':memberID' => $_GET['id']));
	$user = $query->fetch(PDO::FETCH_ASSOC);

	// Affichage données user
?>
<h2>Détails de l'utilisateur</h2>
<div id="userDetail">
<?php
	echo "<p>
	<strong>Login : </strong>{$user['username']}<br>
	<strong>Email : </strong>{$user['email']}</p>
	";
	
	echo "<p><strong>Compte activé: </strong>";
	echo ($user['active']=='Yes')?'Oui':'Non';
	echo "<br><strong>Renseignements fournis : </strong>";
	echo $user['firstLogin']?"Oui":"Non";
	echo "</p>";
	
	echo "<p>
	<strong>Date de création: </strong>{$user['date_creation']}<br>
	<strong>Dernière connexion: </strong>{$user['date_login']}<br>
	<strong>Dernière publication: </strong>{$user['date_publication']}<br>
	</p>";

?>

<form method="post" action="?action=user&id=<?php echo $user['memberID']; ?>">
	<fieldset>
	<input type="hidden" name="id" value=<?php echo $user['memberID']; ?> >

	<label>Peut se connecter</label>
	<input type="radio" name="canLogin" value=1 <?php echo $user['canLogin']?"checked":"";?>> Oui
	<input type="radio" name="canLogin" value=0 <?php echo $user['canLogin']?"":"checked";?>> Non<br>
	
	<label>Peut modifier son site</label>
	<input type="radio" name="canEdit" value=1	<?php echo $user['canEdit']?"checked":"";?>> Oui
	<input type="radio" name="canEdit" value=0 <?php echo $user['canEdit']?"":"checked";?>> Non<br>
	
	<label>Afficher le site</label>
	<input type="radio" name="displaySite" value=1 <?php echo $user['displaySite']?"checked":"";?>> Oui
	<input type="radio" name="displaySite" value=0 <?php echo $user['displaySite']?"":"checked";?>> Non<br>
	
	</fieldset>
	<input type="submit" value="Valider">
</form>
<br>
<center>
<a href="?action=delete&id=<?php echo $user['memberID']; ?>" style="display: block;font-size: 14px;">Supprimer le compte</a>
</center>

</div>
<?php
} else {	// Aucun user sélectionné => erreur
echo "Veuillez revenir en arrière et choisir un utilisateur"; 
}
?>
