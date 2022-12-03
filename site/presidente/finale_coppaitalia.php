<?php
include_once ("menu.php");

?>
<h2>Finale Coppa Italia</h2>
<script>
salvaGiornataSAFinaleCI = function(){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornatafc =  $(this).attr("data-idgiornata");
    var idgiornatasa =  $("#ddlGiornataSerieA" + idgiornatafc).val();
    salvaGiornata(idgiornatafc, idgiornatasa);
    
}
salvaSquadreFinaleCI = function(){
    var id1 = $("#sq_finalista1 option:selected").val();
    var id2 = $("#sq_finalista2 option:selected").val();
    // var giornata = $("#hfgiornata").val();
    var giornata =  $(this).attr("data-idgiornata");
    salvaSquadrePartita(id1, id2, giornata);
}
$(document).ready(function(){
    $(".btnsalva").off("click").bind("click", salvaGiornataSAFinaleCI);
    $("#salvasquadre").off("click").bind("click", salvaSquadreFinaleCI);
})
</script>

<?php
$idgirone = 9; //finale coppa italia
include_once("../DB/serie_a.php");
include_once("../DB/fantacalcio.php");
// $giornate = fantacalcio_getGiornate($idgirone);
$giornate = fantacalcio_getPartite_byGironeId($idgirone);
$squadre = fantacalcio_getFantasquadre();
$giornatesa = seriea_getGiornate();
echo '<fieldset>';
// echo '<legend>Coppa Italia FINALE</legend>';
echo "<div class=\"actiontitle\">";
echo '<select id="sq_finalista1" name="squadra_fantacalcio_1">';
echo '<option value="">--Vincente Semifinale 1--</option>';
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
echo '<option value="">--Vincente Semifinale 2--</option>';
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
echo '<input type="button" class="btn_salvasquadre" id="salvasquadre" value="Salva Squadre" data-idgiornata="'.$giornate[0]["id_giornata"].'"/>';
echo '</div>';
echo "<div class=\"actionrow\">";
echo "<select id=\"ddlGiornataSerieA".$giornate[0]["id_giornata"]."\">";
echo "<option value=\"0\">seleziona giornata di serie a...</option>";
foreach($giornatesa as $giornatasa)
{
    echo "<option value=\"".$giornatasa["id"]."\" ".($giornatasa["id"] == $giornate[0]["giornata_serie_a_id"]? "selected": "") .">"
    .$giornatasa["descrizione"]." (".$giornatasa["inizio"] .")</option>";
}
echo "</select>";
echo "<input class=\"btnsalva\" type=\"button\" id=\"btbgiornata".$giornate[0]["id_giornata"]."\" value=\"salva\" data-idgiornata=\"".$giornate[0]["id_giornata"]."\" >";

echo '</div>';
echo '<div class="mainaction">';
echo '<a href="calcola_giornata.php?&id_giornata='.$giornate[0]["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
echo '</div>';
echo '</fieldset>'; 
?>
    
<?php 
include_once ("../footer.php");
?>