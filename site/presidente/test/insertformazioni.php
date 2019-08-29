<?php
$queryportieri ="SELECT *
FROM `giocatori` g
left outer join rose r on r.id_giocatore = g.id
where g.ruolo = 'P'
AND r.id_sq_fc is null
LIMIT 3;";


include("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try{

    $querydelete = $query="Truncate `formazioni`";

    //per ogni squadra inserisco una formazione random
}
catch(Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
finally{
    $conn->close();
}
?>