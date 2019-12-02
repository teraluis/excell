<?php
require_once('CommandesLine.php');
$commandes = new CommandesLine("commandes.csv");
$commandes->generateLine();
$commandes->createFichier();
$commandes->forcerTelechargement();
?>