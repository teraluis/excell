<?php
echo "<h1>Generation du ficher<br>";
$fichier = 'montures.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(',');
$nom= array();
foreach($csv as $ligne){
	array_push($nom,$ligne[0]);
}
//var_dump($nom);
//$nom2 = array("MACCA","MACCA","MRGITAR","MRGITAR","MRGITAR","QUEEN OF SOUL","QUEEN OF SOUL","QUEEN OF SOUL","BEATSLAYER","BEATSLAYER","BEATSLAYER");
//var_dump($nom2);
function ajout_references($noms){
	$counts = array_count_values($noms);
	$references = array();
	foreach($counts as $count){
		$i=0;
		do {
			$i++;
			echo key($counts)."C$i <br>";
			array_push($references,key($counts)."C".$i);

		}while($i<$count);
		next($counts);
	}
	return $references;
}

$chemin ='seo.csv';
$delimiteur =',';
$fichier_csv = fopen($chemin, 'w+');
fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
//$nom = array("MACCA","MACCA","MRGITAR","MRGITAR","MRGITAR","QUEEN OF SOUL","QUEEN OF SOUL","QUEEN OF SOUL","BEATSLAYER","BEATSLAYER","BEATSLAYER");

$references = ajout_references($nom);
$lignes [] = array('references');
foreach($references as $reference){
	$lignes [] = array($reference);
}

//var_dump($lignes);
echo "<h1>FICHIER generé</h1>";
foreach($lignes as $ligne){
	fputcsv($fichier_csv, $ligne, $delimiteur);
}
?>