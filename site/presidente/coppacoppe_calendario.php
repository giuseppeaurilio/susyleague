<?php
include("menu.php");

?>
<script>
salvaGiornataCoppaCoppe = function(){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornatafc =  $(this).attr("data-idgiornata");
    var idgiornatasa =  $("#ddlGiornataSerieA" + idgiornatafc).val();
    salvaGiornata(idgiornatafc, idgiornatasa);
    
}
$(document).ready(function(){
    
    $(".btnsalva").off("click").bind("click", salvaGiornataCoppaCoppe);
})
</script>
<h2>Calendario Coppa delle Coppe</h2>
<?php
// echo "Connected successfully";
$id_girone = 6; //coppa coppe

include_once("..\DB/serie_a.php");
include_once("..\DB/fantacalcio.php");
$giornate = fantacalcio_getGiornate($id_girone);
// $squadre = fantacalcio_getFantasquadre();
$giornatesa = seriea_getGiornate();
$counter = 1;
// print_r($giornate);
foreach($giornate as $giornata){

    echo '<fieldset>';
    echo '<legend>Giornata:'.$counter.'</legend>';
    echo "<div class=\"actionrow\">";
    echo "<select id=\"ddlGiornataSerieA".$giornata["id_giornata"]."\">";
    echo "<option value=\"0\">seleziona giornata di serie a...</option>";
    foreach($giornatesa as $giornatasa)
    {
        echo "<option value=\"".$giornatasa["id"]."\" ".($giornatasa["id"] == $giornata["giornata_serie_a_id"]? "selected": "") .">"
        .$giornatasa["descrizione"]." (".$giornatasa["inizio"] .")</option>";
    }
    echo "</select>";
    echo "<input class=\"btnsalva\" type=\"button\" id=\"btbgiornata".$giornata["id_giornata"]."\" value=\"salva\" data-idgiornata=\"".$giornata["id_giornata"]."\" >";
    echo '</div>';
    echo '<div class="mainaction">'; 
    echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"].'&id_girone='.$id_girone.'" >Calcola Giornata</a>';
    echo '</div>';
    echo '</fieldset>';
    $counter++;
}
?>
    
<?php 
include("../footer.php");
?>