<?php

function recogeTexto($campo){
    return preg_replace("/[^a-zA-ZÀ-ÿ\s]/", "", strip_tags($campo));
}

function recogeNumero($campo){
    return preg_replace("/[^0-9]/", "", strip_tags($campo));
}

function recogeComentario($comment){
    //Quita etiquetas HTML y PHP
    $comment = strip_tags($comment);

    //Quita los saltos de linea extra dejando solo uno
    $comment = preg_replace("/[\r\n]+/", "\n", $comment);

    //Deja solo un espacio si hay dos o más seguidos y quita las tabulaciones
    $comment = preg_replace(array('/\s{2,}/', '/[\t]/'), ' ', $comment);

    //Quita los espacios del principio y del final
    $comment = nl2br(trim($comment, " "));

    //Quita los saltos de linea en blanco del final
    $comment = rtrim($comment);

    //Limitar comentario a 280
    $comment = mb_substr($comment,0,280);
    
    return $comment;
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


function redirecciona($destino){
    echo "<script>window.location.replace(\"$destino\");</script>";
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
    @session_start();
    session_destroy();
    unset($_SESSION);

    //Borrar cookie sesión
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
}

?>