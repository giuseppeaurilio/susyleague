<?php
include("menu.php");

?>

<style>
.dataTable th {
    word-wrap: break-word;
    height:200px;
}
	td, th {
    border: 1px solid #000;
}
th.opzione {
    width: 400px !important;
}
th.wider {
    /*width: 120px !important;*/
}
th.rotate {
	height: 150px;
	padding: 0px;
	font-weight: normal;
	
}

.rotate {
             filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
         -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
     -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
      -ms-transform: rotate(-90.0deg);  /* IE9+ */
       -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
  -webkit-transform: rotate(-90.0deg);  /* Safari 3.1+, Chrome */
          transform: rotate(-90.0deg);  /* Standard */
}
</style>




<h1>Sondaggi</h1>


<?php
// include("dbinfo_susyleague.inc.php");
// mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");
include_once ("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




$query_squadre='select squadra, id from sq_fantacalcio order by id';
// $result_squadre=mysql_query($query_squadre);
// $num_squadre=mysql_numrows($result_squadre);
$result_squadre=$conn->query($query_squadre); 
#echo "num squadre=".$num_squadre;	
	
$query="SELECT * FROM sondaggi order by id";
// $result=mysql_query($query);
// $num=mysql_numrows($result); 

$result=$conn->query($query); 




#echo "num=".$num;
// while ($i < $num) {
while ($row=$result->fetch_assoc()) {
	$id=$row["id"];//mysql_result($result,$i,"id");

	$scadenza=$row["scadenza"];//mysql_result($result,$i,"scadenza");
	$testo=$row["testo"];//mysql_result($result,$i,"testo");
	$risp_multipla=$row["risposta_multipla"];//mysql_result($result,$i,"risposta_multipla");
	#echo "risp_mult=" . $risp_multipla;
	#echo 'id_sondaggio=' .$id;
	$query_sondaggio='select sondaggi.id as id_sondaggio, sondaggi.testo, sondaggi_opzioni.id as id_opzione,sondaggi_opzioni.opzione, sondaggi_risposte.id_squadra from sondaggi inner join sondaggi_opzioni left join sondaggi_risposte  on sondaggi_risposte.id_sondaggio=sondaggi.id and sondaggi_risposte.id_opzione=sondaggi_opzioni.id where sondaggi.id=' .$id .' and sondaggi_opzioni.id_sondaggio=sondaggi.id';
	#echo $query_sondaggio;
	$result_sondaggio=mysql_query($query_sondaggio);
	$num_sondaggio=mysql_numrows($result_sondaggio); 
	#echo 'num_sondaggio=' . $num_sondaggio;
	
	
	$id_opzione=0;
	$array_opzioni=array();
	$opzioni_testo=array();

	#echo($num_sondaggio);
	while($id_opzione<$num_sondaggio){
		$array_opzioni[$id_opzione]=strval(mysql_result($result_sondaggio,$id_opzione,"id_opzione")). "_" .strval(mysql_result($result_sondaggio,$id_opzione,"id_squadra"));
		$opzioni_testo[mysql_result($result_sondaggio,$id_opzione,"id_opzione")]=mysql_result($result_sondaggio,$id_opzione,"opzione");
		++$id_opzione;
	}
	#print_r($array_opzioni);
	#echo "opzioni testo=";
	#print_r($opzioni_testo);
	$num_opzioni_singole_str= $array_opzioni[$num_sondaggio-1];
	$pieces = explode("_", $num_opzioni_singole_str);
	$num_opzioni_singole=intval($pieces[0]);
	#echo $num_opzioni_singole;
	
	
	?>
	
	<div style=" border: 2px solid blue; ">
	<h2><?php echo $testo;?> </h2>
	<?php
	date_default_timezone_set('Europe/Rome');
	$adesso = date('Y-m-d H:i:s');
    #echo "adesso=" . $adesso;
    #echo "scadenza" . $scadenza;
    if ($adesso<$scadenza){
		echo '<form action="query_voto_sondaggio.php" method="post">';
		echo '<input type="hidden" name="id_sondaggio" value="' . $id . '">';
		for ($x = 1; $x <= $num_opzioni_singole; $x++) {
			if ($risp_multipla) {
				echo '<input type="checkbox" name="selectedIDs[]" value="' . $x . '">' . $opzioni_testo[$x] ;
			}
			else {
				echo '<input type="radio" name="selectedIDs[]" value=' . $x . '>' . $opzioni_testo[$x] ;
			}
			
		}
		echo '<input type="submit" value="Invia">';
	}
  	?>
  	<h3>Scadenza:<?php echo $scadenza;?> </h3>
</form>
	
	
	
	
	
	
	
	
	
	
    <table id="example" class="dataTable display" cellspacing="0" width="100%">
	<thead>
	<tr> 
	<!-- First column header is not rotated -->
	<th class="opzione">Opzione</th>
	<?php
	echo '<th ><div class="rotate">Totale</div></th>';

	$id_squadra=0;
	while ($id_squadra < $num_squadre) {
		#echo '<th><div class="rotate">Fisrt Number Second Number</div></th>';
		echo '<th ><div class="rotate">' . mysql_result($result_squadre,$id_squadra,"squadra") .'</div></th>';
		++$id_squadra;
    }
    ?>
	</tr>
	</thead>
	
	
	<?php
	
    for ($x = 1; $x <= $num_opzioni_singole; $x++) {
		$count_find=0;
		$str_out="";
		echo "<tr>";
		echo "<td>" . $opzioni_testo[$x] . "</td>";
		
		for ($y = 1; $y <= $num_squadre; $y++) {
			#echo $x . "_" . $y . "<br>";
			#echo "search" . array_search($x . "_" . $y,$array_opzioni) . "<br>";
				if (is_int(array_search($x . "_" . $y,$array_opzioni))) {
					++$count_find;
					$str_out= $str_out . '<td align="center" style="text-align:center; font-size:150%; font-weight:bold; color:green;">&#10004;</td>';
					}
					else {
					$str_out= $str_out . "<td></td>";
					}
			 					
		}
		echo "<td>".$count_find."</td>";
		echo $str_out;
		echo "</tr>";
	}
	
	?>
	</table>
	</div>

	<?php
++$i;
}
?>
