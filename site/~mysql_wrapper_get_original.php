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

#echo $num;
#echo $num_col;


mysql_close();
#while($e=mysql_fetch_assoc($result))
#        $output[]=$e;
#echo (json_encode($output))


$i = 0;
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result);
	echo  $meta->name ."\t";
	++$i;
}
echo "\r\n";
$i=0;


while ($i < $num) {
	$j=0;
	while ($j < $num_col) {
#echo mysql_result($result,$i,"Squadra");
		echo mysql_result($result,$i,$j) ."\t";
		++$j;
	} 
#echo ",";
#echo mysql_result($result,$i,"Sigla");
echo "\r\n";
++$i;
} 
?>
