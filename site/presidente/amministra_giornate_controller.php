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
        case("salvaseriea"):
            $idgiornata = $_POST['idgiornata'];
            $inizio = $_POST['inizio'];
            $fine = $_POST['fine'];

            $query= "UPDATE `giornate_serie_a` SET `inizio`='".$inizio."',`fine`='".$fine."' WHERE id=".$idgiornata ;

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("cancellaseriea"):
                $idgiornata = $_POST['idgiornata'];
                $query= "UPDATE `giornate_serie_a` SET `inizio`=null,`fine`=null WHERE id=".$idgiornata ;
    
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                echo json_encode(array(
                    'result' => "true",
                    'message' => $action." eseguito",
                ));
                break;
        case("salvafc"):
                $idgiornatasa = $_POST['idgiornatasa'];
                $idgiornatafc = $_POST['idgiornatafc'];
    
                $query= "UPDATE `giornate` SET `giornata_serie_a_id`='".$idgiornatasa."' WHERE id_giornata=".$idgiornatafc ;
                
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
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
