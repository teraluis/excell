<?php

function supp_sautlignecsv($chemin){

    $row = 1;
    $newtab = array();
    $temp ="";
    $regex = "#[0-9]#";
    
    if(($handle = fopen("sav.txt", "r"))!==FALSE){
        while (($data = fgetcsv($handle,1000,","))!==FALSE) {
            $num = count($data);
            echo "<p> $num champs à la ligne $row: <br /></p>\n";
            
            if($row>=2){

                for($c=0;$c<$num;$c++){
     
                        echo "<b>".$data[$c]."</b><br>";
                        $ligne=trim($data[$c]);
                        $dernier_caractere=substr($ligne,-1);
                        echo "dernier caractere : ".$dernier_caractere."</br>";
                        $condition = ($dernier_caractere=="," || $dernier_caractere=="\"" || preg_match($regex, $dernier_caractere) || $dernier_caractere=="'");
                        if($condition && $temp==""){
                            array_push($newtab,$ligne);
                        }else if(!$condition && $temp==""){
                            $temp.=$ligne." ";
                        }else if($condition && $temp!=""){
                            $temp.=$ligne;
                            array_push($newtab,$temp);
                            $temp="";
                        }else if(!$condition && $temp!=""){
                            $temp.=$ligne." ";
                        }


                }
            }else if($row==1) {
                
                for($c=0;$c<$num;$c++){
                    echo "<b>".$data[$c]."</b><br>";
                        $data[$c]=trim($data[$c]);
                        echo "premier caractere : ".substr($data[$c],-1);
                        array_push($newtab,$data[$c]);
                }
            }
            $row++;
        }
        var_dump($newtab);
        fclose($handle);

        $date = date("dmY");
        if(file_exists('sav_'.$date.'.csv')){
            echo "<h1>Le fichier existe déjà supprimelez svp</h1>";
        }else{
            $fp = fopen('sav_'.$date.'.csv', 'x+');
       
            foreach($newtab as $fields){
                $fields=str_replace("é","e",$fields);
                $fields=str_replace("è","e",$fields);
                
                $fields = array($fields);
                fputcsv($fp, $fields);
            }
            echo "<h1>Fichier genere</h1>";
            fclose($fp);
        }
    }else {
        echo "pb lors de l'ouverture du fichier";
    }
}
$chemin="sav.txt";
supp_sautlignecsv($chemin);
?>