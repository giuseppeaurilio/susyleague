<?php 
include("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "start <br/>";
// per ogni squadra
for ($idsquadra = 1; $idsquadra <= 12; $idsquadra++) {

    //inserisco 3 portieri
    for($idp = 1; $idp <= 3; $idp++){
        // $queryfindgiocatore = "SELECT * FROM `giocatori` WHERE ruolo='P' order by id limit 1";
        $queryfindgiocatore = "SELECT * FROM `giocatori`  left join `rose` on `rose`.`id_giocatore` = `giocatori`.`id` WHERE ruolo='P' and id_sq_fc is null order by id limit 1";
        $resultfindgiocaotre  = $conn->query($queryfindgiocatore) or die($conn->error);
        if($resultfindgiocaotre->num_rows != 0){
            while ($row = $resultfindgiocaotre->fetch_assoc()) {
                // print_r($row).  "<br/>";
                $queryinsertgiocatore="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $idsquadra ."', '". $row["id"] ."', '1')";
            }
            // echo $queryinsertgiocatore . "<br/>";
            $resultinsertgiocatore  = $conn->query($queryinsertgiocatore) or die($conn->error);
        }
        else{
            print_r($resultfindgiocaotre);
        }
    }
    //inserisco 9 difensori
    for($idp = 1; $idp <= 9; $idp++){
        // $queryfindgiocatore = "SELECT * FROM `giocatori` WHERE ruolo='P' order by id limit 1";
        $queryfindgiocatore = "SELECT * FROM `giocatori`  left join `rose` on `rose`.`id_giocatore` = `giocatori`.`id` WHERE ruolo='D' and id_sq_fc is null order by id limit 1";
        $resultfindgiocaotre  = $conn->query($queryfindgiocatore) or die($conn->error);
        if($resultfindgiocaotre->num_rows != 0){
            while ($row = $resultfindgiocaotre->fetch_assoc()) {
                // print_r($row).  "<br/>";
                $queryinsertgiocatore="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $idsquadra ."', '". $row["id"] ."', '2')";
            }
            // echo $queryinsertgiocatore . "<br/>";
            $resultinsertgiocatore  = $conn->query($queryinsertgiocatore) or die($conn->error);
        }
        else{
            print_r($resultfindgiocaotre);
        }
    }
    //inserisco 9 centrocampisti
    for($idp = 1; $idp <= 9; $idp++){
        // $queryfindgiocatore = "SELECT * FROM `giocatori` WHERE ruolo='P' order by id limit 1";
        $queryfindgiocatore = "SELECT * FROM `giocatori`  left join `rose` on `rose`.`id_giocatore` = `giocatori`.`id` WHERE ruolo='C' and id_sq_fc is null order by id limit 1";
        $resultfindgiocaotre  = $conn->query($queryfindgiocatore) or die($conn->error);
        if($resultfindgiocaotre->num_rows != 0){
            while ($row = $resultfindgiocaotre->fetch_assoc()) {
                // print_r($row).  "<br/>";
                $queryinsertgiocatore="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $idsquadra ."', '". $row["id"] ."', '3')";
            }
            // echo $queryinsertgiocatore . "<br/>";
            $resultinsertgiocatore  = $conn->query($queryinsertgiocatore) or die($conn->error);
        }
        else{
            print_r($resultfindgiocaotre);
        }
    }
    //inserisco 7 attaccanti
    for($idp = 1; $idp <= 7; $idp++){
        // $queryfindgiocatore = "SELECT * FROM `giocatori` WHERE ruolo='P' order by id limit 1";
        $queryfindgiocatore = "SELECT * FROM `giocatori`  left join `rose` on `rose`.`id_giocatore` = `giocatori`.`id` WHERE ruolo='A' and id_sq_fc is null order by id limit 1";
        $resultfindgiocaotre  = $conn->query($queryfindgiocatore) or die($conn->error);
        if($resultfindgiocaotre->num_rows != 0){
            while ($row = $resultfindgiocaotre->fetch_assoc()) {
                // print_r($row).  "<br/>";
                $queryinsertgiocatore="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $idsquadra ."', '". $row["id"] ."', '4')";
            }
            // echo $queryinsertgiocatore . "<br/>";
            $resultinsertgiocatore  = $conn->query($queryinsertgiocatore) or die($conn->error);
        }
        else{
            print_r($resultfindgiocaotre);
        }
    }
    //inserisco 1 jolly
    for($idp = 1; $idp <= 1; $idp++){
        // $queryfindgiocatore = "SELECT * FROM `giocatori` WHERE ruolo='P' order by id limit 1";
        $queryfindgiocatore = "SELECT * FROM `giocatori`  left join `rose` on `rose`.`id_giocatore` = `giocatori`.`id` WHERE id_sq_fc is null order by id limit 1";
        $resultfindgiocaotre  = $conn->query($queryfindgiocatore) or die($conn->error);
        if($resultfindgiocaotre->num_rows != 0){
            while ($row = $resultfindgiocaotre->fetch_assoc()) {
                // print_r($row).  "<br/>";
                $queryinsertgiocatore="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $idsquadra ."', '". $row["id"] ."', '1')";
            }
            // echo $queryinsertgiocatore . "<br/>";
            $resultinsertgiocatore  = $conn->query($queryinsertgiocatore) or die($conn->error);
        }
        else{
            print_r($resultfindgiocaotre);
        }
    }
}
echo "end <br/>";
?>
