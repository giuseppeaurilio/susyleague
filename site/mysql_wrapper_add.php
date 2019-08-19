<?
#include("dbinfo.inc.php");

$database=htmlspecialchars($_POST['database']);
$username=htmlspecialchars($_POST['username']);
$password=htmlspecialchars($_POST['password']);
$query=htmlspecialchars($_POST['query']);

echo "database " . $database;
echo "username " . $username;
echo "password " . $password;
echo "query " . $query;


mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database"); 
echo "database_opened";
mysql_query($query);

mysql_close();
$str = $str . "Dato aggiunto correttamente";
echo $str;
?> 