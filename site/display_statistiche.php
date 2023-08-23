<?php 
include_once ("menu.php");

?>
<script>

var astaincorso = false;
loadStatsDialog = function(id)
{
    // debugger;
    
    var action ="stats";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": id,
				"limit": '',
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

cercagiocatori = function()
{
    var action ="liststats";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "anno": $("#anno").val(),
				"ruolo": $("#ruolo").val(),
				"idsquadra": $("#squadra").val(),
				"idsquadrafc": $("#squadrafc").val(),
				"giocate": $("#txtPartiteGiocate").val(),
				"mediavoto": $("#txtMediaVoto").val(),
				"fantamedia": $("#txtFantamedia").val(),
				"golfatti": $("#txtGolFatti").val(),
				"assist": $("#txtAssist").val(),
				"ammonizioni": $("#txtAmmonizioni").val(),
				"espulsioni": $("#txtEspulsioni").val(),
				"autogol": $("#txtAutogol").val(),
				"quotazione": $("#txtQuotazione").val(),
				"ordinamento": $("#ordinamento").val(),
            },
            success:function(data){
               // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
					var template = $('#tmpllistagiocatori').html();
					Mustache.parse(template);   // optional, speeds up future uses
					var rendered = Mustache.render(template, resp);
					$("#tblGiocatori > tbody").remove()
					$("#tblGiocatori").append(rendered);
					// $("#tblGiocatori > tbody tr").unbind().bind("click", { id: $(this).data("id")},  function(){alert ($(this).data("id")); }
					// $("#tblGiocatori > tbody tr").unbind().bind("click", function(){
					// 	loadStatsDialog($(this).data("id")); 
					// 	} 
					// );						
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
	$("#squadrafc").val("");
	$("#txtMediaVoto").val("");
	$("#txtFantamedia").val("");
	$("#txtGolFatti").val("");
	$("#txtAssist").val("");
	$("#txtAutogol").val("");
	$("#txtAmmonizioni").val("");
	$("#txtEspulsioni").val("");
	$("#txtQuotazione").val("");
   
}

$(document).ready(function(){
    // cercagiocatori();
	$("#btnCerca").unbind().bind("click",cercagiocatori);
    $("#btnResetFiltri").unbind().bind("click",resetFiltri);
})
</script>

<script id="tmplStats" type="x-tmpl-mustache">
	<h3>
	    {{ stats.0.nome }} ({{ stats.0.squadra_breve }}) - {{ stats.0.ruolo }}
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

<script id="tmpllistagiocatori" type="x-tmpl-mustache">
	<tbody>
        {{#giocatori}}
            <tr data-id="{{ id }}"> 
                <td style="text-align:left;">{{ nome }}
					&nbsp;
					<a style='float: right;font-size: small; color:black;' target='_blank' 
					href='https://www.fantacalcio.it/squadre/Giocatore/{{ nome }}/{{ id }}'><i class='fas fa-external-link-alt'></i>
				</td>
                <td>{{ ruolo }}</td>
				<td>{{ squadra_breve }}</td>
				<td style="text-align:left;">{{ fantasquadra }}</td>
				<td>{{ pg }}</td>
				<td>{{ mv }}</td>
				<td>{{ mf }}</td>
				<td>{{ gf }}</td>
				<td>{{ gs }}</td>
				<td>{{ rp }}</td>
				<td>{{ rc }}</td>
				<td>{{ rseg }}</td>
				<td>{{ rsba }}</td>
				<td>{{ ass }}</td>
				<td>{{ asf }}</td>
				<td>{{ amm }}</td>
				<td>{{ esp }}</td>
				<td>{{ au }}</td>
				<td>{{ quo }}</td>
            </tr>
        {{/giocatori}}
	</tbody>

</script>

<?php
//load squadre serie a 
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
//fine load squadre  serie a 
?>

<?php
//load squadre fantacalcio
// $query="SELECT * FROM sq_fantacalcio order by squadra";

// $result=$conn->query($query);
// $squadrefc = array();
// while($row = $result->fetch_assoc()){
// 	// $id=mysql_result($result,$i,"id");
	
// 	array_push($squadrefc, array(
// 		"id"=>$row["id"],
// 		"squadra"=>$row["squadra"]
// 		)
// 	);
// }
//fine load squadre fantacalcio
include_once ("DB/fantacalcio.php");
$squadrefc = fantacalcio_getFantasquadre();
include_once ("DB/parametri.php");
?>
<h2>Statistiche giocatori
	
</h2>
<h3 style="text-align:center">Anno:
		<select name="anno" id="anno">			
			<option value="<?php  echo getAnno(); ?>" selected><?php  echo getAnno(); ?></option>	
			<option value="22/23">22/23</option>	
			<option value="21/22">21/22</option>
			<option value="20/21">20/21</option>
			<option value="19/20">19/20</option>
			<option value="18/19">18/19</option>
			<option value="17/18">17/18</option>
			<option value="16/17">16/17</option>
			<option value="15/16">15/16</option>
		</select>
		Ordina per: 
		<select name="ordinamento" id="ordinamento">			
			<!-- <option value="" >-Ordinamento-</option> -->
			<option value="mv-a" >Media voto &uarr;</option>
			<option value="mv-d" >Media voto &darr;</option>
			<option value="fm-a" >Fantamedia &uarr;</option>
			<option value="fm-d" selected>Fantamedia &darr;</option>
			<option value="pg-d">Partite giocate &darr;</option>
			<option value="gf-d">Gol fatti &darr;</option>
			<option value="gs-d">Gol subiti &darr;</option>
			<option value="rp-d">Rigori parati &darr;</option>
			<option value="rc-d">Rigori calciati &darr;</option>
			<option value="ass-d">Assist &darr;</option>
			<option value="amm-d">Ammonizioni &darr;</option>
			<option value="esp-d">Espulsioni &darr;</option>
			<option value="aut-d">Autogol &darr;</option>
			<option value="quo-d">Quotazione &darr;</option>
		</select>
		<input type="button" value="cerca" id="btnCerca">
		<input type="button" value="reset" id="btnResetFiltri">    
	</h3>
<div class="maincontent">
	<!-- <div class="" id="divFiltri" style="width:100%; text-align:center;"> -->
	
	<!-- </div> -->
	
    <div id="divlistagiocatori" style="overflow-x: auto; text-align: center;">
		<table border="0" cellspacing="2" cellpadding="2" id="tblGiocatori">
			<thead>
				<tr>
					<th>Giocatore</th>
					<th style="width: 40px;">
					Ruo: <br>
						<select name="ruolo" id="ruolo" style="width: 40px;">
							<option value="">-R-</option>	
							<option value="P">Portiere</option>
							<option value="D">Difensore</option>
							<option value="C">Centrocampista</option>
							<option value="A">Attaccante</option>
						</select>
					</th>
					<th>Squadra: <br>
					<?php
						echo '<select id="squadra" name="squadra">';
						echo '<option value="">-Squadra-</option>';
						foreach($squadre as $squadra)
						{
							echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra_breve"] . '</option>';
						}
						echo '</select>';
					?>
					</th>
					<th>
					Fantasquadra: <br>
					<?php
						echo '<select id="squadrafc" name="squadrafc">';
						echo '<option value="">-Fantasquadra-</option>';
						echo '<option value="-1">*Qualsiasi</option>';
						echo '<option value="0">*Libero</option>';
						foreach($squadrefc as $squadrafc)
						{
							echo '<option value=' . $squadrafc["id"] . '>'. $squadrafc["squadra"] . '</option>';
						}
						echo '</select>';
					?>
					</th>
					<th style="width: 40px;">
						Gio.: <br>
						<input type="number" style="width: 40px;" id="txtPartiteGiocate" min="0" max="38" step="1" placeholder="Gio.">
					</th>
					<th style="width: 40px;">
						M. V.: <br>
						<input type="number" style="width: 40px;" id="txtMediaVoto" min="0" max="10" step="0.1" placeholder="MV">
					</th>
					<th style="width: 40px;">
						FM: <br>
						<input type="number" style="width: 40px;" id="txtFantamedia" min="0" max="20" step="0.1" placeholder="FM">
					</th>
					<th style="width: 40px;">
						G.Fatti: <br>
						<input type="number" style="width: 40px;" id="txtGolFatti" min="0" max="99" step="1" placeholder="G.fatti">
					</th>
					<th style="width: 40px;">Gol subiti</th>
					<th style="width: 40px;">Rig. parati</th>
					<th style="width: 40px;">Rig. calciati</th>
					<th style="width: 40px;">Rig. segnati</th>
					<th style="width: 40px;">Rig. sbagliati</th>
					<th>
						Ass.: <br>
						<input type="number" style="width: 40px;" id="txtAssist" min="0" max="99" step="1" placeholder="Ass">
					</th>
					<th style="width: 40px;">
						Ass. Fermo
						
					</th>
					<th>
						Amm.: <br>
						<input type="number" style="width: 40px;" id="txtAmmonizioni" min="0" max="99" step="1" placeholder="Amm">
					</th>
					<th>
						Esp.: <br>
						<input type="number" style="width: 40px;"  id="txtEspulsioni" min="0" max="99" step="1" placeholder="Esp">
					</th>
					<th>
						Aut.: <br>
						<input type="number" style="width: 40px;" id="txtAutogol" min="0" max="99" step="1" placeholder="Aut">
					</th>
					<th>
						Quo.: <br>
						<input type="number" style="width: 40px;" id="txtQuotazione" min="0" max="99" step="1" placeholder="Quo">
					</th>
				</tr>
			</thead>
		</table>
    </div>
</div>
<?php 
include_once ("footer.php");
?>
