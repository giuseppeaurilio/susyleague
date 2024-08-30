<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone=6;
// echo "Connected successfully";
$queryclassifica='CALL getClassifica('.$idgirone.')';
// print_r($queryclassifica);
$result_girone = $conn->query($queryclassifica) or die($conn->error);
// print_r($result_girone);
$arraysquadre = array();
    //recupero i dati dal DB e li trasferisco nell'array di oggetti
while ($row = $result_girone->fetch_assoc()) {
    $temp = new RigaClassifica();
    // print_r($row );
    $temp->idSquadra = $row["idsquadra"];
    $temp->squadra = $row["squadra"];
    $temp->punti = $row["punti"];
    $temp->marcatori = $row["marcatori"];
    $temp->vittorie = $row["vittorie"];
    $temp->pareggi = $row["pareggi"];
    $temp->sconfitte = $row["sconfitte"];
    $temp->golfatti = $row["golfatti"];
    $temp->golsubiti = $row["golsubiti"];
    $temp->marcatoricasa = $row["marcatoric"];
    $temp->vittoriecasa = $row["vittoriec"];
    $temp->pareggicasa = $row["pareggic"];
    $temp->sconfittecasa = $row["sconfittec"];
    $temp->golfatticasa = $row["golfattic"];
    $temp->golsubiticasa = $row["golsubitic"];
    
    $temp->marcatoritrasf = $row["marcatorit"];
    $temp->vittorietrasf = $row["vittoriet"];
    $temp->pareggitrasf = $row["pareggit"];
    $temp->sconfittetrasf = $row["sconfittet"];
    $temp->golfattitrasf = $row["golfattit"];
    $temp->golsubititrasf = $row["golsubitit"];
    array_push($arraysquadre,$temp);
}
$conn->close();

// print("<pre>".print_r($arraysquadre,true)."</pre>").'<br>';
?>


<div id="tabs-4">
<?php 


usort($arraysquadre, "cmp");
?>

<h2>Classifica FINALE</h2>
<table >
<tr>
<th>Squadra</th>
<th>Punti</th>
</tr>

<?php 
foreach($arraysquadre as $squadra){
    echo '<tr>';
        echo '<td>'.$squadra->squadra.'</td>';
        echo '<td>'.$squadra->marcatori.'</td>';
       
    echo '</tr>';
}
?>
</table>
</div>