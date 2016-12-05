<?php
// -------- Enregistrement des informations -------- //
if (isset($_POST['titrePage'])){
	
	// Gestion logo
	if (isset($_FILES['monfichier']) && $_FILES['monfichier']['name']){
		$nomOrigine = $_FILES['monfichier']['name'];
		$elementsChemin = pathinfo($nomOrigine);
		$extensionFichier = $elementsChemin['extension'];
		$extensionsAutorisees = array("jpeg", "jpg", "png");
		if (!(in_array($extensionFichier, $extensionsAutorisees))) {
			echo "Le fichier n'a pas l'extension attendue";
		} else {    
			// Copie dans le repertoire du script avec un nom
			// incluant l'heure a la seconde pres 
			$repertoireDestination = dirname(__FILE__)."/../static/user_content/";
			$nomDestination = $_SESSION['memberID']."_logo.".$extensionFichier;

			if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
											 $repertoireDestination.$nomDestination)) {
				/*echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
						" a été déplacé vers ".$repertoireDestination.$nomDestination;*/
				// Upload ok
			} else {
				/*echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
						"Le déplacement du fichier temporaire a échoué".
						" vérifiez l'existence du répertoire ".$repertoireDestination;*/
				// Erreur upload
			}
		}
		$query = $db->prepare('UPDATE SiteDraftData SET content_logo = :logoPage WHERE	idx_member = :memberID');
		$query->execute(Array(':logoPage' => $nomDestination, ':memberID' => $_SESSION['memberID']));
	}	
	
	// Préparation des données
	$data = Array (
		':titrePage' 		=> $_POST['titrePage'],
		':titreChapitre'	=> $_POST['titreChapitre'],
		':desc1' 			=> $_POST['desc1'],
		':titrecat1' 		=> $_POST['titrecat1'],
		':descat1' 			=> $_POST['descat1'],
		':titrecat2' 		=> $_POST['titrecat2'],
		':descat2' 			=> $_POST['descat2'],
		':choixTemp'		=> $_POST['choixTemp'],
		':memberID' 		=> $_SESSION['memberID'],
		':blog'				=> $_POST['blog']
	);

	// Requête
	$query = $db->prepare('UPDATE SiteDraftData 
							SET		content_titleSite		= :titrePage,
									content_titleChapter	= :titreChapitre,
									content_desc1			= :desc1,
									content_titleCat1		= :titrecat1,
									content_descCat1		= :descat1,
									content_titleCat2		= :titrecat2,
									content_descCat2		= :descat2,
									template				= :choixTemp,
									blog					= :blog
								WHERE	idx_member = :memberID
	');
	// Exécution
	$query->execute($data);
	
} // ---- Fin de l'enregistrement des données ---- //

// -------- Récupération des données pour le formulaire -------- //
// Données du membre
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->prepare('SELECT * FROM Title WHERE id_title = :id ');
$query->execute(Array(':id' => $user['title']));
$user['fulltitle']  = $query->fetch(PDO::FETCH_ASSOC)['title'];

// ---- Fin de la récupération des données ---- //

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Param Decription">
    <meta name="author" content="">

    <title>Doctosite</title>

    <!-- Bootstrap core CSS -->
    <link href="../static/home/style/bootstrap.min.css" rel="stylesheet">
	
	<!-- Image Pickup CSS -->
    <link href="../static/image-picker/image-picker/image-picker.css" rel="stylesheet">
 
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
<body>
<style>
fieldset{
    margin: 0px;
    border: 0px none;
    min-width: 0px;
    padding-right: 50px !important; 
    padding-left: 50px !important;
}
.form-horizontal{
background: url(../static/home/img/intro/intro5.jpg) no-repeat center center;
background-size: cover;}

.img-preview{
	width: 120px;
}
</style><!--"../static/user_content/fileupload.php"-->
<form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
<fieldset>

<!-- Form Name -->
<legend>Edition de votre page</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="titrePage">Titre de votre page</label>  
  <div class="col-md-4">
  <input id="titrePage" name="titrePage" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['content_titleSite']; ?>" >
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="titrePage">Titre du chapitre</label>  
  <div class="col-md-4">
  <input id="titreChapitre" name="titreChapitre" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['content_titleChapter']; ?>" >
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="descat1">Description 1</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="desc1" name="desc1" ><?php echo $user['content_desc1']; ?></textarea>
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="logoPage">Logo</label>
  <div class="col-md-4">
    <input id="logoPage" name="monfichier" class="input-file" type="file" />
	<img id="blah" src="/static/user_content/<?php echo $user['content_logo']; ?>" alt="Votre Logo" class="img-preview" />
  </div>
  
  
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="titrecat1">Titre catégorie 1</label>  
  <div class="col-md-4">
  <input id="titrecat1" name="titrecat1" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $user['content_titleCat1']; ?>" >
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="descat1">Description catégorie 1</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="descat1" name="descat1" > <?php echo $user['content_descCat1']; ?> </textarea>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="titrecat2">Titre catégorie 2</label>  
  <div class="col-md-4">
  <input id="titrecat2" name="titrecat2" placeholder="" class="form-control input-md" type="text" value="<?php echo $user['content_titleCat2']; ?>" >
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="descat2">Description catégorie 2</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="descat2" name="descat2" > <?php echo $user['content_descCat2']; ?> </textarea>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="blog">Blog ?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="blog-0">
      <input name="blog" id="blog-0" value=1 type="radio" <?php echo $user['blog']?"checked":""; ?>>
      Oui
    </label> 
    <label class="radio-inline" for="blog-1">
      <input name="blog" id="blog-1" value=0 type="radio" <?php echo $user['blog']?"":"checked"; ?>>
      Non
    </label>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="choixTemp">Choix du template</label>
  <div class="centrage">
	<?php
		$selected = $user['template'];
	?>
  
    <select id="choixTemp" name="choixTemp" class="image-picker">
	  <option <?php if($selected == '1'){echo("selected");}?> data-img-src="../static/img/template1.jpg" value="1">Template 1</option> 
	  <option <?php if($selected == '2'){echo("selected");}?> data-img-src="../static/img/template2.jpg" value="2">Template 2</option> 
	  <option <?php if($selected == '3'){echo("selected");}?> data-img-src="../static/img/template3.jpg" value="3">Template 3</option>    
	</select>
  </div>
</div>

<div class="col-md-5">
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
	<!-- Image Pickup JS -->
    <script src="../static/image-picker/image-picker/image-picker.js"></script> 
	<script src="../static/image-picker/image-picker/image-picker.min.js"></script> 
	<script type="text/javascript">
	 jQuery("select.image-picker").imagepicker({
      hide_select:  true,
    });
	  
	
	</script>
	<!-- Image Preview -->
	<script type="text/javascript">
	    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#logoPage").change(function(){
        readURL(this);
    });
	
	</script>
	<!-- Popup core JS file -->
	<script src="../static/home/js/jquery.magnific-popup.js"></script> 
</body>

</html>
