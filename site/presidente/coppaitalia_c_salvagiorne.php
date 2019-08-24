<?php
if( isset($_POST["idg"]) && !empty($_POST["idg"])
    && isset($_POST["sq1"]) && !empty($_POST["sq1"])
    && isset($_POST["sq2"]) && !empty($_POST["sq2"])
    && isset($_POST["sq3"]) && !empty($_POST["sq3"])
    && isset($_POST["sq4"]) && !empty($_POST["sq4"])
    && isset($_POST["sq5"]) && !empty($_POST["sq5"])
    && isset($_POST["sq6"]) && !empty($_POST["sq6"]) 
    && isset($_POST["sq1m"]) 
    && isset($_POST["sq2m"]) 
    && isset($_POST["sq3m"]) 
    && isset($_POST["sq4m"]) 
    && isset($_POST["sq5m"]) 
    && isset($_POST["sq6m"])
){
    $idg = $_POST["idg"] == "a" ? 1 : 2;
    $ids1 = $_POST["sq1"];
    $ids2 = $_POST["sq2"];
    $ids3 = $_POST["sq3"];
    $ids4 = $_POST["sq4"];
    $ids5 = $_POST["sq5"];
    $ids6 = $_POST["sq6"];
    $ids1m = $_POST["sq1m"];
    $ids2m = $_POST["sq2m"];
    $ids3m = $_POST["sq3m"];
    $ids4m = $_POST["sq4m"];
    $ids5m = $_POST["sq5m"];
    $ids6m = $_POST["sq6m"];
    include("../dbinfo_susyleague.inc.php");
    $conn = new mysqli($localhost, $username, $password,$database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    try {
        // $query="INSERT INTO .`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (" . $giornata .", NULL, NULL," . ($girone) .")";
        $query="";
        $query="DELETE FROM .`gironi_ci_squadre` WHERE `id_girone`=" . $idg . ";";
        // $query.="INSERT INTO `gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES ([value-1],[value-2],[value-3])";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg . "," . $ids1 . "," . $ids1m . ");";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg .",". $ids2 ."," . $ids2m . ");";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg .",". $ids3 ."," . $ids3m . ");";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg .",". $ids4 ."," . $ids4m . ");";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg .",". $ids5 ."," . $ids5m . ");";
        $query.="INSERT INTO .`gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (" . $idg .",". $ids6 ."," . $ids6m . ");";

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
