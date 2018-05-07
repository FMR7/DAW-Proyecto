<?php
require '../model/DB.php';
require 'libs/utils.php';

class Controller {
    
	public function inicio() {
        $model=DB::GetInstance();
        $params = array (
            'recetas'      => $model->getRecetas(),
            'dificultades' => $model->getTipoDificultades(),
            'ingredientes' => $model->getTipoIngredientes(),
            'tiposReceta'  => $model->getTipoReceta()
        );
		require __DIR__ . '/templates/inicio.php';
	}
	
	
	public function register() {
        $datos = ["user", "email", "pass1", "pass2"];
        
        $register = true;
        foreach($datos as $dato){
            if(!isset($_POST[$dato])){
                $register = false;
                break;
            }
        }
        
        if($register){
            $params = array (
                'user'  => $_POST["user"],
                'email' => $_POST["email"]
            );
            
            $model=DB::GetInstance();

            $existsUser  = $model->existsUser($_POST["user"]);
            $existsEmail = $model->existsEmail($_POST["email"]);

            if($existsUser){//El usuario ya está en uso
                $params['errorUser'] = 1;
                $register = false;
            }if($existsEmail){//El email ya está en uso
                $params['errorMail'] = 1;
                $register = false;
            }
            
            
        }
        
        if($register){//Insertar usuario
            if($_POST["pass1"]===$_POST["pass2"]){ //Ambas contraseñas deben de ser iguales
                
                //Inserta usuario
                $insertado = $model->setUser($_POST["user"], $_POST["email"], hash('sha512', $_POST["pass1"]));
                
                if($insertado){
                    //Envía email confirmación
                    
                    //Iniciar sesión
                    openSession($_POST["user"]);
                    
                    require __DIR__ . '/templates/inicio.php';
                }
            }
        }
        
	    require __DIR__ . '/templates/register.php';
	}
	
	
	public function login() {
        if((isset($_POST["user"]))&&(isset($_POST["pass"]))){
            $model=DB::GetInstance();
            
            $user = $_POST["user"];//Quitar espacios
            $pass = hash('sha512', $_POST["pass"]);
            
            $login=$model->getUser($user, $pass);
            if($login){
                openSession($user);
            }else{
                closeSession();
            }
        }
        
	    require __DIR__ . '/templates/login.php';
	}
	
	
	public function logout() {
        closeSession();
        
        $model=DB::GetInstance();
        $params = array (
            'recetas' => $model->getRecetas()
        );
	    require __DIR__ . '/templates/inicio.php';
	}
	
	
	public function perfil() {
        $model=DB::GetInstance();
        $datos = $model->getProfile(getSession());
        $params = array (
            'user'  => $datos['username'],
            'email' => $datos['email']
        );
        
        
        $campos = ["passOld", "pass1", "pass2"];
        
        $changePass = true;
        foreach($campos as $dato){
            if(!isset($_POST[$dato])){
                $changePass = false;
                break;
            }
        }
        
        if($changePass){
            foreach($campos as $dato){
                if($_POST[$dato]==""){
                    $changePass = false;
                    break;
                }
            }
            
            if($_POST["pass1"]!==$_POST["pass2"]){
                $changePass = false;
            }
        }
        
        
        if($changePass){
            $oldPass = hash('sha512', $_POST["passOld"]);
            $currentPass = strtolower($model->getPass(getSession()));
            if($oldPass==$currentPass){
                //Cambiar contraseña
                $newPass = hash('sha512', $_POST["pass1"]);
                $cambiada = $model->setPass(getSession(), $newPass);
                if($cambiada){
                    $params['cambiada'] = "si";
                }
            }else{
                $params['errorPassOld'] = "La contraseña antigua no coincide";
            }
        }
        
        
	    require __DIR__ . '/templates/perfil.php';
	}
    
    
    public function misRecetas(){
        $model=DB::GetInstance();
        $params = array (
            'recetas' => $model->getRecetasUser(getSession())
        );
        
        require __DIR__ . '/templates/misRecetas.php';
    }
    
    
    public function borrarReceta(){
        @session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login']!=""){
                $id = recogeNumero($_POST["idReceta"]);

                $model=DB::GetInstance();
                $recetaPropia = $model->isFromUser($id, getSession());
                if($recetaPropia){
                    $borrada = $model->delReceta($id);
                    if($borrada){
                        echo true;
                    }else{
                        echo false;
                    }
                }
            }
        }else{
            echo "<script>window.location.replace(\"inicio\");</script>";
        }
    }
    
	
	public function nueva() {
        $model=DB::GetInstance();
        $params = array (
            'dificultades' => $model->getTipoDificultades(),
            'ingredientes' => $model->getTipoIngredientes(),
            'tiposReceta'  => $model->getTipoReceta()
        );
	    require __DIR__ . '/templates/nueva.php';
	}
    
    
    public function editar(){
        $model=DB::GetInstance();
        $recetaPropia = $model->isFromUser(@$_GET['id'], getSession());
        if($recetaPropia){
            $params = array (
                'idReceta'     => @$_GET['id'],
                'receta'       => $model->getReceta(@$_GET['id']),
                'recetaTipos'  => $model->getTiposReceta(@$_GET['id']),
                'dificultades' => $model->getTipoDificultades(),
                'ingredientes' => $model->getTipoIngredientes(),
                'tiposReceta'  => $model->getTipoReceta()
            );
        }
        
        require __DIR__ . '/templates/editar.php';
    }
    
    
    public function actualizar(){
        @session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login']!=""){
            
                if(checkCampos()){
                    $id     = recogeNumero($_POST["idReceta"]);
                    $nombre = ucfirst(mb_strtolower(recogeTexto($_POST["nombre"])));
                    $elabo  = recogeTexto($_POST["elaboracion"]);
                    $ingre  = recogeArray($_POST["ingredientes"]);
                    $diff   = recogeNumero($_POST["dificultad"]);
                    $tIngre = recogeNumero($_POST["tipoIngredientes"]);
                    $tRece  = recogetipoRece($_POST["tipoReceta"]);
                    $numCom = recogeNumero($_POST["numCom"]);

                    
                    $model=DB::GetInstance();
                    
                    //Comprobar si la receta es del usuario
                    if($model->isFromUser($id, getSession())){
                        $updated = $model->updateReceta($id, $nombre, $elabo, $ingre, $diff, $tIngre, $numCom);
                        if($updated){
                            //Quitar tipos a receta
                            $model->delRecetaTipos($id);
                            
                            //Asignar tipos a receta
                            $model->setRecetaTipos($id, $tRece);

                            //Redirecciona a la nueva receta
                            $params = array (
                                'receta' => $model->getReceta($id),
                                'likes'  => $model->getLikes($id)
                            );

                            echo true."#".$id;
                        }
                    }
                    echo false;
                }else{//Faltan campos por rellenar;
                    echo "<script>window.location.replace(\"inicio\");</script>";
                }
            }
        }else{//Sin sesión
            echo "<script>window.location.replace(\"inicio\");</script>";
        }
    }
    
    
    public function subirReceta() {
        @session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login']!=""){
            
                if(checkCampos()){
                    $nombre = ucfirst(mb_strtolower(recogeTexto($_POST["nombre"])));
                    $elabo  = recogeTexto($_POST["elaboracion"]);
                    $ingre  = recogeArray($_POST["ingredientes"]);
                    $diff   = recogeNumero($_POST["dificultad"]);
                    $tIngre = recogeNumero($_POST["tipoIngredientes"]);
                    $tRece  = recogetipoRece($_POST["tipoReceta"]);
                    $numCom = recogeNumero($_POST["numCom"]);

                    $model=DB::GetInstance();
                    $inserted = $model->setReceta($nombre, $elabo, $ingre, $diff, $tIngre, $numCom);
                    if($inserted){
                        $idReceta = $model->lastInsertedId();

                        //Asignar tipos a receta
                        $model->setRecetaTipos($idReceta, $tRece);

                        //Asignar receta a usuario
                        $model->setRecetaUser(getSession(), $idReceta);

                        //Redirecciona a la nueva receta
                        $params = array (
                            'receta' => $model->getReceta($idReceta),
                            'likes'  => $model->getLikes($idReceta)
                        );

                        echo true."#".$idReceta;
                    }else{
                        $model->delReceta($lastId);
                        echo false;
                    }
                }else{//Faltan campos por rellenar;
                    echo "<script>window.location.replace(\"inicio\");</script>";
                }
            }
        }else{//Sin sesión
            echo "<script>window.location.replace(\"inicio\");</script>";
        }
	}
	
	
	public function receta() {
        if(isset($_GET['id'])){
            $model=DB::GetInstance();
            if($model->existsReceta($_GET['id'])){
                $user = getSession();
                
                $myLike = null;
                $myComment = null;
                $comments = $model->getComments($_GET['id']);
                
                if((isset($user))&&(@$user!="")){
                    //Cargar like propio
                    $myLike = $model->getLike($_GET['id'], $user);
                    

                    //Quitar comentario propio de la lista de comentarios y cargarlo en otra variable
                    for($i=0; $i<count($comments); $i++){
                        if(($comments[$i]['username']==$user)&&($user!=null)){
                            $myComment = $comments[$i]['comentario'];
                            unset($comments[$i]);
                        }
                    }
                }
                
                $params = array (
                    'idReceta' => $_GET['id'],
                    'receta'   => $model->getReceta($_GET['id']),
                    'likes'    => $model->getLikes($_GET['id']),
                    'myLike'   => $myLike,
                    'comments' => $comments,
                    'myComment'=> $myComment
                );
                require __DIR__ . '/templates/receta.php';
            }else{
                echo "<script>window.location.replace(\"../inicio\");</script>";
            }
        }else{
            echo "<script>window.location.replace(\"../inicio\");</script>";
        }
	}
	
    
    public function setLike(){
        @session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login']!=""){
                if(isset($_POST['idReceta'])){
                    $model=DB::GetInstance();
                    $inserted=false;

                    if(isset($_POST['like'])){
                        switch($_POST['like']){
                        case 2:
                            $inserted = $model->setLike(@$_POST['idReceta'], getSession(), 2);
                            break;
                        case 1:
                            $inserted = $model->setLike(@$_POST['idReceta'], getSession(), 1);
                            break;
                        default:
                            $inserted = $model->setLike(@$_POST['idReceta'], getSession(), 0);
                    }
                    }else{
                        $inserted = $model->setLike(@$_POST['idReceta'], getSession(), 0);
                    }
                    
                    if($inserted){
                        echo true;
                    }else{
                        echo false;
                    }
                }else{//Llamada forzada
                    echo "<script>window.location.replace(\"inicio\");</script>";
                }
            }else{//Sin sesión
                echo "<script>window.location.replace(\"inicio\");</script>";
            }
        }else{//Sin sesión
            echo 0;
        }
    }
    
	
    public function notFound(){
        require __DIR__ . '/templates/404.php';
    }
    
}
?>
