<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
div.fixed {
    position: fixed;
    top: 500px;
    left: 500px;
    width: 300px;
    border: 3px solid #8AC007;
}
.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}
</style>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
$(document).ready(function()
{
    $("tr[contenteditable=true]").blur(function() {

	var str = $(this).attr("id");
	var arr = str.split("_");
	console.log("valore a=" + arr[0]);
	console.log("valore b=" + arr[1]);
	var id_squadra=arr[1];

 	//var id_squadra = $(this).find('td:eq(0)').text();
	//var id_posizione= $(this).find('td:eq(1)').text();
	var squadra= $(this).find('td:eq(0)').text();
	var allenatore= $(this).find('td:eq(1)').text();
	var telefono=$(this).find('td:eq(2)').text(); // Task
	var email=$(this).find('td:eq(3)').text();  // Task
	var password=$(this).find('td:eq(4)').text();  // Task
	
	var query_str = "?&id_squadra=" + id_squadra +"&squadra=" + squadra + "&allenatore=" + allenatore + "&telefono=" +telefono + "&email=" + email + "&password=" + password;

	$.ajax({
	type: "POST",
	url: "query_update_squadre.php",
	data: query_str,
	cache: false,
	success: function(result){
      	console.log(result);
	}

});
	setTimeout(function(){location.reload();
	}, 1000);
 		
            });

        });

</script>


<?php 

include("menu.php");


include("../dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$query="SELECT * FROM sq_fantacalcio";
$result=$conn->query($query);

$num=$result->num_rows; 


echo "<b><left>Squadre</center></b><br><br>";

?>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Allenatore</font></th>
<th><font face="Arial, Helvetica, sans-serif">Telefono</font></th>
<th><font face="Arial, Helvetica, sans-serif">E-mail</font></th>
<th><font face="Arial, Helvetica, sans-serif">password</font></th>
</tr>

<?php 
$i=0;
while ($i<12) {
	$row=$result->fetch_assoc();

	$id=$row["id"];
	$squadra=$row["squadra"];
	$allenatore=$row["allenatore"];
	$telefono=$row["telefono"];
	#$telefono=3*$i;
	$email=$row["email"];
	$passwor=$row["password"];

?>

<tr height="50" id="<?php  echo "squadra_". $id ; ?>"  contenteditable="true" > 
<td    ><font face="Arial, Helvetica, sans-serif"   ><?php  echo "$squadra"; ?></font></td>
<td ><font face="Arial, Helvetica, sans-serif"   ><?php  echo "$allenatore"; ?></font></td>
<td   ><font face="Arial, Helvetica, sans-serif"  ><?php  echo "$telefono"; ?></font></td>
<td  ><font face="Arial, Helvetica, sans-serif"  ><?php  echo "$email"; ?></font></td>
<td ><font face="Arial, Helvetica, sans-serif"  ><?php  echo "$passwor"; ?></font></td>

</tr>
<?php 
++$i;
}



echo "</table>";



include("footer.html");

?>

</body>
</html>
