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
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Registrarse</h1>
    <input type="text" id="user" class="form-control" placeholder="Nombre de usuario" autocomplete="name" required autofocus>
    <input type="email" id="email" class="form-control" placeholder="Correo electrónico" autocomplete="email" required>
    <input type="password" id="pass" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <input type="password" id="pass2" class="form-control" placeholder="Repita contraseña" autocomplete="off" required>
    <button type="button" id="submit" class="btn btn-lg btn-primary btn-block">Registrarse</button>

    <div class="text-center mt-2">
        ¿Ya tienes cuenta? 
        <a href="login">Identifícate</a>
    </div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>