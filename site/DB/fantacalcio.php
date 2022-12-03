<?php

function fantacalcio_getGiornateCampionato(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // $querygiornatefc="SELECT g.*, ga.inizio, ga.fine, c.id_partita,
    // c.id_sq_casa, sq1.squadra as squadracasa,
    // c.id_sq_ospite,  sq2.squadra as squadraospite,
    //     c.formazione_casa_inviata as luc, 
    //     c.formazione_ospite_inviata as luo
    // FROM `giornate` as g
    // left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    // left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    // left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    // left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
    // where id_girone in (1,2) order by id_giornata ASC";

    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    $querygiornatefc = "SELECT g.*, ga.inizio, ga.fine
    FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    where id_girone in (1,2) order by id_giornata ASC";
    $result=$conn->query($querygiornatefc) or die($conn->error);
    $giornatefc = array();
    while ($row=$result->fetch_assoc()) {
        array_push($giornatefc, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            // "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            // "id_sq1"=>$row["id_sq_casa"],
            // "sq1"=>$row["squadracasa"],
            // "id_sq2"=>$row["id_sq_ospite"],
            // "sq2"=>$row["squadraospite"],
            // "luc"=>$row["luc"],
            // "luo"=>$row["luo"],
            )
        );
    }

    return $giornatefc;
}
function fantacalcio_getGiornate($idgirone){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    // $query= "SELECT g.*, ga.inizio, ga.fine , c.id_partita,
    // c.id_sq_casa, sq1.squadra as squadracasa,
    // c.id_sq_ospite,  sq2.squadra as squadraospite,
    //     c.formazione_casa_inviata as luc, 
    //     c.formazione_ospite_inviata as luo
    // FROM `giornate` as g
    // left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    // left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    // left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    // left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
    //     WHERE id_girone = ".$idgirone." order by id_giornata ASC";
    $query ="SELECT g.*, ga.inizio, ga.fine
    FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    WHERE id_girone = ".$idgirone." order by id_giornata ASC";
    $result=$conn->query($query);
    $giornate = array();
    while ($row=$result->fetch_assoc()) {
        array_push($giornate, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            // "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            // "id_sq1"=>$row["id_sq_casa"],
            // "sq1"=>$row["squadracasa"],
            // "id_sq2"=>$row["id_sq_ospite"],
            // "sq2"=>$row["squadraospite"],
            // "luc"=>$row["luc"],
            // "luo"=>$row["luo"],
            )
        );
    }
     return $giornate;
}
function fantacalcio_getFantasquadre(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    $squadre = array();
    // if(!isset($_SESSION['fantasquadre']))
    {
        $query="SELECT * FROM sq_fantacalcio order by squadra";
        $result=$conn->query($query);
        while($row = $result->fetch_assoc()){
            array_push($squadre, array(
                "id"=>$row["id"],
                "squadra"=>$row["squadra"],
                "allenatore"=>$row["allenatore"],
                "telefono"=>$row["telefono"],
                "email"=>$row["email"],
                "password"=>$row["password"],
                "ammcontrollata"=>$row["ammcontrollata"],
                "ammcontrollata_anno"=>$row["ammcontrollata_anno"],
                )
            );
        }
        $_SESSION['fantasquadre'] = $squadre;
    }
    $squadre = $_SESSION['fantasquadre'];
    return $squadre;
}

function fantacalcio_getPartite_byGiornataId($giornata_id)
{

    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query= "SELECT g.*, ga.inizio, ga.fine, c.id_partita,
        c.id_sq_casa, sq1.squadra as squadracasa,
        c.id_sq_ospite,  sq2.squadra as squadraospite,
        c.formazione_casa_inviata as luc, 
        c.formazione_ospite_inviata as luo,
        c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti
        FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_giornata = ".$id_giornata." order by id_giornata ASC";
        // echo $query;
    $result=$conn->query($query);
    $partite = array();
    while ($row=$result->fetch_assoc()) {
        array_push($partite, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            "id_sq1"=>$row["id_sq_casa"],
            "sq1"=>$row["squadracasa"],
            "id_sq2"=>$row["id_sq_ospite"],
            "sq2"=>$row["squadraospite"],
            "luc"=>$row["luc"],
            "luo"=>$row["luo"],
            "punti_casa"=>$row["punti_casa"],
            "gol_casa"=>$row["gol_casa"],
            "punti_ospiti"=>$row["punti_ospiti"],
            "gol_ospiti"=>$row["gol_ospiti"],
            )
        );
    }
     return $partite;
}

