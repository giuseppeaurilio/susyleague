<?php 
if(isset($conn))
{$conn->close();}
if(isset($con))
{$con->close();}

?>

<footer>
<!-- webmaster webmaster@susy-league.heliohost.org -->
<span style="float:left; display: block">
    powered by: susyleague plc.
    </span>
    <span style="float:right; display: block"> web site V1.1</span>
</footer>
<div id="dialog" title="Login" style="display:none;">

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
<span>Password:</span> <input type="password" Name ='password'  value="">
<!-- style="display:none" -->
<div id="result" class="result" >login fallita</div>
<div id="btnLogin" class="bottone">Loggin</div>


<!-- <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p> -->
</div>
<div id="loginDialog" title="Login" style="display:none;">
  <!-- <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p> -->
</div>

<div class="modal"><!-- Place at bottom of page --></div> 

</body>
</html>