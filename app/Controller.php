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
        $datos = ["user", "email", "pass", "pass2"];
        
        $register = true;
        foreach($datos as $dato){
            if(!isset($_POST[$dato])){
                $register = false;
                break;
            }
        }
        
        
        if($register){//Insertar usuario
            if($_POST["pass"]===$_POST["pass2"]){ //Ambas contraseñas deben de ser iguales
                echo "REGISTRADO CON ÉXITO";

                $model=DB::GetInstance();
                //Inserta usuario
                $insertado = $model->setUser($_POST["user"], $_POST["email"], hash('sha512', $_POST["pass"]));

                /*if($insertado){

                }else{//Usuario o email ya en uso

                }*/

                //Envía email confirmación
                
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
                $params = array ('user' => $user);
            }else{
                $params = array ('user' => "");
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
	    require __DIR__ . '/templates/perfil.php';
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
    
    
    public function subirReceta() {
        if($this->checkCampos()){
            //echo "\nInsertar Controller\n";
            $nombre = ucfirst(strtolower(recogeTexto($_POST["nombre"])));
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
                //$model->setRecetaUser($_POST["login"], $idReceta);
                $model->setRecetaUser("fernando", $idReceta);
                
                //Redirecciona a la nueva receta
                $params = array (
                    'receta' => $model->getReceta($idReceta),
                    'likes'  => $model->getLikes($idReceta)
                );
                
                //return "true";
                //require __DIR__ . '/templates/receta.php';
                echo true;
            }else{
                $model->delReceta($lastId);
            }
            
        }else{
            //echo "\nFaltan campos por rellenar\n";
        }
	}
	
	
	public function receta() {
        $model=DB::GetInstance();
        $params = array (
            'receta' => $model->getReceta(@$_GET['id']),
            'likes'  => $model->getLikes(@$_GET['id'])
        );
	    require __DIR__ . '/templates/receta.php';
	}
	
	
	/**
	 * Comprueba usuario y contraseña y en caso correcto establece la variable de sesion
	 */
	public function openSession(){
		$params = array (
				'user' => '',
				'fecha' => date ( 'd-m-y' )
		);
		
		$user = recoge("user");
		$pass = hash('sha256', recoge("pass"));
		
		$params['user'] = $user;


		$m = new DB();
		$valido = $m->checkUser($user, $pass);
		
		if ($valido){
			session_start();
			$_SESSION['login'] = 1;
		}
		
		require __DIR__ . '/templates/inicio.php';
	}
	
	
	/**
	 * Cierra la sesion de forma segura y borra la cookie
	 */
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
