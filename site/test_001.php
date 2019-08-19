<?php 
include("dbinfo_susyleague.inc.php");

#echo "username = " . $username;
$con=mysqli_connect($localhost,$username,$password,$database);


$query="SELECT * FROM sq_fantacalcio";
$result=mysqli_query($con,$query);

$num=mysqli_num_rows($result); 


echo "numero=" . $num;
?>
