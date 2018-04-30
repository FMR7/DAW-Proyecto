<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/bootstrap-multiselect.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/multiSelect.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/inicio.css" type="text/css"/>

<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<!--Quitar-->
<script type="text/javascript" src="../../web/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="../../web/js/multiselect.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //Solo letras 
        //Externalizar y mirar validate.js para sustituir
        $('.alphaonly').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^a-z ]/g,'') ); }
                            );

        //FALTA BUSQUEDA COMBINADA
        $("#fNombre").keyup(function() {
            var filter = new RegExp($(this).val(),'i');
            
            var fu = filtrosUpdate();
            
            if(fu){
                $("#tablaDiv tbody tr:visible").filter(function(){
                    $(this).each(function(){
                        found = false;
                        $(this).find("td:first-child").each(function(){
                            content = $(this).html();
                            if(content.match(filter)){
                                found = true
                            }
                        });
                        if(!found){
                            $(this).hide();
                        }else{
                            $(this).show();
                        }
                    });
                });
            }else{
                $("#tablaDiv tbody tr").filter(function(){
                    $(this).each(function(){
                        found = false;
                        $(this).find("td:first-child").each(function(){
                            content = $(this).html();
                            if(content.match(filter)){
                                found = true
                            }
                        });
                        if(!found){
                            $(this).hide();
                        }else{
                            $(this).show();
                        }
                    });
                });
            }
            
                        
        });

        $("#fElabo").change(function() {
            if($(this).val() != "0"){
                var filter = $(this).find("option:selected").text();
                $("#tablaDiv tbody tr").filter(function(){
                    $(this).each(function(){
                        found = false;
                        if($(this).hasClass(filter)){
                            found = true
                        }
                        if(!found){
                            $(this).hide();
                        }else{
                            $(this).show();
                        }
                    });
                });
            }else{
                $("#tablaDiv tbody tr").show();
            }
        });

        $("#fIngre").change(function() {
            if($(this).val() != "0"){
                var filter = $(this).find("option:selected").text();
                $("#tablaDiv tbody tr").filter(function(){
                    $(this).each(function(){
                        found = false;
                        if($(this).hasClass(filter)){
                            found = true
                        }
                        if(!found){
                            $(this).hide();
                        }else{
                            $(this).show();
                        }
                    });
                });
            }else{
                $("#tablaDiv tbody tr").show();
            }
        });

        $("#fNumCom").change(function() {
            $("#lNumCom").val($(this).val());
            filtroComensales($(this).val());
        });

        $("#lNumCom").blur(function() {
            if($(this).val() > 0){
                $("#fNumCom").val($(this).val());
                if($(this).val()<=$("#fNumCom").attr("max")){
                    $("#fNumCom").trigger("change");
                }
                filtroComensales($(this).val());
            }else{
                $("#fNumCom").val(1);
                $("#fNumCom").trigger("change");
            }
        });


        function filtroComensales(valor){
            if(valor > 1){
                var hiddenClasses = new Array();
                for(var e=0; e<( valor-1); e++){
                    hiddenClasses.push(".c-"+(e+1));
                }

                $("#tablaDiv tbody tr").show();
                $("#tablaDiv tbody tr").filter(hiddenClasses.join()).hide();
            }else{
                $("#tablaDiv tbody tr").show();
            }
        }


        function filtrosUpdate(){
            var updated = false;
            
            if($("#fElabo").val()!=0){
                $("#fElabo").trigger("change");
                console.log("filtrosUpdate fElabo");
                updated = true;
            }if($("#fIngre").val()!=0){
                $("#fIngre").trigger("change");
                console.log("filtrosUpdate fIngre");
                updated = true;
            }if($("#fNumCom").val()>1){
                $("#fNumCom").trigger("change");
                console.log("filtrosUpdate fNumCom");
                updated = true;
            }
            
            return updated;
        }
        
        
        //Click en una receta(fila)
        $("tbody>tr").click(function(){
            //Cargar receta
            location.href="receta/"+$(this).attr('id');
        });
        
        //Ordenar filas
        $(".nombre").click(function(){sortTable(0)});
        $(".dif").click(function(){sortTable(1)});
        $(".ing").click(function(){sortTable(2)});
        $(".com").click(function(){sortTable(3)});
        
        //Establece la cantidad de estrellas segun la dificultad
        $("td.Fácil").html(loadStars(1));
        $("td.Normal").html(loadStars(2));
        $("td.Difícil").html(loadStars(3));
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


<div id="contenido" class="col-12 content">
    <div class="row">
        <div id="filtro" class="col-md-3 content mb-3">
            <div class="row">
                <h4 class="col-12 h4 mb-3 font-weight-normal">Filtros</h4>
            </div>

            <div class="row">
                <input type="text" id="fNombre" class="form-control alphaonly" placeholder="Receta">
            </div>

            <div class="row">
                <select class="col-sm-6 col-md-12 custom-select" id="fElabo">
                    <option value="0" selected>Dificultad</option>
                    <?php 
                    foreach ($params['dificultades'] as $dificultad){
                        echo "<option value".$dificultad['idDificultad'].">".$dificultad['dificultad']."</option>";
                    }
                    ?>
                </select>

                <select class="col-sm-6 col-md-12 custom-select" id="fIngre">
                    <option value="0" selected>Ingredientes</option>
                    <?php 
                    foreach ($params['ingredientes'] as $ingredientes){
                        echo "<option value=".$ingredientes['idTipoIngrediente'].">".$ingredientes['tipoIngrediente']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="row">
                <select class="multiselect" multiple="multiple">
                    <?php 
                    foreach ($params['tiposReceta'] as $tipoReceta){
                        echo "<option value=".$tipoReceta['idTipo'].">".$tipoReceta['tipo']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="row mt-3 pl-2">
                <label class="col-12 pl-2 mb-0">Comensales</label>
                <input type="range" id="fNumCom" min="1" max="20" value="1" class="col-10 form-control slider mt-1">
                <input type="number" id="lNumCom" class="col-2 mb-0 p-0 pl-1 border-0 text-center" value="1">
            </div>
        </div>

        <div class="separador col-10 offset-1 mb-4 mt-2 d-md-none"></div>

        <div id="tablaDiv" class="col-md-9">
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
</div>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>