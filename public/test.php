<?php

$audio = "2018-09-26-11-01-07-5baaf6736f510.pcm";
$accessSecret = "vvW2dPtmXF6JBCX8wakf0m7S7iiurf";
$accessKey = "LTAIn6zGdj2l62qp";

$date = gmdate("D, d M Y H:i:s \G\M\T");
$contentType = 'audio/pcm;samplerate=16000';
$accept = 'application/json';
$method = 'POST';

$headers = array( 'Content-type:'.$contentType, 'Accept:'.$accept, 'Content-Length:'.filesize($audio), 'Date:'.$date, 'method:'.$method );

$body = file_get_contents($audio);
$md5 = base64_encode(md5($body,true));
$md52 = base64_encode(md5($md5,true));
$stringToSign = $method. "\n" . $accept . "\n" . $md52 . "\n" . $contentType . "\n" . $date;
$sign = base64_encode(hash_hmac('sha1',$stringToSign,$accessSecret,true));
$headers[] = 'Authorization:Dataplus '.$accessKey.':'.$sign;
$ch = curl_init('https://nlsapi.aliyun.com/recognize?model=english&version=2.0');
curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
curl_close($ch);
print_r($res);
?>
