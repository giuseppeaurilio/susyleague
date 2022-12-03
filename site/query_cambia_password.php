<?php


include_once ("dbinfo_susyleague.inc.php");

// Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
$conn = getConnection();



$id_squadra=mysqli_escape_String($conn,$_POST['id_squadra']);
$old_password=mysqli_escape_String($conn,$_POST['old_password']);
$new_password=mysqli_escape_String($conn,$_POST['new_password']);
$new_password_2=mysqli_escape_String($conn,$_POST['new_password_2']);

#echo "squadra=" . $id_squadra . "<br>";
#echo "old password=" . $old_password . "<br>";
#echo "new password=" . $new_password . "<br>";
#echo "new password_2=" . $new_password_2 . "<br>";

$query="SELECT password FROM sq_fantacalcio where id='" . $id_squadra . "'";
#echo $query;
$result=$conn->query($query);
#print_r($result);
#var_dump($result);
$saved_password=$result->fetch_assoc()["password"];

#echo "saved password=" . $saved_password . "<br>";

if ($new_password==$new_password_2) {
	if ($saved_password==$old_password) {
		$query="UPDATE `sq_fantacalcio` SET `password`='" . $new_password . "' WHERE `id`='" . $id_squadra ."'";
		$result=$conn->query($query);
		echo "Nuova password salvata!";
	}
	else echo "La vecchia password inserita non e' corretta. Se non ricordi la vecchia password puoi scrivere al presidente per farla resettare";
}
else echo "Le due nuove password non coincidono.";

?>

