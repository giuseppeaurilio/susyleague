<?php 
include("menu.php");

?>
<script>
confermaFusto = function(id)
{
    //alert("conferma " +id);
    aggiornaFusto(id, 1);
}

annullaFusto = function(id)
{
    // alert("annulla " +id);
    aggiornaFusto(id, 2);
}

aggiornaFusto= function(id, stato)
{
    var action ="aggiorna";
    $.ajax({
            type:'POST',
            url:'amministra_fustometro_controller.php',
            data: {
                "action": action,
                "id": id,
                "stato": stato,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   var  buttons= [
                                {
                                text: "Ok",
                                // icon: "ui-icon-heart",
                                click: function() {
                                        window.location.reload();
                                    }
                                }
                            ]
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "Info");
                    $( "#dialog p" ).html("Operazione eseguita.");
                    $( "#dialog" ).dialog({modal:true, buttons: buttons});
                    // resp.result => "Login eseguito",
                }
                else{
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
    }); 
}

nuovoFusto = function()
{
    var action ="nuovo";
    var presidente = $("#presidente").val();
    var motivazione = $("#motivazione").val();
    var stato = $("#stato").find("option:selected").val();

    var message = ""
    if(presidente == null || presidente == "")
            message = 'selezionare un presidente';
    if(stato == null || stato == "")
            message = 'selezionare uno stato';
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }

    $.ajax({
            type:'POST',
            url:'amministra_fustometro_controller.php',
            data: {
                "action": action,
                "presidente": presidente,
                "motivazione": motivazione,
                "stato": stato,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   var  buttons= [
                                {
                                text: "Ok",
                                // icon: "ui-icon-heart",
                                click: function() {
                                        window.location.reload();
                                    }
                                }
                            ]
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "Info");
                    $( "#dialog p" ).html("Operazione eseguita.");
                    $( "#dialog" ).dialog({modal:true, buttons: buttons});
                    // resp.result => "Login eseguito",
                }
                else{
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
    }); 
}

caricaFusti = function()
{
    var action ="get";
    var stato =$("#statoget").find("option:selected").val();
    $.ajax({
            type:'POST',
            url:'amministra_fustometro_controller.php',
            data: {
                "action": action,
                "stato": stato
            },
            success:function(data){
                // console.log("data " + data);
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    var template = $('#tmplFusti').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // console.log("idsquadra" + idsquadra);
                    $("#divContentArchivioFusti").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
            }
    }); 
}

$(document).ready(function(){
    caricaFusti();
})
</script>

<script id="tmplFusti" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th>Id</th>
            <th>Data</th>
            <th>Presidente</th>
            <th>Motivazione</th>
            <th>Stato</th>
            <th></th>
            <th></th>
        </tr>
        {{#fusti}}
            <tr > 
                <td>{{ Id }}</td>
                <td>{{ DataUM }}</td>
                <td>{{ Presidente }}</td>
                <td>{{ Motivazione }}</td>
                <td>{{ Stato }}</td>
                <td><input type="button" value="Conferma" onclick="confermaFusto({{ Id }})"></td>
                <td><input type="button" value="Annulla" onclick="annullaFusto({{ Id }})"></td>
            </tr>
        {{/fusti}}
             
    </tbody>
</table>
</script>

<h2>Gestione Contafusti</h2>
<div id="divNuovoFusto">
<h3> Nuovo Fusto</h3>
    <div id="divContentNuovoFusto" >
        Presidente:<input type="text" id="presidente" name="nome" size="15"><br>
        Motivazione:<input type="text" id="motivazione" name="nome" size="50"><br>
        Stato:<select name="stato" id="stato">
            <option value="">--Scegli--</option>	
            <option value="0">in preparazione</option>
            <option value="1">confermato</option>
        
        </select>
        <br>
        <input type="button" value="Inserisci" onclick="nuovoFusto()">
    </div>
</div>
<hr>
<div id="divArchivioFusti">
    <h3> Elenco Fusti 
    <select name="statoget" id="statoget">
            <option value="">--tutti--</option>	
            <option value="0">in preparazione</option>
            <option value="1">confermato</option>
        
        </select>
    </h3>
    
    <div id="divContentArchivioFusti">
    </div>
</div>
<?php 
include("../footer.php");
?>
