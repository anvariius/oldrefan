<?php
//https://api.sendpulse.com/oauth/access_token?grant_type=client_credentials&client_id=17db26a344e115b856fdabc228edd775&client_secret=783ee380c370d6c1130dd38aa45084d6
$token = '6qzj1f8hij9fyrf1fgtwb85bjdxkarkwdqehx3wo';
$email = 'anvar8ku@mail.ru';
$params = [
	'format' => 'json',
	'api_key' => $token,
	'email' => $email,
	'sender_name' => 'refanparfum',
	'sender_email' => 'anvar8ku@gmail.com',
	'subject' => 'Новая распродажа',
	'body' => 'HELLO WORLD!!!',
	'list_id' => '19962860'
];

$get_params = http_build_query($params);
$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));
print_r($result);
?>