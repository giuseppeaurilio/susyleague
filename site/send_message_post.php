<?php
header('Content-Type: text/html; charset=ISO-8859-1');
function send_message_post($testo) {
try {

    //https://api.telegram.org/bot904128728:AAHJSnL1otOg7LycKyyRFlChVSaiGyIqLks/getUpdates
    // {"ok":true,"result":[{"update_id":567112134,
    //     "message":{"message_id":4,"from":{"id":281080817,"is_bot":false,"first_name":"Giuseppe","last_name":"Aurilio","username":"Peppekaiser","language_code":"it"},
    //     "chat":{"id":-227538077,"title":"test","type":"group","all_members_are_administrators":true},
    //     "date":1569920881,"group_chat_created":true}}]}

    // $USER_CHAT_ID='311291453';
    // $GROUP_CHAT_ID_PAOLA='-152656922';

    $BOT_TOKEN='270744877:AAHCXrPHvHJgWOXEsO_hCuTpR17K2R-l5Wk';//official
    $GROUP_CHAT_ID_SUSYLEAGUE='-181841313';//official

    // $BOT_TOKEN='904128728:AAHJSnL1otOg7LycKyyRFlChVSaiGyIqLks';//peppe
    // $GROUP_CHAT_ID_SUSYLEAGUE='-227538077';//peppe

    $CHAT_ID=$GROUP_CHAT_ID_SUSYLEAGUE;

    $http_string="https://api.telegram.org/bot$BOT_TOKEN/sendmessage?";
    $http_string.="chat_id=" . $CHAT_ID;
    $http_string.="&text=" . urlencode(utf8_encode($testo));

    /**************************************************************************************/
    //disabilito l'invio dei mesaggi telegram perche il provider 000webhost non li permette
    /**************************************************************************************/
    // echo "<br> <br>".$http_string."<br>";
    $response = file_get_contents($http_string);
        $response = "";
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
}

?>
