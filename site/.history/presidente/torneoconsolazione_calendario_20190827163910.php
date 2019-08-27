<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>

<h1>Calendario Torneo di consolazione</h2>


<?php

include("../dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$query= "SELECT giornate.*
        -- , 
        -- calendario.id_sq_casa, sq1.squadra as squadracasa,
        -- calendario.id_sq_ospite,  sq2.squadra as squadraospite 
        FROM `giornate` 
        -- left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
        -- left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
        -- left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_girone = 6 order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$giornate = array();
while ($row=$result->fetch_assoc()) {
    $id_giornata=$row["id_giornata"];
    $inizio=$row["inizio"];
    $fine=$row["fine"];
    // $id_sq1=$row["id_sq_casa"];
    // $sq1=$row["squadracasa"];
    // $id_sq2=$row["id_sq_ospite"];
    // $sq2=$row["squadraospite"];
    $inizio_a=date_parse($inizio);
    $fine_a=date_parse($fine);
    array_push($giornate, array(
        "id_giornata"=>$id_giornata,
        "inizio_a"=>$inizio_a,
        "fine_a"=>$fine_a,
        // "id_sq1"=>$id_sq1,
        // "sq1"=>$sq1,
        // "id_sq2"=>$id_sq2,
        // "sq2"=>$sq2,
        )
    );
}

$counter = 1;
// print_r($giornate);
foreach($giornate as $giornata){

    echo '<fieldset>';
    echo '<legend>Giornata:'.$counter.'</legend>';
    
    echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
    // echo '<label for="giornata">'.$giornata["sq1"].'-'.$giornata["sq2"].'(ID:'.$giornata["id_giornata"].') </label>';
    // echo '<a href="calcola_giornata.php?&id_giornata='. $giornata["id_giornata"] .'" >Calcola Giornata</a>';
    echo '<br>';
    echo '<input type="hidden" name="giornata" value="'.$giornata["id_giornata"].'">';
    echo 'Inizio: <br>';
    echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $giornata['inizio_a']['day'] .'" >';
    echo 'Mese:<input type="text" name="m_inizio" size="5" value="'. $giornata['inizio_a']['month'] .'" >';
    echo 'Anno:<input type="text" name="a_inizio" size="5" value="'. $giornata['inizio_a']['year'] .'">';
    echo 'Ore:<input type="text" name="h_inizio" size="5" value="'. $giornata['inizio_a']['hour'] .'">';
    echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $giornata['inizio_a']['minute'] .'"><br>';
    echo 'Fine: <br>';
    echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $giornata['fine_a']['day'] .'" >';
    echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $giornata['fine_a']['month'] .'" >';
    echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $giornata['fine_a']['year'] .'">';
    echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $giornata['fine_a']['hour'] .'">';
    echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $giornata['fine_a']['minute'] .'"><br>';
    echo '<input type="submit" value="Invia">';
    echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"].'" >Calcola Giornata</a>';
    echo '</form>';
    echo '</fieldset>';
    $counter++;
}
?>
