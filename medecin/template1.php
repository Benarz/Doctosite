<?php
			if (isset($_POST["submitContact"])) {
				$nameContact = $_POST['nameContact'];
				$emailContact = $_POST['emailContact'];
				$messageContact = $_POST['messageContact'];
				$from = 'Fiche de contact de votre site.'; 
				$to = $user['email']; 
				$subject = 'Email provenant de votre fiche contact. ';
				
				$body ="From: $nameContact\n E-Mail: $emailContact\n Message:\n $messageContact";
				
				$mailContact = new Mail();
				
				$mailContact->setFrom(SITEEMAIL);
				$mailContact->addAddress($to);
				$mailContact->subject($subject);
				$mailContact->body($body);
				
			// envoi de l'email
			$boolContact='0';
			if (!$mailContact->send()) {
					//$resultContact='<div class="alert alert-danger">Erreur lors de l\'envoi.</div>';
					$boolContact='1';
				} else {
					//$resultContact='<div class="alert alert-success">Vous message a bien été envoyé. Merci.</div>';
					$boolContact='2';
				}
			
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'|| $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
			header('Location: '.$protocol.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]."?"."&Contact=".$boolContact."/#contact");
			exit;
			}

// Récupération des posts du blog
$query = $db->prepare('SELECT * FROM BlogPosts WHERE idx_member = :memberID');
$query->execute(Array(':memberID' => $id));
while($row = $query->fetch(PDO::FETCH_ASSOC)){
	$posts [] = $row;
};

			
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Param Decription">
    <meta name="author" content="">

    <title><?php echo $user['content_titleSite']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/static/home/style/css/bootstrap.min.css" rel="stylesheet">
 
    <!-- Custom Google Web Font -->
    <link href="/static/home/style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
	
    <!-- Custom CSS-->
    <link href="/static/home/style/css/general<?php echo $user['template']; ?>.css" rel="stylesheet">
	
	 <!-- Owl-Carousel -->
    <link href="/static/home/style/css/custom.css" rel="stylesheet">
	<link href="/static/home/style/css/owl.carousel.css" rel="stylesheet">
    <link href="/static/home/style/css/owl.theme.css" rel="stylesheet">
	<link href="/static/home/style/css/style.css" rel="stylesheet">
	<link href="/static/home/style/css/animate.css" rel="stylesheet">
	
	<!-- Popup core CSS file -->
	<link rel="stylesheet" href="/static/home/style/css/magnific-popup.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
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
				<a class="navbar-brand" href="http://doctosite.fr/medecin/<?php echo $user['firstName'],"-",$user['lastName'],"-",$user['adrCodePostal'],"/",$user['idx_member'];?>"><?php echo $user['content_titleSite']; ?></a>
			</div>

			<div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
				<ul class="nav navbar-nav">
				
					<!-- Remplacer les params par les bons contenus dans la BDD -->
					<li class="menuItem"><a href="#infos1"><?php echo $user['content_titleChapter']; ?></a></li>
					<li class="menuItem"><a href="#infos2"><?php echo $user['content_titleCat2']; ?></a></li>
					<?php if($user['blog']){?><li class="menuItem"><a href="#blog">Blog</a></li><?php }?>
					<li class="menuItem"><a href="#contact">Contact</a></li>
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
	<div id="infos1" class="content-section-b" style="border-top: 0">
		<div class="container">

			<div class="col-md-6 col-md-offset-3 text-center wrap_title">
				<h2><?php echo $user['content_titleChapter']; ?></h2>
				<p class="lead" style="margin-top:0"><?php echo $user['content_desc1']; ?></p>
				
			</div>
			
			<div class="row">
			
				
				
				<div class="col-sm-4 wow fadeInDown text-center">
				 <!-- <img  class="rotate" width="130" src="../img/icon/company.svg" alt="Generic placeholder image">
				   <h3>Param Cat1</h3>
				   <p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				   <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
				<div class="col-sm-4 wow fadeInDown text-center">
				  <img  width="130" src="/static/user_content/<?php echo $user['content_logo']; ?>" alt="Generic placeholder image">
				   <h3><?php echo $user['content_titleCat1']; ?></h3>
					<p class="lead"><?php echo $user['content_descCat1']; ?></p>
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
		<!-- /.container -->
		
			<div class="button_down " style="text-align: center; margin-bottom: -60px;"> 
				<a href="#infos1"> <img class="img_scroll" style="width: 20px;" src="/static/home/img/arrow.png" alt=""> </a>
			</div>
		
	</div>
	
	
