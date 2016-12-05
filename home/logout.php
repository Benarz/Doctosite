<?php require('includes/config.php');

//logout
$user->logout(); 

header('Location: index.php');
exit;
?>