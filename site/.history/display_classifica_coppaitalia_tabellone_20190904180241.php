<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone=5;
// echo "Connected successfully";
?>

<div id="tabs-6">
<?php 



?>

<h2>Coppa italia - Tabellone</h2>
<table >
<tr>
<th>Squadra</th>
<th>Punti</th>
</tr>


</table>
</div>