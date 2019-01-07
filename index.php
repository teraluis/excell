<?php

function supp_sautlignecsv($chemin){

    $row = 1;
    $newtab = array();
    $temp = "";
    if(($handle = fopen("sav.txt", "r"))!==FALSE){
        while (($data = fgetcsv($handle,1000,","))!==FALSE) {
            $num = count($data);
            /*echo "<p> $num champs à la ligne $row: <br /></p>\n";*/
            $row++;
            if($row>=2){

                for($c=0;$c<$num;$c++){
     
                        
                        
                        if(substr($data[$c],-1)!='' ){
                             if(substr($data[$c],-1)==','){
                                array_push($newtab,$data[$c]);
                             }else {
                                $temp.=$data[$c];
                             }  
                        }

                }
            }else if($row==2){
                for($c=0;$c<$num;$c++){
                    array_push($newtab,$data[$c]);
                }
            }
        }
        var_dump($newtab);
        fclose($handle);

/*        $date = date("dmY");
        if(file_exists('sav_'.$date.'.csv')){
            echo "<h1>Le fichier existe déjà supprimelez svp</h1>";
        }else{
            $fp = fopen('sav_'.$date.'.csv', 'x+');
            var_dump($newtab);
            foreach($newtab as $fields){
                $fields=str_replace("é","e",$fields);
                $fields=str_replace("è","e",$fields);
                
                $fields = array($fields);
                fputcsv($fp, $fields);
            }
            fclose($fp);
        }*/
    }else {
        echo "pb lors de l'ouverture du fichier";
    }
}
$chemin="sav.txt";
supp_sautlignecsv($chemin);
?>