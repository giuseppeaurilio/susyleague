 <?php
$servername = "localhost";
$username = "username";
$password = "password";

$username="id258940_susy79";
$password="andspe79";
$database="id258940_susy_league";
$servername = "localhost";



// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?> 
