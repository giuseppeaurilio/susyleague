<?php 
include_once ("menu.php");

?>
<script>

var astaincorso = false;
ricercaGiocatore = function(id)
{
    var action ="ricercagiocatore";
    var ruolo = $("#ruolo").val();
    var idsquadra = $("#squadra").val();
    var mediavoto = $("#txtMediaVoto").val();
    var fantamedia = $("#txtFantamedia").val();
    var titolarita = $("#titolarita").val();
    var rigori = $("#rigori").val();
    var punizioni = $("#punizioni").val();
    var ia = $("#txtIA").val();
    var is = $("#indicesquadra").val();
    var f = $("#fascia").val();
    var om = $("#txtOffMAX").val();
    var sololiberi = $("#cbSoloLiberi").prop("checked") ;
    var ordinamento = $("#ordinamento").val();
    // debugger;
    
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
                "is": is,
                "f": f,
                "om": om,
                "sololiberi": sololiberi,
                "ordinamento": ordinamento
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    //show data
                    var template = $('#tmplListaGiocatoriDisponibili').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);
                    // $("#divGiocatori").html(rendered);
                    $("#tblGiocatori > tbody").remove()
                    $("#tblGiocatori").append(rendered);
                    $("#tblGiocatori > tbody tr").unbind().bind("click", function(){
                        loadStatsDialog($(this).data("id")); 
                        } 
                    );
                    $("#tblGiocatori #txtNome").unbind().bind("keyup", filtraGiocatoriPerNome);
                    
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
    var ruolo = $("#ruoloP").val()
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": <?php echo  $_SESSION['login'] ?>,//idsquadrapeppe
                "ruolo": ruolo, //idsquadrapeppe
            },
            success:function(data){
                
                var resp=$.parseJSON(data)
                
                    if(resp.result == "true"){
                        if(resp.giocatori.length> 0){
                            //show data
                            var template = $('#tmplListaGiocatoriSquadra').html();
                            Mustache.parse(template);   // optional, speeds up future uses
                            var rendered = Mustache.render(template, resp);
                            $("#tblSquadra > tbody").remove()
					        $("#tblSquadra").append(rendered);
                            // $("#divSquadra").html(rendered);
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

loadProssimiPrecedenteAsta = function(ruoloattuale)
{
    var action ="prossimiprecedenteasta";
    var ruolo = $("#ruoloP").val()
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "ruolo": ruolo, 
            },
            success:function(data){
                
                var resp=$.parseJSON(data)
                // debugger;
                    if(resp.result == "true"){
                        if(resp.prossimi.length> 0){
                            var template = $('#tmplProssimi').html();
                            Mustache.parse(template);   // optional, speeds up future uses
                            var rendered = Mustache.render(template, resp);
					        $("#divProssimi").html(rendered);
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
                "limit": 3
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

loadStatsDialog = function(id)
{
    var action ="stats";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": id,
                // "limit": 1,
            },
            success:function(data){
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    if(resp.stats.length> 0){
                        //show data
                        var template = $('#tmplStatsDialog').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp);
                        $( "#dialog" ).prop('title', "Statistiche");        
                        $( "#dialog p" ).html(rendered);
                        $( "#dialog" ).dialog({modal:true, width:600});
                    }
                    else{
                        $( "#dialog" ).prop('title', "ERROR");                
                        $( "#dialog p" ).html("nessun dato presente");
                        $( "#dialog" ).dialog({modal:true});
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
                        if(astaincorso == false)
                        {
                            //show data
                            var template = $('#tmplAstaInCorso').html();
                            Mustache.parse(template);   // optional, speeds up future uses
                            // debugger;
                            var rendered = Mustache.render(template, resp.giocatori[0]);
                            $("#divAstaAttuale").html(rendered);
                            astaincorso = true;
                            loadStats(resp.giocatori[0]["id"]);
                            loadPInfo(resp.giocatori[0]["id"]);
                            var ruoloattuale = $('.widgetastacontent.incorso .ruolo').data("ruolo");
                            // if(ruoloattuale != '-')
                            // {
                            $("#tblGiocatori #ruolo").val(ruoloattuale);
                            $("#tblSquadra #ruoloP").val(ruoloattuale);
                            ricercaGiocatore();
                            loadSquadra();
                            loadProssimiPrecedenteAsta(ruoloattuale);
                            // }
                        }
                        else{
                            //do nothing
                        }
                        
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
filtraGiocatoriPerNome = function()
{
    var filterString = $("#tblGiocatori #txtNome").val().toUpperCase();
    // console.log(filterString);
    $("#tblGiocatori > tbody tr").show()
    if(filterString != "" && filterString.length >= 2)
    {
        $("#tblGiocatori > tbody tr").hide()
        $("#tblGiocatori .nome").filter(function() {
            return $(this).html().includes(filterString);
        }).closest('tr').show()
    }
    
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
    $("#indicesquadra").val("");
    $("#fascia").val("");
    $("#txtOffMAX").val("");
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
     }, 3000);
    $("#ruoloP").unbind().bind("change", loadSquadra);
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
    <div class="widgetastacontent incorso height" data-id="{{ id }}">
        <div class="left">
            <img src='{{ imgurl }}' onerror='imgError(this);'> </img> 
        </div>
        <div  class="right">
            <div class="nome"> {{ nome }} ({{ squadra_breve }})
                <a style='float: right;font-size: small; color:black;' target='popup' 
                href='https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22'
                onclick='
                window.open("https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22","popup","width=600,height=600"); 
                event.stopPropagation();
                return false;''><i class='fas fa-external-link-alt'></i></a>
                </div>
            <div class="ruolo" data-ruolo="{{ ruolo }}"> Ruolo: {{ ruolo }}; Mantra: {{ ruolo_mantra }}</div>
        </div>
    </div>
</div>
</script>

<script id="tmplStats" type="x-tmpl-mustache">
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center; width:100%">
        <tr>
            <th>anno</th>
            <th title="Partite giocate">pg</th>
            <th title="Media voto">mv</th>
            <th title="FantaMedia">mf</th>
            <th title="Gol fatti">gf</th>
            <th title="Gol Subiti">gs</th>
            <th title="Rigori parati"rp</th>
            <th title="Rigori calciati">rc</th>
            <th title="Rigori segnati">r+</th>
            <th title="Rigori sbagliati">r-</th>
            <th title="Assit">as</th>
            <th title="Assist da fermo">asf</th>
            <th title="Ammonizioni">am</th>
            <th title="Espusioni">es</th>
            <th title="Autogol">au</th>
        </tr>
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
            <td>{{asf}}</td>
            <td>{{amm}}</td>
            <td>{{esp}}</td>
            <td>{{au}}</td>
        </tr>
        {{/stats}}
    </table >
</table>
</script>

<script id="tmplStatsDialog" type="x-tmpl-mustache">
    <h3>
        {{ stats.0.nome }} ({{ stats.0.squadra_breve }}) - {{ stats.0.ruolo }}
	</h3>
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr>
            <th>anno</th>
            <th title="Partite giocate">pg</th>
            <th title="Media voto">mv</th>
            <th title="FantaMedia">mf</th>
            <th title="Gol fatti">gf</th>
            <th title="Gol Subiti">gs</th>
            <th title="Rigori parati"rp</th>
            <th title="Rigori calciati">rc</th>
            <th title="Rigori segnati">r+</th>
            <th title="Rigori sbagliati">r-</th>
            <th title="Assit">as</th>
            <th title="Assist da fermo">asf</th>
            <th title="Ammonizioni">am</th>
            <th title="Espusioni">es</th>
            <th title="Autogol">au</th>
        </tr>
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
            <td>{{asf}}</td>
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
        <tr>
            <th title="Quotazione">Quo</th>
            <th title="Titolarità">Tit</th>
            <th title="Calci di rigore">CR</th>
            <th title="Calci di punizione">CP</th>
            <th title="Calci d'agolo">CA</th>
            <th title="Indice di appetibilità">IA</th>
            <th title="Indice squadra">IS</th>
            <th title="Fascia">FA</th>
            <th title="Offerta MAX">OFF MAX</th>
            <th title="Anno precedente">AP</th>
        </tr>
        <tr>
            <td>{{quotazione}}</td>
            <td>{{titolarita}}</td>
            <td>{{cr}}</td>
            <td>{{cp}}</td>
            <td>{{ca}}</td>
            <td>{{ia}}</td>
            <td>{{is}}</td>
            <td>{{f}}</td>
            <td>{{om}}</td>
            <td>{{ordine_ap}}.({{squadra}}){{costo_ap}}FM</td>
            
        </tr>
        <tr>
        <td colspan="10">{{note}}</td></tr>
    </table >
</table>
</script>

<script id="tmplListaGiocatoriSquadra" type="x-tmpl-mustache">
    <tbody>
        {{ #giocatori }}
        <tr>
            <td style="text-align:left;">{{ nome }}
                &nbsp;
                <a style='float: right;font-size: small; color:black;' target='popup' 
                href='https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22'
                onclick='
                window.open("https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22","popup","width=600,height=600"); 
                event.stopPropagation();
                return false;''><i class='fas fa-external-link-alt'></i></a>
            </td>
            <td>{{ruolo}}</td>
            <td>{{squadra_breve}}</td>
            <td>{{is}}</td>
            <td>{{f}}</td>
            <td>{{costo}}</td>
            <td>{{note}}</td>
        </tr>
        {{ /giocatori }}    
    </tbody>
</script>

<script id="tmplListaGiocatoriDisponibili" type="x-tmpl-mustache">
    <tbody>
        {{ #giocatori }}
        <tr data-id="{{ id }}"> 
            <td  style="text-align:left;">
                <span class="nome {{class}}">{{ nome }}</span> <span class="visibile {{class}}">({{squadrafc}})</span>
                <a style='float: right;font-size: small; color:black;' target='popup' 
                href='https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22'
                onclick='
                window.open("https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}/5/2021-22","popup","width=600,height=600"); 
                event.stopPropagation();
                return false;''><i class='fas fa-external-link-alt'></i>
            </td>
            <td>{{ruolo}}</td>
            <td>{{squadra_breve}}</td>
            <td>{{quotazione}}</td>
            <td>{{ia}}</td>
            <td>{{titolarita}}</td>
            <td>{{cr}}</td>
            <td>{{cp}}</td>
            <td>{{ca}}</td>            
            <td>{{is}}</td>
            <td>{{f}}</td>
            <td>{{om}}</td>
            <td>
            {{note}}
            </td>
        </tr>
        {{ /giocatori }}
    </tbody>

</script>

<script id="tmplProssimi" type="x-tmpl-mustache">
    <span>Prossimi AP:</span>
    {{ #prossimi }}
        <span>{{nome}}({{squadra}}) {{costo}} FM;  </span>
    {{ /prossimi }}    
</script>


<h2>ASTA Peppe</h2>
<div class="maincontent" style="min-height: auto;">
<?php
$query="SELECT count(id_giocatore) as somma, g.ruolo
from rose_asta as ra
left join giocatori as g on ra.id_giocatore = g.id
group by ruolo order by ruolo desc";

$result=$conn->query($query);
$somme = array();
while($row = $result->fetch_assoc()){
    array_push($somme, array(
        "somma"=>$row["somma"],
        "ruolo"=>$row["ruolo"],
        )
    );
}
?>

<div class="rigacompleta" id="divavanzamento">
    <span>Avanzamento:</span>
    <?php 
    $totale = 1;
    foreach($somme as $somma)
    {
        $totale += $somma["somma"];
        if($somma["ruolo"] == "P")
            echo '<span>Portieri:'.$somma["somma"].' /36; </span>';
        else if($somma["ruolo"] == "D")
            echo '<span>Difensori:'.$somma["somma"].' /108;  </span>';
        else if($somma["ruolo"] == "C")
            echo '<span>Centrocampisti:'.$somma["somma"].' /108;  </span>';
        else if($somma["ruolo"] == "A")
            echo '<span>Attaccanti:'.$somma["somma"].' /84;  </span>';
    }
    echo '<span>CHIAMATA:'.$totale.';  </span>'
    ?>
</div>
<div class="rigacompleta" id="divProssimi">
    <!-- <span>Prossimi AP:</span> -->
    <?php 
    // foreach($prossimi as $prossimo)
    // {
    //     echo '<span>'.$prossimo["ordine"]. '.'. $prossimo["nome"].'('.$prossimo["squadra"].') '.$prossimo["costo"].' FM;  </span>';
    // }
    ?>
</div>
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
        // $id=$row["id"];
        // $squadra=$row["squadra"];
        array_push($squadre, array(
            "id"=>$row["id"],
            "squadra_breve"=>$row["squadra_breve"]
            )
        );
    }
    //fine load squadre fantacalcio
    ?>
    
    <div class="rigacompleta">
        
        <div class="listaGiocatori" style="width:60%" >
            <h3 style="text-align:center">Giocatori - 
            <input type="checkbox" id="cbSoloLiberi" checked> Solo liberi</input>
             - Ordina per: 
                <select name="ordinamento" id="ordinamento">			
                    <!-- <option value="" >-Ordinamento-</option> -->
                    <option value="ia-d" selected>indica appetibilita &darr;</option>
                    <option value="is-a" >indice squadra &darr;</option>
                    <option value="f-d" >fascia &darr;</option>
                    <option value="t-d">titolarita &darr;</option>
                    <option value="q-d">quotazione &darr;</option>
                    <option value="q-d">Offerta Max &darr;</option>
                </select>
                <input type="button" value="cerca" id="btnCerca">
                <input type="button" value="reset" id="btnResetFiltri">
            </h3>
            <div id="divGiocatori">
                <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;" id="tblGiocatori">
                    <thead>
                        <tr>
                            <!-- <th>Nome</th> -->
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
                                        echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra_breve"] . '</option>';
                                    }
                                    echo '</select>';
                                ?>
                            </th>
                            
                            <th>
                                <input type="number" style="width: 40px;" id="txtQuotazione" min="0" max="60" step="1" placeholder="Quo">
                            </th>
                            <th ><input style="width: 30px;" type="number" id="txtIA" min="0" max="200" step="1" placeholder="IA"></th>
                            <th>
                                <select name="ruolo" id="titolarita">
                                    <option value="">-TIT</option>	
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
                            </th>
                            <th>
                                <select name="rigori" id="rigori">
                                    <option value="">-RIG</option>	
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </th>
                            <th>
                                <select name="punizioni" id="punizioni" style="width: 40px;">
                                    <option value="">-PUN</option>	
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </th>
                            <th >
                                <select name="angoli" id="angoli" style="width: 40px;">
                                    <option value="">-ANG</option>	
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </th>
                            
                            <th >
                                <select name="indicesquadra" id="indicesquadra">
                                    <option value="">-IS</option>	
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            <!-- <input style="width: 30px;" type="number" id="txtIS" min="0" max="200" step="1" placeholder="IS"> -->
                            </th>
                            <th >
                                <select name="fascia" id="fascia">
                                    <option value="">F</option>	
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            <!-- <input style="width: 30px;" type="number" id="txtF" min="0" max="200" step="1" placeholder="F"> -->
                            </th>
                            <th>
                                <input type="number" style="width: 40px;" id="txtOffMAX" min="0" max="200" step="1" placeholder="OMAX">
                            </th>
                            <th>note</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="space" style="width:1%">
        </div>
        <div class="squadraAttuale" style="width:39%">
            <h3 style="text-align:center">I NANI</h3>
            <?php
                include_once ("DB/asta.php");
                include_once "DB/parametri.php";
                function getbackgroundColor($refnum, $refnumjolly, $num, $numjolly)
                {
                    $color = "lightgreen";
                    if($numjolly < $refnumjolly) // se il jolly non è stato scelto
                    {
                        if($num == $refnum)//se il numero di giocatori scelto è uguale al max
                        {
                            $color ="yellow";
                        }
                    }
                    else//se il jolly  è stato scelto
                    {
                        if($num >= $refnum)//se il numero di giocatori scelto è uguale al max
                        {
                            $color ="red";
                        }
                    }
                    return $color;
                }
                $idsquadra = $_SESSION['login'];
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
                            echo '<div style="padding: 3px 7px;">Por: <span style="background-color: '.getbackgroundColor(3, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/3 </span>('.$row["costo"].'FM)</div>';
                        break;
                        case "D":
                            echo '<div style="padding: 3px 7px; ">Dif: <span style="background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span>('.$row["costo"].'FM)</div>';
                        break;
                        case "C":
                            echo '<div style="padding: 3px 7px; ">Cen: <span style="background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span>('.$row["costo"].'FM)</div>';
                        break;
                        case "A":
                            echo '<div style="padding: 3px 7px;">Att: <span style="background-color: '.getbackgroundColor(7, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/7 </span>('.$row["costo"].'FM)</div>';
                        break;
                    }
                }
                echo "</div>"
            ?>
            
            <div id="divSquadra">
                <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;" id="tblSquadra">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>
                                <select name="RuoloP" id="ruoloP">
                                    <option value="">-R</option>	
                                    <option value="P">P</option>
                                    <option value="D">D</option>
                                    <option value="C">C</option>
                                    <option value="A">A</option>
                                </select>
                            </th>
                            <th>Squadra</th>
                            <th>IS</th>
                            <th>F</th>
                            <th>Costo</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<?php 
include_once ("footer.php");
?>
