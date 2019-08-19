<?php

$temperature=mysql_escape_String($_GET['temperature']);
$humidity=mysql_escape_String($_GET['humidity']);

echo "Today is " . date("Y/m/d") . "<br>";
date_default_timezone_set("Europe/Rome");
$txt= date("Y/m/d") . " " .date("h:i:sa");
echo "date= $txt";

$myfile = fopen("data_log.txt", "a") or die("Unable to open file!");
$txt.=" temperature=$temperature,humidity=$humidity\n";
fwrite($myfile, $txt);
fclose($myfile);
echo $txt;
?>

