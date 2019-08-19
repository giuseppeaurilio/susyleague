<?php 

include("menu.php");
include("../dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



$id_giocatore=$_GET['id_giocatore'];
//echo "pippo";
//echo $id_giocatore;

$query="SELECT a.*, b.squadra FROM giocatori as a inner join squadre_serie_a as b where a.id=$id_giocatore and a.id_squadra=b.id;";
//echo $query;
$result=$conn->query($query);

$num=$result->num_rows; 
if ($num=1) {
	$row=$result->fetch_assoc();
	$provenienza=$row["squadra"];
	$nome=$row["nome"];
	$ruolo=$row["ruolo"];
	echo $nome;



?>
<form action="query_cambia_squadra.php">
  id: <input type="text" name="id_giocatore" value= <?php echo $id_giocatore; ?> readonly><br>
  nome: <input type="text" name="nome" value= "<?php echo $nome; ?>" readonly><br>
  ruolo: <input type="text" name="ruolo" value= <?php echo $ruolo; ?> readonly><br>
provenienza:	<input type="text" name="provenienza" value= <?php echo $provenienza; ?> readonly><br>


<p>Passa alla squadra</p>

<select name="squadra_serie_a" id="sq_sa">


<?php
$query_sa="SELECT * FROM squadre_serie_a order by squadra";
$result_sa=$conn->query($query_sa);

$num_sa=$result_sa->num_rows; 
$i=0;

while ($row=$result_sa->fetch_assoc()) {
	$id=$row["id"];
	$squadra=$row["squadra"];
	echo '<option value=' . $id . '>'. $squadra . '</option>';
	++$i;
}




}
?>

<input type="submit" id="submit" value="Cambia">
</form> 

