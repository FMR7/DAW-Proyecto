<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>

<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<form id="contenido" class="col-md-6 form-signin" autocomplete="on">
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Identificarse</h1>
    <input type="text" id="user" class="form-control" placeholder="Nombre de usuario" autocomplete="username" required autofocus>
    <input type="password" id="pass" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <button type="button" id="submit" class="btn btn-lg btn-primary btn-block">Acceder</button>

    <div class="text-center mt-2">
        ¿Aún no tienes cuenta? 
        <a href="register">Regístrate</a>
    </div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>