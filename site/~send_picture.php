<?php


$path=$_POST['path'];
	
$BOT_TOKEN='270744877:AAHCXrPHvHJgWOXEsO_hCuTpR17K2R-l5Wk';
$USER_CHAT_ID='311291453';
$GROUP_CHAT_ID_PAOLA='-152656922';
$GROUP_CHAT_ID_SUSYLEAGUE='-181841313';

$CHAT_ID=$GROUP_CHAT_ID_SUSYLEAGUE;
$CHAT_ID=$USER_CHAT_ID;


//$path="https://upload.wikimedia.org/wikipedia/commons/thumb/1/13/CPV-ANG-2013-01-27.svg/512px-CPV-ANG-2013-01-27.svg.png";
//$path="susyleague.000webhostapp.com/canvas/vezio.png";
$postdata = http_build_query(
    array(
//        'photo' => "susyleague.000webhostapp.com/make_picture_2.php?&id_giornata=2&id_incontro=2&rotation=0",
//        'photo' =>  "https://upload.wikimedia.org/wikipedia/commons/1/13/CPV-ANG-2013-01-27.svg",
//        'photo' =>  "https://upload.wikimedia.org/wikipedia/commons/thumb/1/13/CPV-ANG-2013-01-27.svg/512px-CPV-ANG-2013-01-27.svg.png",
		  'photo' => $path,
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

 $http_string="https://api.telegram.org/bot$BOT_TOKEN/sendPhoto";
 $response = file_get_contents($http_string, false, $context);
return $response;

// echo $http_string;
// echo $response;



?>
