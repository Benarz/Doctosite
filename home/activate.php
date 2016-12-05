<?php

// Included
$memberID = array_shift($params);
$active = array_shift($params);

//si l'ID est un nombre et que le token n'est pas vite, on entre dans la condition
if(is_numeric($memberID) && !empty($active)){

	$query = $db->prepare("SELECT * FROM members WHERE memberID = :memberID AND active = :active");
	$query->execute(array(
		':memberID' => $memberID,
		':active' => $active
	));
	$check = $query->fetch(PDO::FETCH_ASSOC);
	
	// Si le résultat concorde on active le compte
	if ($check){
		$stmt = $db->prepare("UPDATE members SET active = 'Yes' WHERE memberID = :memberID AND active = :active");
		$stmt->execute(array(
			':memberID' => $memberID,
			':active' => $active
		));
		$message = "Votre compte a été activé.<br>Vous pouvez retourner à la page d'accueil et vous connecter.";
	}else {
		$message = "Erreur lors de l'activation de votre compte.";
		$error = true;
	}
	
}
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
    <link href="/static/home/style/bootstrap.min.css" rel="stylesheet">
 
    <!-- Custom Google Web Font -->
    <link href="/static/home/style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
	
    <!-- Custom CSS-->
    <link href="/static/home/style/css/general.css" rel="stylesheet">
	
	 <!-- Owl-Carousel -->
    <link href="/static/home/style/css/custom.css" rel="stylesheet">
	<link href="/static/home/style/css/owl.carousel.css" rel="stylesheet">
    <link href="/static/home/style/css/owl.theme.css" rel="stylesheet">
	<link href="/static/home/style/css/style.css" rel="stylesheet">
	<link href="/static/home/style/css/animate.css" rel="stylesheet">
	
	<!-- Popup core CSS file -->
	<link rel="stylesheet" href="/static/home/style/css/magnific-popup.css"> 
	
	<script src="/static/home/js/modernizr-2.8.3.min.js"></script>  <!-- Modernizr /-->

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
				<a class="navbar-brand" href="http://doctosite.fr">Doctosite</a>
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
background: url(/static/home/img/intro/intro5.jpg) no-repeat center center;
background-size: cover;}
</style>

<div class="container">
    <div class="row">
        

		<div class="col-md-6 col-md-offset-3 text-center wrap_title">
            <div class="alert alert-<?php echo isset($error)?"danger":"success";?>
                
                <strong>Information</strong>
                <hr class="message-inner-separator">
                <p>
					<?php echo $message; ?>
				</p>
            </div>
        </div>	
	
    <footer>
      
    </footer>

    <!-- JavaScript -->
    <script src="/static/home/js/jquery-1.10.2.js"></script>
    <script src="/static/home/js/bootstrap.js"></script>
	<script src="/static/home/js/owl.carousel.js"></script>
	<script src="/static/home/js/script.js"></script>
	<!-- StikyMenu -->
	<script src="/static/home/js/stickUp.min.js"></script>
	<script type="text/javascript">
	  jQuery(function($) {
		$(document).ready( function() {
		  $('.navbar-default').stickUp();
		  
		});
	  });
	
	</script>
	<!-- Smoothscroll -->
	<script type="text/javascript" src="/static/home/js/jquery.corner.js"></script> 
	<script src="/static/home/js/wow.min.js"></script>
	<script>
	 new WOW().init();
	</script>
	<script src="/static/home/js/classie.js"></script>
	<script src="/static/home/js/uiMorphingButton_inflow.js"></script>
	<!-- Popup core JS file -->
	<script src="/static/home/js/jquery.magnific-popup.js"></script> 
</body>

</html>