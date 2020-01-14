<?php
$tabmontures = array();
$montures = file_get_contents('references.txt');
$montures = explode(PHP_EOL, $montures);
for($i=0; $i<count($montures);$i++){
	echo substr($montures[$i],2, strlen($montures[$i])-4)." ".substr($montures[$i],strlen($montures[$i])-2)."<br>";
}
?>