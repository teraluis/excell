<?php
require_once('CommandesLine.php');
$commandes = new CommandesLine("commandes.csv");
$commandes->createFichier();
$commandes->forcerTelechargement();
?>