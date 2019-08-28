<?php
function my_autoloader($class) {
    include 'DB/' . $class . '.class.php';
}
spl_autoload_register('my_autoloader');

$id_girone=$_GET['id_girone'];
$idcasa=$_GET['idcasa'];
$idospite=$_GET['idospite'];
$result = new Partita($id_girone, $idcasa, $idospite, true, 1);
print_r($result);
?>