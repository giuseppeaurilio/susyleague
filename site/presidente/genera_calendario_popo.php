<?php
include_once ("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="INSERT INTO `susy79_league`.`gironi` (`id_girone`, `add_casa`, `nome`) VALUES (3 , 0, 'popo')";

$result=mysql_query($query);

// giornata 34-36
$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (34, NULL, NULL,3)";
$result=mysql_query($query);
$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (35, NULL, NULL,3)";
$result=mysql_query($query);
$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (36, NULL, NULL,3)";
$result=mysql_query($query);


// giornata 37 Coppa delle coppe
$query="INSERT INTO `susy79_league`.`giornate` (`id_giornata`, `inizio`, `fine`,`id_girone`) VALUES (37, NULL, NULL,3)";
$result=mysql_query($query);


echo "<br> Calendario playoff playout e coppa delle coppe e' stato creato";
?>
