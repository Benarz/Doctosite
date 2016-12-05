<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Doctosite">
    <meta name="author" content="">

    <title>Doctosite</title>

    <!-- Bootstrap core CSS -->
    <link href="/static/home/style/css/bootstrap.min.css" rel="stylesheet">
 
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
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<script src="/static/home/js/modernizr-2.8.3.min.js"></script>  <!-- Modernizr /-->
	
</head>

<body id="home">

	<!-- Preloader -->
	<div id="preloader">
		<div id="status"></div>
	</div>
	
	<!-- FullScreen -->
    <div class="intro-header">
		<div class="col-xs-12 text-center abcen1">
			<!--<img  class="img-responsive img-rounded" src="/static/home/img/logo.png">-->
			<h1 class="h1_home wow fadeIn" data-wow-delay="0.4s">Doctosite</h1>			
			<h3 class="h3_home wow fadeIn" data-wow-delay="0.6s">Votre vitrine en quelques clics...</h3>
			<ul class="list-inline intro-social-buttons">
				<li><button class="btn  btn-lg mybutton_cyano wow fadeIn" href="#signin" data-toggle="modal" data-target="#mySigninModal">Se connecter</button>
				</li>
				<li><button class="btn  btn-lg mybutton_standard wow swing wow fadeIn" href="#signup" data-toggle="modal" data-target="#mySignupModal">S'enregistrer</button>
				</li>
			</ul>
   
        
    
	
	<!-- Modal -->
<?php 
//si connecté, on redirige vers la page de membre
if( $user->is_logged_in() ){ header('Location: http://doctosite.fr/account/'); }

//si le formulaire est validé, lance la connexion
if(isset($_POST['submitSignin'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$co	= $user->login($username,$password);
	
	if($co == "ok"){ 
		$_SESSION['username'] = $username;
		$query = $db->prepare('UPDATE members SET date_login = :d_login WHERE memberID = :memberID');
		$query->execute(Array(':memberID' => $_SESSION['memberID'], ':d_login' => date('Y-m-d H:i:s')));
		
		header('Location: http://doctosite.fr/account/');
		exit;
	} elseif ($co =="nok") {
		$error[] = 'Mauvais nom d\'utilisateur ou mot de passe, ou votre compte n\'est pas activé.';
	} elseif ($co == "accountOff") {
		$error[] = 'Votre compte est désactivé.';
	} else {
		$error[] = 'Une erreur est survenue.';
	}

}

//si le formulaire a été validé, on entre dans la condition
if(isset($_POST['submitSignup'])){

	
	if(strlen($_POST['username']) < 3){
		$error[] = 'Nom d\'utilisateur trop court.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Nom d\'utilisateur déjà utilisé.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Mot de passe trop court.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Mot de passe de confirmation trop court.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Les mots de passe ne sont pas identiques.';
	}

	//validation par email
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Adresse email non valide.';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Adresse email déjà utilisée.';
		}

	}


	//s'il n'y a pas eu d'erreur, on entre dans la condition
	if(!isset($error)){

		//hash du mot de passe
		$salt = genSalt();
		$hashedpassword = crypt($_POST['password'], $salt);
		$activation		= md5(uniqid(rand(),true));

		try {

			//insertion dans la bdd des informations du membre
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active, salt, date_creation) VALUES (:username, :password, :email, :active, :salt, :d_creation)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activation,
				':salt' => $salt,
				':d_creation' =>  date('Y-m-d H:i:s')
			));
			$id = $db->lastInsertId('memberID');

			// Création des pages perso
			$stmt = $db->prepare('INSERT INTO SiteDraftData (idx_member) VALUES (:id)');
			$stmt->execute(array(':id' => $id));
			$stmt = $db->prepare('INSERT INTO SiteLiveData (idx_member) VALUES (:id)');
			$stmt->execute(array(':id' => $id));
			
			//envoi de l'email
			$to = $_POST['email'];
			$subject = "Confirmation de l'inscription";
			$body = "<p>Merci de votre inscription sur Doctosite.fr</p>
			<p>Afin de finaliser votre inscription, il est n\écessaire de cliquer sur ce lien de confirmation:  <a href='".DIR."home/validate/$id/$activation'>".DIR."home/validate/$id/$activation</a></p>
			<p>Cordialement, L\'\équipe Doctosite.</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirection vers la page d'acceuil
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'|| $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
			//header('Location: '.$protocol.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]);
			header('Location: http://doctosite.fr/home/joined');
			exit;
			
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}
 ?>
	
	
