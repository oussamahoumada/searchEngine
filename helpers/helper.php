<?php
require_once(str_replace("\\helpers","",__DIR__) ."/class/connexion.php");

//Cette fonction permet de separer les mots par une list de separateur donnée
function _multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//Cette fonction return tous les mots et le nobre de repetition de chaque mot d'un fichier donnee
function _loadDataFromFile($path){
    $imp = implode(" ", file($path));
    $ponctuation_arr = [" ","…","!", "?", ".", ",", ";", ":", "(", ")","{","}","[","]","-","+","=","/","\\","d'","d’","l'","l’","s'","s’"];
    $exp = _multiexplode($ponctuation_arr, $imp);
    return array_count_values(_deleteStopWords($exp)); 
}

//Cette fonction permet a supprimer les espaces et transformer majuscule en minuscule
function _deleteSpaces($arr){
    mb_internal_encoding('UTF-8');
    foreach ($arr as $key => $value) {
        $arr[$key] = mb_strtolower($arr[$key]);
        $arr[$key] = trim($arr[$key]);
    }
    return $arr;
}

//Cette fonction permet a supprimer les mot d'arret
function _deleteStopWords($arr){
    $stopWords = file(__DIR__."/stopwords.txt");
    $arr = _deleteSpaces($arr);
    $stopWords = _deleteSpaces($stopWords);
    $tab = array_diff($arr, $stopWords);
    return $tab;
}

//Afficher le resultat
function _afficher($result,$mot,$c){

    //foreach ($result as $key => $value) {
        echo ("<u>Nombre de réponses pour (<b>".$mot."</b>) :</u> ".$c);
        echo ("<br>");
        echo ("<ol>");
        foreach ($result as $k => $v) {
            //echo ("<li>" . $v['path']." (".$v['frequence'].")</li>");
            //$path = "http://localhost/Paris8/TP_Web_Recherche/Rendu/txtFiles/".$v['name'];
            //echo ("<li><a href='".$path."' target='_blank'>".$v['name']."</a>(".$v['frequence'].")</li>");
            $path = "http://localhost/Paris8/TP_Web_Recherche/Rendu/views/affichage/?url=".$v['path'];
            echo ("<li><a href='".$path."' target='_blank'>".$v['name']."</a>(".$v['frequence'].")</li>");
            
        }
        echo ("</ol>");
    //}
}

//Cette fonction permet de chercher un mot dans la base de donnée
function _getWord($word)
{
    try {
        $cnx = new connexion();
        $req = "SELECT name,frequence,path FROM word w inner JOIN indexation i on i.wId=w.wId INNER JOIN file f on  f.fId=i.fId where (w.libelle = :libelle)";
        $prep = $cnx->prepare($req);
        $prep->execute(
            array(
                ':libelle' => $word
            )
        );
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);
        $prep->closeCursor();
    } catch (PDOException $e) {
        print $e->getMessage();
    }
    return $result;
}

function pagination($nbr)
{
    if ((($nbr / 4) * 100000) > (((int) ($nbr / 4)) * 100000)) {
        return ((int) ($nbr / 4)) + 1;
    }
    return ($nbr / 4);
}

//Recuperer les donnees a afficher pour chaque page
function getData($nbr = 1, $arr,$mot,$c)
{
    $filArray = array();
    for ($i=(($nbr-1)*4); $i < (($nbr-1)*4)+4; $i++) { 
        if ($i == count($arr))
            break;
        $filArray[] = $arr[$i];
    }
    _afficher($filArray,$mot,$c);
}