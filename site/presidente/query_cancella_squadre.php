<?
include("../dbinfo_susyleague.inc.php");


mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query = "TRUNCATE `sq_fantacalcio`";
echo $query;
$result=mysql_query($query);



?> 

