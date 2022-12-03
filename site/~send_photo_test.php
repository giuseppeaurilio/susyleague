<?php
//include_once ('send_message_post.php');
include_once ('send_picture.php');


$date = date('m/d/Y h:i:s a', time());
$testo="ciao Vezio";
$a=send_picture("pippo");
echo $a;

//send_telegram_update();


?>
