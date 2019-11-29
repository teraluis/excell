<?php

require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
try {
	$sav->createFichier("sav");	
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
	die();
}
//$sav->forcerTelechargement();
//echo $sav->afficherOutput();
//sleep(60*15);
//$retour=$sav->envoiMail("adv@angeleyes-eyewear.com");
$retour=$sav->envoiMail("luismanresaramirez@gmail.com");
var_dump($retour);
?>