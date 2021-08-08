<?php 
include("menu.php");

// $id_girone=$_GET['id_girone'];
?>
<script>
cancellaVoti = function()
{
    var idgiornatasa = $("#ddlGiornataSerieA").val();
    var action ="delete";
    // debugger;
    $.ajax({
            type:'POST',
            url:'amministra_voti_controller.php',
            data: {
                "action": action,
                "idgiornatasa": idgiornatasa
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

updateVoto = function()
{
    // debugger;
    var id = $(this).attr("data-id");
    var voto = $("#txtVoto"+ id).val();
    var fantavoto = $("#txtFV"+ id).val();
    var action ="update";
    $.ajax({
            type:'POST',
            url:'amministra_voti_controller.php',
            data: {
                "action": action,
                "id": id,
                "fantavoto": fantavoto,
                "voto": voto,

            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}
getVoti = function()
{
    // var control = $(this);
    var idgiornatasa = $(this).find("option:selected").val();
    $("#hfIdGiornata").val(idgiornatasa);
    var action ="getAll";
    $.ajax({
            type:'POST',
            url:'amministra_voti_controller.php',
            data: {
                "action": action,
                "idgiornatasa": idgiornatasa
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    // debugger;
                    var template = $('#tmplVoti').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // console.log("idsquadra" + idsquadra);
                    // control.parent().find(".resultcontainer").html(rendered);
                    $("#resultcontainer").html(rendered)
                    $(".updateVoto").off("click").bind("click", updateVoto);
                    // debugger;
                    if(resp.voti.length == 0){
                        $("#formUploadVoti").show();
                        $("#divCancellaVoti").hide();
                        }
                    else{
                        $("#formUploadVoti").hide();
                        $("#divCancellaVoti").show();
                        }
                }
                else{
                    alert(resp.error.msg);
                }
                
            }
    }); 
}
var idgiornatasa = "<?php echo $giornata_serie_a_id=isset($_GET['giornata_serie_a_id']) ? $_GET['giornata_serie_a_id']: '' ; ?>";
$(document).ready(function(){
    $("#ddlGiornataSerieA").off("change").bind("change", getVoti);
    $("#divCancellaVoti").off("click").bind("click", cancellaVoti);
   
    $("#formUploadVoti").hide();
    $("#divCancellaVoti").hide();
    // console.log(idgiornatasa);
    if(idgiornatasa != '')
    {
        console.log(idgiornatasa);
        $('#ddlGiornataSerieA').val(idgiornatasa).change();
        
    }
    // $(".updateVoto").off("click").bind("click", updateVoto);
    // $("#btnUploadFile").off("submit").bind("submit", uploadFile);
})
</script>

<script id="tmplVoti" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th style="display:none;">Id</th>
            <th>Id G.</th>
            <th>Nome</th>
            <th>R</th>
            <th>Squadra</th>
            <th>FV</th>
            <th>V</th>
            <th>&nbsp;</th>
        </tr>
        {{#voti}}
            <tr > 
                <td style="display:none;">{{ id }}</td>
                <td>{{ g_id }}</td>
                <td>{{ nome }}</td>
                <td>{{ ruolo }}</td>
                <td>{{ squadra }}</td>
                <td><input type="number" id="txtFV{{ id }}" min="-10" max="30" step="0.5" value="{{ voto }}" style="width: 50px;"></td>
                <td><input type="number" id="txtVoto{{ id }}" min="-10" max="30" step="0.5" value="{{ voto_md }}" style="width: 50px;"></td>
                <td><input type="button" class="updateVoto" data-id="{{ id }}" value="aggiorna"></td>
                
            </tr>
        {{/voti}}
             
    </tbody>
</table>
</script>
<h2>Gestisci Voti</h2>
<?php
include_once("..\DB/serie_a.php");
// include_once("..\DB/fantacalcio.php");
// $giornate = fantacalcio_getGiornate($idgirone);
// $squadre = fantacalcio_getFantasquadre();
$giornatesa = seriea_getGiornate();
echo "<div class=\"actionrow\">";
echo "<select id=\"ddlGiornataSerieA\">";
echo "<option value=\"0\">seleziona giornata di serie a...</option>";
foreach($giornatesa as $giornatasa)
{
    echo "<option value=\"".$giornatasa["id"]."\" ".($giornatasa["id"] == $giornata_serie_a_id ? "selected": "") .">"
    .$giornatasa["descrizione"]." (".$giornatasa["inizio"] .")</option>";
}
echo "</select>";

echo '</div>';
?>
<div class="mainaction" id="divCancellaVoti">
    <a href="#" >Cancella Voti</a>
</div>
<form action="upload_voti.php" method="post" enctype="multipart/form-data" id="formUploadVoti">
    Seleziona il file da inserire:
    <input type="hidden" name="hfIdGiornata" id="hfIdGiornata">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" id="btnUploadFile">
</form>
<div id="resultcontainer"></div>
<?php 
include("../footer.php");
?>
