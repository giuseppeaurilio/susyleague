<?php 
include("menu.php");

?>
<script>


salvaAnnuncio= function(){
    var DataDal = $("txtDate").val();
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
    $("#btnInvia").off("click").bind("click", salvaAnnuncio);
    // caricaScambi();
})


</script>

<?php
//load squadre fantacalcio
$query="SELECT * FROM annunci order by al";

$result=$conn->query($query);
$annunci = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    
    array_push($annunci, array(
        "id"=>$row["id"],
        "titolo"=>$row["titolo"],
        "dal"=>$row["dal"],
        "al"=>$row["al"]
        )
    );
}
//fine load squadre fantacalcio
?>
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
            <textarea id="tstarTesto"></textarea>
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
        flatpickr("#txtDal", {
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            mode:"range",
            time_24hr: true,
        });
        // flatpickr("#txtAl", {
        //     enableTime: true,
        //     dateFormat: "d-m-Y H:i",
        // });
    });
</script>
<br/>
<div id="divArchivioAnnunci">
    <h3>Archivio Annunci</h3>
    <div id="divContentArchivioAnnunci">
        <table border="0" cellspacing="2" cellpadding="2">
            <tbody>
                <tr> 
                    <th>Id</th>
                    <th>Titolo</th>
                    <th>Testo</th>
                    <th>Dal</th>
                    <th>Al</th>
                    <th>&nbsp;</th>
                    
                </tr>
            </tbody>
        </table>        
    </div>
</div>
<?php 
include("../footer.php");
?>
