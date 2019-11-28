<?php

require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
	
try {
$sav->createFichier("sav");
	//$sav->envoiMail("adv@angeleyes-eyewear.com");
	$sav->forcerTelechargement();
	echo $sav->afficherOutput();
	//header("Location:suces.php");
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
?>