<?php 
include("menu.php");

?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<script>

function load_data(id_sq, ruolo, id) {
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'sq_sa='+id_sq+"&"+"ruolo="+ruolo,
                success:function(html){
                    $('#giocatore').html(html);
                    $("#ruolo").val(ruolo)
                    $("#sq_sa").val(id_sq)
                    $("#giocatore").val(id)
                }
            }); 
}


$(document).ready(function(){
    $('#sq_sa').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var a=load_data(sq_sa_ID ,ruolo);
        if(sq_sa_ID && ruolo){
			load_data(sq_sa_ID , ruolo)
        }else{
            $('#giocatore').html('<option value="">--Seleziona giocatore--</option>');
            //$('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#ruolo').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var a=load_data(sq_sa_ID ,ruolo);
        if(sq_sa_ID && ruolo){
			load_data(sq_sa_ID , ruolo)
        }else{
            $('#giocatore').html('<option value="">--Seleziona giocatore--</option>');
            //$('#city').html('<option value="">Select state first</option>'); 
        }
    });
    var url = new URL(window.location);
    var c = url.searchParams.get("ruolo");
    var min = url.searchParams.get("min");
    var max = url.searchParams.get("max");
    $("select#ruolo").val(c);
    $("#txtMin").val(min);
    $("#txtMax").val(max);
    var esito = url.searchParams.get("esito");

    var message = url.searchParams.get("message");
    if(esito != undefined && esito != "info")
    {
        var  buttons= [
                        {
                        text: "Ok",
                        // icon: "ui-icon-heart",
                        click: function() {
                            var url = window.location.href;
                            console.log(url);
                            window.location.href = url.substring(0,url.indexOf("esito") );
                            $( "#dialog" ).dialog('close')
                            }
                        }
                    ]
        $( "#dialog" ).prop('title', esito);
        $( "#dialog p" ).html(message);
        // $( "#dialog" ).dialog({modal:true});
        $( "#dialog" ).dialog({modal:true, buttons: buttons});
    }
});
</script>

