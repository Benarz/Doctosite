<?php
// Sécurité : Vérification d'inclusion
if (!(isset($wentThroughIndex) && $wentThroughIndex)) {
	exit(1);
}

// ID à supprimer
$id = $_GET['id'];

if (isset($_GET['confirm']) && $_GET['confirm']){
	$query = $db->prepare("
			DELETE FROM	BlogPosts 		WHERE idx_member = :id;
			DELETE FROM SiteDraftData	WHERE idx_member = :id;
			DELETE FROM SiteLiveData	WHERE idx_member = :id;
			DELETE FROM members			WHERE memberID	 = :id;");
	$query->execute(Array(":id" => $id));
?>
<div id="userDetail">
<p style="text-align:center">
	Compte supprimé avec succès.
</p>
</div>

<?php
} else {
//	Confirmation
?>
<div id="userDetail">
<p style="text-align:center">
	Voulez vous réellement supprimer ce compte ?<br><br>
	<a href="?action=delete&id=<?php echo $id; ?>&confirm=1">
	Supprimer
	</a>
</p>
</div>
<?php
}

?>