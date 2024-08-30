<?php 
$action ="";
include_once ("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action = $_POST['action'];
    switch($action)
    {
        case("nuovo"):

            $presidente = $_POST['Presidente'];
            $motivazione = $_POST['Motivazione'];
            $stato = 0;
            $data = date('Y-m-d H:i:s');

            $query= "INSERT INTO `contafusti` (`Id`, `Presidente`, `Motivazione`, `Stato`, `DataUM`)
                    VALUES (null,$presidente,$motivazione,$stato, $data)";

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("aggiorna"):
            $id = $_POST['Id'];
            $stato = $_POST['Stato'];
            $data = date('Y-m-d H:i:s');

            $query= "UPDATE `contafusti` SET `Stato`=$stato,`DataUM`=$data
                    where `Id`=$id";

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        break;
        case("get"):

            $query= "SELECT `Id`, `Presidente`, `Motivazione`, `Stato`, `DataUM` FROM `contafusti` order by DataUM desc";

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            $fusti = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($fusti, array(
                    "Id"=>$row["Id"],
                    "Presidente"=>$row["Presidente"],
                    "Motivazione"=>$row["Motivazione"],
                    "Stato"=>$row["Stato"],
                    "DataUM"=>$row["DataUM"]
                    )
                );
            };

            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
                'fusti' => $fusti
            ));
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
else{
    echo json_encode(array(
        'error' => array(
            'msg' => "Method not allowed",
            // 'code' => $e->getCode(),
        ),
    ));
}
?>
