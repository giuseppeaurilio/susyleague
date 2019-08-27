<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
}
else { 
	$allenatore= $_SESSION['allenatore'];
}
?>

<head>
<title>Susy League</title>
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
<div>
    	<div > <h1>Susy League <?php  echo $anno; ?> </h1> </div>
    	<div >
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
			 <li><a href="/display_classifiche.php">Classifiche</a></li>
			 <li><a href="#">Calendari</a>
				<ul>
				   <li><a href="/display_calendario.php?&id_girone=1">Calendario Apertura</a></li>
				   <li><a href="/display_calendario.php?&id_girone=2">Calendario Chiusura</a></li>
				   <li><a href="/display_calendario.php?&id_girone=3">Calendario Finale</a></li>
				</ul>         
			 </li>
			 <li><a href="#">Rose</a>
				<ul>
				   <li><a href="/display_rose.php" >Susy League</a></li>
				   <li><a href="/display_giocatori.php">Serie A</a></li>
				   <li><a href="/display_asta.php">Asta</a></li>
				</ul>         
			 </li>
			 <li><a href="/invio_formazione.php">Invio formazione</a></li>
			 <li><a href="#">Social</a>
				<ul>
				   <li><a href="/display_sondaggi.php">Sondaggi</a></li>
				   <li><a href="/display_mercato.php">Mercato</a></li>

				</ul>         
			 </li>
			 <li><a href="/cambia_password.php" >Password</a></li>
			 <li><a href="/homepage/regolamento.pdf" >Regolamento</a></li>
			 <li><a href="/presidente/amministrazione.php" >Amministrazione</a></li>
		  </ul>
		 </div>


<?php
if (!(isset($allenatore) && $allenatore != '')) {
	echo '<div><a href="/login.php" >Login</a></div>';
}
else { 
	echo '<div>Benvenuto ' . $allenatore . ',<a class="login" href="/logout.php" >Logout</a></div>';
}
?>
