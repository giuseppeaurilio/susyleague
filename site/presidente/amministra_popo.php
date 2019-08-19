<?php 
include("menu.php");

?>

<link href="../style.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>


<script>
var partite = [4, 4, 3,1];
var competizioni = ["play_off", "play_out", "coppa_delle_coppe"];
$(document).ready(function(){
    $("#invia").click(function(){
			for (id_giornata=34; id_giornata<=37; id_giornata++){ //segue le giornate
				console.log("giornata= " + id_giornata);
				for (partita = 1; partita <=partite[id_giornata-34]; partita++) { //partita scorre i giocatori
					console.log ("partita numero =" + partita);
					var id_squadra_casa;
					id_squadra_casa=$("#sel_" + id_giornata + "_" + partita + "_1").val();
					id_squadra_ospite=$("#sel_" + id_giornata + "_" + partita + "_2").val();
					console.log ("sq casa =" + id_squadra_casa);
					console.log ("sq ospite =" + id_squadra_ospite);
					//if (id_squadra_casa!="nothing" && id_squadra_ospite!="nothing") 
					//{
					dataString = "id_giornata=" + id_giornata + "&id_partita=" + partita +"&id_squadra_casa=" + id_squadra_casa + "&id_squadra_ospite=" + id_squadra_ospite;
					console.log ("query =" + dataString);
					$.ajax(
						{
						type: "POST",
						url: "query_aggiungi_partita.php",
						data: dataString,
						cache: false,
						success: function(result)
							{
								console.log("result=" + result)
							}
						}); //end ajax
//					} // end if id_squadra_casa!="nothing"
				} // end for partita
			}//end for id_giornata
			
			
			/////aggiorna i vincitori
			var competizione;
			for  ( competizione of competizioni){
				var id_winner;
				id_winner=$("#sel_w_" + competizione).val();
				dataString = "competizione=" + competizione + "&vincitore=" + id_winner;
				console.log ("query =" + dataString);
				$.ajax(
					{
					type: "POST",
					url: "query_aggiungi_vincitore.php",
					data: dataString,
					cache: false,
					success: function(result)
						{
								console.log("result=" + result)
						}
					})
						
					
			}// end for each competizione
				
    });
});
</script>




<body>

<h1>Gestione Calendari Play-off Pay-out e Coppa delle Coppe</h1>


<?php
include("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


#echo "test";
$partite = array(4,4,3,1);
$query="SELECT * FROM sq_fantacalcio";
$result_sq_fc=$conn->query($query);

$num_sq_fc=$result->num_rows; 

while( $row = $result_sq_fc->fetch_assoc()){
 $squadre_fc[ $row['id']] = $row;
}



//echo "<br>" . "numero= ". $num;
?>

<?php 
for ($id_giornata=34;$id_giornata<=37; $id_giornata++) { 

	echo "<h2>Giornata " . $id_giornata . "</h2>" .PHP_EOL;
	if ($id_giornata == 37) {echo "<h3>Coppa delle Coppe</h3>"; } else {echo "<h3>Play-off</h3>";}
	echo PHP_EOL;

	for ($i=1;$i<=$partite[$id_giornata - 34]; $i++) {
		if (($i == $partite[$id_giornata - 34]/2+1) || ($id_giornata == 36) && ($i == 2)){	echo "<h3>Play-out</h3>";}
		if (($id_giornata == 36) && ($i == 3)) {	echo "<h3>Terzo Posto</h3>";}
		$query2="select * from calendario where id_giornata = " . $id_giornata . " and id_partita=" . $i;

		$result2=$conn->query($query2);
		$num2=$result2->num_rows;

		if ($num2>0)
			{
			$row=$result2->fetch_assoc();
//			print_r($row);
			$id_sq_casa=$row["id_sq_casa"];
			
			$id_sq_ospite=$row["id_sq_ospite"];
			//echo $id_sq_casa,$id_sq_ospite;
			}
		else
			{
			$id_sq_casa=0;
			$id_sq_ospite=0;
			}		
		for ($j=1; $j <=2 ; $j++) {
			echo '<select id="sel_' .$id_giornata . '_' . $i .'_' .$j .'">' .PHP_EOL;
			$k=0;
			echo '<option value="">--</option>';

			foreach ($squadre_fc as $squadra)
			{

				$id=$squadra["id"];

				$squadra=$squadra["squadra"];
				if (($j==1 and $id==$id_sq_casa) or ($j==2 and $id==$id_sq_ospite))
					{
					echo '<option selected value="' . $id .'">'. $squadra .'</option>';
					}
					else
					{
					echo '<option value="' . $id .'">'. $squadra . '</option>';
					}					
			
			} //end for each
			echo "</select>";
		} //end for j
		echo "<br>";
	}//end for i
}// end for id_giornata
?>
<br>
<br>
<br>
<h1>Vincitori</h1>

<?php
$competizioni = array("play_off","play_out","coppa_delle_coppe");	
foreach ($competizioni as $competizione){
	echo "<h2>" .$competizione."</h2>";
	$query_w="SELECT * FROM vincitori where competizione='". $competizione ."'";
//		//echo $query_w;
	$result_w=$conn->query($query_w);
	$num_w=$result_w->num_rows;
	$row_w=$result_w->fetch_assoc();
	if ($num_w>0) $id_w=$row_w["id_vincitore"];
//		
//		//echo $id_w;
	echo '<select id="sel_w_' . $competizione .'">' .PHP_EOL;
	$k=0;
	echo '<option value="">--</option>';
	foreach ($squadre_fc as $squadra){
		$id=$squadra["id"];
		$squadra=$squadra["squadra"];
		if ($id==$id_w)	
		{
			echo '<option selected value="' . $id .'">'. $squadra .'</option>';
		}
		else
		{
			echo '<option value="' . $id .'">'. $squadra .'</option>';
		}					
	} //end foreach
	echo "</select>";
}// end for each competizione
?>
<br>
<br>
<input type="submit" id="invia" name="submit" value="INVIA TUTTE LE GIORNATE">