<div class="modal fade bs-modal-sm" id="mySigninModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
	 
        <h4 class="small-modal-title">Connexion</h4>
      
        
       
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
           <div class="tab-pane fade active in" id="signinTab">
            <form class="form-horizontal" method="post" action="">
            <fieldset>
            <!-- Sign In Form -->
			<?php
				if(isset($error)){
					foreach($error as $err){
						echo '<p class="bg-danger">'.$err.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//on passe dans un switch pour les différents cas
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Votre compte est maintenant actif, vous pouvez vous connecter.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Veuillez consulter vos emails, un nouveau lien a été envoyé.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Votre mot de passe a été changé, vous pouvez vous connecter.</h2>";
							break;
					}

				}

				
				?>
            <!-- Text input-->
			
            <div class="control-group">
              <label class="control-label" for="userid">Nom d'utilisateur:</label>
              <div class="controls">
                <input required="" id="username" name="username" type="text" class="form-control" placeholder="Nom d'utilisateur" class="input-medium" required="" tabindex="1" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
              </div>
            </div>

            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="passwordinput">Mot de passe :</label>
              <div class="controls">
                <input required="" id="password" name="password" class="form-control" type="password" placeholder="********" class="input-medium"  tabindex="2">
              </div>
            </div>

            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="signin"></label>
              <div class="row">
				<div class=".col-xs-6 .col-md-4"><input type="submit" name="submitSignin" value="S'identifier" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
			  </div>
			  
            </div>
            </fieldset>
            </form>
			</div>
		</div>
	  </div>
		<div class="modal-footer">
		<center>
			<button type="button" class="btn btn-default" data-dismiss="modal" tabindex="4">Close</button>
        </center>
		</div>
	</div>
  </div>
</div>

<div class="modal fade bs-modal-sm" id="mySignupModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <h4 class="small-modal-title">Inscription</h4>
       
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
           <div class="tab-pane fade active in" id="signupTab">
            <form class="form-horizontal" method="post" action="">
            <fieldset>
            <!-- Sign Up Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="Email">Email:</label>
              <div class="controls">
                <input id="email" name="email" class="form-control" type="text" placeholder="Adresse email" class="input-large" required="" value="<?php if(isset($error) && isset($_POST['email'])){ echo $_POST['email']; } ?>" tabindex="1">
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="userid">Nom d'utilisateur:</label>
              <div class="controls">
                <input id="username" name="username" class="form-control" type="text" placeholder="Nom d'utilisateur" class="input-large" required="" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="2">
              </div>
            </div>
            
            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="password">Mot de passe:</label>
              <div class="controls">
                <input id="password" name="password" class="form-control" type="password" placeholder="********" class="input-large" required="" tabindex="3">
                <em>1-8 Characters</em>
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="reenterpassword">Passe de confirmation:</label>
              <div class="controls">
                <input id="passwordConfirm" class="form-control" name="passwordConfirm" type="password" placeholder="********" class="input-large" required="" tabindex="4">
              </div>
            </div>
            
            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="confirmsignup"></label>
              <div class="row">
					<div class=".col-md-4"><input type="submit" name="submitSignup" value="S'enregistrer" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
            </div>
            </fieldset>
            </form>
      </div>
    </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="6">Close</button>
        </center>
      </div>
    </div>
  </div>
  
</div>
	<div class="col-md-6 col-md-offset-3 text-center wrap_title">
		<?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($joined)){
					echo "<h3 class='bg-success'>Inscription réussie, veuillez consulter vos mails pour activer votre compte.</h3>";
				}
		?>
	</div>
