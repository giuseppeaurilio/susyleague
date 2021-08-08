<?php
include("menu.php");

?>
<script>
salvaGiornataCampionato = function(){
    var idgiornatafc =  $(this).attr("data-idgiornata");
    var idgiornatasa =  $("#ddlGiornataSerieA" + idgiornatafc).val();
    console.log ("idgiornatafc: " + idgiornatafc);
    console.log ("idgiornatasa: " + idgiornatasa);
    salvaGiornata(idgiornatafc, idgiornatasa)
}
$(document).ready(function(){
    $(".btnsalva").unbind("click").bind("click", salvaGiornataCampionato);
})
</script>

<h1>Amministazione Giornate</h2>
<?php

include_once("..\DB/serie_a.php");
include_once("..\DB/fantacalcio.php");
include_once("..\DB/calendario.php");

$giornatefc = fantacalcio_getGiornateCampionato();
$giornatesa = seriea_getGiornate();
?>
<fieldset>
<?php
foreach($giornatefc as $giornatafc)
{
    echo "<h2 >" .getDescrizioneGiornata($giornatafc["id_giornata"]) ."</h2>";
    echo "<div class=\"actionrow\">";
        echo "<select id=\"ddlGiornataSerieA".$giornatafc["id_giornata"]."\">";
            echo "<option value=\"0\">seleziona giornata di serie a...</option>";
            foreach($giornatesa as $giornatasa)
            {
                echo "<option value=\"".$giornatasa["id"]."\" ".($giornatasa["id"] == $giornatafc["giornata_serie_a_id"]? "selected": "") .">"
                .$giornatasa["descrizione"]." (".$giornatasa["inizio"] .")</option>";
            }
            echo "</select>";
            echo "<input class=\"btnsalva\" type=\"button\" id=\"btbgiornata".$giornatafc["id_giornata"]."\" value=\"salva\" data-idgiornata=\"".$giornatafc["id_giornata"]."\" >";
    echo "</div>";
    echo "<div class=\"mainaction\">";
    echo "<a href=\"calcola_giornata.php?id_giornata=" . $giornatafc["id_giornata"] ."&id_girone=".$giornatafc["id_girone"]."\" >Calcola Giornata</a>";
    echo "</div>";
    echo "<hr>";
}
?>

<?php 
include("../footer.php");
?>
