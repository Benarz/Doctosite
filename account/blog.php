<?php
// User information
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);

// Post new content
if(isset($_POST['newPost'])){
	$query = $db->prepare('INSERT INTO BlogPosts (idx_member,date,titre,corps) VALUES (:idx_member, :date, :titre, :corps)');
	$query->execute(array(
		':idx_member' => $_SESSION['memberID'],
		':date' => date('Y-m-d H:i:s'),
		':titre' => $_POST['postTitle'],
		':corps' => $_POST['content'],
	));
}

// Edit old content
if(isset($_POST['editing'])){
	$query = $db->prepare('UPDATE BlogPosts 
							SET		titre = :titre,
									corps = :corps
							WHERE	idx_member = :idx_member
							AND		id_post = :id_post');
	$query->execute(array(
		':idx_member' => $_SESSION['memberID'],
		':titre' => $_POST['postTitle'],
		':corps' => $_POST['content'],
		':id_post' => $_POST['editing'],
	));
}

// Edit specific post
if (isset($_GET['edit'])){
	$query = $db->prepare('SELECT * FROM BlogPosts WHERE idx_member = :memberID AND id_post = :id_post');
	$query->execute(Array(':memberID' => $_SESSION['memberID'], ':id_post' => $_GET['edit']));
	$editing = $query->fetch(PDO::FETCH_ASSOC);
}

// Delete specific post
if (isset($_GET['del'])){
	$query = $db->prepare('DELETE FROM BlogPosts WHERE idx_member = :memberID AND id_post = :id_post');
	$query->execute(Array(':memberID' => $_SESSION['memberID'], ':id_post' => $_GET['del']));
}

// ---------- Récupération de données ---------- //

// User's older blog entries
$query = $db->prepare('SELECT * FROM BlogPosts WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
while($row = $query->fetch(PDO::FETCH_ASSOC)){
	$olderPosts [] = $row;
};

// -------- Récupération des données pour le formulaire -------- //
// Données du membre
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->prepare('SELECT * FROM Title WHERE id_title = :id ');
$query->execute(Array(':id' => $user['title']));
$user['fulltitle']  = $query->fetch(PDO::FETCH_ASSOC)['title'];


// -------- Fin Récupération de données -------- //
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Param Decription">
    <meta name="author" content="">

    <title>Doctosite</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
	auto_focus: 'content',
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
});
</script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<!-- Custom Google Web Font -->
    <link href="/static/home/style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>

    <!-- Custom CSS-->
    <link href="/static/home/style/css/general.css" rel="stylesheet">	
	<link href="/static/home/style/css/owl.theme.css" rel="stylesheet">
	<link href="/static/home/style/css/owl.carousel.css" rel="stylesheet">
	<link href="/static/home/style/css/style.css" rel="stylesheet">
	<link href="/static/home/style/css/animate.css" rel="stylesheet">
	
	
</head>

<body id="home">
	
	<!-- NavBar-->
	<nav class="navbar-default" role="navigation">
		<div class="container">
		
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#home">Doctosite</a>
			</div>
			
			<div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
				<ul class="nav navbar-nav">
				
					<!-- Remplacer les params par les bons contenus dans la BDD -->
					<li class="menuItem"><a href="http://doctosite.fr/medecin/<?php echo $user['adrCodePostal'],"-",$user['fulltitle'],"/",$user['firstName'],"-",$user['lastName'],"-",$user['idx_member'];?>">Ma Page</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/edit">Editer ma page</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/info">Editer mes informations</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/publier">Publier</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/blog">Gestion du blog</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/logout.php">Déconnexion</a></li>
				</ul>
			</div>
		   
		</div>
	</nav>
	
<!-- Form Name -->
<legend style="text-align: center;">Gestion du blog</legend>

<!-- EDITOR/ -->
<div class="col-md-6 col-md-offset-3 text-center wrap_title">
						<div class="col nopadding">
							<form method="post" action="">
								<div class="row">
								<label>Titre<br><input type="text" name="postTitle" value="<?php echo isset($editing)?$editing['titre']:"";?>" required></label>
								</div><div class="row">
								<label>Contenu<br><textarea id="content" name="content"><?php echo isset($editing)?$editing['corps']:""; ?></textarea> </label>
								</div><div class="row">
								<input type="hidden" name="<?php echo isset($editing)?"editing":"newPost"; ?>" value=<?php echo isset($editing)?$editing['id_post']:""; ?> >
								<input type="submit" value="Enregistrer">
								</div>
							</form>
						</div>
				
				<?php if (!empty($olderPosts)){ ?>
				
						<h3>Anciens posts</h3>
						<div class="col nopadding">
						<center>
						<table>
							<thead>
							<tr>
								<td class="dc-wide-cell">Titre</td>
								<td>Editer</td>
								<td>Supprimer</td>
							</tr>
							</thead>
						<?php
							foreach($olderPosts as $post){
								echo "<tr>
									<td class='dc-wide-cell'>{$post['titre']}</td>
									<td><a href='?edit={$post['id_post']}'>...</a></td>
									<td><a href='?del={$post['id_post']}'>X</a></td>
								</tr>";
							}
						?>
						</table>
						</center>
					</div>
				<?php } ?>

</div>		
	
<!-- /EDITOR -->
	
    <footer>
      
    </footer>
	
</body>
<style>
#home{
background: url(/static/home/img/intro/intro5.jpg) no-repeat center center;
background-size: cover;}
</style>

</html>
