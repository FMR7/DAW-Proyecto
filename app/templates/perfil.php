<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/perfil.css"/>
<link rel="stylesheet" href="../../web/css/inicio.css"/>
<style type="text/css">
    @media (min-width: 992px){
        #perfil{padding-right: 25px !important;}
        #favs{
            padding-left: 10px !important;
            border-left: 1px solid rgb(222, 226, 230);
        }
    }
    #submit{margin-bottom: 0 !important;}
    #tabla{white-space: nowrap;}
</style>
<?php $css = ob_get_clean() ?>

<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript" src="../../web/js/general.js"></script>
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
    
    
    $(document).ready(function(){
        eventos();
        
        //Establece la cantidad de estrellas segun la dificultad
        $("td.Fácil").html(loadStars(1));
        $("td.Normal").html(loadStars(2));
        $("td.Difícil").html(loadStars(3));
        
        //Ordenar filas
        $(".nombre").click(function(){sortTable(0)});
        $(".dif").click(function(){sortTable(1)});
        $(".ing").click(function(){sortTable(2)});
        $(".com").click(function(){sortTable(3)});
    });
    
    function eventos(){
        //Click en una receta(fila)
        $("tbody>tr").click(function(){
            //Cargar receta
            location.href="receta/"+$(this).attr('id');
        });
        
        //Tabs
        $("#goProfile").click(function() {
            if(!($("#goProfile").hasClass("active"))){
                cambia();
            }
        });

        $("#goFav").click(function() {
            if(!($("#goFav").hasClass("active"))){
                cambia();
            }
        });
        
        $("#cambiarPass").submit(function(evt){
            //Contraseña mínimo 6 chars

            if(!($("#pass1").val()===$("#pass2").val())){
                $("#avisoPass").show();
                evt.preventDefault();
            }
        });
    }
    
    
    function cambia(){
        $("#goProfile").toggleClass("active");
        $("#goFav").toggleClass("active");
        $("#perfil").toggleClass("d-none");
        $("#favs").toggleClass("d-none");
    }
</script>
<?php $js = ob_get_clean() ?>

<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
@session_start();
if(@$_SESSION['login']!=""){
    if(@$params['emailConfirmed']==0){
        ?>
        <div class="col-12 mb-3 bg-warning rounded text-justify">
            Aún no has confirmado tu dirección de correo. Si no has recibido el correo de cofirmación haz click <u><a href="#">aquí</a></u>.
        </div>
        <?php 
    }
?>


<div id="contenido" class="col-12 content">
    <div class="row border rounded bb-0">
        <nav id="nav" class="col-12 nav nav-pills nav-fill px-0">
            <a id="goProfile" class="rounded bb-0 col-12 col-md-6 nav-item nav-link active d-lg-none">Perfil</a>
            <a id="goFav" class="rounded bb-0 col-12 col-md-6 nav-item nav-link d-lg-none">Favoritos</a>

            <a id="goProfileLg" class="rounded bb-0 br-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Perfil</a>
            <a id="goFavLg" class="rounded bb-0 bl-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Favoritos</a>
        </nav>
    </div>

    <div class="row border rounded bt-0">
        <div id="perfil" class="col-12 col-lg-6  d-lg-block">
            <div class="content">
                <div class="row"><h3 class="h4 mb-2 pl-2 font-weight-normal">Datos personales</h3></div>
                
                <div class="row">
                    <label class="col-sm-7 col-md-6 col-form-label" for="user">Nombre de usuario:</label>
                    <input class="col-sm-5 col-md-6 form-control" type="text" id="user" readonly value="<?php echo @$params['user']; ?>">
                </div>
                
                <div class="row">
                    <label class="col-sm-7 col-md-6 col-form-label" for="email">Dirección de correo:</label>
                    <input class="col-sm-5 col-md-6 form-control" type="email" id="email" readonly value="<?php echo @$params['email']; ?>">
                </div>
                
                <div class="row"><h3 class="h4 mt-4 mb-2 pl-2 font-weight-normal">Cambiar contraseña</h3></div>
            </div>
            
            
            <form id="cambiarPass" class="content px-0" action="perfil" method="post">
                <div class="row">
                    <label class="col-sm-7 col-md-6 col-form-label" for="passOld">Contraseña antigua:</label>
                    <input class="col-sm-5 col-md-6 form-control" type="password" id="passOld" name="passOld" required>
                </div>

                <div class="row">
                    <label class="col-sm-7 col-md-6 col-form-label" for="pass">Nueva contraseña:</label>
                    <input class="col-sm-5 col-md-6 form-control" type="password" id="pass" name="pass1" id="pass1" required>
                </div>

                <div class="row">
                    <label class="col-sm-7 col-md-6 col-form-label" for="pass2">Repite nueva contraseña:</label>
                    <input class="col-sm-5 col-md-6 form-control" type="password" id="pass2" name="pass2" id="pass2" required>
                </div>

                <div class="row">
                    <button type="submit" id="submit" class="col-sm-5 col-md-6 offset-sm-7 offset-md-6 my-2 my-sm-0 btn btn-lg btn-primary btn-block">Cambiar</button>
                </div>

                <div id="avisoPassOld" class="text-center mt-2" style="display: none;">La contraseña antigua no coincide</div>
                <div id="avisoPass" class="text-center mt-2" style="display: none;">Las contraseñas deben coincidir</div>
                <div id="avisoCambiada" class="text-center mt-2" style="display: none;">Contraseña cambiada con éxito</div>
            </form>
        </div>
        
        <div id="favs" class="col-12 col-lg-6 d-none d-lg-block px-0">
            <table id="tabla" class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="w-100 nombre">Nombre</th>
                        <th class="d-none d-sm-table-cell dif">Dificultad</th>
                        <th class="d-sm-none dif text-center">Dif.</th>
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
<?php 
}else{//Redireccionar al login
    ?><script>window.location.replace("login");</script><?php
}
?>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>