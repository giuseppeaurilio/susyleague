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
include("menu.php");

?>
<h2>SusyLeague - Organo direttivo</h2>
<div>
<h3>Presidentissimo eautorità massima</h3>
<div>Dr. Avv. Luca Micheli</div>
</div>
<div>
<h3>Segretario di federazione</h3>
<div>Ill. Dr. Ing. Prof. Gran Duc. Marco Mauti</div>
</div>

<div>
<h3>capo-cantiniere </h3>
<div>Ing. Peppe Palanka</div>
</div>

<div>
<h3>vice-cantiniere </h3>
<div>Massimetto</div>
</div>

<div>
<h3>cantiniere aggiuntivo</h3>
<div>Prof. Daniele Fornaro</div>
</div>

<div>
<h3>Official Sponsor</h3>
<div>Centro Tim di N.G.</div>
</div>

<?php 
include("footer.php");
?>