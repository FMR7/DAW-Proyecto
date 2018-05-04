<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/perfil.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/inicio.css" type="text/css"/>
<style>
    #contenido, #tablaDiv{padding: 0;}
</style>
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
    
    $(document).ready(function() {
        //Click en una receta(fila)
        $("tbody>tr").click(function(){
            //Cargar receta
            location.href="editar/"+$(this).attr('id');
        });
        
        //Establece la cantidad de estrellas segun la dificultad
        $("td.Fácil").html(loadStars(1));
        $("td.Normal").html(loadStars(2));
        $("td.Difícil").html(loadStars(3));
    });
    
    
    
    //Carga los iconos de la dificultad
    function loadStars(n){
        var stars = "";
        for(var i=0; i<n; i++){
            stars += "<span class=\"oi oi-star\"></span>";
        }
        return stars;
    }
</script>
<?php $js = ob_get_clean() ?>

<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
@session_start();
if(@$_SESSION['login']!=""){
?>
<div id="contenido" class="col-12 col-lg-10 col-xl-8">
    <div id="tablaDiv">
        <table id="tabla" class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th class="w-100 nombre">Nombre</th>
                    <th class="d-none d-sm-table-cell dif">Dificultad</th>
                    <th class="d-sm-none dif">Dif.</th>
                    <th class="d-none d-sm-table-cell ing">Ingredientes</th>
                    <th class="d-sm-none ing">Ing.</th>
                    <th class="d-none d-sm-table-cell com">Comensales</th>
                    <th class="d-sm-none com"><span class="oi oi-people"></span></th>
                </tr>
            </thead>
            <tbody>
               <?php
                foreach ($params['recetas'] as $receta){
                ?>
                <tr id="<?php echo $receta['idReceta'] ?>" class="<?php echo $receta['dificultad'] ?> <?php echo $receta['tipoIngrediente'] ?> c-<?php echo $receta['numComensales'] ?>">
                    <td><?php echo $receta['nombre'] ?></td>
                    <td class="text-center <?php echo $receta['dificultad'] ?>"></td>
                    <td><?php echo $receta['tipoIngrediente'] ?></td>
                    <td><?php echo $receta['numComensales'] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
}else{//Redireccionar al login
    ?><script>window.location.replace("login");</script><?php
}
?>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>