</div>
<!-- /.container -->
		<div class="col-xs-12 text-center abcen wow fadeIn">
			<div class="button_down "> 
				<a class="imgcircle wow bounceInUp" data-wow-duration="1.5s"  href="#whatis"> <img class="img_scroll" src="/static/home/img/icon/circle.png" alt=""> </a>
			</div>
		</div>
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
					
					<li class="menuItem"><a href="#whatis">Qui sommes-nous?</a></li>
					<li class="menuItem"><a href="#useit">Comment créer sa vitrine?</a></li>
					<li class="menuItem"><a href="#screen">Exemples</a></li>
					<li class="menuItem"><a href="#contact">Contact</a></li>
				</ul>
			</div>
		   
		</div>
	</nav> 
	
	<!-- Qui sommes-nous? -->
	<div id="whatis" class="content-section-b" style="border-top: 0">
		<div class="container">

			<div class="col-md-6 col-md-offset-3 text-center wrap_title">
				<h2>Qui sommes-nous?</h2>
				<p class="lead" style="margin-top:0">Nous sommes une société indépendante qui souhaite fournir aux professions du mileux médical un moyen simple et rapide de se mettre en avant sur le Web.</p>
				
			</div>
			
			<div class="row">
			
				
				
				<div class="col-sm-4 wow fadeInDown text-center">
				  <img  class="rotate" width="130" src="/static/home/img/icon/company.svg" alt="Generic placeholder image">
				   <h3>L'entreprise</h3>
				   <p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				   <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
				<div class="col-sm-4 wow fadeInDown text-center">
				  <img  class="rotate" width="130" src="/static/home/img/icon/cardiogram.svg" alt="Generic placeholder image">
				   <h3>Nos objectifs</h3>
					<p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				  <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
				<div class="col-sm-4 wow fadeInDown text-center">
				  <img  class="rotate" width="130" src="/static/home/img/icon/stethoscope.svg" alt="Generic placeholder image">
				   <h3>Les autres marques</h3>
					<p class="lead">Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. </p>
				  <!-- <p><a class="btn btn-embossed btn-primary view" role="button">View Details</a></p> -->
				</div><!-- /.col-lg-4 -->
				
			</div><!-- /.row -->
			
		</div>
	</div>
	
	
<!-- Créer sa vitrine? -->
    <div class="content-section-b"> 
		
		<div class="container">
            <div class="row">
                <div class="col-sm-6 wow fadeInLeftBig">
                     <div id="owl-demo-1" class="owl-carousel">
						<a href="/static/home/img/first_step.jpg" class="image-link">
							<div class="item">
								<img  class="img-responsive img-rounded" width="130" src="/static/home/img/first_step.jpg" alt="">
							</div>
						</a>
						<a href="/static/home/img/second_step.jpg" class="image-link">
							<div class="item">
								<img  class="img-responsive img-rounded" width="130" src="/static/home/img/second_step.jpg" alt="">
							</div>
						</a>
						<a href="/static/home/img/third_step.jpg" class="image-link">
							<div class="item">
								<img  class="img-responsive img-rounded" width="130" src="/static/home/img/third_step.jpg" alt="">
							</div>
						</a>
					</div>       
                </div>
				
                <div class="col-sm-6 wow fadeInRightBig"  data-animation-delay="200">   
                    <h3 class="section-heading">Comment créer sa vitrine?</h3>
					
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

	<!-- Exemples -->
	<div id="screen" class="content-section-b">
        <div class="container">
          <div class="row" >
			 <div class="col-md-6 col-md-offset-3 text-center wrap_title ">
				<h2>Exemples</h2>
				<p class="lead" style="margin-top:0">Idées de template pour votre vitrine</p>
			 </div>
		  </div>
		    <div class="row wow bounceInUp" >
              <div id="owl-demo" class="owl-carousel">
				
				<a href="/static/home/img/slide/1.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/1.jpg" alt="Owl Image">
					</div>
				</a>
				
               <a href="/static/home/img/slide/2.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/2.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="/static/home/img/slide/3.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/3.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="/static/home/img/slide/4.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/4.jpg" alt="Owl Image">
					</div>
				</a>
				
               <a href="/static/home/img/slide/5.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/5.jpg" alt="Owl Image">
					</div>
				</a>
				
				<a href="/static/home/img/slide/6.jpg" class="image-link">
					<div class="item">
						<img  class="img-responsive img-rounded" src="/static/home/img/slide/6.jpg" alt="Owl Image">
					</div>
				</a>
              </div>       
          </div>
        </div>


	</div>
	
		
	<!-- Contacts -->
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
				<div class="col-md-5 col-md-push-1 address">
					<address>
					<h3>Notre adresse</h3>
					<p class="lead"><a href="https://www.google.com/maps/place/Institut+Limayrac/@43.5932659,1.4684558,17z/data=!3m1!4b1!4m5!3m4!1s0x12aebcf7254f26bf:0x62ddf85fb62c1df4!8m2!3d43.593262!4d1.4706445">Institut Limayrac<br>
					Adresse blablabla</a><br>
					Tél: 01 23 45 56 78<br>
					Fax: 01 23 45 56 87<br>
					Email: blabla@doctosite.fr</p>
					</address>

					<h3>Réseaux sociaux</h3>
					<li class="social"> 
					<a href="#"><i class="fa fa-facebook-square fa-size"> </i></a>
					<a href="#"><i class="fa  fa-twitter-square fa-size"> </i> </a> 
					<a href="#"><i class="fa fa-google-plus-square fa-size"> </i></a>
					<a href="#"><i class="fa fa-flickr fa-size"> </i> </a>
					</li>
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
	<script type="text/javascript">

	</script>
</body>

</html>
