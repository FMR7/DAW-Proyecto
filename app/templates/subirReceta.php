<?php

print_r($_POST);
if(recogeCampos()){
    echo "\nInsertar";
}else{
    echo "\nFaltan campos por rellenar";
}


function recogeCampos(){
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
    
    
    return $continuar;
}

?>