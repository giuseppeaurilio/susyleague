<?php 
include("menu.php");
?>

<!DOCTYPE html>
<html>
<head>
<style>
.lista li{
font-size:25px;
}




</style>


<body>
<h1>Menu amministratore</h1>
	<h2>Amministrazione</h2>
<ul class="lista">	
	<li><a href="amministra_squadre.php" >Amministra Squadre</a></li>
	<li><a href="amministra_rose.php" >Amministra Rose</a></li>
	<li><a href="amministra_giocatori.php" >Amministra Giocatori</a></li>	
	<li><a href="amministra_giornate.php" >Amministra Giornate</a></li>
	<li><a href="amministra_popo.php" >Amministrazione Calendario Play-off Play-out</a></li>
</ul>
<h2>Nuovo Anno</h2>
<ul class="lista">	
	<li><a href="genera_nuovo_anno.php">Genera nuovo anno</a></li>
	<li><a href="carica_giocatori.php">Carica Giocatori</a></li>
</ul>


<h2>Sondaggi</h2>
<ul class="lista">
	<li><a href="amministra_sondaggi.php" >Sondaggi</a></li>

</ul>

<h2>Homepage (home.html oppure .zip) e regolamento (regolamento.pdf)</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Selziona File da inserire:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" name="submit">
</form>



<br>

<?php 
include("footer.html");

?>


</body>
</html>
