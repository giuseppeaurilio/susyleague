<?php 
include("dbinfo_susyleague.inc.php");


$username="id258940_susy79";
$password="andspe79";
$database="id258940_susy_league";
$localhost = "localhost";


echo "localhost= ".$localhost . "<br>";
echo "username= ".$username. "<br>";
echo "password= ".$password. "<br>";
echo "database= ".$database. "<br>";
echo "pippo";


$con=mysqli_connect($localhost,$username,$password,$database);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * from sq_fantacalcio";

if ($result=mysqli_query($con,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }

mysqli_close($con);
?> 
