<?php
if($param == "publier?doIt") {
	
	// Vérification : L'utilisateur peut-il publier ?
	$query = $db->prepare('SELECT * FROM members WHERE memberID = :memberID');
	$query->execute(Array(':memberID' => $_SESSION['memberID']));
	$allowed = $query->fetch(PDO::FETCH_ASSOC);
	
	if($allowed['canEdit']){
		
	$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
	$query->execute(Array(':memberID' => $_SESSION['memberID']));
	$data = $query->fetch(PDO::FETCH_ASSOC);
	
	$prep = Array(
		':id_dratftData' => $data['id_dratftData'],
		':theme' => $data['theme'],
		':firstName' => $data['firstName'],
		':lastName' => $data['lastName'],
		':telFixe' => $data['telFixe'],
		':telMobile' => $data['telMobile'],
		':email' => $data['email'],
		':adrRue' => $data['adrRue'],
		':adrVille' => $data['adrVille'],
		':adrCodePostal' => $data['adrCodePostal'],
		':rppsNum' => $data['rppsNum'],
		':mainPicture' => $data['mainPicture'],
		':presentation' => $data['presentation'],
		':contact' => $data['contact'],
		':tarifs' => $data['tarifs'],
		':country' => $data['country'],
		':convention' => $data['convention'],
		':title' => $data['title'],
		':specs' => $data['specs'],
		':centre' => $data['centre'],
		':content_logo' => $data['content_logo'],		
		':content_titleSite' => $data['content_titleSite'],		
		':content_titleChapter' => $data['content_titleChapter'],	
		':content_desc1' => $data['content_desc1'],		
		':content_titleCat1' => $data['content_titleCat1'],	
		':content_descCat1' => $data['content_descCat1'],
		':content_titleCat2' => $data['content_titleCat2'],		
		':content_descCat2'	=> $data['content_descCat2'],	
		':template' => $data['template'],
		':blog'	=> $data['blog']
	);
	
	$query = $db->prepare('UPDATE SiteLiveData 
							SET theme = :theme, 
								firstName = :firstName, 
								lastName = :lastName, 
								telFixe = :telFixe, 
								telMobile = :telMobile, 
								email = :email, 
								adrRue = :adrRue, 
								adrVille = :adrVille, 
								adrCodePostal = :adrCodePostal, 
								rppsNum = :rppsNum, 
								mainPicture = :mainPicture, 
								presentation = :presentation, 
								contact = :contact, 
								tarifs = :tarifs, 
								country = :country, 
								convention = :convention, 
								title = :title, 
								specs = :specs, 
								centre = :centre,
								content_logo = :content_logo,
								content_titleSite = :content_titleSite,
								content_titleChapter = :content_titleChapter,
								content_desc1 = :content_desc1,
								content_titleCat1 = :content_titleCat1,
								content_descCat1 = :content_descCat1,
								content_titleCat2 = :content_titleCat2,
								content_descCat2 = :content_descCat2,
								template = :template,
								blog = :blog
							WHERE id_liveData = :id_dratftData');
	$query->execute($prep);
	
	$query = $db->prepare('UPDATE members SET date_publication = :d_pub WHERE memberID = :memberID');
	$query->execute(Array(':memberID' => $_SESSION['memberID'], ':d_pub' => date('Y-m-d H:i:s')));
	
	$published = True;
	} else{
		$published = False;
		$denied = True;
	}
} else{
	$published = False;
	$denied = False;
}
// -------- Récupération des données pour le formulaire -------- //
// Données du membre
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->prepare('SELECT * FROM Title WHERE id_title = :id ');
$query->execute(Array(':id' => $user['title']));
$user['fulltitle']  = $query->fetch(PDO::FETCH_ASSOC)['title'];


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

<body>
<style>
hr.message-inner-separator
{
    clear: both;
    margin-top: 10px;
    margin-bottom: 13px;
    border: 0;
    height: 1px;
    background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
    background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}

.alert-warning, .alert-success, .alert-danger{
	margin-top: 25px;
}
#home{
background: url(../static/home/img/intro/intro5.jpg) no-repeat center center;
background-size: cover;}
</style>

<div class="container">
    <div class="row">
        
		<?php 
		if ($published){
		?>
		<div class="col-md-6 col-md-offset-3 text-center wrap_title">
            <div class="alert alert-success">
                
                <strong>Information</strong>
                <hr class="message-inner-separator">
                <p>
                    Vos données ont été actualisées avec succès.
				</p>
            </div>
        </div>
		<?php
		} elseif ($denied){
		?>
		<div class="col-md-6 col-md-offset-3 text-center wrap_title">
            <div class="alert alert-danger">
                
                <strong>Information</strong>
                <hr class="message-inner-separator">
                <p>
                    Vous n'êtes pas autorisé à publier.
				</p>
            </div>
        </div>
		<?php
		}
		else{
		?>
		
        <div class="col-md-6 col-md-offset-3 text-center wrap_title">
            <div class="alert alert-warning">
                
                <strong>Information</strong>
                <hr class="message-inner-separator">
                <p>
                    En cliquant sur le lien ci-dessous, les données actuellement visibles par votre interface vont être rendues publiques.<br />
				</p>
            </div>
			<p><a class="btn btn-warning" href="http://doctosite.fr/account/publier?doIt">Continuer</a></p>
        </div>
		<?php
		}
		?>
        
    </div>
</div>

<script type="text/javascript">

</script>	
	
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
