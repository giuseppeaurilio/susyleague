<?php
include("menu.php");
?>

<script>
var moduli =["3-5-2", "3-4-3", "4-3-3", "4-4-2", "4-5-1", "5-3-2", "5-4-1"];
var numRiserve = 10;

// var pconto = [0, 0, 0, 0];
// var modulo = [0, 0, 0, 0];

imgError = function(img){
	img.src = "https://content.fantacalcio.it/web/campioncini/small/no-campioncino.png";
};
	
resetFormazione = function(){
	$('.giocatorecontainer').each( function (){
		if($(this).hasClass("titolare"))	
		{
			$(this).trigger('click');
			$(this).trigger('click');
		}
		else if($(this).hasClass("riserva"))
		{
			$(this).trigger('click');
		}
	});
};

setFormazioneDefault = function(){
	resetFormazione();
	var value =$("#hfFormazioneDefault").val();
	if(value!=0)
	{
		var giocatori= value.split('.');
		// alert(giocatori[0]);
		for( index = 0; index< 11; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
		for( index = 11; index< 21; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
};

impostaFormazione = function()
{
	resetFormazione();
	var value =$(this).val();
	if(value!=0)
	{
		var giocatori= value.split('.');
		// alert(giocatori[0]);
		for( index = 0; index< 11; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
		for( index = 11; index< 21; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
}

formazionerandom = function()
{
	
	var modulo = moduli[Math.floor(Math.random()*moduli.length)];
	// console.log(modulo);
	resetFormazione();
	var portieri = $("#divPortieri").find(".giocatorecontainer.tribuna");
	var portieret = portieri[Math.floor(Math.random()*portieri.length)];
	$(portieret).trigger('click');

	var g =modulo.split("-");
	// console.log(g[0]);
	for(var index = 1; index <= g[0]; index++)
	{
		var difensori = $("#divDifensori").find(".giocatorecontainer.tribuna");
		var difensoret	= difensori[Math.floor(Math.random()*difensori.length)];
		$(difensoret).trigger('click');
	}
	for(var index = 1; index <= g[1]; index++)
	{
		var centro = $("#divCentrocampisti").find(".giocatorecontainer.tribuna");
		var centrot	= centro[Math.floor(Math.random()*centro.length)];
		$(centrot).trigger('click');
	}
	for(var index = 1; index <= g[2]; index++)
	{
		var atta = $("#divAttaccanti").find(".giocatorecontainer.tribuna");
		var attat	= atta[Math.floor(Math.random()*atta.length)];
		$(attat).trigger('click');
	}

	for(var index = 1; index <= 1; index++)
	{
		var portieri = $("#divPortieri").find(".giocatorecontainer.tribuna");
		var portierer	= portieri[Math.floor(Math.random()*portieri.length)];
		$(portierer).trigger('click');
		$(portierer).trigger('click');
		// console.log("por"  + index);
	}
	for(var index = 1; index <= 3; index++)
	{
		var difensori = $("#divDifensori").find(".giocatorecontainer.tribuna");
		var difensorer	= difensori[Math.floor(Math.random()*difensori.length)];
		$(difensorer).trigger('click');
		$(difensorer).trigger('click');
		// console.log("dif"  + index);
	}
	for(var index = 1; index <= 2; index++)
	{
		var centro = $("#divCentrocampisti").find(".giocatorecontainer.tribuna");
		var centror	= centro[Math.floor(Math.random()*centro.length)];
		$(centror).trigger('click');
		$(centror).trigger('click');
		// console.log("cen"  + index);
	}
	for(var index = 1; index <= 2; index++)
	{
		var atta = $("#divAttaccanti").find(".giocatorecontainer.tribuna");
		var attar	= atta[Math.floor(Math.random()*atta.length)];
		$(attar).trigger('click');
		$(attar).trigger('click');
		// console.log("att"  + index);
	}
}

removeItem = function (array, item)
{
	for( var i = 0; i < array.length; i++){ 
		if (array[i].obj === item) {
			array.splice(i, 1); 
		}
	}
}

addItem = function (array, item, order)
{
	
	array.push({ obj: item, o: order });
	array.sort( compare );
}

reassignOrder = function (array)
{
	// debugger;
	for( var i = 0; i < array.length; i++){ 
		var b = $("#div" + array[i].obj);
		b.data('order', i);
		array[i].o= i;
	}

}

function compare( a, b ) {
  if ( a.o < b.o ){
    return -1;
  }
  if ( a.o > b.o ){
    return 1;
  }
  return 0;
}

var por = [];
var dif = [];
var cen = [];
var att = [];
var porris = [];
var difris = [];
var cenris = [];
var attris = [];
selezionaGiocatore = function(){
	por = [];
	dif = [];
	cen = [];
	att = [];
	porris = [];
	difris = [];
	cenris = [];
	attris = [];
	
	var b = $(this);
	// console.log(b);
	$('#divPortieri .giocatorecontainer.titolare').each(function( index ){
		// por.push(b.data('id'));
		addItem(por, $(this).data('id'), $(this).data('order'))
	});
	$('#divPortieri .giocatorecontainer.riserva').each(function( index ){
		addItem(porris, $(this).data('id'), $(this).data('order'))
	});

	$('#divDifensori .giocatorecontainer.titolare').each(function( index ){
		// por.push(b.data('id'));
		addItem(dif, $(this).data('id'), $(this).data('order'))
	});
	$('#divDifensori .giocatorecontainer.riserva').each(function( index ){
		addItem(difris, $(this).data('id'), $(this).data('order'))
	});

	$('#divCentrocampisti .giocatorecontainer.titolare').each(function( index ){
		// por.push(b.data('id'));
		addItem(cen, $(this).data('id'), $(this).data('order'))
	});
	$('#divCentrocampisti .giocatorecontainer.riserva').each(function( index ){
		addItem(cenris, $(this).data('id'), $(this).data('order'))
	});

	$('#divAttaccanti .giocatorecontainer.titolare').each(function( index ){
		// por.push(b.data('id'));
		addItem(att, $(this).data('id'), $(this).data('order'))
	});
	$('#divAttaccanti .giocatorecontainer.riserva').each(function( index ){
		addItem(attris, $(this).data('id'), $(this).data('order'))
	});
	// console.log(b.data('order'));
	var action = 0;
	if (b.hasClass("titolare")){
		b.removeClass("titolare")
		b.addClass("riserva");
		action = 2// add riserva
	}
	else if (b.hasClass("riserva"))	{
		b.removeClass("riserva")
		b.addClass("tribuna");
		action = 0// add tribuna
	}
	else	{
		b.removeClass("tribuna")
		b.addClass("titolare");
		action = 1// add titolare
	}

	var element  = b.data('id');
	var ruolo = b.data('ruolo');

	switch(ruolo){
		case "P": 
			if(action ==0)
			{
				removeItem(por, element);
				removeItem(porris, element);
				reassignOrder(por);
				reassignOrder(porris);
				b.data('order', -1);
				$("#div" + element).find('.badge').html("&nbsp;");
			}
			else if(action ==1)
			{
				removeItem(porris, element);
				reassignOrder(porris);
				b.data('order', por.length);
				addItem(por, element, por.length);
			}
			else if(action ==2)
			{
				removeItem(por, element);
				reassignOrder(por);
				b.data('order', porris.length);
				addItem(porris, element, porris.length);
			}
			// console.log(por);
			// console.log(porris);
		break;
		case "D": 
			if(action ==0)
			{
				removeItem(dif, element);
				removeItem(difris, element);
				reassignOrder(dif);
				reassignOrder(difris);
				b.data('order', -1);
				$("#div" + element).find('.badge').html("&nbsp;");
			}
			else if(action ==1)
			{
				removeItem(difris, element);
				reassignOrder(difris);
				b.data('order', dif.length);
				addItem(dif, element, dif.length);
			}
			else if(action ==2)
			{
				removeItem(dif, element);
				reassignOrder(dif);
				b.data('order', difris.length);
				addItem(difris, element, difris.length);
			}
			// console.log(dif);
			// console.log(difris);
		break;
		case "C": 
			if(action ==0)
			{
				removeItem(cen, element);
				removeItem(cenris, element);
				reassignOrder(cen);
				reassignOrder(cenris);
				b.data('order', -1);
				$("#div" + element).find('.badge').html("&nbsp;");
			}
			else if(action ==1)
			{
				removeItem(cenris, element);
				reassignOrder(cenris);
				b.data('order', cen.length);
				addItem(cen, element, cen.length);
			}
			else if(action ==2)
			{
				removeItem(cen, element);
				reassignOrder(cen);
				b.data('order', cenris.length);
				addItem(cenris, element, cenris.length);
			}
			// console.log(cen);
			// console.log(cenris);
		break;
		case "A": 
			if(action ==0)
			{
				removeItem(att, element);
				removeItem(attris, element);
				reassignOrder(att);
				reassignOrder(attris);
				b.data('order', -1);
				$("#div" + element).find('.badge').html("&nbsp;");
			}
			else if(action ==1)
			{
				removeItem(attris, element);
				reassignOrder(attris);
				b.data('order', att.length);
				addItem(att, element, att.length);
			}
			else if(action ==2)
			{
				removeItem(att, element);
				reassignOrder(att);
				b.data('order', attris.length);
				addItem(attris, element, attris.length);
			}
			// console.log(att);
			// console.log(attris);
		break;
	}
	
	$(por).each(function( index ){
		var start = 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});
	$(dif).each(function( index ){
		start = por.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});
	$(cen).each(function( index ){
		start = por.length + dif.length + 1 ;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});

	$(att).each(function( index ){
		start = por.length + dif.length+cen.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});

	$(porris).each(function( index ){
		start = por.length + dif.length+cen.length + att.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});
	$(difris).each(function( index ){
		start = por.length + dif.length+cen.length + att.length + porris.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});
	$(cenris).each(function( index ){
		start = por.length + dif.length+cen.length + att.length + porris.length + difris.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});

	$(attris).each(function( index ){
		start = por.length + dif.length+cen.length + att.length + porris.length + difris.length + cenris.length + 1;
		$("#div" + this.obj).find('.badge').html(start + this.o);
	});
	
	var curModule = dif.length + '-' + cen.length + '-' + att.length;
	var curReserve  = porris.length + '-' + difris.length + '-' + cenris.length + '-' + attris.length;
	var numcurReserve = porris.length + difris.length + cenris.length + attris.length;
	// "ui-state-error ui-corner-all"

	$('#divRiepilogo #modulo').html(curModule);
	$('#divRiepilogo #panchina').html(curReserve);

	var tit = $('#divRiepilogo #titolari');
	var ris = $('#divRiepilogo #riserve');
	// console.log(moduli);
	// console.log($.inArray(curModule, moduli));
	if(por.length != 1 || $.inArray(curModule, moduli)<0)
	{
		if (!tit.hasClass("ui-state-error"))
		tit.addClass("ui-state-error");
		if (!tit.hasClass("ui-corner-all"))
		tit.addClass("ui-corner-all");
	}
	else
	{
		if (tit.hasClass("ui-state-error"))
		tit.removeClass("ui-state-error");
		if (tit.hasClass("ui-corner-all"))
		tit.removeClass("ui-corner-all");
	}

	if(numcurReserve !== numRiserve)
	{
		if (!ris.hasClass("ui-state-error"))
		ris.addClass("ui-state-error");
		if (!ris.hasClass("ui-corner-all"))
		ris.addClass("ui-corner-all");
	}
	else
	{
		if (ris.hasClass("ui-state-error"))
		ris.removeClass("ui-state-error");
		if (ris.hasClass("ui-corner-all"))
		ris.removeClass("ui-corner-all");
	}
	

}
inviaFormazione = function(){
	var id_squadra= "<?php echo $_GET['id_squadra']; ?>";
 	var id_giornata= "<?php echo $_GET['id_giornata']; ?>";
	var titolari = [];
 	var panchina = [];
	 $('#divPortieri .giocatorecontainer.titolare').each(function( index ){
		titolari.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divDifensori .giocatorecontainer.titolare').each(function( index ){
		titolari.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divCentrocampisti .giocatorecontainer.titolare').each(function( index ){
		titolari.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divAttaccanti .giocatorecontainer.titolare').each(function( index ){
		titolari.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});

	$('#divPortieri .giocatorecontainer.riserva').each(function( index ){
		panchina.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divDifensori .giocatorecontainer.riserva').each(function( index ){
		panchina.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divCentrocampisti .giocatorecontainer.riserva').each(function( index ){
		panchina.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	$('#divAttaccanti .giocatorecontainer.riserva').each(function( index ){
		panchina.push({ id: $(this).data('id'), o: parseInt($(this).find('.badge').html()) , r: $(this).data('ruolo')});
	});
	titolari.sort( compare );
	panchina.sort( compare );
	var formazionedefault = document.getElementById("cbFormazioneDefault").checked;
	var all = document.getElementById("cbSalvaPerTutte").checked;
	var action ="inviaformazione";
	$.ajax(
	{
		type: "POST",
		url: "query_invio_formazione_beta.php",
		data: {
                "action": action,
                "id_squadra": id_squadra,
				"id_giornata": id_giornata,
                "titolari": titolari,
                "panchina": panchina,
				"default": formazionedefault,
				"all": all,
                
            },
		cache: false,
		success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                   var  buttons= [
                                {
                                text: "Ok",
                                // icon: "ui-icon-heart",
                                click: function() {
                                        window.location.reload();
                                    }
                                }
                            ]
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "Info");
                    $( "#dialog p" ).html(resp.message);
                    $( "#dialog" ).dialog({modal:true, buttons: buttons});
                    // resp.result => "Login eseguito",
                }
                else{
                    // $( "#dialog" ).dialog('destroy');
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.message);
                    $( "#dialog" ).dialog({modal:true});
                }
                
                
            }
	//
	});

}

$(document).ready(function(){
	$('#btnReset').off("click").bind("click", resetFormazione);
	$('#ddlUltimeFormazioni').off("change").bind("change", impostaFormazione);
	$('.giocatorecontainer').off("click").bind("click", selezionaGiocatore);
	$("#divInvia").off("click").bind("click",inviaFormazione);
	$('#btnFormazioneDefault').off("click").bind("click", setFormazioneDefault);
	
	resetFormazione();
	var value =$("#hfSquadraInserita").val();
	if(value!="")
	{
		var giocatori= value.split('.');
		// alert(giocatori[0]);
		console.log(giocatori);
		for( index = 0; index< 11; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
		for( index = 11; index< 21; index++)
			{
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
				$("#div" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
});
</script>
<?php

$id_giornata=$_GET['id_giornata'];
$id_squadra=$_GET['id_squadra'];

$query="SELECT squadra, allenatore FROM sq_fantacalcio where id=" . $id_squadra;
$result=$conn->query($query);

$row=$result->fetch_assoc();

$squadra=$row["squadra"];
$allenatore=$row["allenatore"];
?>

<h2><?php echo $squadra . "(" .$allenatore .")";?> - Invio formazione</h2>
<!-- <div>
	<p> Vuoi tornare alla vecchia pagina di invio formazione? </p>
	<a href="<?php echo "invio_formazione_squadra_old
	.php?&id_giornata=" . $id_giornata ."&id_squadra=".$id_squadra ; ?>"><?php echo "Clicca qui" ?></a>
</div> -->
<hr>
<div id="divAmministrazioneControllata">
<?php
$queryselect = "select ammcontrollata from sq_fantacalcio where id=" . $id_squadra;
$numammcontr =0;
$result = mysqli_query($conn,$queryselect);
$row = mysqli_fetch_array($result);
$numammcontr= $row['ammcontrollata'];
if($numammcontr>0)
{
	echo '<div class="ui-widget" id="result" >';
    echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> ';
	echo '<p>';
	echo '   <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
	echo '  <span class="message"> Allenatore!!!! Non hai inviato la formazione per '.$numammcontr.' volta/e!!!</span>';
	echo '</p>';
	echo '</div>';
	echo '</div>';
}
?>
</div>
		
<div id="divUltimeFormazioni"> 
	<label>ultime formazioni</label>
	<select id="ddlUltimeFormazioni">
		<option value="0">scegli...</option>
	<!-- <option value="1">DEFAULT</option> -->
<?php 
// $querypartite = 'SELECT id_giornata, sqc.squadra as casa, sqt.squadra as ospite
// FROM `calendario`  as c
// left join sq_fantacalcio as sqc on c.id_sq_casa = sqc.id
// left join sq_fantacalcio as sqt on c.id_sq_ospite = sqt.id
// WHERE (id_sq_casa = '.$id_squadra.' OR id_sq_ospite ='.$id_squadra.') and gol_casa is not null
// order by id_giornata desc
// LIMIT 5';
$querypartite ='SELECT c.id_giornata, sqc.squadra as casa, sqt.squadra as ospite, ga.inizio, ga.fine
FROM `calendario`  as c
left join giornate as g  on c.id_giornata = g.id_giornata
left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
left join sq_fantacalcio as sqc on c.id_sq_casa = sqc.id
left join sq_fantacalcio as sqt on c.id_sq_ospite = sqt.id
WHERE (id_sq_casa = '.$id_squadra.' OR id_sq_ospite ='.$id_squadra.') and gol_casa is not null
order by ga.fine desc
LIMIT 5';

$result_partite  = $conn->query($querypartite) or die($conn->error);
include_once("DB/calendario.php");
while ($row = $result_partite->fetch_assoc()) {
	$descrizionepartita = getDescrizioneBreveGiornata($row["id_giornata"]).": ". $row["casa"].'-'.$row["ospite"];
	$formazionedadb = "";
	$queryformaz = 'SELECT id_posizione, id_giocatore
	FROM `formazioni` WHERE id_giornata = '.$row["id_giornata"].' and id_squadra = '.$id_squadra.'
	order by id_posizione';
	$formazione  = $conn->query($queryformaz) or die($conn->error);
	while ($row = $formazione->fetch_assoc()) {
		$formazionedadb.=$row["id_posizione"].'_'.$row["id_giocatore"].'.';
	}
	echo '<option value="'.$formazionedadb.'">'.$descrizionepartita.'</option>';

	
}
?>

	<!-- <option value="1_250.2_2160.3_2130.4_2214.5_226.6_26.7_2002.8_645.9_2610.10_2756.11_785.12_453.13_798.14_288.15_392.16_1996.17_2085.18_2531.19_608">I NANI- ASVenere</option> -->
	</select>

<?php
	$formazionedadb = "";

	$queryformaz = 'SELECT id_posizione, id_giocatore
	FROM `formazioni` WHERE id_giornata = '.$id_giornata.' and id_squadra = '.$id_squadra.'
	order by id_posizione';

	$result  = $conn->query($queryformaz) or die($conn->error);
	// print_r($result);
	while ($row = $result->fetch_assoc()) {
		$formazionedadb.=$row["id_posizione"].'_'.$row["id_giocatore"].'.';
	}
	// $conn->close();
	// echo  $formazionedadb;
		echo '<input type="hidden" id="hfSquadraInserita" value="'. $formazionedadb .'"></input>';
	?>

	<input type="button" id="btnReset" value="Reset Formazione"/>

	<?php
	$queryformazionedefault = 'SELECT `id_giocatore`,`id_posizione`,`id_squadra_sa`
	FROM `formazione_standard` WHERE id_tipo_formazione = 1 and id_squadra = '.$id_squadra.'
	order by id_posizione';
	
	$resultformazionedefault  = $conn->query($queryformazionedefault) or die($conn->error);
	$formazionedefault= "";
	while ($row = $resultformazionedefault->fetch_assoc()) {
		$formazionedefault.=$row["id_posizione"].'_'.$row["id_giocatore"].'.';
	}
	// $formazionedefault="1_2211.2_2633.3_2164.4_554.5_4895.6_662.7_4965.8_428.9_536.10_2011.11_4992.12_2178.13_142.14_4331.15_2525.16_530.17_2625.18_1987.19_4324.20_2762.21_608.";
	
	echo '<input type="hidden" id="hfFormazioneDefault" value="'. $formazionedefault .'"></input>';
	 
	?>
	<input type="button" id="btnFormazioneDefault" value="Formazione Default"/>
</div>

<?php
$portieri = array();
$difensori = array();
$centrocampisti = array();
$attaccanti = array();

$query2="SELECT * FROM giocatori as g 
left join rose as r on g.id = r.id_giocatore
left join sq_fantacalcio as sqf on r.id_sq_fc = sqf.id
left join squadre_serie_a as sqa on sqa.id = g.id_squadra
where r.id_sq_fc = $id_squadra";
$result_giocatori=$conn->query($query2);
// echo $query2;
// $num_giocatori=$result_giocatori->num_rows;
while ($row=$result_giocatori->fetch_assoc()) {
	$id_giocatore=$row["id_giocatore"];
	$nome_giocatore=$row["nome"];
	$squadra_giocatore=$row["squadra_breve"];
	$ruolo_giocatore=$row["ruolo"];
	// $costo_giocatore=$row["costo"];

	// echo $nome_giocatore;
	$nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $nome_giocatore));
	// echo $nome_giocatore_pulito;
	$filename = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/small/".$nome_giocatore_pulito.".png");

	if($ruolo_giocatore == "P")
	array_push($portieri, array(
		"id"=>$id_giocatore,
		"nome"=>$nome_giocatore,
		"squadra"=>$squadra_giocatore,
		"filename"=>$filename
		)
	);
	if($ruolo_giocatore == "D")
	array_push($difensori, array(
		"id"=>$id_giocatore,
		"nome"=>$nome_giocatore,
		"squadra"=>$squadra_giocatore,
		"filename"=>$filename
		)
	);
	if($ruolo_giocatore == "C")
	array_push($centrocampisti, array(
		"id"=>$id_giocatore,
		"nome"=>$nome_giocatore,
		"squadra"=>$squadra_giocatore,
		"filename"=>$filename
		)
	);
	if($ruolo_giocatore == "A")
	array_push($attaccanti, array(
		"id"=>$id_giocatore,
		"nome"=>$nome_giocatore,
		"squadra"=>$squadra_giocatore,
		"filename"=>$filename
		)
	);
}

// print_r($portieri)
?>
<script>
$(document).ready(function(){jQuery(".textcontainer").fitText(.6);});
</script>
<div id="divContainer" class="containerFormazione">
	<div id="divContainerGiocatori" class="giocatori">
		<div id="divPortieri" >
			<h5>Portieri</h5>
			<?php
			foreach($portieri as $giocatore)
			{
				echo '<div id="div'. $giocatore["id"].'" 
						class="giocatorecontainer tribuna" 
						data-id="'.$giocatore["id"].'"
						data-ruolo="P"
						>';
					
					echo '<img src='.$giocatore["filename"].' onerror="imgError(this);">';
					echo "<div class='textcontainer'>".$giocatore["nome"] . " (" .$giocatore["squadra"] . ")</div>";
					echo '<div class="badge">&nbsp;</div>';
				echo '</div>';
			}
			?>
		</div>

		<div id="divDifensori" >
			<h5>Difensori</h5>
			<?php
			foreach($difensori as $giocatore)
			{
				echo '<div id="div'. $giocatore["id"].'" 
						class="giocatorecontainer tribuna" 
						data-id="'.$giocatore["id"].'"
						data-ruolo="D"
						>';
					echo '<img src='.$giocatore["filename"].' onerror="imgError(this);">';
					echo "<div class='textcontainer'>".$giocatore["nome"] . " (" .$giocatore["squadra"] . ")</div>";
					echo '<div class="badge">&nbsp;</div>';
				echo '</div>';
			}
			?>
		</div>

		<div id="divCentrocampisti" >
			<h5>Centrocampisti</h5>
			<?php
			foreach($centrocampisti as $giocatore)
			{
				echo '<div id="div'. $giocatore["id"].'" 
						class="giocatorecontainer tribuna" 
						data-id="'.$giocatore["id"].'"
						data-ruolo="C"
						>';
					echo '<img src='.$giocatore["filename"].' onerror="imgError(this);">';
					echo "<div class='textcontainer'>".$giocatore["nome"] . " (" .$giocatore["squadra"] . ")</div>";
					echo '<div class="badge">&nbsp;</div>';
				echo '</div>';
			}
			?>
		</div>

		<div id="divAttaccanti" >
			<h5>Attaccanti</h5>
			<?php
			foreach($attaccanti as $giocatore)
			{
				echo '<div id="div'. $giocatore["id"].'" 
						class="giocatorecontainer tribuna" 
						data-id="'.$giocatore["id"].'"
						data-ruolo="A"
						>';
					echo '<img src='.$giocatore["filename"].' onerror="imgError(this);">';
					echo "<div class='textcontainer '>".$giocatore["nome"] . " (" .$giocatore["squadra"] . ")</div>";
					echo '<div class="badge">&nbsp;</div>';
				echo '</div>';
			}
			?>
		</div>
		<div id="divRiepilogo" >
			<h5>Riepilogo</h5>
			<div id="titolari" style="background-color: rgba(51,102,255,0.2)">
				<label for="modulo"> modulo = </label>
				<label id="modulo" >  </label><br>
			</div>
			<div id="riserve" style="background-color: rgba(170,170,170,0.2)">
				<label for="panchina" >panchina = </label>
				<label id="panchina" >  </label><br>
			</div>
			<div style="background-color: rgba(51,102,255,0.2); text-align: center; padding: 10px">
				<label >Imposta come formazione di default: </label>
				<input type="checkbox" id="cbFormazioneDefault"/>
			</div>
			<div style="background-color: rgba(170,170,170,0.2);text-align: center; padding: 10px;">
				<label >Salva per tutte le competizioni: </label>
				<input type="checkbox" id="cbSalvaPerTutte" />
			</div>
			<div id="divInvia" class="mainaction asabutton">Invia Formazione</div>

		</div>
	</div>

</div>
<div>
	

	<p> Le formazioni inviate dagli allenatori possono essere consultate nella sezione CALENDARIO facendo click sul nome della giornata </p>
	<a href="<?php echo "display_giornata.php?&id_giornata=" . $id_giornata ; ?>"><?php echo "Formazioni Giornata " . $id_giornata ?></a>
</div>

<?php 
include("footer.php");
?>