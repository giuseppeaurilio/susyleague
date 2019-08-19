<?php

include("dbinfo_susyleague.inc.php");
backup_tables($localhost,$username,$password,$database);


/* backup the db OR just a table */
function backup_tables($localhost,$user,$pass,$name,$tables = '*')
{
	$return="CREATE DATABASE IF NOT EXISTS " . $name .";\n"; 
	$return.="USE " . $name .";\n"; 
	$link = mysql_connect($host,$user,$pass) or die( "Unable to connect database");
	//echo $host.$user.$pass;
	mysql_select_db($name,$link) or die( "Unable to select database");
	
	//get all of the tables

		$tables = array();
		$result = mysql_query("show full tables where Table_Type = 'BASE TABLE'");
		//$result = mysql_query("show tables");
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}

	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
			
				
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					//echo (is_null($row[$j])) . "+";
					if (!(is_null($row[$j])))	{				
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);

					 $return.= '"'.$row[$j].'"' ; } else { $return.= 'NULL'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
					//echo (is_null($row[$j])) . "-";
				}

				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	
		//get all of the Views

		$tables = array();
		$result = mysql_query("show full tables where Table_Type = 'VIEW'");
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}

	
	//cycle through
	foreach($tables as $table)
	{
		$return.= 'DROP VIEW IF EXISTS '.$table.";\n";
		$return.= 'CREATE TABLE '.$table." (";
		$fields = array();
		$result = mysql_query("show columns from $table");		
		while($row = mysql_fetch_row($result))
		{
			//echo "<br>row=";
			//print_r($row);
			//echo $row[0] ."-".$row[1];
			$return.= "\n" . $row[0] . " " . $row[1] .",";
		}	
		$return=rtrim($return, ",");
		$return.=");\n\n";
		

	}	
	foreach($tables as $table)	
	{
		$return.= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE VIEW '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
	}




	//echo "return=" . $return;
	//save file
	$handle = fopen('db_backup.sql','w');
	fwrite($handle,$return);
	fclose($handle);


}

?>
