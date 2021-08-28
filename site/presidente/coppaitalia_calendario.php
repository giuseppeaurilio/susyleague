<?php
include("menu.php");

?>
<script>
salvaGiornataCI = function(){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornatafc =  $(this).attr("data-idgiornata");
    var idgiornatasa =  $("#ddlGiornataSerieA" + idgiornatafc).val();
    salvaGiornata(idgiornatafc, idgiornatasa);
    
}
$(document).ready(function(){
    
    $(".btnsalva").off("click").bind("click", salvaGiornataCI);
})
</script>
<h1>Calendario Coppa Italia</h2>
<?php
$id_girone = 4;
include_once("../DB/serie_a.php");
include_once("../DB/fantacalcio.php");
// $giornate = fantacalcio_getGiornate($id_girone);
// $squadre = fantacalcio_getFantasquadre();
$partite = fantacalcio_getPartite_byGironeId($id_girone);
$giornatesa = seriea_getGiornate();

$counter = 0;
foreach($partite as $partita){
    if($counter == 0 ){
        echo '<h1>Girone Narpini</h1>';    
    }
    else if($counter == 15 ){
        echo '<h1>Girone Gianluca</h1>';    
    }
    if($counter %3  == 0){
        echo '<fieldset>';
        echo '<legend>Giornata:'.($counter/3 > 5 ? $counter/3 - 4 : $counter/3 +1 ).'</legend>';
    }
    echo "<div class=\"actiontitle\">";
    echo '<label for="giornata">'.$partita["sq1"].'-'.$partita["sq2"].'(ID:'.$partita["id_giornata"].') </label>';
    echo '</div>';
    echo "<div class=\"actionrow\">";
    echo "<select id=\"ddlGiornataSerieA".$partita["id_giornata"]."\">";
    echo "<option value=\"0\">seleziona giornata di serie a...</option>";
    foreach($giornatesa as $partitasa)
    {
        echo "<option value=\"".$partitasa["id"]."\" ".($partitasa["id"] == $partita["giornata_serie_a_id"]? "selected": "") .">"
        .$partitasa["descrizione"]." (".$partitasa["inizio"] .")</option>";
    }
    echo "</select>";
    echo "<input class=\"btnsalva\" type=\"button\" id=\"btbgiornata".$partita["id_giornata"]."\" value=\"salva\" data-idgiornata=\"".$partita["id_giornata"]."\" >";
    echo '</div>';
    echo '<div class="mainaction">';
    echo '<a href="calcola_giornata.php?&id_giornata='.$partita["id_giornata"].'&id_girone='.$id_girone.'" >Calcola Giornata</a>';
    echo '</div>';
    echo '<br>';
    echo '<input type="hidden" name="giornata" value="'.$partita["id_giornata"].'">';
    echo '</form>';
    
    $counter++;
    if($counter %3  == 0){
        echo '</fieldset>';
    }
}
?>
    
<?php 
include("../footer.php");
?>
