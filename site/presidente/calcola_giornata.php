<!-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<?php
include("menu.php");
$id_giornata=$_GET['id_giornata'];
$id_girone=$_GET['id_girone'];
?>
<script>
	
imgError = function(img){
	img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
};

inviaSostituzione= function (){
	// debugger;
	var id_giornata=$(this).attr( "data-id_giornata");
	var id_squadra=$(this).attr( "data-id_squadra");
	var id_giocatore=$(this).attr( "data-id_giocatore");
	var checked=$(this).prop("checked");

	var action ="inviasostituzione";
	// debugger;
	// console.log("giornata: " + id_giornata +"; partita: " + id_partita +"; squadra: " + id_squadra + 
	// "; checked: " + checked + "; home: " + home);
	$.ajax({
        type:'POST',
            url:'calcola_giornata_controller.php',
            data: {
                "action": action,
                "id_giornata": id_giornata,
                "id_squadra": id_squadra, 
				"id_giocatore": id_giocatore, 
				"checked": checked, 
            },
            success:function(data){
                modalPopupResultHide(data);
            }
    }); 
}
inviaCommento = function(){
	var id_giornata=$(this).data("giornata");
	var id_partita=$(this).data("partita");
	var id_squadra=$(this).data("squadra");
	var home=$(this).data("home");
	// var casa=$(this).prop("home");
	var checked=$(this).prop("checked");
	console.log($(this));
	var action ="usemd";

	$.ajax({
        type:'POST',
            url:'calcola_giornata_controller.php',
            data: {
                "action": action,
                "id_giornata": id_giornata,
                "id_partita": id_partita, 
				"id_squadra": id_squadra, 
				"checked": checked, 
				"home": home
            },
            success:function(data){
				modalPopupResult(data);
            }
    }); 
}
calcolaRisultati= function(){
	var id_giornata="<?php echo $id_giornata; ?>";
	var id_girone="<?php echo $id_girone; ?>";
	$.ajax({
		url: "partita_c_calcolarisultato.php" + "?idgiornata=" + id_giornata +"&idgirone=" + id_girone,
		type:"GET",
		success: function(msg)
		{
			// setTimeout(function(){location.reload();},10);
			modalPopupResult(msg);
		}
		}); //end $.ajax
}//end function $("#btn_commento").click
cancellaRisultati= function (){
	// debugger;
	var id_giornata=$(this).data("idgiornata");
	var action ="cancellarisultati";
	$.ajax({
        type:'POST',
            url:'calcola_giornata_controller.php',
            data: {
                "action": action,
                "id_giornata": id_giornata,
            },
            success:function(data){
				modalPopupResult(data);
            }
    }); 
}
salvautilizzomd = function()
{
	var id_giornata=$(this).data("giornata");
	var id_partita=$(this).data("partita");
	var id_squadra=$(this).data("squadra");
	var home=$(this).data("home");
	// var casa=$(this).prop("home");
	var checked=$(this).prop("checked");
	console.log($(this));
	var action ="usemd";
	$.ajax({
        type:'POST',
            url:'calcola_giornata_controller.php',
            data: {
                "action": action,
                "id_giornata": id_giornata,
                "id_partita": id_partita, 
				"id_squadra": id_squadra, 
				"checked": checked, 
				"home": home
            },
            success:function(data){
                modalPopupResultHide(data);
            }
    }); 
}
inizializza = function(){
	$(".cbFormazione").each(function() {
  		var id = $(this).attr( "data-id_giocatore");
		var sub = $("#hf"+ id).val();
		if(sub == "1")
		{
			$(this).prop( "checked", true );
		}
		else
		{
			$(this).prop("checked", false );
		}
	});
}
$(document).ready(function(){
	inizializza();
	$(".cbFormazione").off("click").bind("click", inviaSostituzione)
	$("#btn_commento").off("click").bind("click", inviaCommento);
	$("#btn_calcola").off("click").bind("click", calcolaRisultati);
	$("#btn_cancella").off("click").bind("click", cancellaRisultati);
    $(".usamd").unbind().bind("change", salvautilizzomd);

})

</script>

<h1> <?php
include_once "../DB/calendario.php";
$descrizioneGiornata = getDescrizioneGiornata($id_giornata);
 echo $descrizioneGiornata 
 ;?> </h1>
