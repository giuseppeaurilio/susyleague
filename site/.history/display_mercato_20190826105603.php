<?php 
session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
}
include("menu.php");

?>





<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    
max-width: 1000px;
}

</style>
<h2>Mercato</h2>


<?php 
include("dbinfo_susyleague.inc.php");
//echo $username;
$con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");


$query="SELECT a.id_annuncio,a.testo, b.squadra, b.id, a.data_annuncio  FROM mercato as a inner join  sq_fantacalcio as b where a.id_squadra=b.id ; ";
//echo $query;
$result=mysqli_query($con,$query);
$num=mysqli_num_rows($result);
?>
<div>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Data</font></th>
<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Annuncio</font></th>

</tr>

<?php

$j=0;
while ($j < $num) {
$annuncio=mysqli_fetch_assoc($result);
$id_annuncio=$annuncio["id_annuncio"];
$testo=$annuncio["testo"];
$squadra=$annuncio["squadra"];
$id_squadra=$annuncio["id"];

$data_annuncio=$annuncio["data_annuncio"];
?>
<tr>
<td><?php  echo $data_annuncio; ?></td>
<td><?php  echo $squadra; ?></td>
<td><?php  echo $testo ; ?></td>
<?php

//echo "id_squadra=$id_squadra";
//echo "id_squadra_logged=$id_squadra_logged";
//echo "id_annuncio=$id_annuncio";
if ($id_squadra_logged==$id_squadra) {
	echo '<td><a href="query_delete_annuncio.php?id_annuncio=' . $id_annuncio . '">Cancella</a></td>';
	}
	else
	{echo '<td></td>'; }
?>
</tr>
<?php 
++$j;

} 
echo "</table>";
echo "</div>";
mysqli_close($con);


if ((isset($_SESSION['login']) && $_SESSION['login'] != '')) {
?>
<div style="height: 200px;">
<form action="/query_add_annuncio.php"     style="width: 80%;margin-top: 2%;">
    testo: <textarea name="testo_annuncio" cols="64" rows="4" maxlength="255"></textarea>
  <input type="submit" value="Invia">
</form>
</div>
<?php
}

include("footer.html");

?>

</body>
</html>
