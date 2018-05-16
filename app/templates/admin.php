<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/inicio.css"/>
<link rel="stylesheet" href="../../web/css/jquery-confirm.min.css"/>
<style>
    @media (min-width: 992px){
        #rece{padding-right: 10px !important;}
        #come{
            padding-left: 10px !important;
            border-left: 1px solid rgb(222, 226, 230);
        }
        #favs{
            padding-left: 10px !important;
            border-left: 1px solid rgb(222, 226, 230);
        }
    }
    .oi-minus{color: #dd0000;}
    #rece{white-space: nowrap;}
</style>
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript" src="../../web/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="../../web/js/general.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        eventos();
        
        //Establece la cantidad de estrellas segun la dificultad
        $("td.Fácil").html(loadStars(1));
        $("td.Normal").html(loadStars(2));
        $("td.Difícil").html(loadStars(3));
    });
    
    
    function eventos(){
        //Tabs
        $("#goRece").click(function() {
            if(!($("#goRece").hasClass("active"))){
                cambia();
            }
        });

        $("#goCome").click(function() {
            if(!($("#goCome").hasClass("active"))){
                cambia();
            }
        });
        
        
        //Click en una receta(fila)
        $("#rece tbody>tr>td").click(function(){
            //Cargar receta
            location.href="editar/"+$(this).parent().attr('id');
        });
        
        
        
        $(".remove, .removeComment").unbind('click');//Quitamos los eventos anteriores
        
        //Borrar receta
        $(document).on('click', '.remove .oi-minus', function(evt) {//Click icono
            msgBorrarReceta($(this).parent());
            evt.stopPropagation();
        });
        $(document).on('click', '.remove', function(evt) {//Click td icono
            msgBorrarReceta($(this));
            evt.stopPropagation();
        });
        
        
        //Borrar comentario
        $(document).on('click', '.removeComment .oi-minus', function(evt) {//Click icono
            msgBorrarComentario($(this).parent());
            evt.stopPropagation();
        });

        $(document).on('click', '.removeComment', function(evt) {//Click td icono
            msgBorrarComentario($(this));
            evt.stopPropagation();
        });
    }
    
    function cambia(){
        $("#goRece").toggleClass("active");
        $("#goCome").toggleClass("active");
        $("#rece").toggleClass("d-none");
        $("#come").toggleClass("d-none");
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
    
    function msgBorrarComentario(evt){
        $.confirm({
            columnClass: 'medium',
            type: 'blue',
            title: 'Borrar receta',
            content: '¿Está seguro de que quiere borrar este comentario?',
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
                            content: 'Esta acción es irreversible, no podrá recuperar el comentario. ¿Está seguro?',
                            icon: 'fa fa-warning',
                            animation: 'scale',
                            closeAnimation: 'zoom',
                            buttons: {
                                confirm: {
                                    text: 'Si, seguro!',
                                    btnClass: 'btn-red',
                                    action: function () {
                                        borrarComment(evt);
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
    
    function borrarComment(evt){
        var id = $(evt).parent().attr("id");
        var username = $(evt).parent().attr("username");
        var params = {'idReceta':id,
                      'username':username};
        
        //Borrar de BBDD
        $.ajax({
            data:  params,
            url:   'borrarComment',
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
</script>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>

<div id="contenido" class="col-12 content">
    <div class="row border rounded bb-0">
        <nav id="nav" class="col-12 nav nav-pills nav-fill px-0">
            <a id="goRece" class="rounded bb-0 col-12 col-md-6 nav-item nav-link active d-lg-none">Recetas</a>
            <a id="goCome" class="rounded bb-0 col-12 col-md-6 nav-item nav-link d-lg-none">Comentarios</a>

            <a id="goReceLg" class="rounded bb-0 br-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Recetas</a>
            <a id="goComeLg" class="rounded bb-0 bl-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Comentarios</a>
        </nav>
    </div>
    
    
    <div class="row border rounded bt-0">
        <div id="rece" class="col-12 col-lg-6 table-responsive px-0 d-lg-block">
            <table class="table table-responsive">
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
                            <tr id="<?php echo $receta['idReceta']?>">
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

        <div id="come" class="col-12 col-lg-6 table-responsive px-0 d-none d-lg-block">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Comentario</th>
                        <th style="width: 10px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($params['comentarios'] as $comentario){
                            ?>
                            <tr id="<?php echo $comentario['idReceta']?>" username="<?php echo $comentario['username']?>">
                                <td><?php echo $comentario['username'] ?></td>
                                <td><?php echo $comentario['comentario'] ?></td>
                                <td class="removeComment"><span class="oi oi-minus" title="Borrar comentario" aria-hidden="true"></span></td>
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