<!-- <a href="amministra_voti.php" >Voti</a> -->
<!-- <form action="upload_voti.php?idgiornata=<?php echo $id_giornata ;?>" method="post" enctype="multipart/form-data">
<section>
	<h1>Istruzioni</h1>
	Importare un fils CSV. <br>
	Il separatore di valori deve essere il carattere ";" (punto e virgole). <br>
	il separatore di decimali deve essere il carattere "." (punto).
</section>
    Selziona File da inserire:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" name="submit">
</form>
<div data-role="main" class="ui-content"> -->

<?php


// $query2="SELECT a.id_sq_casa as id_casa, 
// a.id_sq_ospite as id_ospite, 
// b.squadra as sq_casa, 
// c.squadra as sq_ospite, 
// a.gol_casa, a.gol_ospiti, 
// a.punti_casa, a.punti_ospiti 
// $query2="Select *, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone
// FROM calendario as a 
// left join sq_fantacalcio as b on a.id_sq_casa=b.id 
// left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
// left join giornate as g on g.id_giornata=a.id_giornata 
// where a.id_giornata=".$id_giornata ." order by a.id_partita" ;
$query2="Select a.id_sq_casa, a.id_sq_ospite, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone, a.id_giornata,
a.fattorecasa, a.numero_giocanti_casa, a.punti_casa, a.md_casa, a.gol_casa,
a.numero_giocanti_ospite, a.punti_ospiti, a.md_ospite, a.gol_ospiti,
a.id_partita, a.use_mdcasa, a.use_mdospite
FROM calendario as a 
left join sq_fantacalcio as b on a.id_sq_casa=b.id 
left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
left join giornate as g on g.id_giornata=a.id_giornata  
where a.id_giornata=".$id_giornata ." order by a.id_partita" ;

	// $query_risultati="Select *, sum(punti_casa + md_casa + fattorecasa) as tot_casa from calendario 
	// where id_giornata='" . $id_giornata . "' and id_sq_casa= '". $id_casa ."'";
