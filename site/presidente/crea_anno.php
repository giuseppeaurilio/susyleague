<?php
//
//echo "<body>";
//echo "<h1>LOG creazione anno</h1>";

$nuovo_anno=$_POST['anno'];
$fantamilioni=$_POST['fantamilioni'];
//echo $nuovo_anno;
//echo $fantamilioni;

$n=12;

include("menu.php");
include("../dbinfo_susyleague.inc.php");
// mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/******************************************************************************
 * Round Robin Pairing Generator
 * Author: Eugene Wee
 * Date: 23 May 2005
 * Last updated: 13 May 2007
 * Based on an algorithm by Tibor Simko.
 *
 * Copyright (c) 2005, 2007 Eugene Wee
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 ******************************************************************************/

function generateRoundRobinPairings($num_players) {
    // Do we have a positive number of players? If not, default to 4.
    $num_players = ($num_players > 0) ? (int)$num_players : 4;

    // If necessary, round up number of players to nearest even number.
    $num_players += $num_players % 2;

    // Format for pretty alignment of pairings across rounds.
    $format = "%0" . ceil(log10($num_players)) . "d";
    $pairing = "$format-$format ";

    // Set the return value
    $ret = $num_players . " Player Round Robin:\n-----------------------";
	$ret_val_2=array();
    // Generate the pairings for each round.
    for ($round = 1; $round < $num_players; $round++) {
        $ret .= sprintf("\nRound #$format : ", $round);
        $players_done = array();
		$ret_val=array();
        // Pair each player except the last.
        for ($player = 1; $player < $num_players; $player++) {
            if (!in_array($player, $players_done)) {
                // Select opponent.
                $opponent = $round - $player;
                $opponent += ($opponent < 0) ? $num_players : 1;

                // Ensure opponent is not the current player.
                if ($opponent != $player) {
                    // Choose colours.
                    if (($player + $opponent) % 2 == 0 xor $player < $opponent) {
                        // Player plays white.
                        $ret .= sprintf($pairing, $player, $opponent);
                        //echo "player-opponent a " . $player ."-" . $opponent ."<br>";
                        array_push($ret_val,array("casa" => $player,"ospite" => $opponent));
                    } else {
                        // Player plays black.
                        $ret .= sprintf($pairing, $opponent, $player);
                        //echo "player-opponent b " . $opponent ."-" . $player ."<br>";
                        array_push($ret_val,array("casa" => $opponent,"ospite" => $player));
                    }

                    // This pair of players are done for this round.
                    $players_done[] = $player;
                    $players_done[] = $opponent;
                }
            }
        }

        // Pair the last player.
        if ($round % 2 == 0) {
            $opponent = ($round + $num_players) / 2;
            // Last player plays white.
            $ret .= sprintf($pairing, $num_players, $opponent);
            //echo "player-opponent a " . $player ."-" . $opponent ."<br>";
            array_push($ret_val,array("casa" => $player,"ospite" => $opponent));
        } else {
            $opponent = ($round + 1) / 2;
            // Last player plays black.
            $ret .= sprintf($pairing, $opponent, $num_players);
            //echo "player-opponent b " . $opponent ."-" . $player ."<br>";
            array_push($ret_val,array("casa" => $opponent,"ospite" => $player));
        }
        echo "<br> round" . $round . "<br>";
        print_r($ret_val);
       $ret_val_2[$round]= $ret_val;
    }
    return $ret_val_2;
}  


function aggiungi_partita($giornata, $casa, $ospite) {
    $query="INSERT INTO `calendario`(`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES (" . $giornata .",". $casa .",".  $ospite .")";
    // $result=mysql_query($query);
    global $conn;
    $conn->query($query);
	echo $query ."<br>";
}

function aggiungi_giornata($giornata,$girone) {
	$query="INSERT INTO .`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (" . $giornata .", NULL, NULL," . ($girone) .")";
    // $result=mysql_query($query);
    global $conn;
    $conn->query($query);
	echo $query ."<br>";

}

