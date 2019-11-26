<!DOCTYPE html>
<html>
<head>
	<title>montures solaires</title>
</head>
<body>
<p>Ce script a pour but de  sortir les montures qui sont solaires et qui ne sont pas polarisées</p>	
<?php
$fichier = '26072019FINAL.csv';
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
function afficher($csv){
	foreach($csv as $ligne){
        $photo_file = 'https://revendeurs.angeleyes-eyewear.com/EspaceRevendeur/pic/'.$ligne[0].'_1.jpg';
        echo "<tr>";
        if (url_exists($photo_file)==true){
        	$bol=1
        }else {
        	$bol=0;
        }
        echo "<td>".$ligne[0]."</td>";
        echo "<td>".$bol."</td>";
        echo "</tr>";
	}	
}  
?>
<table border="1">
	<tr>
		<td>ref</td>
		<td>enmagasin</td>
	</tr>
<?php
	afficher($csv);
?>
</table>
</body>
</html>