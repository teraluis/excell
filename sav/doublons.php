<?php

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}
	function createFichier($nom_fichier,$tab){
		// Paramétrage de l'écriture du futur fichier CSV
		$chemin = $nom_fichier."_".date("dmY").".csv";
		$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";

		// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'w+');

		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
		$ligne0 = array(
				'callid' => "ServiceCallID",
				'origin' =>"origin",
				'calltype'=>"callType",
				'description'=>"description",
				'customercode'=>"CustomerCode",
				'itemcode'=>"ItemCode",
				'subject'=>"subject",
				'upiece'=>"U_Piece",
				'problemetype'=>"ProblemType"
			);
		fputcsv($fichier_csv, $ligne0, $delimiteur);
		$ligne1 = array(
				'callid' => "callID",
				'origin' =>"origin",
				'calltype'=>"callType",
				'description'=>"description",
				'customercode'=>"CustomerCode",
				'itemcode'=>"ItemCode",
				'subject'=>"subject",
				'upiece'=>"U_Piece",
				'problemetype'=>"ProblemType"
			);		
		fputcsv($fichier_csv, $ligne1, $delimiteur);
		// Boucle foreach sur chaque ligne du tableau
		foreach($tab as $ligne){			
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}
		// fermeture du fichier csv
		fclose($fichier_csv);
		$taillefichier=filesize($chemin);
		return $taillefichier;		
	}
function generertableau($tab){
	$csv=array();
	$i=1;
	foreach($tab as $value){
		$infos=explode(",", $value["infos"]);
		if (preg_match("/[A-Z+]{1,4}\d{1,20}/i", $infos[0])) {
		$csv [] = array(
			"callid" => $i,
			"origin" => "-1",
			"calltype" => "1",
			"description" => $value["description"],
			"customercode" => $infos[0],
			"itemcode" => $infos[1],
			"subject" => $infos[2],
			"upiece" => $infos[3],
			"problemtype" => 3
		);		
		$i++;
		}	
	}
	return $csv;
}
	  function forcerTelechargement($poids,$nom_fichier)
	  {
	    header('Content-Type: application/octet-stream');
	    header('Content-Length: '. $poids);
	    header('Content-disposition: attachment; filename='.$nom_fichier );
	    header('Pragma: no-cache');
	    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	    header('Expires: 0');
	    readfile($nom_fichier);
	    exit();
	  }	
require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
$description=array();
$tabgenere= $sav->getLinestab();
$tabsansdoublons= array();
$vartmp=null;
foreach ($tabgenere as $key => $value) {
	$description[$key]=$tabgenere[$key]['description'];
	$vartmp = $tabgenere[$key]['customercode'].",".$tabgenere[$key]['itemcode'].",".$tabgenere[$key]['subject'].",".$tabgenere[$key]['upiece'];
	$tabsansdoublons [] = array(
		"description" => $tabgenere[$key]['description'],
		"infos" => $vartmp
	);
}
$tabsansdoublons = unique_multidim_array($tabsansdoublons,"infos");
$tabsansdoublonsgenre =generertableau($tabsansdoublons);
$nom_fichier="clean_doublons";
$poids = createFichier($nom_fichier,$tabsansdoublonsgenre);

$chemin = $nom_fichier."_".date("dmY").".csv";
forcerTelechargement($poids,$chemin);

?>