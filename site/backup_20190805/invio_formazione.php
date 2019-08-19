<?php
session_start();
date_default_timezone_set('Europe/Rome');

#$date1 = date_create_from_format('d-m-Y H:i:s', '18-08-2015 23:20:10');

$adesso = date('Y-m-d H:i:s');

#print_r($adesso);

include("dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query_giornate="SELECT * from giornate where inizio <' " . $adesso ." ' and fine >'" . $adesso . "'";





$result_giornate=mysql_query($query_giornate);

$num_giornate=mysql_numrows($result_giornate); 

if ($num_giornate>0) {

	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	header ("Location: login.php?&caller=invio_formazione.php");
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra= $_SESSION['login'];
	}
	
	include("menu.php");
    
    ?>
    <style>
	table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	}


	ul#squadre li {
    display:inline;
	}


	</style>
    <?php
	//echo "allenatore=" . $allenatore;
	$i=0;
	while ($i < $num_giornate) {
		$id=mysql_result($result_giornate,$i,"id_giornata");
		$inizio=mysql_result($result_giornate,$i,"inizio");
		$fine=mysql_result($result_giornate,$i,"fine");
		$query2="SELECT a.id_sq_casa as id_casa, a.id_sq_ospite as id_ospite, b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id ." order by a.id_partita" ;
		#echo $query2;
		$result_giornata=mysql_query($query2);
		$num_giornata=mysql_numrows($result_giornata);
		?>
		<h2><?php echo "Giornata " .$id;?></h2>
		<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>
		<?php
		$j=0;
		while ($j < $num_giornata) {
			$id_casa=mysql_result($result_giornata,$j,"id_casa");
			$id_ospite=mysql_result($result_giornata,$j,"id_ospite");
			$punti_casa=mysql_result($result_giornata,$j,"punti_casa");
			$gol_casa=mysql_result($result_giornata,$j,"gol_casa");
			$sq_casa=mysql_result($result_giornata,$j,"sq_casa");
			$sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");
			$gol_ospite=mysql_result($result_giornata,$j,"gol_ospiti");
			$punti_ospite=mysql_result($result_giornata,$j,"punti_ospiti");
			$link="invio_formazione_squadra.php"
			?>
			<ul id="squadre">

			<?php
			if ($id_squadra==$id_casa) {
  			echo '<li><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_casa . '">'. $sq_casa .'</a></li>';
			}
			else {
			echo '<li>' .$sq_casa .'</li>';
			}
			?>
    			<li> - </li>
    					<?php
			if ($id_squadra==$id_ospite) {
  			echo '<li><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_ospite . '">'. $sq_ospite .'</a></li>';
			}
			else {
			echo '<li>' .$sq_ospite .'</li>';
			}
			?>
			
			</ul>
			<?php
			++$j;
		} 
		echo "</table>";
		++$i;
		} 
mysql_close();
}

?>
<?php
include("footer.html");

?>

</body>
</html>
