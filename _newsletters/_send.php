<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require_once('../wp-load.php');

$msg = file_get_contents('2016/02/index.html');




$subject = "Changing between heatwaves, rain and back again - and love in the garden!";


//$to = 'adrian.ohagan@gmail.com';
$to = 'team@lists.permablitz.net'; // TEAM TESTS
// $to = 'melb_blitzes@lists.permablitz.net'; // FINAL SEND!

$headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
$headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$send = wp_mail($to, $subject, $msg, $headers);
	
echo $send ? 'Sent: <strong>' . $subject . '</strong><br>To: ' . $to : 'Send failed';

?>