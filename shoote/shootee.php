<!DOCTYPE html>
<html>
<head>
	<title>montures solaires</title>
</head>
<body>
<p>Ce script a pour but de  sortir les montures shootees non shootees</p>	
<?php
$fichier = 'montures_mazette.csv';
$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(';');
function url_exists($url){


    $url = get_headers($url);
    $url0= $url[0];
    
    if ($url0 == 'HTTP/1.1 404 Not Found') {
        return FALSE;

    } else if($url0=='HTTP/1.1 200 OK'){ 
        return TRUE;
    } else {
        return FALSE;
    }
}
function generer($csv){
	$limit =200;
	$i=60;
	$montures = array();
	foreach($csv as $ligne){
        $pattern = '/(^FO)|(^FS)|(^VS)|(^VO)|(^LV)|(^MS)|(^MO)/i';
        $input = array(substr($ligne[0], 0));
      
        if(preg_grep($pattern, $input) && $i<$limit){
            $photo_file = 'https://revendeurs.angeleyes-eyewear.com/EspaceRevendeur/pic/'.$ligne[0].'_1.jpg';
            echo "<tr>";
            if (url_exists($photo_file)==true){
            	$bol=1;
            	array_push($montures,array(substr($ligne[0], 0)));
            }else {
            	$bol=0;
            }
        }
        $i++;
	}
	return $montures;	
}
function afficher($montures){
	$tab="<table>";
	foreach($montures as $ligne){
		$tab.="<tr>";
        $tab.= "<td>".$ligne[0]."</td>";
        $tab.= "<td>1</td>";
        $tab.= "</tr>";        
	}
	$tab.="</table>";
	return $tab;
}
function create_fichier($nom_fichier,$tab){

$chemin = $nom_fichier;
$delimiteur = ','; 


$fichier_csv = fopen($chemin, 'w+');

fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
fputcsv($fichier_csv, array('itemcode','U_Shoote'), $delimiteur);
fputcsv($fichier_csv, array('itemcode','U_Shoote'), $delimiteur);
foreach($tab as $key => $value){
	$tab2 =$tab[$key];
	array_push($tab2, "Oui");
	$ligne =$tab2 ;
	fputcsv($fichier_csv, $ligne , $delimiteur);
}

// fermeture du fichier csv
fclose($fichier_csv);

}
$montures = generer($csv);

//create_fichier("montures_shooteees28oct.csv",$montures);
?>

<?php
	echo afficher($montures);
?>
</body>
</html>