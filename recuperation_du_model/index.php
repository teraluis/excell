<!-- 
rename *"C1.jpg" *"C1_1.jpg"
rename *"C2.jpg" *"C2_1.jpg"
rename *"C3.jpg" *"C3_1.jpg"
rename *"C4.jpg" *"C4_1.jpg" -->

<?php
$tabmontures_ok = array();
$tabmontures_non_ok = array();
$directory= scandir("C:\Users\luis.manresa\Pictures\MONTURES ESPACE REVENDEUR 2020");
function maregex($itemcode){
	if (preg_match("/^(FO|LO|VO|VS|MS|MO){1}[A-Z]{2,30}[C]{1}[1-9]{1}[_]{1}[1]{1}(\.jpg)/i", $itemcode)) {//{1}[A-Z]{2,50}[C]{1}[1-10]{1}[_][1-2][.jpg]
	//echo "<p>$itemcode monture ok.</p>";
		return true;
	} else {
	//echo "<p>$itemcode monture non ok</p>";
		return false;
	}
}

foreach ($directory as $key => $value) {
	if(maregex($value)){
		array_push($tabmontures_ok, $value);
	}else {
		array_push($tabmontures_non_ok, $value);
	}
}

foreach ($tabmontures_ok as  $value) {
	file_put_contents("montures_ok.txt", $value."\n\r", FILE_APPEND | LOCK_EX);
}
foreach ($tabmontures_non_ok as  $value) {
	file_put_contents("montures_nonok.txt", $value."\n\r", FILE_APPEND | LOCK_EX);
}

$montures = file_get_contents('montures_ok.txt');

$montures = explode("\n\r", $montures);

for($i=0; $i<count($montures);$i++){
	echo substr($montures[$i],2, strlen($montures[$i])-8)."<br>";
}
?>