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
<h2>Mercato</h2>

<?php 

$query="SELECT a.id_annuncio,a.testo, b.squadra, b.id, a.data_annuncio  FROM mercato as a inner join  sq_fantacalcio as b where a.id_squadra=b.id ; ";
//echo $query;
$result=mysqli_query($con,$query);
$num=mysqli_num_rows($result);
?>
<div>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th>Data</th>
<th>Squadra</th>
<th>Annuncio</th>

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
<br/>
<div >
<h3> Nuovo Annuncio</h3>
<form action="/query_add_annuncio.php">
	<textarea style="width:100%;" name="testo_annuncio"  rows="10" maxlength="255"></textarea>
  	<input type="submit" value="Invia">
</form>
</div>
<?php
}

include("footer.html");

?>

</body>
</html>
