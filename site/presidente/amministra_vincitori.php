<?php 
include_once ("menu.php");

?>
<script>
aggiungiVincitore = function()
{
    
    var idCompetizione = $( "#competizioneget option:selected" ).val();
    var competizione = $( "#competizioneget option:selected" ).val() == 0 ? $("#txtAltraCompetizione").val() : $( "#competizioneget option:selected" ).text();
    var posizione = $( "#posizioneget option:selected" ).val();
    var idSquadra = $( "#squadraget option:selected" ).val();
    var message = ""
    if(message == "" && competizione== "" )
        message = 'seleziona una competizione';
    if(message == "" && idSquadra== "" )
        message = 'seleziona una squadra';
    if(message == "" && posizione== "" )
        message = 'seleziona una posizione';

    
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }


    var action ="aggiungi";
    $.ajax({
            type:'POST',
            url:'amministra_vincitori_controller.php',
            data: {
                "action": action,
                "idCompetizione": idCompetizione,
                "competizione": competizione,
                "posizione": posizione,
                "idSquadra": idSquadra,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

cancellaVincitore = function(id)
{
    //alert("conferma " +id);
    var action ="cancella";
    $.ajax({
            type:'POST',
            url:'amministra_vincitori_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

caricaVincitori = function()
{
    var action ="carica";
    $.ajax({
            type:'POST',
            // dataType: "json",
            // contentType: "application/json; charset=ISO-8859-1",
            url:'amministra_vincitori_controller.php',
            data: {
                "action": action
            },
            success:function(data){
                
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    var template = $('#tmplVincitori').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // console.log("idsquadra" + idsquadra);
                    $("#divContentArchivioVincitori").html(rendered);
                }
                else{
                    alert(resp.error.msg);
                }
            }
    }); 
}
function inizializzaControlli(){
    $("#txtAltraCompetizione").hide()
    $('#competizioneget').change(function() {
        var idv = $( "#competizioneget option:selected" ).val();        
        if(idv == "0")
        {$("#txtAltraCompetizione").show();}
        else
        {$("#txtAltraCompetizione").hide();}
    });
}
$(document).ready(function(){
    inizializzaControlli();
    caricaVincitori();

})
</script>
<?php
//load squadre fantacalcio
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
include_once ("../DB/fantacalcio.php");
$squadre = fantacalcio_getFantasquadre();
//fine load squadre fantacalcio
?>

<?php
//load competizioni
$query="SELECT * FROM gironi order by id_girone";

$result=$conn->query($query);
$competizioni = array();
while($row = $result->fetch_assoc()){
    array_push($competizioni, array(
        "id_girone"=>$row["id_girone"],
        "nome"=>$row["nome"]
        )
    );
}
//fine load squadre fantacalcio
?>

<script id="tmplVincitori" type="x-tmpl-mustache">
    
<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th>Id</th>
            <th>Competizione</th>
            <th>Posizione</th>
            <th>Squadra</th>
            <th>Allenatore</th>
            <th></th>
        </tr>
        {{#vincitori}}
            <tr > 
                <td>{{ id }}</td>
                <td>{{ descc }}</td>
                <td>{{ pos }}</td>
                <td>{{ squadra }}</td>
                <td>{{ allenatore }}</td>
                <td><input type="button" value="cancella" onclick="cancellaVincitore({{ id }})"></td>
            </tr>
        {{/vincitori}}
             
    </tbody>
</table>
</script>

<h2>Gestione Vincitori</h2>
<div id="divNuovoVincitore">
<h3> Inserisci vincitore</h3>
    <div id="divContentNuovoVincitore" >
        Competizione:
        <select name="competizioneget" id="competizioneget">
            <option value="">--scegli--</option>	
            <?php 
            foreach($competizioni as $competizione)
            {
                echo '<option value=' . $competizione["id_girone"] . '>'. $competizione["nome"] . '</option>';
            }
            echo '<option value="0">Altro</option>';
            ?>
        </select>
        <input type="text" id="txtAltraCompetizione" name="nome" size="15">
        
        Squadra:
        <select name="Squadraget" id="squadraget">
            <option value="">--scegli--</option>	
            <?php 
            foreach($squadre as $squadra)
            {
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
            // echo '<option value="0">Altro</option>';
            ?>
        </select>
        
        Posizione:
        <select name="posizioneget" id="posizioneget">
            <option value="">--scegli--</option>	
            <option value="1">Primo</option>
            <option value="2">Secondo</option>
            <option value="3">Terzo</option>
        </select>
        <br>
        <input type="button" value="Inserisci" onclick="aggiungiVincitore()">
    </div>
</div>
<hr>
<div id="divArchivioVincitori">
    <h3> Elenco Vincitori 
    </h3>
    
    <div id="divContentArchivioVincitori">
    </div>
</div>
<?php 
include_once ("../footer.php");
?>
