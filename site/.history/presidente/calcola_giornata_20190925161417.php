<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php
include("menu.php");
$id_giornata=$_GET['id_giornata'];
$id_girone=$_GET['id_girone'];
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
			var nome=test.find('td:eq(1)').text();
			var squadra=test.find('td:eq(2)').text();
			var ruolo=test.find('td:eq(3)').text();
			var voto=test.find('.voto').text();
			var voto_md=test.find('.votomd').text();
			var sostituzione=test.find('.sostituzione').find('input:checkbox').prop("checked")? "1": "0";
			// console.log(nome + "_" + j + "_" + voto + "_" + voto_md + "_" + sostituzione);
			if (isNumeric(voto) || isNumeric(voto_md)) {
				dataString += j + "_" + voto + "_" + voto_md + "_" + sostituzione + ",";
			}
			else
			{
				dataString += j + "_" + "_" +  "_" + 0 + ",";
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

				// message_status.show();
				// message_status.text("Aggiornato");
				// console.log("risultato query= " + result);
				// operationSuccess();
				setTimeout(function(){location.reload(true);},10);
				// location.reload(true);
			
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

	$("#btn_calcola").click(function(){
		var id_giornata="<?php echo $id_giornata; ?>";
		var id_girone="<?php echo $id_girone; ?>";
		$.ajax({
        	url: "partita_c_calcolarisultato.php" + "?idgiornata=" + id_giornata +"&idgirone=" + id_girone,
			type:"GET",
        	success: function(msg)
        	{
				setTimeout(function(){location.reload();},10);
        	}
        	}); //end $.ajax
	})//end function $("#btn_commento").click
})
</script>

<h1> Calcolo Giornata <?php echo $id_giornata ;?> </h1>

<form action="upload_voti.php?idgiornata=<?php echo $id_giornata ;?>" method="post" enctype="multipart/form-data">
<section>
	<h1>Istruzioni</h1>
	Importare un fils CSV. <br>
	Il separatore di valori deve essere il carattere ";" (punto e virgole). <br>
	il separatore di decimali deve essere il carattere "," (virgola).
</section>
    Selziona File da inserire:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" name="submit">
</form>
<div data-role="main" class="ui-content">

<?php


// $query2="SELECT a.id_sq_casa as id_casa, 
// a.id_sq_ospite as id_ospite, 
// b.squadra as sq_casa, 
// c.squadra as sq_ospite, 
// a.gol_casa, a.gol_ospiti, 
// a.punti_casa, a.punti_ospiti 
$query2="Select *, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone
FROM calendario as a 
left join sq_fantacalcio as b on a.id_sq_casa=b.id 
left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
left join giornate as g on g.id_giornata=a.id_giornata 
where a.id_giornata=".$id_giornata ." order by a.id_partita" ;

	// $query_risultati="Select *, sum(punti_casa + md_casa + fattorecasa) as tot_casa from calendario 
	// where id_giornata='" . $id_giornata . "' and id_sq_casa= '". $id_casa ."'";
