<?php
$path = $_SERVER['DOCUMENT_ROOT'];

$path = "../menu.php";
#include("menu.php");
#echo "path=" . $path;
include($path);
include("home.html");

include("../footer.html");


?>
