<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<?php $css = ob_get_clean() ?>

<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<?php 
    if(isset($params['errorUser'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoUser").show();
            });
        </script>
        <?php
    }if(isset($params['errorMail'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoMail").show();
            });
        </script>
        <?php
    }
?>

<script type="text/javascript">
    $("#contenido").submit(function(evt){
        //Contraseña mínimo 6 chars
        
        if(!($("#pass").val()===$("#pass2").val())){
            $("#avisoPass").show();
            evt.preventDefault();
        }
    });
</script>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<form id="contenido" class="col-md-6 form-signin" autocomplete="on" action="register" method="post">
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Registrarse</h1>
    <input id="user" type="text" name="user" class="form-control" placeholder="Nombre de usuario" autocomplete="name" required autofocus value="<?php echo @$params['user']; ?>">
    <input id="email" type="email" name="email" class="form-control" placeholder="Correo electrónico" autocomplete="email" required value="<?php echo @$params['email']; ?>">
    <input id="pass" type="password" name="pass1" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <input id="pass2" type="password" name="pass2" class="form-control" placeholder="Repita contraseña" autocomplete="off" required>
    <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block">Registrarse</button>
    <div id="avisoUser" class="text-center mt-2" style="display: none;">El nombre de usuario ya está en uso</div>
    <div id="avisoMail" class="text-center mt-2" style="display: none;">El correo electrónico ya está en uso</div>
    <div id="avisoPass" class="text-center mt-2" style="display: none;">Las contraseñas deben coincidir</div>
    <div class="text-center mt-2">
        ¿Ya tienes cuenta? 
        <a href="login">Identifícate</a>
    </div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>