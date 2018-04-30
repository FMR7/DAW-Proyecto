<!--EL CSS VA AQUÍ-->
<?php ob_start() ?>
<link rel="stylesheet" href="../../web/css/receta.css" type="text/css"/>
<?php $css = ob_get_clean() ?>


<!--EL JS VA AQUÍ-->
<?php ob_start() ?>
<script type="text/javascript">
    $( document ).ready(function() {
        evtLikes();
        evtReceta();
        evtComents();

        likesUpdate();

        function evtLikes(){
            //Click Like
            $(".oi-thumb-up").click(function() {
                var likes = parseInt($("#likes").text(), 10);
                $(".oi-thumb-up").toggleClass("liked");
                if($(".oi-thumb-up").hasClass("liked")){
                    likes++;
                    if($(".oi-thumb-down").hasClass("disliked")){
                        $(".oi-thumb-down").trigger( "click" );
                    }
                }else{
                    likes--;
                }

                $("#likes").text(likes);
                likesUpdate();
                //AJAX UPDATE OPINION

            });


            //Click Dislike
            $(".oi-thumb-down").click(function() {
                var dislikes = parseInt($("#dislikes").text(), 10);
                $(".oi-thumb-down").toggleClass("disliked");
                if($(".oi-thumb-down").hasClass("disliked")){
                    dislikes++;
                    if($(".oi-thumb-up").hasClass("liked")){
                        $(".oi-thumb-up").trigger( "click" );
                    }
                }else{
                    dislikes--;
                }

                $("#dislikes").text(dislikes);
                likesUpdate();
                //AJAX UPDATE OPINION

            });


        }
        function evtReceta(){
            evtCrea("#goIngre");
            evtCrea("#goElabo");


            function evtCrea(str){
                $(str).click(function() {
                    if(!($(str).hasClass("active"))){
                        $("#goIngre").toggleClass("active");
                        $("#goElabo").toggleClass("active");
                        $("#ingre").toggleClass("d-none");
                        $("#elabo").toggleClass("d-none");
                    }
                });
            }
        }
        function evtComents(){
            evtCrea("#verOpi");
            evtCrea("#opinar");


            function evtCrea(str){
                $(str).click(function() {
                    if(!($(str).hasClass("active"))){
                        $("#verOpi").toggleClass("active");
                        $("#opinar").toggleClass("active");
                        $("#miOpinion").toggleClass("d-none");
                        $("#opiniones").toggleClass("d-none");
                    }
                });
            }
        }

    });


    //Actualiza las barras que muestran la proporción de likes
    function likesUpdate(){
        var likes = parseInt($("#likes").text(), 10);
        var dislikes = parseInt($("#dislikes").text(), 10);
        var total = likes + dislikes;

        var likesBar = Math.round(100*likes/total);
        var dislikesBar = Math.round(100*dislikes/total);


        $("#likesBar").width(likesBar+"%");
        $("#likesBar").attr("aria-valuenow", likesBar);

        $("#dislikesBar").width(dislikesBar+"%");
        $("#dislikesBar").attr("aria-valuenow", dislikesBar);

    }
</script>
<?php $js = ob_get_clean() ?>


<!--EL HTML VA AQUÍ-->
<?php ob_start() ?>
<?php 
    $receta = $params['receta'][0];
    $likes = $params['likes'];
