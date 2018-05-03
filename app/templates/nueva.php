<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<!--COMUN CON inicio-->
<link rel="stylesheet" href="../../web/css/bootstrap-multiselect.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/multiSelect.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/nueva.css" type="text/css"/>
<link rel="stylesheet" href="../../web/css/slider.css" type="text/css"/>
<style>
    .cantidad{
        padding-left: 0;
        padding-right: 0;
    }
</style>
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript" src="../../web/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="../../web/js/multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        eventos();
    });
    
    function eventos(){
        //Tabs
        $("#goIngre").click(function() {
            if(!($("#goIngre").hasClass("active"))){
                cambia();
            }
        });

        $("#goElabo").click(function() {
            if(!($("#goElabo").hasClass("active"))){
                cambia();
            }
        });

        function cambia(){
            $("#goIngre").toggleClass("active");
            $("#goElabo").toggleClass("active");
            $("#ingre").toggleClass("d-none");
            $("#elabo").toggleClass("d-none");
        }


        //Ingredientes
        //Borrar fila
        $(document).on('click', '.oi-minus', function() {//Click icono
            borraFila($(this).parent());
        });

        $(document).on('click', '.remove', function() {//Click td icono
            borraFila($(this));
        });

        //Añadir fila
        $(document).on('click', '.oi-plus', function() {
            var fila = "<tr><td><input type=\"text\" class=\"cantidad rounded form-control text-center\" autofocus></td><td><input type=\"text\" class=\"ingrediente rounded form-control\" autofocus></td><td class=\"remove\"><span class=\"oi oi-minus\" title=\"Remove\" aria-hidden=\"true\"></span></td></tr>";

            $(this).parent().parent().before(fila);

            //Scroll hacia abajo
            $("#ingre").animate({ scrollTop: $("#ingre>table").height() }, 500);
        });
        
        
        $("#fNumCom").change(function() {
            $("#lNumCom").val($(this).val());
        });

        $("#lNumCom").blur(function() {
            if($(this).val() > 0){
                $("#fNumCom").val($(this).val());
                if($(this).val()<=$("#fNumCom").attr("max")){
                    $("#fNumCom").trigger("change");
                }
            }else{
                $("#fNumCom").val(1);
                $("#fNumCom").trigger("change");
            }
        });


        
        
        //Publicar
        $("#publicar").click(function(){
            limpiarTabla();//Quita los ingredientes cuyos campos esten en blanco
            
            var params = recogeCampos();
            console.log(params);
            
            
            subir(params);
        });
        
    }
    
    //Borra la fila salvo que sea la última
    function borraFila(evt){
        if($("#ingre tbody tr").length > 2){
            evt.parent().remove();
        }else{
            //Última fila
        }
    }
    
    
    //Quita los ingredientes cuyos campos esten en blanco
    function limpiarTabla(){
        var cantIngre = $("#ingre>table>tbody>tr>td>input");
        for(var i=0; i< cantIngre.length; i++) {
            if(i%2==0){
                if(($(cantIngre[i]).val()=="")&&($(cantIngre[(i+1)]).val()=="")){
                    $(cantIngre[i]).parent().parent().remove();
                }
            }
        }
        
        cantIngre = $("#ingre>table>tbody>tr>td>input");
        if($(cantIngre).length == 0){
            $(".oi-plus").trigger("click");
        }
    }
    
    
    //USAR EN LOGIN REGISTER PERFIL--------------------------------------------------------------------
    //Muestra una animación sobre el borde del campo
    function animacionRequerido(campo){
        campo.css({border: '0 solid #dd0000'}).animate({
            borderWidth: 3
        }, 800);
        
        setTimeout(function(){
            campo.css({border: '3 solid #dd0000'}).animate({
                borderWidth: 1
            }, 800);
        }, 900);
        
        setTimeout(function(){
            campo.removeAttr('style');
        }, 1600);
    }
    
    //Comprueba y recoge los campos, si están en blanco da un aviso visual
    function recogeCampos(){
        //Nombre
        var nombre = "";
        if($("#nombre").val()!=""){
            nombre = $("#nombre").val();
        }else{
            animacionRequerido($("#nombre"));
        }
        
        //Elaboracion
        var elaboracion = "";
        if($("#elabo").val()!=""){
            elaboracion = $("#elabo").val();
        }else{
            animacionRequerido($("#elabo"));
        }
        
        //Ingredientes
        var cantIngre = $("#ingre>table>tbody>tr>td>input");
        var ingredientes = {};
        for(var i=0; i< cantIngre.length; i++) {
            ingredientes[i] = $(cantIngre[i]).val();
            if(ingredientes[i] == ""){
                animacionRequerido($(cantIngre[i]));
            }
        }
        
        //Dificultad
        var dificultad = "";
        if($("#diffElabo").find("option:selected").val()!=0){
            dificultad = $("#diffElabo").find("option:selected").val();
        }else{
            animacionRequerido($("#diffElabo"));
        }
        
        //Tipo de ingredientes
        var tipoIngredientes = "";
        if($("#diffIngre").find("option:selected").val()!=0){
            tipoIngredientes = $("#diffIngre").find("option:selected").val();
        }else{
            animacionRequerido($("#diffIngre"));
        }
        
        //Tipo de receta
        var tipoReceta = "";
        if($("#tipoReceta").find("option:selected").text()!=""){
            var tipos = $("#tipoReceta").find("option:selected");
            for(var i=0; i< tipos.length; i++) {
                if((i+1)==tipos.length){//Último
                    tipoReceta += $(tipos[i]).val();
                }else{
                    tipoReceta += $(tipos[i]).val()+"#";
                }
            }
        }else{
            animacionRequerido($(".multiselect-native-select>div>button"));
        }
        
        //Número comensales
        var numCom = "";
        if($("#lNumCom").val()>0){
            numCom = $("#lNumCom").val();
        }else{
            animacionRequerido($("#numCom"));
        }
        
        var params = {
            "nombre" : nombre,
            "elaboracion" : elaboracion,
            "ingredientes" : ingredientes,
            "dificultad" : dificultad,
            "tipoIngredientes" : tipoIngredientes,
            "tipoReceta" : tipoReceta,
            "numCom" : numCom
        };
        
        return params;
    }
    
    function subir(params){
        $.ajax({
            data:  params,
            url:   'subir',
            type:  'post',
            beforeSend: function(){
                
            },
            success: function(response){
                var insertada = response.split("#")[0];
                var idReceta  = response.split("#")[1];
                if(insertada==1){
                    window.location.replace("receta/"+idReceta);
                }
            }
        });
    }
