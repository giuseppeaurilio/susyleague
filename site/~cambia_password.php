<?php
include_once ("menu.php");
?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}


.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

</style>


<h2>Cambia password</h2>
<form action="query_cambia_password.php" method="post" class="a-form">
Squadra: <select name="id_squadra">

<?php
include_once ("dbinfo_susyleague.inc.php");
#echo $username;
// Create connection
if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



// $query="SELECT * FROM sq_fantacalcio";
// $result=$conn->query($query);
include_once ("DB/fantacalcio.php");
$result=fantacalcio_getFantasquadre();
// $num=$result_numrows; 

// $i=0;

while ($row=$result->fetch_assoc()) {



$id=$row["id"];
$squadra=$row["squadra"];
$allenatore=$row["allenatore"];

#echo $squadra . "<br>";
#echo $allenatore . "<br>";

?>
  <option value="<?php echo $id ?>"><?php echo $squadra ?></option>

<?php
++$i;
}

?>

</select><br>


Vecchia Password: <input type="password" name="old_password" id="old_password"><BR>
Nuova password: <input type="password" name="new_password" id="new_password"><BR>
Conferma nuova password: <input type="password" name="new_password_2" id="new_password_2"><BR>
<input type="submit" value="Submit">

</form>




<?php
include_once ("footer.html");

?>

</body>
</html>




