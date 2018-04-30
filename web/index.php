<?php

require_once __DIR__ . '/../app/Controller.php';

$map = array(
	'inicio'=>    array('controller' =>'Controller', 'action' =>'inicio'),
    'login'=>     array('controller' =>'Controller', 'action' =>'login'),
    'logout'=>    array('controller' =>'Controller', 'action' =>'logout'),
    'register'=>  array('controller' =>'Controller', 'action' =>'register'),
    'perfil'=>    array('controller' =>'Controller', 'action' =>'perfil'),
	'nueva' =>    array('controller' =>'Controller', 'action' =>'nueva'),
    'receta' =>   array('controller' =>'Controller', 'action' =>'receta'),
    'notFound' => array('controller' =>'Controller', 'action' =>'notFound'),
    'admin' =>    array('controller' =>'Controller', 'action' =>'admin')
);

if (isset($_GET['ctl'])) {
	if (isset($map[$_GET['ctl']])) {
		$ruta = $_GET['ctl'];
	} else {
	    $ruta = 'notFound';
        
	    /*
		header('Status: 404 Not Found');
		echo '<html><body><h1>Error 404: No existe la ruta <i>' .
		$_GET['ctl'] .'</p></body></html>';
		exit;*/
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
