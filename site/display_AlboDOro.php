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
<h2>SusyLeague - Albo D'oro</h2>

<div>
<h3>Campionato Susy league</h3>
	<div>
		<h4>2002/2003</h4>
		<div>Vincitore</div>
		<div>Real Baucao</div>
		<div>Carlo Perciballi</div>

		<div>Secondo</div>
		<div>As 433</div>
		<div>Fernando Fiorini</div>
	</div>

	<div>
		<h4>2003/2004</h4>
		<div>Vincitore</div>
		<div>S.C.A.P.P.E.T</div>
		<div>Giuseppe Aurilio</div>

		<div>Secondo</div>
		<div>As 433</div>
		<div>Fernando Fiorini</div>
	</div>

	<div>
		<h4>2003/2004</h4>
		<div>Omissis</div>
	</div>

	<div>
		<h4>2003/2004</h4>
		<div>Omissis</div>
		<div>Ultima stagione a girone unico</div>
	</div>

</div>


<div>
<h3>Coppa delle Coppe</h3>
	<div> prima edizione 2012</div>
	<div>
		<h4>2012</h4>
		<div>Vincitore</div>
		<div>Atletico ci sarai tu</div>
		<div>Antonio Palombizio</div>
		
		<div>Secondo</div>
		<div>FC Daje de tacco</div>
		<div>Peppino</div>
	</div>
</div>

<div>
<h3>Coppa Italia</h3>
	<div> prima edizione 2019/20</div>
	<div>
		<h4>2012</h4>
		<div>Vincitore</div>
		<div>Atletico ci sarai tu</div>
		<div>Antonio Palombizio</div>
		
		<div>Secondo</div>
		<div>FC Daje de tacco</div>
		<div>Peppino</div>
	</div>
</div>

<div>
<h3>Supercoppa</h3>
	<div> prima edizione 2020/21</div>
	<div>
		<h4>2012</h4>
		<div>Vincitore</div>
		<div>Atletico ci sarai tu</div>
		<div>Antonio Palombizio</div>
		
		<div>Secondo</div>
		<div>FC Daje de tacco</div>
		<div>Peppino</div>
	</div>
</div>
<?php 
include("footer.php");
?>