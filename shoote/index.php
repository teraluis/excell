<?php
require_once("Shoote.php");
$chemin=$_GET['fichier'];
if(isset($_GET['fichier'])){
	$chemin=$_GET['fichier'];
	$shote = new Shoote($chemin);
	$shote->generer(100);
	$shote->createfichier("genere/shotes_non_shotes_".$chemin,",");	
	echo "fichier genere";
}else {
	echo "especifiez n fichier";
}
/*function generer($csv){
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
}*/
?>