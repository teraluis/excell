<?php
require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
echo $sav->afficher();	
try {
$sav->createFichier("sav");
	$sav->envoiMail("luismanresa@angeleyes-eyewear.com");
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
?>