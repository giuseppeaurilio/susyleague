<script>
redirectFormazioni = function(){
    var idpartita = $(this).data("idpartita");
    var idgiornata = $(this).data("idgiornata");
    window.location.href = "/display_giornata.php?id_giornata=" + idgiornata + "#tabellino" + idpartita;
}
$(document).ready(function(){
    $(".widget.ultimi .partita").off("click").bind("click", redirectFormazioni);
});
</script>
<div class="widget ultimi">
    <h2>Ultimi risultati</h2>

    <?php
include_once("..\DB/serie_a.php");
include_once("..\DB/fantacalcio.php");
include_once "../DB/calendario.php";

$giornatasa = seriea_getGiornataUltima();
if(!is_null($giornatasa))
{
    $giornatefc = fantacalcio_getPartite_bySerieAId($giornatasa["id"]);
    // print_r($giornatefc);
    $prev = "";
    $index=0;
    foreach ($giornatefc as $giornatafc)
    {
        $descrizioneGiornata = getDescrizioneGiornata($giornatafc["id_giornata"]);
        if($prev != $descrizioneGiornata)
        {
            echo '<h3>'.$descrizioneGiornata.'</h3>';
            $prev = $descrizioneGiornata;
        }
        $index++;
        if($index%2== 0)
            echo '<div class="result">';
        else
            echo '<div class="result alternate" >';
            // echo '<a href="display_giornata.php?&id_giornata=1">';  
        echo '<div style="text-align:center; cursor:pointer;" class="partita" 
                data-idpartita="'.$giornatafc["id_partita"].'" 
                data-idgiornata="'.$giornatafc["id_giornata"].'">'.
                '<div style="width:48%; display:inline-block; text-align:right;">'
                    // . $giornatafc["sq1"] 
                    
                    // .'<span class="gol">'. $giornatafc["gol_casa"] .'</span><br>' 
                    // .'<span class="punti">'. $giornatafc["punti_casa"].'</span>'
                    .'<div class="gol home">'. $giornatafc["gol_casa"].'</div>'
                    .'<div class="squadra home">'
                        .'<div class="squadra ">'. $giornatafc["sq1"] .'</div>'
                        .'<div class="punti home">'. $giornatafc["punti_casa"].'</div>'.
                    '</div>'
                    
                . '</div>
                <div style="width:2%; display:inline-block;">-</div>
                <div style="width:48%; display:inline-block; text-align:left; vertical-align:top;">'
                    .'<div class="gol away">'. $giornatafc["gol_ospiti"].'</div>'
                    .'<div class="squadra away  ">'
                        .'<span class=" ">'. $giornatafc["sq2"] .'</span>'
                        .'<br><span class="punti away">'. $giornatafc["punti_ospiti"].'</span>'.
                    '</div>'
                .'</div>
            </div>';
        // echo '</a>';
        echo '</div>';
    }
}
else{
    echo "<h3> &nbsp;</h3>";
    echo "<div class='widgetcontent2 ultimirisultati'>Non sono state giocate partite</div>";
}

echo '<hr>';
    ?>
</div>