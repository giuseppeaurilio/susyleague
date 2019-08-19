<?php
include('send_message_post.php');
//include('send_telegram_update.php');
echo "pippo";

$date = date('m/d/Y h:i:s a', time());
$testo="susyleague.000webhostapp.com";
$a=send_message_post($testo);
echo $a;

//send_telegram_update();


?>
