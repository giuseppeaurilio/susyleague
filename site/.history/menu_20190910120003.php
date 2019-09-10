<?php
if(!isset($_SESSION)) 
{
	session_start();
}
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
}
else { 
	$allenatore= $_SESSION['allenatore'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Susy League</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="/js/jquery.datetimepicker.js"></script> -->
<script src="https://kit.fontawesome.com/c4dd1e8c85.js"></script>

<script type="text/javascript" src="/plugin/menu/js/stellarnav.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/plugin/menu/css/stellarnav.css">

<script type="text/javascript" src="/plugin/jquery.connections.js"></script>
<script type="text/javascript" src="/js/global.js"></script>

<!-- <script src="css/jquery.datetimepicker.min.css"></script> -->
<link href="/style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php 

// include("dbinfo_susyleague.inc.php");

// #echo "username = " . $username;

include_once ("dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");;

$query="SELECT * FROM sq_fantacalcio";
$result=mysqli_query($con,$query);

$num=mysqli_num_rows($result); 



#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='anno'";
#echo $query2;
$result_generale=mysqli_query($con,$query_generale);
//$anno=mysqli_result($result_generale,0,"valore");

$row=mysqli_fetch_array($result_generale,MYSQLI_ASSOC);
$anno="2016";
$anno=$row["valore"];
?>


<header>
<div style="width: 100%; overflow: hidden;">
    	<div style="width: 50%; float: left;"> <h1>Susy League <?php  echo $anno; ?> </h1> </div>
    	<div style="width:50%; float: left; text-align:right;">
		<figure><img src="/Logo_sponsor_small.png" syle="object-fit: fitcontent;"></figure> 
	</div>
</div>

</header>


<script type="text/javascript">
    $(document).ready(function($) {
        $('.stellarnav').stellarNav({
            theme: 'dark',
            breakpoint: 800,
            position: 'left',
            // mobileMode: true
        });
    });
</script>

<div class="stellarnav">
		  <ul class="navbar">
			 <li><a href="/homepage/home.php"> <i class="fas fa-home"></i> Home</a></li>
			 <li><a href="/display_classifiche.php"><i class="fas fa-chart-line"></i> Classifiche</a></li>
			 <li><a href="#"><i class="fas fa-calendar-alt"></i> Calendari</a>
				<ul>
				   <li><a href="/display_calendario.php?&id_girone=1">Apertura</a></li>
					 <li><a href="/display_calendario.php?&id_girone=2">Chiusura</a></li>
					 <li><a href="/display_calendario_coppaitalia_gironi.php">CoppaItalia-Gironi</a></li>
					 <li><a href="/display_calendario_coppaitalia_tabellone.php">CoppaItalia-Tabellone</a></li>
					 <li><a href="/display_calendario.php?&id_girone=6">Coppa delle coppe</a></li>
				   <li><a href="/display_calendario_finali.php">Finale campionato</a></li>
				</ul>         
			 </li>
			 <li><a href="#"><i class="fas fa-users"></i> Rose</a>
				<ul>
				   <li><a href="/display_rose.php" >Susy League</a></li>
				   <li><a href="/display_giocatori.php">Serie A</a></li>
				   <!-- <li><a href="/display_asta.php">Asta</a></li> -->
				</ul>         
			 </li>
			 <li><a href="/invio_formazione.php"><i class="fas fa-futbol"></i> Invio formazione</a></li>
			 <li><a href="#"><i class="far fa-thumbs-up"></i> Social</a>
				<ul>
				   <li><a href="/display_sondaggi.php">Sondaggi</a></li>
				   <li><a href="/display_mercato.php">Mercato</a></li>

				</ul>         
			 </li>
			 <li><a href="/cambia_password.php" ><i class="fas fa-lock"></i> Password</a></li>
			 <li><a href="/homepage/regolamento.pdf" ><i class="fas fa-pencil-alt"></i> Regolamento</a></li>
			 <li><a href="/presidente/amministrazione.php" ><i class="fas fa-tools"></i> Amministrazione</a></li>
		  </ul>
		 </div>


<?php
if (!(isset($allenatore) && $allenatore != '')) {
	echo '<p align="right"><a align="right" href="/login.php" >Login</a></p>';
}
else { 
	echo '<p align="right" >Benvenuto ' . $allenatore . ',<a class="login" href="/logout.php" >Logout</a></p>';
}
?>