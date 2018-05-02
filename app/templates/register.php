<?php 
$aviso = false;
if(isset($params['user'])){//Recibe datos
    if($params['user']!=""){//Usuario correcto
        //Iniciar sesion
        @session_start();
        $_SESSION['login'] = $params['user'];
        
        //Redireccionar a inicio
        ?><script>window.location.replace("inicio");</script><?php
    }else{//Usuario incorrecto
        $aviso = true;
    }
}
?>


<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<?php 
    switch ($aviso){
        case 1:
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#avisoUser").show();
                });
            </script>
            <?php
            break;
        case 2:
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#avisoMail").show();
                });
            </script>
            <?php
            break;
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#avisoUser").show();
    });
</script>
<?php } ?>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<form id="contenido" class="col-md-6 form-signin" autocomplete="on">
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Registrarse</h1>
    <input type="text" id="user" class="form-control" placeholder="Nombre de usuario" autocomplete="name" required autofocus>
    <input type="email" id="email" class="form-control" placeholder="Correo electrónico" autocomplete="email" required>
    <input type="password" id="pass" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <input type="password" id="pass2" class="form-control" placeholder="Repita contraseña" autocomplete="off" required>
    <button type="button" id="submit" class="btn btn-lg btn-primary btn-block">Registrarse</button>
    <div id="avisoUser" class="text-center mt-2" style="display: none;">El nombre de usuario ya está en uso</div>
    <div id="avisoMail" class="text-center mt-2" style="display: none;">El correo electrónico ya está en uso</div>
    <div class="text-center mt-2">
        ¿Ya tienes cuenta? 
        <a href="login">Identifícate</a>
    </div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>