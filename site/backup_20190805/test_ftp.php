<?php
// connect and login to FTP server

$ftp_username='susy79';
$ftp_userpass='andspe79';
$ftp_server = "ftp.drivehq.com";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

ftp_pasv($ftp_conn, true);

$file = "localfile.txt";
echo "login=";
print_r($login);
echo "connection=";
print_r($ftp_conn);
// upload file
$a=ftp_chdir($ftp_conn, 'My Documents');
echo "cambio directory=" . $a;
if (ftp_put($ftp_conn, "server_file.txt", $file, FTP_BINARY))
  {
  echo "Successfully uploaded $file.";
  }
else
  {
  echo "Error uploading $file.";
  print_r(error_get_last());
  }

// close connection
ftp_close($ftp_conn);
?> 
