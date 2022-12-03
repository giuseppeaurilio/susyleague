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
        case("aggiungi"):

            $idCompetizione = $_POST['idCompetizione']  = '' ? null :$_POST['idCompetizione'];
            $competizione = $_POST['competizione'];
            $posizione = $_POST['posizione']  = '' ? null :$_POST['posizione'];
            $idSquadra = $_POST['idCompetizione']  = '' ? null :$_POST['idSquadra'];

            $query= "INSERT INTO `vincitori`(`id`, `competizione_id`, `desc_competizione`, `posizione`, `sq_id`)
                    VALUES (null,'$idCompetizione','$competizione',$posizione, '$idSquadra')";

            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("cancella"):
            $id = $_POST['id'];

            $query= "DELETE FROM `vincitori`
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
        case("carica"):
            $query= "SELECT v.`id` as id, v.`competizione_id` as idc, v.`desc_competizione` as descc, v.`posizione` as pos, v.`sq_id` as ids, sqf.squadra, sqf.allenatore 
            FROM `vincitori` as v
            left join sq_fantacalcio as sqf on sqf.id = v.sq_id
            order by competizione_id, desc_competizione, posizione";
            
            $result=$conn->query($query);
            $vincitori = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($vincitori, array(

                    "id"=>$row["id"],
                    "idc"=>$row["idc"],
                    "descc"=>utf8_encode($row["descc"]),
                    "pos"=>$row["pos"],
                    "ids"=>$row["ids"],
                    "squadra"=>utf8_encode($row["squadra"]),
                    "allenatore"=>utf8_encode($row["allenatore"]),
                    )
                );
            };
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'vincitori' => $vincitori
            );
            // print_r($response);
            echo json_encode($response);
            // echo json_last_error_msg();
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
