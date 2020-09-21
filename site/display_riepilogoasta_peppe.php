<?php 
include("menu.php");

?>
<script>
var noimage = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/no-campioncino.png";
imgError = function(img){
	img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/no-campioncino.png";
};
var astaincorso = false;
ricercaGiocatore = function(id)
{
    var action ="ricercagiocatore";
    ruolo = $("#ruolo").val();
    idsquadra = $("#squadra").val();
    mediavoto = $("#txtMediaVoto").val();
    fantamedia = $("#txtFantamedia").val();
    titolarita = $("#titolarita").val();
    rigori = $("#rigori").val();
    punizioni = $("#punizioni").val();
    ia = $("#txtIA").val();
    ip = $("#txtIP").val();
    
    
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "ruolo": ruolo,
                "idsquadra": idsquadra,
                // "mediavoto": mediavoto,
                // "fantamedia": fantamedia,
                "titolarita": titolarita,
                "rigori": rigori,
                "punizioni": punizioni,
                "ia": ia,
                "ip": ip,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    //show data
                    var template = $('#tmplListaGiocatoriDisponibili').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    $("#divGiocatori").html(rendered);
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
            }
    }); 
}

loadSquadra = function(id)
{
    var action ="loadsqadra";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": 1, //idsquadrapeppe
            },
            success:function(data){
                var resp=$.parseJSON(data)
                
                    if(resp.result == "true"){
                        if(resp.giocatori.length> 0){
                            //show data
                            var template = $('#tmplListaGiocatoriSquadra').html();
                            Mustache.parse(template);   // optional, speeds up future uses
                            var rendered = Mustache.render(template, resp);
                            $("#divSquadra").html(rendered);
                        }
                    }
                }
                // else{
                //     $( "#dialog" ).prop('title', "ERROR");                
                //     $( "#dialog p" ).html(resp.error.msg);
                //     $( "#dialog" ).dialog({modal:true});
                // }
            // }
    }); 
}

