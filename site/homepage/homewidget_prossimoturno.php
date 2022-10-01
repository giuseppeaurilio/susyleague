<script>
redirectFormazioni = function(){
    var idpartita = $(this).data("idpartita");
    var idgiornata = $(this).data("idgiornata");
    window.location.href = "/display_giornata.php?id_giornata=" + idgiornata + "#tabellino" + idpartita;
}
$(document).ready(function(){
    $(".widget.prossimo .partita").off("click").bind("click", redirectFormazioni);
});
</script>
<div class="widget prossimo">
    <?php
    include_once("../DB/serie_a.php");
    include_once("../DB/fantacalcio.php");
    include_once "../DB/calendario.php";
    
    $giornatasacurrent = seriea_getGiornataCorrente();
    // if(!is_null($giornatasa))
    $giornatasa = seriea_getGiornataProssima();
    //se non c'e' una giornata in corso ed esiste una prossima giornata
    if(is_null($giornatasacurrent) && !is_null($giornatasa))
    {
        echo '<h2>Prossimo turno';
        $date = date_create($giornatasa["inizio"]);
        echo '<div style="font-size: 15px;"><a href="/invio_formazione.php" style="color:white;">Invia la formazione</a> entro: '.date_format($date, 'H:i').' del '.date_format($date, 'd/m'). '</div>';
        echo '</h2>';

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
                    '<div style="width:46%; display:inline-block; text-align:right;">'
                        . $giornatafc["sq1"]
                        . ($giornatafc["luc"] == 1 ? 
                        '<i class="far fa-check-circle" style="color:green;float:right;"></i> '
                        : (($giornatafc["luc"] == 2 ? 
                        '<i class="far fa-check-circle" style="color:yellow;float:right;"></i> '
                        : '<i class="far fa-times-circle" style="color:red;float:right;"></i> ') )
                        ).'</div>
                    <div style="width:5%; display:inline-block;">-</div>
                    <div style="width:46%; display:inline-block; text-align:left;">'
                        . ($giornatafc["luo"] == 1 ? 
                        '<i class="far fa-check-circle" style="color:green;float:left;"></i> '
                        : (($giornatafc["luo"] == 2 ? 
                        '<i class="far fa-check-circle" style="color:yellow;float:left;"></i> '
                        : '<i class="far fa-times-circle" style="color:red;float:left;"></i> ') )
                        ). $giornatafc["sq2"].'</div>
                </div>';
            // echo '</a>';
            echo '</div>';
        }
    }
    // se non c'e' una giornata in corso e non esiste una prossima giornata
    else if(is_null($giornatasacurrent) && is_null($giornatasa)){
        echo "<h3> &nbsp;</h3>";
        echo "<div class='widgetcontent2 prossimoturno'>Non ci sono partite in programma</div>";
    }
    else //c'e' una giornata in corso
    {
        echo '<script>
            $(document).ready(function(){
                $(".widget.prossimo").hide()
            });
        </script>';
    }
    echo '<hr>';

    ?>

</div>