<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

</style>




<h1>Amministazione Giornate</h2>


<?php

include("../dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$query="SELECT * FROM giornate order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$i=0;
while ($row=$result->fetch_assoc()) {



$id_giornata=$row["id_giornata"];
$inizio=$row["inizio"];
$fine=$row["fine"];
#var_dump($inizio);

$inizio_a=date_parse($inizio);
$fine_a=date_parse($fine);
#var_dump($inizio_a);
#echo "inizio= " . $inizio_a["year"];
?>

<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">

<label for="giornata">Giornata <?php echo $id_giornata; ?></label><br>
<input type="hidden" name="giornata" value="<?php echo $id_giornata; ?>">


Inizio: <br>
Giorno:<input type="text" name="g_inizio" size="5" value="<?php echo $inizio_a['day'] ?>" >
Mese:<input type="text" name="m_inizio" size="5" value="<?php echo $inizio_a['month'] ?>" >
Anno:<input type="text" name="a_inizio" size="5" value="<?php echo $inizio_a['year'] ?>">
Ore:<input type="text" name="h_inizio" size="5" value="<?php echo $inizio_a['hour'] ?>">
Minuti:<input type="text" name="min_inizio" size="5" value="<?php echo $inizio_a['minute'] ?>"><br>
Fine: <br>
Giorno:<input type="text" name="g_fine" size="5" value="<?php echo $fine_a['day'] ?>" >
Mese:<input type="text" name="m_fine" size="5" value="<?php echo $fine_a['month'] ?>" >
Anno:<input type="text" name="a_fine" size="5" value="<?php echo $fine_a['year'] ?>">
Ore:<input type="text" name="h_fine" size="5" value="<?php echo $fine_a['hour'] ?>">
Minuti:<input type="text" name="min_fine" size="5" value="<?php echo $fine_a['minute'] ?>"><br>
<input type="submit" value="Invia">
</form>
<a href="calcola_giornata.php?&id_giornata=<?php echo $id_giornata ?>" >Calcola Giornata</a>
<hr>

<?php
++$i;
}



?>
