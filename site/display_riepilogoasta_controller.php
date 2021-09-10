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

            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve, sa.squadra as squadra
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
                    "squadra"=>$row["squadra"],
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

            $limit = null;
            // echo $_POST['limit']; 
            if(isset($_POST['limit']))
                $limit = $_POST['limit']  = '' ? null :$_POST['limit'];

            $query= "SELECT g.id as id, g.nome, g.ruolo, sq.squadra_breve,  gs.* 
            FROM `giocatori_statistiche` as gs
            left join giocatori as g on g.id = gs.giocatore_id
            left join squadre_serie_a as sq on sq.id = g.id_squadra
            WHERE giocatore_id = $id";
            $query .= " order by anno desc";
            if($limit <> null)//inserire controlli su input valido
                $query .= " limit $limit";
            // echo $query;
            $result=$conn->query($query);
            $stats = array();
            while ($row=$result->fetch_assoc()) {
                array_push($stats, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>utf8_encode($row["ruolo"]),
                    "squadra_breve"=>utf8_encode($row["squadra_breve"]),
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
                    "asf"=>$row["asf"],
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
                gpi.titolarita as titolarita, gpi.cp as calci_punizione, gpi.cr as calci_rigore, gpi.ca as calci_angolo, gpi.ia as indice_appetibilita, 
                gpi.is as 'is', gpi.f as fascia ,  gpi.note as note, rap.costo as costo_ap, rap.ordine as ordine_ap, sqf.squadra as squadra
                FROM `giocatori` as g
                left join giocatori_pinfo as gpi on g.id = gpi.giocatore_id
                left join squadre_serie_a as sq on sq.id = g.id_squadra
                left join rose_asta_ap as rap on rap.id_giocatore = g.id
                left join sq_fantacalcio as sqf on rap.id_sq_fc = sqf.id
                where g.id = $id";
                // echo $query;
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
                        "cp"=>utf8_encode($row["calci_punizione"]),
                        "cr"=>utf8_encode($row["calci_rigore"]),
                        "ca"=>utf8_encode($row["calci_angolo"]),
                        "ia"=>utf8_encode($row["indice_appetibilita"]),
                        "is"=>utf8_encode($row["is"]),
                        "f"=>utf8_encode($row["fascia"]),
                        "costo_ap"=>utf8_encode($row["costo_ap"]),
                        "ordine_ap"=>utf8_encode($row["ordine_ap"]),
                        "squadra"=>utf8_encode($row["squadra"]),
                        "note"=>utf8_encode($row["note"])

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
                $is = $_POST['is']  = '' ? null :$_POST['is'];
                $f = $_POST['f']  = '' ? null :$_POST['f'];
                $sololiberi = $_POST['sololiberi']  = '' ? null :$_POST['sololiberi'];

                $ordinamento = $_POST['ordinamento']  = '' ? null :$_POST['ordinamento'];
 
                // echo $sololiberi;
                $query= "SELECT g.id as idgiocatore, g.nome as nome, sq.squadra_breve as squadra_breve, g.ruolo as ruolo, g.quotazione as quotazione,  
                gpi.titolarita as titolarita, gpi.cp as cp,gpi.cr as cr, gpi.ca as ca, gpi.ia as ia, gpi.is as 'is',  gpi.f as f,  gpi.note as note , sqf.squadra as squadrafc
                FROM `giocatori` as g
                left join giocatori_pinfo as gpi on g.id = gpi.giocatore_id
                left join squadre_serie_a as sq on sq.id = g.id_squadra
                left join rose as r on r.id_giocatore =g.id 
                left join sq_fantacalcio as sqf on sqf.id = r.id_sq_fc ";
                if($sololiberi == "true")//inserire controlli su input valido
                    $query.=" where r.id_sq_fc is  null ";
                else
                    $query.=" where 1 ";
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
                if($is <> null)//inserire controlli su input valido
                    $query.=" and gpi.is <=  $is"; 
                if($f <> null)//inserire controlli su input valido
                    $query.=" and gpi.f <=  $f"; 
                
                if($ordinamento  == "ia-d")
                    $query.=" order by case when gpi.ia is null then 1 else 0 end, gpi.ia desc, g.quotazione desc ";
                else if($ordinamento  == "is-a")
                    $query.=" order by case when gpi.is is null then 1 else 0 end, gpi.is asc, gpi.ia desc ";
                else if($ordinamento  == "f-d")
                    $query.=" order by case when gpi.f is null then 1 else 0 end, gpi.f desc, gpi.ia desc ";
                else if($ordinamento  == "t-d")
                    $query.=" order by case when gpi.titolarita is null then 1 else 0 end, gpi.titolarita desc, gpi.ia desc ";
                else if($ordinamento  == "q-d")
                    $query.=" order by case when g.quotazione is null then 1 else 0 end, g.quotazione desc, gpi.ia desc ";
                else
                    $query.=" order by case when gpi.ia is null then 1 else 0 end, gpi.f, gpi.ia, g.quotazione desc";
                //echo $query;
                $result=$conn->query($query);
                $giocatori = array();
                while ($row=$result->fetch_assoc()) {
                    array_push($giocatori, array(
                        "id"=>$row["idgiocatore"],
                        "nome"=>utf8_encode($row["nome"]),
                        "class"=>$row["squadrafc"] != null ? "barrato" : "",
                        "squadra_breve"=>utf8_encode($row["squadra_breve"]),
                        "ruolo"=>utf8_encode($row["ruolo"]),
                        "quotazione"=>utf8_encode($row["quotazione"]),
                        "titolarita"=>utf8_encode($row["titolarita"]),
                        "cp"=>utf8_encode($row["cp"]),
                        "cr"=>utf8_encode($row["cr"]),
                        "ca"=>utf8_encode($row["ca"]),
                        "ia"=>utf8_encode($row["ia"]),
                        "is"=>utf8_encode($row["is"]),
                        "f"=>utf8_encode($row["f"]),
                        "squadrafc"=>utf8_encode($row["squadrafc"]),
                        "note"=>utf8_encode($row["note"])
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
            $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
            $query= "SELECT g.id as id, g.id_squadra as ids, g.nome as nome, g.ruolo as ruolo, g.quotazione as quotazione, sa.squadra_breve as squadra_breve,
            sf.squadra as fantasquadra, s.costo as costo, gpi.note as note, gpi.is as 'is',  gpi.f as f
            FROM `giocatori` as g 
            left join rose as s on s.id_giocatore = g.id
            left join squadre_serie_a as sa on sa.id = g.id_squadra
            left join sq_fantacalcio as sf on sf.id = s.id_sq_fc
            left join giocatori_pinfo as gpi on g.id = gpi.giocatore_id
            where id_sq_fc = $idSquadra";
            if($ruolo <> null)//inserire controlli su input valido
                $query.=" and g.ruolo = '$ruolo'"; 
            $query .=" order by ruolo desc, ordine";
            // echo $query;
            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                // $imgurl = "";
                // $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                // $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "costo"=>$row["costo"],
                    "note"=>utf8_encode($row["note"])
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
        case("liststats"):
            $anno = $_POST['anno']  = '' ? null :$_POST['anno'];
            $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
            $idsquadra = $_POST['idsquadra']  = '' ? null :$_POST['idsquadra'];
            $idsquadrafc = $_POST['idsquadrafc']  = '' ? null :$_POST['idsquadrafc'];
            $giocate = $_POST['giocate']  = '' ? null :$_POST['giocate'];
            $mediavoto = $_POST['mediavoto']  = '' ? null :$_POST['mediavoto'];
            $fantamedia = $_POST['fantamedia']  = '' ? null :$_POST['fantamedia'];
            $golfatti = $_POST['golfatti']  = '' ? null :$_POST['golfatti'];
            $assist = $_POST['assist']  = '' ? null :$_POST['assist'];
            
            $ammonizioni = $_POST['ammonizioni']  = '' ? null :$_POST['ammonizioni'];
            $espulsioni = $_POST['espulsioni']  = '' ? null :$_POST['espulsioni'];
            $autogol = $_POST['autogol']  = '' ? null :$_POST['autogol'];
            $ordinamento = $_POST['espulsioni']  = '' ? null :$_POST['ordinamento'];

            $query= "SELECT g.id as idgiocatore, g.nome as nome, sq.squadra_breve as squadra_breve, g.ruolo as ruolo, 
            sqfc.squadra as fantasquadra,
            gs.pg, gs.mv,gs.mf, gs.gf, gs.gs, gs.rp,  gs.rc, `r+` as rseg, `r-` as rsba, gs.ass, gs.asf, gs.amm, gs.esp, gs.au               
            FROM `giocatori` as g
            left join rose as r on r.id_giocatore =g.id 
            left join squadre_serie_a as sq on g.id_squadra = sq.id
            left join sq_fantacalcio as sqfc on r.id_sq_fc = sqfc.id
            left join giocatori_statistiche as gs on gs.giocatore_id = g.id";
            $query.=" where gs.anno = '$anno' ";
            if($ruolo <> null)//inserire controlli su input valido
                $query.=" and g.ruolo = '$ruolo'"; 
            if($idsquadra <> null)//inserire controlli su input valido
                $query.=" and g.id_squadra = $idsquadra"; 

            if($idsquadrafc <> null)//inserire controlli su input valido
            {
                // echo $query;
                if($idsquadrafc ==  '0')
                    $query.=" and r.id_sq_fc is null";
                else if($idsquadrafc ==  '-1')
                    $query.=" and r.id_sq_fc > 0";
                else
                    $query.=" and r.id_sq_fc = '$idsquadrafc'";
            }
            if($giocate <> null)//inserire controlli su input valido
                $query.=" and gs.pg >= $giocate"; 
            if($mediavoto <> null)//inserire controlli su input valido
                $query.=" and gs.mv >= $mediavoto"; 
            if($fantamedia <> null)//inserire controlli su input valido
                $query.=" and gs.mf >= $fantamedia"; 
            if($golfatti <> null)//inserire controlli su input valido
                $query.=" and gs.gf >= $golfatti"; 
            if($assist <> null)//inserire controlli su input valido
                $query.=" and gs.ass >= $assist"; 
            if($ammonizioni <> null)//inserire controlli su input valido
                $query.=" and gs.amm >= $ammonizioni"; 
            if($espulsioni <> null)//inserire controlli su input valido
                $query.=" and gs.esp >= $espulsioni"; 
            if($autogol <> null)//inserire controlli su input valido
                $query.=" and gs.au >= $autogol"; 
            
            switch($ordinamento)
            {
                case "mv-a":
                    $query.=" order by gs.mv asc";
                break;
                case "mv-d":
                    $query.=" order by gs.mv desc";
                break;
                case "fm-a":
                    $query.=" order by gs.mf asc";
                break;
                case "fm-d":
                    $query.=" order by gs.mf desc";
                break;
                case "pg-d":
                    $query.=" order by gs.pg desc";
                break;
                case "gf-d":
                    $query.=" order by gs.gf desc";
                break;
                case "gs-d":
                    $query.=" order by gs.gs desc";
                break;
                case "rp-d":
                    $query.=" order by gs.rp desc";
                break;
                case "rc-d":
                    $query.=" order by gs.rc desc";
                break;
                case "ass-d":
                    $query.=" order by gs.ass desc";
                break;
                case "amm-d":
                    $query.=" order by gs.amm desc";
                break;
                case "esp-d":
                    $query.=" order by gs.esp desc";
                break;
                case "aut-d":
                    $query.=" order by gs.aut desc";
                break;
                default :
                    $query.=" order by gs.mf desc"; 
                break;
            }
            $ordinamento = $_POST['espulsioni']  = '' ? null :$_POST['ordinamento'];
          
            // $query.=" order by g.quotazione desc";
            //  echo $query;
            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                $imgurl = "";
                $nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
                $imgurl = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png");
               
                array_push($giocatori, array(
                    "id"=>$row["idgiocatore"],
                    "nome"=>utf8_encode($row["nome"]),
                    "squadra_breve"=>utf8_encode($row["squadra_breve"]),
                    "ruolo"=>utf8_encode($row["ruolo"]),
                    "imgurl"=>$imgurl,
                    "fantasquadra"=>utf8_encode($row["fantasquadra"]),
                    "pg"=>utf8_encode($row["pg"]),
                    "mv"=>utf8_encode($row["mv"]),
                    "mf"=>utf8_encode($row["mf"]),
                    "gf"=>utf8_encode($row["gf"]),
                    "mf"=>utf8_encode($row["mf"]),
                    "gs"=>utf8_encode($row["gs"]),
                    "rp"=>utf8_encode($row["rp"]),
                    "rc"=>utf8_encode($row["rc"]),
                    "rseg"=>utf8_encode($row["rseg"]),
                    "rsba"=>utf8_encode($row["rsba"]),
                    "ass"=>utf8_encode($row["ass"]),
                    "asf"=>utf8_encode($row["asf"]),
                    "amm"=>utf8_encode($row["amm"]),
                    "esp"=>utf8_encode($row["esp"]),
                    "au"=>utf8_encode($row["au"]),
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
        case("prossimiprecedenteasta"):
            $ruolo = $_POST['ruolo']  = '' ? null :$_POST['ruolo'];
            $queryoffset ="select count(*) as c from `rose_asta`";
            $resultqueryoffset=$conn->query($queryoffset);

            $value = 0;
            while($row = $resultqueryoffset->fetch_assoc()){
                $value = $row["c"];
                // print_r($row);
            }
            $query="SELECT  ordine, nome, costo,  squadra
            FROM `rose_asta_ap` as rap 
            left join sq_fantacalcio as sqf on rap.id_sq_fc = sqf.id
            left join giocatori as g on g.id = rap.id_giocatore
            where g.ruolo = '$ruolo'
            order by ordine asc 
            limit 5 OFFSET $value";
// echo $query;
            $result=$conn->query($query);
            $prossimi = array();
            while($row = $result->fetch_assoc()){
                array_push($prossimi, array(
                    "ordine"=>$row["ordine"],
                    "nome"=>$row["nome"],
                    "squadra"=>$row["squadra"],
                    "costo"=>$row["costo"],
                    )
                );
            }
            $response = array(
                'result' => "true",
                'message' => $action." eseguito",
                'prossimi' => $prossimi
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
