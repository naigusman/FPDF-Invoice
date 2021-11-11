<?php
$message=urlencode($otp." is your App OTP and is valid for 10 minutes. Do not share the OTP with anyone.");
$phone="XXXXXXXXXX";

$username="Your User Name";
$password="Your Password";
$senderId="Sender Id";


$ch=curl_init('https://web.insignsms.com/api/sendsms?username='.$username.'&password='.$password.'&senderid='.$senderId.'&message='.$message.'&numbers='.$phone.'&dndrefund=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
?>
