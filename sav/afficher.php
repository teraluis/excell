<?php
require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->uPiece();
echo $sav->afficher();
?>