<?php
if(isset($_POST["sq_sa"]) && !empty($_POST["sq_sa"]) && isset($_POST["ruolo"]) && !empty($_POST["ruolo"]) ){
	$ruolo=$_POST["ruolo"];
	$sq_id=$_POST["sq_sa"];


	include("../dbinfo_susyleague.inc.php");

	mysql_connect($localhost,$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
    $query="SELECT * FROM giocatori  where giocatori.ruolo='". $ruolo . "' and giocatori.id_squadra=".$sq_id;
     $query="SELECT * FROM giocatori as a where a.ruolo='". $ruolo . "' and a.id_squadra=".$sq_id ."  and a.id NOT IN (SELECT id_giocatore FROM rose)";

     //$query="SELECT * FROM giocatori as a  natural left join rose as b where giocatori.ruolo='". $ruolo . "' and giocatori.id_squadra=".$sq_id ." and b.id_giocatore=NULL";

    $result=mysql_query($query);
    $num=mysql_numrows($result); 
    echo '<option value="">--Seleziona Giocatore--</option>';
    // echo '<option value="">' . $query . '</option>';  
$i=0;
while ($i < $num) {
	$id=mysql_result($result,$i,"id");
    $giocatore=mysql_result($result,$i,"nome");
	  echo '<option value=' . $id . '>'. $giocatore . '</option>';
	++$i;
}

};
?>
