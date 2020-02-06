<?php 
$match1 = preg_match("/^[-0-9]{1,2}[.][0-9]{3,200}/", "54.184157");
var_dump($match1);
if($match1==1) {
	echo "ok";
}else if($match1==0) {
	echo "non ok";
}


?>