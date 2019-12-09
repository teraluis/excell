<?php
require_once("Shote.php");
$chemin=$_GET['fichier'];
if(isset($_GET['fichier'])){
	$chemin=$_GET['fichier'];
	$shote = new Shoote($chemin);
	$shote->generer(10);
	$shote->createfichier("genere/shotes_non_shotes_".$chemin.".csv",",");	
	echo "fichier genere";
}else {
	echo "especifiez n fichier";
}

?>