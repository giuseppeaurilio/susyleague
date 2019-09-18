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

            $da = date('Y/m/d H:i', strtotime($dateda));
            $a = date('Y/m/d H:i', strtotime($datea));
            $query= "INSERT INTO `annunci`(`titolo`, `testo`, `dal`, `al`) 
                        VALUES ('$titolo','$testo','$da','$a')";
            // echo $query;
            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
               
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito"
            ));
        break;

        case("cancellaannuncio"):

            $id = $_POST['id'];
            
            $query= "DELETE FROM `annunci` where id=$id";
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
