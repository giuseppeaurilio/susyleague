<?php
include_once ('conf.php');

date_default_timezone_set('Europe/Rome');
$date = date('m/d/Y h:i:s a', time());

$testo="pippopippo $date";
$http_string="https://api.telegram.org/bot$BOT_TOKEN/sendmessage?&chat_id=$GROUP_CHAT_ID&text=$testo";
echo $http_string;
$response = file_get_contents($http_string);
echo $response;
?>
