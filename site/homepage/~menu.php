<?PHP
//session_start();
//if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
//	$allenatore="";
//}
//else { 
//	$allenatore= $_SESSION['allenatore'];
//}
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

#wrap	{
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
				
				.navbar li ul li a:hover	{background-color: #366b82;}
									

</style>
</head>

<body>

<?php 
include_once ("../dbinfo_susyleague.inc.php");

#echo "username = " . $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM sq_fantacalcio";
$result=mysql_query($query);

$num=mysql_numrows($result); 



#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='anno'";
#echo $query2;
$result_generale=mysql_query($query_generale);
$anno=mysql_result($result_generale,0,"valore");
#$anno=$username;
?>


<header>
<div style="width: 100%; overflow: hidden;">
    	<div style="width: 70%; float: left;"> <h1>Susy League <?php  echo $anno; ?> </h1> </div>
    	<div style="width=25%;">pippo
		<figure><img src="/Logo_sponsor_small.png" width=230px height=115px></figure> 
	</div>
</div>
</header>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var d = 0; d < dropdowns.length; d++) {
      var openDropdown = dropdowns[d];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>


	 <div id="wrap">
		  <ul class="navbar">
			 <li><a href="/homepage/home.php">Home</a></li>
			 <li><a href="../display_classifiche.php">Classifiche</a></li>
			 <li><a href="#">Calendari</a>
				<ul>
				   <li><a href="../display_calendario.php?&id_girone=1">Calendario Apertura</a></li>
				   <li><a href="../display_calendario.php?&id_girone=2">Calendario Chiusura</a></li>
				   <li><a href="../display_calendario.php?&id_girone=3">Calendario Finale</a></li>
				</ul>         
			 </li>
			 <li><a href="#">Rose</a>
				<ul>
				   <li><a href="../display_rose.php" >Susy League</a></li>
				   <li><a href="../display_giocatori.php">Serie A</a></li>
				</ul>         
			 </li>
			 <li><a href="/invio_formazione.php">Invio formazione</a></li>
			 <li><a href="../cambia_password.php" >Password</a></li>
			 <li><a href="regolamento.pdf" >Regolamento</a></li>
			 <li><a href="../presidente/amministrazione.php" >Amministrazione</a></li>
		  </ul>
		 </div>


<?PHP
if (!(isset($allenatore) && $allenatore != '')) {
	echo '<a class="login" href="./login.php" >Login</a>';
}
else { 
	echo '<p class="allenatore">Benvenuto ' . $allenatore . ',<a class="login" href="./logout.php" >Logout</a></p>';
}
?>


