<?php
//
//echo "<body>";
//echo "<h1>LOG creazione anno</h1>";

$nuovo_anno=$_POST['anno'];
$precedente_anno = ((int)(explode("/", $nuovo_anno)[0])-1)."_".((int)(explode("/", $nuovo_anno)[1])-1);
$fantamilioni=$_POST['fantamilioni'];

session_destroy();
    
//echo $nuovo_anno;
//echo $fantamilioni;

$n=12;

include_once ("menu.php");

include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();
include_once "../DB/parametri.php";
$numSquadre = getNumeroFantasquadre();


function aggiungi_giornata($giornata,$girone) {
	$query="INSERT INTO .`giornate` (`id_giornata`,`id_girone`) VALUES (" . $giornata ."," . ($girone) .")";
    // $result=mysql_query($query);
    // global $conn;
    $conn = getConnection();
    $conn->query($query);
	echo $query ."<br>";

}


//////////
/// CANCELLA DATI PRECEDENTI

$query="Truncate `giornate`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `calendario`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `formazioni`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `formazione_standard`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `rose`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="DROP TABLE IF EXISTS rose_asta_". str_replace("/","_", $precedente_anno) ;
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="CREATE TABLE rose_asta_". str_replace("/","_", $precedente_anno) ." AS SELECT * FROM rose_asta";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);



$query="Truncate `rose_asta`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

// $query="Truncate `vincitori`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);

$query="DROP TABLE IF EXISTS giocatori_". str_replace("/","_", $precedente_anno) ;
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="CREATE TABLE giocatori_". str_replace("/","_", $precedente_anno) ." AS SELECT * FROM giocatori";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `giocatori`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `giocatori_voti`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `giocatori_pinfo`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `squadre_serie_a`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `giornate_serie_a`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

// $query="Truncate `sondaggi`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);


// $query="Truncate `sondaggi_opzioni`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);

// $query="Truncate `sondaggi_risposte`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);

$query="Truncate `mercato`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `gironi_ci_squadre`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);


$query="Truncate `gironi_tc_squadre`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `contafusti`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `scambi`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `scambi_dettagli`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

// $query="Truncate `annunci`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);

// $query="Truncate `annunci_dettagli`";
// echo $query;
// // $result=mysql_query($query);
// $result=$conn->query($query);

$query="Truncate `vincitori`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="INSERT INTO `vincitori`(`id_girone`) VALUES (1) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);
$query="INSERT INTO `vincitori`(`id_girone`) VALUES (2) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);
$query="INSERT INTO `vincitori`(`id_girone`) VALUES (6) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);
$query="INSERT INTO `vincitori`(`id_girone`) VALUES (7) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);
$query="INSERT INTO `vincitori`(`id_girone`) VALUES (8) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);
$query="INSERT INTO `vincitori`(`id_girone`) VALUES (9) ";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

/////////
/// AGGIORNA PARAMETRI GENERALE
$query="UPDATE `generale` SET `valore`='" .$fantamilioni . "' WHERE `id_parametro`='2'";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

echo "anno=" . $nuovo_anno;
$query="UPDATE `generale` SET `valore`='" .$nuovo_anno ."' WHERE `id_parametro`='1'";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="UPDATE `sq_fantacalcio` SET `ammcontrollata`=0, `ammcontrollata_anno`=0";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

//genero le giornate di serie a

for ($giornata = 1; $giornata <= 38; $giornata++) {
    $query="INSERT INTO `giornate_serie_a` (`id`, `descrizione`) VALUES (NULL, 'Giornata ". $giornata ."') ";
    echo $query;
    // $result=mysql_query($query);
    $result=$conn->query($query);
}

// // GENERA CALENDARIO
// $tabellone=generateRoundRobinPairings($n);

// $map=range(1, $n);
// $globalgiornatecounter = 0;
// /////////////////////////
// //  GENERA GIRONE ANDATA
// shuffle($map);
// //echo "<br> mappa <br>";
// //print_r($map);

// $tabellone_shuffled=mappa($tabellone,$map);

