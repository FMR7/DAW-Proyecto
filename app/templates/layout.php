<!doctype html>
<?php
require __DIR__."/../../model/Config.php";
$server=Config::$serverUrl;
?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="../../web/bootstrap-4.1.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../../web/images/open-iconic/font/css/open-iconic-bootstrap.css">

        <?php 
        echo @$css;
        ?>

        <link rel="stylesheet" href="../../web/css/general.css" >
        <link rel="stylesheet" href="../../web/css/flechaVolver.css">

        <style>
            #menu{
                margin: 0 -15px;
                min-height: 64px;
            }

            footer{
                height: 80px;
                border-top: 1px solid rgb(169, 169, 169);
            }
        </style>

        <title>Cocina y Comparte</title>
    </head>

    <body class="container align-items-start">
        <header class="row">
            <div class="col-12">
                <nav id="menu" class="navbar navbar-expand-sm navbar-dark bg-primary">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#items" aria-controls="navbarSupportedContent" aria-expanded="false">
                        <span class="oi oi-menu"></span>
                    </button>
                    <?php 
                    @session_start();
                    ?>
                    <div class="navbar order-sm-1">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <?php 
                                if(isset($_SESSION['login'])){
                                    if($_SESSION['login']!=""){
                                        ?>
                                        <a class="nav-item nav-link" href="<?php echo $server;?>logout">
                                            <span class="d-none d-sm-block">Cerrar sesión</span>
                                            <span class="d-block d-sm-none oi oi-account-logout"></span>
                                        </a>
                                        <?php 
                                    }else{
                                        ?>
                                        <a class="nav-item nav-link" href="<?php echo $server;?>login">
                                            <span class="d-none d-sm-block">Identificarse</span>
                                            <span class="d-block d-sm-none oi oi-account-login"></span>
                                        </a>
                                        <?php 
                                    }
                                }else{
                                    ?>
                                    <a class="nav-item nav-link" href="<?php echo $server;?>login">
                                        <span class="d-none d-sm-block">Identificarse</span>
                                        <span class="d-block d-sm-none oi oi-account-login"></span>
                                    </a>
                                    <?php 
                                }
                                ?>
                            </li>
                        </ul>
                    </div>

                    <div id="items" class="navbar-collapse collapse w-80">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-item nav-link active" href="<?php echo $server;?>inicio">Inicio</a>
                            </li>

                            <?php
                            if (isset($_SESSION['login'])){
                                if($_SESSION['login']!=""){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-item nav-link" href="<?php echo $server;?>nueva">Subir receta</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-item nav-link" href="<?php echo $server;?>perfil">Mi perfil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-item nav-link" href="<?php echo $server;?>recetas">Mis recetas</a>
                                    </li>
                                    <?php 
                                }
                            }
                            ?>
                        </ul>
                    </div>


                </nav>
            </div>
        </header>


        <content class="row pt-4">
            <?php 
            echo @$contenido;
            ?>
        </content>


        <footer class="row mt-3 pt-3">
            <div class="col-12 text-center">
                Proyecto de Grado Superior en Desarrollo de Aplicaciones Web<br>
                Fernando Marín Ramis
            </div>
            <script type="text/javascript" src="../../web/js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="../../web/js/popper.min.js"></script>
            <script type="text/javascript" src="../../web/bootstrap-4.1.0/js/bootstrap.js"></script>


            <?php 
            echo @$js;
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    menuUpdate();

                    //Evento para volver de la flecha para volver al principio de la página
                    $('#toTop').on("click", function(){
                        $('body,html').animate({
                            scrollTop : 0
                        }, 500);
                    });
                });


                //Muestra u oculta la flecha para volver al principio de la página
                $(window).scroll(function() {
                    if ($(this).scrollTop() >= 50) {
                        $('#toTop').fadeIn(200);
                    } else {
                        $('#toTop').fadeOut(200);
                    }
                });


                //Marca en el menú la página activa
                function menuUpdate(){
                    var url = window.location.pathname;
                    url = url.substring(1, url.length);

                    if(url != ""){
                        $('ul.navbar-nav a').removeClass('active');
                    }
                    $('ul.navbar-nav a[href="'+ "<?php echo $server ?>" + url +'"]').addClass('active');

                    if(url == "register"){//Marca register como login
                        $('ul.navbar-nav a[href="<?php echo $server;?>login"]').addClass('active');
                    }if(url == "logout"){//Redirecciona a inicio
                        window.location.replace("inicio");
                    }
                }
            </script>
            <div id="toTop"><span class="oi oi-arrow-top"></span></div>
        </footer>

    </body>
</html>