$idgirone = 0;
$result_giornata=$conn->query($query2);
$num_giornata=$result_giornata->num_rows;
$j=0;
while ($row=$result_giornata->fetch_assoc()) {
	$idgirone=$row["id_girone"];
	$id_partita=$row["id_partita"];
	$id_casa=$row["id_sq_casa"];
	$id_ospite=$row["id_sq_ospite"];
	$sq_casa=$row["sq_casa"];
	$sq_ospite=$row["sq_ospite"];
	
	$addizionalecasa = $row["fattorecasa"];
	$numero_giocanti_casa = $row["numero_giocanti_casa"];
	$voto_netto_casa = $row["punti_casa"];
	$media_difesa_avversaria_casa = $row["md_casa"];
	$voto_totale_casa = $voto_netto_casa + $media_difesa_avversaria_casa + $addizionalecasa;//$row["tot_casa"];
	$gol_casa = $row["gol_casa"];

	$numero_giocanti_ospite  = $row["numero_giocanti_ospite"];
	$voto_netto_ospite = $row["punti_ospiti"];
	$media_difesa_avversaria_ospite = $row["md_ospite"];
	$voto_totale_ospite = $voto_netto_ospite + $media_difesa_avversaria_ospite;//$row["tot_ospite"];
	$gol_ospite = $row["gol_ospiti"];

	$usemdcasa = $row["use_mdcasa"];
	$usemdospite = $row["use_mdospite"];

	$query_formazione="SELECT b.id,  gv.voto, gv.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione, gv.voto_ufficio
	FROM formazioni as a 
	inner join giocatori as b 
	left join giocatori_voti as gv on b.id = gv.giocatore_id
	inner join squadre_serie_a as c 
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_casa ."' 
	and a.id_giocatore=b.id 
	and  b.id_squadra =c.id order by a.id_posizione ";
	// echo $query_formazione;
	//echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$giocatoricasa = array();
	$formazioneDefaultCasa = false;
	while ($row=$result_formazione->fetch_assoc()) {
		array_push($giocatoricasa, array(
			"id"=> $row["id"],
			"nome"=> $row["nome"],
			"squadra_breve"=>$row["squadra_breve"],
			"ruolo"=>$row["ruolo"],
			"voto"=>$row["voto"],
			"voto_ufficio"=>$row["voto_ufficio"],
			"voto_md"=>$row["voto_md"],
			"sostituzione"=>$row["sostituzione"]
			)
		);
	}	
	?>

	<?php
	$query_formazione=
	"SELECT b.id, gv.voto, gv.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione, gv.voto_ufficio
	FROM formazioni as a 
	inner join giocatori as b 
	left join giocatori_voti as gv on b.id = gv.giocatore_id
	inner join squadre_serie_a as c 
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_ospite ."' 
	and a.id_giocatore=b.id 
	and  b.id_squadra =c.id order by a.id_posizione ";

	//echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$giocatoritraferta = array();
	$formazioneDefaultOspite = false;
	while ($row=$result_formazione->fetch_assoc()) {
		array_push($giocatoritraferta, array(
			"id"=> $row["id"],
			"nome"=> $row["nome"],
			"squadra_breve"=>$row["squadra_breve"],
			"ruolo"=>$row["ruolo"],
			"voto"=>$row["voto"],
			"voto_md"=>$row["voto_md"],
			"voto_ufficio"=>$row["voto_ufficio"],
			"sostituzione"=>$row["sostituzione"]
			)
		);
	}
	
	?>
	<div id="tabellino<?php echo $id_partita ?>" class="tabellino">
		<table>
			<tr>
				<th style="width:35%"><?php echo $sq_casa; echo ($formazioneDefaultCasa? "*" : ""); ?></th>
				<th><?php echo $gol_casa; ?> - <?php echo $gol_ospite; ?></th>
				<th style="width:35%"><?php echo $sq_ospite; echo ($formazioneDefaultOspite? "*" : "");?></th>
			</tr>
			<tr style="  ">
				<td><?php echo $gol_casa; ?> </td>
				<td>GOL</td>
				<td><?php echo $gol_ospite; ?> </td>
			</tr>
			<tr style="  ">
				<td><?php echo $voto_netto_casa; ?> </td>
				<td>VOTO NETTO</td>
				<td><?php echo $voto_netto_ospite; ?> </td>
			</tr>
			<tr style="  ">
				<td><?php echo $addizionalecasa; ?> </td>
				<td>FATTORE CASA</td>
				<td>&nbsp;</td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato)? "": "display:none" ?>">
				<td><?php echo $media_difesa_avversaria_casa; ?> </td>
				<td>MEDIA DIFESA</td>
				<td><?php echo $media_difesa_avversaria_ospite; ?></td>
			</tr>
			<tr style="  ">
				<td><?php echo $voto_totale_casa; ?> </td>
				<td>VOTO TOTALE</td>
				<td><?php echo $voto_totale_ospite; ?></td>
			</tr>
			<tr style="  ">
				<td><?php echo $numero_giocanti_casa; ?> </td>
				<td># GIOCATORI</td>
				<td><?php echo $numero_giocanti_ospite; ?></td>
			</tr>
			<tr>
				<td>
				<input type="checkbox" class="usamd" id="cbmdcasa" 
					<?php echo $usemdcasa  == "1" ? "checked": ""; ?>
					data-home="1" 
					data-squadra="<?php echo $id_casa; ?>" 
					data-giornata="<?php echo $id_giornata;?>" 
					data-partita="<?php echo $id_partita;?>"> calcola media difesa casa</input></td>
				<td>&nbsp;</td>
				<td><input type="checkbox" class="usamd" id="cbmdospite" 
					<?php echo $usemdospite  == "1" ? "checked": ""; ?>
					data-home="0"
					data-squadra="<?php echo $id_ospite; ?>" 
					data-giornata="<?php echo $id_giornata;?>" 
					data-partita="<?php echo $id_partita;?>"> calcola media difesa ospite</input></td>
			</tr>
			<tr>
				<td>
					<a href="invio_formazione_squadra.php?&id_giornata=<?php  echo $id_giornata; ?>&id_girone=<?php  echo $id_girone; ?>&id_squadra=<?php  echo $id_casa; ?>">Invia Formazione</a>
				</td>
				<td>&nbsp;</td>
				<td><a href="invio_formazione_squadra.php?&id_giornata=<?php  echo $id_giornata; ?>&id_girone=<?php  echo $id_girone; ?>&id_squadra=<?php  echo $id_ospite; ?>">Invia Formazione</a> </td>
			</tr>
		</table>
	</div>
	<div class="ui-grid-a">
		
		<div class="ui-block-a" style="float:left;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_casa; ?></h3> -->
			<table  id="squadra_casa_desk<?php echo $j;?>" class="desktop">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<tr>
					<th width="3%">CAS</th>
					<th colspan="2" >Nome</th>
					<th width="10%">R</th>
					<th width="10%">V</th>
					<th width="10%">VN</th>
					<th width="10%">S</th>
				</tr>
				<?php
				$i=0;
				foreach ($giocatoricasa as $row){	
						$ruolo_giocatore=$row["ruolo"];
					?>
				
					<tr id=row_<?php  echo $id_casa  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
					?>">
						<?php
							// echo $nome_giocatore;
							$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate'> Titolari</div></td>";  } ?>
						<?php if ($i==11) {echo "<td rowspan='10' style='background-color: rgba(51,102,255,0.4);'><div class='rotate' > Riserve </div></td>";  } ?>	
						<!-- <td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td> -->
						<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
						<td ><?php echo $row["voto"]; ?> <?php echo $row["voto_ufficio"] ? "*": ""; ?></td>
						<td ><?php echo $row["voto_md"] ?></td>
						<td class="sostituzione">
							<?php  
							if ($i<11) 
							{echo "&nbsp;";}
							else{
								if($row["sostituzione"] == 1){
									echo	"<input id=\"hf".$row["id"]."\" type='hidden' data-id_giocatore=\"".$row["id"]."\" value=\"1\"/>";
								}
								else{
									echo	"<input id=\"hf".$row["id"]."\" type='hidden' data-id_giocatore=\"".$row["id"]."\" value=\"0\"/>";
								}
								echo	"<input class=\"cbFormazione\" id=\"cb".$row["id"]."\" type='checkbox'" 
								. " data-id_giocatore=\"".$row["id"] ."\"" 
								. " data-id_giornata=\"".$id_giornata ."\""
								. " data-id_squadra=\"" .$id_casa ."\""
								."/>";
							}
							?>
						</td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>
			
			<table  id="squadra_casa_mobile<?php echo $j;?>" class="mobile">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<!-- <tr> 
					<th >Giocatore</th>
					<th width="15%">VOTO</th> 
				</tr> -->
				<?php
				$i=0;
				foreach ($giocatoricasa as $row){	
						$ruolo_giocatore=$row["ruolo"];
					?>
				
					<tr id=row_<?php  echo $id_casa  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
					?>">
						<?php
							// echo $nome_giocatore;
							$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<td >
					<?php 
							// echo  ($row["sostituzione"] == 1  ? '<i class="fas fa-arrow-left" style="color:springgreen"></i>' : ""); 
					?>	
						<div class="<?php echo ($disable)? "disable": "" ?>">
						<div >
							<?php 
								echo '<span class="truncate">'. $row["nome"] .'</span><span class="truncate">('.$row["squadra_breve"] .")</span>"
							?>
						</div>
					</div>

					<?php 
							// echo ($row["voto"] == "" &&  $i < 11 ? '<i class="fas fa-arrow-right" style="color:red"></i>' : ""); 
					?>
					</td>
					<td style="width:10%"> 
						<?php 
							echo (($row["sostituzione"] == 1 || $i < 11) && $row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
						?>
					</td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>
		</div>

	
	
		
		<div class="ui-block-b" style="float:right;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_ospite; ?></h3> -->
			<table id="squadra_ospite_desk<?php echo $j;?>" class="desktop">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->
				<th colspan="2" >Nome</th>
				<th width="10%">R</th>
				<th width="10%">V</th>
				<th width="10%">VN</th>
				<th width="3%">OSP</th>
				<th width="10%">S</th>
				<?php
				$i=0;
				foreach ($giocatoritraferta as $row){	
					$ruolo_giocatore=$row["ruolo"];
				?>
					<tr id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
				?>">
				<?php
						// echo $nome_giocatore;
						$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
				
					<!-- <td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td> -->
					<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
					<td ><?php echo $row["voto"]; ?> <?php echo $row["voto_ufficio"] ? "*": ""; ?></td>
					<td ><?php echo $row["voto_md"] ?></td>
					<td class="sostituzione">
							<?php  
							if ($i<11) 
							{echo "&nbsp;";}
							else{
								if($row["sostituzione"] == 1){
									echo	"<input id=\"hf".$row["id"]."\" type='hidden' data-id_giocatore=\"".$row["id"]."\" value=\"1\"/>";
								}
								else{
									echo	"<input id=\"hf".$row["id"]."\" type='hidden' data-id_giocatore=\"".$row["id"]."\" value=\"0\"/>";
								}
								echo	"<input class=\"cbFormazione\" id=\"cb".$row["id"]."\" type='checkbox'" 
								. " data-id_giocatore=\"".$row["id"] ."\"" 
								. " data-id_giornata=\"".$id_giornata ."\""
								. " data-id_squadra=\"" .$id_ospite ."\""
								."/>";
							}
							?>
						</td>
					<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate2'> Titolari</div></td>";  } ?>
					<?php if ($i==11) {echo "<td rowspan='10' style='background-color: rgba(51,102,255,0.4);'><div class='rotate2'> Riserve </div></td>";  } ?>
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>

			<table  id="squadra_ospite_mobile<?php echo $j;?>" class="mobile">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->
				
				<!-- <tr> 
					<th >Giocatore</th>
					<th width="15%">VOTO</th> 
				</tr> -->

				<?php
				$i=0;
				foreach ($giocatoritraferta as $row){	
					$ruolo_giocatore=$row["ruolo"];
				?>
					<tr id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
				?>">
				<?php
						// echo $nome_giocatore;
						$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
					<td >
						<?php 
								// echo  ($row["sostituzione"] == 1  ? '<i class="fas fa-arrow-left" style="color:springgreen"></i>' : ""); 
						?>	
						<div class="<?php echo ($disable)? "disable": "" ?>">
							<div >
								<?php 
									echo '<span class="truncate">'. $row["nome"] .'</span><span class="truncate">('.$row["squadra_breve"] .")</span>"
								?>
							</div>
						</div>

						<?php 
								// echo ($row["voto"] == "" &&  $i < 11 ? '<i class="fas fa-arrow-right" style="color:red"></i>' : ""); 
						?>
					</td>
					<td style="width:10%"> 
						<?php 
							echo (($row["sostituzione"] == 1 || $i < 11) && $row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
						?>
					</td>
					
					
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>
		</div>
	
<hr style="display: inline-block;width: 100%;">
<?php
++$j;
if($formazioneDefaultCasa || $formazioneDefaultOspite){
echo "<div style=\"text-align: center;\"><i>* formazione di default</i></div>";}
echo '</div>';
} # end incontri
?>
<!-- <button type="button" id="btn_invia">Invia Voti</button> -->
<a href="amministra_voti.php?giornata_serie_a_id="<?php echo $id_giornata; ?>" >Voti</a>
<input type="hidden" id="hfIdGirone" value='<?php echo $idgirone; ?>'>
<button type="button" id="btn_calcola">Calcola Risultati</button>
<button type="button" id="btn_cancella" data-idgiornata="<?php echo $id_giornata;?>" >Reset Risultati</button>

<?php
$query="select * from giornate where id_giornata=". $id_giornata;
#echo $query;
$result_commento=$conn->query($query);
#$num_commento=mysql_numrows($result_commento);
$commento=$result_commento->fetch_assoc()["commento"];

?>


<p>  Il commento del presidente: <br> </p>
  <textarea name="commento" rows="10" cols="30" id="txt_commento"> <?php echo $commento ?></textarea>
  <br><br>
<button type="button" id="btn_commento"> Invia commento </button>

<h2> Messaggi Telegram</h2>

 <form action="send_message_giornata.php" method="post">

	<input type="checkbox" name="calcolo" value='1' /> Calcolo fatto<br>
	<input type="checkbox" name="risultati" value='1' /> Risultati<br>
	<input type="checkbox" name="classifiche" value='1' /> Classifica<br>
	<input type="checkbox" name="commento" value='1' /> Commento<br>
	<input type="hidden" name="id_giornata" value=<?php echo $id_giornata;?> />
	<input type="submit" value="Submit">
</form> 
    
<?php 
include("../footer.php");
?>