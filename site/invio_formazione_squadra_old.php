<?php
include("menu.php");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.myButton_0 {
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
    -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;

  font-family: Arial;
  color: #000000;
  font-size: 20px;
  background-color: #8dc2eb;
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;


}
.myButton_1 {
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
    -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;

  font-family: Arial;
  color: #000000;
  font-size: 20px;
  background-color: #8dc2eb;
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;

}

.myButton_2 {
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
    -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;

  font-family: Arial;
  color: #000000;
  font-size: 20px;
  background-color: #8dc2eb;
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;
  
}

.myButton_3 {
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
    -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;

  font-family: Arial;
  color: #000000;
  font-size: 20px;
  background-color: #8dc2eb;
  padding: 20px 20px 20px 20px;
  text-decoration: none;
  width: 150px;

}

.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}
.container{
	float:left;
}
</style>



<?php

$id_giornata=$_GET['id_giornata'];
$id_squadra=$_GET['id_squadra'];

$ruoli = array("P","D","C","A");
$ruoli_name = array("Portieri","Difensori","Centrocampisti","Attaccanti");

$i=0;

$query="SELECT squadra, allenatore FROM sq_fantacalcio where id=" . $id_squadra;
$result=$conn->query($query);

$row=$result->fetch_assoc();

$squadra=$row["squadra"];
$allenatore=$row["allenatore"];
?>


<script>

var pconto = [0, 0, 0, 0];
var modulo = [0, 0, 0, 0];

function sortFunction(a, b) {
    if (a[0] === b[0]) {
        return 0;
    }
    else {
        return (a[0] < b[0]) ? -1 : 1;
    }
}
    function getCol(matrix, col){
       var column = [];
       for(var i=0; i<matrix.length; i++){
          column.push(matrix[i][col]);
       }
       return column;
    }

function pushArray(arr, arr2) {
    arr.push.apply(arr, arr2);
}
    
resetFormazione = function(){
	$('[class^="myButton"]').each( function (){
		if($(this).css("background-color") ==  "rgb(0, 255, 0)")	
		{
			$(this).trigger('click');
			$(this).trigger('click');
		}
		else if($(this).css("background-color") ==  "rgb(255, 0, 0)")
		{
			$(this).trigger('click');
		}
	});
};

