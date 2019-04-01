<?php
echo "<h1>Generation du ficher</h1>";
$fichier = 'suppression.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(',');
$nom= array();
$newnom = array();
foreach($csv as $ligne){
	if($ligne[0]!=NULL ){
		//echo "ligne :".$ligne[0]." <br>";
		array_push($newnom,$ligne[0]."C1");
		array_push($newnom,$ligne[0]."C2");
		array_push($newnom,$ligne[0]."C3");
	}
}

$chemin ='sorties_collection.csv';
$delimiteur =',';
$fichier_csv = fopen($chemin, 'w+');
fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));


$references = $newnom;
$lignes [] = array('references');
foreach($references as $reference){
	$lignes [] = array($reference);
}


echo "<h1>FICHIER pour sorties de collection generé</h1>";
foreach($lignes as $ligne){
	fputcsv($fichier_csv, $ligne, $delimiteur);
}
?>