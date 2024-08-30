<?php 
include("menu.php");

?>
<script>
caricaFusti = function()
{
    var action ="get";
    $.ajax({
            type:'POST',
            url:'amministra_fustometro_controller.php',
            data: {
                "action": action,
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
            <th>Conferma</th>
            <th>Annulla</th>
        </tr>
        {{#scambi}}
            <tr > 
                <td>{{ Id }}</td>
                <td>{{ DataUm }}</td>
                <td>{{ Presidente }}</td>
                <td>{{ Motivazione }}</td>
                <td>{{ Stato }}</td>
                <td></td>
                <td></td>
            </tr>
        {{/scambi}}
             
    </tbody>
</table>
</script>
<h2>Gestione Contafusti</h2>
<div id="divNuovoFusto">
<h3> Nuovo Fusto<h3>
<div id="divContentNuovoFusto" >
</div>
</div>
<div id="divArchivioFusti">
    <h3> Elenco Fusti </h3>
    <div id="divContentArchivioFusti">
    </div>
</div>
<?php 
include("../footer.php");
?>
