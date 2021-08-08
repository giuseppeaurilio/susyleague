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
        
    case("usemd"):

            $id_giornata = $_POST['id_giornata'];
            $id_partita = $_POST['id_partita'];
            $id_squadra = $_POST['id_squadra'];
            $checked = $_POST['checked'];
            $home = $_POST['home'];
            if($home == "1")
            {
                $query= "UPDATE `calendario` SET `use_mdcasa`=$checked
                WHERE id_giornata = $id_giornata
                and id_partita = $id_partita
                and id_sq_casa = $id_squadra";
                // echo $query;
            }
            else
            {
                $query= "UPDATE `calendario` SET `use_mdospite`=$checked
                WHERE id_giornata = $id_giornata
                and id_partita = $id_partita
                and id_sq_ospite = $id_squadra";
                // echo $query;
            }
            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("inviasostituzione"):

            $id_giornata = $_POST['id_giornata'];
            $id_squadra = $_POST['id_squadra'];
            $id_giocatore = $_POST['id_giocatore'];
            $checked = $_POST['checked'];
            
            $query= "UPDATE `formazioni` 
                SET `sostituzione`=$checked 
                WHERE `id_giocatore`=$id_giocatore
                AND `id_giornata`=$id_giornata
                AND `id_squadra`=$id_squadra";
                // echo $query;
            
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
