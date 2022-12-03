<?php

$idgiornata;
$idsquadre;
if( isset($_POST["idgiornata"]) && !empty($_POST["idgiornata"])
&& isset($_POST["idsquadre"]) && !empty($_POST["idsquadre"]))
{
    $idgiornata = $_POST['idgiornata'];
    $idsquadre = json_decode($_POST['idsquadre']);
    try {
        aggiungi_partita($idgiornata, $idsquadre[0], $idsquadre[1]);
        echo json_encode(array(
            'result' => "true",
            'message' => "Operazione correttamente eseguita",
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
                // 'code' => $e->getCode(),
            ),
        ));
    }
}
function aggiungi_partita($giornata, $casa, $ospite) {
    // include_once ("../dbinfo_susyleague.inc.php");
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();
    try {
        $query="DELETE FROM .`calendario` WHERE `id_giornata`=" . ($giornata) . ";";
        $query.="INSERT INTO .`calendario`(`id_giornata`, `id_sq_casa`, `id_sq_ospite`) VALUES (" . $giornata .",". $casa .",".  $ospite .")";
        // $result=mysql_query($query);
        $conn;
        $conn->multi_query($query);
        // echo $query ."<br>";
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
                // 'code' => $e->getCode(),
            ),
        ));
    }
    finally {
        $conn->close();
    }
}


?>
