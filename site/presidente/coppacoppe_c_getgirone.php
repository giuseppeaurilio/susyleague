<?php
if( isset($_POST["girone"]) && !empty($_POST["girone"])){
    $idg = 6;
    $id_numbers =array();

        
    // include_once ("../dbinfo_susyleague.inc.php");
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    try {

        $query="SELECT * FROM `gironi_tc_squadre` WHERE id_girone=". $idg;
        $result=$conn->query($query);
        while ($row = $result->fetch_assoc()) {
            array_push($id_numbers ,  array(
                "id_squadra" => $row["id_squadra"],
                )); // Inside while loop
        }
        echo json_encode(array(
            'result' => "true",
            "id_numbers" =>$id_numbers,
            "idg" =>$_POST["girone"],
            )
        );

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
