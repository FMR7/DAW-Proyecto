<?php 
$aviso = false;
@session_start();
if(isset($_SESSION['login'])){//Recibe datos
    if($_SESSION['login']!=""){//Usuario correcto
        //Redireccionar a inicio
        ?><script>window.location.replace("inicio");</script><?php
    }
}
?>


<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<style>
    #email{
        border-radius: 16px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
</style>
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<?php 
    if(isset($params['errorMail'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoMail").show();
            });
        </script>
        <?php
    }if(isset($params['enviado'])){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#avisoEnviado").show();
            });
        </script>
        <?php
    }
?>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<form id="contenido" class="col-md-6 form-signin" autocomplete="on" action="recuperar" method="post">
    <h1 class="h4 mb-3 pl-3 font-weight-normal">Reestablecer contraseña</h1>
    <input id="email" type="email" name="email" class="form-control" placeholder="Correo electrónico" autocomplete="email" required>
    <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block">Enviar correo</button>
    <div id="avisoMail" class="text-center mt-2" style="display: none;">El correo electrónico no existe</div>
    <div id="avisoEnviado" class="text-center mt-2" style="display: none;">Se ha mandado un email a la dirección especificada</div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>