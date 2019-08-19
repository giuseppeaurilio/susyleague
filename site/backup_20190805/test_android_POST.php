<?php
include("dbinfo_susyleague.inc.php");
//echo $username;
$con=mysqli_connect($host,$username,$password,$database) or die( "Unable to select database");


$data = json_decode(file_get_contents('php://input'), true);
$pwd=$data["password"];

$id_squadra=$data["id_squadra"];


$myfile = fopen("./salvataggio.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);

fwrite($myfile, $a);
fclose($myfile);


$query="SELECT a.costo,a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc='" . $id_squadra ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";
//echo $query2;
$result_giocatori=mysqli_query($con,$query);
$rows = array();
while($r = mysqli_fetch_assoc($result_giocatori)) {
    $rows[] = $r;
}
echo json_encode($rows);


?>
