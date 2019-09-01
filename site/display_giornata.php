<?php
include("menu.php");

?>

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
include("dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";




$id_giornata=$_GET['id_giornata'];

?>

<h1> Giornata <?php echo $id_giornata ;?> </h1>
<div data-role="main" class="ui-content">

<?php


$query2="Select *, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone
FROM calendario as a 
left join sq_fantacalcio as b on a.id_sq_casa=b.id 
left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
left join giornate as g on g.id_giornata=a.id_giornata 
where a.id_giornata=".$id_giornata ." order by a.id_partita" ;
#echo "<br> quesry2= " . $query2;
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
	inner join giocatori as b 
	inner join squadre_serie_a as c 
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_casa ."' 
	and a.id_giocatore=b.id 
	and a.id_squadra_sa=c.id ";
	//echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
	 <div class="ui-grid-a">
		<div class="ui-block-a">
	<table border=1  id="squadra_casa<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_casa; ?></caption>
	<th><font face="Arial, Helvetica, sans-serif"> </font></th>
	<th><font face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto MD</font></th>
	<?php
	while ($row=$result_formazione->fetch_assoc()) {
		$ruolo_giocatore=$row["ruolo"];
	?>
        <tr id=row_<?php  echo $id_casa  . "_" . ($i+1);?> bgcolor= <?php switch ($ruolo_giocatore) {
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
<?php
		// echo $nome_giocatore;
		$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
		// echo $nome_giocatore_pulito;
		$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
?>
>
	<?php if ($i==0) {echo 	"<th bgcolor='#FFFFFF' rowspan='11'>Titolari</th>";  } ?>
	<?php if ($i==11) {echo "<th bgcolor='#FFFFFF' rowspan='8'>Riserve</th>";  } ?>
		<td><?php echo '<img style="height: 20;width: 15px;	" src='.$filename.'>';?></td>
		<td><?php echo $row["nome"]; ?></td>
		<td><?php echo $row["squadra_breve"]; ?></td>
		<td><?php echo $row["ruolo"]; ?></td>
		<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
		<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
		
        </tr>
        <?php
        ++$i;
	}#end giocatori casa
	?>
	
	</table>




	<?php
	// // $query_risultati="Select * from punteggio_finale where id_giornata='" . $id_giornata . "' and id_casa= '". $id_casa ."'";
	// $query_risultati="Select *, sum(punti_casa + md_casa + fattorecasa) as tot_casa from calendario where id_giornata='" . $id_giornata . "' and id_sq_casa= '". $id_casa ."'";
	// #echo "query= " . $query_risultati;
	// $risultati=$conn->query($query_risultati);
	// $num_risultati=$risultati->num_rows;
	
	// $addizionale="";
	// $voto_netto="";
	// $media_difesa="";
	// $voto_totale="";
	// $gol="";
	// $numero_giocanti="";	
	
	// if ($num_risultati>0) {	
	// 	$row=$risultati->fetch_assoc();
	// 	$addizionale=$row["fattorecasa"];
	// 	$voto_netto=$row["punti_casa"];
	// 	$media_difesa=$row["md_casa"];
	// 	$voto_totale=$row["tot_casa"];
	// 	$gol=$row["gol_casa"];
	// 	$numero_giocanti=$row["numero_giocanti_casa"];	
	// 	}
	
	// // $query_risultati="Select * from punteggio_finale where id_giornata='" . $id_giornata . "' and id_ospite= '". $id_ospite ."'";
	// $query_risultati="Select *, sum(punti_ospiti + md_ospite) as tot_ospite from calendario where id_giornata='" . $id_giornata . "' and id_sq_ospite= '". $id_ospite ."'";
	// #echo "query= " . $query_risultati;
	// $risultati=$conn->query($query_risultati);
	// $num_risultati=$risultati->num_rows;
	// $voto_netto_ospite="";
	// $media_difesa_ospite="";
	// $voto_totale_ospite="";
	// $gol_ospite="";
	// $numero_giocanti_ospite="";
	// if ($num_risultati>0) {	
	// 	$row=$risultati->fetch_assoc();
	// 	$voto_netto_ospite=$row["punti_ospiti"];
	// 	$media_difesa_ospite=$row["md_ospite"];
	// 	$voto_totale_ospite=$row["tot_ospite"];
	// 	$gol_ospite=$row["gol_ospiti"];
	// 	$numero_giocanti_ospite=$row["numero_giocanti_ospite"];
	// }


	// ?>
	
	<p> addizionale = <?php echo $addizionalecasa; ?> </p>
	<p> giocatori con  voto = <?php echo $numero_giocanti_casa; ?> </p>
	<p> voto netto = <?php echo $voto_netto_casa; ?> </p>
	<p> media difesa = <?php echo $media_difesa_avversaria_casa; ?> </p>
	<p> voto totale = <?php echo $voto_totale_casa; ?> </p>
	<p> gol = <?php echo $gol_casa; ?> </p>
		</div>
	<?php

	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_ospite ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";

	//echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
		<div class="ui-block-b">
	<table border=1  id="squadra_ospite<?php echo $j;?>">
	<caption class="caption_style"><?php echo $sq_ospite; ?></caption>

	<th><font face="Arial, Helvetica, sans-serif"> </font></th>
	<th><font face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Voto MD</font></th>

	<?php
	while ($row=$result_formazione->fetch_assoc()) {
		$ruolo_giocatore=$row["ruolo"];
	?>
        <tr id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> bgcolor= <?php switch ($ruolo_giocatore) {
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
<?php
		// echo $nome_giocatore;
		$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
		// echo $nome_giocatore_pulito;
		$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
?>
	<?php if ($i==0) {echo 	"<th bgcolor='#FFFFFF' rowspan='11'>Titolari</th>";  } ?>
	<?php if ($i==11) {echo "<th bgcolor='#FFFFFF' rowspan='8'>Riserve</th>";  } ?>
		<td><?php echo '<img style="height: 20;width: 15px;	" src='.$filename.'>';?></td>
		<td><?php echo $row["nome"]; ?></td>
		<td><?php echo $row["squadra_breve"]; ?></td>
		<td><?php echo $row["ruolo"]; ?></td>
		<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
		<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
		
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
	<p> gol = <?php echo $gol_ospite; ?> </p></div>

	</div>
	<hr>
	<?php
	
++$j;



} # end incontri
?>
</div>




</body>
</html>
