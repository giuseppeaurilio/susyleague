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
                    $("#divContentArchivioScambi").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
                
                
            }
    }); 
}
</script>

<h2>Gestione Contafusti</h2>
<h3> Nuovo Fusto<h3>
<div id="divArchivioFusti">
    <h3> Elenco Fusti </h3>
    <div id="divContentArchivioFusti">
    </div>
</div>
<?php 
include("../footer.php");
?>
