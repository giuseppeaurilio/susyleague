
<span>Squadra:	</span>
<?php
include_once ("dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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