// echo "<br> Inizio Tabellone shuffled <br>";
// for ($giornata = 1; $giornata < $n; $giornata++) {
// $element=$tabellone_shuffled[$giornata];
// echo "<br> unwrappato " . $giornata ."<br>";
// print_r($element);
// }
// echo "<br> Fine Tabellone Shuffled  <br>";

for ($giornata = 1; $giornata <= 2*($numSquadre -1); $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
	aggiungi_giornata($giornata,"1");
	$globalgiornatecounter = $giornata;
}


// /////////////////////
// // GENERA GIRONE RITORNO

// shuffle($map);
// //echo "<br> mappa <br>";
// //print_r($map);

// $tabellone_shuffled=mappa($tabellone,$map);

// echo "<br> Inizio Tabellone shuffled <br>";
// for ($giornata = 1; $giornata < $n; $giornata++) {
// $element=$tabellone_shuffled[$giornata];
// echo "<br> unwrappato " . $giornata ."<br>";
// print_r($element);
// }

// echo "<br> Fine Tabellone Shuffled  <br>";

for ($giornata = 2*($n-1)+1; $giornata <= 3*($numSquadre -1); $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
	aggiungi_giornata($giornata,"2");
    $globalgiornatecounter = $giornata;
		
	
}

/////////////////////
// GENERA GIRONE POPO

// for ($giornata = 3*($n-1)+1; $giornata <= 3*($n-1)+4; $giornata++) {
// //echo "casa= ". $element[1] . "ospite= " $element[1];
// aggiungi_giornata($giornata,"3");
// }

/////////////////////
// GENERA giornate per Girone Coppa Italia A
// visto che ogni incontro della giornata apuò essere giocato in qualunque turno della serie A, devo generare tante giornate 
// quanti sono  gli incontri 
// un girone è fatto da 6 squadre, ci sono 5 giornate, ogni giornata  3 incontri. 
// devo quindi creare 30 giornate per la fase a gironi della coppa italia
$globalgiornatecounter++;
for ($giornata = 1; $giornata <= 30; $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
    aggiungi_giornata($globalgiornatecounter,"4"); // 4  coppa italia
    $globalgiornatecounter++;
}

/////////////////////
// GENERA giornate per tabellone coppa italia: quarti andata/ritorno Semifinali andata/ritorno Finale secca 
//ogni incontro della giornata può essere giocato in qualunque turno della serie A, devo tante giornate quanti sono  gli incontri
for ($giornata = 1; $giornata <= 12; $giornata++) {
    aggiungi_giornata($globalgiornatecounter,"5"); // 5  tabellone coppa italia 
    $globalgiornatecounter++;
}

aggiungi_giornata($globalgiornatecounter ,"9"); // 8  finale coppa italia
$globalgiornatecounter++;

/////////////////////
// GENERA giornate per coppa delle coppe - ex torneo di consolazione
//il torneo si svolge nelle ultime due giornate di campionato, le uniche utili, e vanno  considerati solo i punteggi delle squadre, ignorando gli scontri diretti.
for ($giornata = 1; $giornata <= 2; $giornata++) {//23-24 DUEGIORNATE COPPA COPPE)
//echo "casa= ". $element[1] . "ospite= " $element[1];
    aggiungi_giornata($globalgiornatecounter,"6"); // 6  coppa delle coppe - ex torneo di consolazione
    $globalgiornatecounter++;
}

/////////////////////
// GENERA giornate per Finale campionato: andata/ritorno
$globalgiornatecounter++;
for ($giornata = 1; $giornata <= 2; $giornata++) {//23-24 DUEGIORNATE FINALE)
//echo "casa= ". $element[1] . "ospite= " $element[1];
    aggiungi_giornata($globalgiornatecounter,"7"); // 7  finale campionato 
    $globalgiornatecounter++;
}

/////////////////////
// GENERA giornate per supercoppa
aggiungi_giornata($globalgiornatecounter ,"8"); // 8  supercoppa
$globalgiornatecounter++;

$conn->close();
include_once ("../footer.php");
?>