<script>
imgError = function(img){
	img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/no-campioncino.png";
};
estraiGiocatore = function()
{
    $("#sq_sa").val("");
    $("#giocatore").val("");
    var ruolo = $( "#ruolo option:selected" ).val();
    var min = $( "#txtMin" ).val();
    var max = $( "#txtMax" ).val();
    var idsquadra = $( "#sq_sa option:selected" ).val();
    var message = ""
    
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }


    var action ="estrai";
    $.ajax({
            type:'POST',
            url:'amministra_rose_controller.php',
            data: {
                "action": action,
                "ruolo": ruolo,
                "min": min,
                "max": max,
                "idsquadra": idsquadra,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true" ){
                    if(resp.giocatori.length> 0){
                    var  buttons= [
                                    {
                                    text: "annulla",
                                    click: function() {
                                        annullaGiocatoreEstrazione(resp.giocatori[0].id);
                                        $( "#dialog" ).dialog('close');
                                        }
                                    }, 
                                    {
                                    text: "conferma",
                                    click: function() {
                                        confermaGiocatoreEstratto(resp.giocatori[0].ruolo, resp.giocatori[0].ids, resp.giocatori[0].id);
                                        $( "#dialog" ).dialog('close');
                                        }
                                    }
                                ];
                        // preg_replace('/\s+/', '-', $nome_giocatore);
                        // str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png")
                        var res = resp.giocatori[0].nome.replace("/\s+/", "-");
                        var filename = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/" + res + ".png";
                    
                        var content = "<div style='text-align: center;'>";
                        content += "<h3> " + resp.giocatori[0].nome + " (" + resp.giocatori[0].squadra_breve + ")" + "</h3>";
                        content += "<img src='" + filename + "' onerror='imgError(this);'> </img> ";
                        content +="<div> Ruolo: " + resp.giocatori[0].ruolo + "</div>";
                        content += "<div> Quotazione: " + resp.giocatori[0].quotazione + "</div>",
                        content +="</div>";
                        $( "#dialog" ).prop('title', "Info");
                        $( "#dialog p" ).html(content);
                        $( "#dialog" ).dialog({modal:true, buttons: buttons});
                    }
                    else
                    {
                        var  buttons= [
                                    {
                                    text: "OK",
                                    click: function() {
                                        $( "#dialog" ).dialog('close');
                                        }
                                    }];
                        var content = "Nessun giocatore trovato";
                        $( "#dialog" ).prop('title', "Info");
                        $( "#dialog p" ).html(content);
                        $( "#dialog" ).dialog({modal:true, buttons: buttons});
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
confermaGiocatore = function()
{
    var ruolo = $("#ruolo").val();
    var ids = $("#sq_sa").val();
    var id = $("#giocatore").val();
    
    confermaGiocatoreEstratto(ruolo, ids, id);
}
confermaGiocatoreEstratto = function(ruolo, ids, id)
{
    load_data(ids,ruolo, id);

    // //alert("conferma " +id);
    var action ="conferma";
    $.ajax({
        type:'POST',
            url:'amministra_rose_controller.php',
            data: {
                "action": action,
                "id": id,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   // t
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
    }); 
}

annullaGiocatoreEstrazione = function(id)
{
    $("#sq_sa").val("");
    $("#giocatore").val("");
    var action ="annulla";
    $.ajax({
        type:'POST',
            url:'amministra_rose_controller.php',
            data: {
                "action": action,
                // "id": id,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   // t
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
    }); 
}

getQuotazioneMax = function()
{
    $("#txtMax").attr("max", 100);
    $("#lblMax").html("max: "+ "ND");
    var action ="getquotazionemax";
    var ruolo =$("#ruolo").val();
    if(ruolo == "")
        return false;
    $.ajax({
        type:'POST',
            url:'amministra_rose_controller.php',
            data: {
                "action": action,
                "ruolo": ruolo,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   $("#txtMax").attr("max", resp.max);
                   $("#lblMax").html("max: "+ resp.max);
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
    }); 
}
giocatoreInAsta = function()
{
    var sq_sa_ID = $('#sq_sa').val();
    var ruolo = $('#ruolo').val();
    var giocatore_ID=$('#giocatore').val();
    if( ruolo != "" &&  sq_sa_ID != "" && giocatore_ID != ""){
        confermaGiocatoreEstratto(ruolo, sq_sa_ID, giocatore_ID);
    }
}
enablebutton = function()
{
    // debugger;

    var sq_sa_ID = $('#sq_sa').val();
    var ruolo = $('#ruolo').val();
    var giocatore_ID=$('#giocatore').val();
    var sq_fc = $('#sq_fc').val();
    var costo=$('#costo').val();
    var min=$('#txtMin').val();
    var max=$('#txtMax').val();
    var disabled=!(sq_sa_ID  && giocatore_ID && sq_fc && $.isNumeric(costo))
    $("#submit").prop('disabled', disabled);
    $("#sommario").val(giocatore_ID + "_" + sq_fc + "_" + ruolo + "_" + min + "_" + max)
    
    // if( ruolo != "" &&  sq_sa_ID != "" && giocatore_ID != ""){
    //     $('#btnInAsta').removeAttr("disabled");
    //     $("#btnInAsta").unbind().bind('click', confermaGiocatore);
    // }
    // else{
    //     $("#btnInAsta").attr("disabled", true);
    // }
    
}

getGiocatoreInAsta = function()
{
    var action ="astaincorso";
    $.ajax({
        type:'POST',
            url:'amministra_rose_controller.php',
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
                        // $("#ruolo").val(resp.giocatori[0]["ruolo"]);
                        // $("#sq_sa").val(resp.giocatori[0]["ids"]);
                        load_data( resp.giocatori[0]["ids"], resp.giocatori[0]["ruolo"], resp.giocatori[0]["id"])
                        //   //show data
                        //   var template = $('#tmplAstaInCorso').html();
                        //   Mustache.parse(template);   // optional, speeds up future uses
                        //   var rendered = Mustache.render(template, resp.giocatori[0]);
                        //   $("#divAstaAttuale").html(rendered);
                        //   astaincorso = true;
                        //   loadStats(resp.giocatori[0]["id"]);
                        //   // $("#divAstaAttuale").unbind().bind("click", { id: resp.giocatori[0]["id"]},  loadStats);
                        
                    }
                    else{
                        // var giocatore = {nome: "Nessuna giocatore in asta", ruolo: "-", imgurl: noimage, squadra_breve: "--"}
                        // //
                        // resp.giocatori.push(giocatore);
                        // var template = $('#tmplAstaInCorso').html();
                        // Mustache.parse(template);   // optional, speeds up future uses
                        // var rendered = Mustache.render(template, resp.giocatori[0]);
                        // $("#divAstaAttuale").html(rendered);
                        
                        // if(astaincorso == true)
                        // {
                        //     location.reload();
                        // }
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
function inizializzaControlli(){
    enablebutton();
    $("#btnEstraiRandom").click(estraiGiocatore);
    $("#btnAnnullaAstaCorrente").click(annullaGiocatoreEstrazione);
    $("#ruolo").on('change', enablebutton);
    $("#sq_sa").on('change', enablebutton)
    $("#giocatore").on('change', enablebutton)
    $("#giocatore").on('change', giocatoreInAsta)
    $("#sq_fc").on('change', enablebutton)
    $("#costo").on('change keyup', enablebutton)
    getQuotazioneMax();
    $("#ruolo").on('change', getQuotazioneMax);
    getGiocatoreInAsta();

    // $("#btnInAsta").click(confermaGiocatore);
}
$(document).ready(function(){
     inizializzaControlli();
})
</script>

<h2>Aggiungi Giocatore</h2>
<div class="aggiungi">
<form action="aggiungi_a_rosa.php" method="get">
<select name="Ruolo" id="ruolo">
  <option value="">--Seleziona ruolo--</option>	
  <option value="P">Portiere</option>
  <option value="D">Difensore</option>
  <option value="C">Centrocampista</option>
  <option value="A">Attaccante</option>
</select>


<select name="squadra_serie_a" id="sq_sa">
<option value="">--Seleziona squadra--</option>	
<?php
$query_sa="SELECT * FROM squadre_serie_a order by squadra";
$result_sa=$conn->query($query_sa);

$num_sa=$result_sa->num_rows; 
$i=0;
while ($row=$result_sa->fetch_assoc()) {
	
	$id=$row["id"];
    $squadra=$row["squadra_breve"];
	  echo '<option value=' . $id . '>'. $squadra . '</option>';
++$i;
}
?>
</select>


<select name="giocatore" id="giocatore">
		<option value="">--Seleziona giocatore--</option>	
</select>
<!-- <input type="button" value="in asta" id="btnInAsta"> -->
<input type="button" value="annulla asta" id="btnAnnullaAstaCorrente">

&#8658;


<select id="sq_fc" name="squadra_fantacalcio ">
	<option value="">--Seleziona squadra fantacalcio--</option>	
	  
<?php
$query="SELECT * FROM sq_fantacalcio order by squadra   ";
$result=$conn->query($query);

$num=$result->num_rows; 
$i=0;
while ($row=$result->fetch_assoc()) {
	$id=$row["id"];
    $squadra=$row["squadra"];
	  echo '<option value=' . $id . '>'. $squadra . '</option>';
++$i;
}
?>
</select>

Costo:<input type="number" id="costo" name="costo" style="width:80px;">


<input  type="hidden" id="sommario" name="sommario" value="">
<input type="submit" id="submit" value="Aggiungi" disabled>
<br/>

</form> 

<div>
Estrazione automatica:
<input type="number" id="txtMin" name="min" placeholder="min" style="width:80px;">
<input type="number" id="txtMax" name="MAX" placeholder="MAX" style="width:80px;">
<span id="lblMax"></span>
<input type="button" value="estrai un giocatore" id="btnEstraiRandom">

</div>

</div>
<h2>Rose</h2>
<?php 
#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
#echo $query2;
$result_generale=$conn->query($query_generale);
while ($row=$result_generale->fetch_assoc()) {

$fantamilioni=$row["valore"];
}
$i=0;

$query="SELECT * FROM sq_fantacalcio order by squadra";
$result=$conn->query($query);

$num=$result->num_rows; 


while ($row=$result->fetch_assoc()) {



$id=$row["id"];
$squadra=$row["squadra"];
$allenatore=$row["allenatore"];
$query2="SELECT a.costo,a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc='" . $id ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";
#echo $query2;
$result_giocatori=$conn->query($query2);
$num_giocatori=$result_giocatori->num_rows;

#echo $i;

?>
<div class="rosegiocatoriseriea">
<h2><?php echo "$squadra";?></h2>
<h3><?php echo "(" .$allenatore .")";?></h3>

<table class="table_rose" border="0" cellspacing="2" cellpadding="2">
<tr> 

<th>Nome</th>
<th>Squadra</th>
<th>Ruolo</th>
<th>Costo</th>
<th>Azione</th>
</tr>
<?php 

$j=0;
$spesi=0;
$portieri=0;
$difensori=0;
$centrocampisti=0;
$attaccanti=0;
while ($row=$result_giocatori->fetch_assoc()) {
	$id_giocatore=$row["id_giocatore"];
	$nome_giocatore=$row["nome"];
	$squadra_giocatore=$row["squadra_breve"];
	$ruolo_giocatore=$row["ruolo"];
	$costo_giocatore=$row["costo"];
$spesi = $spesi+ $costo_giocatore;
$portieri=$portieri + ($ruolo_giocatore=="P");
$difensori=$difensori + ($ruolo_giocatore=="D");
$centrocampisti=$centrocampisti + ($ruolo_giocatore=="C");
$attaccanti=$attaccanti + ($ruolo_giocatore=="A");
?>


<tr style="background-color: <?php switch ($ruolo_giocatore) {
    case "P":
        echo "#66CC33";
        break;
    case "D":
        echo "#33CCCC";
        break;
    case "C":
        echo "#FFEF00";
        break;
     case "A":
        echo "#E80000 ";
        break;
    default:
        echo "#FFFFFF";
}
?>
"> 

<td><?php  echo "$nome_giocatore"; ?></td>
<td><?php  echo "$squadra_giocatore"; ?></td>
<td><?php  echo "$ruolo_giocatore"; ?></td>
<td><?php  echo "$costo_giocatore"; ?></td>
<td><a href=<?php  echo "cancella_giocatore_da_rosa.php?id_giocatore=" . $id_giocatore; ?> >Cancella</a></td>
</tr>

<?php 
++$j;

} 
echo "</table>";

?>
<br>

<table >
  <tr>
    <th>giocatori</th>
    <th><?php  echo $num_giocatori; ?></th>
  </tr >
  <tr>
    <th>portieri</th>
    <th><?php  echo $portieri; ?></th>
  </tr>
   <tr>
    <th>difensori</th>
    <th><?php  echo $difensori; ?></th>
  </tr>
  <tr>
    <th>centrocampisti</th>
    <th><?php  echo $centrocampisti; ?></th>
  </tr>
  <tr>
    <th>attaccanti</th>
    <th><?php  echo $attaccanti; ?></th>
  </tr>
  <tr >
    <th>Fantamilioni spesi</th>
    <th><?php  echo $spesi; ?></th>
  </tr>
   <tr >
    <th>Fantamilioni restanti</th>
    <th><?php  echo $fantamilioni-$spesi; ?></th>
  </tr>
  
</table>


</div>
<?php 

++$i;
} 
?>
<?php 
include("../footer.php");
?>
