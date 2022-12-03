<?
#include_once ("dbinfo.inc.php");
$database=$_GET['database'];
$username=$_GET['username'];
$password=$_GET['password'];
$query=$_GET['query'];

#echo "database= " . $database . "\r\n";
#echo "username= " . $username . "\r\n";
#echo "password= " . $password . "\r\n";
#echo "query= " . $query . "\r\n";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$result=mysql_query($query);

$num=mysql_numrows($result); 
$num_col=mysql_numfields($result); 
$results_out = array();
while($row=mysql_fetch_array($result))
{
   $results_out[] = $row;
}
echo (json_encode($results_out))

?>
