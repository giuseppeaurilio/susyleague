<?php
$uname = "";
$pword = "";
$errorMessage = "";
$action ="";
include_once ("dbinfo_susyleague.inc.php");
// Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
$conn = getConnection();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action = $_POST['action'];

    if($action=="login")
    {
        // $uid = $_POST['uid'];
        $uname = strtolower($_POST['uname']);
        $pword = $_POST['password'];
        session_start();
        $uname = htmlspecialchars($uname);
        $pword = htmlspecialchars($pword);
        if ($uname=='presidente') 
        {
            $SQL =  "SELECT 'Presidente' as 'allenatore', '0' as 'id' FROM generale WHERE id_parametro=4 and valore=\"$pword\"";}
            
        else{
            $SQL = "SELECT * FROM sq_fantacalcio WHERE LOWER(squadra) = \"$uname\" AND password = \"$pword\"";
        }
        // echo $SQL;
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
                // $_SESSION['login'] = "";
                // #header ("Location: signup.php");
                // $errorMessage = "Login fallito";
                // $_SERVER["HTTP_REFERER"]=$_POST['referer'];
                echo json_encode(array(
                    'error' => array(
                        'msg' => "Login fallito",
                        // 'code' => $e->getCode(),
                    ),
                ));
            }	
        }
        else {
            // $errorMessage = "Error logging on";
            echo json_encode(array(
                'error' => array(
                    'msg' => "Error logging on",
                    // 'code' => $e->getCode(),
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