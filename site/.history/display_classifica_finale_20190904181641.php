<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// print("<pre>".print_r($arraysquadre,true)."</pre>").'<br>';
?>


<div id="tabs-4">
<?php 



?>

<h2>FINALE CAMPIONATO</h2>

</div>