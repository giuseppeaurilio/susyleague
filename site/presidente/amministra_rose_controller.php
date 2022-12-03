<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
$action ="";
include_once ("../dbinfo_susyleague.inc.php");
// Create connection
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
        case("estrai"):

            $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
            $min = $_POST['min']  = '' ? null :$_POST['min'];
            $max = $_POST['max']  = '' ? null :$_POST['max'];
            $idsquadra = $_POST['idsquadra']  = '' ? null :$_POST['idsquadra'];


            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            where s.id_sq_fc is null";
            if($ruolo <> null)//inserire controlli su input valido
                $query.=" and g.ruolo = '$ruolo'"; 
            if($min <> null)//inserire controlli su input valido
                $query.=" and g.quotazione >= $min"; 
            if($max <> null)//inserire controlli su input valido
                $query.=" and g.quotazione <= $max";
            // if($idsquadra <> null)//inserire controlli su input valido
            //     $query.=" and g.id_squadra = $idsquadra"; 
            $query.=" order by rand() limit 1";
            // echo $query;
            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($giocatori, array(

                    "id"=>$row["id"],
                    "ids"=>$row["ids"],
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "quotazione"=>$row["quotazione"],
                    "squadra_breve"=>$row["squadra_breve"],
                    )
                );
            };

            // if ($conn->query($query) === FALSE) {
            //     //throw exception
            //     echo $query;
            // }
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'giocatori' => $giocatori
            );
            echo json_encode($response);
            break;
        case("conferma"):
            $idgiocatore = $_POST['id'];

            $query= "INSERT INTO `rose`(`id_giocatore`) VALUES ($idgiocatore)";

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
        case("annulla"):
            // $idgiocatore = $_POST['id'];
            $query= "DELETE FROM `rose` WHERE id_sq_fc = 0";
            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        case("getquotazionemax"):
            $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
            $query= "SELECT g.quotazione as max
            from giocatori as g 
            left join rose as r on r.id_giocatore = g.id
            where ruolo = '$ruolo'
            and r.id_sq_fc is null
            order by quotazione desc limit 1";
            // echo $query;
            $result=$conn->query($query);
            if ($result === FALSE) {
                echo $query;
            }
            $max = 0;
            while ($row=$result->fetch_assoc()) {
                    $max=$row["max"];     
            };
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'max' => $max
            );
            echo json_encode($response);
            break;
        case("astaincorso"):

            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            where s.id_sq_fc = 0";
            // echo $query;
            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "ids"=>utf8_encode($row["ids"]),
                    "ruolo"=>$row["ruolo"],
                    )
                );
            };
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'giocatori' => $giocatori
            );
            echo json_encode($response);
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
