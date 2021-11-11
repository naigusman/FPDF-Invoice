<?php
$to[]=($phone);
$message=urlencode("Welcome to YOUR COMPANY NAME. Your OTP is: ".$random);
$curl = curl_init();
$ch=curl_init('http://bulksms.digicalmmedia.com/api/mt/SendSMS?APIKEY=YOUR PAI&senderid=YOUR SENDER ID&channel=TRANS&DCS=0&flashsms=0&number='.$phone.'&text='.$message.'&route=15&DLTTemplateId=YOUR TEMPLATE ID&PEID=YOUR PEID');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($curl);
?>
