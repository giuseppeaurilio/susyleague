<?
include("dbinfo_susyleague.inc.php");

$query=$_POST['query'];
echo $query;

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database"); 
//echo "database_opened";
$result=mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
mysql_close();

?> 