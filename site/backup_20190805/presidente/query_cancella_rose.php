<?
include("../dbinfo_susyleague.inc.php");


mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query = "TRUNCATE `rose`";

$result=mysql_query($query);
echo $result


?> 

