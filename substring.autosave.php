<?php
echo "<h1>Generation du ficher<br>";
$fichier = 'oitm.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(',');
$nom = array();

foreach($csv as $ligne){
	if(!empty($ligne)){
	$tab = explode(';',$ligne[0] );
	//echo $tab[0]." ".$tab[1]."<br>";
	$nom [] = array($tab[0]=>$tab[1]);
	}
}

//var_dump($nom);
//$nom2 = array("MACCA","MACCA","MRGITAR","MRGITAR","MRGITAR","QUEEN OF SOUL","QUEEN OF SOUL","QUEEN OF SOUL","BEATSLAYER","BEATSLAYER","BEATSLAYER");

function substring($noms){
	$counts = $noms;
	$references = array();
	foreach($counts as $key => $count){
		foreach ($count as $key => $value) {
			$deux_letres = substr($key, 0,2);
			//echo $deux_letres."<br>";
			if($deux_letres == "BD" || $deux_letres="BG"){
				//echo "prix ".$value."<br>";
				$value=floatval($value)*0.25; 
				//echo $value."<br>";
			}else if($deux_letres == "FA"){
				$value=floatval($value)*0.5; 
			}else {
				$value = floatval($value);
			}
			$key = substr($key, 2,-);
			//$count = substr($count,0, -2);

			$references [] = array($key,$value);
		}
		//var_dump($counts[$key]);

	}
	return $references;
}

$chemin ='substring.csv';
$delimiteur =',';
$fichier_csv = fopen($chemin, 'w+');
fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
//$nom = array("MACCA","MACCA","MRGITAR","MRGITAR","MRGITAR","QUEEN OF SOUL","QUEEN OF SOUL","QUEEN OF SOUL","BEATSLAYER","BEATSLAYER","BEATSLAYER");

$references = substring($nom);
//var_dump($references);

$lignes [] = array('references','prix');


foreach($references as $key => $reference){
	var_dump($reference[1]);
	$lignes [] = array($reference[0],strval($reference[1]));

}

//var_dump($lignes);
echo "<h1>FICHIER generé</h1>";
foreach($lignes as $ligne){
	fputcsv($fichier_csv, $ligne, $delimiteur);
}
?>
