<?php
include("dbinfo_susyleague.inc.php");

echo "host=" . $host . "<br>";
echo "username=" . $username . "<br>";
echo "password=" . $password . "<br>";
echo "database=" . $database . "<br>";

$con=mysqli_connect($host,$username,$password,$database) or die( "Unable to select database");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * from sq_fantacalcio";
echo $sql;
$result=mysqli_query($con,$sql);

// Fetch all
echo "tutta lettura";
$a=mysqli_fetch_all($result,MYSQLI_ASSOC);
$num=mysqli_num_rows($result);
print_r($a). "<br>";
echo "num=" . $num . "<br>";
print_r($a[1]). "<br>";
// Fetch array
//$a=mysqli_fetch_array($result,MYSQLI_ASSOC);
//echo "prima lettura";
//print_r($a);

//echo "seconda lettura";
//$a=mysqli_fetch_array($result,MYSQLI_ASSOC);
//print_r($a);
// Free result set

$i=0;

while ($i < $num) {
echo "<br>" . "indice= " . $i;
//$b=$a[i];
print_r($a[$i]);
//print_r($a);
$i=$i+1;
}
mysqli_free_result($result);



mysqli_close($con);
?>
