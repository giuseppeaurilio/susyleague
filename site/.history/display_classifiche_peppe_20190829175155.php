<?php
include "menu.php";

?>
<link href="style.css" rel="stylesheet" type="text/css">

<style>
body{
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
table{
	border-collapse: collapse;
	width: 100%;
}
table th, table td{
	border: 1px solid #ddd;
	padding: 8px;
	}
table tr:nth-child(even){
	background-color: #f2f2f2;
	}
table tr:hover {
	background-color: #ddd;
	}
table th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #4CAF50;
	color: white;
}
</style>
<?php
    class RigaClassifica{
        public $idSquadra;
        public $squadra;
        public $punti;
        public $marcatori;
        public $vittorie;
        public $pareggi;
        public $sconfitte;
        public $golfatti;
        public $golsubiti;
        public $marcatoricasa;
        public $vittoriecasa;
        public $pareggicasa;
        public $sconfittecasa;
        public $golfatticasa;
        public $golsubiticasa;
        public $marcatoritrasf;
        public $vittorietrasf;
        public $pareggitrasf;
        public $sconfittetrasf;
        public $golfattitrasf;
        public $golsubititrasf;
    }
?>


<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone=2;
// echo "Connected successfully";
$queryclassifica='CALL getCalendario('.$idgirone.')';
// print_r($queryclassifica);
$result_girone = $conn->multi_query($queryclassifica) or die($conn->error);;
print_r($result_girone);
$arraysquadre = array();
    //recupero i dati dal DB e li trasferisco nell'array di oggetti
while ($row = $result_girone->fetch_assoc()) {
    $temp = new RigaClassifica();
    print_r($row );
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
    array_push($arraysquadre,temp);
}
$conn->close();

print("<pre>".print_r($arraysquadre,true)."</pre>").'<br>';
?>
