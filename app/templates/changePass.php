<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/loginAndRegister.css">
<style>
    #pass{
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
<form id="contenido" class="col-md-6 form-signin" autocomplete="on" action="../nuevaPass/<?php echo $params['token']; ?>" method="post">
    <h1 class="h3 mb-3 pl-3 font-weight-normal">Reestablecer contraseña</h1>
    <input id="pass" type="password" name="pass1" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <input id="pass2" type="password" name="pass2" class="form-control" placeholder="Repita contraseña" autocomplete="off" required>
    <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block">Cambiar contraseña</button>
    <div id="avisoMail" class="text-center mt-2" style="display: none;">El correo electrónico no existe</div>
    <div id="avisoPass" class="text-center mt-2" style="display: none;">Las contraseñas deben coincidir</div>
</form>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>