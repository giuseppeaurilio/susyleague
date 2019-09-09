<?php
include("menu.php");
?>
<h2>Calendario Coppa Italia</h2>


<?php

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
		echo '<h3>Girone A</h3>';    
		echo '<div class=" ">';
    }
    else if($counter == 15 ){
		echo '<h3>Girone B</h3>';    
		echo '<div class=" ">';
	}
	$commento ="";
    if($counter %3  == 0){
        // echo '<fieldset>';
        // echo '<legend>Giornata:'.($counter/3 > 5 ? $counter/3 - 4 : $counter/3 +1 ).'</legend>';
		echo '<div class="calendario_giornata coppaitalia ">';
		echo '<h3>Giornata:'.($counter/3 > 5 ? $counter/3 - 4 : $counter/3 +1 ).'</h3>';
		echo '<div class="scrollmenu">';
		echo '<table >';
			echo '<tr>';
				echo '<th class="data">Data</th>';
				echo '<th>Casa</th>';
				echo '<th>Ospite</th>';
				echo '<th>Gol</th>';
				echo '<th>Gol</th>';
				echo '<th>	Punti</th>';
				echo '<th>Punti</th>';
				echo '<th>&nbsp;</th>';
			echo '</tr>';
		$commento ="";
	}
	echo '<tr>';
		echo '<td > '. (($giornata['inizio_a']!= "") ? date('d/m H:i', strtotime($giornata['inizio_a'])) : "") .'  <br>  ' .(($giornata['fine_a']!= "") ? date('d/m H:i', strtotime($giornata['fine_a'])) : ""). '</td>';
		echo '<td>'.$giornata["sq1"].'</td>';
		echo '<td>'.$giornata["sq2"].'</td>';
		echo '<td>'.$giornata["gol_casa"].'</td>';
		echo '<td>'.$giornata["gol_ospiti"].'</td>';
		echo '<td>'.$giornata["punti_casa"].'</td>';
		echo '<td>'.$giornata["punti_ospiti"].'</td>';
		echo '<td><a href="display_giornata.php?&id_giornata='. $giornata["id_giornata"] .'" ><i class="fas fa-list-ol"></i></a></td>';
	echo '</tr>';
	$commento .= $commento;
	$counter++;
	if($counter %3  == 0){
		echo '</table >';
		echo '</div>';
		echo '</div>';
		echo '<div><textarea readonly rows="10" style="'.'">Il punto del presidente:
			'.$commento .'</textarea> </div>';
	}
	if($counter == 15 || $counter == 30){
		echo '</div>';
    }
    
    // if($counter %3  == 0){
    //     echo '</fieldset>';
	// }
	
}
?>

<?php 
include("footer.php");
?>