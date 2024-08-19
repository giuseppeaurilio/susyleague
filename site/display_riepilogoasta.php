<?php 
include("menu.php");

?>
<script>
function scrollFunction() {
    return false;
}
// var pagereload = false;
var lastcost = 0;

loadStatsDialog = function(event)
{
    // debugger;
    var id = event.data.id;
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

loadStats = function(id)
{
    // // debugger;
    // var action ="stats";
    // $.ajax({
    //     type:'POST',
    //         url:'display_riepilogoasta_controller.php',
    //         data: {
    //             "action": action,
    //             "id": id,
    //             "limit": 3
    //         },
    //         success:function(data){
    //             var resp=$.parseJSON(data)
    //             if(resp.result == "true"){
    //                 if(resp.stats.length> 0){
    //                     //show data
    //                     var template = $('#tmplStats').html();
    //                     Mustache.parse(template);   // optional, speeds up future uses
    //                     var rendered = Mustache.render(template, resp);
    //                     $("#divStats").html(rendered);
    //                 }
    //             }
    //             else{
    //                 $( "#dialog" ).prop('title', "ERROR");                
    //                 $( "#dialog p" ).html(resp.error.msg);
    //                 $( "#dialog" ).dialog({modal:true});
    //             }
    //         }
    // }); 
}

loadUltimoGiocatore = function(id)
{
    var action ="ultimogiocatore";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    if(resp.giocatori.length> 0){
                        //show data
                        var template = $('#tmplAstaprecedente').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divAstaprecedente").html(rendered);
                        $("#divAstaprecedente").unbind().bind("click", { id: resp.giocatori[0]["id"]},  loadStatsDialog);
                    }
                    else{
                        var giocatore = {nome: "NO DATA", ruolo: "-", imgurl: noimage, squadra_breve: "--", costo:"-", fantasquadra : "--"}
                        //
                        resp.giocatori.push(giocatore);
                        var template = $('#tmplAstaprecedente').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divAstaprecedente").html(rendered);
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
                
                if(resp.result == "true" ){
                    if(resp.giocatori.length> 0){
                        // debugger;
                        // astaincorso = resp.giocatori[0].costo == null;
                        // console.log(resp.giocatori[0].costo);
                        // if(astaincorso == true)
                        // {
                        //show data
                        var template = $('#tmplAstaInCorso').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp.giocatori[0]);
                        $("#divAstaAttuale").html(rendered);
                       
                        if(resp.giocatori[0].costo == null)
                        {
                            lastcost = resp.giocatori[0].costo;
                        }
                        else
                        {
                            if(lastcost == null)
                            {
                                location.reload();
                            }
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
$(document).ready(function(){
    //ogni 5 secondi 
        //mostro l'ultimo giocatore venduto, a chi e a che prezzo.
        //verifico se c'e' un giocatore in vendita.
            //se non c'era e lo trovo mostro il nuovo giocatore in vendita.
            //se c'era e non c'è vuol dire che è stato venduto, reload della pagina
    // loadUltimoGiocatore();
    var pagereload = false;
    loadAstaInCorso();
    window.setInterval(function(){
        
        loadAstaInCorso();
     }, 3000);
    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("fullscreen");

    if(c != null)
    {
        $("header").hide()
        $(".menu").hide()
    }

})
$(document).on({
    ajaxStart: function() { 
        $("body").removeClass("loading");
    },
});

</script>

<script id="tmplAstaInCorso" type="x-tmpl-mustache">
    
<div>
    {{ #fantasquadra }}
    <h3 style="text-align:center;font-size: 30px;"> Ultimo aggiudicato</h3>
    <div class="widgetastacontent ultimoaggiudicato" data-id="{{ id }}">
    {{ /fantasquadra }}
    {{ ^fantasquadra }}
    <h3 style="text-align:center;font-size: 30px;"> Adesso in asta</h3>
    <div class="widgetastacontent incorso" data-id="{{ id }}">
    {{ /fantasquadra }}
    <div class="ruolo" style="font-size:50px"> Ruolo: {{ ruolo }} </div>
    <div class="nome" style="font-size:100px"> {{ nome }} </div>
    <!-- <div class="nome" style="font-size:100px"> ({{ squadra }})</div> -->
    <img  width="120px;" src='{{ imgurl }}' onerror='imgError(this);'> </img>
    <img  width="120px;" src='{{ imgurlsquadra }}'> </img>
    {{ #fantasquadra }}
    <div class="fantasquadra" style="font-size:50px"> Aggiudicato: {{ fantasquadra }} <br> Costo: {{ costo }} FMD</div>
    {{ /fantasquadra }}
    </div>
</div>
</script>

<script id="tmplAstaprecedente" type="x-tmpl-mustache">
    
<div>
    <h3>Ultimo Aggiudicato</h3>
    <div class="widgetastacontent precedente" data-id="{{ id }}">
        <div class="left">
            <img src='{{ imgurl }}' onerror='imgError(this);'> </img> 
        </div>
        <div  class="right">
            <div class="nome" > {{ nome }} ({{ squadra_breve }})</div>
            <div class="ruolo"> Ruolo: {{ ruolo }} </div>
            <div > Costo: {{ costo }}</div>
            <div > Fantasquadra: <br><span class="fantasquadra">{{ fantasquadra }}<span></div>
        </div>
    </div>
</div>
</script>

<script id="tmplStats" type="x-tmpl-mustache">
    <h3 >
        <span style="font-size:50px">{{ stats.0.nome }} ({{ stats.0.squadra_breve }}) - {{ stats.0.ruolo }}</span>

        &nbsp;
        <a style='float: right;font-size: small; color:white;' target='_blank' 
        href='https://www.fantacalcio.it/squadre/Giocatore/{{ stats.0.nome }}/{{ stats.0.id }}/5/20{{anno}}'>
        <i class='fas fa-external-link-alt'></i>
        </a>
    
	</h3>
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr><th>anno</th><th>pg</th><th>mv</th><th>mf</th><th>gf</th><th>gs</th><th>rp</th><th>rc</th><th>r+</th><th>r-</th><th>as</th><th>asf</th><th>am</th><th>es</th><th>au</th></tr>
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


<h2>ASTA LIVE</h2>
<div class="maincontent">
    <div class="rigacompleta">
        <div class="widgetasta " id="divAstaAttuale">
        <!-- <h3> Adesso in asta</h3>
    <div class="widgetastacontent incorso" >
        <div class="left">
            <img src='https://content.fantacalcio.it/web/campioncini/medium/BUFFON.png' onerror='imgError(this);'> </img> 
        </div>
        <div  class="right">
            <div class="nome"> Buffon (JUV)</div>
            <div class="ruolo"> Ruolo: P </div>
        </div>
        
    </div> -->
        </div>
        <!-- <div class="widgetasta " id="divAstaprecedente"> -->
        <!-- <h3>Ultimo Aggiudicato</h3>
    <div class="widgetastacontent precedente" >
    <div class="left">
            <img src='https://content.fantacalcio.it/web/campioncini/medium/PERIN.png' onerror='imgError(this);'> </img> 
        </div>
        <div  class="right">
            <div class="nome"> PERIN (GEN)</div>
            <div > Ruolo: P </div>
            <div > Costo: 20</div>
            <div > Fantasquadra: <br><span class="fantasquadra">Nuova Romanina<span></div>
        </div>
    </div> -->
        <!-- </div> -->
    <!-- </div> -->
<?php 
//load squadre fantacalcio
// $query="SELECT * FROM sq_fantacalcio order by squadra";

// $result=$conn->query($query);
// $squadre = array();
// while($row = $result->fetch_assoc()){
//     array_push($squadre, array(
//         "id"=>$row["id"],
//         "squadra"=>$row["squadra"],
//         "allenatore"=>$row["allenatore"]
//         )
//     );
// }
include_once ("DB/fantacalcio.php");
$squadre = fantacalcio_getFantasquadre();
?>
<?php
include_once ("DB/asta.php");
// include_once ("DB/parametri.php");

function getbackgroundColor($refnum, $refnumjolly, $num, $numjolly)
{
    $color = "";
    // if($numjolly < $refnumjolly) // se il jolly non è stato scelto
    // {
        if($num == $refnum)//se il numero di giocatori scelto è uguale al max
        {
            $color ="lightgreen";
        }
    // }
    // else//se il jolly  è stato scelto
    // {
        if($num > $refnum)//se il numero di giocatori scelto è uguale al max
        {
            $color ="red";
        }
    // }
    return $color;
}
echo "<div class='riepilogocreditiasta ' id='divAstaprecedente'> <table>";
echo "<tr>
<th>Squadra</th>
<th>Off MAX /RIMANENTI <br>(FMD)</th>
<th>P </th>
<th>D</th>
<th>C</th>
<th>A</th>
</tr>";
foreach($squadre as $squadra)
{
    $rimanenti = getMilioniRimanenti($squadra["id"]);
    $offertamassima = getOffertaMassima($squadra["id"]);
    $numjollyscelti = hasJolly($squadra["id"]);
    $riepilogo = getRiepilogoAsta($squadra["id"]);
    // echo $squadra["id"] . " - " .print_r($riepilogo) ."<br>";
    $numpor= 0;
    $numdif= 0;
    $numcen= 0;
    $numatt= 0;
    $costopor= 0;
    $costodif= 0;
    $costocen= 0;
    $costoatt= 0;
    echo "<tr>";
    echo "<td style='font-size:2.5em;'>".$squadra["squadra"]."<span style='font-size:0.5em;'>(".$squadra["allenatore"].")</span></td>";
    echo "<td style='font-size:3em; text-align:center;'>".$offertamassima." <span style='font-size:0.6em'>/".$rimanenti." </span></td>";
    foreach($riepilogo["giocatori"] as $row){
        
        // echo '<td>';
        switch($row["ruolo"])
                {
                    case "P":
                        // echo '<div style="padding: 2px;"><span style="color: black; background-color: '.getbackgroundColor(3, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/3 </span><br>('.$row["costo"].'FM)</div>';
                        $numpor = $row["numero"];
                        $costopor= $row["costo"];
                    break;
                    case "D":
                        // echo '<div style="padding: 2px; "><span style="color: black; background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span><br>('.$row["costo"].'FM)</div>';
                        $numdif = $row["numero"];
                        $costodif= $row["costo"];
                    break;
                    case "C":
                        // echo '<div style="padding: 2px; "><span style="color: black; background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span><br>('.$row["costo"].'FM)</div>';
                        $numcen = $row["numero"];
                        $costocen= $row["costo"];
                    break;
                    case "A":
                        // echo '<div style="padding: 2px;"><span style="color: black; background-color: '.getbackgroundColor(7, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/7 </span><br>('.$row["costo"].'FM)</div>';
                        $numatt = $row["numero"];
                        $costoatt= $row["costo"];
                    break;
                }
                
        // echo '</td>';
    }
    echo '<td class="costo" style="color: black; background-color: '.getbackgroundColor(3, 1, $numpor, $numjollyscelti).';">';
    echo '<div style="padding: 2px;"><span >'.$numpor. '/3 </span> <br>('.$costopor.'FMD)';
    echo '</td>';
    echo '<td class="costo" style="color: black; background-color: '.getbackgroundColor(9, 1, $numdif, $numjollyscelti).';">';
    echo '<div style="padding: 2px;"><span >'.$numdif. '/9 </span> <br>('.$costodif.'FMD)</div>';
    echo '</td>';
    echo '<td class="costo"  style="color: black; background-color: '.getbackgroundColor(9, 1, $numcen, $numjollyscelti).';">';
    echo '<div style="padding: 2px;"><span >'.$numcen. '/9 </span> <br>('.$costocen.'FMD)</div>';
    echo '</td>';
    echo '<td class="costo" style="color: black; background-color: '.getbackgroundColor(7, 1, $numatt, $numjollyscelti).';">';
    echo '<div style="padding: 2px;"><span >'.$numatt. '/7 </span> <br>('.$costoatt.'FMD)</div>';
    echo '</td>';
    echo "</tr>";
    // echo '<div id=riepilogo'.$squadra["id"].' class="riepilogo" style="vertical-align: middle;">';
    // echo '<h2>'.$squadra["squadra"];
   
    // echo '</h2>';
    // echo '<div class="ui-state-error" style="text-align:center;">
    //             MAX <span style="font-size: 100px">
    //             '.$offertamassima.'
    //         </span>
    //         </div>';
    // echo "<div style='flex-flow: row; display: flex; flex-wrap: wrap; width: 100%; background-color: lightgrey;'> ";
    //     foreach($riepilogo["giocatori"] as $row){
    //         switch($row["ruolo"])
    //         {
    //             case "P":
    //                 echo '<div style="padding: 3px;">P: <span style="color: black; background-color: '.getbackgroundColor(3, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/3 </span>('.$row["costo"].'FM)</div>';
    //             break;
    //             case "D":
    //                 echo '<div style="padding: 3px; ">D: <span style="color: black; background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span>('.$row["costo"].'FM)</div>';
    //             break;
    //             case "C":
    //                 echo '<div style="padding: 3px; ">C: <span style="color: black; background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9 </span>('.$row["costo"].'FM)</div>';
    //             break;
    //             case "A":
    //                 echo '<div style="padding: 3px;">A: <span style="color: black; background-color: '.getbackgroundColor(7, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/7 </span>('.$row["costo"].'FM)</div>';
    //             break;
    //         }
    //     }
    // echo "</div>";
    // echo '<h4 style="text-align: center;">Offerta massima '.$offertamassima.'</h4>';
    // echo '<table>';
    // echo '<tr>
    //         <th>Ruolo</th>
    //         <th>Spesi</th>
    //         <th>In rosa</th>
    //     </tr>';
    // foreach($riepilogo["giocatori"] as $row){
    //     switch($row["ruolo"])
    //     {
    //         case "P":
    //             echo '<tr><td>Portieri</td><td style="text-align: center;">'.$row["costo"].'</td>';
    //             echo '<td style="text-align: center;background-color: '.getbackgroundColor(3, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/3</td>';
    //             echo'</tr>';
    //         break;
    //         case "D":
    //             echo '<tr><td>Difensori</td><td style="text-align: center;">'.$row["costo"].'</td>';
    //             echo '<td style="text-align: center;background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9</td>';
    //             echo'</tr>';
    //         break;
    //         case "C":
    //             echo '<tr><td>Centrocampisti</td><td style="text-align: center;">'.$row["costo"].'</td>';
    //             echo '<td style="text-align: center;background-color: '.getbackgroundColor(9, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/9</td>';
    //             echo'</tr>';
    //         break;
    //         case "A":
    //             echo '<tr><td>Attaccanti</td><td style="text-align: center;">'.$row["costo"].'</td>';
    //             echo '<td style="text-align: center;background-color: '.getbackgroundColor(7, 1, $row["numero"], $numjollyscelti).';">'.$row["numero"]. '/7</td>';
    //             echo'</tr>';
    //         break;
    //     }
    // }
    // echo '</table>';
    
        //<tr>
        //     <th>Giocatori in rosa</th>
        //     <th>'.$riepilogo["numerototale"].'</th>
        
        // </tr>
        // <tr>
        //     <th>Jolly scelti</th>
        //     <th>'.$jollyScelto.'</th>
        
        // </tr>
    // echo '<table>
    //     <tr>
    //             <th>Milioni spesi</th>
    //             <th>'.$riepilogo["spesi"].'</th>
               
    //     </tr>
    //     <tr>
    //         <th>Milioni rimanenti</th>
    //         <th>'.$rimanenti.'</th>
           
    //     </tr>
    // </table>';
    echo '</div>';

    // print_r($riepilogo["giocatori"]);
    // echo '<br> Spesi: ' . $riepilogo["spesi"];
    // echo '<br> Totale: ' . $riepilogo["numerototale"];
    // echo '<br> Rimanenti: ' . $rimanenti;
    // echo '<br> Offerta Massima: ' . $offertamassima;
    // echo '<br> Jolly: ' . $jollyScelto;
    $conn->next_result();
}
echo "</table > </div> ";
?>
</div>
</div>
<?php 
include("footer.php");
?>
