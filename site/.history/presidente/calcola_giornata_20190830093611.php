<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.inlineTable {
            display: inline-block;
        }

.caption_style {font-size:30px}

.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

</style>




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


$id_giornata=$_GET['id_giornata'];

?>





<script>
	
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

$(document).ready(function(){
	$("#btn_invia").click(function(){
 	
	var id_giornata="<?php echo $id_giornata; ?>";

 	var titolari = [];
 	var panchina = [];
	for (i=1; i<13; i++){ //i scorre le squadre
 	var dataString = 'id_squadra='+ i + '&id_giornata=' + id_giornata + '&giocatori=';
		//console.log("datastring= " + dataString);
 		for (j = 1; j < 20; j++) { //j scorre i giocatori
		var test = $("#row_"+ i + "_" + j);
		var nome=test.find('td:eq(0)').text();
		var squadra=test.find('td:eq(1)').text();
		var ruolo=test.find('td:eq(2)').text();
		var voto=test.find('td:eq(3)').text();
		var voto_md=test.find('td:eq(4)').text();
		//console.log(i + "_" + j + "-" + nome + "_" + squadra + "_" + ruolo + "_" + voto + "_" + voto_md)
		if (isNumeric(voto) || isNumeric(voto_md)) {
			dataString += j + "_" + voto + "_" + voto_md + ",";
		}
		}//end j
		dataString = dataString.substring(0, dataString.length - 1);
		console.log("datastring= " + dataString);
		$.ajax(
		{
			type: "GET",
			url: "query_aggiungi_voti.php",
			data: dataString,
			cache: false,
			success: function(result)
			{

				//message_status.show();
				//message_status.text("Aggiornato");
				console.log("risultato query= " + result);
				setTimeout(function(){location.reload();},3000);
			
			}

		});

		}//end i









	}) //end function $("#btn_invia").click
	$("#btn_commento").click(function(){
		var id_giornata="<?php echo $id_giornata; ?>";
		var commento = $('#txt_commento').val();
		$.ajax({
        	url: "invia_commento.php",
        	type:"GET",
        	data:
        	{
            		id_giornata: id_giornata,
            		commento: commento
        	},
        	success: function(msg)
        	{
            		alert('commento inviato');
        	}
        	}); //end $.ajax
	})//end function $("#btn_commento").click
})
</script>





<h1> Calcolo Giornata <?php echo $id_giornata ;?> </h1>
<div data-role="main" class="ui-content">

<?php


$query2="SELECT a.id_sq_casa as id_casa, a.id_sq_ospite as id_ospite, b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id_giornata ." order by a.id_partita" ;

