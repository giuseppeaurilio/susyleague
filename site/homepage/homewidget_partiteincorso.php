<script>
redirectFormazioni = function(){
    var idpartita = $(this).data("idpartita");
    var idgiornata = $(this).data("idgiornata");
    window.location.href = "/display_giornata.php?id_giornata=" + idgiornata + "#tabellino" + idpartita;
}
$(document).ready(function(){
    $(".widget.incorso .partita").off("click").bind("click", redirectFormazioni);
});
</script>
<div class="widget incorso">
    <h2>Partite in corso</h2>
    <?php
    include_once("../DB/serie_a.php");
    include_once("../DB/fantacalcio.php");
    include_once "../DB/calendario.php";
    
    $giornatasa = seriea_getGiornataCorrente();
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
                    '<div style="width:46%; display:inline-block; text-align:right;">'
                        . $giornatafc["sq1"]
                        . ($giornatafc["luc"] == 1 ? 
                        '<i class="far fa-check-circle" style="color:green;float:right;"></i> '
                        : (($giornatafc["luc"] == 2 ? 
                        '<i class="far fa-check-circle" style="color:yellow;float:right;"></i> '
                        : '<i class="far fa-check-circle" style="color:blue;float:right;"></i> ') )
                        ).'</div>
                    <div style="width:5%; display:inline-block;">-</div>
                    <div style="width:46%; display:inline-block; text-align:left;">'
                        . ($giornatafc["luo"] == 1 ? 
                        '<i class="far fa-check-circle" style="color:green;float:left;"></i> '
                        : (($giornatafc["luo"] == 2 ? 
                        '<i class="far fa-check-circle" style="color:yellow;float:left;"></i> '
                        : '<i class="far fa-check-circle" style="color:blue;float:left;"></i> ') )
                        ). $giornatafc["sq2"].'</div>
                </div>';
            // echo '</a>';
            echo '</div>';
        }
            if($index == 0)
        {
            echo '<h3>Nessuna partita in programma</h3>';
        }
    }
    else 
        echo '<script>
            $(document).ready(function(){
                $(".widget.incorso").hide()
            });
        </script>';
    echo '<hr>';
    ?>
</div>