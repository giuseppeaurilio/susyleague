<?php
if(isset($_POST["sq_sa"]) && !empty($_POST["sq_sa"]) && isset($_POST["ruolo"]) && !empty($_POST["ruolo"]) ){
	$ruolo=$_POST["ruolo"];
	$sq_id=$_POST["sq_sa"];


	include("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

    // $query="SELECT * FROM giocatori  where giocatori.ruolo='". $ruolo . "' and giocatori.id_squadra=".$sq_id;
    // $query="SELECT * FROM giocatori as a where a.ruolo='". $ruolo . "' and a.id_squadra=".$sq_id ."  and a.id NOT IN (SELECT id_giocatore FROM rose)";
    $query = "SELECT * 
    FROM giocatori as g
    left join `rose` as r on g.id = r.id_giocatore
    where g.ruolo='$ruolo' and g.id_squadra=$sq_id
    and (r.id_sq_fc is null
        OR r.id_sq_fc = 0)";

    //$query="SELECT * FROM giocatori as a  natural left join rose as b where giocatori.ruolo='". $ruolo . "' and giocatori.id_squadra=".$sq_id ." and b.id_giocatore=NULL";

    $result=$conn->query($query);
    $num=$result->num_rows; 
    echo '<option value="">--Seleziona Giocatore--</option>';
    // echo '<option value="">' . $query . '</option>';  
$i=0;
while ($row=$result->fetch_assoc()) {
	$id=$row["id"];
    $giocatore=$row["nome"];
	  echo '<option value=' . $id . '>'. $giocatore . '</option>';
	++$i;
}

};
?>
