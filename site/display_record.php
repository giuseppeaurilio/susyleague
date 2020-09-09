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
<h2>SusyLeague - Statistiche e curiosità</h2>

<div>
<h3>Campionato Susy league</h3>
	<div>
		<h4>Partita con piu gol</h4>
		<div>stagione</div>
		<div>XXX vs YYY 5-5</div>
	</div>
</div>


<?php 
include("footer.php");
?>