<?php
include("menu.php");
?>

<!DOCTYPE html>
<html>
<head>
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

</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        console.log($(this).attr('id'));
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $("#wrapper_" + $(this).attr('id') ).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Cancella</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>


<?php

include_once ("../dbinfo_susyleague.inc.php");

// Create connection 
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query="SELECT * FROM sondaggi order by id ASC";
$result=$conn->query($query);

// $num=$result->num_rows; 


// $id_sondaggio_old=0;
// while ($i <= $num) {
while ($row=$result->fetch_assoc()) {
		$id_sondaggio=$row["id"];
		$risp_multipla=$row["risposta_multipla"];//mysql_result($result,$i,"risposta_multipla");
		$fine=$row["scadenza"];//mysql_result($result,$i,"scadenza");
		$testo=$row["testo"];//mysql_result($result,$i,"testo");
		$fine_a=date_parse($fine);



		echo '<form action="query_amministra_sondaggi.php" method="post" class="a-form" target="formSending">';

		echo '<label for="sondaggio">Sondaggio '. $id_sondaggio .'</label><br>';
		echo '<input type="hidden" name="id_sondaggio" value="'.$id_sondaggio.'>">';

		echo 'Testo:<input type="text" name="testo" size="120" value="'. $testo .'" ><br>';
		echo 'Fine:';
		echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $fine_a['day'] .'" >';
		echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $fine_a['month'] .'" >';
		echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $fine_a['year'] .'">';
		echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $fine_a['hour'] .'">';
		echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.$fine_a['minute'] .'"><br>';
		echo 'Risposta multipla: <input type="checkbox" name="risp_multipla" value="risp_multipla"><br>';
		echo '<div class="input_fields_wrap" id="wrapper_add_button_'.$id_sondaggio.'" >';
		echo '<button type="button" class="add_field_button" id="add_button_'.$id_sondaggio .'">Aggiungi opzioni</button>';


	$query_opzioni='SELECT * FROM sondaggi_opzioni where id_sondaggio=' .$id_sondaggio . ' order by id ASC';
	// $result_opzioni=mysql_query($query_opzioni);
	// $num_opzioni=mysql_numrows($result_opzioni);
	$result_opzioni=$conn->query($query_opzioni);
	// $num_opzioni=$result_opzioni->num_rows; 
	// $j=0;
	// while ($j < $num_opzioni) {
	while ($row=$result_opzioni->fetch_assoc()) {
		$id_risposta=$row["id"];//mysql_result($result_opzioni,$j,"id");
		$opzione=$row["opzione"];//mysql_result($result_opzioni,$j,"opzione");
		#echo $opzione;
		#echo '<div><input type="text" name="mytext[]"></div>';
		echo  '<div><input type="text" name="mytext[]" value="' . $opzione . '">';
		echo '<a href="#" class="remove_field">Cancella</a></div>';
		// ++$j;
		
	}

echo '</div>';
echo '<input type="submit" value="Invia">';
echo '</form>';
echo '<a href="cancella_sondaggio.php?&id_sondaggio=<?php echo $id_sondaggio ?>" >Cancella Sondaggio</a>';
}
echo '<hr>';

?>
<form action="query_amministra_sondaggi_nuovo.php" method="post" class="a-form" target="formSending">
<label for="sondaggio">Nuovo sondaggio</label><br>
Testo:<input type="text" name="testo" size="120" value="" ><br>
Fine:
Giorno:<input type="text" name="g_fine" size="5" value="" >
Mese:<input type="text" name="m_fine" size="5" value="" >
Anno:<input type="text" name="a_fine" size="5" value="">
Ore:<input type="text" name="h_fine" size="5" value="">
Minuti:<input type="text" name="min_fine" size="5" value=""><br>

<input type="submit" value="Invia">
</form>
<?php
	// ++$i;
include("footer.html");

?>