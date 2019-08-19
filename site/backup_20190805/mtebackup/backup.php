<?
// Inspired by tutorials: http://www.phpfreaks.com/tutorials/130/6.php
// http://www.vbulletin.com/forum/archive/index.php/t-113143.html
// http://hudzilla.org


// Create the mysql backup file
// edit this section
$dbhost = "localhost"; // usually localhost
$dbuser = "susy79"; //enter your database username here
$dbpass = "andspe79"; //enter your database password here
$dbname = "susy79_league"; // enter your database name here
$sendto = "Send to <vezio79@katamail.com>";
$sendfrom = "Send From <susyleague@email.com>";
$sendsubject = "backup database susy league";
$bodyofemail = "Here is the daily backup of my database.";
// don't need to edit below this section

$backupfile = $dbname . date("Y-m-d") . '.sql.gz';
system("mysqldump -h $dbhost -u $dbuser --password=$dbpass --routines $dbname | gzip > $backupfile");

// Mail the file


include('Mail.php');
include('Mail/mime.php');

$message = new Mail_mime();
$text = "$bodyofemail";
$message->setTXTBody($text);
$message->AddAttachment($backupfile);
$body = $message->get();
$extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
$headers = $message->headers($extraheaders);
$mail = Mail::factory("mail");
$mail->send("$sendto", $headers, $body);


// Delete the file from your server
unlink($backupfile);
?>
