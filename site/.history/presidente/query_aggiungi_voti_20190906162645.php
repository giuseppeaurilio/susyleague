<?php 

$id_squadra=$_GET['id_squadra'];
$id_giornata=$_GET['id_giornata'];
$giocatori=$_GET['giocatori'];
include("../dbinfo_susyleague.inc.php");

// $link = mysql_connect(localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `nome`, `squadra`, `ruolo`, `voto`, `voto_md`) VALUES (" . $id_giornata .",". $id_squadra . "," ;

if(isset($giocatori) && trim($giocatori) !== '')
{
    $giocatori_line_array=explode("," , $giocatori);
    $i=1;
    #echo "<br> array=";
    // print_r($giocatori_line_array);
    foreach ($giocatori_line_array as $giocatore_line) {
        $giocatore=explode("_" , $giocatore_line);
        #echo "dati array=";
        // print_r($giocatore);
        $query = "UPDATE `formazioni` 
                SET `sostituzione`=".$giocatore[3].",
                `voto`=".$giocatore[1].",
                `voto_md`=".($giocatore[2] == '' ? "null" : $giocatore[2])." 
                WHERE id_giornata = ".$id_giornata."
                and id_posizione = ".$giocatore[0]." 
                and id_squadra =".$id_squadra.";";
        echo $query;
        // $result = $conn->query($query);
        
    }// end giocatori
}
?>
