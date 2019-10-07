<?php
$uname = "";
$pword = "";
$errorMessage = "";
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

    if($action=="cambiopassword")
    {
        $uname = !empty ($_POST['squadra'])??"";
        $pwordold = !empty($_POST['passwordvecchia'])?? "";
        $pwordnew = !empty($_POST['passwordnuova'])?? "";
        session_start();
        $uname = htmlspecialchars($uname);
        $pwordold = htmlspecialchars($pwordold);
        $pwordnew = htmlspecialchars($pwordnew);
        //verifico che non sia il presidente

        $message = "";
        if($uname =="presidente")
        {
            $message="Il presidente non può cambiare password.";
        }

        //verifico che i dati siano corretti
        if(!isset($pwordold) || $pwordold == "")
        {
            $message="Password non valida.";
        }
        //se tutto ok, faccio il cambio password

        $result = $conn->query($SQL);
        $num_rows = $result->num_rows;
        if ($result) {
            if ($num_rows > 0) {
                $row=$result->fetch_assoc();
                $id_squadra=$row["id"];
                $allenatore=$row["allenatore"];
                $_SESSION['login'] = $id_squadra;
                #echo "valore id_Squadra al login= " . $id_squadra;
                $_SESSION['allenatore']=$allenatore;
                #echo "valore allenatore al login= " . $allenatore;
                
                #header ("Location: ". $_POST['referer']);
                // $errorMessage = "allenatore $allenatore - Login eseguito";
                
                // $_SERVER["HTTP_REFERER"]=$_POST['referer'];
                echo json_encode(array(
                    'result' => "true",
                    'message' => "Login eseguito",
                ));
            }
            else {

                echo json_encode(array(
                    'error' => array(
                        'msg' => "Login fallito",
                    ),
                ));
            }	
        }
        else {
            echo json_encode(array(
                'error' => array(
                    'msg' => "Error logging on",
                ),
            ));
        }
    }
    else if($action=="logout")
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        echo json_encode(array(
            'result' => "true",
            'message' => "Logout eseguito",
        ));
    }
}
?>