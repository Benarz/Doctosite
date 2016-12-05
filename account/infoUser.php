<?php
// -------- Enregistrement des informations -------- //
if (isset($_POST['nomUser'])){
	// Préparation des données
	$data = Array (
		':nomUser' => $_POST['nomUser'],
		':prenomUser' => $_POST['prenomUser'],
		':emailUser' => $_POST['emailUser'],
		':adresseUser' => $_POST['adresseUser'],
		':cpUser' => $_POST['cpUser'],
		':villeUser' => $_POST['villeUser'],
		':paysUser' => $_POST['paysUser'],
		':phonefixUser' => $_POST['phonefixUser'],
		':phonemobUser' => $_POST['phonemobUser'],
		':convUser' => $_POST['convUser'],
		':rppsUser' => $_POST['rppsUser'],
		':titreUser' => $_POST['titreUser'],
		':specUser' => implode(",", $_POST['specUser']),
		':memberID' => $_SESSION['memberID'],
		':centreUser' => $_POST['centreUser']
	);

	// Requête
	$query = $db->prepare('UPDATE SiteDraftData 
							SET		firstName		= :prenomUser,
									lastName		= :nomUser,
									email			= :emailUser,
									adrRue			= :adresseUser,
									adrVille		= :villeUser,
									adrCodePostal	= :cpUser,
									country			= :paysUser,
									telFixe			= :phonefixUser,
									telMobile		= :phonemobUser,
									convention		= :convUser,
									rppsNum			= :rppsUser,
									title			= :titreUser,
									specs			= :specUser,
									centre			= :centreUser
							WHERE	idx_member = :memberID
	');
	// Exécution
	$query->execute($data);

	// First login
	if (isset($_SESSION['firstLogin']) && $_SESSION['firstLogin']){
		$firstLoginOk = $db->prepare('UPDATE members SET firstLogin = 1 WHERE memberID = :memberID');
		$firstLoginOk->execute(Array(':memberID' => $_SESSION['memberID']));
	}
} // ---- Fin de l'enregistrement des données ---- //

// -------- Récupération des données pour le formulaire -------- //
// Données du membre
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->prepare('SELECT * FROM Title WHERE id_title = :id ');
$query->execute(Array(':id' => $user['title']));
$user['fulltitle']  = $query->fetch(PDO::FETCH_ASSOC)['title'];


// Liste des titres
$query = $db->prepare('SELECT * FROM Title');
$query->execute();
while($row = $query->fetch(PDO::FETCH_ASSOC)){
	$titles[] = $row;
};

// Liste des spécialités
$query = $db->prepare('SELECT * FROM Specs');
$query->execute();
while($row = $query->fetch(PDO::FETCH_ASSOC)){
	$specs[] = $row;
};

// ---- Fin de la récupération des données ---- //


/*
 * Excess code
 
 <!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="introUser">Introduisez-vous</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="introUser" name="introUser"></textarea>
  </div>
</div>

*/


?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Param Decription">
    <meta name="author" content="">

    <title>Doctosite</title>

    <!-- Bootstrap core CSS -->
    <link href="../static/home/style/bootstrap.min.css" rel="stylesheet">
 
    <!-- Custom Google Web Font -->
    <link href="../static/home/style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
	
    <!-- Custom CSS-->
    <link href="../static/home/style/css/general.css" rel="stylesheet">
	
	 <!-- Owl-Carousel -->
    <link href="../static/home/style/css/custom.css" rel="stylesheet">
	<link href="../static/home/style/css/owl.carousel.css" rel="stylesheet">
    <link href="../static/home/style/css/owl.theme.css" rel="stylesheet">
	<link href="../static/home/style/css/style.css" rel="stylesheet">
	<link href="../static/home/style/css/animate.css" rel="stylesheet">
	
	<!-- Popup core CSS file -->
	<link rel="stylesheet" href="../static/home/style/css/magnific-popup.css"> 
	
	<script src="../static/home/js/modernizr-2.8.3.min.js"></script>  <!-- Modernizr /-->

</head>
<body id="home">

	<!-- Preloader -->
	<div id="preloader">
		<div id="status"></div>
	</div>
	
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
				<a class="navbar-brand" href="http://doctosite.fr/account">Doctosite</a>
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

<style>

fieldset{
    margin: 0px;
    border: 0px none;
    min-width: 0px;
    padding-right: 50px !important; 
    padding-left: 50px !important;
}

.col-md-7{
	margin-bottom: 10px;
}

.form-horizontal{
background: url(../static/home/img/intro/intro5.jpg) no-repeat center center;
background-size: cover;}


</style>
<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->
<legend>Vos informations</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nomUser">Nom</label>  
  <div class="col-md-4">
  <input id="nomUser" name="nomUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['lastName']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="prenomUser">Prénom</label>  
  <div class="col-md-4">
  <input id="prenomUser" name="prenomUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['firstName']; ?>">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailUser">Email</label>  
  <div class="col-md-4">
  <input id="emailUser" name="emailUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['email']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="adresseUser">Adresse</label>  
  <div class="col-md-5">
  <input id="adresseUser" name="adresseUser" placeholder="Ex: 10 avenue Jean-Jaures..." class="form-control input-md" required="" type="text" value="<?php echo $user['adrRue']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="cpUser">Code Postal</label>  
  <div class="col-md-2">
  <input id="cpUser" name="cpUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['adrCodePostal']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="villeUser">Ville</label>  
  <div class="col-md-4">
  <input id="villeUser" name="villeUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['adrVille']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="paysUser">Pays</label>  
  <div class="col-md-4">
  <input id="paysUser" name="paysUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['country']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="phonefixUser">Téléphone fixe</label>  
  <div class="col-md-4">
  <input id="phonefixUser" name="phonefixUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['telFixe']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="phonemobUser">Téléphone mobile       (Ne sera pas public)</label>  
  <div class="col-md-4">
  <input id="phonemobUser" name="phonemobUser" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['telMobile']; ?>">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="convUser">Conventionné</label>
  <div class="col-md-4">
    <select id="convUser" name="convUser" class="form-control">
      <option value="1" <?php echo ($user['convention'] == 1)? "selected":""; ?> >Secteur 1</option>
      <option value="2" <?php echo ($user['convention'] == 2)? "selected":""; ?> >Secteur 2</option>
      <option value="3" <?php echo ($user['convention'] == 3)? "selected":""; ?> >Secteur 3</option>
      <option value="4" <?php echo ($user['convention'] == 4)? "selected":""; ?> >Autre</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="rppsUser">N° RPPS</label>  
  <div class="col-md-4">
  <input id="rppsUser" name="rppsUser" class="form-control input-md" required="" type="text" value="<?php echo $user['rppsNum']; ?>">
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="centreUser">Êtes-vous un centre médical ?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="centreUser-0">
      <input name="centreUser" id="centreUser-0" value="Oui" type="radio" <?php echo ($user['centre'])? "checked":""; ?> >
      Oui
    </label> 
    <label class="radio-inline" for="centreUser-1">
      <input name="centreUser" id="centreUser-1" value="Non" type="radio" <?php echo ($user['centre'])? "":"checked"; ?>>
      Non
    </label>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="titreUser">Votre titre</label>
  <div class="col-md-4">
    <select id="titreUser" name="titreUser" class="form-control">
    <?php
	foreach($titles as $title){
		if ($title['id_title'] == $user['title']){
			echo '<option value="'.$title['id_title'].'" selected>'.$title['title'].'</option>';
		} else{
			echo '<option value="'.$title['id_title'].'">'.$title['title'].'</option>';
		}
	}
	?>
    </select>
  </div>
</div>
<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-4 control-label" for="specUser">Spécialités</label>
  <div class="col-md-4">
    <select id="specUser" name="specUser[]" class="form-control" multiple>
	<?php
	$slist = explode(",", $user['specs']);
	foreach($specs as $spec){
		if (in_array($spec['id_specs'],$slist)){
			echo '<option value="'.$spec['id_specs'].'" selected>'.$spec['specs'].'</option>';
		} else{
			echo '<option value="'.$spec['id_specs'].'">'.$spec['specs'].'</option>';
		}
	}
	?>
    </select>
  </div>
</div>

	<div class="col-md-8">
		<input type="submit" name="submit" id="submit" value="Enregistrer" class="btn wow tada btn-embossed btn-primary pull-right col-md-3">
	</div>
</fieldset>

</form>


     <footer>
      
    </footer>

    <!-- JavaScript -->
    <script src="../static/home/js/jquery-1.10.2.js"></script>
    <script src="../static/home/js/bootstrap.js"></script>
	<script src="../static/home/js/owl.carousel.js"></script>
	<script src="../static/home/js/script.js"></script>
	<!-- StikyMenu -->
	<script src="../static/home/js/stickUp.min.js"></script>
	<script type="text/javascript">
	  jQuery(function($) {
		$(document).ready( function() {
		  $('.navbar-default').stickUp();
		  
		});
	  });
	
	</script>
	<!-- Smoothscroll -->
	<script type="text/javascript" src="../static/home/js/jquery.corner.js"></script> 
	<script src="../static/home/js/wow.min.js"></script>
	<script>
	 new WOW().init();
	</script>
	<script src="../static/home/js/classie.js"></script>
	<script src="../static/home/js/uiMorphingButton_inflow.js"></script>
	<!-- Popup core JS file -->
	<script src="../static/home/js/jquery.magnific-popup.js"></script> 
</body>

</html>

