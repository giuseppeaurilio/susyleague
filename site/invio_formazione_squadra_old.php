<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.myButton {
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
    -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;

  font-family: Arial;
  color: #000000;
  font-size: 20px;
  background-color: #8dc2eb;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
  width: 150px;
}

.myButton:hover {
  background-color: #8dc2eb;
  text-decoration: none;
}

</style>

<script>

var pconto = [0, 0, 0, 0];
var modulo = [0, 0, 0, 0];
function btnColor(btn){
    var property=document.getElementById(btn);
	console.log(property.style.backgroundColor);
	var a = btn.split("_");
	var ruolo=parseInt(a[1]) ;
	switch(property.style.backgroundColor) {
	case "rgb(0, 255, 0)"://da titolare a panchina
		property.style.backgroundColor = "rgb(255, 0, 0)";
		pconto[ruolo]= pconto[ruolo]+1;
		modulo[ruolo]=modulo[ruolo]-1;
		property.innerText  = property.innerText + "*P" + pconto[ruolo];
		break;
	case "rgb(255, 0, 0)"://da panchina a tribuna
		property.style.backgroundColor = "rgb(141, 194, 235)";
		pconto[ruolo]= pconto[ruolo]-1;
		var b = property.innerText.split("*");
		property.innerText  = b[0];
		break;	
	default: //da tribuna a titolare
		property.style.backgroundColor = "rgb(0, 255, 0)";
		modulo[ruolo]=modulo[ruolo]+1;
		break;
	}
}
</script>

<?
include("menu.html");
$id_giornata=$_GET['id_giornata'];
$id_squadra=$_GET['id_squadra'];

$ruoli = array("P","D","C","A");
$ruoli_name = array("Portieri","Difensori","Centrocampisti","Attaccanti");

include("dbinfo_susyleague.inc.php");

include("dbinfo_susyleague.inc.php");
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$i=0;

$query="SELECT squadra, allenatore FROM sq_fantacalcio where id=" . $id_squadra;
$result=mysql_query($query);


$squadra=mysql_result($result,$i,"squadra");
$allenatore=mysql_result($result,$i,"allenatore");
?>

<h2>Invio fomazione</h2>
<h2><?echo $squadra . "(" .$allenatore .")";?></h2>
<!-- <h3><?echo "(" .$allenatore .")";?></h3> -->

<?
for($i = 0; $i < 4; $i++) {

	$query2="SELECT * FROM rose where sq_fantacalcio_id=" . $id_squadra . " AND ruolo = '" . $ruoli[$i] ."'";
	#echo $query2;
	$result_giocatori=mysql_query($query2);
	$num_giocatori=mysql_numrows($result_giocatori);
	#echo $num_giocatori;
	#echo $i;
	?>
	
	<div >
	<h2><?echo $ruoli_name[$i];?></h2>
	<?

	$j=0;
		while ($j < $num_giocatori) {
		$id_giocatore=mysql_result($result_giocatori,$j,"id_posizione");
		$nome_giocatore=mysql_result($result_giocatori,$j,"nome");
		$squadra_giocatore=mysql_result($result_giocatori,$j,"squadra");
		$ruolo_giocatore=mysql_result($result_giocatori,$j,"ruolo");
		$costo_giocatore=mysql_result($result_giocatori,$j,"costo");

	?>
		<button id="btn_<? echo $i . "_" . $id_giocatore; ?>" type="button" class="myButton" onclick="btnColor('btn_<? echo $i . "_" .$id_giocatore; ?>');"><?echo $nome_giocatore . "<br /> (" .$squadra_giocatore . ")";?></button>

	<?
	++$j;

	} 
	?>
	</div>
	<?
}
mysql_close();
?>



<?
include("footer.html");

?>

</body>
</html>