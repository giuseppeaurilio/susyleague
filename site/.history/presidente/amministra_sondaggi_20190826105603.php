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

include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * FROM sondaggi order by id ASC";
$result=mysql_query($query);

$num=mysql_numrows($result); 

$i=0;
$id_sondaggio_old=0;
while ($i <= $num) {


	if ($i<$num) {
		$id_sondaggio=mysql_result($result,$i,"id");
		$risp_multipla=mysql_result($result,$i,"risposta_multipla");
		$fine=mysql_result($result,$i,"scadenza");
		$testo=mysql_result($result,$i,"testo");
		$fine_a=date_parse($fine);
	}
	else {
		$id_sondaggio=$id_sondaggio+1;
		$risp_multipla="";
		$fine="";
		$testo="";
		$fine_a=date_parse($fine);
	}
	

?>

	<form action="query_amministra_sondaggi.php" method="post" class="a-form" target="formSending">

	<label for="sondaggio">Sondaggio <?php echo $id_sondaggio; ?></label><br>
	<input type="hidden" name="id_sondaggio" value="<?php echo $id_sondaggio; ?>">

	Testo:<input type="text" name="testo" size="120" value="<?php echo $testo ?>" ><br>
	Fine:
	Giorno:<input type="text" name="g_fine" size="5" value="<?php echo $fine_a['day'] ?>" >
	Mese:<input type="text" name="m_fine" size="5" value="<?php echo $fine_a['month'] ?>" >
	Anno:<input type="text" name="a_fine" size="5" value="<?php echo $fine_a['year'] ?>">
	Ore:<input type="text" name="h_fine" size="5" value="<?php echo $fine_a['hour'] ?>">
	Minuti:<input type="text" name="min_fine" size="5" value="<?php echo $fine_a['minute'] ?>"><br>
	Risposta multipla: <input type="checkbox" name="risp_multipla" value="risp_multipla"><br>
	<div class="input_fields_wrap" id="wrapper_add_button_<?php echo $id_sondaggio; ?>" >
    <button type="button" class="add_field_button" id="add_button_<?php echo $id_sondaggio; ?>">Aggiungi opzioni</button>
<?php
	$query_opzioni='SELECT * FROM sondaggi_opzioni where id_sondaggio=' .$id_sondaggio . ' order by id ASC';
	$result_opzioni=mysql_query($query_opzioni);
	$num_opzioni=mysql_numrows($result_opzioni);
	$j=0;
	while ($j < $num_opzioni) {
		$id_risposta=mysql_result($result_opzioni,$j,"id");
		$opzione=mysql_result($result_opzioni,$j,"opzione");
		#echo $opzione;
		#echo '<div><input type="text" name="mytext[]"></div>';
		echo  '<div><input type="text" name="mytext[]" value="' . $opzione . '">';
		echo '<a href="#" class="remove_field">Cancella</a></div>';
		++$j;
		
	}
?>
    </div>
	<input type="submit" value="Invia">
	</form>
	<a href="cancella_sondaggio.php?&id_sondaggio=<?php echo $id_sondaggio ?>" >Cancella Sondaggio</a>
	<hr>

<?php
	++$i;
}


include("footer.html");



?>
