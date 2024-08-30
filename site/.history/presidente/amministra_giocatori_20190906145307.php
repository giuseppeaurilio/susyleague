<?php 
include("menu.php");

?>

<style>


</style>


<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->

<script>

function load_data(id_sq, ruolo) {
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'sq_sa='+id_sq+"&"+"ruolo="+ruolo,
                success:function(html){
                    $('#giocatore').html(html);
                    //$('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
}


$(document).ready(function(){
    
    $('#ruolo').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var a=load_data(sq_sa_ID ,ruolo);
        if(sq_sa_ID && ruolo){
			load_data(sq_sa_ID , ruolo)
        }else{
            $('#giocatore').html('<option value="">--Seleziona giocatore--</option>');
            //$('#city').html('<option value="">Select state first</option>'); 
        }
    });
   
});
</script>

<?php
include("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


?>

<div class="aggiungi">
<h2>Aggiungi Giocatore</h2>
<form action="aggiungi_giocatore.php" method="get">
	
	
Nome:<input type="text" id="nome" name="nome" size="30">

Codice:<input type="text" id="id" name="id" size="4">

<select name="Ruolo" id="ruolo">
  <option value="">--Seleziona ruolo--</option>	
  <option value="P">Portiere</option>
  <option value="D">Difensore</option>
  <option value="C">Centrocampista</option>
  <option value="A">Attaccante</option>
</select>


<select name="squadra_serie_a" id="sq_sa">
<option value="">--Seleziona squadra--</option>	
<?php
$query_sa="SELECT * FROM squadre_serie_a order by squadra";
$result_sa=$conn->query($query_sa);

$num_sa=$result_sa->num_rows; 
$i=0;
while ($row=$result_sa->fetch_assoc()) {
	$id=$row["id"];
	$squadra=$row["squadra_breve"];
	echo '<option value=' . $id . '>'. $squadra . '</option>';
	++$i;
}
?>
</select>




<input  type="hidden" id="sommario" name="sommario" value="">
 
 
<input type="submit" id="submit" value="Aggiungi">
</form> 

</div>



<h2>Rose</h2>



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
	<div >
	<h2><?php echo "$squadra";?></h2>


	<table border="0" cellspacing="2" cellpadding="2">
	<tr> 
	<th>id</th>
	<th>Nome</th>
	<th>Ruolo</th>
	<th>Squadra</th>
    <th>Costo</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
	</tr>
	<?php 

	$j=0;
	$spesi=0;
	while ($row=$result_giocatori->fetch_assoc()) {
		$id_giocatore=$row["id"];
		$nome_giocatore=$row["nome"];
		$ruolo_giocatore=$row["ruolo"];
		$squadra_giocatore=$row["sq_fc"];

		$costo_giocatore=$row["costo"];

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
<td><a href=<?php  echo "cambia_squadra_sa_giocatore.php?id_giocatore=" . $id_giocatore; ?> >Cambia squadra</a></td>
<td><a href=<?php  echo "elimina_giocatore.php?id_giocatore=" . $id_giocatore; ?> >Elimina</a></td>
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





?>





<?php 
include("footer.html");

?>

</body>
</html>
