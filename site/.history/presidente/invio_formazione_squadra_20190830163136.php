<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.myButton_0 {
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
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;


}
.myButton_1 {
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
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;

}

.myButton_2 {
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
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;
  
}

.myButton_3 {
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
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;

}

.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}
</style>



<?php
include("menu.php");
$id_giornata=$_GET['id_giornata'];
$id_squadra=$_GET['id_squadra'];

$ruoli = array("P","D","C","A");
$ruoli_name = array("Portieri","Difensori","Centrocampisti","Attaccanti");



include("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$query="SELECT squadra, allenatore FROM sq_fantacalcio where id=" . $id_squadra;
// $result=mysql_query($query);
$result  = $conn->query($query) or die($conn->error);


// $squadra=mysqli_result($result,$i,"squadra");
// $allenatore=mysqli_result($result,$i,"allenatore");
while ($row = $result->fetch_assoc()) {
	$squadra = $row["squadra"];
	$allenatore = $row["allenatore"];
}
?>
<script>

var pconto = [0, 0, 0, 0];
var modulo = [0, 0, 0, 0];

function sortFunction(a, b) {
    if (a[0] === b[0]) {
        return 0;
    }
    else {
        return (a[0] < b[0]) ? -1 : 1;
    }
}
    function getCol(matrix, col){
       var column = [];
       for(var i=0; i<matrix.length; i++){
          column.push(matrix[i][col]);
       }
       return column;
    }

function pushArray(arr, arr2) {
    arr.push.apply(arr, arr2);
}
    

$(document).ready(function(){
    $('[class^="myButton"]').click(function(){

	console.log($(this).text());
	//var a = $(this).attr('id').split("_");
	var myClass = $(this).attr("class");
	var a = myClass.split("_");
	var ruolo=parseInt(a[1]) ;
	switch($( this ).css( "background-color" )) {
	case "rgb(0, 255, 0)"://da titolare a panchina
		$( this ).css( "background-color" , "rgb(255, 0, 0)");
		pconto[ruolo]= pconto[ruolo]+1;
		modulo[ruolo]=modulo[ruolo]-1;
		$(this).text( $(this).text() +  "*" + pconto[ruolo]);
		
		break;
	case "rgb(255, 0, 0)"://da panchina a tribuna
		$( this ).css( "background-color" , "rgb(141, 194, 235)");
		pconto[ruolo]= pconto[ruolo]-1;
		var b = $(this).text().split("*");
		$(this).text(b[0]);
		var panchina = parseInt(b[1]);
		$('.' + myClass).each(function(){
		console.log($(this).text());
		var d = $(this).text().split("*");
		panchina_rem= parseInt(d[1]);
		if (panchina_rem>panchina) {
		$(this).text(d[0] + "*" + (panchina_rem-1));}
		})
		break;	
	default: //da tribuna a titolare
		$( this ).css( "background-color" ,"rgb(0, 255, 0)");
		modulo[ruolo]=modulo[ruolo]+1;
		break;
	}
	var testo_modulo="";
	var tot_panchine =0;
	for (j = 0; j < 3; j++) {
    	testo_modulo += String(modulo[j]) + "-";
    	tot_panchine += pconto[j];
	}
	testo_modulo += String(modulo[3]) ;
	tot_panchine += pconto[3];
	$("#modulo").text(testo_modulo);
	$("#panchina").text(String(tot_panchine));
}
)


 $("#btn_invia").click(function(){
 var id_squadra= "<?php echo $id_squadra; ?>";
 var id_giornata="<?php echo $id_giornata; ?>";
 var dataString = 'id_squadra='+ id_squadra + '&id_giornata=' + id_giornata + '&titolari=';
 var titolari = [];
 var panchina = [];
 for (j = 0; j < 4; j++) {
  		var panchina_loc= new Array();
 	$('.myButton_'+ String(j)).each(function(){

 		if ($(this).css( "background-color")=="rgb(0, 255, 0)"){
 		var id=$(this).attr("id");
 		var id_num=id.split("_");
 		titolari.push (id_num[1]);
 		}
  		if ($(this).css( "background-color")=="rgb(255, 0, 0)"){
 		var id=$(this).attr("id");
 		var id_num=id.split("_");
 		var nome=$(this).text();
 		var pos=nome.split("*");
 		var valueToPush = new Array();
 		valueToPush[0] = pos[1];
 		valueToPush[1] = id_num[1];
 		panchina_loc.push ([pos[1],id_num[1]]  );
 		}		

 		})
		var panchina_sort = panchina_loc.sort(sortFunction);
 		var panchina_id = getCol(panchina_sort,1);
 		pushArray(panchina,panchina_id);
 	}
 	titolari.forEach(function(entry) {
 	dataString += String(entry) + ",";
 	});
 	dataString = dataString.substring(0, dataString.length - 1);
 	dataString += "&panchina="
 	panchina.forEach(function (entry) {
 	dataString += String(entry) + ",";
 	});
 	dataString = dataString.substring(0, dataString.length - 1);
 	dataString += "&password_all=" + $("#password").val();
	console.log(dataString);
	$.ajax(
	{
		type: "POST",
		url: "query_invio_formazione.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
		console.log(result);
		window.alert(result);
	//		message_status.show();
	//		message_status.text("Aggiornato");
	//		#hide the message
	//			setTimeout(function(){message_status.hide()},1000);
	//		
		}
	//
	});

 });
 
 
});
$(document).ready(function(){
	$("#ddlUltimeFormazioni").change(impostaFormazione);
}
);

 impostaFormazione = function()
 {
	var value =$(this).val();
	if(val!=0)
		{
		var giocatori= value.split('.');
		// alert(giocatori[0]);
		for(var index = 0; index< 11: index++)
			{
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
		for(var index = 11; index< 19: index++)
			{
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
 }
</script>

<h2>Invio fomazione</h2>
<h2><?php echo $squadra . "(" .$allenatore .")";?></h2>
<!-- <h3><?php echo "(" .$allenatore .")";?></h3> -->
<select id="ddlUltimeFormazioni">
	<option value="0">scegli...</option>
	<option value="1_282.2_11.3_286.4_322.5_392.6_152.7_184.8_355.9_277.10_408.11_409.12_350.13_513.14_662.15_1847.16_375.17_402.18_410.19_441">I NANI- ASVenere</option>
</select>
<?php
for($i = 0; $i < 4; $i++) {

	include("../dbinfo_susyleague.inc.php");
	$conn = new mysqli($localhost, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//$query2="SELECT * FROM rose where sq_fantacalcio_id=" . $id_squadra . " AND ruolo = '" . $ruoli[$i] ."'";
	$query2="SELECT * FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc=". $id_squadra ." AND a.id_giocatore=b.id and b.ruolo='" . $ruoli[$i] ."' and b.id_squadra=c.id";

	//echo $query2;
	// $result_giocatori=mysql_query($query2);
	// $num_giocatori=mysql_numrows($result_giocatori);
	#echo $num_giocatori;
	#echo $i;
	$result_giocatori  = $conn->query($query2) or die($conn->error);
	$num_giocatori=$result_giocatori->num_rows;
	// while ($row = $result_giocatori->fetch_assoc()) {
	// 	$squadra = $row["squadra"];
	// 	$allenatore = $row["allenatore"];
	// }
	?>
	
	<div >
	<h2><?php echo $ruoli_name[$i];?></h2>
	<?php

	$j=0;
		// while ($j < $num_giocatori) {
		// $id_giocatore=mysql_result($result_giocatori,$j,"id_giocatore");
		// $nome_giocatore=mysql_result($result_giocatori,$j,"nome");
		// $squadra_giocatore=mysql_result($result_giocatori,$j,"squadra_breve");
		// $ruolo_giocatore=mysql_result($result_giocatori,$j,"ruolo");
		// $costo_giocatore=mysql_result($result_giocatori,$j,"costo");
		while ($row = $result_giocatori->fetch_assoc()) {
			$id_giocatore=$row["id_giocatore"];//mysql_result($result_giocatori,$j,"id_giocatore");
			$nome_giocatore=$row["nome"];//mysql_result($result_giocatori,$j,"nome");
			$squadra_giocatore=$row["squadra_breve"];//mysql_result($result_giocatori,$j,"squadra_breve");
			$ruolo_giocatore=$row["ruolo"];//mysql_result($result_giocatori,$j,"ruolo");
			$costo_giocatore=$row["costo"];//mysql_result($result_giocatori,$j,"costo");

	?>
		<button id="btn_<?php echo  $id_giocatore; ?>" type="button" class="myButton_<?php echo $i; ?>"><?php echo $nome_giocatore . " (" .$squadra_giocatore . ")";?></button>

	<?php
	++$j;

	} 
	?>
	</div>
	<?php
}

?>

<form action="" class="a-form">
<label for="modulo"> modulo = </label>
<label id="modulo" >  </label><br>
<label for="panchina" >panchina = </label>
<label id="panchina" >  </label><br>
Password: <input type="password" name="password" id="password">
<button type="button" id="btn_invia">Invia Formazione</button>

</form>

<p> Le formazioni inviate dagli allenatori possono essere consultate nella sezione CALENDARIO facendo click sul nome della giornata </p>
<a href="<?php echo "display_giornata.php?&id_giornata=" . $id_giornata ; ?>"><?php echo "Formazioni Giornata " . $id_giornata ?></a>
<br>

<?php
include("footer.html");

?>

</body>
</html>
