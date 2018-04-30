<?php

print_r($_POST);
if(checkCampos()){
    echo "\nInsertar\n";
    $campos = recogeCampos();
    
}else{
    echo "\nFaltan campos por rellenar\n";
}


//Devuelve TRUE si todos los campos tienen valores
function checkCampos(){
    $continuar = true;
    
    if($_POST["nombre"]==""){
        echo "Nombre en blanco\n";
        $continuar = false;
    }
    
    if($_POST["elaboracion"]==""){
        echo "Elaboracion en blanco\n";
        $continuar = false;
    }
    
    if(count($_POST["ingredientes"])%2!=0){
        echo "Ingredientes impares\n";
        $continuar = false;
    }
    
    $ingreCorrecto = true;
    foreach ($_POST["ingredientes"] as $cantIngre){
        if($cantIngre==""){
            $ingreCorrecto = false;
        }
    }
    if(!$ingreCorrecto){
        echo "Ingrediente en blanco\n";
        $continuar = false;
    }
    
    if($_POST["dificultad"]==""){
        echo "Dificultad en blanco\n";
        $continuar = false;
    }
    
    if($_POST["tipoIngredientes"]==""){
        echo "Tipo de ingredientes en blanco\n";
        $continuar = false;
    }
    
    if($_POST["tipoReceta"]==""){
        echo "Tipo de receta en blanco\n";
        $continuar = false;
    }
    
    if($_POST["numCom"]<1){
        echo "Número de comensales menor que 1\n";
        $continuar = false;
    }
    
    return $continuar;
}

//Devuelve un array, con los valores de los campos filtrados
function recogeCampos(){
    $nombre = ucfirst(strtolower(recogeTexto($_POST["nombre"])));
    $elabo  = recogeTexto($_POST["elaboracion"]);
    $ingre  = recogeArray($_POST["ingredientes"]);
    $diff   = recogeNumero($_POST["dificultad"]);
    $tIngre = recogeNumero($_POST["tipoIngredientes"]);
    $tRece  = recogetipoRece($_POST["tipoReceta"]);
    $nCom   = recogeNumero($_POST["numCom"]);
    
    $array = array(
        "nombre" => $nombre,
        "elabo"  => $elabo,
        "ingre"  => $ingre,
        "diff"   => $diff,
        "tIngre" => $tIngre,
        "tRece"  => $tRece,
        "nCom"   => $nCom
    );
    
    return $array;
}

function recogeTexto($campo){
    return preg_replace("/[^a-zA-Z\s]/", "", strip_tags($campo));
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
        $ingre = $ingre.$array[$counter]."#".ucfirst(strtolower($array[($counter+1)])).";";
        $counter += 2;
    }
    $ingre = mb_substr($ingre,0,mb_strlen($ingre)-1);
    
    return $ingre;
}

?>