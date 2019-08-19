<!DOCTYPE html>
<html>
<head>
<style>
.lista li{
font-size:25px;
}
</style>

<?php 
include("menu.php");
?>


<body>
<h1>Attenzione!!!</h1>
<h1>Premendo il pulsante invia verranno cancellati tutti i dati correnti.</h1>
<form action="crea_anno.php" method="post">
Anno: <input type="text" name="anno"><br>
Fantamilioni: <input type="text" name="fantamilioni"><br>
<input type="submit">
</form>



</body>
</html>