loadPInfo = function(id)
{
    // debugger;
    var action ="loadpinfo";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    if(resp.giocatori.length> 0){
                        //show data
                        var template = $('#tmplPInfo').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divPInfo").html(rendered);
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

loadStats = function(id)
{
    // debugger;
    var action ="stats";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    if(resp.stats.length> 0){
                        //show data
                        var template = $('#tmplStats').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp);
                        $("#divStats").html(rendered);
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

loadAstaInCorso = function()
{
    var action ="astaincorso";
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
                        //show data
                        var template = $('#tmplAstaInCorso').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divAstaAttuale").html(rendered);
                        astaincorso = true;
                        loadStats(resp.giocatori[0]["id"]);
                        loadPInfo(resp.giocatori[0]["id"]);
                    }
                    else{
                        var giocatore = {nome: "Nessuna giocatore in asta", ruolo: "-", imgurl: noimage, squadra_breve: "--"}
                        //
                        resp.giocatori.push(giocatore);
                        var template = $('#tmplAstaInCorso').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divAstaAttuale").html(rendered);
                        
                        if(astaincorso == true)
                        {
                            location.reload();
                        }
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
resetFiltri = function()
{
    $("#ruolo").val("");
    $("#squadra").val("");
    $("#titolarita").val("");
    $("#rigori").val("");
    $("#punizioni").val("");
    $("#txtMediaVoto").val("");
    $("#txtFantamedia").val("");
    $("#txtIA").val("");
    $("#txtIP").val("");
}
$(document).ready(function(){
    loadAstaInCorso();
    loadSquadra();
    ricercaGiocatore();
    $("#btnCerca").unbind().bind("click",ricercaGiocatore);
    $("#btnResetFiltri").unbind().bind("click",resetFiltri);
    window.setInterval(function(){
        // loadUltimoGiocatore();
        loadAstaInCorso();
     }, 5000);
})

$(document).on({
    ajaxStart: function() { 
        $("body").removeClass("loading");
    },
});

</script>

<script id="tmplAstaInCorso" type="x-tmpl-mustache">  
<div>
    <h3> Adesso in asta</h3>
    <div class="widgetastacontent incorso" data-id="{{ id }}">
        <div class="left">
            <img src='{{ imgurl }}' onerror='imgError(this);'> </img> 
        </div>
        <div  class="right">
            <div class="nome"> {{ nome }} ({{ squadra_breve }})</div>
            <div class="ruolo"> Ruolo: {{ ruolo }} </div>
        </div>
    </div>
</div>
</script>

<script id="tmplStats" type="x-tmpl-mustache">
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center; width:100%">
        <tr><th>anno</th><th>pg</th><th>mv</th><th>mf</th><th>gf</th><th>gs</th><th>rp</th><th>rc</th><th>r+</th><th>r-</th><th>as</th><th>am</th><th>es</th><th>au</th></tr>
        {{#stats}}
        <tr>
            <td>{{anno}}</td>
            <td>{{pg}}</td>
            <td>{{mv}}</td>
            <td>{{mf}}</td>
            <td>{{gf}}</td>
            <td>{{gs}}</td>
            <td>{{rp}}</td>
            <td>{{rc}}</td>
            <td>{{r+}}</td>
            <td>{{r-}}</td>
            <td>{{ass}}</td>
            <td>{{amm}}</td>
            <td>{{esp}}</td>
            <td>{{au}}</td>
        </tr>
        {{/stats}}
    </table >
</table>
</script>

<script id="tmplPInfo" type="x-tmpl-mustache">
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr><th>Quo</th><th>Tit</th><th>cr</th><th>cp</th><th>ca</th><th>val</th><th>ia</th><th>ip</th></tr>
        <tr><td>{{quotazione}}</td>
        <td>{{titolarita}}</td>
        <td>{{cr}}</td>
        <td>{{cp}}</td>
        <td>{{ca}}</td>
        <td>{{val}}</td>
        <td>{{ia}}</td>
        <td>{{ip}}</td>
    </table >
</table>
</script>

<script id="tmplListaGiocatoriSquadra" type="x-tmpl-mustache">
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr><th>Nome</th><th>Squadra</th><th>Ruolo</th><th>Costo</th><th>chiamata</th></tr>
        {{ #giocatori }}
        <tr><td>{{nome}}</td><td>{{ruolo}}</td><td>{{squadra_breve}}</td><td>{{costo}}</td><td>{{chiamata}}</td></tr>
        {{ /giocatori }}
    </table >
</table>
</script>

<script id="tmplListaGiocatoriDisponibili" type="x-tmpl-mustache">
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr><th>Nome</th><th>Squadra</th><th>Ruolo</th><th>Quo</th><th>Tit</th><th>cr</th><th>cp</th><th>ca</th><th>val</th><th>ia</th><th>ip</th></tr>
        {{ #giocatori }}
        <tr><td>{{nome}}</td><td>{{squadra_breve}}</td><td>{{ruolo}}</td><td>{{quotazione}}</td>
        <td>{{titolarita}}</td>
        <td>{{cr}}</td>
        <td>{{cp}}</td>
        <td>{{ca}}</td>
        <td>{{val}}</td>
        <td>{{ia}}</td>
        <td>{{ip}}</td>
        </tr>
        {{ /giocatori }}
    </table >
</table>
</script>


<h2>ASTA Peppe</h2>
<div class="maincontent" style="min-height: auto;">
    <div class="rigacompleta" id="divAdessoInAsta">
        <div class="widgetasta " id="divAstaAttuale">

        </div>
        <div style="width:65%">
            <div class=" stats" id="divStats">

            </div>
            <div class="pinfo" id="divPInfo">

            </div>
        </div>
    </div>
    <?php
    //load squadre fantacalcio
    $query="SELECT * FROM squadre_serie_a order by squadra";

    $result=$conn->query($query);
    $squadre = array();
    while($row = $result->fetch_assoc()){
        // $id=mysql_result($result,$i,"id");
        $id=$row["id"];
        $squadra=$row["squadra"];
        array_push($squadre, array(
            "id"=>$id,
            "squadra"=>$squadra
            )
        );
    }
    //fine load squadre fantacalcio
    ?>
    <div class="" id="divFiltri" style="width:100%; text-align:center;">
        <!-- <div style="width:100%"> -->
            <h3 style="text-align:center">Filtri</h3>
            <select name="Ruolo" id="ruolo">
                <option value="">--Ruolo--</option>	
                <option value="P">Portiere</option>
                <option value="D">Difensore</option>
                <option value="C">Centrocampista</option>
                <option value="A">Attaccante</option>
            </select>
            <?php
                echo '<select id="squadra" name="squadra">';
                echo '<option value="">--squadra--</option>';
                foreach($squadre as $squadra)
                {
                    echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
                }
                echo '</select>';
            ?>
            <input type="number" id="txtMediaVoto" min="0" max="10" step="0.1" placeholder="Media Voto">
            <input type="number"  id="txtFantamedia" min="0" max="20" step="0.1" placeholder="Fantamedia">
            <select name="ruolo" id="titolarita">
                <option value="">--Titolarità--</option>	
                <option value="10">10</option>
                <option value="9">9</option>
                <option value="8">8</option>
                <option value="7">7</option>
                <option value="6">6</option>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <select name="rigori" id="rigori">
                <option value="">--Rigorista--</option>	
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <select name="punizioni" id="punizioni">
                <option value="">--Punizioni--</option>	
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <input type="number" id="txtIA" min="0" max="200" step="1" placeholder="Indice A">
            <input type="number" id="txtIP" min="0" max="200" step="1" placeholder="Indice P">
            <input type="button" value="cerca" id="btnCerca">
            <input type="button" value="reset" id="btnResetFiltri">
        <!-- </div>     -->
    
    </div>
    <div class="rigacompleta">
        
        <div class="listaGiocatori" style="">
            <h3 style="text-align:center">Giocatori disponibili</h3>
            <div id="divGiocatori"></div>
        </div>
        <div class="space" style="width:2%">
        </div>
        <div class="squadraAttuale" style="width:48%">
            <h3 style="text-align:center">I NANI</h3>
            <?php
                include_once ("DB/asta.php");
                include_once "DB/parametri.php";
                $idsquadra = 1;
                $rimanenti = getMilioniRimanenti($idsquadra);
                $offertamassima = getOffertaMassima($idsquadra);
                $numjollyscelti = hasJolly($idsquadra);
                $riepilogo = getRiepilogoAsta($idsquadra);
                echo "<div style='flex-flow: row;display: flex; flex-wrap: wrap; width: 100%;'> 
                <div style='padding: 3px 10px;'>Offerta massima: 
                <span style='border: solid 1px red; background-color:chocolate; padding: 0 5px;'>$offertamassima<span></div>";
                foreach($riepilogo["giocatori"] as $row){
                    switch($row["ruolo"])
                    {
                        case "P":
                            echo '<div style="padding: 3px 7px;">Por: '.$row["numero"]. ' ('.$row["costo"].')</div>';
                        break;
                        case "D":
                            echo '<div style="padding: 3px 7px;">Dif: '.$row["numero"]. ' ('.$row["costo"].')</div>';
                        break;
                        case "C":
                            echo '<div style="padding: 3px 7px;">Cen: '.$row["numero"]. ' ('.$row["costo"].')</div>';
                        break;
                        case "A":
                            echo '<div style="padding: 3px 7px;">Att: '.$row["numero"]. ' ('.$row["costo"].')</div>';
                        break;
                    }
                }
                echo "</div>"
            ?>
            
            <div id="divSquadra"></div>
        </div>
    </div>
</div>
<?php 
include("footer.php");
?>
