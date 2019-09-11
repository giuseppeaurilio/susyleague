<?php 
include("menu.php");

?>
<script>

caricagiocatori = function()
{
    var idsquadra = $(this).find("option:selected").val();

    alert(idsquadra);
}
$(document).ready(function(){
    $("#sq_1").off("change").bind("change", caricagiocatori);
    $("#sq_2").off("change").bind("change", caricagiocatori);
})


</script>
<?php
//load squadre fantacalcio
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
//fine load squadre fantacalcio
?>
<h2>Gestione Scambi</h2>
<div id="divNuovoScambio">
    <h3>Nuovo Scambio</h3>
    <div id="divContentNuovoScambio">
        <div id="dvdsq1">
        <?php
            echo '<select id="sq_1" name="squadra_fantacalcio_1">';
            echo '<option value="">--seleziona Squadra1--</option>';
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
        ?>
        </div>
        <div id="dvdgiocatorisq1">
        </div>
    </div>
</div>
<div id="divArchivioScambi">
    <h3>Archivio Scambi</h3>
    <div id="divContentArchivioScambi">
    </div>
</div>
<?php 
include("../footer.php");
?>
