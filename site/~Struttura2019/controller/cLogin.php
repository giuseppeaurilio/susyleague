<?PHP

$uname = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['squadra'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);
    
    include_once ("../configuration.php");
    // Create connection
	if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
    }
    
    $SQL = "SELECT * FROM sq_fantacalcio WHERE id = $uname AND password = \"$pword\"";
    $result = $conn->query($SQL);
    $num_rows = $result->num_rows;
    if ($result) {
        if ($num_rows > 0) {
            $row=$result->fetch_assoc();
            $id_squadra=$row["id"];
            $allenatore=$row["allenatore"];
            $_SESSION['login'] = $id_squadra;
            $_SESSION['allenatore']=$allenatore;
            $errorMessage = "allenatore $allenatore - Login eseguito";
            
        }
        else {

            $_SESSION['login'] = "";
            $errorMessage = "Login fallito";
        }	
    }
    else {
        $errorMessage = "Error logging on";
    }
}
?>