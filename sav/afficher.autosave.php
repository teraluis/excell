<?php
require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
echo $sav->afficher();	
$sav->createFichier("sav");
?>