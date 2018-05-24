<?php 
$aviso = false;
@session_start();
if(isset($_SESSION['login'])){//Recibe datos
    if($_SESSION['login']!=""){//Usuario correcto
        //Redireccionar a inicio
        ?><script>window.location.replace("inicio");</script><?php
    }
}if((isset($_POST['user']))||(isset($_POST['pass']))){//Usuario incorrecto
    $aviso = true;
}
?>


<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<?php if($aviso){ ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#aviso").show();
    });
</script>
<?php } ?>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<form id="contenido" class="col-md-6 form-signin" autocomplete="on" action="login" method="post">
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Identificarse</h1>
    <input id="user" type="text" name="user" class="form-control" placeholder="Nombre de usuario" autocomplete="username" required autofocus>
    <input id="pass" type="password" name="pass" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block">Acceder</button>
    <div id="aviso" class="text-center mt-2" style="display: none;">
        ¿No puedes acceder? Haz click <a href="recuperar">aquí</a> para recuperar tu cuenta
    </div>
    <div class="text-center mt-2">
        ¿Aún no tienes cuenta? 
        <a href="register">Regístrate</a>
    </div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>