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
echo $sav->afficherOutput();
//sleep(60*15);
//$sav->envoiMail("adv@angeleyes-eyewear.com");
?>