<?php
include("menu.php");
?>

<h1>Calendario Coppa Italia</h2>


<?php

include("dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$query= "SELECT giornate.*, 
calendario.id_sq_casa, sq1.squadra as squadracasa,
calendario.id_sq_ospite,  sq2.squadra as squadraospite ,
calendario.gol_casa,
calendario.gol_ospiti,
calendario.punti_casa,
calendario.punti_ospiti


FROM `giornate` 
left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
WHERE id_girone = 4 order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$giornate = array();
while ($row=$result->fetch_assoc()) {
    $id_giornata=$row["id_giornata"];
    $inizio=$row["inizio"];
    $fine=$row["fine"];
    $id_sq1=$row["id_sq_casa"];
    $sq1=$row["squadracasa"];
    $id_sq2=$row["id_sq_ospite"];
	$sq2=$row["squadraospite"];
	$gol_casa=$row["gol_casa"];
	$gol_ospiti=$row["gol_ospiti"];
	$punti_casa=$row["punti_casa"];
	$punti_ospiti=$row["punti_ospiti"];
    // $inizio_a=date_parse($inizio);
    // $fine_a=date_parse($fine);
    array_push($giornate, array(
        "id_giornata"=>$id_giornata,
        "inizio_a"=>$inizio,
        "fine_a"=>$fine,
        "id_sq1"=>$id_sq1,
        "sq1"=>$sq1,
        "id_sq2"=>$id_sq2,
		"sq2"=>$sq2,
		"gol_casa"=>$gol_casa,
		"gol_ospiti"=>$gol_ospiti,
		"punti_casa"=>$punti_casa,
		"punti_ospiti"=>$punti_ospiti,
        )
    );
}
$counter = 0;

foreach($giornate as $giornata){
	// print_r ($giornata);
    if($counter == 0 ){
        echo '<h1>Girone A</h1>';    
    }
    else if($counter == 15 ){
        echo '<h1>Girone B</h1>';    
    }
    if($counter %3  == 0){
        // echo '<fieldset>';
        // echo '<legend>Giornata:'.($counter/3 > 5 ? $counter/3 - 4 : $counter/3 +1 ).'</legend>';
    
	echo '<h3>Giornata:'.($counter/3 > 5 ? $counter/3 - 4 : $counter/3 +1 ).'<h3>';
		echo '<table >';
			echo '<tr>';
				echo '<th>Data</th>';
				echo '<th>Casa</th>';
				echo '<th>Ospite</th>';
				echo '<th>Gol</th>';
				echo '<th>Gol</th>';
				echo '<th>	Punti</th>';
				echo '<th>Punti</th>';
				echo '<th<Dettaglio</th>';
			echo '</tr>';
	}
	echo '<tr>';
		echo '<td>'.$giornata['inizio_a'].'->'.$giornata['fine_a'].' </td>';
		echo '<td>'.$giornata["sq1"].'</td>';
		echo '<td>'.$giornata["sq2"].'</td>';
		echo '<td>'.$giornata["gol_casa"].'</td>';
		echo '<td>'.$giornata["gol_ospiti"].'</td>';
		echo '<td>'.$giornata["punti_casa"].'</td>';
		echo '<td>'.$giornata["punti_ospiti"].'</td>';
		echo '<td><a href="display_giornata.php?&id_giornata='. $giornata["id_giornata"] .'" >Dettaglio</a></td>';
	echo '</tr>';
    // // echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
    // echo '<label for="giornata">'.$giornata["sq1"].'-'.$giornata["sq2"].'(ID:'.$giornata["id_giornata"].') </label>';
    // // echo '<a href="calcola_giornata.php?&id_giornata='. $giornata["id_giornata"] .'" >Calcola Giornata</a>';
    // echo '<br>';
    // echo '<input type="hidden" name="giornata" value="'.$giornata["id_giornata"].'">';
    // echo 'Inizio: <br>';
    // echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $giornata['inizio_a']['day'] .'" >';
    // echo 'Mese:<input type="text" name="m_inizio" size="5" value="'. $giornata['inizio_a']['month'] .'" >';
    // echo 'Anno:<input type="text" name="a_inizio" size="5" value="'. $giornata['inizio_a']['year'] .'">';
    // echo 'Ore:<input type="text" name="h_inizio" size="5" value="'. $giornata['inizio_a']['hour'] .'">';
    // echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $giornata['inizio_a']['minute'] .'"><br>';
    // echo 'Fine: <br>';
    // echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $giornata['fine_a']['day'] .'" >';
    // echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $giornata['fine_a']['month'] .'" >';
    // echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $giornata['fine_a']['year'] .'">';
    // echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $giornata['fine_a']['hour'] .'">';
    // echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $giornata['fine_a']['minute'] .'"><br>';
    // echo '<input type="submit" value="Invia">';
    // echo '</form>';
	
	$counter++;
	if($counter %3  == 0){
		echo '</table >';
	}
    // if($counter %3  == 0){
    //     echo '</fieldset>';
	// }
	
}
?>
