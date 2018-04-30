<?php
require '../model/DB.php';

$db = new DB();

echo "getRecetas<br>";
$db->GetInstance();
$recetas = $db->getRecetas();
print_r($recetas);


echo "<br><br>getReceta<br>";
$db->GetInstance();
print_r($db->getReceta("2"));


echo "<br><br>getRecetasDif<br>";
$db->GetInstance();
print_r($db->getRecetasDif("1"));


echo "<br><br>getRecetasNumCom<br>";
$db->GetInstance();
print_r($db->getRecetasNumCom("4"));


echo "<br><br>getRecetasTipo<br>";
$db->GetInstance();
$tipo = array('1','2','8');
print_r($db->getRecetasTipo($tipo));


echo "<br><br>getOpinionesRecetas<br>";
$db->GetInstance();
print_r($db->getOpinionesRecetas("2"));


echo "<br><br>getTipoDificultades<br>";
$db->GetInstance();
print_r($db->getTipoDificultades());


echo "<br><br>getTipoIngredientes<br>";
$db->GetInstance();
print_r($db->getTipoIngredientes());


echo "<br><br>getTipoReceta<br>";
$db->GetInstance();
print_r($db->getTipoReceta());


echo "<br><br>getLikes<br>";
$db->GetInstance();
print_r($db->getLikes(5));
?>