$idgirone = 0;
$result_giornata=$conn->query($query2);
$num_giornata=$result_giornata->num_rows;
$j=0;
while ($row=$result_giornata->fetch_assoc()) {

	$idgirone=$row["id_girone"];

	$id_casa=$row["id_sq_casa"];
	$id_ospite=$row["id_sq_ospite"];
	$sq_casa=$row["sq_casa"];
	$sq_ospite=$row["sq_ospite"];
	
	$addizionalecasa = $row["fattorecasa"];
	$numero_giocanti_casa = $row["numero_giocanti_casa"];
	$voto_netto_casa = $row["punti_casa"];
	$media_difesa_avversaria_casa = $row["md_casa"];
	$voto_totale_casa = $voto_netto_casa + $media_difesa_avversaria_casa + $addizionalecasa;//$row["tot_casa"];
	$gol_casa = $row["gol_casa"];

	$numero_giocanti_ospite  = $row["numero_giocanti_ospite"];
	$voto_netto_ospite = $row["punti_ospiti"];
	$media_difesa_avversaria_ospite = $row["md_ospite"];
	$voto_totale_ospite = $voto_netto_ospite + $media_difesa_avversaria_ospite;//$row["tot_ospite"];
	$gol_ospite = $row["gol_ospiti"];

	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione 
	FROM formazioni as a 
	left join giocatori as b on  a.id_giocatore=b.id 
	left join squadre_serie_a as c on a.id_squadra_sa=c.id
	where a.id_giornata=" . $id_giornata . "
	and a.id_squadra= ". $id_casa ; 

	
	// echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	// print_r($result);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
	 <div class="ui-grid-a">
		<div class="ui-block-a">
	<table border=1  id="squadra_casa<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_casa; ?></caption>
	<th style='background-color: white;' >&nbsp;</th>
	<th width="50%" >Nome</th>
	<th width="10%">&nbsp;</th>
	<th width="10%">R</th>
	<th width="10%">V</th>
	<th width="10%">VN</th>
	<th>&nbsp;</th>
	<?php
	while ($row=$result_formazione->fetch_assoc()) {
	$ruolo_giocatore=$row["ruolo"];
	?>
        <tr contenteditable='true' id=row_<?php  echo $id_casa  . "_" . ($i+1);?> style="background-color: <?php switch ($ruolo_giocatore) {
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
">
	<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: white;'><div class='rotate' style='width: auto;'> Titolari</div></td>";  } ?>
	<?php if ($i==11) {echo "<td rowspan='8' style='background-color: white;'><div class='rotate' style='width: auto;'> Riserve </div></td>";  } ?>
		<td><?php echo $row["nome"]; ?></td>
		<td><?php echo $row["squadra_breve"]; ?></td>
		<td><?php echo $row["ruolo"]; ?></td>
		<td class="voto"><?php echo $row["voto"]; ?></td>
		<td class="votomd"><?php echo $row["voto_md"]; ?></td>
		<td class="sostituzione">
			<?php  
			if ($i<11) 
			{echo "&nbsp;";}
			else{
				$s = $row["sostituzione"] == 1 ? "checked='chacked'": "";
				echo	"<input type='checkbox' ".$s."></input>";
				// ".$row["sostituzione"]? "checked": "" .";

				// checked='checked'
			}
			?>
		</td>
		
        </tr>
        <?php
        ++$i;
	}#end giocatori casa
	?>
	
	</table>
	<p> addizionale = <?php echo $addizionalecasa; ?> </p>
	<p> giocatori con  voto = <?php echo $numero_giocanti_casa; ?> </p>
	<p> voto netto = <?php echo $voto_netto_casa; ?> </p>
	<p> media difesa = <?php echo $media_difesa_avversaria_casa; ?> </p>
	<p> voto totale = <?php echo $voto_totale_casa; ?> </p>
	<p> gol = <?php echo $gol_casa; ?> </p>
	<a href="invio_formazione_squadra.php?&id_giornata=<?php  echo $id_giornata; ?>&id_squadra=<?php  echo $id_casa; ?>">Invia Formazione</a>
		</div>
	<?php
	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione 
	FROM formazioni as a 
	left join giocatori as b on  a.id_giocatore=b.id 
	left join squadre_serie_a as c on a.id_squadra_sa=c.id
	where a.id_giornata=" . $id_giornata . "
	and a.id_squadra= ". $id_ospite ; 

	#echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
		<div class="ui-block-b">
	<table border=1  id="squadra_ospite<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_ospite; ?></caption>

	<th style='background-color: white;' >&nbsp;</th>
	<th width="50%" >Nome</th>
	<th width="10%">&nbsp;</th>
	<th width="10%">R</th>
	<th width="10%">V</th>
	<th width="10%">VN</th>
	<th>&nbsp;</th>

	<?php
	while ($row=$result_formazione->fetch_assoc()) {
		$ruolo_giocatore=$row["ruolo"];
	?>
		<tr contenteditable='true' id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> style="background-color: <?php 
		switch ($ruolo_giocatore) {
	case "P":
		if($i<11)
			echo "rgba(102, 204, 51, 1)";
		else
			echo "rgba(102, 204, 51, 0.5)";
		break;
	case "D":
		if($i<11)
			echo "rgba(51, 204, 204, 1)";
		else
			echo "rgba(51, 204, 204, 0.5)";
		break;
    case "C":
		if($i<11)
			echo "rgba(255, 239, 0, 1)";
		else
			echo "rgba(255, 239, 0, 0.5)";
		break;
	 case "A":
		 if($i<11)
			echo "rgba(232, 0, 0, 1)";
		else
			echo "rgba(232, 0, 0, 0.5)";
		break;
    default:
        echo "#FFFFFF";
}
?>
">
	<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(102,204,51,0.2);'><div class='rotate'style='width: auto;'> Titolari</div></td>";  } ?>
	<?php if ($i==11) {echo "<td rowspan='8' style='background-color: rgba(255,51,0,0.2);'><div class='rotate' style='width: auto;'> Riserve </div></td>";  } ?>
			<td><?php echo $row["nome"]; ?></td>
			<td><?php echo $row["squadra_breve"]; ?></td>
			<td><?php echo $row["ruolo"]; ?></td>
			<td class="voto"><?php echo $row["voto"]; ?></td>
			<td class="votomd"><?php echo $row["voto_md"]; ?></td>
			<td class="sostituzione">
				<?php  
				if ($i<11) 
				{echo "&nbsp;";}
				else{
					$s = $row["sostituzione"] == 1 ? "checked='chacked'": "";
					echo	"<input type='checkbox' ".$s."></input>";
					// ".$row["sostituzione"]? "checked": "" .";
	
					// checked='checked'
				}
				?>
			</td>
        </tr>
        <?php
        ++$i;
	}#end giocatori ospiti
	?>
	</table>
	<p> addizionale = 0 </p>
	<p> giocatori con  voto = <?php echo $numero_giocanti_ospite; ?> </p>
	<p> voto netto = <?php echo $voto_netto_ospite; ?> </p>
	<p> media difesa = <?php echo $media_difesa_avversaria_ospite; ?> </p>
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
<input type="hidden" id="hfIdGirone" value='<?php echo $idgirone; ?>'>
<button type="button" id="btn_calcola">Calcola Risultati</button>

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

<input type="checkbox" name="calcolo" value='1' /> Calcolo fatto<br>
<input type="checkbox" name="risultati" value='1' /> Risultati<br>
<input type="checkbox" name="classifiche" value='1' /> Classifica<br>
<input type="checkbox" name="commento" value='1' /> Commento<br>
<input type="hidden" name="id_giornata" value=<?php echo $id_giornata;?> />
 <input type="submit" value="Submit">
</form> 
    
<?php 
include("../footer.php");
?>