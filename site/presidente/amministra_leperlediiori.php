<?php 
include("menu.php");

?>
<script>
eliminaPerla = function(id ){
    var action ="elimina";
    $.ajax({
            type:'POST',
            url:'amministra_leperlediiori_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

nuovaPerla = function()
{
    var action ="nuovo";
    var testo = $("#txtNuovaPerla").val();
    
    var message = ""
    // if(presidente == null || presidente == "")
    //         message = 'selezionare un presidente';
    // if(stato == null || stato == "")
    //         message = 'selezionare uno stato';
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
            url:'amministra_leperlediiori_controller.php',
            data: {
                "action": action,
                "testo": testo,
            },
            success:function(data){
               modalPopupResult(data); 
            }
    }); 
}

caricaPerle = function()
{
    var action ="get";
    $.ajax({
            type:'POST',
            url:'amministra_leperlediiori_controller.php',
            data: {
                "action": action,
            },
            success:function(data){
                // console.log("data " + data);
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    var template = $('#tmplPerle').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // console.log("idsquadra" + idsquadra);
                    $("#divContentArchivioPerle").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
            }
    }); 
}

$(document).ready(function(){
    // $("#statoget").off("change").bind("change", caricaPerle);
    caricaPerle();
})
</script>

<script id="tmplPerle" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th>Id</th>
            <th>Data</th>
            <th>Testo</th>
            <th></th>
            <th></th>
        </tr>
        {{#fusti}}
            <tr > 
                <td>{{ Id }}</td>
                <td>{{ Data }}</td>
                <td>{{ Testo }}</td>                
                <td><input type="button" value="Elimina" onclick="eliminaPerla({{ Id }})"></td>
            </tr>
        {{/fusti}}
             
    </tbody>
</table>
</script>

<h2>Le perle di Iori</h2>
<div id="divNuovaPerla">
<h3> Nuova Perla</h3>
    <div id="divContentNuovaPerla" >
        Testo:<textarea name="note" rows="10" cols="30"  id="txtNuovaPerla" name="nuovaperla" ></textarea>
        <input type="button" value="Inserisci" onclick="nuovaPerla()">
    </div>
</div>
<hr>
<div id="divArchivioPerle">
    <h3> Elenco Perle 
    </h3>
    
    <div id="divContentArchivioPerle">
    </div>
</div>
<?php 
include("../footer.php");
?>
