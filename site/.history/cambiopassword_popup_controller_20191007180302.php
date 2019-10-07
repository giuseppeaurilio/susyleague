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
        $uname = !empty ($_POST['squadra'])? $_POST['squadra'] : "";
        $pwordold = !empty($_POST['passwordvecchia'])? $_POST['passwordvecchia'] :"";
        $pwordnew = !empty($_POST['passwordnuova'])? $_POST['passwordnuova'] : "";
        session_start();
        $uname = htmlspecialchars($uname);
        $pwordold = htmlspecialchars($pwordold);
        $pwordnew = htmlspecialchars($pwordnew);
        //verifico che non sia il presidente

        $message = "";
        if($message  == "" && $uname == "presidente")
        {
            $message = "Il presidente non può cambiare password." .$uname ;
        }

       // verifico che i dati siano corretti
        if($message  == "" && (!isset($pwordold) || $pwordold == ""))
        {
            $message="Vecchia password non valida.";
        }

        // if($message  == "" && (!isset($pwordnew) || $pwordnew == ""))
        // {
        //     $message="Nuova password non valida.";
        // }

        // $query = "SELECT id FROM `sq_fantacalcio` WHERE allenatore = '".$uname."' and password ='".$pwordold."'";
        // $result = $conn->query($query);
        
        // if($message  == "" && (!$result) || mysqli_fetch_assoc($result)["id"] == 0 )
        // {
        //     $message="Password non valida.";
        // }
        //se tutto ok, faccio il cambio password


        echo json_encode(array(
            'error' => array(
                'msg' => $message,
            ),
        ));
        
        // if ($result) {
        //     if ($num_rows > 0) {
        //         $row=$result->fetch_assoc();
        //         $id_squadra=$row["id"];
        //         $allenatore=$row["allenatore"];
        //         $_SESSION['login'] = $id_squadra;
        //         #echo "valore id_Squadra al login= " . $id_squadra;
        //         $_SESSION['allenatore']=$allenatore;
        //         #echo "valore allenatore al login= " . $allenatore;
                
        //         #header ("Location: ". $_POST['referer']);
        //         // $errorMessage = "allenatore $allenatore - Login eseguito";
                
        //         // $_SERVER["HTTP_REFERER"]=$_POST['referer'];
        //         echo json_encode(array(
        //             'result' => "true",
        //             'message' => "Login eseguito",
        //         ));
        //     }
        //     else {

        //         echo json_encode(array(
        //             'error' => array(
        //                 'msg' => "Login fallito",
        //             ),
        //         ));
        //     }	
        // }
        // else {
        //     echo json_encode(array(
        //         'error' => array(
        //             'msg' => "Error logging on",
        //         ),
        //     ));
        // }
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