function fantacalcio_getPartite_byGironeId($girone_id)
{

    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query= "SELECT g.*, ga.inizio, ga.fine , c.id_partita,
    c.id_sq_casa, sq1.squadra as squadracasa,
    c.id_sq_ospite,  sq2.squadra as squadraospite,
        c.formazione_casa_inviata as luc, 
        c.formazione_ospite_inviata as luo,
        c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti
    FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_girone = ".$girone_id." order by id_giornata ASC";
        // echo $query;
    $result=$conn->query($query);
    $partite = array();
    while ($row=$result->fetch_assoc()) {
        array_push($partite, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            "id_sq1"=>$row["id_sq_casa"],
            "sq1"=>$row["squadracasa"],
            "id_sq2"=>$row["id_sq_ospite"],
            "sq2"=>$row["squadraospite"],
            "luc"=>$row["luc"],
            "luo"=>$row["luo"],
            "punti_casa"=>$row["punti_casa"],
            "gol_casa"=>$row["gol_casa"],
            "punti_ospiti"=>$row["punti_ospiti"],
            "gol_ospiti"=>$row["gol_ospiti"],
            )
        );
    }
     return $partite;
}

function fantacalcio_getAltrePartite($id_giornata, $id_squadra)
{
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query = "SELECT g.*, ga.inizio, ga.fine , c.id_partita,
    c.id_sq_casa, sq1.squadra as squadracasa,
    c.id_sq_ospite,  sq2.squadra as squadraospite,
        c.formazione_casa_inviata as luc, 
        c.formazione_ospite_inviata as luo,
        c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti
    FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
    WHERE g.giornata_serie_a_id = 
    							(
                                    select giornata_serie_a_id from giornate where id_giornata = $id_giornata
                                )
    AND g.id_giornata not in ($id_giornata)
    and (id_sq_casa = $id_squadra OR id_sq_ospite = $id_squadra)
    order by g.id_giornata ASC";
        // echo $query;
    $result=$conn->query($query);
    $partite = array();
    while ($row=$result->fetch_assoc()) {
        array_push($partite, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            "id_sq1"=>$row["id_sq_casa"],
            "sq1"=>$row["squadracasa"],
            "id_sq2"=>$row["id_sq_ospite"],
            "sq2"=>$row["squadraospite"],
            "luc"=>$row["luc"],
            "luo"=>$row["luo"],
            "punti_casa"=>$row["punti_casa"],
            "gol_casa"=>$row["gol_casa"],
            "punti_ospiti"=>$row["punti_ospiti"],
            "gol_ospiti"=>$row["gol_ospiti"],
            )
        );
    }
     return $partite;
  
}

function fantacalcio_getGiornate_bySerieAId($giornata_serie_a_id){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query= "SELECT g.*, ga.inizio, ga.fine
        FROM `giornate` as g
        left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
        WHERE giornata_serie_a_id = ".$giornata_serie_a_id." order by id_giornata ASC";
        // echo $query;
    $result=$conn->query($query);
    $giornate = array();
    while ($row=$result->fetch_assoc()) {
        array_push($giornate, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            )
        );
    }
     return $giornate;
}
function fantacalcio_getPartite_bySerieAId($giornata_serie_a_id){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query= "SELECT g.*, ga.inizio, ga.fine, c.id_partita,
        c.id_sq_casa, sq1.squadra as squadracasa,
        c.id_sq_ospite,  sq2.squadra as squadraospite,
        c.formazione_casa_inviata as luc, 
        c.formazione_ospite_inviata as luo,
        c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti
        FROM `giornate` as g
    left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    left join `calendario` as c on `g`.`id_giornata` =  `c`.`id_giornata` 
    left join `sq_fantacalcio` as sq1 on `c`.`id_sq_casa` =  `sq1`.`id`
    left join `sq_fantacalcio` as sq2 on `c`.`id_sq_ospite` =  `sq2`.`id`
        WHERE giornata_serie_a_id = ".$giornata_serie_a_id." order by id_giornata ASC";
        // echo $query;
    $result=$conn->query($query);
    $partite = array();
    while ($row=$result->fetch_assoc()) {
        array_push($partite, array(
            "id_giornata"=>$row["id_giornata"],
            "id_girone"=>$row["id_girone"],
            "id_partita"=>$row["id_partita"],
            "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            "id_sq1"=>$row["id_sq_casa"],
            "sq1"=>$row["squadracasa"],
            "id_sq2"=>$row["id_sq_ospite"],
            "sq2"=>$row["squadraospite"],
            "luc"=>$row["luc"],
            "luo"=>$row["luo"],
            "punti_casa"=>$row["punti_casa"],
            "gol_casa"=>$row["gol_casa"],
            "punti_ospiti"=>$row["punti_ospiti"],
            "gol_ospiti"=>$row["gol_ospiti"],
            )
        );
    }
     return $partite;
}

function fantacalcio_getSquadreSenzaFormazione($giornata_serie_a_id){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once ("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query="SELECT * FROM sq_fantacalcio 
    where id  in (
        select distinct id_sq_casa from calendario where id_giornata=".$giornata_serie_a_id ."
        union 
        select distinct id_sq_ospite from calendario where id_giornata=".$giornata_serie_a_id."
    ) 
    and id not in (select distinct id_squadra from formazioni where id_giornata=".$giornata_serie_a_id.")";
        // echo $query;
    $result=$conn->query($query);
    $squadre = array();
    while ($row=$result->fetch_assoc()) {
        array_push($squadre, array(
            "id"=>$row["id"],
            "squadra"=>$row["squadra"],
            )
        );
    }
     return $squadre;
}
?>