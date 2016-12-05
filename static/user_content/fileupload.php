<html>
<head>
  <meta charset="utf-8">
</head>
<body>
<?php

session_start();

$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("jpeg", "jpg", "png");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {    
    // Copie dans le repertoire du script avec un nom
    // incluant l'heure a la seconde pres 
    $repertoireDestination = dirname(__FILE__)."/";
    $nomDestination = $_SESSION['memberID']."_logo.".$extensionFichier;

    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                     $repertoireDestination.$nomDestination)) {
        echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                " a été déplacé vers ".$repertoireDestination.$nomDestination;
    } else {
        echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                "Le déplacement du fichier temporaire a échoué".
                " vérifiez l'existence du répertoire ".$repertoireDestination;
    }
}
?>

<a href="http://doctosite.fr/acount">Retour à votre profil</a>
</body>
</html>