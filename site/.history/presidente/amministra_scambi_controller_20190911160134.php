<?php 
$action ="";
include_once ("/dbinfo_susyleague.inc.php");
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
        case("loadrosa"):

            $idsquadra = $_POST['idsquadra'];
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
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
