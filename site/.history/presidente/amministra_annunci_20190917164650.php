<?php 
include("menu.php");

?>
<script>


doScambio= function(){
    // var giocatori1 = $("#divGiocatoriSq1 table input[type=checkbox]:checked");
    // var giocatori2 = $("#divGiocatoriSq2 table input[type=checkbox]:checked");
    // var idsquadra1 = $("#sq_1").find("option:selected").val();
    // var idsquadra2 = $("#sq_2").find("option:selected").val();

    // var note = $("textarea").val();
    // var arr1 = [];
    // $(giocatori1).each(function(index){
    //     // console.log( index + ": " + $( this ).val() );
    //     arr1.push( $( this ).val());
    // })
    // var arr2 = [];
    // $(giocatori2).each(function(index){
    //     // console.log( index + ": " + $( this ).val() );
    //     arr2.push( $( this ).val());
    // })
    // var message = ""
    // if(idsquadra1 == null || idsquadra1 == "")
    //         message = 'selezionare la squadra 1';
    // if(message == "" && (idsquadra2 == null || idsquadra2 == ""))
    //     message = 'selezionare la squadra 2';
    // if(message == "" && idsquadra1== idsquadra2 )
    //     message = 'le due squadre devono essere diverse';
    
    
    // if (message != "")
    // {
    //     // alert (message);
    //     $( "#dialog" ).prop('title', "ERROR");                
    //     $( "#dialog p" ).html(message);
    //     $( "#dialog" ).dialog({modal:true});
    //     return false;
    // }
    // // console.log(idsquadra1);
    // // console.log(arr1);
    // // console.log(idsquadra2);
    // // console.log(arr2);
    // // console.log(note);
    // var action ="doscambio";
    // $.ajax({
    //         type:'POST',
    //         url:'amministra_scambi_controller.php',
    //         data: {
    //             "action": action,
    //             "idsquadra1": idsquadra1,
    //             "arr1": arr1,
    //             "idsquadra2": idsquadra2,
    //             "arr2": arr2,
    //             "note": note,
    //         },
    //         success:function(data){
    //             // debugger;
    //             var resp=$.parseJSON(data)
    //             if(resp.result == "true"){
    //                var  buttons= [
    //                             {
    //                             text: "Ok",
    //                             // icon: "ui-icon-heart",
    //                             click: function() {
    //                                     window.location.reload();
    //                                 }
    //                             }
    //                         ]
    //                 // $( "#dialog" ).dialog('destroy');
    //                 $( "#dialog" ).prop('title', "Info");
    //                 $( "#dialog p" ).html("Operazione eseguita.");
    //                 $( "#dialog" ).dialog({modal:true, buttons: buttons});
    //                 // resp.result => "Login eseguito",
    //             }
    //             else{
    //                 // $( "#dialog" ).dialog('destroy');
    //                 $( "#dialog" ).prop('title', "ERROR");                
    //                 $( "#dialog p" ).html(resp.error.msg);
    //                 $( "#dialog" ).dialog({modal:true});
    //             }
                
                
    //         }
    // }); 
}
$(document).ready(function(){
    // $("#sq_1").off("change").bind("change", caricagiocatori);
    // $("#sq_2").off("change").bind("change", caricagiocatori);
    // $("#btnScambio").off("click").bind("click", doScambio);
    // caricaScambi();
})


</script>

<?php
//load squadre fantacalcio
$query="SELECT * FROM annunci order by al";

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
    <div id="divContentNuovoScambio" >
        <div id="divsq1" class="grid-item">
        <?php
            echo '<select id="sq_1" name="squadra_fantacalcio_1">';
            echo '<option value="">--seleziona Squadra1--</option>';
            foreach($squadre as $squadra)
            {
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
            echo '</select>';
        ?>
        
        <div id="divGiocatoriSq1" class="resultcontainer">
        </div>
        </div>
        <div id="divsq2" class="grid-item">
        <?php
            echo '<select id="sq_2" name="squadra_fantacalcio_2">';
            echo '<option value="">--seleziona Squadra2--</option>';
            foreach($squadre as $squadra)
            {
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
            echo '</select>';
        ?>
        
            <div id="divGiocatoriSq2" class="resultcontainer">
            </div>
        </div>
        <div id="scambioStep3" class="grid-item"> 
            <div>Note:</div>
            <textarea name="note" rows="10" cols="30" id="txt_note"></textarea>
            <div id="btnScambio" class="mainaction"><a href="#">Salva</a></div>
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
