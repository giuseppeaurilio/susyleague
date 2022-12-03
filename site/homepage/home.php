<?php
$path = $_SERVER['DOCUMENT_ROOT'];

$path = "../menu.php";
#include_once ("menu.php");
#echo "path=" . $path;
include_once ($path);
// include_once ("home.html");

include_once ("homecontent.php");

include_once ("../footer.php");

?>
