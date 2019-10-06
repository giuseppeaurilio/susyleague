<?php
function getParametro($parametro){
    global $localhost;
    global $username;
    global $password;
    global $database;

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_generale="SELECT valore FROM generale where nome_parametro='$parametro'";
    $result_generale = $conn->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    return $f["valore"];
}

public function getFantamilioni()
{
    return getParametro("fantamilioni");
}

?>
