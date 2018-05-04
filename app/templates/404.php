<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<style>
    #contenido>.row{margin-top: 50px;}
</style>
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript">
$(document).ready(function(){
    var url = window.location.host + window.location.pathname;
    $("#url").text(url);
});
</script>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
    header('Status: 404 Not Found');
?>

<div id="contenido" class="col-12 content">
    <div class="row">
        <h1 class="text-center col-12">Vaya, parece que la página no existe</h1>
        <h2 class="text-center text-muted col-12"><i id="url"></i></h2>
    </div>
</div>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>