$(document).ready(function(){

	$('#btnReset').click(resetFormazione);

    $('[class^="myButton"]').click(function(){

	console.log($(this).text());
	//var a = $(this).attr('id').split("_");
	var myClass = $(this).attr("class");
	var a = myClass.split("_");
	var ruolo=parseInt(a[1]) ;
	switch($( this ).css( "background-color" )) {
	case "rgb(0, 255, 0)"://da titolare a panchina
		$( this ).css( "background-color" , "rgb(255, 0, 0)");
		pconto[ruolo]= pconto[ruolo]+1;
		modulo[ruolo]=modulo[ruolo]-1;
		$(this).text( $(this).text() +  "*" + pconto[ruolo]);
		
		break;
	case "rgb(255, 0, 0)"://da panchina a tribuna
		$( this ).css( "background-color" , "rgb(141, 194, 235)");
		pconto[ruolo]= pconto[ruolo]-1;
		var b = $(this).text().split("*");
		$(this).text(b[0]);
		var panchina = parseInt(b[1]);
		$('.' + myClass).each(function(){
		console.log($(this).text());
		var d = $(this).text().split("*");
		panchina_rem= parseInt(d[1]);
		if (panchina_rem>panchina) {
		$(this).text(d[0] + "*" + (panchina_rem-1));}
		})
		break;	
	default: //da tribuna a titolare
		$( this ).css( "background-color" ,"rgb(0, 255, 0)");
		modulo[ruolo]=modulo[ruolo]+1;
		break;
	}
	var testo_modulo="";
	var tot_panchine =0;
	for (j = 0; j < 3; j++) {
    	testo_modulo += String(modulo[j]) + "-";
    	tot_panchine += pconto[j];
	}
	testo_modulo += String(modulo[3]) ;
	tot_panchine += pconto[3];
	$("#modulo").text(testo_modulo);
	$("#panchina").text(String(tot_panchine));
}
)


 $("#btn_invia").click(function(){
 var id_squadra= "<?php echo $id_squadra; ?>";
 var id_giornata="<?php echo $id_giornata; ?>";
 var dataString = 'id_squadra='+ id_squadra + '&id_giornata=' + id_giornata ;
 var boolammcontrollata = $("#cbAmministrazControllata").prop("checked");
 var valammcontrollata = 0;
 dataString += "&ammcontrollata=" + valammcontrollata;
 dataString += '&titolari=';
 var titolari = [];
 var panchina = [];
 for (j = 0; j < 4; j++) {
  		var panchina_loc= new Array();
 	$('.myButton_'+ String(j)).each(function(){

 		if ($(this).css( "background-color")=="rgb(0, 255, 0)"){
 		var id=$(this).attr("id");
 		var id_num=id.split("_");
 		titolari.push (id_num[1]);
 		}
  		if ($(this).css( "background-color")=="rgb(255, 0, 0)"){
 		var id=$(this).attr("id");
 		var id_num=id.split("_");
 		var nome=$(this).text();
 		var pos=nome.split("*");
 		var valueToPush = new Array();
 		valueToPush[0] = pos[1];
 		valueToPush[1] = id_num[1];
 		panchina_loc.push ([pos[1],id_num[1]]  );
 		}		

 		})
		var panchina_sort = panchina_loc.sort(sortFunction);
 		var panchina_id = getCol(panchina_sort,1);
 		pushArray(panchina,panchina_id);
 	}
 	titolari.forEach(function(entry) {
 	dataString += String(entry) + ",";
 	});
 	dataString = dataString.substring(0, dataString.length - 1);
 	dataString += "&panchina="
 	panchina.forEach(function (entry) {
 	dataString += String(entry) + ",";
 	});
 	dataString = dataString.substring(0, dataString.length - 1);
 	dataString += "&password_all=" + $("#password").val();
	console.log(dataString);
	$.ajax(
	{
		type: "POST",
		url: "query_invio_formazione.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
		console.log(result);
		window.alert(result);
	//		message_status.show();
	//		message_status.text("Aggiornato");
	//		#hide the message
	//			setTimeout(function(){message_status.hide()},1000);
	//		
		}
	//
	});

 });
 
 
});

$(document).ready(function(){
	$("#ddlUltimeFormazioni").change(impostaFormazione);
	// window.alert(result);
}
);

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
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
		for( index = 11; index< 19; index++)
			{
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
}

