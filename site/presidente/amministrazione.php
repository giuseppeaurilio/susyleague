<?php 
include("menu.php");
?>
<h1>Menu amministratore</h1>
	<h2>Strumenti del presidente</h2>
	<ul class="lista">
		<li><a href="calcola_risultati.php" >Calcola risultati</a></li>	
		<li><a href="amministra_annunci.php" >Annunci del presidente</a></li>	
		<li><a href="amministra_sondaggi.php" >Sondaggi</a></li>
		<li><a href="amministra_fustometro.php" >Fustometro</a></li>
		<li><a href="amministra_leperlediiori.php" >Le perle di Iori</a></li>
		<li><a href="amministra_vincitori.php" >Vincitori</a></li>
	</ul>
	<h2>Serie A</h2>
	<ul class="lista">
		<li><a href="amministra_giornate_serie_a.php">Giornate Serie A</a></li>
		<li><a href="carica_giocatori.php">Database giocatori</a></li>
		<li><a href="amministra_giocatori.php" >Amministra Giocatori</a></li>	
		<li><a href="amministra_voti.php" >Inserisci Voti</a></li>	
	</ul>
	<h2>Fantasquadre</h2>
	<ul class="lista">
		<li><a href="amministra_squadre.php" >Fantapresidenti</a></li>
		<li><a href="genera_nuovo_anno.php">Genera nuovo anno</a></li>
		<li><a href="amministra_rose.php" >Amministra Rose</a></li>
		<li><a href="amministra_scambi.php" >Amministra Scambi</a></li>
	</ul>
	<h2>Campionato</h2>
	<ul class="lista">	
		<li><a href="genera_calendario_campionato.php" >Genera Calendario</a></li>
		<li><a href="amministra_giornate.php" >Calendario Incontri</a></li>
		<li><a href="finale_campionato.php" >Finale Campionato</a></li>
		<!-- <li><a href="amministra_popo.php" >Amministrazione Calendario Play-off Play-out</a></li> -->
	</ul>
	<h2>Coppa Italia</h2>
	<ul class="lista">	
		<li><a href="coppaitalia_gironi.php" >Gironi </a></li>
		<li><a href="coppaitalia_calendario.php" >Calendario Incontri</a></li>
		<li><a href="coppaitalia_tabellone.php" >Incontri Tabellone</a></li>
		<li><a href="finale_coppaitalia.php" >Finale</a></li>
	</ul>
	<h2>Coppa delle Coppe</h2>
	<ul class="lista">	
		<li><a href="coppacoppe_girone.php" >Girone</a></li>
		<li><a href="coppacoppe_calendario.php" >Calendario Incontri</a></li>
	</ul>
	<h2>Supercoppa</h2>
	<ul class="lista">	
		<li><a href="finale_supercoppa.php" >Supercoppa</a></li>
	</ul>


<h2>Regolamento (regolamento.pdf)</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Selziona File da inserire:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" name="submit">
</form>



<br>

<?php 
if(isset($conn))
{$conn->close();}
include("../footer.html");
?>
