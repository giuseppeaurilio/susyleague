<?php 
session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	$id_squadra_logged="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
}
include_once ("menu.php");

?> 
<h2>Organo direttivo</h2>
<div class="organigramma">
	<div class="carica">
		<div class="titolo">Presidentissimo e autorità massima</div>
		<div class="nome">Dr. Avv. Luca Micheli</div>
	</div>

	<div class="carica">
		<div class="titolo">Segretario di federazione </div>
		<div class="nome">Ill. Dr. Ing. Prof. Gran Duc. Marco Mauti</div>
	</div>

	<div class="carica">
		<div class="titolo">Capo-cantiniere </div>
		<div class="nome">Ing. Peppe Palanka</div>
	</div>

	<div class="carica">
		<div class="titolo">Vice-cantiniere </div>
		<div class="nome">Massimetto</div>
	</div>

	<div class="carica">
		<div class="titolo">Cantiniere aggiuntivo</div>
		<div class="nome">Prof. Daniele Fornaro</div>
	</div>

	<div class="carica">
		<div class="titolo">Official Sponsor</div>
		<div class="nome">Centro Tim di N.G.</div>
	</div>
<div>
<?php 
include_once ("footer.php");
?> 