formazionerandom = function()
{
	var moduli =["3-5-2", "3-4-3", "4-3-3", "4-4-2", "4-5-1", "5-3-2", "5-4-1"];
	var modulo = moduli[Math.floor(Math.random()*moduli.length)];
	console.log(modulo);
	resetFormazione();
	var portieri = $("#divPortieri").find("button");
	var portieret = portieri[Math.floor(Math.random()*portieri.length)];
	$(portieret).trigger('click');

	var g =modulo.split("-");
	// console.log(g[0]);
	for(var index = 1; index <= g[0]; index++)
	{
		var difensori = $("#divDifensori").find("button[style='background-color: rgb(141, 194, 235);']");
		var difensoret	= difensori[Math.floor(Math.random()*difensori.length)];
		$(difensoret).trigger('click');
	}
	for(var index = 1; index <= g[1]; index++)
	{
		var centro = $("#divCentrocampisti").find("button[style='background-color: rgb(141, 194, 235);']");
		var centrot	= centro[Math.floor(Math.random()*centro.length)];
		$(centrot).trigger('click');
	}
	for(var index = 1; index <= g[2]; index++)
	{
		var atta = $("#divAttaccanti").find("button[style='background-color: rgb(141, 194, 235);']");
		var attat	= atta[Math.floor(Math.random()*atta.length)];
		$(attat).trigger('click');
	}

	for(var index = 1; index <= 1; index++)
	{
		var portieri = $("#divPortieri").find("button[style='background-color: rgb(141, 194, 235);']");
		var portierer	= portieri[Math.floor(Math.random()*portieri.length)];
		$(portierer).trigger('click');
		$(portierer).trigger('click');
		console.log("por"  + index);
	}
	for(var index = 1; index <= 3; index++)
	{
		var difensori = $("#divDifensori").find("button[style='background-color: rgb(141, 194, 235);']");
		var difensorer	= difensori[Math.floor(Math.random()*difensori.length)];
		$(difensorer).trigger('click');
		$(difensorer).trigger('click');
		console.log("dif"  + index);
	}
	for(var index = 1; index <= 2; index++)
	{
		var centro = $("#divCentrocampisti").find("button[style='background-color: rgb(141, 194, 235);']");
		var centror	= centro[Math.floor(Math.random()*centro.length)];
		$(centror).trigger('click');
		$(centror).trigger('click');
		console.log("cen"  + index);
	}
	for(var index = 1; index <= 2; index++)
	{
		var atta = $("#divAttaccanti").find("button[style='background-color: rgb(141, 194, 235);']");
		var attar	= atta[Math.floor(Math.random()*atta.length)];
		$(attar).trigger('click');
		$(attar).trigger('click');
		console.log("att"  + index);
	}
}
</script>
<h2><?php echo $squadra . "(" .$allenatore .")";?> - Invio formazione</h2>
<!-- <h2></h2> -->

<!-- <h3><?php echo "(" .$allenatore .")";?></h3> -->
<?php
// include_once ("dbinfo_susyleague.inc.php");
// $conn = new mysqli($localhost, $username, $password,$database);

// // Check connection
// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// }
$queryselect = "select ammcontrollata from sq_fantacalcio where id=" . $id_squadra;

$numammcontr =0;
$result = mysqli_query($conn,$queryselect);
$row = mysqli_fetch_array($result);
$numammcontr= $row['ammcontrollata'];
// echo '<h3>La squadra è in amministrazione controllata da '.$numammcontr.' turni</h3>';
if($numammcontr>0)
{
	// echo '<h3>Allenatore!!!! Non hai inviato la formazione per '.$numammcontr.' volta/e!!!</h3>';
	echo '<div class="ui-widget" id="result" >';
    echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> ';
	echo '<p>';
	echo '   <span class="ui-icon ui-icon-alert" ';
	echo '      style="float: left; margin-right: .3em;"></span>';
	echo '  <span class="message"> Allenatore!!!! Non hai inviato la formazione per '.$numammcontr.' volta/e!!!</span>';
	echo '</p>';
    echo '</div>';
	echo '</div>';
	
}
// echo '<input type="hidden" id="hfAmmControllata" value="'.$numammcontr.'"/>';
?>

<label>ultime formazioni</label>
<select id="ddlUltimeFormazioni">
	<option value="0">scegli...</option>
	<!-- <option value="1">DEFAULT</option> -->
<?php 

$querypartite = 'SELECT id_giornata, sqc.squadra as casa, sqt.squadra as ospite
FROM `calendario`  as c
left join sq_fantacalcio as sqc on c.id_sq_casa = sqc.id
left join sq_fantacalcio as sqt on c.id_sq_ospite = sqt.id
WHERE (id_sq_casa = '.$id_squadra.' OR id_sq_ospite ='.$id_squadra.') and gol_casa is not null
order by id_giornata desc
LIMIT 5';

$result_partite  = $conn->query($querypartite) or die($conn->error);

while ($row = $result_partite->fetch_assoc()) {
	$descrizionepartita = $row["casa"].'-'.$row["ospite"];
	$formazionedadb = "";
	$queryformaz = 'SELECT id_posizione, id_giocatore
	FROM `formazioni` WHERE id_giornata = '.$row["id_giornata"].' and id_squadra = '.$id_squadra.'
	order by id_posizione';
	$formazione  = $conn->query($queryformaz) or die($conn->error);
	while ($row = $formazione->fetch_assoc()) {
		$formazionedadb.=$row["id_posizione"].'_'.$row["id_giocatore"].'.';
	}
	echo '<option value="'.$formazionedadb.'">'.$descrizionepartita.'</option> -->';
}

