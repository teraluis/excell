<?php
require_once('CommandesTete.php');
$commandes = new CommandesTete("commandes.csv");
$commandes->generateLine();
$commandes->createFichier();
$commandes->forcerTelechargement();
?>