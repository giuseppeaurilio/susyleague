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
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action = $_POST['action'];
    switch($action)
    {
        case("nuovo"):

            $testo = $_POST['testo'];
            $data = date('Y-m-d H:i:s');

            $query= "INSERT INTO `perlediiori` (`Id`, `Data`, `Testo`)
                    VALUES (null,'$data','$testo')";

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("elimina"):
            $id = $_POST['id'];

            $query= "DELETE FROM `perlediiori` 
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
            $query= "SELECT `Id`, `Data`, `Testo`FROM `perlediiori` order by 'Data' Desc";

            $result=$conn->query($query);
            $fusti = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($fusti, array(
                    "Id"=>$row["Id"],
                    "Data"=>($row["Data"]),
                    "Testo"=>($row["Testo"])
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
