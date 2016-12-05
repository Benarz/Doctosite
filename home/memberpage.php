<?php  

//si l'utilisateur n'est pas connecté, redirection vers la page login.php
if(!$user->is_logged_in()){ header('Location: home/home.php'); } 

?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			
				<h2>Page de membre <?php echo $_SESSION['username']; ?></h2>
				<p><a href='logout.php'>Déconnexion</a></p>
				<hr>

		</div>
	</div>


</div>


