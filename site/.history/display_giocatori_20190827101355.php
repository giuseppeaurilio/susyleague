<?php 
include("menu.php");

?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}


.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}
div.scroll {
    background-color: #00FFFF;
    width: 1000px;
    height: 1000px;
    margin:0 auto;
    overflow: auto; 
    
}

div.inner {
    margin-right:-999em;
    padding-left:20px
    }
    
#wrapper {
    width:100%;
    margin: 30px auto;
    border:1px solid #000;
    background:#EEF;
    padding:10px 0 25px 0;
}

#outer-wrap {
    width: 90%; 
    height: 256px;
    margin:0 auto;
    overflow: auto; 
    background:#BCC5E1;
    border:1px solid #000; 
}
#inner-wrap {
    float:left;
    margin-right:-999em;
    padding-left:20px;
}
.floatbox {
    float:left; /*force into block level for dimensions*/
    //width:400px;
    height:900px;
    //background:blue;
    color:#000;
    margin:20px 20px 0 0;
}



</style>




<h2>Rose</h2>



<?php 

include("dbinfo_susyleague.inc.php");
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



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
	<div class="floatbox">
	<h2><?php echo "$squadra";?></h2>


	<table border="0" cellspacing="2" cellpadding="2">
	<tr> 
	<th><font face="Arial, Helvetica, sans-serif">id</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
	<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>

	<th><font face="Arial, Helvetica, sans-serif">Costo</font></th>
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


		<tr bgcolor= <?php switch ($ruolo_giocatore) {
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
		<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$id_giocatore"; ?></font></td>
		<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$nome_giocatore"; ?></font></td>
		<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$ruolo_giocatore"; ?></font></td>
		<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra_giocatore"; ?></font></td>

		<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$costo_giocatore"; ?></font></td>
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
$conn->close();

?>





<?php 
include("footer.html");

?>

</body>
</html>
