<?PHP

$uname = "";
$pword = "";
$errorMessage = "";


session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['squadra'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	//==========================================
	//	CONNECT TO THE LOCAL DATABASE
	//==========================================

	include("dbinfo_susyleague.inc.php");


	// Create connection
	$conn = new mysqli($localhost, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	// echo "Connected successfully";


		#echo "database found";

		if ($uname=='0') 
		$SQL =  "SELECT 'Presidente' as 'allenatore', '0' as 'id' FROM generale WHERE id_parametro=4 and valore=\"$pword\"";
		else
		$SQL = "SELECT * FROM sq_fantacalcio WHERE id = $uname AND password = \"$pword\"";
		#echo "<br> query="	;	
		#echo $SQL;
		$result = $conn->query($SQL);
		#echo "<br> connessione";
		#print_r($conn);
		#echo "<br>result";
		#print_r($result);
		$num_rows = $result->num_rows;

		
	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

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
				$errorMessage = "allenatore $allenatore - Login eseguito";
				$_SERVER["HTTP_REFERER"]=$_POST['referer'];
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


<?php
include("menu.php");

?>

<FORM NAME ="form1" METHOD ="POST" ACTION ="login.php">
Squadra:	
<?php
	include("dbinfo_susyleague.inc.php");


	// Create connection
	$conn = new mysqli($localhost, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	// echo "Connected successfully";


$query = "SELECT * FROM sq_fantacalcio";
#echo $sql;
$result=$conn->query($query);

$num=$result->num_rows; 
#print_r($result);
#echo "num=" . $num;
echo '<select name="squadra">'; 
echo "<option value='0' size =30 >Presidente</option>";
while($row = $result->fetch_assoc()) 
{        
print_r($row);
echo "<option value='".$row['id']."'>".$row['squadra']."</option>"; 
}
echo "</select>";


?>





Password: <INPUT type="password" Name ='password'  value="">
<input type="hidden" name="referer" value="<?= $caller ?>" />



<P align = center>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
</P>

</FORM>


<p><?= $errorMessage ?></p>






</body>
</html>
