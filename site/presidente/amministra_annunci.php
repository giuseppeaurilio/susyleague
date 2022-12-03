<?php 
include_once ("menu.php");

?>
<script>
cancellaAnnuncio = function(id)
{
    var action ="cancellaannuncio";
    $.ajax({
            type:'POST',
            url:'amministra_annunci_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

salvaAnnuncio= function(){
    
    var date = $("#txtDate").val();
    var titolo = $("#txtTitolo").val();
    var testo = $("#taTesto").val();
    var action ="salvaannuncio";

    var datada = date.split('to')[0];
    var dataa = date.split('to')[1];
    $.ajax({
            type:'POST',
            url:'amministra_annunci_controller.php',
            data: {
                "action": action,
                "titolo": titolo,
                "testo": testo,
                "dateda": datada,
                "datea": dataa,
            },
            success:function(data){
                // debugger;
                modalPopupResult(data);    
            }
    }); 
}
$(document).ready(function(){
    // $("#sq_1").off("change").bind("change", caricagiocatori);
    // $("#sq_2").off("change").bind("change", caricagiocatori);
    $("#btnInvia").off("click").bind("click", salvaAnnuncio);
    // caricaScambi();
})


</script>
<h2>Gestione annunci del presidente</h2>
<div id="divNuovoAnnuncio">
    <h3>Nuovo annuncio</h3>
    <div id="divContentNuovoAnnuncio" >
        <div>
            <div>Titolo</div>
            <input type="text" id="txtTitolo">
        </div>
        <div>
            <div>Testo</div>
            <textarea id="taTesto"></textarea>
        </div>
        <div>
            <div>Visibile</div>
            <input type="text" id="txtDate" placeholder="seleziona una data e ora di inizio e fine.">
        </div>
        <!-- <div>
            <div> al</div>
            <input type="text" id="txtAl" placeholder="seleziona una data...">
        </div> -->
        <div id="actioncontainer">
            <div id="btnInvia" class="buttonaction">Salva</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        flatpickr("#txtDate", {
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            mode:"range",
            time_24hr: true,
        });
    });
</script>
<br/>

<?php
//load annunci
$query="SELECT * FROM annunci order by al";

$result=$conn->query($query);
$annunci = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    
    array_push($annunci, array(
        "id"=>$row["id"],
        "titolo"=>$row["titolo"],
        "testo"=>$row["testo"],
        "dal"=>$row["dal"],
        "al"=>$row["al"]
        )
    );
}
//fine load squadre fantacalcio
?>

<div id="divArchivioAnnunci">
    <h3>Archivio Annunci</h3>
    <div id="divContentArchivioAnnunci">
        <table border="0" cellspacing="2" cellpadding="2">
            <tbody>
                <tr> 
                    <!-- <th>Id</th> -->
                    <th>Titolo</th>
                    <th>Testo</th>
                    <th>Dal</th>
                    <th>Al</th>
                    <th>&nbsp;</th>
                    
                </tr>
                <?php
                foreach($annunci as $annuncio)
                {
                    echo '<tr>';
                    echo '<td>'.$annuncio["titolo"].'</td>';
                    echo '<td>'.$annuncio["testo"].'</td>';
                    echo '<td>'.$annuncio["dal"].'</td>';
                    echo '<td>'.$annuncio["al"].'</td>';
                    echo '<td ><i class="far fa-trash-alt" onclick="javascript:cancellaAnnuncio('.$annuncio["id"].');" style="cursor:pointer"></i></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>        
    </div>
</div>
<?php 
include_once ("../footer.php");
?>
