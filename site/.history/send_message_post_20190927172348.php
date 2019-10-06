<?php



function send_message_post($testo) {
	try{
$BOT_TOKEN='270744877:AAHCXrPHvHJgWOXEsO_hCuTpR17K2R-l5Wk';
$USER_CHAT_ID='311291453';
$GROUP_CHAT_ID_PAOLA='-152656922';
$GROUP_CHAT_ID_SUSYLEAGUE='-181841313';

$CHAT_ID=$GROUP_CHAT_ID_SUSYLEAGUE;
//$CHAT_ID=$USER_CHAT_ID;


$postdata = http_build_query(
    array(
        'text' => $testo,
        'chat_id' => $CHAT_ID
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

 $http_string="https://api.telegram.org/bot$BOT_TOKEN/sendmessage";
$response = file_get_contents($http_string, false, $context);
}
catch (Exception $e) {
    echo json_encode(array(
        'error' => array(
            'message' => $e->getMessage(),
            // 'code' => $e->getCode(),
        ),
    ));
}
finally {
    return $response;
    if(isset($conn))
        {$conn->close();}
}


// echo $http_string;
// echo $response;


}

?>
