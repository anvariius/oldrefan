<?php
//https://api.sendpulse.com/oauth/access_token?grant_type=client_credentials&client_id=17db26a344e115b856fdabc228edd775&client_secret=783ee380c370d6c1130dd38aa45084d6

$params = [
	'grant_type' => 'client_credentials',
	'client_id' => '17db26a344e115b856fdabc228edd775',
	'client_secret' => '783ee380c370d6c1130dd38aa45084d6'
];

$myCurl = curl_init();
curl_setopt_array($myCurl, array(
    CURLOPT_URL => 'https://api.sendpulse.com/oauth/access_token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(array($params))
));
$response = curl_exec($myCurl);
curl_close($myCurl);

echo "Ответ на Ваш запрос: ".$response;
?>