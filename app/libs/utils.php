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

function checkCampos(){
    $continuar = true;

    if(@$_POST["nombre"]==""){
        $continuar = false;
    }

    if(@$_POST["elaboracion"]==""){
        $continuar = false;
    }

    if(@count(@$_POST["ingredientes"])%2!=0){
        $continuar = false;
    }

    $ingreCorrecto = true;
    if(isset($_POST["ingredientes"])){
        foreach ($_POST["ingredientes"] as $cantIngre){
        if($cantIngre==""){
            $ingreCorrecto = false;
        }
    }
        if(!$ingreCorrecto){
            $continuar = false;
        }
    }


    if(@$_POST["dificultad"]==""){
        $continuar = false;
    }

    if(@$_POST["tipoIngredientes"]==""){
        $continuar = false;
    }

    if(@$_POST["tipoReceta"]==""){
        $continuar = false;
    }

    if(@$_POST["numCom"]<1){
        $continuar = false;
    }

    return $continuar;
}

//Inicia una sesión
function openSession($user){
    @session_start();
    $_SESSION['login'] = $user;
}

//Devuelve el nombre de usuario de la sesión actual
function getSession(){
    @session_start();
    return @$_SESSION['login'];
}

//Cierra la sesion de forma segura y borra la cookie
function closeSession(){
    //Destruir sesión
    session_start();
    session_destroy();
    unset($_SESSION);

    //Borrar cookie sesión
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
}

?>