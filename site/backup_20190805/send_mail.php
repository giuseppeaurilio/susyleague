<?php
/**
 * This example shows sending a message using PHP's mail() function.
 */

require './PHPMailer-master/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('webmaster@heliohost.org', 'webmaster');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('v.malandruccolo@inwind.it', 'Vezio');
//Set the subject line
$mail->Subject = 'Backup Database susy-league';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('Questa mail contine un backup del database del sito susy-league.heliohost.org');
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('/home/www/susyleague.eu.pn/backup_database/backup.sql');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";

}

?>