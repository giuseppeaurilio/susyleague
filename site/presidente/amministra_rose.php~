<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
div.fixed {
    position: fixed;
    top: 500px;
    left: 500px;
    width: 300px;
    border: 3px solid #8AC007;
}
.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
$(document).ready(function()
{
    $("tr[contenteditable=true]").blur(function()
    {
    	var dataString = '';
    	var message_status = $("#status");
	var str = $(this).attr("id");
	var arr = str.split("_");
	console.log("valore a=" + arr[0]);
	console.log("valore b=" + arr[1]);
	var id_squadra=arr[0];
	var id_posizione=arr[1];
 	//var id_squadra = $(this).find('td:eq(0)').text();
	//var id_posizione= $(this).find('td:eq(1)').text();
	var nome= $(this).find('td:eq(0)').text();
	var squadra= $(this).find('td:eq(1)').text();
	var ruolo=$(this).find('td:eq(2)').text(); // Task
	var costo=$(this).find('td:eq(3)').text();  // Task

	var dataString = '?&id_squadra='+ id_squadra +'&id_posizione=' +id_posizione +'&nome='+nome+'&squadra=' +squadra +'&ruolo='+ruolo+'&costo=' +costo;

	console.log(dataString);
	$.ajax(
		{
			type: "POST",
			url: "query_update_rose.php",
			data: dataString,
			cache: false,
			success: function(result)
			{

				message_status.show();
				message_status.text("Aggiornato");
				console.log(result);
				setTimeout(function(){message_status.hide();location.reload();},1000);
			
			}

		});


	});
});
	
</script>
<?
include("menu.html");

?>


<h2>Rose</h2>
<!-- <button class="pos_fixed" id="btnHousing" onclick="readTblValues();" >Aggiorna</button> -->
<div  class="fixed"  id="status"></div>

<?
include("../dbinfo_susyleague.inc.php");
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * FROM sq_fantacalcio";
$result=mysql_query($query);

$num=mysql_numrows($result); 



#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
#echo $query2;
$result_generale=mysql_query($query_generale);
$fantamilioni=mysql_result($result_generale,0,"valore");



$i=0;
while ($i < $num) 
{

$id_squadra=mysql_result($result,$i,"id");
$squadra=mysql_result($result,$i,"squadra");
$allenatore=mysql_result($result,$i,"allenatore");
$query2="SELECT * FROM rose where sq_fantacalcio_id=" . $id_squadra . " order by id_posizione";
#echo $query2;
$result_giocatori=mysql_query($query2);
$num_giocatori=mysql_numrows($result_giocatori);



?>

<h2><?echo "$squadra";?></h2>
<h3><?echo "(" .$allenatore .")";?></h3>

<table border="0" cellspacing="2" cellpadding="2">
<tr> 
<!-- <th><font face="Arial, Helvetica, sans-serif">Id squadra</font></th> -->
<!-- <th><font face="Arial, Helvetica, sans-serif">Id giocatore</font></th> -->
<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
<th><font face="Arial, Helvetica, sans-serif">Costo</font></th>
</tr>
<?

$j=0;
$spesi=0;
while ($j < 29) {

	$nome_giocatore="";
	$squadra_giocatore="";
	$ruolo_giocatore="";
	$costo_giocatore=0;
	$spesi = $spesi+ $costo_giocatore;

	$k=0;
while ($k < $num_giocatori) {

	$id_giocatore=mysql_result($result_giocatori,$k,"id_posizione");
	if ($id_giocatore==$j+1) {
	
	$nome_giocatore=mysql_result($result_giocatori,$k,"nome");
	$squadra_giocatore=mysql_result($result_giocatori,$k,"squadra");
	$ruolo_giocatore=mysql_result($result_giocatori,$k,"ruolo");
	$costo_giocatore=mysql_result($result_giocatori,$k,"costo");
	$spesi = $spesi+ $costo_giocatore;
	}
	++$k;
	}

?>


<tr contenteditable='true' id=<? echo $id_squadra  . "_" . ($j+1);?> bgcolor= <?switch ($ruolo_giocatore) {
    case "P":
        echo "#66CC33";
        break;
    case "D":
        echo "#33CCCC";
        break;
    case "C":
        echo "#CC0066";
        break;
     case "A":
        echo "#E80000 ";
        break;
    default:
        echo "#FFFFFF";
}
?>

>
<td><font face="Arial, Helvetica, sans-serif" ><? echo "$nome_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif" ><? echo "$squadra_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif" ><? echo "$ruolo_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif" ><? echo "$costo_giocatore"; ?></font></td>

</tr>
<?
++$j;
}
?>

</table>


<form action="" class="a-form">
<label for="modulo"> Fantamilioni spesi= </label>
<label id="spesi" > <? echo $spesi; ?> </label><br>
<label for="restanti" >Fantamilioni restanti= </label>
<label id="restanti" >  <? echo $fantamilioni-$spesi; ?></label><br>
</form>

<?

++$i;
} 

mysql_close();

?>
<?
include("footer.html");

?>

</body>
</html>
