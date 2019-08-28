<?php
function spl_autoload_register($class_name) {
    require_once $class_name . '.php';
  };
$id_girone=$_GET['id_girone'];
$idcasa=$_GET['idcasa'];
$idospite=$_GET['idospite'];
$result = new Partita($id_girone, $idcasa, $idospite, true, 1);
print_r($result);
?>