</script>
<?php $js = ob_get_clean() ?>



<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
@session_start();
if(isset($_SESSION['login'])){
    if($_SESSION['login']!=""){
    ?>
    <div id="contenido" class="col-12 col-md-8 content">
        <div class="row mt-3 mb-3">
            <input type="text" id="nombre" class="rounded form-control" placeholder="Nombre de la receta" required autofocus>
        </div>

        <div class="row">
            <nav id="nav" class="col-12 nav nav-pills nav-fill">
                <a id="goElabo" class="rounded bb-0 col-12 col-md-6 nav-item nav-link active d-lg-none">Elaboración</a>
                <a id="goIngre" class="rounded bb-0 col-12 col-md-6 nav-item nav-link d-lg-none">Ingredientes</a>

                <a id="goElaboLg" class="rounded bb-0 br-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Elaboración</a>
                <a id="goIngreLg" class="rounded bb-0 bl-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Ingredientes</a>
            </nav>
        </div>

        <div class="row" id="receta">
            <textarea id="elabo" class="col-12 col-lg-6 d-lg-block" name="" id="" rows="10" placeholder="Primero encendemos el horno. Despúes..." required></textarea>

            <div id="ingre" class="col-12 col-lg-6 table-responsive d-none d-lg-block">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center d-none d-sm-block">Cantidad</th>
                            <th style="width: 20px;" class="text-right d-sm-none">Cnt.</th>
                            <th style="width: 60%;">Ingrediente</th>
                            <th style="width: 10px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="cantidad rounded form-control text-center" placeholder="2" required autofocus></td>
                            <td><input type="text" class="ingrediente rounded form-control" placeholder="Tomates" required autofocus></td>
                            <td class="remove"><span class="oi oi-minus" title="Remove" aria-hidden="true"></span></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="cantidad rounded form-control text-center" placeholder="150g" autofocus></td>
                            <td><input type="text" class="ingrediente rounded form-control" placeholder="Harina" autofocus></td>
                            <td class="remove"><span class="oi oi-minus" title="Borrar fila" aria-hidden="true"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><span class="oi oi-plus" title="Añadir fila" aria-hidden="true"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <select class="col-lg-6 custom-select" id="diffElabo">
                <option value="0" selected>Dificultad de la elaboración</option>
                <?php 
                foreach ($params['dificultades'] as $dificultad){
                    echo "<option value=".$dificultad['idDificultad'].">".$dificultad['dificultad']."</option>";
                }
                ?>
            </select>

            <select class="col-lg-6 custom-select" id="diffIngre">
                <option value="0" selected>Ingredientes</option>
                <?php 
                foreach ($params['ingredientes'] as $ingredientes){
                    echo "<option value=".$ingredientes['idTipoIngrediente'].">".$ingredientes['tipoIngrediente']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="row">
            <select class="multiselect" id="tipoReceta" multiple="multiple">
                <?php 
                foreach ($params['tiposReceta'] as $tipoReceta){
                    echo "<option value=".$tipoReceta['idTipo'].">".$tipoReceta['tipo']."</option>";
                }
                ?>
            </select>
        </div>


        <div class="row" id="numCom">
            <label class="col-4 col-sm-3 col-lg-2 pt-1">Comensales</label>
            <input type="range" id="fNumCom" min="1" max="20" value="1" class="col-6 col-sm-7 col-lg-8 form-control slider">
            <input type="number" id="lNumCom" class="col-2 border-0 text-right" value="1">
        </div>


        <div class="row">
            <button type="button" id="publicar" class="col-sm-6 col-md-4 offset-sm-6 offset-md-8 btn btn-lg btn-primary btn-block">Publicar</button>
        </div>
    </div>
    <?php 
    }else{//Redireccionar al login
        ?><script>window.location.replace("login");</script><?php
    }
}
?>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>