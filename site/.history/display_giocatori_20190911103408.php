<?php 
include("menu.php");

?>
<h2>Rose</h2>
<script>
	$(document).ready(function(){

		var time = 1000;
		var strurl = "/display_rose.php?autoscroll";
		var url_string = window.location.href;
		var url = new URL(url_string);
		var c = url.searchParams.get("autoscroll");
		// console.log(c);
		// console.log($(document).height());
		time = $(document).height() *10;
		if(c != null)
		{
			$('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, time,"linear", function() {
				$(this).animate({ scrollTop: 0 }, time,"linear",  function(){window.location.href="/display_rose.php?autoscroll"});
			});
		}
	});
</script>
<?php 

$query="SELECT * FROM squadre_serie_a order by squadra";
$result=$conn->query($query);

$num=$result->num_rows; 




$i=0;

while ($row=$result->fetch_assoc()) {
	$id_squadra=$row["id"];
	$squadra=$row["squadra"];
	$query2="SELECT a.squadra_breve as squadra, b.id, b.nome, b.ruolo FROM `squadre_serie_a` as a inner join giocatori as b where a.id=$id_squadra and b.id_squadra=$id_squadra order by ruolo desc";
	$query2="select giocatori.nome,giocatori.id, giocatori.ruolo, giocatori.id_squadra,rose.id_sq_fc, rose.costo, sq_fantacalcio.squadra as sq_fc from giocatori  left join rose  on giocatori.id=rose.id_giocatore left join sq_fantacalcio on rose.id_sq_fc=sq_fantacalcio.id  where giocatori.id_squadra=$id_squadra  order by ruolo desc";
	//echo $query2;
	$result_giocatori=$conn->query($query2);
	$num_giocatori=$result_giocatori->num_rows;

	#echo $i;

	?>
	
	<div class="rosegiocatoriseriea">
		

	<h2><?php echo "$squadra";?></h2>


	<table border="0" cellspacing="2" cellpadding="2">
	<tr> 
	<th>id</th>
	<th class="nome">Nome</th>
	<th>Ruolo</th>
	<th>Squadra</th>

	<th>Costo</th>
	</tr>
	<?php 

	$j=0;
	$spesi=0;
	while ($row_player=$result_giocatori->fetch_assoc()) {
		$id_giocatore=$row_player["id"];
		$nome_giocatore=$row_player["nome"];
		$ruolo_giocatore=$row_player["ruolo"];
		$squadra_giocatore=$row_player["sq_fc"];

		$costo_giocatore=$row_player["costo"];

		?>


		<tr style="background-color: <?php switch ($ruolo_giocatore) {
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
		<td><?php  echo "$id_giocatore"; ?></td>
		<td><?php  echo "$nome_giocatore"; ?></td>
		<td><?php  echo "$ruolo_giocatore"; ?></td>
		<td><?php  echo "$squadra_giocatore"; ?></td>

		<td><?php  echo "$costo_giocatore"; ?></td>
		</tr>

		<?php 
		++$j;

	} 
	echo "</table>";

	?>
	</div>

	<?php 

	++$i;
} 



// mysql_close();
// $conn->close();

?>
<?php 
include("footer.php");
?>