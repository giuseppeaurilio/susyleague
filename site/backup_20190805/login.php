<?PHP

$uname = "";
$pword = "";
$errorMessage = "";
//==========================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==========================================
function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}
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


	$db_handle = mysql_connect($localhost, $username, $password);
	$db_found = mysql_select_db($database, $db_handle);
		#echo "search database";
	if ($db_found) {
		#echo "database found";
		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);
		if ($uname=='0') 
		$SQL =  "SELECT 'Presidente' as 'allenatore', '0' as 'id' FROM generale WHERE id_parametro=4 and valore=$pword";
		else
		$SQL = "SELECT * FROM sq_fantacalcio WHERE id = $uname AND password = $pword";
		#echo $SQL;
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

		
	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		if ($result) {
			if ($num_rows > 0) {
				$id_squadra=mysql_result($result,0,"id");
				$allenatore=mysql_result($result,0,"allenatore");
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

	mysql_close($db_handle);

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
#echo "ciao";
include("dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "SELECT * FROM sq_fantacalcio";
#echo $sql;
$result=mysql_query($query);

$num=mysql_numrows($result); 

#echo "num=" . $num;
echo '<select name="squadra">'; 
echo "<option value='0' size =30 >Presidente</option>";
while($row = mysql_fetch_array($result)) 
{        
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
