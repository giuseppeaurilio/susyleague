<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

</style>




<h1>Amministazione Giornate</h2>


<?php
include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * FROM giornate order by id_giornata ASC";
$result=mysql_query($query);

$num=mysql_numrows($result); 

$i=0;
while ($i < $num) {



$id_giornata=mysql_result($result,$i,"id_giornata");
$inizio=mysql_result($result,$i,"inizio");
$fine=mysql_result($result,$i,"fine");
#var_dump($inizio);

$inizio_a=date_parse($inizio);
$fine_a=date_parse($fine);
#var_dump($inizio_a);
#echo "inizio= " . $inizio_a["year"];
?>

<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">

<label for="giornata">Giornata <?php echo $id_giornata; ?></label><br>
<input type="hidden" name="giornata" value="<?php echo $id_giornata; ?>">


Inizio: <br>
Giorno:<input type="text" name="g_inizio" size="5" value="<?php echo $inizio_a['day'] ?>" >
Mese:<input type="text" name="m_inizio" size="5" value="<?php echo $inizio_a['month'] ?>" >
Anno:<input type="text" name="a_inizio" size="5" value="<?php echo $inizio_a['year'] ?>">
Ore:<input type="text" name="h_inizio" size="5" value="<?php echo $inizio_a['hour'] ?>">
Minuti:<input type="text" name="min_inizio" size="5" value="<?php echo $inizio_a['minute'] ?>"><br>
Fine: <br>
Giorno:<input type="text" name="g_fine" size="5" value="<?php echo $fine_a['day'] ?>" >
Mese:<input type="text" name="m_fine" size="5" value="<?php echo $fine_a['month'] ?>" >
Anno:<input type="text" name="a_fine" size="5" value="<?php echo $fine_a['year'] ?>">
Ore:<input type="text" name="h_fine" size="5" value="<?php echo $fine_a['hour'] ?>">
Minuti:<input type="text" name="min_fine" size="5" value="<?php echo $fine_a['minute'] ?>"><br>
<input type="submit" value="Invia">
</form>
<a href="calcola_giornata.php?&id_giornata=<?php echo $id_giornata ?>" >Calcola Giornata</a>
<hr>

<?php
++$i;
}



?>
