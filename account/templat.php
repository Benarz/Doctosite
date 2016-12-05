<?php
// -------- Récupération des données pour le formulaire -------- //
// Données du membre
$query = $db->prepare('SELECT * FROM SiteDraftData WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $_SESSION['memberID']));
$user = $query->fetch(PDO::FETCH_ASSOC);

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
				<a class="navbar-brand" href="#home"><?php echo $user['content_titleSite']; ?></a>
			</div>

			<div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
				<ul class="nav navbar-nav">
				
					<!-- Remplacer les params par les bons contenus dans la BDD -->
					<li class="menuItem"><a href="#paramlink1">Param chapitre1</a></li>
					<li class="menuItem"><a href="#paramlink2">Param chapitre2</a></li>
					<li class="menuItem"><a href="#paramlink3">Param chapitre3</a></li>
					<li class="menuItem"><a href="#paramlink4">Param chapitre4</a></li>
				</ul>
			</div>
		   
		</div>
	</nav> 
	
	<!-- Partie 0.1 Logo/Nom: Mettre une condition si afficher ou pas 
	<div id="downloadlink" class="banner">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center abcen1">
					<h1 class="h1_home wow fadeIn" data-wow-delay="0.4s">Param name</h1>
					<h3 class="h3_home wow fadeIn" data-wow-delay="0.6s">Param commentaire</h3>
				</div>
			</div>
		</div>
	</div>-->
	
	<!-- Partie 1 Présentation: Mettre une condition si afficher ou pas -->
	<div id="whatis" class="content-section-b" style="border-top: 0">
		<div class="container">

			<div class="col-md-6 col-md-offset-3 text-center wrap_title">
				<h2>Param Titre H2</h2>
				<p class="lead" style="margin-top:0">Param description </p>
				
			</div>
			
			<div class="row">
			
				
				
				<div class="col-sm-4 wow fadeInDown text-center">
				 <!-- <img  class="rotate" width="130" src="../img/icon/company.svg" alt="Generic placeholder image">
				   <h3>Param Cat1</h3>
				   <p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				   <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
				<div class="col-sm-4 wow fadeInDown text-center">
				  <img  class="rotate" width="130" src="http://simpleicon.com/wp-content/uploads/camera.png" alt="Generic placeholder image">
				   <h3>Param Cat1</h3>
					<p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				  <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
				<div class="col-sm-4 wow fadeInDown text-center">
				 <!-- <img  class="rotate" width="130" src="../img/icon/stethoscope.svg" alt="Generic placeholder image">
				   <h3>Param Cat1</h3>
					<p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				  <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
			</div><!-- /.row -->
			
		</div>
	</div>
	
	
<!-- Partie 2 Bloc infos: Mettre une condition si afficher ou pas -->
    <div class="content-section-b">  
		
		<div class="container">
            <div class="row">
                				
                <div class="col-md-6 wow fadeInRightBig"  data-animation-delay="200" style="visibility: visible; margin-left: 25%;">   
                    <h3 class="section-heading" style="text-align:center;">Param titre H3</h3>
					
                    <p class="lead">
						In his igitur partibus duabus nihil erat, quod Zeno commuta rest gestiret. 
						Sed virtutem ipsam inchoavit, nihil ampliusuma. Scien tiam pollicentur, 
						uam non erat mirum sapientiae lorem cupido
						patria esse cariorem. Quae qui non vident, nihilamane umquam magnum ac cognitione.
					</p>
				</div>  			
			</div>
        </div>
    </div>

<!-- Partie 3 Photos: Mettre une condition si afficher ou pas 
	<div id="screen" class="content-section-b">
        <div class="container">
          <div class="row" >
			 <div class="col-md-6 col-md-offset-3 text-center wrap_title ">
				<h2>Param titre H2</h2>
				<p class="lead" style="margin-top:0">Param texte</p>
			 </div>
		  </div>
		    <div class="row wow bounceInUp" >
              <div id="owl-demo" class="owl-carousel">
				
				<a href="../img/slide/1.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/1.jpg" alt="Owl Image">
					</div>
				</a>
				
               <a href="../img/slide/2.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/2.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="../img/slide/3.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/3.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="../img/slide/4.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/4.jpg" alt="Owl Image">
					</div>
				</a>
				
               <a href="../img/slide/5.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/5.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="../img/slide/6.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="../img/slide/6.jpg" alt="Owl Image">
					</div>
				</a>
              </div>       
          </div>
        </div>


	</div>
	-->
	<!-- Partie 3.1 Blog: Mettre une condition si afficher ou pas -->
<div class="content-section-b"> 	
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<h2>Param Blog</h2>
				<div id="postlist">
					<div class="panel">
						<div class="panel-heading">
							<div class="text-center">
								<div class="row">
									<div class="col-sm-9">
										<h3 class="pull-left">Param titre post 1</h3>
									</div>
									<div class="col-sm-3">
										<h4 class="pull-right">
										<small><em>Param date</em></small>
										</h4>
									</div>
								</div>
							</div>
						</div>
						
					<div class="panel-body">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in... 
					</div>
				</div>
				<div class="panel">
						<div class="panel-heading">
							<div class="text-center">
								<div class="row">
									<div class="col-sm-9">
										<h3 class="pull-left">Param titre post 2</h3>
									</div>
									<div class="col-sm-3">
										<h4 class="pull-right">
										<small><em>Param date</em></small>
										</h4>
									</div>
								</div>
							</div>
						</div>
					<div class="panel-body">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation...
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
	
		
<!-- Partie 4 Contact: Mettre une condition si afficher ou pas -->
	<div id="contact" class="content-section-a">
		<div class="container">
			<div class="row">
			
			<div class="col-md-6 col-md-offset-3 text-center wrap_title">
				<h2>Nous contacter</h2>
			</div>
			
			<form role="form" action="" method="post" >
				<div class="col-md-6">
					<div class="form-group">
						<label for="InputName">Votre nom</label>
						<div class="input-group">
							<input type="text" class="form-control" name="InputName" id="InputName" placeholder="Enter Name" required>
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="InputEmail">Votre Email</label>
						<div class="input-group">
							<input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter Email" required  >
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="InputMessage">Message</label>
						<div class="input-group">
							<textarea name="InputMessage" id="InputMessage" class="form-control" rows="5" required></textarea>
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>

					<input type="submit" name="submit" id="submit" value="Valider" class="btn wow tada btn-embossed btn-primary pull-right">
				</div>
			</form>
			
			<hr class="featurette-divider hidden-lg">
			<!-- A changer pour chaque membre avec les bons param -->
				<div class="col-md-5 col-md-push-1 address">
					<address>
					<h3>Notre adresse</h3>
					<p class="lead"><a href="https://www.google.com/maps/place/Institut+Limayrac/@43.5932659,1.4684558,17z/data=!3m1!4b1!4m5!3m4!1s0x12aebcf7254f26bf:0x62ddf85fb62c1df4!8m2!3d43.593262!4d1.4706445">Param titre<br>
					Param adresse/contact</p>
					</address>

				</div>
			</div>
		</div>
	</div>
	
	
	
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

