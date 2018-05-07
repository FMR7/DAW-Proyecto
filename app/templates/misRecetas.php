<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/perfil.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/inicio.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/jquery-confirm.min.css" type="text/css"/>
<style>
    #contenido, #tablaDiv{padding: 0;}
    .oi-minus{color: #dd0000;}
</style>
<?php $css = ob_get_clean() ?>

<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript" src="../../web/js/jquery-confirm.min.js"></script>
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
        $("tbody>tr>td").click(function(){
            //Cargar receta
            location.href="editar/"+$(this).parent().attr('id');
        });

        
        //Establece la cantidad de estrellas segun la dificultad
        $("td.Fácil").html(loadStars(1));
        $("td.Normal").html(loadStars(2));
        $("td.Difícil").html(loadStars(3));
        
        
        //Borrar receta
        $(".remove").unbind('click');//Quitamos los eventos anteriores
        
        $(document).on('click', '.oi-minus', function(evt) {//Click icono
            msgBorrarReceta($(this).parent());
            evt.stopPropagation();
        });

        $(document).on('click', '.remove', function(evt) {//Click td icono
            msgBorrarReceta($(this));
            evt.stopPropagation();
        });
        
        //Ordenar filas
        $(".nombre").click(function(){sortTable(0)});
        $(".dif").click(function(){sortTable(1)});
        $(".ing").click(function(){sortTable(2)});
        $(".com").click(function(){sortTable(3)});
    });
    
    
    
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = $("#tabla");
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = $("#tabla").find("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
                if(n == 3){
                    if (dir == "asc") {
                        if (parseInt(x.innerHTML.toLowerCase()) > parseInt(y.innerHTML.toLowerCase())) {
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (parseInt(x.innerHTML.toLowerCase()) < parseInt(y.innerHTML.toLowerCase())) {
                            shouldSwitch= true;
                            break;
                        }
                    }  
                }else{
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch= true;
                            break;
                        }
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++; 
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    
    
    function msgBorrarReceta(evt){
        $.confirm({
            columnClass: 'medium',
            type: 'blue',
            title: 'Borrar receta',
            content: '¿Está seguro de que quiere borrar esta receta?<br>'+$(evt).parent().children(":first").text(),
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Borrar',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.confirm({
                            autoClose: 'cancelar|8000',
                            columnClass: 'medium',
                            type: 'red',
                            title: 'Acción irreversible',
                            content: 'Esta acción borrará tanto la receta como los comentarios asociados. ¿Está seguro?',
                            icon: 'fa fa-warning',
                            animation: 'scale',
                            closeAnimation: 'zoom',
                            buttons: {
                                confirm: {
                                    text: 'Si, seguro!',
                                    btnClass: 'btn-red',
                                    action: function () {
                                        borrar(evt);
                                    }
                                },
                                cancelar: function () {

                                }
                            }
                        });
                    }
                },
                cancelar: function () {

                },
            }
        });
    }
    
    
    function borrar(evt){
        var id = $(evt).parent().attr("id");
        console.log(id);
        
        var params = {'idReceta':id};
        
        //Borrar de BBDD
        $.ajax({
            data:  params,
            url:   'borrar',
            type:  'post',
            success: function(response){
                var borrada = response;
                if(borrada==1){
                    //Borrar del DOM
                    evt.parent().remove();
                }
            }
        });
        
    }


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
                    <th style="width: 10px;"></th>
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
                    <td class="remove"><span class="oi oi-minus" title="Borrar receta" aria-hidden="true"></span></td>
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