<?php

require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
	
try {
	$sav->createFichier("sav");	
	
	echo $sav->afficherOutput();
	//header("Location:suces.php");
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
	die();
}
sleep(60*30);
//$sav->forcerTelechargement();
//$sav->envoiMail("adv@angeleyes-eyewear.com");
?>