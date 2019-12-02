<?php
require_once('CommandesLine.php');
$commandes = new CommandesLine("commandes.csv");
var_dump($commandes->generate());
?>