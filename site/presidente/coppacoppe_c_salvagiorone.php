<?php
$idsquadre;
$n; 
$idg = 6;
if( isset($_POST["idsquadre"]) && !empty($_POST["idsquadre"]))
{
    $idsquadre = json_decode($_POST['idsquadre']);
    $n = count($idsquadre);

    // include_once ("../dbinfo_susyleague.inc.php");
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    try {
        // $query="INSERT INTO .`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (" . $giornata .", NULL, NULL," . ($girone) .")";
        $query="";
        $query="DELETE FROM .`gironi_tc_squadre` WHERE `id_girone`=" . $idg . ";";
        for ($i = 0; $i < $n; $i++) {
            $query.="INSERT INTO .`gironi_tc_squadre`(`id_girone`, `id_squadra`) VALUES (" . $idg . "," . $idsquadre[$i] . ");";
        }
        

        if ($conn->multi_query($query) === TRUE) {
            echo json_encode(array(
                'result' => "true",
                'message' => "Operazione correttamente eseguita",
                'query' =>  ($query),
                // 'ids1' =>  $ids1,
                // 'ids1m' =>  $ids1m,
            ));
        }
        else {
            echo json_encode(array(
                'error' => array(
                    'msg' => $conn->error,
                    // 'code' => $e->getCode(),
                ),
            )); 
        }

        // $query="DELETE FROM .`gironi_ci_squadre` WHERE `id_girone`=1;";
        // if ($conn->query($query) === TRUE) {
        //     echo json_encode(array(
        //         'result' => "true",
        //         'message' => "Operazione correttamente eseguita",
        //         'query' =>  ($query),
        //         // 'ids1' =>  $ids1,
        //         // 'ids1m' =>  $ids1m,
        //     ));
        // }
        // else {
        //     echo json_encode(array(
        //         'error' => array(
        //             'msg' => $conn->error,
        //             // 'code' => $e->getCode(),
        //         ),
        //     )); 
        // }

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
else{
    // throw new Exception("parametri non corretti");
    echo json_encode(array(
        'error' => array(
            'msg' => "parametri non corretti",
            // 'code' => $e->getCode(),
        ),
    ));
}
?>