function mappa($tabellone,$map) {
	//echo "pappapero";
	$i=1; 
	$j=0;
    foreach($tabellone as $giornata){
        $j=0;
        foreach ($giornata as $partita){
            //echo "cambio " .$tabellone[$i][$j]["casa"] . " " . $map[$partita["casa"]-1] ."<br>";
            $tabellone[$i][$j]["casa"]=$map[$partita["casa"]-1];
            //echo "cambio " .$tabellone[$i][$j]["ospite"] . " " . $map[$partita["ospite"]-1] ."<br>";
            $tabellone[$i][$j]["ospite"]=$map[$partita["ospite"]-1];
            $j++;
        }
        $i++;
    }
    return $tabellone;
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

$query="Truncate `rose`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `vincitori`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `giocatori`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `squadre_serie_a`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `sondaggi`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);


$query="Truncate `sondaggi_opzioni`";
echo $query;
// $result=mysql_query($query);
$result=$conn->query($query);

$query="Truncate `sondaggi_risposte`";
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


// GENERA CALENDARIO

$tabellone=generateRoundRobinPairings($n);


$map=range(1, $n);
$globalgiornatecounter = 0;
/////////////////////////
//  GENERA GIRONE ANDATA


shuffle($map);
//echo "<br> mappa <br>";
//print_r($map);

$tabellone_shuffled=mappa($tabellone,$map);

echo "<br> Inizio Tabellone shuffled <br>";
for ($giornata = 1; $giornata < $n; $giornata++) {
$element=$tabellone_shuffled[$giornata];
echo "<br> unwrappato " . $giornata ."<br>";
print_r($element);
}
echo "<br> Fine Tabellone Shuffled  <br>";

for ($giornata = 1; $giornata <= 2*($n-1); $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
	aggiungi_giornata($giornata,"1");
	if ($giornata<$n) {
		foreach ($tabellone_shuffled[$giornata] as $partita) {
			aggiungi_partita($giornata, $partita["casa"], $partita["ospite"]);
		}
	}
	else {
		foreach ($tabellone_shuffled[$giornata-$n+1] as $partita) {
			aggiungi_partita($giornata, $partita["ospite"], $partita["casa"]);
		}
	}	
	$globalgiornatecounter = $giornata;
}


/////////////////////
// GENERA GIRONE RITORNO

shuffle($map);
//echo "<br> mappa <br>";
//print_r($map);

$tabellone_shuffled=mappa($tabellone,$map);

echo "<br> Inizio Tabellone shuffled <br>";
for ($giornata = 1; $giornata < $n; $giornata++) {
$element=$tabellone_shuffled[$giornata];
echo "<br> unwrappato " . $giornata ."<br>";
print_r($element);
}

echo "<br> Fine Tabellone Shuffled  <br>";

for ($giornata = 2*($n-1)+1; $giornata <= 3*($n-1); $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
	aggiungi_giornata($giornata,"2");

    foreach ($tabellone_shuffled[$giornata-2*($n-1)] as $partita) {
        aggiungi_partita($giornata, $partita["casa"], $partita["ospite"]);
    }
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
// visto che ogni incontro della giornat apuò essere giocato in qualunque turno della serie A, devo tante giornate quanti sono  gli incontri 
// un girone è fatto da 6 squadre, ci sono 5 giornate, ogni giornata  3 incontri. 
//devo quindi creare 30 giornate per la fase a gironi della coppa italia
$globalgiornatecounter++;
for ($giornata = 1; $giornata <= 30; $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
    aggiungi_giornata($globalgiornatecounter,"4"); // 4  coppa italia
    $globalgiornatecounter++;
}

/////////////////////
// GENERA giornate per Finale coppa italia 
aggiungi_giornata($globalgiornatecounter,"5"); // 5  finale coppa italia 
$globalgiornatecounter++;

/////////////////////
// GENERA giornate per Torneo di consolazione
//il torneo si svolge nelle ultime due giornate di campionato, le uniche utili, e vanno  considerati solo i punteggi delle squadre, ignorando gli scontri diretti.
for ($giornata = 1; $giornata <= 2; $giornata++) {
//echo "casa= ". $element[1] . "ospite= " $element[1];
    aggiungi_giornata($globalgiornatecounter,"6"); // 6  torneo di consolazione
    $globalgiornatecounter++;
}

/////////////////////
// GENERA giornate per Finale campionato
aggiungi_giornata($globalgiornatecounter,"7"); // 7  finale campionato 
$globalgiornatecounter++;

/////////////////////
// GENERA giornate per coppa delle coppe
aggiungi_giornata($globalgiornatecounter ,"8"); // 8  coppa delle coppe
$globalgiornatecounter++;


$conn->close();

?>

