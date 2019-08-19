<?php

// Contact subject
$subject ="subject";
// Details
$message="detalle";

// Mail of sender
$mail_from="soloporobjetos@gmail.com";
// From
$header="from: javi &lt;sljavi@gmail.&gt;";

// Enter your email address
$to ='vezio79@katamail.com';

//$send_contact=mail($to,$subject,$message,$header);
$send_contact=mail('vezio79@katamail.com','subject','main text');

// Check, if message sent to your email
// display message "We've recived your information"
if($send_contact){
	echo "We've recived your contact information";
}else {
	echo "ERROR";
}

?>