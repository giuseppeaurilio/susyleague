<?php

$girone;
$idsquadre;
$n; 
if( isset($_POST["girone"]) && !empty($_POST["girone"])
&& isset($_POST["idsquadre"]) && !empty($_POST["idsquadre"]))
{
    $girone = $_POST['girone'];
    $idsquadre = json_decode($_POST['idsquadre']);
    try {

        $n = count($idsquadre);
        $tabellone=generateRoundRobinPairings($n);
        $map=range(1, $n);
        shuffle($map);
        $tabellone_shuffled=mappa($tabellone,$map);
        //devo aggiungere 15 partite. le giornate predisposte vanno dalla 34 alla 63 (30 giornate)
        if($girone == "a"){
            $g = 34;
        }
        else{
            $g = 49;
        }
        for ($giornata = 1; $giornata <= ($n -1); $giornata++) {
            foreach ($tabellone_shuffled[$giornata] as $partita) {
                aggiungi_partita($g, $idsquadre[$partita["casa"]-1], $idsquadre[$partita["ospite"]-1]);
                $g++;
            }
        }
        echo json_encode(array(
            'result' => "true",
            'message' => "Operazione correttamente eseguita",
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
                // 'code' => $e->getCode(),
            ),
        ));
    }
}

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
        // echo "<br> round" . $round . "<br>";
        // print_r($ret_val);
       $ret_val_2[$round]= $ret_val;
    }
    return $ret_val_2;
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
function aggiungi_partita($giornata, $casa, $ospite) {
    // in caso di dati di test, usare questo codice
    
    include("../dbinfo_susyleague.inc.php");
    $conn = new mysqli($localhost, $username, $password,$database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    try {
        $query="DELETE FROM .`calendario` WHERE `id_giornata`=" . ($giornata) . ";";
        $query.="INSERT INTO .`calendario`(`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES (" . $giornata .",". $casa .",".  $ospite .")";
        // $result=mysql_query($query);
        $conn;
        $conn->multi_query($query);
        // echo $query ."<br>";
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
                // 'code' => $e->getCode(),
            ),
        ));
    }
    finally {
        $conn->close();
    }
}

?>