$result_giornata=$conn->query($query2);
$num_giornata=$result_giornata->num_rows;
$j=0;
while ($row=$result_giornata->fetch_assoc()) {
	$id_casa=$row["id_casa"];
	$id_ospite=$row["id_ospite"];
	$punti_casa=$row["punti_casa"];
	$gol_casa=$row["gol_casa"];
	$sq_casa=$row["sq_casa"];
	$sq_ospite=$row["sq_ospite"];
	$gol_ospite=$row["gol_ospiti"];
	$punti_ospite=$row["punti_ospiti"];


	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_casa ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";
	#echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
	 <div class="ui-grid-a">
		<div class="ui-block-a">
	<table border=1  id="squadra_casa<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_casa; ?></caption>
	<th><font face="Arial, Helvetica, sans-serif"> </font></th>
	<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto MD</font></th>
	<th>&nbsp;</th>
	<?php
	while ($row=$result_formazione->fetch_assoc()) {
	$ruolo_giocatore=$row["ruolo"];
	?>
        <tr contenteditable='true' id=row_<?php  echo $id_casa  . "_" . ($i+1);?> bgcolor= <?php switch ($ruolo_giocatore) {
    case "P":
        echo "#66CC33";
        break;
    case "D":
        echo "#33CCCC";
        break;
    case "C":
        echo "#FFEF00";
        break;
     case "A":
        echo "#E80000 ";
        break;
    default:
        echo "#FFFFFF";
}
?>
>
	<?php if ($i==0) {echo 	"<th bgcolor='#FFFFFF' rowspan='11'>Titolari</th>";  } ?>
	<?php if ($i==11) {echo "<th bgcolor='#FFFFFF' rowspan='8'>Riserve</th>";  } ?>
		<td><?php echo $row["nome"]; ?></td>
		<td><?php echo $row["squadra_breve"]; ?></td>
		<td><?php echo $row["ruolo"]; ?></td>
		<td><?php echo $row["voto"]; ?></td>
		<td><?php echo $row["voto_md"]; ?></td>
		<td>
			<?php  
			if ($i<11) 
			{echo "&nbsp;";}
			else{
			    echo	"<input type='checkbox' ".$row["sostituzione"]? "checked": "" .";>";
			}
					?>
		</td>
		
        </tr>
        <?php
        ++$i;
	}#end giocatori casa
	?>
	
	</table>




	<?php
	$query_risultati="Select * from punteggio_finale where id_giornata='" . $id_giornata . "' and id_casa= '". $id_casa ."'";
	#echo "query= " . $query_risultati;
	$risultati=$conn->query($query_risultati);
	
	$num_risultati=$risultati->num_rows;
	
	$addizionale="";
	$voto_netto="";
	$media_difesa="";
	$voto_totale="";
	$gol="";
	$numero_giocanti="";	
	
	if ($num_risultati>0) {	
		$row=$risultati->fetch_assoc();
		$addizionale=$row["addizionale"];
		$voto_netto=$row["voto_casa"];
		$media_difesa=$row["mv_casa"];
		$voto_totale=$row["tot_casa"];
		$gol=$row["gol_casa"];
		$numero_giocanti=$row["numero_giocanti_casa"];	
	}

	$query_risultati="Select * from punteggio_finale where id_giornata='" . $id_giornata . "' and id_ospite= '". $id_ospite ."'";
	#echo "query= " . $query_risultati;
	$risultati=$conn->query($query_risultati);
	$num_risultati=$risultati->num_rows;
	
	$voto_netto_ospite="";
	$media_difesa_ospite="";
	$voto_totale_ospite="";
	$gol_ospite="";
	$numero_giocanti_ospite="";
	
	if ($num_risultati>0) {	
		$row=$risultati->fetch_assoc();
		$voto_netto_ospite=$row["voto_ospite"];
		$media_difesa_ospite=$row["mv_ospite"];
		$voto_totale_ospite=$row["tot_ospite"];
		$gol_ospite=$row["gol_ospite"];
		$numero_giocanti_ospite=$row["numero_giocanti_ospite"];
	}

	?>
	<p> addizionale = <?php echo $addizionale; ?> </p>
	<p> giocatori con  voto = <?php echo $numero_giocanti; ?> </p>
	<p> voto netto = <?php echo $voto_netto; ?> </p>
	<p> media difesa = <?php echo $media_difesa_ospite; ?> </p>
	<p> voto totale = <?php echo $voto_totale; ?> </p>
	<p> gol = <?php echo $gol; ?> </p>
<a href="invio_formazione_squadra.php?&id_giornata=<?php  echo $id_giornata; ?>&id_squadra=<?php  echo $id_casa; ?>">Invia Formazione</a>
		</div>
	<?php
	$query_formazione="Select * from formazioni where id_giornata='" . $id_giornata . "' and id_squadra= '". $id_ospite ."'";
	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_ospite ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";

	#echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
		<div class="ui-block-b">
	<table border=1  id="squadra_ospite<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_ospite; ?></caption>

	<th><font face="Arial, Helvetica, sans-serif"> </font></th>
	<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto MD</font></th>

	<?php
	while ($row=$result_formazione->fetch_assoc()) {
		$ruolo_giocatore=$row["ruolo"];
	?>
        <tr contenteditable='true' id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> bgcolor= <?php switch ($ruolo_giocatore) {
    case "P":
        echo "#66CC33";
        break;
    case "D":
        echo "#33CCCC";
        break;
    case "C":
        echo "#FFEF00";
        break;
     case "A":
        echo "#E80000 ";
        break;
    default:
        echo "#FFFFFF";
}
?>
>
	<?php if ($i==0) {echo 	"<th bgcolor='#FFFFFF' rowspan='11'>Titolari</th>";  } ?>
	<?php if ($i==11) {echo "<th bgcolor='#FFFFFF' rowspan='8'>Riserve</th>";  } ?>
            	<td><?php echo $row["nome"]; ?></td>
            	<td><?php echo $row["squadra_breve"]; ?></td>
            	<td><?php echo $row["ruolo"]; ?></td>
             	<td><?php echo $row["voto"]; ?></td>
				<td><?php echo $row["voto_md"]; ?></td>
		
        </tr>
        <?php
        ++$i;
	}#end giocatori ospiti
	?>
	</table>
	<p> addizionale = 0 </p>
	<p> giocatori con  voto = <?php echo $numero_giocanti_ospite; ?> </p>
	<p> voto netto = <?php echo $voto_netto_ospite; ?> </p>
	<p> media difesa = <?php echo $media_difesa; ?> </p>
	<p> voto totale = <?php echo $voto_totale_ospite; ?> </p>
	<p> gol = <?php echo $gol_ospite; ?> </p>

 	<a href="invio_formazione_squadra.php?&id_giornata=<?php  echo $id_giornata; ?>&id_squadra=<?php  echo $id_ospite; ?>">Invia Formazione</a> 

		</div>

	</div>
	<hr>
	<?php
	
++$j;



} # end incontri
?>
</div>


<button type="button" id="btn_invia">Invia Voti</button>

<?php
$query="select * from giornate where id_giornata=". $id_giornata;
#echo $query;
$result_commento=$conn->query($query);
#$num_commento=mysql_numrows($result_commento);
$commento=$result_commento->fetch_assoc()["commento"];

?>


<p>  Il commento del presidente: <br> </p>
  <textarea name="commento" rows="10" cols="30" id="txt_commento"> <?php echo $commento ?></textarea>
  <br><br>
<button type="button" id="btn_commento"> Invia commento </button>

<h2> Messaggi Telegram</h2>

 <form action="send_message_giornata.php" method="post">

<input type="checkbox" name="calcolo" value='1' /> Calcolo fatto</br>
<input type="checkbox" name="risultati" value='1' /> Risultati</br>
<input type="checkbox" name="classifiche" value='1' /> Classifica</br>
<input type="checkbox" name="commento" value='1' /> Commento</br>
<input type="hidden" name="id_giornata" value=<?php echo $id_giornata;?> />
 <input type="submit" value="Submit">
</form> 





</html>
