<?php
include("menu.php");

?>

<h1>Tabellone Coppa Italia</h2>

<script>
salvaSquadreCITabellone = function(){
    var giornataand = $(this).attr("data-idgiornata");
    var giornatarit = parseInt(giornataand) +1;
    var id1 = $("#sq_a_" +  giornataand + " option:selected").val();
    var id2 = $("#sq_b_" +  giornataand + " option:selected").val();
    // debugger;
    salvaSquadrePartita(id1, id2, giornataand);
    // if(giornatarit != 77)
    salvaSquadrePartita(id2, id1, giornatarit);
};
salvaGiornataCITabellone = function(){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornatafc =  $(this).attr("data-idgiornata");
    var idgiornatasa =  $("#ddlGiornataSerieA" + idgiornatafc).val();
    salvaGiornata(idgiornatafc, idgiornatasa);
}
$(document).ready(function(){
    $(".btnsalva").off("click").bind("click", salvaGiornataCITabellone);
    $(".btn_salvasquadre").off("click").bind("click", salvaSquadreCITabellone);
})
</script>

<?php


$idgirone = 5;//tabellone coppaitalia

include_once("../DB/serie_a.php");
include_once("../DB/fantacalcio.php");
$giornate = fantacalcio_getPartite_byGironeId($idgirone);
$squadre = fantacalcio_getFantasquadre();
$giornatesa = seriea_getGiornate();


foreach($giornate as $giornata){
    // print_r($giornata);
    // echo "<br><br><br>";

    $index = $giornata["id_giornata"];
    //match di andata e ritorno 
    //quarti 64/65 66/67 68/69 70/71
    //semifinali 72/73 74/75
    //finale secca 76
    switch($index){
        case 64:
        case 66:
        case 68:
        case 70:
        case 72:
        case 74:
        echo '<fieldset>';
        if($index == 64 ||$index == 66 ||$index == 68 ||$index == 70 )
        echo '<legend>Quarto '.(($index-62)/2).'</legend>';
        else
        echo '<legend>Semifinale '.(($index-70)/2).'</legend>';
        echo "<div class=\"actiontitle\">";
        echo '<select id="sq_a_'.$index.'" name="squadra_fantacalcio_a_'.$index.'">';
        if($index == 72)
        echo '<option value="">--Vincente Quarto 1--</option>';
        else if($index == 74)
        echo '<option value="">--Vincente Quarto 3--</option>';
        else
        echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        foreach($squadre as $squadra)
        {
            if($squadra["id"] ==$giornata["id_sq1"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<select id="sq_b_'.$index.'" name="squadra_fantacalcio_b_'.$index.'">';
        if($index == 72)
        echo '<option value="">--Vincente Quarto 2--</option>';
        else if($index == 74)
        echo '<option value="">--Vincente Quarto 4--</option>';
        else
        echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        foreach($squadre as $squadra)
        {
            if($squadra["id"] ==$giornata["id_sq2"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<input type="button" class="btn_salvasquadre" id="salvasquadre'.$giornata["id_giornata"].'" value="Salva Squadre" data-idgiornata="'.$giornata["id_giornata"].'"/>';
        echo '</div>';
        echo "<div class=\"actionrow\">";
        echo "ANDATA: "; 
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
        echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';   
        
        echo '</div>';
        //match di andata
        break;
        case 65:
        case 67:
        case 69:
        case 71:
        case 73:
        case 75:
            echo "<div class=\"actionrow\">";
            echo "RITORNO: "; 
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
            echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"].'&id_girone='.$idgirone.'">Calcola Giornata</a>';      
            echo '</div>';
            echo '</fieldset>';
        //match di ritorno
        break;
        case 76:
        //Finale

        
        break;
    }
}
?>
    
<?php 
include("../footer.php");
?>