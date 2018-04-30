<?php
require '../model/DB.php';

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
	    require __DIR__ . '/templates/register.php';
	}
	
	
	public function login() {
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
	
	
	public function receta() {
        $model=DB::GetInstance();
        $params = array (
            'receta' => $model->getReceta(@$_GET['id']),
            'likes'  => $model->getLikes(@$_GET['id'])
        );
	    require __DIR__ . '/templates/receta.php';
	}
	
    
	
	/**
	 * Inserta un empleado
	 */
	public function insertar() {
		$params = array (
				'first_name' => '',
				'last_name' => '',
				'gender' => '',
				'birth_date' => '',
				'hire_date' => '' 
		);
		
		$m = new DB ();
		
		if (isset ( $_POST ['insertar'] )) {
			$nombre = recoge ( 'first_name' );
			$apellido = recoge ( 'last_name' );
			$genero = recoge ( 'gender' );
			$nac = recoge ( 'birth_date' );
			$contra = recoge ( 'hire_date' );
			// comprobar campos formulario
			if (validarDatos ( $nombre, $apellido, $genero, $nac, $contra )) {
				if ($m->insertarEmpleado ( recoge ( 'first_name' ), recoge ( 'last_name' ), recoge ( 'gender' ), recoge ( 'birth_date' ), recoge ( 'hire_date' ) )) {
					header ( 'Location: index.php?ctl=listar' );
				} else {
					$params = array (
							'first_name' => $nombre,
							'last_name' => $apellido,
							'gender' => $genero,
							'birth_date' => $nac,
							'hire_date' => $contra 
					);
					$params ['mensaje'] = 'No se ha podido insertar el empleado. Revisa el formulario';
				}
			} else {
				$params = array (
						'first_name' => $nombre,
						'last_name' => $apellido,
						'gender' => $genero,
						'birth_date' => $nac,
						'hire_date' => $contra 
				);
				$params ['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario';
			}
		}
		
		require __DIR__ . '/templates/formInsertar.php';
	}
	
	
	/**
	 * Busca empleados con un determinado nombre
	 */
	public function buscarPorNombre() {
		$params = array (
				'nombre' => '',
				'resultado' => array () 
		);
		
		$m = new DB ();
		
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$nombre = recoge ( "nombre" );
			$params ['nombre'] = $nombre;
			$params ['resultado'] = $m->buscarEmpleadosPorNombre ( $nombre );
		}
		
		require __DIR__ . '/templates/buscarPorNombre.php';
	}
	
	
	/**
	 * Muestra empleados hasta un determinado salario
	 */
	public function buscarPorSalario() {
		$params = array (
				'salary' => '',
				'resultado' => array () 
		);
		
		$m = new DB ();
		
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$salario = recoge ( "salario" );
			$params ['salary'] = $salario;
			$params ['resultado'] = $m->buscarEmpleadosPorSalario ( $salario );
		}
		
		require __DIR__ . '/templates/buscarPorSalario.php';
	}
	
	
	/**
	 * Muestra empleados en un determinado departamento
	 */
	public function buscarPorDepartamento() {
		$params = array (
				'dept_name' => '',
				'resultado' => array () 
		);
		
		$m = new DB ();
		
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$departamento = recoge ( "departamento" );
			$params ['dept_name'] = $departamento;
			$params ['resultado'] = $m->buscarEmpleadosPorDepartamento ( $departamento );
		}
		
		require __DIR__ . '/templates/buscarPorDepartamento.php';
	}
	
	
	/**
	 * Muestra empleados en un determinado puesto
	 */
	public function buscarPorPuesto() {
		$params = array (
				'title' => '',
				'resultado' => array ()
		);
	
		$m = new DB ();
	
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$puesto = recoge ( "puesto" );
			$params ['title'] = $puesto;
			$params ['resultado'] = $m->buscarEmpleadosPorPuesto( $puesto );
		}
	
		require __DIR__ . '/templates/buscarPorPuesto.php';
	}
	
	
	/**
	 * Muestra el empleado sobre el que se ha hecho click
	 */
	public function ver() {
		if (! isset ( $_GET ['id'] )) {
			$params = array (
					'mensaje' => 'No has seleccionado ningun elemento que mostrar',
					'fecha' => date ( 'd-m-y' ) 
			);
			require __DIR__ . '/templates/inicio.php';
		}
		
		$id = recoge ( 'id' );
		
		$m = new DB ();
		
		$empleado = $m->dameEmpleado ( $id );
		
		$params = $empleado;
		// Si la consulta no ha devuelto resultados volvemos a la página de inicio
		if (empty ( $params )) {
			$params = array (
					'mensaje' => 'No hay empleado que mostar',
					'fecha' => date ( 'd-m-y' ) 
			);
			require __DIR__ . '/templates/inicio.php';
		} else
			
			require __DIR__ . '/templates/verEmpleado.php';
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
}
?>
