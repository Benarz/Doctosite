<?php require('includes/config.php'); 

//si l'utilisateur est connecté, redirection vers la page de membre
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $_GET['key']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//s'il n'y a pas de token dans la bdd
if(empty($row['resetToken'])){
	$stop = 'Mauvais code, veuillez utiliser le lien reçu dans vos mails.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Votre mot de passe a déjà été changé';
}

if(isset($_POST['submit'])){

	//validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Mot de passe trop court.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirmation trop courte.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Les mots de passe ne sont pas identiques.';
	}

	//s'il n'y a pas d'erreur, on entre dans la condition
	if(!isset($error)){

		//hash du mot de passe
		$salt = genSalt();
		$hashedpassword = crypt($_POST['password'], $salt);

		try {

			$stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes', salt = :salt  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken'],
				':salt' => $salt,
			));

			header('Location: login.php?action=resetAccount');
			exit;

		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//titre de la page
$title = 'Doctosite';

//ajout du header
require('layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


	    	<?php if(isset($stop)){

	    		echo "<p class='bg-danger'>$stop</p>";

	    	} else { ?>

				<form role="form" method="post" action="" autocomplete="off">
					<h2>Changer le mot de passe</h2>
					<hr>

					<?php
					if(isset($error)){
						foreach($error as $error){
							echo '<p class="bg-danger">'.$error.'</p>';
						}
					}

					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Votre compte est maintenant actif, vous pouvez vous connecter.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Veuillez consulter vos emails, un nouveau lien a été envoyé.</h2>";
							break;
					}
					?>

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="1">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmation" tabindex="1">
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Changer le mot de passe" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
					</div>
				</form>

			<?php } ?>
		</div>
	</div>


</div>

<?php 
//ajout du footer
require('layout/footer.php'); 
?>