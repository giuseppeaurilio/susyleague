<?php

header('Content-Type: text/html; charset=ISO-8859-1');
$action ="";
include_once ("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sbragaCalendario() {
    $query="DELETE FROM `calendario`";
    // $result=mysql_query($query);
    global $conn;
	$conn->query($query);
	
	// $query="DELETE FROM `giornate` where id_girone=1";
    // // $result=mysql_query($query);
    // global $conn;
	// $conn->query($query);
	
	// $query="DELETE FROM `giornate` where id_girone=2";
    // // $result=mysql_query($query);
    // global $conn;
    // $conn->query($query);

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
    // $ret = $num_players . " Player Round Robin:\n-----------------------";
	$ret_val_2=array();
    // Generate the pairings for each round.
    for ($round = 1; $round < $num_players; $round++) {
        // $ret .= sprintf("\nRound #$format : ", $round);
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
                        // $ret .= sprintf($pairing, $player, $opponent);
                        //echo "player-opponent a " . $player ."-" . $opponent ."<br>";
                        array_push($ret_val,array("casa" => $player,"ospite" => $opponent));
                    } else {
                        // Player plays black.
                        // $ret .= sprintf($pairing, $opponent, $player);
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
            // $ret .= sprintf($pairing, $num_players, $opponent);
            //echo "player-opponent a " . $player ."-" . $opponent ."<br>";
            array_push($ret_val,array("casa" => $player,"ospite" => $opponent));
        } else {
            $opponent = ($round + 1) / 2;
            // Last player plays black.
            // $ret .= sprintf($pairing, $opponent, $num_players);
            //echo "player-opponent b " . $opponent ."-" . $player ."<br>";
            array_push($ret_val,array("casa" => $opponent,"ospite" => $player));
        }
        // echo "<br> round" . $round . "<br>";
        // print_r($ret_val);
       $ret_val_2[$round]= $ret_val;
    }
    return $ret_val_2;
}  


function aggiungi_partita($giornata, $casa, $ospite) {
    $query="INSERT INTO `calendario`(`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES (" . $giornata .",". $casa .",".  $ospite .")";
    // $result=mysql_query($query);
    global $conn;
    $conn->query($query);
	// echo $query ."<br>";
}

// function aggiungi_giornata($giornata,$girone) {
// 	$query="INSERT INTO .`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (" . $giornata .", NULL, NULL," . ($girone) .")";
//     // $result=mysql_query($query);
//     global $conn;
//     $conn->query($query);
// 	// echo $query ."<br>";

// }

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


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$action = $_POST['action'];
    switch($action)
    {
		case("generaanno"):

			$n=12;

			sbragaCalendario();
			// GENERA CALENDARIO
			$tabellone=generateRoundRobinPairings($n);

			$map=range(1, $n);
			$globalgiornatecounter = 0;


			// //  GENERA GIRONE ANDATA
			// shuffle($map);

			// $tabellone_shuffled=mappa($tabellone,$map);

			// for ($giornata = 1; $giornata < $n; $giornata++) {
			// 	$element=$tabellone_shuffled[$giornata];
			// }

			// for ($giornata = 1; $giornata <= 2*($n-1); $giornata++) {
			// 	// aggiungi_giornata($giornata,"1");
			// 	if ($giornata<$n) {
			// 		foreach ($tabellone_shuffled[$giornata] as $partita) {
			// 			aggiungi_partita($giornata, $partita["casa"], $partita["ospite"]);
			// 		}
			// 	}
			// 	else {
			// 		foreach ($tabellone_shuffled[$giornata-$n+1] as $partita) {
			// 			aggiungi_partita($giornata, $partita["ospite"], $partita["casa"]);
			// 		}
			// 	}	
			// 	$globalgiornatecounter = $giornata;
			// }
            // //FINE   GENERA GIRONE ANDATA
            
            //andata con calendario asimmetrico
	        shuffle($map);

			$tabellone_shuffled=mappa($tabellone,$map);

			for ($giornata = 1; $giornata < $n; $giornata++) {
				$element=$tabellone_shuffled[$giornata];
			}
            for ($giornata = 1; $giornata <= 2*($n-1); $giornata++) {
				// aggiungi_giornata($giornata,"1");
				if ($giornata<$n) { //girone di andata
					foreach ($tabellone_shuffled[$giornata] as $partita) {
						aggiungi_partita($giornata, $partita["casa"], $partita["ospite"]);
					}
				}
				else { //girone di ritorno asimmetrico
					foreach ($tabellone_shuffled[$giornata-$n+1] as $partita) {
                        $giornatadiinserimento = 2*($n-1) - ($giornata - $n);//22-
						aggiungi_partita($giornatadiinserimento, $partita["ospite"], $partita["casa"]);
					}
				}	
				$globalgiornatecounter = $giornata;
			}

            //FINE andata con calendario asimmetrico
			// GENERA GIRONE RITORNO
			shuffle($map);
			$tabellone_shuffled=mappa($tabellone,$map);
			for ($giornata = 1; $giornata < $n; $giornata++) {
				$element=$tabellone_shuffled[$giornata];
			}
			for ($giornata = 2*($n-1)+1; $giornata <= 3*($n-1); $giornata++) {
				// aggiungi_giornata($giornata,"2");
				foreach ($tabellone_shuffled[$giornata-2*($n-1)] as $partita) {
					aggiungi_partita($giornata, $partita["casa"], $partita["ospite"]);
				}
				$globalgiornatecounter = $giornata;
			}

			$response = array(
                'result' => "true",
                'message' => $action." eseguito",
            );
            echo json_encode($response);
            break;
        
        default:
            echo json_encode(array(
                'error' => array(
                    'msg' => "Method not allowed",
                    // 'code' => $e->getCode(),
                ),
            ));
		break;
	}
}


?>
