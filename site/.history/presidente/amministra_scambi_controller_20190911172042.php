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
        case("loadrosa"):

            $idsquadra = $_POST['idsquadra'];
            $query2="SELECT a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  
            FROM rose as a 
            inner join giocatori as b 
            inner join squadre_serie_a as c 
            where a.id_sq_fc='" . $idsquadra ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";

            $result_giocatori=$conn->query($query2);
            $giocatori = array();
            while ($row=$result_giocatori->fetch_assoc()) {
                array_push($giocatori, array(
                    "id"=>$row["id_giocatore"],
                    "nome"=>$row["nome"],
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"]
                    )
                );
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
                'data' => "true",
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
