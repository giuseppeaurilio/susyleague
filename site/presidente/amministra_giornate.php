<?php
include("menu.php");

?>
<script>
// jQuery.datetimepicker.setLocale('it');
// $(document).ready(function(){
//     jQuery('#btnDataDa').datetimepicker();
// });
</script>

<h1>Amministazione Giornate</h2>
<?php


$query="SELECT * FROM giornate where id_girone in (1,2) order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$i=0;
while ($row=$result->fetch_assoc()) {



$id_giornata=$row["id_giornata"];
$id_girone=$row["id_girone"];
$inizio=$row["inizio"];
$fine=$row["fine"];
#var_dump($inizio);

$inizio_a=date_parse($inizio);
$fine_a=date_parse($fine);
#var_dump($inizio_a);
#echo "inizio= " . $inizio_a["year"];
?>
<fieldset>
<legend>Giornata: <?php echo $id_giornata; ?></legend>
<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">

<h2 for="giornata">Giornata <?php echo $id_giornata; ?></h2>
<input type="hidden" name="giornata" value="<?php echo $id_giornata; ?>">
<div>Inizio: </div>
<div>
Giorno:<input type="text" name="g_inizio" size="5" value="<?php echo $inizio_a['day'] ?>" >
Mese:<input type="text" name="m_inizio" size="5" value="<?php echo $inizio_a['month'] ?>" >
Anno:<input type="text" name="a_inizio" size="5" value="<?php echo $inizio_a['year'] ?>">
Ore:<input type="text" name="h_inizio" size="5" value="<?php echo $inizio_a['hour'] ?>">
Minuti:<input type="text" name="min_inizio" size="5" value="<?php echo $inizio_a['minute'] ?>">
<!-- <input type="button" id="btnDataDa" value="data"><br> -->
<div>Fine: </div>
Giorno:<input type="text" name="g_fine" size="5" value="<?php echo $fine_a['day'] ?>" >
Mese:<input type="text" name="m_fine" size="5" value="<?php echo $fine_a['month'] ?>" >
Anno:<input type="text" name="a_fine" size="5" value="<?php echo $fine_a['year'] ?>">
Ore:<input type="text" name="h_fine" size="5" value="<?php echo $fine_a['hour'] ?>">
Minuti:<input type="text" name="min_fine" size="5" value="<?php echo $fine_a['minute'] ?>"><br>
<input type="submit" value="Invia" class="btn_amministrazione">
</form>
<div class="mainaction">
<a href="calcola_giornata.php?id_giornata=<?php echo $id_giornata ?>&id_girone=<?php echo $id_girone ?>" >Calcola Giornata</a>
</div>
</div>
</fieldset>
<hr>

<?php
++$i;
}
?>
<?php 
include("../footer.php");
?>
