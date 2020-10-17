<?php

include_once ("dbinfo_susyleague.inc.php");

$mysqlDatabaseName =$database;
$mysqlUserName =$username;
$mysqlPassword =$password;
$mysqlHostName =$localhost;
$mysqlExportPath ='db_backup.sql';

//Si prega di non modificare i seguenti punti
//Esportazione del database e dell'output dello stato
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
// $command="mysqldump --user=$mysqlUserName --password=$mysqlPassword --host=$mysqlHostName $mysqlDatabaseName >  $mysqlExportPath";
// exec($command,$output=array(),$worked);
echo $command;
echo "<br>";
exec($command);
// echo $output;
// echo "<br>";
echo "dump complete";
// switch($worked){
	// if()
	// case 0:
	// echo 'Il database <b>' .$mysqlDatabaseName .'</b> è stato memorizzato con successo nel seguente perscorso '.getcwd().'/' .$mysqlExportPath .'</b>';
	// break;
	// case 1:
	// echo 'Si è verificato un errore durante la esportatione da <b>' .$mysqlDatabaseName .'</b> a '.getcwd().'/' .$mysqlExportPath .'</b>';
	// break;
	// case 2:
	// echo 'Si è verificato un errore di esportazione, controllare le seguenti informazioni: <br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
	// break;
	// }

// backup_tables($localhost,$username,$password,$database);

// /* backup the db OR just a table */
// function backup_tables($localhost,$user,$pass,$name,$tables = '*')
// {
// 	$return="CREATE DATABASE IF NOT EXISTS " . $name .";\n"; 
// 	$return.="USE " . $name .";\n"; 
// 	// $link = mysql_connect($host,$user,$pass) or die( "Unable to connect database");
// 	// //echo $host.$user.$pass;
// 	// mysql_select_db($name,$link) or die( "Unable to select database");
// 	// Create connection
// 	$conn = new mysqli($localhost, $username, $password,$database);

// 	// Check connection
// 	if ($conn->connect_error) {
// 		die("Connection failed: " . $conn->connect_error);
// 	}
	
// 	//get all of the tables

// 	$tables = array();
// 	// $result = mysql_query("show full tables where Table_Type = 'BASE TABLE'");
// 	$query= "show full tables where Table_Type = 'BASE TABLE'";
// 	$result=$conn->query($query);
// 	//$result = mysql_query("show tables");
// 	while ($row=$result->fetch_assoc()) {
// 	{
// 		$tables[] = $row[0];
// 	}

	
// 	//cycle through
// 	foreach($tables as $table)
// 	{
// 		// $result = mysql_query('SELECT * FROM '.$table);
// 		$num_fields = mysql_num_fields($result);
		
// 		$return.= 'DROP TABLE IF EXISTS '.$table.';';
// 		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
// 		$return.= "\n\n".$row2[1].";\n\n";
		
// 		for ($i = 0; $i < $num_fields; $i++) 
// 		{
// 			while($row = mysql_fetch_row($result))
// 			{
			
				
// 				$return.= 'INSERT INTO '.$table.' VALUES(';
// 				for($j=0; $j < $num_fields; $j++) 
// 				{
// 					//echo (is_null($row[$j])) . "+";
// 					if (!(is_null($row[$j])))	{				
// 					$row[$j] = addslashes($row[$j]);
// 					$row[$j] = ereg_replace("\n","\\n",$row[$j]);

// 					 $return.= '"'.$row[$j].'"' ; } else { $return.= 'NULL'; }
// 					if ($j < ($num_fields-1)) { $return.= ','; }
// 					//echo (is_null($row[$j])) . "-";
// 				}

// 				$return.= ");\n";
// 			}
// 		}
// 		$return.="\n\n\n";
// 	}
	
	
// 	//get all of the Views

// 	$tables = array();
// 	$result = mysql_query("show full tables where Table_Type = 'VIEW'");
// 	while($row = mysql_fetch_row($result))
// 	{
// 		$tables[] = $row[0];
// 	}

	
// 	//cycle through
// 	foreach($tables as $table)
// 	{
// 		$return.= 'DROP VIEW IF EXISTS '.$table.";\n";
// 		$return.= 'CREATE TABLE '.$table." (";
// 		$fields = array();
// 		$result = mysql_query("show columns from $table");		
// 		while($row = mysql_fetch_row($result))
// 		{
// 			//echo "<br>row=";
// 			//print_r($row);
// 			//echo $row[0] ."-".$row[1];
// 			$return.= "\n" . $row[0] . " " . $row[1] .",";
// 		}	
// 		$return=rtrim($return, ",");
// 		$return.=");\n\n";
		

// 	}	
// 	foreach($tables as $table)	
// 	{
// 		$return.= 'DROP TABLE IF EXISTS '.$table.';';
// 		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE VIEW '.$table));
// 		$return.= "\n\n".$row2[1].";\n\n";
// 	}




// 	//echo "return=" . $return;
// 	//save file
// 	$handle = fopen('db_backup.sql','w');
// 	fwrite($handle,$return);
// 	fclose($handle);


// }

?>
