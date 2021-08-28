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
                    $("#tblGiocatori #txtNome").unbind().bind("keyup", filtraGiocatoriPerNome);
                    $("#tblGiocatori #ruolo").unbind().bind("change", filtraGiocatoriPerRuolo);
                    $("#tblGiocatori #squadra").unbind().bind("change", filtraGiocatoriPerSquadraBreve);
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

filtraGiocatoriPerNome = function()
{
    var filterString = $("#tblGiocatori #txtNome").val().toUpperCase();
    // console.log(filterString);
    $("#tblGiocatori > tbody tr").show()
    if(filterString != "" && filterString.length >= 2)
    {
        $("#tblGiocatori > tbody tr").hide()
        $($("#tblGiocatori > tbody tr")[0]).show()
        $("#tblGiocatori .nome").filter(function() {
            return $(this).html().includes(filterString);
        }).closest('tr').show()
    }
    
}

filtraGiocatoriPerRuolo = function()
{
    // debugger;
    var filterString = $("#tblGiocatori #ruolo").val().toUpperCase();
    // console.log(filterString);
    $("#tblGiocatori > tbody tr").show()
    if(filterString != "" )
    {
        $("#tblGiocatori > tbody tr").hide()
        $($("#tblGiocatori > tbody tr")[0]).show()
        $("#tblGiocatori .ruolo").filter(function() {
            return $(this).html().includes(filterString);
        }).closest('tr').show()
    }
    
}

filtraGiocatoriPerSquadraBreve = function()
{
    // debugger;
    var filterString = $("#tblGiocatori #squadra").val().toUpperCase();
    // console.log(filterString);
    $("#tblGiocatori > tbody tr").show()
    if(filterString != "" )
    {
        $("#tblGiocatori > tbody tr").hide()
        $($("#tblGiocatori > tbody tr")[0]).show()
        $("#tblGiocatori .sq_breve").filter(function() {
            return $(this).html().includes(filterString);
        }).closest('tr').show()
    }
    
}

inserisciVotoufficio = function()
{
    var idgiornatasa = $("#ddlGiornataSerieA").find("option:selected").val();
    var idsquadra = $("#squadravu").find("option:selected").val();

    var action ="inserisciVotoUfficio";
    $.ajax({
            type:'POST',
            url:'amministra_voti_controller.php',
            data: {
                "action": action,
                "idgiornatasa": idgiornatasa,
                "idsquadra": idsquadra,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 

}

var idgiornatasa = "<?php echo $giornata_serie_a_id=isset($_GET['giornata_serie_a_id']) ? $_GET['giornata_serie_a_id']: '' ; ?>";
$(document).ready(function(){
    $("#ddlGiornataSerieA").off("change").bind("change", getVoti);
    $("#divCancellaVoti > a").off("click").bind("click", cancellaVoti);
   
    $("#formUploadVoti").hide();
    $("#divCancellaVoti").hide();
    // console.log(idgiornatasa);
    if(idgiornatasa != '')
    {
        console.log(idgiornatasa);
        $('#ddlGiornataSerieA').val(idgiornatasa).change();
        
    }
    $("#btnInserisciVotoufficio").off("click").bind("click", inserisciVotoufficio);
    // $("#btnUploadFile").off("submit").bind("submit", uploadFile);
})
</script>
<?php
    //load squadre fantacalcio
    $query="SELECT * FROM squadre_serie_a order by squadra";

    $result=$conn->query($query);
    $squadre = array();
    while($row = $result->fetch_assoc()){
        // $id=mysql_result($result,$i,"id");
        // $id=$row["id"];
        // $squadra=$row["squadra"];
        array_push($squadre, array(
            "id"=>$row["id"],
            "squadra_breve"=>$row["squadra_breve"],
            "squadra"=>$row["squadra"]
            )
        );
    }
    //fine load squadre fantacalcio
    ?>
<script id="tmplVoti" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2" id="tblGiocatori">
    <tbody>
        <tr> 
            <th style="display:none;">Id</th>
            <th>Id G.</th>
            <th ><input style="width:140px;" type="text" id="txtNome" placeholder="Nome"></th>
            <th>
                <select name="Ruolo" id="ruolo">
                    <option value="">-R</option>	
                    <option value="P">P</option>
                    <option value="D">D</option>
                    <option value="C">C</option>
                    <option value="A">A</option>
                </select>
            </th>
            <th>
                <?php
                    echo '<select id="squadra" name="squadra">';
                    echo '<option value="">-sq-</option>';
                    foreach($squadre as $squadra)
                    {
                        echo '<option value=' . $squadra["squadra_breve"] . '>'. $squadra["squadra_breve"] . '</option>';
                    }
                    echo '</select>';
                ?>
            </th>
            <th>FV</th>
            <th>V</th>
            <th>&nbsp;</th>
        </tr>
        {{#voti}}
            <tr > 
                <td style="display:none;">{{ id }}</td>
                <td>{{ g_id }}</td>
                <td class="nome" >{{ nome }}</td>
                <td class="ruolo">{{ ruolo }}</td>
                <td class="sq_breve">{{ squadra }}</td>
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
include_once("../DB/serie_a.php");
// include_once("/DB/fantacalcio.php");
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
<div class="" id="divVotiUfficio">
    <span>Inserisci un 6 d'ufficio per la seguente squadra</span>
<?php
    echo '<select id="squadravu" name="squadra">';
    echo '<option value="">-scegli la squadra-</option>';
    foreach($squadre as $squadra)
    {
        echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
    }
    echo '</select>';
?>
<input type="button" class="insertVotoUfficio" value="inserisci voto d'ufficio" id="btnInserisciVotoufficio">
</div>
<hr>
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
