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
                $params['errorUser'] = "El nombre de usuario ya está en uso";
                $register = false;
            }if($existsEmail){//El email ya está en uso
                $params['errorMail'] = "El email ya está en uso";
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
                    $this->openSession($_POST["user"]);
                    
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
                $this->openSession($user);
            }else{
                $this->closeSession();
            }
        }
        
	    require __DIR__ . '/templates/login.php';
	}
	
	
	public function logout() {
        $this->closeSession();
        
        $model=DB::GetInstance();
        $params = array (
            'recetas' => $model->getRecetas()
        );
	    require __DIR__ . '/templates/inicio.php';
	}
	
	
	public function perfil() {
        $model=DB::GetInstance();
        $datos = $model->getProfile($this->getSession());
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
            $currentPass = strtolower($model->getPass($this->getSession()));
            if($oldPass==$currentPass){
                //Cambiar contraseña
                $newPass = hash('sha512', $_POST["pass1"]);
                $cambiada = $model->setPass($this->getSession(), $newPass);
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
            'recetas' => $model->getRecetasUser($this->getSession())
        );
        
        require __DIR__ . '/templates/misRecetas.php';
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
        $params = array (
            'receta' => $model->getReceta(@$_GET['id'])
        );
        require __DIR__ . '/templates/editar.php';
    }
    
    
    public function subirReceta() {
        @session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login']!=""){
            
                if($this->checkCampos()){
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
                        $model->setRecetaUser($this->getSession(), $idReceta);

                        //Redirecciona a la nueva receta
                        $params = array (
                            'receta' => $model->getReceta($idReceta),
                            'likes'  => $model->getLikes($idReceta)
                        );

                        echo true."#".$idReceta;
                    }else{
                        $model->delReceta($lastId);
                    }
                    return true;
                }else{//Faltan campos por rellenar;
                    
                }
            }
        }
        $this->inicio();
	}
	
	
	public function receta() {
        $model=DB::GetInstance();
        $params = array (
            'receta' => $model->getReceta(@$_GET['id']),
            'likes'  => $model->getLikes(@$_GET['id'])
        );
	    require __DIR__ . '/templates/receta.php';
	}
	
	
    //Inicia una sesión
	public function openSession($user){
        @session_start();
        $_SESSION['login'] = $user;
	}
	
    
    //Devuelve el nombre de usuario de la sesión actual
    public function getSession(){
        @session_start();
        return @$_SESSION['login'];
	}
    
	
    //Cierra la sesion de forma segura y borra la cookie
	public function closeSession(){
		//Destruir sesión
		session_start();
		session_destroy();
		unset($_SESSION);
		
		//Borrar cookie sesión
		$params = session_get_cookie_params();
		setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
	}
    
    
    private function checkCampos(){
        $continuar = true;

        if($_POST["nombre"]==""){
            echo "Nombre en blanco\n";
            $continuar = false;
        }

        if($_POST["elaboracion"]==""){
            echo "Elaboracion en blanco\n";
            $continuar = false;
        }

        if(count($_POST["ingredientes"])%2!=0){
            echo "Ingredientes impares\n";
            $continuar = false;
        }

        $ingreCorrecto = true;
        foreach ($_POST["ingredientes"] as $cantIngre){
            if($cantIngre==""){
                $ingreCorrecto = false;
            }
        }
        if(!$ingreCorrecto){
            echo "Ingrediente en blanco\n";
            $continuar = false;
        }

        if($_POST["dificultad"]==""){
            echo "Dificultad en blanco\n";
            $continuar = false;
        }

        if($_POST["tipoIngredientes"]==""){
            echo "Tipo de ingredientes en blanco\n";
            $continuar = false;
        }

        if($_POST["tipoReceta"]==""){
            echo "Tipo de receta en blanco\n";
            $continuar = false;
        }

        if($_POST["numCom"]<1){
            echo "Número de comensales menor que 1\n";
            $continuar = false;
        }

        return $continuar;
    }
    

}
?>
