<?php
$path = $_SERVER['DOCUMENT_ROOT'];

$path = "../menu.php";
#include("menu.php");
#echo "path=" . $path;
include($path);
// include("home.html");

include("homecontent.php");

include("../footer.php");

?>
