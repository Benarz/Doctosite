<?php
// Sécurité : Vérification d'inclusion
if (!(isset($wentThroughIndex) && $wentThroughIndex)) {
	exit(1);
}

// Grab all users
$query = $db->prepare('SELECT * FROM members');
$query->execute();

// Send results into a new array
$users = Array();
while($row = $query->fetch(PDO::FETCH_ASSOC)){
	$users[] = $row;
};

// Liens vers les images "ok" et "nok"
$ok = '<img src="img/ok.png" width="12px" height="12px" />';
$nok = '<img src="img/nok.png" width="12px" height="12px" />';
$edit = '<img src="img/edit.png" width="14px" height="14px" />';

?>

<h2>Liste des utilisateurs</h2>

<table>
	<thead>
	<tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Email</th>
		<th>Login</th>
		<th>Edition</th>
		<th>Display</th>
		<th>Modifier</th>
	</tr>
	</thead>
	<tbody>
<?php
	$i = 1;
	foreach($users as $user){
		$i++; $i = $i%2;
		echo
		"<tr class='c{$i}'>
		<td>{$user['memberID']}</td>
		<td>{$user['username']}</td>
		<td>{$user['email']}</td>
		<td>".($user['canLogin']?$ok:$nok)."</td>
		<td>".($user['canEdit']?$ok:$nok)."</td>
		<td>".($user['displaySite']?$ok:$nok)."</td>
		<td><a href='?action=user&id={$user['memberID']}'>{$edit}</a></td>
		</tr>";
	}

?>
	</tbody>
</table>