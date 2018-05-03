<?php

function recogeTexto($campo){
    return preg_replace("/[^a-zA-ZÀ-ÿ\s]/", "", strip_tags($campo));
}

function recogeNumero($campo){
    return preg_replace("/[^0-9]/", "", strip_tags($campo));
}


function recogetipoRece($campo){
    return preg_replace("/[^0-9#]/", "", strip_tags($campo));
}

function recogeArray($array){
    $ingre  = "";
    $n = count($array);
    $counter = 0;
    while($n>$counter){
        $ingre = $ingre.$array[$counter]."#".ucfirst(mb_strtolower($array[($counter+1)])).";";
        $counter += 2;
    }
    $ingre = mb_substr($ingre,0,mb_strlen($ingre)-1);
    
    return $ingre;
}


?>