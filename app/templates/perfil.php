<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/perfil.css" type="text/css"/>
<?php $css = ob_get_clean() ?>

<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<?php 
    if(isset($params['errorPassOld'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoPassOld").show();
            });
        </script>
        <?php
    }if(isset($params['cambiada'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoCambiada").show();
            });
        </script>
        <?php
    }
?>

<script type="text/javascript">
    $("#cambiarPass").submit(function(evt){
        //Contraseña mínimo 6 chars
        
        if(!($("#pass1").val()===$("#pass2").val())){
            $("#avisoPass").show();
            evt.preventDefault();
        }
    });
</script>
<?php $js = ob_get_clean() ?>

<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
@session_start();
if(@$_SESSION['login']!=""){
?>
<div id="contenido" class="col-md-8 col-lg-6 col-xl-6 content">
    <div class="row">
        <h1 class="h3 mb-4 pl-3 font-weight-normal">Perfil</h1>
    </div>

    <div class="row">
        <h3 class="h4 mb-2 pl-2 font-weight-normal">Datos personales</h3>
    </div>

    <div class="row">
        <label class="col-sm-7 col-md-6 col-form-label" for="user">Nombre de usuario:</label>
        <input class="col-sm-5 col-md-6 form-control" type="text" id="user" readonly value="<?php echo @$params['user']; ?>">
    </div>

    <div class="row">
        <label class="col-sm-7 col-md-6 col-form-label" for="email">Dirección de correo:</label>
        <input class="col-sm-5 col-md-6 form-control" type="email" id="email" readonly value="<?php echo @$params['email']; ?>">
    </div>

    <div class="row">
        <h3 class="h4 mt-4 mb-2 pl-2 font-weight-normal">Cambiar contraseña</h3>
    </div>

    <div class="row">
        <form id="cambiarPass" class="content" action="perfil" method="post">
            <div class="row">
                <label class="col-sm-7 col-md-6 col-form-label" for="passOld">Contraseña antigua:</label>
                <input class="col-sm-5 col-md-6 form-control" type="password" name="passOld" required>
            </div>

            <div class="row">
                <label class="col-sm-7 col-md-6 col-form-label" for="pass">Nueva contraseña:</label>
                <input class="col-sm-5 col-md-6 form-control" type="password" name="pass1" id="pass1" required>
            </div>

            <div class="row">
                <label class="col-sm-7 col-md-6 col-form-label" for="pass2">Repite nueva contraseña:</label>
                <input class="col-sm-5 col-md-6 form-control" type="password" name="pass2" id="pass2" required>
            </div>

            <div class="row">
                <button type="submit" class="col-sm-5 col-md-6 offset-sm-7 offset-md-6 my-2 my-sm-0 btn btn-lg btn-primary btn-block">Cambiar</button>
            </div>
            
            <div id="avisoPassOld" class="text-center mt-2" style="display: none;">La contraseña antigua no coincide</div>
            <div id="avisoPass" class="text-center mt-2" style="display: none;">Las contraseñas deben coincidir</div>
            <div id="avisoCambiada" class="text-center mt-2" style="display: none;">Contraseña cambiada con éxito</div>
        </form>
    </div>

</div>
<?php 
}else{//Redireccionar al login
    ?><script>window.location.replace("login");</script><?php
}
?>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>