<?php 
include("./configuration.php");

#echo "username = " . $username;
$con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");;

// $query="SELECT * FROM sq_fantacalcio";
// $result=mysqli_query($con,$query);

// $num=mysqli_num_rows($result); 

$query_generale="SELECT valore FROM generale where nome_parametro='anno'";
$result_generale=mysqli_query($con,$query_generale);

$row=mysqli_fetch_array($result_generale,MYSQLI_ASSOC);
$anno=$row["valore"];
$con->close();
?>
<!-- <img src="./images/header.png" id="imghb"> -->
<h1>Susy League <?php  echo $anno; ?> </h1> 
<!-- <figure><img src="/Logo_sponsor_small.png" width=230px height=115px></figure>  -->