<?php



function send_message($testo) {
	
$BOT_TOKEN='270744877:AAHCXrPHvHJgWOXEsO_hCuTpR17K2R-l5Wk';
$USER_CHAT_ID='311291453';
$GROUP_CHAT_ID='-152656922';

 $http_string="https://api.telegram.org/bot$BOT_TOKEN/sendmessage?&chat_id=$GROUP_CHAT_ID&text=$testo";
 echo $http_string;
 $response = file_get_contents($http_string);
 echo $response;
}

?>
