<?php
// echo "pippo";
$name_loc='db_backup.sql';
$name_remote='db_backup' .date('m-d-Y_hia').'.sql';

include("backup_database_sql.php");
include("send_telegram_update.php");


$answer_tg=send_telegram_update();

$ftp_username='susy79';
$ftp_userpass='andspe79';
$ftp_server = "ftp.drivehq.com";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

ftp_pasv($ftp_conn, true);


//echo "login=";
//print_r($login);
//echo "connection=";
//print_r($ftp_conn);
// upload file
$a=ftp_chdir($ftp_conn, 'My Documents');
//echo "cambio directory=" . $a;
if (ftp_put($ftp_conn, $name_remote, $name_loc, FTP_BINARY))
  {
  echo "Successfully uploaded";
  }
else
  {
  echo "Error uploading $name_loc.";
  print_r(error_get_last());
  }

// close connection
ftp_close($ftp_conn);


 
?>