// $conn->close();
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
<script >
$(document).ready(function(){
	resetFormazione();
	var value =$("#hfSquadraInserita").val();
	if(value!="")
	{
		var giocatori= value.split('.');
		// alert(giocatori[0]);
		console.log(giocatori);
		for( index = 0; index< 11; index++)
			{
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
		for( index = 11; index< 19; index++)
			{
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
				$("#btn_" + giocatori[index].split('_')[1]).trigger('click');
			}
	}
});
</script>
<input type="button" id="btnReset" value="Reset Formazione"></input>
<?php
for($i = 0; $i < 4; $i++) {
	// $conn = new mysqli($localhost, $username, $password,$database);
	// if ($conn->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
	// }
	//$query2="SELECT * FROM rose where sq_fantacalcio_id=" . $id_squadra . " AND ruolo = '" . $ruoli[$i] ."'";
	$query2="SELECT * FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc=". $id_squadra ." AND a.id_giocatore=b.id and b.ruolo='" . $ruoli[$i] ."' and b.id_squadra=c.id";

	//echo $query2;
	$result_giocatori=$conn->query($query2);
	$num_giocatori=$result_giocatori->num_rows;
	#echo $num_giocatori;
	#echo $i;
	?>
	
	<div id="div<?php echo $ruoli_name[$i];?>" >
	<div style="display: inline-block; width:100%;">
	<h3><?php echo $ruoli_name[$i];?></h3>
	<?php
		while ($row=$result_giocatori->fetch_assoc()) {
		$id_giocatore=$row["id_giocatore"];
		$nome_giocatore=$row["nome"];
		$squadra_giocatore=$row["squadra_breve"];
		$ruolo_giocatore=$row["ruolo"];
		$costo_giocatore=$row["costo"];

		// echo $nome_giocatore;
		$nome_giocatore_pulito = preg_replace('/\s+/', '-', $nome_giocatore);
		// echo $nome_giocatore_pulito;
		$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png");

		//  'https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/'.$nome_giocatore.'.png';
		// if (file_exists('https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/'.$nome_giocatore.'.png'))
			// if (getimagesize($filename)) 
		// $headers = get_headers($filename );

		// if (!stripos($headers[0], "200 OK"))
		// {
		// 	$filename = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/NO-CAMPIONCINO.png";
			
		// }
		echo '<div class="container">';
		echo '<img style="		height: 80px;		width: 60px;	" src='.$filename.'>';
		echo '<br>';
		echo '<button id="btn_'.  $id_giocatore.'" type="button" class="myButton_'. $i.' btn" style="background-color: rgb(141, 194, 235);">';
		
		echo $nome_giocatore . " (" .$squadra_giocatore . ")";
		echo '</button>';
		echo '</div>';
		// echo '<button id="btn_'.  $id_giocatore.'" type="button" class="myButton_'. $i.' btn" style="background-color: rgb(141, 194, 235);">';
		
		// echo $nome_giocatore . " (" .$squadra_giocatore . ")";
		// echo '</button>';
	
	} 
	?>
	</div>
	</div>
	<?php
}

?>

<form action="" class="a-form">
<label for="modulo"> modulo = </label>
<label id="modulo" >  </label><br>
<label for="panchina" >panchina = </label>
<label id="panchina" >  </label><br>

<button type="button" id="btn_invia">Invia Formazione</button>

</form>

<p> Le formazioni inviate dagli allenatori possono essere consultate nella sezione CALENDARIO facendo click sul nome della giornata </p>
<a href="<?php echo "display_giornata.php?&id_giornata=" . $id_giornata ; ?>"><?php echo "Formazioni Giornata " . $id_giornata ?></a>
<br>

<?php 
include("footer.php");
?>