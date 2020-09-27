<?php 
include("menu.php");

?>
<script>
var noimage = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
imgError = function(img){
	img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
};
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
            <th>&nbsp;</th>
            <th>Giocatore</th>
            <th>SQ</th>
            <th>R</th>
            <th>€</th>
            <th>FSQ</th>
            <th>ORD</th>
        </tr>
        {{#giocatori}}
            <tr > 
                <td> <img src='{{ imgurl }}' onerror='imgError(this);'> </img> </td>
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
include("footer.php");
?>
