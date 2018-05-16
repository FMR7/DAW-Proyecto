<?php

require_once __DIR__ . '/../app/Controller.php';

$map = array(
	'inicio'        => array('controller' =>'Controller', 'action' =>'inicio'),
    'login'         => array('controller' =>'Controller', 'action' =>'login'),
    'logout'        => array('controller' =>'Controller', 'action' =>'logout'),
    'register'      => array('controller' =>'Controller', 'action' =>'register'),
    'recuperar'     => array('controller' =>'Controller', 'action' =>'recover'),
    'nuevaPass'     => array('controller' =>'Controller', 'action' =>'cambiarPass'),
    'perfil'        => array('controller' =>'Controller', 'action' =>'perfil'),
    'borrarCuenta'  => array('controller' =>'Controller', 'action' =>'borrarUsuario'),
    'confirmar'     => array('controller' =>'Controller', 'action' =>'confirmarCuenta'),
    'recetas'       => array('controller' =>'Controller', 'action' =>'misRecetas'),
    'borrar'        => array('controller' =>'Controller', 'action' =>'borrarReceta'),
    'borrarComment' => array('controller' =>'Controller', 'action' =>'borrarComment'),
	'nueva'         => array('controller' =>'Controller', 'action' =>'nueva'),
    'subir'         => array('controller' =>'Controller', 'action' =>'subirReceta'),
    'editar'        => array('controller' =>'Controller', 'action' =>'editar'),
    'actualizar'    => array('controller' =>'Controller', 'action' =>'actualizar'),
    'receta'        => array('controller' =>'Controller', 'action' =>'receta'),
    'like'          => array('controller' =>'Controller', 'action' =>'setLike'),
    'comment'       => array('controller' =>'Controller', 'action' =>'setComment'),
    'notFound'      => array('controller' =>'Controller', 'action' =>'notFound'),
    'admin'         => array('controller' =>'Controller', 'action' =>'admin')
);

if (isset($_GET['ctl'])) {
	if (isset($map[$_GET['ctl']])) {
		$ruta = $_GET['ctl'];
	} else {
	    $ruta = 'notFound';
	}
} else {
	$ruta = 'inicio';
}

$controlador = $map[$ruta];

if (method_exists($controlador['controller'],$controlador['action'])) {
	call_user_func(array(new $controlador['controller'], $controlador['action']));
} else {
	header('Status: 404 Not Found');
	echo '<html><body><h1>Error 404: El controlador <i>' .
	$controlador['controller'] .'->' .	$controlador['action'] .'</i> no existe</h1></body></html>';
}
