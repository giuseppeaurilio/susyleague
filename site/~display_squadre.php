<?
include_once ("menu.html");

?>

<?
include_once ("dbinfo_susyleague.inc.php");
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM sq_fantacalcio";
$result=mysql_query($query);

$num=mysql_numrows($result); 

mysql_close();

echo "<b><left>Squadre</center></b><br><br>";

?>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 
<th><font face="Arial, Helvetica, sans-serif">Id</font></th>
<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Allenatore</font></th>
<th><font face="Arial, Helvetica, sans-serif">Telefono</font></th>
<th><font face="Arial, Helvetica, sans-serif">E-mail</font></th>
<th><font face="Arial, Helvetica, sans-serif">password</font></th>
</tr>

<?
$i=0;
while ($i < $num) {
$id=mysql_result($result,$i,"id");
$squadra=mysql_result($result,$i,"squadra");
$allenatore=mysql_result($result,$i,"allenatore");
#$telefono=mysql_result($result,$i,"telefono");
$telefono=3*$i;
$email=mysql_result($result,$i,"email");
$passwor=mysql_result($result,$i,"password");

?>

<tr> 
<td><font face="Arial, Helvetica, sans-serif"><? echo "$id"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><? echo "$squadra"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><? echo "$allenatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><? echo "$telefono"; ?></font></td>

<td><font face="Arial, Helvetica, sans-serif"><a href="mailto:<? echo "$email"; ?>">E-mail</a></font></td>
<td><font face="Arial, Helvetica, sans-serif"><? echo "$passwor"; ?></font></td>

</tr>
<?
++$i;
} 
echo "</table>";


?>
<?
include_once ("footer.html");

?>

</body>
</html>