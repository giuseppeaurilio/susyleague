<?PHP

$uname = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['squadra'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);
    
    include("../configuration.php");
    // Create connection
	$conn = new mysqli($localhost, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
}
?>