<?php 
include("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



$nome=mysqli_real_escape_string($conn,$_GET["nome"]);
$id=$_GET["id"];
$sq_sa=$_GET["squadra_serie_a"];
$ruolo=$_GET["Ruolo"];

//echo "nome=" . $nome ."<br>";
//echo "id=" . $id ."<br>";
//echo "sq_sa=" . $sq_sa ."<br>";
//echo "ruolo=" . $ruolo ."<br>";
//$sommario_a=explode( '_', $sommario );

//$id_giocatore=$sommario_a[0];
//$id_sq_fc=$sommario_a[1];
$query="INSERT INTO `giocatori` (`id`, `ruolo`, `nome`, `id_squadra`) VALUES ('$id', '$ruolo', '$nome', '$sq_sa')";

//echo $query;
$result=$conn->query($query); 

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
