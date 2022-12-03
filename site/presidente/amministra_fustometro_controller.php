<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
$action ="";
// include_once ("../dbinfo_susyleague.inc.php");
// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action = $_POST['action'];
    switch($action)
    {
        case("nuovo"):

            $presidente = $_POST['presidente'];
            $motivazione = $_POST['motivazione']  = '' ? null :$_POST['motivazione'];
            $stato = $_POST['stato'];
            $data = date('Y-m-d H:i:s');

            $query= "INSERT INTO `contafusti` (`Id`, `Presidente`, `Motivazione`, `Stato`, `DataUM`)
                    VALUES (null,'$presidente','$motivazione',$stato, '$data')";

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
            $id = $_POST['id'];
            $stato = $_POST['stato'];
            $data = date('Y-m-d H:i:s');

            $query= "UPDATE `contafusti` SET `Stato`=$stato,`DataUM`='$data'
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

            $stato = $_POST['stato']  = '' ? null : $_POST['stato'];
            if($stato == '')
            {
                $query= "SELECT `Id`, `Presidente`, `Motivazione`, `Stato`, `DataUM` FROM `contafusti` order by Id Desc";
            }
            else
            {
                $query= "SELECT `Id`, `Presidente`, `Motivazione`, `Stato`, `DataUM` FROM `contafusti` where stato = $stato order by Id Desc";
            }
            $result=$conn->query($query);
            $fusti = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($fusti, array(
                    "Id"=>$row["Id"],
                    "Presidente"=>utf8_encode($row["Presidente"]),
                    "Motivazione"=>utf8_encode($row["Motivazione"]),
                    "Stato"=>$row["Stato"] == '0' ? "in preparazione": ($row["Stato"] == '1' ? "assegnato": "annullato"),
                    // "Stato"=>$row["Stato"] ,
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
