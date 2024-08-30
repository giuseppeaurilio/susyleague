<?php
$uname = "";
$pword = "";
$errorMessage = "";
include_once ("dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['squadra'];
    $pword = $_POST['password'];
    $action = $_POST['action'];

	$uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);
    if ($uname=='0') 
    {
        $SQL =  "SELECT 'Presidente' as 'allenatore', '0' as 'id' FROM generale WHERE id_parametro=4 and valore=\"$pword\"";}
        
    else{
        $SQL = "SELECT * FROM sq_fantacalcio WHERE id = $uname AND password = \"$pword\"";
    }
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
            
            $_SERVER["HTTP_REFERER"]=$_POST['referer'];
            echo json_encode(array(
                'result' => "true",
                'message' => "Login eseguito",
            ));
        }
        else {
            $_SESSION['login'] = "";
            #header ("Location: signup.php");
            $errorMessage = "Login fallito";
            $_SERVER["HTTP_REFERER"]=$_POST['referer'];
        }	
    }
    else {
        $errorMessage = "Error logging on";
    }
}
?>