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

<head>
<title>Susy League</title>
<style type="text/css">	

header {
    background-color:green;
    color:white;
    text-align:center;
    padding:5px;	 
}

footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;	 	 
}

body {padding: 0; margin: 0;}

.navbar	{
	z-index:1;
}

/* #wrap	{
		width: 100%;
		height: 50px; 
		margin: 0; 
		z-index: 99;
		position: relative;
		background-color: #366b82;
		}
	
	.navbar		{
				height: 50px;
				padding: 0;
				margin: 0;
				position: absolute;
				border-right: 1px solid #54879d;
				}
			
		.navbar li 	{
					height: auto;
					width: 100px; 
					float: left; 
					text-align: center; 
					list-style: none; 
					font: normal bold 12px/1.2em Arial, Verdana, Helvetica;  
					padding: 0;
					margin: 0;
					background-color: #366b82;					
					}

			.navbar a	{							
						padding: 18px 0; 
						border-left: 1px solid #54879d;
						border-right: 1px solid #1f5065;
						text-decoration: none;
						color: white;
						display: block;
						}

				.navbar li:hover, a:hover	{background-color: #54879d;}
								
				.navbar li ul 	{
								display: none;
								height: auto;									
								margin: 0;
								padding: 0;								
								}

				
				.navbar li:hover ul {
									display: block;									
									}
									
				.navbar li ul li	{background-color: #54879d;}
				
				.navbar li ul li a 	{
									border-left: 1px solid #1f5065; 
									border-right: 1px solid #1f5065; 
									border-top: 1px solid #74a3b7; 
									border-bottom: 1px solid #1f5065; 
									}
				
				.navbar li ul li a:hover	{background-color: #366b82;} */
									

</style>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://kit.fontawesome.com/c4dd1e8c85.js"></script>
</head>

<body>

<?php 
include("dbinfo_susyleague.inc.php");

#echo "username = " . $username;
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
    	<div style="width:50%; float: left;">
		<figure><img src="/Logo_sponsor_small.png" syle="object-fit: fitcontent;"></figure> 
	</div>
</div>

</header>

<script type="text/javascript" src="/plugin/menu/js/stellarnav.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/plugin/menu/css/stellarnav.css">
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
				   <li><a href="/display_calendario_finali.php">Finali</a></li>
				</ul>         
			 </li>
			 <li><a href="#"><i class="fas fa-users"></i> Rose</a>
				<ul>
				   <li><a href="/display_rose.php" >Susy League</a></li>
				   <li><a href="/display_giocatori.php">Serie A</a></li>
				   <li><a href="/display_asta.php">Asta</a></li>
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
