<?php 
include_once ("menu.php");

?>
<script>

caricagiocatori = function()
{
    var control = $(this);
    var idsquadra = $(this).find("option:selected").val();
    var action ="loadrosa";
    $.ajax({
            type:'POST',
            url:'amministra_scambi_controller.php',
            data: {
                "action": action,
                "idsquadra": idsquadra
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                //     alert(resp.giocatori);
                //    $("#divGiocatoriSq1").html(resp.giocatori + "");
                var template = $('#tmplRosa').html();
                Mustache.parse(template);   // optional, speeds up future uses
                var rendered = Mustache.render(template, resp);
                // console.log("idsquadra" + idsquadra);
                control.parent().find(".resultcontainer").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
                
                
            }
    }); 
}

caricaScambi = function()
{
    var action ="getscambi";
    $.ajax({
            type:'POST',
            url:'amministra_scambi_controller.php',
            data: {
                "action": action,
            },
            success:function(data){
                // console.log("data " + data);
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    var template = $('#tmplScambi').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // console.log("idsquadra" + idsquadra);
                    $("#divContentArchivioScambi").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
                
                
            }
    }); 
}

doScambio= function(){
    var giocatori1 = $("#divGiocatoriSq1 table input[type=checkbox]:checked");
    var giocatori2 = $("#divGiocatoriSq2 table input[type=checkbox]:checked");
    var idsquadra1 = $("#sq_1").find("option:selected").val();
    var idsquadra2 = $("#sq_2").find("option:selected").val();

    var note = $("textarea").val();
    var arr1 = [];
    $(giocatori1).each(function(index){
        // console.log( index + ": " + $( this ).val() );
        arr1.push( $( this ).val());
    })
    var arr2 = [];
    $(giocatori2).each(function(index){
        // console.log( index + ": " + $( this ).val() );
        arr2.push( $( this ).val());
    })
    var message = ""
    if(idsquadra1 == null || idsquadra1 == "")
            message = 'selezionare la squadra 1';
    if(message == "" && (idsquadra2 == null || idsquadra2 == ""))
        message = 'selezionare la squadra 2';
    if(message == "" && idsquadra1== idsquadra2 )
        message = 'le due squadre devono essere diverse';
    
    
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }
    // console.log(idsquadra1);
    // console.log(arr1);
    // console.log(idsquadra2);
    // console.log(arr2);
    // console.log(note);
    var action ="doscambio";
    $.ajax({
            type:'POST',
            url:'amministra_scambi_controller.php',
            data: {
                "action": action,
                "idsquadra1": idsquadra1,
                "arr1": arr1,
                "idsquadra2": idsquadra2,
                "arr2": arr2,
                "note": note,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}
$(document).ready(function(){
    $("#sq_1").off("change").bind("change", caricagiocatori);
    $("#sq_2").off("change").bind("change", caricagiocatori);
    $("#btnScambio").off("click").bind("click", doScambio);
    caricaScambi();
})


</script>

<script id="tmplRosa" type="x-tmpl-mustache">
    
    <table border="0" cellspacing="2" cellpadding="2">
        <tbody>
            <tr> 
                <th class="nome">Nome</th>
                <th>Squadra</th>
                <th>Ruolo</th>
                <th>&nbsp;</th>
            </tr>
            {{#giocatori}}
            {{#ispor}}
            <tr style="background-color: #66CC33"> 
            {{/ispor}}
            {{#isdif}}
            <tr style="background-color: #33CCCC"> 
            {{/isdif}}
            {{#iscen}}
            <tr style="background-color: #FFEF00"> 
            {{/iscen}}
            {{#isatt}}
            <tr style="background-color: #E80000"> 
            {{/isatt}}
                <td>{{ nome }}</td>
                <td>{{ squadra_breve }}</td>
                <td>{{ ruolo }}</td>
                <td><input type="checkbox" value="{{ id }}"></td>
            </tr>
            {{/giocatori}}
             
    </tbody>
</table>
</script>

<script id="tmplScambi" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th>Id</th>
            <th>Data</th>
            <th>Nome</th>
            <th>Ruolo</th>
            <th>Squadra</th>
            <th>Origine</th>
            <th>Destinazione</th>
            <th>Note</th>
        </tr>
        {{#scambi}}
            <tr > 
                <td>{{ id }}</td>
                <td>{{ data }}</td>
                <td>{{ nome }}</td>
                <td>{{ ruolo }}</td>
                <td>{{ squadra_breve }}</td>
                <td>{{ sqorigine }}</td>
                <td>{{ sqdestinazione }}</td>
                <td>{{ note }}</td>
            </tr>
        {{/scambi}}
             
    </tbody>
</table>
</script>
<?php
// //load squadre fantacalcio
// $query="SELECT * FROM sq_fantacalcio order by squadra";

// $result=$conn->query($query);
// $squadre = array();
// while($row = $result->fetch_assoc()){
//     // $id=mysql_result($result,$i,"id");
//     $id=$row["id"];
//     $squadra=$row["squadra"];
//     array_push($squadre, array(
//         "id"=>$id,
//         "squadra"=>$squadra
//         )
//     );
// }
// //fine load squadre fantacalcio
include_once("../DB/fantacalcio.php");
$squadre = fantacalcio_getFantasquadre();
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
include_once ("../footer.php");
?>
