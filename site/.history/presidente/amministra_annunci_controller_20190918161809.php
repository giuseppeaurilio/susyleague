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
        case("salvaannuncio"):

            $titolo = $_POST['titolo'];
            $testo = $_POST['testo'];
            $dateda = $_POST['dateda'];
            $datea = $_POST['datea'];

            $da = date_create_from_format('Y/m/d:H:i', $dateda);
            $a = date_create_from_format('Y/m/d:H:i', $datea);
            $query= "INSERT INTO `annunci`(`titolo`, `testo`, `dal`, `al`) 
                        VALUES ('$titolo','$testo','$da','$a')";
            echo $query;
            // if ($conn->query($query) === FALSE) {
            //     //throw exception
            //     echo $query;
            // }
               
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito"
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
