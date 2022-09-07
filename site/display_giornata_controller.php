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
        case("formazione_ideale"):
			$modulo = $_POST['modulo']  = '' ? null :$_POST['modulo'];
			$punteggio = $_POST['punteggio']  = '' ? null :$_POST['punteggio'];
			$formazione = $_POST['formazione']  = '' ? null :$_POST['formazione'];
			$idgiornata = $_POST['idgiornata']  = '' ? null :$_POST['idgiornata'];

            $query= "SELECT g.id, g.nome,g.ruolo, sq_a.squadra_breve, gv.voto, gv.voto_md
			FROM `giocatori` as g
			left join squadre_serie_a as sq_a on g.id_squadra = sq_a.id
			left join giocatori_voti as gv on g.id = gv.giocatore_id
			left join giornate as gio on gio.giornata_serie_a_id = gv.giornata_serie_a_id
			where gio.id_giornata = $idgiornata 
			and g.id in ($formazione)
			-- where gio.id_giornata = 2
			-- and g.id in (453,5481,4982,1852,2263,4479,5850,5063,5298,4268,2103)
			order by g.ruolo desc";
            // echo $query;
            $result=$conn->query($query);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                // print_r($row);
                $imgurl = "";
                $nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $row["nome"]));
                $imgurl = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/large/".$nome_giocatore_pulito.".png");
                array_push($giocatori, array(
                    "id"=>utf8_encode($row["id"]),
                    "nome"=>utf8_encode($row["nome"]),
                    "ruolo"=>$row["ruolo"],
                    "squadra_breve"=>$row["squadra_breve"],
                    "imgurl"=>$imgurl,
					"voto"=>$row["voto"],
					"voto_md"=>$row["voto_md"],
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
