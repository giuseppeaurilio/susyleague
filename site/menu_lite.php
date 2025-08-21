<?php
// header('Content-Type: text/html; charset=ISO-8859-1');
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
<!-- Google tag (gtag.js) -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-QTL5W2CYXB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-QTL5W2CYXB');
</script> -->

<title>Susy League</title>

<meta name="viewport" content="width=device-width, user-scalable=no,  initial-scale=1.0">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<link rel="manifest" href="/manifest.json" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.3/mustache.min.js"></script>
<!-- <script src="https://kit.fontawesome.com/c4dd1e8c85.js"></script> -->
<script src="https://kit.fontawesome.com/c4dd1e8c85.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FitText.js/1.2.0/jquery.fittext.js"></script>


<script type="text/javascript" src="/plugin/menu/js/stellarnav.js"></script>
<script type="text/javascript" src="/plugin/jQuerySimpleCounter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/plugin/menu/css/stellarnav.css">

<!-- <script type="text/javascript" src="/plugin/jquery.connections.js"></script> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

<script type="text/javascript" src="/js/global.js"></script>
<script type="text/javascript" src="/js/fantacalcio.js"></script>

<link rel="stylesheet" href="/plugin/slick/slick.css">
<link rel="stylesheet" href="/plugin/slick/slick-theme.css">
<!-- <script src="/plugin/slick/jquery.min.js"></script> -->
<script src="/plugin/slick/slick.js"></script>

<link href="/css/susyleague.css" rel="stylesheet" type="text/css">

</head>

<body>

<?php 
// include_once ("dbinfo_susyleague.inc.php");

// #echo "username = " . $username;

include_once ("dbinfo_susyleague.inc.php");
$conn = getConnection();
// Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
// // $conn->set_charset("ISO-8859-1");
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// $con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");;

// $query="SELECT * FROM sq_fantacalcio";
// $result=mysqli_query($conn,$query);

// // $num=mysqli_num_rows($result); 
// $num = $result->num_rows;
include_once ("DB/fantacalcio.php");
include_once ("DB/parametri.php");
$squadrefc = fantacalcio_getFantasquadre();
$num = count($squadrefc);

#echo "<b><left>Squadre</center></b><br><br>";

// $query_generale="SELECT valore FROM generale where nome_parametro='anno'";
// #echo $query2;
// $result_generale=mysqli_query($conn,$query_generale);
// //$anno=mysqli_result($result_generale,0,"valore");

// $row=mysqli_fetch_array($result_generale,MYSQLI_ASSOC);
// $anno="2016";
// $anno=$row["valore"];
$anno = getAnno();
?>


<header>
<a href="/homepage/home.php" style="color:white;">
	<div style="width: 100%; overflow: hidden; vertical-align: middle;background-color: rgb(0,0,0, 0.3);">
			<div style="width: 60%; float: left;"> <h1 style="margin: 10px 0 0 0;">Serie A Centro Tim di NG</h1>
			<h2 style="padding: 0; background-color: transparent;"> SusyLeague <?php  echo $anno; ?></h2> </div>
			<div style="width:40%; float: left; text-align:center;">
			<figure style="margin: 10px 0;"><img src="/images/Logo_sponsor_small.png" syle="object-fit: fitcontent;"></figure> 
		</div>
	</div>
</a>
</header>



<script>
// var noimage = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
// var noimage = "https://content.fantacalcio.it/web/campioncini/small/no-campioncino.png";

imgError = function(img){
	img.src = "https://content.fantacalcio.it/web/campioncini/small/no-campioncino.png";
};
</script>

