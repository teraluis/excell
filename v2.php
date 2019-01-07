<?php
function getfile($chemin){
    $file = file_get_contents($chemin);
    $tab = explode(",", $file);
    
/*    $header = array("id","Title","Date","Code Magasin","Type","ItemCode","Remarques",
        "Paire de branche","Branche gauche","Branche droite","Verres présentation","Verres solaires",
        "Face","Tenon","Vis plaquettes","Vis face","Vis branches","Manchon",
        "Plaquettes","Vis","Manchon gauche","Manchon droit","Tenon gauche","Tenon droit");*/
        $tab_vide = array();
    foreach ($tab as $mot) {
    	array_push($tab_vide,substr($mot,-2));
    }
    $text = implode(",", $files);
    $test=fopen("letres.txt","w");
    fwrite($test, $text);
    return $file;
}
function supp_sautligne($chemin){
    $file = file_get_contents($chemin);
    $tab = explode(" ", $file);

    $new_tab= array();
    foreach($tab as $texte){
            $texte =trim($texte);
            $texte=str_replace(array("\r","\n","\t","\r\n","\r\n\t","\r\t"),"",$file); 
            $texte=str_replace(array("Ã©"),'é',$file); 
            /*$texte = substr($texte, 0,500);*/
            
            array_push($new_tab,$texte);
    }
    var_dump($new_tab);
    $new_tab = implode(" ", $new_tab);
     
    /*echo $new_tab;*/
    $date = date("dmY");
    $test=fopen("sav_".$date.".txt","w");
    fwrite($test, $new_tab);

    return $file;
}
function supp_sautlignecsv($chemin){

    $row = 1;
    $newtab = array();
    $temp = "";
    if(($handle = fopen("sav.txt", "r"))!==FALSE){
        while (($data = fgetcsv($handle,1000,","))!==FALSE) {
            $num = count($data);
            echo "<p> $num champs à la ligne $row : <br/></p>\n";
            $row++;
            if($row>2){
                for($c=0;$c<$num;$c++){
                    echo "<b>".$data[$c]."</b><br/>\n";
                        
                        str_replace("é","e",$data[$c]);
                        str_replace("è","e",$data[$c]);
                        if(substr($data[$c],-1)=="," && $temp==""){

                            str_replace(array("\r","\n","\t","\r\n","\r\n\t","\r\t"),"",$data[$c]);
                            array_push($newtab,$data[$c]);
                            
                            var_dump($newtab);
                        }else if(substr($data[$c],-1)=="," && $temp!=""){
                            $temp.=$data[$c];
                            /*echo "temp = ".$temp;*/
                           
                            array_push($newtab,$temp);
                          
                            /*var_dump($newtab);*/
                            
                            $temp="";
                        }
                        else if(substr($data[$c],-1)!="," ){
                            
                            $temp.=$data[$c]." ";
                            /*echo "variable temporaire = ".$temp;*/
                        }else {
                            array_push($newtab,$temp);
                        }
                        
                }
            }else {
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
            
            foreach($newtab as $fields){
                $fields=str_replace("é","e",$fields);
                $fields=str_replace("è","e",$fields);
                echo $fields."<br>";
                $tableau = array($fields);
                fputcsv($fp, $tableau);
            }
            fclose($fp);
        }*/
    }else {
        echo "pb lors de l'ouverture du fichier";
    }
}
function modfierItemCode($nom){
    $date = date("dmY");
    $newtab=array();
    $handle = fopen($nom.'_'.$date.'.csv', "r");
    while (($data = fgetcsv($handle,1000,","))!==FALSE) {
        for($c=0;$c<$num;$c++){
            if($data[$c]=="item code"){
            $data[$c]=str_replace("item code","ItemCode",$data[$c]);
            array_push($newtab,$data[$c]); 
            }
            else if($data[$c]=="Code Magasin"){
            $data[$c]=str_replace("Code Magasin","CustomerCode",$data[$c]);
                array_push($newtab,$data[$c]); 
            }
            else{
                array_push($newtab,$data[$c]);
            }
        }
    }
    return $newtab;
    fclose($handle);
}
function u_piece($nom){
    $date = date("dmY");
    $list = array (
       array('aaa', 'bbb', 'ccc', 'dddd'),
       array('123', '456', '789'),
       array('"aaa"', '"bbb"')
    );
    $handle = fopen($nom.'_'.$date.'.csv', "w");
    fputcsv($handle, array("u_piece"),";");
    foreach ($list as $fields) {
        fputcsv($handle, $fields);
    }
    fclose($handle);
}
$chemin="sav.txt";
supp_sautlignecsv("sav");
//$tab = modfierItemCode("sav");
//u_piece("sav");
?>