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

$xml          = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$root_element = "sq_fatntacalcio"; //fruits
$xml         .= "<$root_element>";

if (!$result) {
    die('Invalid query: ' . mysql_error());
}
 
if(mysql_num_rows($result)>0)
{
   while($result_array = mysql_fetch_assoc($result))
   {
        $xml .= "<sq_fatntacalcio>";
      //loop through each key,value pair in row
      foreach($result_array as $key => $value)
      {
         //$key holds the table column name
         $xml .= "<$key>";
 
         //embed the SQL data in a CDATA element to avoid XML entity issues
         $xml .= "<![CDATA[$value]]>";
 
         //and close the element
         $xml .= "</$key>";
      }
 
      $xml.="<sq_fatntacalcio>";
   }
}

 //close the root element
$xml .= "</$root_element>";
 
//send the xml header to the browser
header ("Content-Type:text/xml");
 
//output the XML data
echo $xml;

?>
