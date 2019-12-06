<?php
require_once('Hacheur.php');
$nom=$_GET['nomfichier'];
$maxlines=$_GET['maxline'];
$nom=$nom.".csv";

try {
	$hacheur = new Hacheur($nom);
	$hacheur->generateFichiers($maxlines);	
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
	die();
}
echo "<p>Touts les fichiers ont été correctement généres</p>";
?>