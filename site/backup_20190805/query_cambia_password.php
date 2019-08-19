<?php

include("dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");



$id_squadra=mysql_escape_String($_POST['id_squadra']);
$old_password=mysql_escape_String($_POST['old_password']);
$new_password=mysql_escape_String($_POST['new_password']);
$new_password_2=mysql_escape_String($_POST['new_password_2']);

#echo "squadra=" . $id_squadra . "<br>";
#echo "old password=" . $old_password . "<br>";
#echo "new password=" . $new_password . "<br>";
#echo "new password_2=" . $new_password_2 . "<br>";

$query="SELECT password FROM sq_fantacalcio where id='" . $id_squadra . "'";
#echo $query;
$result=mysql_query($query);
#print_r($result);
#var_dump($result);
$saved_password=mysql_result($result,0,"password");

#echo "saved password=" . $saved_password . "<br>";

if ($new_password==$new_password_2) {
	if ($saved_password==$old_password) {
		$query="UPDATE `sq_fantacalcio` SET `password`='" . $new_password . "' WHERE `id`='" . $id_squadra ."'";
		$result=mysql_query($query);
		echo "Nuova password salvata!";
	}
	else echo "La vecchia password inserita non e' corretta. Se non ricordi la vecchia password puoi scrivere al presidente per farla resettare";
}
else echo "Le due nuove password non coincidono.";

?>

