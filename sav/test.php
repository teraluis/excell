<?php
if (preg_match("/[A-Z+]{1,4}\d{1,20}/i", "C+05708")) {
    echo "Le mot a été trouvé.";
} else {
    echo "Le mot n'a pas été trouvé.";
}
$champs=array("bonjour","cordialment","impo- ssible de vous joindre par tel");
$bodytag = str_replace($champs, "", "bonjour, les branches metalliques de ce modele blesse notre cliente, des branches avec manchons c'est possible? impo- ssible de vous joindre par tel.");
var_dump($bodytag);
?>