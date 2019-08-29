<?php
$queryportieri ="SELECT *
FROM `giocatori` g
left outer join rose r on r.id_giocatore = g.id
where g.ruolo = 'P'
AND r.id_sq_fc is null
LIMIT 3;";
$querydifensori ="SELECT *
FROM `giocatori` g
left outer join rose r on r.id_giocatore = g.id
where g.ruolo = 'D'
AND r.id_sq_fc is null
LIMIT 9;";
$querycentrocampisti ="SELECT *
FROM `giocatori` g
left outer join rose r on r.id_giocatore = g.id
where g.ruolo = 'C'
AND r.id_sq_fc is null
LIMIT 9;";
$queryattaccanti ="SELECT *
FROM `giocatori` g
left outer join rose r on r.id_giocatore = g.id
where g.ruolo = 'A'
AND r.id_sq_fc is null
LIMIT 7;";



// include("../../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try{

    $querydelete = $query="Truncate `rose`";
    $result  = $conn->query($querydelete) or die($conn->error); 

    print("<pre>".print_r($result,true)."</pre>").'<br>';
    for($idsquadrafc =1; $idsquadrafc<= 12; $idsquadrafc++)
    {
        $resultportieri  = $conn->query($queryportieri) or die($conn->error); 
        $idsquadra=0;
        while ($row = $resultportieri->fetch_assoc()) {
            $idsquadra=$row["id"];
            $queryinsert = "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadrafc,1,$idsquadra)";
            $result  = $conn->query($queryinsert) or die($conn->error); 
        }
        
        $resultdifensori  = $conn->query($querydifensori) or die($conn->error); 
        while ($row = $resultdifensori->fetch_assoc()) {
            $idsquadra=$row["id"];
            $queryinsert = "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadrafc,1,$idsquadra)";
            $result  = $conn->query($queryinsert) or die($conn->error); 
        }

        $resultcentrocampisti  = $conn->query($querycentrocampisti) or die($conn->error); 
        while ($row = $resultcentrocampisti->fetch_assoc()) {
            $idsquadra=$row["id"];
            $queryinsert = "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadrafc,1,$idsquadra)";
            $result  = $conn->query($queryinsert) or die($conn->error); 
        }

        $resultattaccanti  = $conn->query($queryattaccanti) or die($conn->error); 
        while ($row = $resultattaccanti->fetch_assoc()) {
            $idsquadra=$row["id"];
            $queryinsert = "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadrafc,1,$idsquadra)";
            $result  = $conn->query($queryinsert) or die($conn->error); 
        }

        echo "squadra $idsquadrafc OK <br/>" ;
    }
    
}
catch(Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
finally{
    $conn->close();
}
?>
