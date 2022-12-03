<!DOCTYPE html>
<html>
<body>

<?
include_once ("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");




$tipo=mysql_escape_String($_GET['tipo']);

//echo "tipo = " . $tipo . "<br>";

define("num_squadre",     12);



function aggiungi($init_tabellone, $x, $y) {

//print_r($init_tabellone);

//var_dump(num_squadre);
//stop condition
if (($y<num_squadre) and ($x<num_squadre+1)) {
$possibili=calcola_possibili($init_tabellone, $x, $y);


	if (!empty($possibili)){
		$aggiunto=array();
		$k=1;

		//echo "shuffle done <br>";

		shuffle($possibili);
		//echo "<br>";
		//echo $x . "-" . $y . "<br>";
		//echo "possibili<br>";
		//print_r($possibili);
		//echo "<br>";
		$giornata=array_shift($possibili);
		//echo "gioranta selezionata tentativo 1 = ";		
		//var_dump($giornata);
		//echo "<br>";
		
		
		while (empty($aggiunto) and !is_null($giornata)){
		
		//echo $x . "-" . $y . "<br>";
		//echo "gioranta selezionata tentativo ". $k ."=";		
		//var_dump($giornata);
		//echo "<br>";

		
			$init_tabellone[$x][$y]=$giornata;

		
		
			if ($y==$x-1) {
		   		$aggiunto=aggiungi($init_tabellone, $x+1, 1);
	
			}
			else {
		  		$aggiunto=aggiungi($init_tabellone, $x, $y+1);
			}
			//echo "<br>tabellone aggiunto <br>";
			//print_r($aggiunto);

			$k++;
			$giornata=array_shift($possibili);
		} //end while
		return $aggiunto;
	}//end if possibili
	else
	return NULL;
	//echo "errore";
} //end if
	return $init_tabellone;
}// end functions aggiungi


function calcola_possibili($tabellone, $x, $y) {
$possibily=array();
for ($i = 1; $i <= num_squadre-1; $i++) {
    $possibili[$i] = $i;
} // next $i




//echo "<br>";
//echo "tabellone";
//print_r($tabellone);

//echo "<br>";
//echo "Possibili_prima";
//print_r($possibili);
for ($j = 1; $j <= num_squadre; $j++) {
//   echo "<br>";
//    var_dump ($tabellone[$x][$j]);
//    var_dump ($possibili[$tabellone[$x][$j]]);
    unset($possibili[$tabellone[$x][$j]]);
    unset($possibili[$tabellone[$y][$j]]);
    unset($possibili[$tabellone[$j][$x]]);
    unset($possibili[$tabellone[$j][$y]]);
} //next $j

//echo "<br>";
//echo "Possibili_dopo";
//print_r($possibili);


return $possibili;



} //end calcola_possibili





function aggiungi_db($giornata, $casa, $ospite) {
//echo "aggiungo " .$giornata . "sq_casa= " . $casa . "sq_ospite= " . $ospite . "<br>";
//INSERT INTO `calendario` (`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES ('3', '9', '10');

$query="INSERT INTO `calendario`(`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES (" . $giornata .",". $casa .",".  $ospite .")";
$result=mysql_query($query);
echo $query . "<br>";
//echo $result . "<br>";
}

echo "avvio calcolo calendario";

$tabellone = array();

$finale=aggiungi($tabellone, 2, 1);

		
		
//echo "<br>";
//echo "finale <br>";	
//print "<pre>";
//print_r($finale);
//print "</pre>";

//$query="truncate `calendario`";
//$result=mysql_query($query);
//$query="truncate `giornate`";
//$result=mysql_query($query);



$query="SELECT MAX(id_giornata) FROM susy79_league.calendario";
$result=mysql_query($query);
$last_giornata=mysql_result($result,0,"MAX(id_giornata)");
echo "<br>" . "Ultima giornata= " . $last_giornata . "<br>";

$query="SELECT MAX(id_girone) FROM susy79_league.gironi";
$result=mysql_query($query);
$last_girone=mysql_result($result,0,"MAX(id_girone)");
echo "<br>" . "Ultimo girone= " . $last_girone . "<br>";


######  Definizione Calendario

for ($i=2;$i<=num_squadre; $i++) {
	for ($j=1; $j < $i; $j++) {
		$giornata=$finale[$i][$j];
		if ($tipo==1){
			$a=rand(0,1);
			if ($a==1) {
				aggiungi_db($last_giornata+$giornata, $i, $j);
				aggiungi_db($last_giornata+$giornata + num_squadre -1 , $j, $i);
			}//end if $a=1
			else
			{
				aggiungi_db($last_giornata+$giornata, $j, $i);
				aggiungi_db($last_giornata+$giornata + num_squadre -1 , $i, $j);
			}//end else $a=1
		
		} //end tipo 1
	else aggiungi_db($last_giornata+$giornata, $i, $j);
	
	}// end for j
} // end for i

######  Definizione Giornate

$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`) VALUES (NULL, NULL, NULL)";
for ($i=1;$i<=(2*(num_squadre-1)); $i++){
	$giornata=$i+$last_giornata;
	$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (" . $giornata .", NULL, NULL," . ($last_girone+1) .")";
	echo $query . "<br>";
	## Correzione da verificare
	##if ($i<num_squadre-1) {
	if ($i<num_squadre) {
		$pippo=1;
		$result=mysql_query($query);
	}//end if prima meta'
	else {
		if ($tipo==1) {
		$pippo=2;
		$result=mysql_query($query);
		}//end if tipo 1
	}//end if prima meta'

}//end for

######  Definizione Girone

if ($tipo==1) {
	$query="INSERT INTO `susy79_league`.`gironi` (`id_girone`, `add_casa`, `nome`) VALUES (". ($last_girone+1) ." , 1, 'Apertura')";
	}
	else {
	$query="INSERT INTO `susy79_league`.`gironi` (`id_girone`, `add_casa`, `nome`) VALUES (". ($last_girone+1) ." , 0, 'Chiusura')";
	}
echo "<br>".$query;
$result=mysql_query($query);
	
echo "Calendario generato correttamente";





?>


</body>
</html>
