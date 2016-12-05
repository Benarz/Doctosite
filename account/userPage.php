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
					<li class="menuItem"><a href="http://doctosite.fr/account/create">Créer ma page</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/edit">Editer ma page</a></li>
					<li class="menuItem"><a href="http://doctosite.fr/account/info">Editer mes informations</a></li>
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
</style>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Construisez votre page</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Nom de votre page</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" placeholder="" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasicSpec">Spécialité</label>
  <div class="col-md-4">
    <select id="selectbasicSpec" name="selectbasicSpec" class="form-control">
      <option value="1">Medecin</option>
      <option value="2">Psy</option>
      <option value="3">Chirurgien</option>
      <option value="4">Véto</option>
      <option value="5">Autre</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasicAutre">Autre domaine</label>
  <div class="col-md-4">
    <select id="selectbasicAutre" name="selectbasicAutre" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Votre logo</label>
  <div class="col-md-4">
    <input id="filebutton" name="filebutton" class="input-file" type="file">
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="checkboxes">Option de la page</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="checkboxes-0">
      <input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
      Blog
    </label>
    <label class="checkbox-inline" for="checkboxes-1">
      <input name="checkboxes" id="checkboxes-1" value="2" type="checkbox">
      Album Photo
    </label>
    <label class="checkbox-inline" for="checkboxes-2">
      <input name="checkboxes" id="checkboxes-2" value="3" type="checkbox">
      Carte GoogleMap
    </label>
    <label class="checkbox-inline" for="checkboxes-3">
      <input name="checkboxes" id="checkboxes-3" value="4" type="checkbox">
      Autre
    </label>
  </div>
</div>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectmultiple">Style de page</label>
  <div class="col-md-4">
    <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple">
      <option value="1">Style 1</option>
      <option value="2">Style 2</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textareaADR">Adresse</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textareaADR" name="textareaADR"></textarea>
  </div>
</div>

</fieldset>
</form>
    <footer>
      
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
