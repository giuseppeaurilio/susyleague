<?php 
include_once ("menu.php");

?>
<script>

var astaincorso = false;
listacompleta = function()
{
    var action ="listacompleta";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                // "id": id,
            },
            success:function(data){
               // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    if(resp.giocatori.length> 0){
                        var template = $('#tmpllistacompleta').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp);
                        $("#divlistacompleta").html(rendered);
                    }
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
            }
    }); 
}


$(document).ready(function(){
    listacompleta();
})
</script>

<script id="tmpllistacompleta" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr>
            
            <th>Giocatore</th>
            <th>SQ</th>
            <th>R</th>
            <th>€</th>
            <th>FSQ</th>
            <th>ORD</th>
        </tr>
        {{#giocatori}}
            <tr > 
                
                <td>{{ nome }}</td>
                <td>{{ squadra_breve }}</td>
                <td>{{ ruolo }}</td>
                <td>{{ costo }}</td>
                <td>{{ fantasquadra }}</td>
                <td>{{ chiamata }}</td>
            </tr>
        {{/giocatori}}
                
    </tbody>
</table>
</script>

<h2>Registro acquisti</h2>
<div class="maincontent">
    <div id="divlistacompleta">
    </div>
</div>
<?php 
include_once ("footer.php");
?>