?>
<div id="contenido" class="col-12 col-md-8 content">
    <div class="row">
        <h4 class="col-12 h4 mb-3 font-weight-normal"><?php echo $receta['nombre'] ?></h4>
    </div>

    <div class="row mb-1">
        <div class="col-sm-6 offset-sm-6 px-0 container">
            <div class="row m-0 mb-1">
                <span class="col-1 px-0 pl-1 oi oi-thumb-up" title="Like"></span>
                <span class="col-5 px-0" id="likes" title="Likes"><?php echo $likes['likes'] ?></span>
                <span class="col-5 px-0 text-right" id="dislikes" title="Dislikes"><?php echo $likes['disLikes'] ?></span>
                <span class="col-1 px-0 pr-1 pt-1 oi oi-thumb-down text-right" title="Dislike"></span>
            </div>
        </div>
        <div class="col-sm-6 offset-sm-6 px-0 progress" style="height: 8px;">
            <div id="likesBar" class="progress-bar bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" title="Likes"></div>
            <div id="dislikesBar" class="progress-bar bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" title="Dislikes"></div>
        </div>
    </div>

    <div class="row">
        <nav id="nav" class="col-12 nav nav-pills nav-fill">
            <a id="goElabo" class="rounded bb-0 col-12 col-md-6 nav-item nav-link active d-lg-none">Elaboración</a>
            <a id="goIngre" class="rounded bb-0 col-12 col-md-6 nav-item nav-link d-lg-none">Ingredientes</a>

            <a id="goElaboLg" class="rounded bb-0 br-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Elaboración</a>
            <a id="goIngreLg" class="rounded bb-0 bl-0 col-12 col-md-6 nav-item nav-link active d-none d-lg-block">Ingredientes</a>
        </nav>
    </div>

    <div class="row bt-0" id="receta">
        <textarea id="elabo" class="col-12 col-lg-6 d-lg-block" name="" id="" rows="10" readonly><?php echo $receta['elaboracion'] ?></textarea>

        <div id="ingre" class="col-12 col-lg-6 table-responsive d-none d-lg-block">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 108px;" class="text-right d-none d-sm-block">Cantidad</th>
                        <th style="width: 20px;" class="text-right d-sm-none">Cnt.</th>
                        <th style="width: 80%;">Ingrediente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    $ingredientes = explode(";", $receta['ingredientes']);
foreach ($ingredientes as $ingrediente){
    $cntIng = explode("#", $ingrediente);
    echo "<tr><td>".$cntIng[0]."</td>";
    echo "<td>".@$cntIng[1]."</td></tr>";
}
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row mt-5">
        <nav id="nav" class="col-12 nav nav-pills nav-fill">
            <a id="opinarLg" class="rounded bb-0 col-12 nav-item nav-link active d-none d-lg-block">Comentar</a>
            <a id="opinar" class="rounded bb-0 col-12 col-md-6 nav-item nav-link active d-lg-none">Comentar</a>

            <a id="verOpi" class="rounded bb-0 col-12 col-md-6 nav-item nav-link d-lg-none">Ver comentarios</a>
        </nav>
    </div>


    <div class="row mb-5 d-lg-block" id="miOpinion">
        <textarea class="col-12 text-justify bt-0" name="miOpinion" rows="5" placeholder="Escribe aquí tu comentario."></textarea>
        <button type="button" id="publicar" class="col-4 offset-8 btn btn-lg btn-primary btn-block">Publicar</button>
    </div>


    <div class="row mt-5 d-none d-lg-block">
        <nav id="nav" class="col-12 nav nav-pills nav-fill">
            <a id="verOpiLg" class="bb-0 col-12 nav-item nav-link active">Comentarios</a>
        </nav>
    </div>

    <div class="row mb-5 pt-3 d-none d-lg-block" id="opiniones">
        <opinion class="col-12 content">
            <h5 class="col-12">Usuario146</h5>
            <p class="col-12 text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur nemo quae labore tenetur illum voluptates nesciunt nostrum alias culpa vero commodi, magni mollitia consequatur nam temporibus eaque ea velit aliquid?</p>
        </opinion>

        <div class="separador col-8 offset-2 mb-3 mt-3"></div>

        <opinion class="col-12 content">
            <h5 class="col-12">Usuario386</h5>
            <p class="col-12 text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur nemo quae labore tenetur illum voluptates nesciunt nostrum alias culpa vero commodi, magni mollitia consequatur nam temporibus eaque ea velit aliquid?</p>
        </opinion>

        <div class="separador col-8 offset-2 mb-3 mt-3"></div>

        <opinion class="col-12 content">
            <h5 class="col-12">Usuario164</h5>
            <p class="col-12 text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur nemo quae labore tenetur illum voluptates nesciunt nostrum alias culpa vero commodi, magni mollitia consequatur nam temporibus eaque ea velit aliquid?</p>
        </opinion>
    </div>
</div>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>