<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
$action ="";
include_once ("dbinfo_susyleague.inc.php");
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
                $imgurl = "";
                $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "imgurl"=>$imgurl
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
        case("ultimogiocatore"):
            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve,
            sf.squadra as fantasquadra, s.costo as costo
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            left join sq_fantacalcio as sf on sf.id = s.id_sq_fc
            where id_sq_fc > 0
            order by ordine desc
            limit 1";

            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                $imgurl = "";
                $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/medium/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "imgurl"=>$imgurl,
                    "fantasquadra"=>utf8_encode($row["fantasquadra"]),
                    "costo"=>$row["costo"],
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
        case("listacompleta"):
            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve,
            sf.squadra as fantasquadra, s.costo as costo, s.ordine as chiamata
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            left join sq_fantacalcio as sf on sf.id = s.id_sq_fc
            where id_sq_fc > 0
            order by ordine desc";

            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                $imgurl = "";
                $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "imgurl"=>$imgurl,
                    "fantasquadra"=>utf8_encode($row["fantasquadra"]),
                    "costo"=>$row["costo"],
                    "chiamata"=>$row["chiamata"],
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
        case("stats"):
            $id = $_POST['id'];
            $query= "SELECT * FROM `giocatori_statistiche` WHERE giocatore_id = $id";
            // echo $query;
            $result=$conn->query($query);
            $stats = array();
            while ($row=$result->fetch_assoc()) {
                array_push($stats, array(
                    "anno"=>utf8_encode($row["anno"]),
                    "pg"=>$row["pg"],
                    "mv"=>$row["mv"],
                    "mf"=>$row["mf"],
                    "gf"=>$row["gf"],
                    "gs"=>$row["gs"],
                    "rp"=>$row["rp"],
                    "rc"=>$row["rc"],
                    "r+"=>$row["r+"],
                    "r-"=>$row["r-"],
                    "ass"=>$row["ass"],
                    "amm"=>$row["amm"],
                    "esp"=>$row["esp"],
                    "au"=>$row["au"],
                    )
                );
            };
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'stats' => $stats
            );
            echo json_encode($response);
            break;
        case("loadpinfo"):
                $id = $_POST['id'];
                $query= "SELECT g.id as idgiocatore, g.nome as nome, sq.squadra_breve as squadra_breve, g.ruolo as ruolo, g.quotazione as quotazione,  
                gpi.titolarita as titolarita, gpi.cp as cp,gpi.cr as cr, gpi.ca as ca, gpi.val as val, gpi.ia as ia, gpi.ip as ip 
                FROM `giocatori` as g
                left join giocatori_pinfo as gpi on g.id = gpi.giocatore_id
                left join squadre_serie_a as sq on sq.id = g.id_squadra
                
                where g.id = $id";
                //echo $query;
                $result=$conn->query($query);
                $giocatori = array();
                while ($row=$result->fetch_assoc()) {
                    array_push($giocatori, array(
                        "id"=>$row["idgiocatore"],
                        "nome"=>utf8_encode($row["nome"]),
                        "squadra_breve"=>utf8_encode($row["squadra_breve"]),
                        "ruolo"=>utf8_encode($row["ruolo"]),
                        "quotazione"=>utf8_encode($row["quotazione"]),
                        "titolarita"=>utf8_encode($row["titolarita"]),
                        "cp"=>utf8_encode($row["cp"]),
                        "cr"=>utf8_encode($row["cr"]),
                        "ca"=>utf8_encode($row["ca"]),
                        "val"=>utf8_encode($row["val"]),
                        "ia"=>utf8_encode($row["ia"]),
                        "ip"=>utf8_encode($row["ip"]),
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
        case("ricercagiocatore"):
                $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
                $idsquadra = $_POST['idsquadra']  = '' ? null :$_POST['idsquadra'];
                // $mediavoto = $_POST['mediavoto']  = '' ? null :$_POST['mediavoto'];
                // $fantamedia = $_POST['fantamedia']  = '' ? null :$_POST['fantamedia'];
                $titolarita = $_POST['titolarita']  = '' ? null :$_POST['titolarita'];
                $rigori = $_POST['rigori']  = '' ? null :$_POST['rigori'];
                $punizioni = $_POST['punizioni']  = '' ? null :$_POST['punizioni'];
                $ia = $_POST['ia']  = '' ? null :$_POST['ia'];
                $ip = $_POST['titolarita']  = '' ? null :$_POST['ip'];

                $query= "SELECT g.id as idgiocatore, g.nome as nome, sq.squadra_breve as squadra_breve, g.ruolo as ruolo, g.quotazione as quotazione,  
                gpi.titolarita as titolarita, gpi.cp as cp,gpi.cr as cr, gpi.ca as ca, gpi.val as val, gpi.ia as ia, gpi.ip as ip 
                FROM `giocatori` as g
                left join giocatori_pinfo as gpi on g.id = gpi.giocatore_id
                left join squadre_serie_a as sq on sq.id = g.id_squadra
                left join rose as r on r.id_giocatore =g.id ";
                $query.=" where r.id_sq_fc is  null ";
                if($ruolo <> null)//inserire controlli su input valido
                    $query.=" and g.ruolo = '$ruolo'"; 
                if($idsquadra <> null)//inserire controlli su input valido
                    $query.=" and g.id_squadra = '$idsquadra'"; 
                if($titolarita <> null)//inserire controlli su input valido
                    $query.=" and gpi.titolarita >=  $titolarita"; 
                if($rigori <> null)//inserire controlli su input valido
                    $query.=" and gpi.cr >=  $rigori"; 
                if($punizioni <> null)//inserire controlli su input valido
                    $query.=" and gpi.cp >=  $punizioni"; 
                if($ia <> null)//inserire controlli su input valido
                    $query.=" and gpi.ia >=  $ia"; 
                if($ip <> null)//inserire controlli su input valido
                    $query.=" and gpi.ip >=  $ip"; 
                
                $query.=" order by g.quotazione desc";
                //echo $query;
                $result=$conn->query($query);
                $giocatori = array();
                while ($row=$result->fetch_assoc()) {
                    array_push($giocatori, array(
                        "id"=>$row["idgiocatore"],
                        "nome"=>utf8_encode($row["nome"]),
                        "squadra_breve"=>utf8_encode($row["squadra_breve"]),
                        "ruolo"=>utf8_encode($row["ruolo"]),
                        "quotazione"=>utf8_encode($row["quotazione"]),
                        "titolarita"=>utf8_encode($row["titolarita"]),
                        "cp"=>utf8_encode($row["cp"]),
                        "cr"=>utf8_encode($row["cr"]),
                        "ca"=>utf8_encode($row["ca"]),
                        "val"=>utf8_encode($row["val"]),
                        "ia"=>utf8_encode($row["ia"]),
                        "ip"=>utf8_encode($row["ip"]),
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
        case("loadsqadra"):
            $idSquadra = $_POST['id'];
            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve,
            sf.squadra as fantasquadra, s.costo as costo, s.ordine as chiamata
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            left join sq_fantacalcio as sf on sf.id = s.id_sq_fc
            where id_sq_fc = $idSquadra
            order by ruolo desc, ordine";

            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                $imgurl = "";
                $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "costo"=>$row["costo"],
                    "chiamata"=>$row["chiamata"],
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
