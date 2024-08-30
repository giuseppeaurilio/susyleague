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
                    "squadra_breve"=>$row["squadra_breve"], 
                    "ispor"=>$row["ruolo"] == "P",
                    "isdif"=>$row["ruolo"] == "D",
                    "iscen"=>$row["ruolo"] == "C",
                    "isatt"=>$row["ruolo"] == "A",
                    )
                );
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
                'giocatori' => $giocatori
            ));
            break;
        case("doscambio"):
            $idsquadra1 = $_POST['idsquadra1'];
            $arr1 = (!empty($_POST['arr1']))? $_POST['arr1'] : array();
            $idsquadra2 = $_POST['idsquadra2'];
            $arr2 = (!empty($_POST['arr2']))? $_POST['arr2'] : array();
            $note = (!empty($_POST['note']))? $_POST['note'] : "";

            date_default_timezone_set('Europe/Rome');
            $adesso = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `scambi`(`data`, `note`)  VALUES ('$adesso', '$note')";
            $last_id = 0;
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
            }
            else
                echo $sql;
            // print_r($arr1);
            foreach($arr1 as $gioc)
            {
                $query= "INSERT INTO `scambi_dettagli`(`scambio_id`, `giocatore_id`, `squadra_or_id`, `squadra_dest_id`) 
                        VALUES ($last_id,$gioc,$idsquadra1,$idsquadra2)";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                $query= "DELETE FROM `rose` where id_sq_fc = $idsquadra1 AND id_giocatore =$gioc";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                $query= "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadra2,null,$gioc)";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
            }
            foreach($arr2 as $gioc)
            {
                $query= "INSERT INTO `scambi_dettagli`(`scambio_id`, `giocatore_id`, `squadra_or_id`, `squadra_dest_id`)
                        VALUES ($last_id,$gioc,$idsquadra2,$idsquadra1)";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                $query= "DELETE FROM `rose` where id_sq_fc = $idsquadra2 AND id_giocatore =$gioc";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                $query= "INSERT INTO `rose`(`id_sq_fc`, `costo`, `id_giocatore`) VALUES ($idsquadra1,null,$gioc)";
                if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
        break;
        case("getscambi"):

            $query="SELECT s.id, s.data, s.note, g.nome, g.ruolo, 
            sq_a.squadra_breve, sq1.squadra as sqorigine, sq2.squadra as sqdestinazione
            FROM scambi as s
            left join scambi_dettagli as sd on s.id = sd.scambio_id
            left join giocatori as g on sd.giocatore_id = g.id
            left join squadre_serie_a as sq_a on g.id_squadra = sq_a.id
            left join sq_fantacalcio as sq1 on sq1.id = sd.squadra_or_id
            left join sq_fantacalcio as sq2 on sq2.id = sd.squadra_dest_id
            order by data desc";

            $result=$conn->query($query);
            $scambi = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                array_push($scambi, array(

                    "id"=>$row["id"],
                    "data"=>$row["data"],
                    "note"=>empty($row["note"])? "":$row["note"] ,
                    "nome"=>empty($row["nome"])? "":$row["nome"],
                    "ruolo"=>empty($row["ruolo"])? "":$row["ruolo"],
                    "squadra_breve"=>empty($row["squadra_breve"])? "":$row["squadra_breve"],
                    "sqorigine"=>"",//empty($row["squadra_breve"])? "":$row["squadra_breve"],empty($row["sqorigine"])? "":$row["sqorigine"],
                    "sqdestinazione"=>"",//empty($row["squadra_breve"])? "":$row["squadra_breve"],empty($row["sqdestinazione"])? "":$row["sqdestinazione"]
                    )
                );
            };
            // print_r($scambi);
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
                'scambi' => $scambi
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
