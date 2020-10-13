<?php
header('Content-Type: text/html; charset=ISO-8859-1');
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
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta charset="utf-8">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.3/mustache.min.js"></script>
<script src="https://kit.fontawesome.com/c4dd1e8c85.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FitText.js/1.2.0/jquery.fittext.js"></script>


<script type="text/javascript" src="/plugin/menu/js/stellarnav.js"></script>
<script type="text/javascript" src="/plugin/jQuerySimpleCounter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/plugin/menu/css/stellarnav.css">

<!-- <script type="text/javascript" src="/plugin/jquery.connections.js"></script> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

<script type="text/javascript" src="/js/global.js"></script>


<link href="/style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php 

// include("dbinfo_susyleague.inc.php");

// #echo "username = " . $username;

include_once ("dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// $conn->set_charset("ISO-8859-1");
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
<a href="/homepage/home.php" style="color:white;">
	<div style="width: 100%; overflow: hidden; vertical-align: middle;background-color: rgb(0,0,0, 0.3);">
			<div style="width: 60%; float: left;"> <h1 style="margin: 10px 0 0 0;">Serie A Centro Tim di NG</h1>
			<h2 style="padding: 0; background-color: transparent;"> SusyLeague <?php  echo $anno; ?></h2> </div>
			<div style="width:40%; float: left; text-align:center;">
			<figure style="margin: 10px 0;"><img src="/Logo_sponsor_small.png" syle="object-fit: fitcontent;"></figure> 
		</div>
	</div>
</a>
</header>


<script type="text/javascript">
    $(document).ready(function($) {
        $('#mainMenu').stellarNav({
            theme: 'dark',
            breakpoint: 650,
			position: 'left',
			// sticky: true,
			// scrollbarFix: true

            // mobileMode: true
        });
    });
</script>
<div style="background:#366b82;">
	<div id="mainMenu" class="stellarnav">
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
				<li><a href="/display_calendario_supercoppa.php">Supercoppa</a></li>
			</ul>         
			</li>
			<li><a href="#"><i class="fas fa-users"></i> Rose</a>
			<ul>
				<li><a href="/display_rose.php" >Susy League </a> </li>
				<li><a href="/display_giocatori.php">Serie <i class="fab fa-autoprefixer"></i></a> </li>
				<li><a href="/display_statistiche.php">Statistiche <i class="fas fa-chart-bar"></i></a></li>
			</ul>  
			<li><a href="#"><i class="fas fa-gavel"></i> Asta</a>       
			<!-- <li <a href="#"><i class="fas fa-gavel"></i> Asta</a> -->
				<ul>
				<li><a href="/display_riepilogoasta.php">Asta Live! <i class="fas fa-satellite-dish"></i></a></li>
				<li><a href="/display_registroasta.php">Registro acquisti <i class="fas fa-balance-scale"></i></a></li>
				<?php if ((isset($_SESSION['login'])  && ($_SESSION['login'] == '1'))) {
					echo '<li><a href="/display_riepilogoasta_peppe.php">asta peppe <i class="fab fa-pinterest-p"></i></a></li>';
				}
				?>
				</ul>         
			</li>

			</li>
			<li><a href="/invio_formazione.php"><i class="fas fa-futbol"></i> Invio formazione</a></li>
			<li><a href="#"><i class="far fa-thumbs-up"></i> Social</a>
			<ul>
				<li><a href="/display_sondaggi.php">Sondaggi</a></li>
				<li><a href="/display_mercato.php">Mercato</a></li>

			</ul>         
			</li>
			<li><a href="#"><i class="fas fa-crown"></i> Lega</a>
			<ul>
				<li><a href="/display_organodirettivo.php" ><i class="fas fa-sitemap"></i> Organo direttivo</a></li>
				<li><a href="/display_albodoro.php" ><i class="fas fa-book-open"></i> Albo D'oro</a></li>
				<li><a href="/display_record.php" ><i class="fas fa-poll"></i> Statistiche e curiosità</a></li>
				<li><a href="/homepage/regolamento.pdf" ><i class="fas fa-pencil-alt"></i> Regolamento</a></li>
			</ul>
			<?php if ((isset($_SESSION['login'])  && ($_SESSION['login'] == '0'))) {
				echo '<li><a href="/presidente/amministrazione.php" ><i class="fas fa-tools"></i> Amministrazione</a></li>';
			}
			?>
			<!-- <li><a href="#" >			
				LOGIN
				</a>
			</li> -->
		</ul>
	</div>
	<div class="loginsection">

	<?php
	if (!(isset($_SESSION['allenatore']) && $_SESSION['allenatore'] != '')) {
		echo '
		<a href="#" style="text-decoration:none; color:white; padding: 15px 5px;" id="btnShowLogin">
		<i class="fas fa-sign-in-alt"></i> Login</a>';
	}
	else { 
		
		echo '	<ul>
					<li><a id="presidenteloggato" href="#">Benvenuto ' . $allenatore . ' <i class="fas fa-sort-down"></i></a>
						<ul class="submenu">
							<li><a id="btnCambioPassword" style="text-decoration:none; color:white;" class="login" href="#" >Cambio Password</a></li>
							<li><a id="btnLogout" style="text-decoration:none; color:white;" class="login" href="#" >Logout <i class="fas fa-sign-out-alt"></i> </a></li>
						</ul>
					</li>
				</ul>';
		
	}
	// echo $_SESSION['allenatore'];
	?>
	</div>
</div>
<script>
$(document).ready(function(){
	
	$("#btnShowLogin").off("click").bind("click", showLogin);
	$("#btnLogout").off("click").bind("click", callLogout);
	$("#presidenteloggato").off("click").bind("click", showSubMenu);
	$("#btnCambioPassword").off("click").bind("click", showCambioPassword);
})
showSubMenu=function(){
	$( ".loginsection .submenu" ).toggle();
}
showLogin=function(){
	$( "#loginDialog" ).dialog({modal:true});
}

showCambioPassword=function(){
	$( "#cambioPasswordDialog" ).dialog({modal:true});
	$( ".loginsection .submenu" ).toggle();
}
callLogout=function(){
    var action ="logout";
    $.ajax({
            type:'POST',
            url:'/login_popup_controller.php',
            data: {
                "action": action
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
					// alert(resp.message);
					window.location.href = '/home.php';
                }
                else{
                    alert(resp.error.msg);
                }
                
                
            }
    }); 
}
</script>

