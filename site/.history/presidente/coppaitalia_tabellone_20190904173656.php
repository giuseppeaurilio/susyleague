<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>

<h1>TAbellone Coppa Italia</h2>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

    SalvaSquadrePartita = function(){
        var id1 = $("#sq_finalista1 option:selected").val();
        var id2 = $("#sq_finalista2 option:selected").val();
        var giornata = $("#hfgiornata").val();
        if(id1 == null || id1 == "")
        {
            alert('selezionare la squadra vincente Girone A');
            return false;
        }
        if(id2 == null || id2 == "")
        {
            alert('selezionare la squadra vincente Girone B');
            return false;
        }

        if(id1== id2 )
        {
            alert('le due squadre devono essere diverse');
            return false;
        }
        var idsquadre = [id1, id2];

        $.ajax({
                type:'POST',
                url:'finale_c_salvasquadre.php',
                data: {"idgiornata": giornata, "idsquadre": JSON.stringify(idsquadre)},
                success:function(data){
                   //debugger;
                    var resp=$.parseJSON(data)
                    if(resp.result == "true"){
                        alert(resp.message);
                    }
                    else{
                        alert(resp.error.msg);
                    }
                    
                    //$('#city').html('<option value="">Select state first</option>'); 
                }
                // ,error: function (xhr, ajaxOptions, thrownError) {
                //     alert(xhr.responseText);
                // }
            });
    };
    $("#salvasquadre").off("click").bind("click", SalvaSquadrePartita);

})
</script>

<?php
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone = 5; //5 tabellone coppaitalia 
include("../dbinfo_susyleague.inc.php");
$query= "SELECT giornate.*, 
        calendario.id_sq_casa, sq1.squadra as squadracasa,
        calendario.id_sq_ospite,  sq2.squadra as squadraospite 
        FROM `giornate` 
        left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
        left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
        left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_girone = ".$idgirone." order by id_giornata ASC";
$result=$conn->query($query);
while ($row=$result->fetch_assoc()) {
    $id_giornata=$row["id_giornata"];
    $inizio=$row["inizio"];
    $fine=$row["fine"];
    $id_sq1=$row["id_sq_casa"];
    $sq1=$row["squadracasa"];
    $id_sq2=$row["id_sq_ospite"];
    $sq2=$row["squadraospite"];
    $inizio_a=date_parse($inizio);
    $fine_a=date_parse($fine);
};

// echo '<input type="hidden" id="hfa'.$index.'"/>';
echo '<div> Vincente Girone A: ';
echo '<select id="sq_finalista1" name="squadra_fantacalcio">';
echo '<option value="">--Seleziona squadra fantacalcio--</option>';
   
$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);

while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    if($id ==$id_sq1 ){
        echo '<option value=' . $id . ' selected>'. $squadra . '</option>';    
    }
    else{
        echo '<option value=' . $id . '>'. $squadra . '</option>';
    }
}
echo '</select>';
echo '</div>';

// echo '<input type="hidden" id="hfa'.$index.'"/>';
echo '<div>  Vincente Girone B: ';
echo '<select id="sq_finalista2" name="squadra_fantacalcio">';
echo '<option value="">--Seleziona squadra fantacalcio--</option>';
   
$query="SELECT * FROM sq_fantacalcio order by squadra";
$result=$conn->query($query);
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    if($id ==$id_sq2 ){
        echo '<option value=' . $id . ' selected>'. $squadra . '</option>';    
    }
    else{
        echo '<option value=' . $id . '>'. $squadra . '</option>';
    }
}
echo '</select>';
echo '</div>';
echo '<input type="button" id="salvasquadre" value="Salva Squadre"/>';
echo '<br>';


echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
echo '<input type="hidden" id="hfgiornata" name="giornata" value="'.$id_giornata.'">';
echo 'Inizio: <br>';
echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $inizio_a['day'] .'" >';
echo 'Mese:<input type="text" name="m_inizio" size="5" value="'.  $inizio_a['month'] .'" >';
echo 'Anno:<input type="text" name="a_inizio" size="5" value="'.  $inizio_a['year'] .'">';
echo 'Ore:<input type="text" name="h_inizio" size="5" value="'.  $inizio_a['hour'] .'">';
echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $inizio_a['minute'] .'"><br>';
echo 'Fine: <br>';
echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $fine_a['day'] .'" >';
echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $fine_a['month'] .'" >';
echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $fine_a['year'] .'">';
echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $fine_a['hour'] .'">';
echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $fine_a['minute'] .'"><br>';
echo '<input type="submit" value="Invia">';
echo '</form>';
echo '<br>';
echo '<a href="calcola_giornata.php?&id_giornata='.$id_giornata .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
    
$conn->close();
?>
