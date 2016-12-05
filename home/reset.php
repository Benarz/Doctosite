<?php require('includes/config.php');

//si connecter, redirection vers la page membre
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }


if(isset($_POST['submit'])){

	//validation par mail
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Veuillez entrer une adresse mail valide.';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'L\'adresse email n\'est pas reconnue.';
		}

	}

	if(!isset($error)){

		//création du code d'activation
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//envoi du mail
			$to = $row['email'];
			$subject = "Réinitialisation du mot de passe";
			$body = "<p>Vous avez demandé à réinitialiser votre mot de passe.</p>
			<p>En cas d'erreur, ne tenez pas compte de ce mail.</p>
			<p>Pour réinitialiser votre mot de passe, cliquez sur le lien suivant: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			header('Location: login.php?action=reset');
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
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Réinitialiser le mot de passe</h2>
				<p><a href='login.php'>Retour sur la page de connexion</a></p>
				<hr>

				<?php
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Votre compte est maintenant actif, vous pouvez vous connecter.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Veuillez consulter vos emails, un nouveau lien a été envoyé.</h2>";
							break;
					}
				}
				?>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="" tabindex="1">
				</div>

				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Réinitialiser le mot de passe" class="btn btn-primary btn-block btn-lg" tabindex="2"></div>
				</div>
			</form>
		</div>
	</div>


</div>

<?php
//ajout du footer
require('layout/footer.php');
?>
