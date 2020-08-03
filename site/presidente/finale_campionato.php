<?php
include("menu.php");

?>
<h2>Finale Campionato</h2>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
$(document).ready(function(){

    SalvaSquadrePartita = function(){
        var id1 = $("#sq_finalista1 option:selected").val();
        var id2 = $("#sq_finalista2 option:selected").val();
        var giornata = $("#hfgiornata").val();
        if(id1 == null || id1 == "")
        {
            alert('selezionare la squadra vincente dell\'apertura');
            return false;
        }
        if(id2 == null || id2 == "")
        {
            alert('selezionare la squadra vincente della clausura');
            return false;
        }

        if(id1== id2 )
        {
            alert('le due squadre devono essere diverse');
            return false;
        }
        var idsquadre = [id1, id2];

        // andata
        $.ajax({
                type:'POST',
                url:'match_c_salvasquadre.php',
                data: {"idgiornata": giornata, "idsquadre": JSON.stringify(idsquadre)},
                // success:function(data){
                //    //debugger;
                //     var resp=$.parseJSON(data)
                //     if(resp.result == "true"){
                //         alert(resp.message);
                //     }
                //     else{
                //         alert(resp.error.msg);
                //     }
                    
                //     //$('#city').html('<option value="">Select state first</option>'); 
                // }
                // // ,error: function (xhr, ajaxOptions, thrownError) {
                // //     alert(xhr.responseText);
                // // }
            });
        //ritorno
        idsquadre = [id2, id1];
        giornata= parseInt(giornata)+1;
        console.log(giornata);
        console.log(idsquadre);
        $.ajax({
            type:'POST',
            url:'match_c_salvasquadre.php',
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
$idgirone = 7; //7 finale campionato
$query= "SELECT giornate.*, 
        calendario.id_sq_casa, sq1.squadra as squadracasa,
        calendario.id_sq_ospite,  sq2.squadra as squadraospite 
        FROM `giornate` 
        left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
        left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
        left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_girone = ".$idgirone." order by id_giornata ASC";
$result=$conn->query($query);
// while ($row=$result->fetch_assoc()) {
//     $id_giornata=$row["id_giornata"];
//     $inizio=$row["inizio"];
//     $fine=$row["fine"];
//     $id_sq1=$row["id_sq_casa"];
//     $sq1=$row["squadracasa"];
//     $id_sq2=$row["id_sq_ospite"];
//     $sq2=$row["squadraospite"];
//     $inizio_a=date_parse($inizio);
//     $fine_a=date_parse($fine);
// };
$giornate = array();
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
    array_push($giornate, array(
        "id_giornata"=>$id_giornata,
        "inizio_a"=>$inizio_a,
        "fine_a"=>$fine_a,
        "id_sq1"=>$id_sq1,
        "sq1"=>$sq1,
        "id_sq2"=>$id_sq2,
        "sq2"=>$sq2,
        )
    );
}

$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);
$squadre = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    array_push($squadre, array(
        "id"=>$id,
        "squadra"=>$squadra
        )
    );
}
echo '<fieldset>';
// echo '<legend>Finale CAMPIONATO</legend>';

echo '<select id="sq_finalista1" name="squadra_fantacalcio_1">';
echo '<option value="">--Vincente Apertura--</option>';
foreach($squadre as $squadra)
{
    if($squadra["id"] ==$giornate[0]["id_sq1"] ){
        echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
    }
    else{
        echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
    }
}
echo '</select>';
echo '<select id="sq_finalista2" name="squadra_fantacalcio_2">';
echo '<option value="">--Vincente Chiusura--</option>';
foreach($squadre as $squadra)
{
    if($squadra["id"] ==$giornate[0]["id_sq2"] ){
        echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
    }
    else{
        echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
    }
}
echo '</select>';
echo '<input type="button" class="btn_salvasquadre" id="salvasquadre" value="Salva Squadre" name="'.$giornate[0]["id_giornata"].'"/>';
echo '<br>';

echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
echo '<input type="hidden" id="hfgiornata" name="giornata" value="'.$giornate[0]["id_giornata"].'">';
echo 'Inizio: <br>';
echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $giornate[0]["inizio_a"]['day'] .'" >';
echo 'Mese:<input type="text" name="m_inizio" size="5" value="'.  $giornate[0]["inizio_a"]['month'] .'" >';
echo 'Anno:<input type="text" name="a_inizio" size="5" value="'.  $giornate[0]["inizio_a"]['year'] .'">';
echo 'Ore:<input type="text" name="h_inizio" size="5" value="'.  $giornate[0]["inizio_a"]['hour'] .'">';
echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $giornate[0]["inizio_a"]['minute'] .'"><br>';
echo 'Fine: <br>';
echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $giornate[0]["fine_a"]['day'] .'" >';
echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $giornate[0]["fine_a"]['month'] .'" >';
echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $giornate[0]["fine_a"]['year'] .'">';
echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $giornate[0]["fine_a"]['hour'] .'">';
echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $giornate[0]["fine_a"]['minute'] .'"><br>';
echo '<input type="submit" value="Invia">';
echo '</form>';
echo '<div class="mainaction">';
echo '<a href="calcola_giornata.php?&id_giornata='.$giornate[0]["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
echo '</div>';

echo '<br>';

echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
echo '<input type="hidden" id="hfgiornata" name="giornata" value="'.$giornate[1]["id_giornata"].'">';
echo 'Inizio: <br>';
echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $giornate[1]["inizio_a"]['day'] .'" >';
echo 'Mese:<input type="text" name="m_inizio" size="5" value="'.  $giornate[1]["inizio_a"]['month'] .'" >';
echo 'Anno:<input type="text" name="a_inizio" size="5" value="'.  $giornate[1]["inizio_a"]['year'] .'">';
echo 'Ore:<input type="text" name="h_inizio" size="5" value="'.  $giornate[1]["inizio_a"]['hour'] .'">';
echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $giornate[1]["inizio_a"]['minute'] .'"><br>';
echo 'Fine: <br>';
echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $giornate[1]["fine_a"]['day'] .'" >';
echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $giornate[1]["fine_a"]['month'] .'" >';
echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $giornate[1]["fine_a"]['year'] .'">';
echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $giornate[1]["fine_a"]['hour'] .'">';
echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $giornate[1]["fine_a"]['minute'] .'"><br>';
echo '<input type="submit" value="Invia">';
echo '</form>';
echo '<br>';


echo '<div class="mainaction">';
echo '<a href="calcola_giornata.php?&id_giornata='.$giornate[1]["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
echo '</div>';
echo '</fieldset>'; 
?>
<?php 
include("../footer.php");
?>

