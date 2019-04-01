<?php
echo "Recursivite";
$nom = array("MACCA","MACCA","MRGITAR","MRGITAR","MRGITAR","QUEEN OF SOUL","QUEEN OF SOUL","QUEEN OF SOUL","BEATSLAYER","BEATSLAYER","BEATSLAYER");

function ajout_references($nom){
	$taille_nom = count($nom);
	$references =array();
	$c =0;
	for($i=0;$i<$taille_nom;$i++){
		$c=0;
		do{
			if($c<$taille_nom){
				$c++;
			}
			array_push($references,$nom[$i]."C".$c);
		}while($references[$i]==$references[$c]);
	}
	return $references;
}
$new = ajout_references($nom);
var_dump($new);
?>
<h1>Recursivite</h1>