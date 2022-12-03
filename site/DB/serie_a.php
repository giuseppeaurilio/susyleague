<?php
function seriea_getGiornate(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query="SELECT id, descrizione, inizio, fine FROM `giornate_serie_a` order by id asc";

    $result=$conn->query($query);
    $giornatesa = array();
    while($row = $result->fetch_assoc()){    
        array_push($giornatesa, array(
            "id"=>$row["id"],
            "descrizione"=>$row["descrizione"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            )
        );
    }

    return $giornatesa;
}
function seriea_getGiornataCorrente(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    $adesso = date('Y-m-d H:i:s');
    $query="SELECT * FROM `giornate_serie_a` WHERE '$adesso' >inizio and '$adesso' < fine";
// echo $query; 
    $result=$conn->query($query);
    $giornatesa = array();
    while($row = $result->fetch_assoc()){    
        array_push($giornatesa, array(
            "id"=>$row["id"],
            "descrizione"=>$row["descrizione"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            )
        );
    }
    if(!empty($giornatesa))
        return $giornatesa[0];
    else
        return null;
}

function seriea_getGiornataUltima(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    $adesso = date('Y-m-d H:i:s');
    $query="SELECT * FROM `giornate_serie_a` where fine is not null and '$adesso' > fine order by fine desc LIMIT 1";
// echo $query;
    $result=$conn->query($query);
    $giornatesa = array();
    while($row = $result->fetch_assoc()){    
        array_push($giornatesa, array(
            "id"=>$row["id"],
            "descrizione"=>$row["descrizione"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            )
        );
    }

    if(!empty($giornatesa))
        return $giornatesa[0];
    else
        return null;
}

function seriea_getGiornataProssima(){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    $adesso = date('Y-m-d H:i:s');
    $query="SELECT * FROM `giornate_serie_a` where inizio is not null and '$adesso' < inizio order by inizio limit 1";

    $result=$conn->query($query);
    $giornatesa = array();
    while($row = $result->fetch_assoc()){    
        array_push($giornatesa, array(
            "id"=>$row["id"],
            "descrizione"=>$row["descrizione"],
            "inizio"=>$row["inizio"],
            "fine"=>$row["fine"],
            )
        );
    }

    if(!empty($giornatesa))
        return $giornatesa[0];
    else
        return null;
}

?>