<!-- Partie 2 Bloc infos: Mettre une condition si afficher ou pas -->
    <div id="infos2" class="content-section-b">  
		
		<div class="container">
            <div class="row">
                				
                <div class="col-md-6 wow fadeInRightBig"  data-animation-delay="200" style="visibility: visible; margin-left: 25%;">   
                    <h3 class="section-heading" style="text-align:center;"><?php echo $user['content_titleCat2']; ?></h3>
					
                    <p class="lead">
						<?php echo $user['content_descCat2']; ?>
					</p>
				</div>  			
			</div>
        </div>
		<!-- /.container -->
		
			<div class="button_down " style="text-align: center; margin-bottom: -60px;"> 
				<a href="#infos1"> <img class="img_scroll" style="width: 20px;" src="/static/home/img/arrow.png" alt=""> </a>
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
<?php
if (!empty($posts) && $user['blog']){
?>
<div id="blog" class="content-section-b"> 	
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<h2>Dernières entrées</h2>
				<?php
					foreach($posts as $post){
				?>
					<div class="panel">
						<div class="panel-heading">
							<div class="text-center">
								<div class="row">
									<div class="col-sm-9">
										<h3 class="pull-left"><?php echo $post['titre']; ?></h3>
									</div>
									<div class="col-sm-3">
										<h4 class="pull-right">
										<small><em><?php echo $post['date']; ?></em></small>
										</h4>
									</div>
								</div>
							</div>
						</div>
						
					<div class="panel-body">
						<?php echo $post['corps'] ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- /.container -->
		
			<div class="button_down " style="text-align: center; margin-bottom: -60px;"> 
				<a href="#infos1"> <img class="img_scroll" style="width: 20px;" src="/static/home/img/arrow.png" alt=""> </a>
			</div>
</div>
<?php 
}
?>
		
<!-- Partie 4 Contact: Mettre une condition si afficher ou pas -->

	<div id="contact" class="content-section-a">
		<div class="container">
			<div class="row">
			
			<div class="col-md-6 col-md-offset-3 text-center wrap_title">
				<h2>Prendre contact</h2>
			</div>
			
			<form role="form" action="" method="post" >
				<div class="col-md-6">
					<div class="form-group">
						<label for="InputName">Votre nom</label>
						<div class="input-group">
							<input type="text" class="form-control" name="nameContact" id="nameContact" placeholder="Enter Name" value="" required>
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="InputEmail">Votre Email</label>
						<div class="input-group">
							<input type="email" class="form-control" id="emailContact" name="emailContact" placeholder="Enter Email" value="" required  >
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="InputMessage">Message</label>
						<div class="input-group">
							<textarea name="messageContact" id="messageContact" class="form-control" rows="5" value="" required></textarea>
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
						</div>
					</div>
					<input type="submit" name="submitContact" id="submitContact" value="Valider" class="btn wow tada btn-embossed btn-primary pull-right">
						<?php 
						if (isset($_GET["Contact"])){
							$boolContact=$_GET["Contact"];
							if ($boolContact[0]=='1'){
								$resultContact='<div class="alert alert-danger">Erreur lors de l\'envoi.</div>';
							}
							if ($boolContact[0]=='2'){
								$resultContact='<div class="alert alert-success">Vous message a bien été envoyé. Merci.</div>';
							}
						}
						if (isset($resultContact)) { echo $resultContact;} ?>
					
				</div>
			</form>
				
			<hr class="featurette-divider hidden-lg">
			<!-- A changer pour chaque membre avec les bons param -->
				<div class="col-md-5 col-md-push-1 address">
					<address>
					<h3>Adresse</h3>
					<p class="lead"><?php echo $user['lastName']," ",$user['firstName']; ?><br>
					<?php echo $user['adrRue'];?> <br>
					<?php echo $user['adrCodePostal']," ",$user['adrVille'];?> <br>
					Fixe: <?php echo $user['telFixe'];?> <br>
					Mobile: <?php echo $user['telMobile'];?> <br><br><br>
					<?php echo $user['email'];?>
					</p>
					</address>

				</div>
			</div>
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

