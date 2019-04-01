<?php

$noms = array("ANGER","ANGER","ANGER","BLUEDEEP","BLUEDEEP","MECHANTE","MECHANTE","STEAMPUNK","STEAMPUNK");
$counts = array_count_values($noms);
var_dump($noms);
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
var_dump($references);

?>
